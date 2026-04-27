<?php
$dossierSessions = __DIR__ . "/data/sessions"; // ça crée le chemin du dossier pour les sessions.
if (!is_dir($dossierSessions)) { // si le dossier n'existe pas.
    mkdir($dossierSessions, 0775, true); // PHP crée le dossier.
}
session_save_path($dossierSessions); // ça dit où stocker les sessions.
session_start(); // ça démarre la session.

$erreur = ""; // variable pour afficher une erreur.
$reussi = ""; // variable pour afficher un message de réussite.
require __DIR__ . "/config/database.php"; // ça connecte la page à la base de données.

if (($_SERVER["REQUEST_METHOD"] ?? "GET") == "POST") { // si le formulaire est envoyé.
    $pseudo = trim($_POST['Pseudo'] ?? ''); // récupère le pseudo et enlève les espaces.
    $motDePasse = $_POST['mdp'] ?? ''; // récupère le mot de passe.
    $nom = trim($_POST['nom'] ?? ''); // récupère le nom.
    $prenom = trim($_POST['prenom'] ?? ''); // récupère le prénom.
    $date_naissance = $_POST['date_naissance'] ?? ''; // récupère la date de naissance.
    $email = trim($_POST['email'] ?? ''); // récupère l'email.
    $sexe = trim($_POST['sexe'] ?? ''); // récupère le sexe choisi.

    if ( // vérifie que tous les champs sont remplis.
        !empty($pseudo) &&
        !empty($motDePasse) &&
        !empty($nom) &&
        !empty($prenom) &&
        !empty($date_naissance) &&
        !empty($email) &&
        !empty($sexe)
    ) {
        $verification = $pdo->prepare("SELECT id FROM utilisateurs WHERE pseudo = ? OR email = ?"); // prépare la recherche d'un compte déjà existant.
        $verification->execute([$pseudo, $email]); // lance la recherche avec le pseudo et l'email.

        if ($verification->fetch()) { // si un compte existe déjà.
            $erreur = "Ce nom d'utilisateur existe deja."; // message d'erreur.
        } else { // sinon on peut créer le compte.
            $ajout = $pdo->prepare( // prépare l'ajout dans la base de données.
                "INSERT INTO utilisateurs (pseudo, mot_de_passe, nom, prenom, date_naissance, email, sexe)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $ajout->execute([ // ajoute l'utilisateur dans la base.
                $pseudo,
                password_hash($motDePasse, PASSWORD_DEFAULT), // protège le mot de passe.
                $nom,
                $prenom,
                $date_naissance,
                $email,
                $sexe
            ]);

            $_SESSION['pseudo'] = $pseudo; // garde le pseudo en session.
            header("Location: azflix.php"); // redirige vers la page AZFLIX.
            exit(); // arrête le script après la redirection.
        }
    } else { // si un champ est vide.
        $erreur = "Veuillez remplir tous les champs."; // message d'erreur.
    }
}
?>

<!DOCTYPE html> <!-- ça dit que la page est en HTML. -->
<html lang="fr"> <!-- la page est en français. -->
<head> <!-- informations de la page. -->
    <meta charset="UTF-8"> <!-- ça permet les accents. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ça adapte la page au téléphone. -->
    <title>Inscription</title> <!-- titre de l'onglet. -->
    <link rel="stylesheet" href="inscription.css"/> <!-- ça relie le CSS. -->
</head>
<body> <!-- début de la page visible. -->

<div class="background-couleur"></div> <!-- fond de couleur. -->

<h1>Information d'inscription</h1> <!-- grand titre. -->
<h2>Entrez vos informations</h2> <!-- sous-titre. -->

<?php if (!empty($erreur)) : ?> <!-- si il y a une erreur. -->
    <p style="color:red;"><?= htmlspecialchars($erreur) ?></p> <!-- affiche l'erreur en rouge sans danger. -->
<?php endif; ?> <!-- fin de la condition erreur. -->

<?php if (!empty($reussi)) : ?> <!-- si il y a un message de réussite. -->
    <p style="color:green;"><?= htmlspecialchars($reussi) ?></p> <!-- affiche le message en vert sans danger. -->
<?php endif; ?> <!-- fin de la condition réussite. -->

<form action="" method="post"> <!-- formulaire envoyé sur la même page. -->
    <div class="Formulaire"> <!-- bloc du formulaire. -->
        <input class="inputVerif" type="text" placeholder="Saisir un nom d'utilisateur" name="Pseudo" required> <!-- champ du pseudo. -->
        <br><br> <!-- espace entre les champs. -->

        <input class="inputVerif" type="password" placeholder="Saisir un mot de passe" name="mdp" required> <!-- champ du mot de passe. -->
        <br><br> <!-- espace entre les champs. -->

        <input class="inputVerif" type="text" placeholder="Votre nom" name="nom" required> <!-- champ du nom. -->
        <br><br> <!-- espace entre les champs. -->

        <input class="inputVerif" type="text" placeholder="Votre prénom" name="prenom" required> <!-- champ du prénom. -->
        <br><br> <!-- espace entre les champs. -->

        <label for="date_naissance">Date de naissance :</label> <!-- texte pour la date. -->
        <input class="inputVerif" type="date" name="date_naissance" id="date_naissance" required> <!-- champ de date de naissance. -->
        <br><br> <!-- espace entre les champs. -->

        <label for="email">Entrer votre mail :</label> <!-- texte pour l'email. -->
        <input class="inputVerif" type="email" id="email" name="email" size="30" required> <!-- champ de l'email. -->
        <br><br> <!-- espace entre les champs. -->

        <p>Choisir un sexe :</p> <!-- texte pour choisir le sexe. -->
        <p> <!-- bloc des boutons radio. -->
            Homme: <input class="inputVerif" type="radio" name="sexe" value="Homme" required><br> <!-- choix homme. -->
            Femme: <input class="inputVerif" type="radio" name="sexe" value="Femme"><br> <!-- choix femme. -->
            Indéterminé: <input class="inputVerif" type="radio" name="sexe" value="Indetermine"> <!-- choix indéterminé. -->
        </p>

        <button type="submit">Valider</button> <!-- bouton pour envoyer. -->
        <button type="reset">Effacer</button> <!-- bouton pour vider le formulaire. -->
    </div>
</form>

<script src="Inscription.js"></script> <!-- ça relie le JavaScript. -->
</body>
</html>
