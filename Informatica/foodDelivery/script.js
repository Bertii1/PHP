
function valida() {
    const inputs = document.querySelectorAll("input");
    for (let input of inputs) {
        if (!input.validity.valid) {
            alert("Errore nel campo: " + input.id);
            return false;
        }
    }
    alert("Tutti i dati sono validi!");
    return true;
}

document.getElementById("btn").addEventListener("click", function(event) {
    valida();
}); 


function calcolaPrezzo(){
    const pasto = parseFloat(document.getElementById("pasto").value);
    const menu = parseFloat(document.getElementById("menu").value);
    let amici = parseInt(document.getElementById("amici").value);
    const prezzo1 = pasto;
    const prezzo2 = menu;
    let costoTotale = prezzo1 + prezzo2;
     if(amici != 0){
        costoTotale = costoTotale - 5 ;
    }

    document.getElementById("costoTotale").innerText = "Prezzo Totale: €" + costoTotale;

}

/*
   if (!input.checkValidity()) { */