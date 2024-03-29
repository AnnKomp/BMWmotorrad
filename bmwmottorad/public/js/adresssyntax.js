
var adresseInput = document.querySelector('#adresse')
var datalist = document.querySelector('#adress_list')
async function findAdress(){
    const addr = adresseInput.value.replace(" ", "%20");
    await fetch(`https://api-adresse.data.gouv.fr/search/?q=${addr}&type=housenumber&autocomplete=1`)
        .then((resp) => resp.json())
        .then((data) => {
            if (data.features.length > 0)
            {
                data.features.forEach((feature) => {
                    let option = document.createElement("option");
                    option.innerText = feature.properties["label"];
                    option.onclick = function() {
                        adresseInput.value = option.innerText;
                        datalist.innerHTML = "";
                    }
                    datalist.appendChild(option)
                })
            }
        });
}