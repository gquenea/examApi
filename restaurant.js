const contenu = document.querySelector(".content")

const boutonEnvoyer = document.querySelector("#envoyer")
const nom = document.querySelector("#nom");
const adresse = document.querySelector("#adresse");
const ville = document.querySelector("#ville");

boutonEnvoyer.addEventListener("click", () => {
    send(nom.value, adresse.value, ville.value);
});

function displayAll() {
    let url = "http://localhost/baseFramework/?type=restaurant&action=index";
    contenu.innerHTML = "";
    fetch(url)
        .then((reponse) => reponse.json())
        .then((restaurants) => {
            console.log(restaurants);
            restaurants.forEach((restaurant) => {
                templateRestaurant = `
                <div>
                    <hr>
                        <h2>Restaurant : ${restaurant.nom}</h2>
                        <p><strong>${restaurant.adresse}</strong></p>
                        <p><strong>${restaurant.ville}</strong></p>
                        ${displayPlats(restaurant.plats)}
                        <button id="${restaurant.id}" class="btn btn-danger boutonSuppr"><strong>X</strong></button>
                    <hr>
                </div>
                
            `;
                contenu.innerHTML += templateRestaurant;
            });
            const boutonSuppr = document.querySelectorAll(".boutonSuppr")
            boutonSuppr.forEach(bouton => {bouton.addEventListener("click", () => {
                supprimer(bouton.id)
            })} )
        });
}


function send(nom, adresse, ville) {
    let url = "http://localhost/baseFramework/?type=restaurant&action=new";

    let bodyRequete = {
        nom: nom,
        adresse: adresse,
        ville: ville
    };
    let requete = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(bodyRequete),
    };
    fetch(url, requete)
        .then((reponse) => reponse.json())
        .then((donnees) => {
            console.log(donnees);
            displayAll();
            document.querySelector("#nom").value = "";
            document.querySelector("#adresse").value = "";
            document.querySelector("#ville").value = "";
        });
}

function supprimer(id){

    let url = "http://localhost/baseFramework/?type=restaurant&action=suppr"

    let bodyRequete = {
        id:id
    }
    let requete = {
        method: "DELETE",
        headers : {
            "Content-Type" : "application/json"
        },
        body : JSON.stringify(bodyRequete)
    }
    fetch(url, requete)
        .then(reponse=>reponse.json()).then(donnees => {
        console.log(donnees)
        displayAll()
    })
}


function displayPlats(plats) {
    let allPlats = "";

    plats.forEach(plat=>{
        let templatePlat = `
            <p>${plat.description}</p>
            <p>${plat.prix}</p>

        `;
        allPlats += templatePlat
    })

    return allPlats;
}

displayAll()