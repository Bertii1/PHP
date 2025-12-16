let comuni = [];
const regioni = [];

let selectRegioni, selectProvincie, selectComuni;

document.addEventListener("DOMContentLoaded", INIT);

async function INIT() {
  selectRegioni = document.getElementById("selectRegioni");
  selectProvincie = document.getElementById("selectProvincie");
  selectComuni = document.getElementById("selectComuni");


  try {
    const resp = await fetch("regioni.php");
    if (!resp.ok) {
      console.error("richiesta fallita", resp.status);
    } else {
      comuni = await resp.json();
    }
  } catch (err) {
    console.error("fetch error", err);
  }

  formatData();

  clearSelect(selectRegioni, "Seleziona la regione");
  regioni.forEach((regione) => {
    const optRegione = new Option(regione.nome, regione.codice);
    selectRegioni.appendChild(optRegione);
  });

  selectProvincie.hidden = true;
  selectComuni.hidden = true;

  selectRegioni.addEventListener("change", updateProvincieSelects);
  selectProvincie.addEventListener("change", updateComuniSelects);
  selectComuni.addEventListener("change", loadComuneData);
}

function clearSelect(sel, placeholderText) {
  sel.innerHTML = "";
  const ph = document.createElement("option");
  ph.value = "";
  ph.textContent = placeholderText;
  sel.appendChild(ph);
}

function updateProvincieSelects() {
  const codiceRegione = selectRegioni.value;
  clearSelect(selectProvincie, "Seleziona la provincia");
  clearSelect(selectComuni, "Seleziona il comune");
  selectComuni.hidden = true;

  if (!codiceRegione) {
    selectProvincie.hidden = true;
    return;
  }

  const regione = regioni.find((r) => r.codice === codiceRegione);
  if (!regione || !regione.provincie) {
    selectProvincie.hidden = true;
    return;
  }

  regione.provincie.forEach((provincia) => {
    const optProvincia = new Option(provincia.nome, provincia.codice);
    selectProvincie.appendChild(optProvincia);
  });

  selectProvincie.hidden = false;
}

function updateComuniSelects() {
  const codiceProvincia = selectProvincie.value;
  clearSelect(selectComuni, "Seleziona il comune");

  if (!codiceProvincia) {
    selectComuni.hidden = true;
    return;
  }

  let provinciaFound = null;
  for (const r of regioni) {
    provinciaFound = r.provincie.find((p) => p.codice === codiceProvincia);
    if (provinciaFound) break;
  }

  if (!provinciaFound || !provinciaFound.comuni) {
    selectComuni.hidden = true;
    return;
  }

  provinciaFound.comuni.forEach((c) => {
    const optComune = new Option(c.nome, c.codice);
    selectComuni.appendChild(optComune);
  });

  selectComuni.hidden = false;
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