function load_lista() {
  const numero_partecipanti = document.getElementById("numero_partecipanti").value
  document.getElementById("numero_partecipanti").disabled = true
  const div_partecipanti = document.getElementById("lista_partecipanti")
  for (let i = 0; i < numero_partecipanti; i++) {
    div_partecipanti.appendChild(buildPartecipanteCard(i))
  }

  document.getElementById("salva_button").disabled = false

  function buildPartecipanteCard(i) {
    const div_partecipante = document.createElement("div")
    const label_nome = document.createElement("label")
    label_nome.setAttribute("for", "name" + i)
    label_nome.textContent = "Nome:"
    div_partecipante.appendChild(label_nome)

    const nome_input = document.createElement("input")
    nome_input.type = "text"
    nome_input.id = "name" + i
    nome_input.placeholder = "nome"
    nome_input.required = true
    div_partecipante.appendChild(nome_input)

    const label_cognome = document.createElement("label")
    label_cognome.setAttribute("for", "surname" + i)
    label_cognome.textContent = "Cognome:"
    div_partecipante.appendChild(label_cognome)

    const cognome_input = document.createElement("input")
    cognome_input.type = "text"
    cognome_input.id = "surname" + i
    cognome_input.placeholder = "cognome"
    cognome_input.required = true
    div_partecipante.appendChild(cognome_input)
    return div_partecipante
  }

}

function salva() {
  var nome_convegno = document.getElementById("nome_convegno").value
  var numero_partecipanti = document.getElementById("numero_partecipanti").value
  var partecipanti = document.getElementById("lista_partecipanti").childNodes
  var convegno_data = {
    "nome_convegno": nome_convegno,
    "numero_partecipanti": numero_partecipanti,
    "partecipanti": []
  }

  partecipanti.forEach(partecipante => {
    var pobj = {
      "nome": null,
      "cognome": null,
    }
    let c = 0
    partecipante.childNodes.forEach(elmnt => {
      if (elmnt.tagName === "INPUT") {
        if (c === 0) {
          pobj.nome = elmnt.value
        } else {
          pobj.cognome = elmnt.value
        }
        c++
      }
    })
    convegno_data.partecipanti.push(pobj)
  })
  console.log(convegno_data)
  SendData()




  function SendData(){
    fetch("./salva.php",{
      method : "POST",
      body : JSON.stringify(convegno_data)
    })

  }
}