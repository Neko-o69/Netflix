<?php
$dossierSessions = __DIR__ . "/data/sessions";
if (!is_dir($dossierSessions)) {
    mkdir($dossierSessions, 0775, true);
}
session_save_path($dossierSessions);
session_start();

$erreur = "";
require __DIR__ . "/config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") { // ça verifie si 
    $pseudo = trim($_POST['Pseudo'] ?? '');
    $mdp = $_POST['mdp'] ?? '';

    if ($pseudo == "admin" && $mdp == "test") {
        $_SESSION['pseudo'] = $pseudo;
        header("Location: azflix.php");
        exit();
    }

    $requete = $pdo->prepare("SELECT pseudo, mot_de_passe FROM utilisateurs WHERE pseudo = ?");
    $requete->execute([$pseudo]);
    $utilisateur = $requete->fetch();

    if ($utilisateur && password_verify($mdp, $utilisateur['mot_de_passe'])) {
        $_SESSION['pseudo'] = $utilisateur['pseudo'];
        header("Location: azflix.php");
        exit();
    }

    $erreur = "Identifiants incorrects";
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Connexion</title>
    <link rel="stylesheet" href="connexion.css">
</head>

<body>

<div class="background-animation"></div>



<?php if (!empty($erreur)) : ?>
    <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post" action="">

<div class="Formulaire">

    <h2 class="typing-effect">Formulaire de Connexion</h2>

    <div id="f1">
        <label class="form__label">Identifiant :</label>
        <input type="text" class="form__field" name="Pseudo" required />
    </div>

    <br>

    <div id="f2">
        <label class="form__label">Mot de passe :</label>
        <input type="password" class="form__field" name="mdp" required />
    </div> 

    <a href="mdpOublie.html" class="button">Mot de passe oublié</a>
    <a href="s'inscrire.php" class="button">S'inscrire</a>
    
    <div id="bouton">
        <button type="reset" class="button">Effacer</button>
        <button type="submit" class="button">Valider</button>
    </div>

</div>
</form>

<footer>
    <p>© 2024 azflix. Tous droits réservés.</p>
</footer>

</body>
</html>
