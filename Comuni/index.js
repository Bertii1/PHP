let regioni = [];
let provincie = []
let comuni = [];


let selectRegioni, selectProvincie, selectComuni;

document.addEventListener("DOMContentLoaded", INIT);

async function INIT() {
  selectRegioni = document.getElementById("selectRegioni");
  selectProvincie = document.getElementById("selectProvincie");
  selectComuni = document.getElementById("selectComuni");

  regioni = await fetchfile("regioni")
  provincie = await fetchfile("province")
  comuni = await fetchfile("comuni")
  
  clearSelect(selectRegioni, "Seleziona la regione");
  regioni.forEach((regione) => {
    const optRegione = new Option(regione.nome, regione.nome);
    selectRegioni.appendChild(optRegione);
  });

  selectProvincie.hidden = true;
  selectComuni.hidden = true;

  selectRegioni.addEventListener("change", updateProvincieSelects);
  selectProvincie.addEventListener("change", updateComuniSelects);
}

function clearSelect(sel, placeholderText) {
  sel.innerHTML = "";
  const ph = document.createElement("option");
  ph.value = "";
  ph.textContent = placeholderText;
  sel.appendChild(ph);
}

function updateProvincieSelects() {
  const nomeRegione = selectRegioni.value;
  clearSelect(selectProvincie, "Seleziona la provincia");
  clearSelect(selectComuni, "Seleziona il comune");
  selectComuni.hidden = true;

  if (!nomeRegione) {
    selectProvincie.hidden = true;
    return;
  }

  provincie.forEach(p =>{
    if (p.regione === nomeRegione){
      selectProvincie.appendChild(new Option(p.nome,p.codice))
    }
  })

  selectProvincie.hidden = false;
}

function updateComuniSelects() {
  const codiceProvincia = selectProvincie.value;
  clearSelect(selectComuni, "Seleziona il comune");

  if (!codiceProvincia) {
    selectComuni.hidden = true;
    return;
  }

  comuni.forEach(c =>{
    if(c.provincia.codice === codiceProvincia){
      const optComune = new Option(c.nome, c.codice);
      selectComuni.appendChild(optComune);
    }

  })
  selectComuni.hidden = false;
}

function loadComuneData() {
  // carica i dati del comune selezionato e li inserisce come campi hidden nel form
  const codiceComune = selectComuni.value;
  const form = document.getElementById("registrationForm");

  // rimuove eventuali campi comuni precedenti
  if (form) removeHiddenComuneInputs(form);

  if (!codiceComune) return;

  // prova a trovare il comune nell'array piatto `comuni`
  let comuneObj = comuni.find((c) => c.codice === codiceComune);

  // se non lo trovi, prova a cercare nella struttura `regioni` -> `provincie` -> `comuni`
  if (!comuneObj) {
    for (const r of regioni) {
      for (const p of r.provincie || []) {
        const found = (p.comuni || []).find((cc) => cc.codice === codiceComune);
        if (found) {
          // arricchisci l'oggetto con provincia/regioni, se possibile
          comuneObj = Object.assign({}, found);
          comuneObj.provincia = p;
          comuneObj.regione = r;
          break;
        }
      }
      if (comuneObj) break;
    }
  }

  if (!comuneObj) {
    console.warn("Comune non trovato:", codiceComune);
    return;
  }

  // helper per normalizzare valori
  const val = (v) => (v === undefined || v === null ? "" : v);

  if (form) {
    // dettagli specifici del comune
    createOrUpdateHidden(form, "comune_codice", val(comuneObj.codice));
    createOrUpdateHidden(form, "comune_nome", val(comuneObj.nome));
    createOrUpdateHidden(
      form,
      "comune_cap",
      Array.isArray(comuneObj.cap) ? comuneObj.cap.join(",") : val(comuneObj.cap)
    );
    createOrUpdateHidden(form, "comune_codiceCatastale", val(comuneObj.codiceCatastale));
    createOrUpdateHidden(form, "comune_popolazione", val(comuneObj.popolazione));
    createOrUpdateHidden(form, "comune_provincia", (comuneObj.provincia && comuneObj.provincia.nome) || val(comuneObj.sigla));
    createOrUpdateHidden(form, "comune_regione", (comuneObj.regione && comuneObj.regione.nome) || "");

    // campi con i nomi attesi dal backend
    createOrUpdateHidden(form, "regione", (comuneObj.regione && comuneObj.regione.nome) || "");
    createOrUpdateHidden(form, "provincia", (comuneObj.provincia && comuneObj.provincia.nome) || ((comuneObj.sigla) ? comuneObj.sigla : ""));
    createOrUpdateHidden(form, "comune", val(comuneObj.nome));
  }

  // salva una copia veloce nel dataset dell'elemento select
  selectComuni.dataset.selectedComune = JSON.stringify({ codice: comuneObj.codice, nome: comuneObj.nome });

  console.log("Comune caricato:", comuneObj.nome);
}

function createOrUpdateHidden(form, name, value) {
  let input = form.querySelector(`input[name="${name}"]`);
  if (!input) {
    input = document.createElement("input");
    input.type = "hidden";
    input.name = name;
    form.appendChild(input);
  }
  input.value = value;
}

function removeHiddenComuneInputs(form) {
  const inputs = Array.from(form.querySelectorAll("input")).filter(Boolean);
  inputs.forEach((i) => {
    if (i.name && (i.name.startsWith("comune_") || ["regione", "provincia", "comune"].includes(i.name))) {
      i.remove();
    }
  });
}

function formatData() {  
  const codiciRegioni = new Set();
  const codiciProvincie = new Set();
  const codiciComuni = new Set();

  comuni.forEach((comune) => {
    const codiceRegione = comune.regione.codice;

    const datiRegione = {
      codice: codiceRegione,
      nome: comune.regione.nome,
      provincie: [],
    };

    if (!codiciRegioni.has(codiceRegione)) {
      codiciRegioni.add(codiceRegione);
      regioni.push(datiRegione);
    }
  });

  comuni.forEach((comune) => {
    const codiceProvincia = comune.provincia.codice;

    const datiProvincia = {
      codice: comune.provincia.codice,
      nome: comune.provincia.nome,
      sigla: (comune.provincia && comune.provincia.sigla) || comune.sigla || "",
      comuni: [],
    };

    if (!codiciProvincie.has(codiceProvincia)) {
      codiciProvincie.add(codiceProvincia);
      regioni.forEach((regione) => {
        if (regione.codice === comune.regione.codice) {
          regione.provincie.push(datiProvincia);
        }
      });
    }
  });

  comuni.forEach((comune) => {
    const codiceComune = comune.codice;

    const datiComune = {
      codice: comune.codice,
      nome: comune.nome,
      codiceCatastale: comune.codiceCatastale,
      cap: comune.cap,
      popolazione: comune.popolazione,
    };

    if (!codiciComuni.has(codiceComune)) {
      codiciComuni.add(codiceComune);
      regioni.forEach((regione) => {
        regione.provincie.forEach((provincia) => {
          if (provincia.codice === comune.provincia.codice) {
            provincia.comuni.push(datiComune);
          }
        });
      });
    }
  });

  console.log(regioni)
}

async function fetchfile(file){
    try {
    const resp = await fetch("./Routes/Files.php?file="+file)
    if (!resp.ok) {
      console.error("richiesta fallita", resp.status);
    } else {
      return JSON.parse(await resp.json())
    }
  } catch (err) {
    console.error("fetch error", err);
  }
}