let maForm = document.querySelector("form"); // ça récupère le formulaire.
let tInput = document.querySelectorAll(".inputVerif") // ça récupère tous les champs à vérifier.

maForm.addEventListener("submit", verificationForm); // quand on envoie le formulaire, ça lance la vérification.
function verificationForm(e) { // fonction qui vérifie le formulaire.
    let taille = tInput.length; // ça garde le nombre de champs.
    console.log(tInput); // ça affiche les champs dans la console.
    for (let i=0; i < tInput.length; i++){ // boucle sur tous les champs.

        if (tInput[i].value == "" || tInput[i].value == null) { // si un champ est vide.
            console.log("saisie invalide"+i); // affiche quel champ est invalide.
            e.preventDefault(); // bloque l'envoi du formulaire.
            return; // arrête la fonction.
        }
    }

    let emailInput = document.querySelector("#email"); // récupère le champ email.
    let emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // règle pour vérifier l'email.
    if (!emailRegex.test(emailInput.value)) { // si l'email ne respecte pas la règle.
        console.log("Email invalide."); // affiche que l'email est invalide.
        e.preventDefault(); // bloque l'envoi du formulaire.
    }
}
