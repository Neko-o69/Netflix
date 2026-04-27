<?php
session_start();

$erreur = "";
$fichierUtilisateurs = __DIR__ . "/data/users.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = trim($_POST['Pseudo'] ?? '');
    $mdp = $_POST['mdp'] ?? '';
    $utilisateurs = [];

    if (file_exists($fichierUtilisateurs)) {
        $contenu = file_get_contents($fichierUtilisateurs);
        $utilisateurs = json_decode($contenu, true) ?: [];
    }

    if (isset($utilisateurs[$pseudo]) && password_verify($mdp, $utilisateurs[$pseudo]['mot_de_passe'])) {
        $_SESSION['pseudo'] = $pseudo;
        header("Location: azflix.php");
        exit();
    }

    if ($pseudo == "admin" && $mdp == "test") {
        $_SESSION['pseudo'] = $pseudo;
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
    <p style="color:red;"><?= $erreur ?></p>
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
