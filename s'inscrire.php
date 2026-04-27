<?php
$dossierSessions = __DIR__ . "/data/sessions"; // ça crée le chemin du dossier pour les sessions.
if (!is_dir($dossierSessions)) { // si le dossier n'existe pas.
    mkdir($dossierSessions, 0775, true); // PHP crée le dossier.
}
session_save_path($dossierSessions); // ça dit où stocker les sessions.
session_start(); // ça démarre la session.

$erreur = ""; 
$reussi = ""; 
require __DIR__ . "/config/database.php"; // ça connecte la page à la base de données.

if (($_SERVER["REQUEST_METHOD"] ?? "GET") == "POST") { 
    $pseudo = trim($_POST['Pseudo'] ?? ''); 
    $motDePasse = $_POST['mdp'] ?? ''; 
    $nom = trim($_POST['nom'] ?? ''); 
    $prenom = trim($_POST['prenom'] ?? ''); 
    $date_naissance = $_POST['date_naissance'] ?? ''; 
    $email = trim($_POST['email'] ?? ''); 
    $sexe = trim($_POST['sexe'] ?? ''); 

    if ( 
        !empty($pseudo) &&
        !empty($motDePasse) &&
        !empty($nom) &&
        !empty($prenom) &&
        !empty($date_naissance) &&
        !empty($email) &&
        !empty($sexe)
    ) {
        $verification = $pdo->prepare("SELECT id FROM utilisateurs WHERE pseudo = ? OR email = ?"); // ça prépare la recherche d'un compte qui existe deja.
        $verification->execute([$pseudo, $email]); // ça lance la recherche avec le pseudo et l'email.

        if ($verification->fetch()) { // si un compte existe déjà.
            $erreur = "Ce nom d'utilisateur existe deja."; // ça affiche un message d'erreur.
        } else { // sinon on peut créer le compte.
            $ajout = $pdo->prepare( // ça prépare l'ajout dans la base de données.
                "INSERT INTO utilisateurs (pseudo, mot_de_passe, nom, prenom, date_naissance, email, sexe)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $ajout->execute([ // ça ajoute l'utilisateur dans la base.
                $pseudo,
                password_hash($motDePasse, PASSWORD_DEFAULT), 
                $nom,
                $prenom,
                $date_naissance,
                $email,
                $sexe
            ]);

            $_SESSION['pseudo'] = $pseudo; // ça garde le pseudo en session.
            header("Location: azflix.php"); 
            exit();
        }
    } else { // si un champ est vide.
        $erreur = "Veuillez remplir tous les champs."; // ça affiche un message d'erreur.
    }
}
?>

<!DOCTYPE html> 
<html lang="fr"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Inscription</title> 
    <link rel="stylesheet" href="inscription.css"/> 
<body> 

<div class="background-couleur"></div> 

<h1>Information d'inscription</h1> 
<h2>Entrez vos informations</h2> 

<?php if (!empty($erreur)) : ?> 
    <p style="color:red;"><?= htmlspecialchars($erreur) ?></p> 
<?php endif; ?> 

<?php if (!empty($reussi)) : ?> 
    <p style="color:green;"><?= htmlspecialchars($reussi) ?></p> 
<?php endif; ?> 

<form action="" method="post"> 
    <div class="Formulaire"> 
        <input class="inputVerif" type="text" placeholder="Saisir un nom d'utilisateur" name="Pseudo" required> 
        <br><br> 

        <input class="inputVerif" type="password" placeholder="Saisir un mot de passe" name="mdp" required> 
        <br><br> 

        <input class="inputVerif" type="text" placeholder="Votre nom" name="nom" required> 
        <br><br> 

        <input class="inputVerif" type="text" placeholder="Votre prénom" name="prenom" required> 
        <br><br> 

        <label for="date_naissance">Date de naissance :</label> 
        <input class="inputVerif" type="date" name="date_naissance" id="date_naissance" required> 
        <br><br> 

        <label for="email">Entrer votre mail :</label> 
        <input class="inputVerif" type="email" id="email" name="email" size="30" required> 
        <br><br> 

        <p>Choisir un sexe :</p> 
        <p> 
            Homme: <input class="inputVerif" type="radio" name="sexe" value="Homme" required><br> 
            Femme: <input class="inputVerif" type="radio" name="sexe" value="Femme"><br> 
            Indéterminé: <input class="inputVerif" type="radio" name="sexe" value="Indetermine"> 
        </p>

        <button type="submit">Valider</button> 
        <button type="reset">Effacer</button> 
    </div>
</form>

<script src="Inscription.js"></script> 
</body>
</html>
