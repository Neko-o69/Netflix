<?php
$dossierSessions = __DIR__ . "/data/sessions"; // ça crée le chemin vers le dossier où PHP va stocker les sessions.
if (!is_dir($dossierSessions)) { // si le dossier n'existe pas encore.
    mkdir($dossierSessions, 0775, true); // PHP crée le dossier data/sessions.
}
session_save_path($dossierSessions); // ça dit à PHP où enregistrer les sessions.
session_start(); // ça démarre la session.

$pseudo = $_SESSION['pseudo'] ?? ''; // ça récupère le pseudo connecté, sinon ça met vide.

$topFilms = [ // ici je range les films du top 10.
    ['titre' => 'My Secret Santa', 'image' => 'MySecretSanta.jpg', 'rang' => 1], 
    ['titre' => 'Jingle Bell Heist', 'image' => 'JingleBellHeist.webp', 'rang' => 2], 
    ['titre' => 'Toy Story 5', 'image' => 'ToyStory5.jpg', 'rang' => 3], 
    ['titre' => 'Tron', 'image' => 'Tron.jpg', 'rang' => 4], 
    ['titre' => 'Captain America', 'image' => 'CaptainAmerica.jpg', 'rang' => 5], 
    ['titre' => 'Scream 7', 'image' => 'Scream7.jpg', 'rang' => 6], 
    ['titre' => 'SuperMan', 'image' => 'SuperMan.jpg', 'rang' => 7], 
    ['titre' => 'Bob', 'image' => 'bob.jpg', 'rang' => 8], 
    ['titre' => 'FNF', 'image' => 'FNF.jpg', 'rang' => 9], 
    ['titre' => 'Stitch', 'image' => 'Stitch.jpg', 'rang' => 10], 
];

$nouveautes = [ // ici je range les nouveaux films.
    ['titre' => 'Stitch', 'image' => 'Stitch.jpg'], 
    ['titre' => 'SuperMan', 'image' => 'SuperMan.jpg'], 
    ['titre' => 'Scream 7', 'image' => 'Scream7.jpg'], 
    ['titre' => 'Toy Story 5', 'image' => 'ToyStory5.jpg'], 
    ['titre' => 'Captain America', 'image' => 'CaptainAmerica.jpg'], 
    ['titre' => 'Tron', 'image' => 'Tron.jpg'], 
    ['titre' => 'My Secret Santa', 'image' => 'MySecretSanta.jpg'], 
    ['titre' => 'Jingle Bell Heist', 'image' => 'JingleBellHeist.webp'], 
    ['titre' => 'FNF', 'image' => 'FNF.jpg'], 
    ['titre' => 'Bob', 'image' => 'bob.jpg'], 
];
?>

<!DOCTYPE html> 
<html lang="fr"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>AZFLIX</title> 
    <link rel="stylesheet" href="AZFLIX.css"> 
</head>
<body> 
    <header class="haut"> 
        <div class="haut-gauche"> 
            <a href="azflix.php" class="logo">AZFLIX</a> 
        </div>

        <nav class="menu" aria-label="Menu principal"> 
            <a href="#top10">Top 10</a> 
            <a href="#nouveautes">Nouveautés</a> 
            <a href="#selection">Ma liste</a> 
        </nav>

        <form class="haut-centre" role="search"> 
            <input id="searchInput" type="search" placeholder="Rechercher un film, une série..." aria-label="Rechercher un film ou une série"> 
            <button type="submit">Rechercher</button> 
        </form>

        <div class="profil"> 
            <?php if ($pseudo) : ?> //si un utilisateur est connecté.
                <span>Bonjour <?= htmlspecialchars($pseudo) ?></span> //ça dit bonjour et ça affiche son pseudo 
            <?php else : ?> //sinon il n'est pas connecté.
                <a href="connexion.php">Connexion</a> 
            <?php endif; ?> 
        </div>
    </header>

    <main> 
        <section class="hero" id="selection"> 
            <div class="hero-contenu"> 
                <p class="categorie">Films, séries et exclusivités</p> 
                <h1>Bienvenue sur AZFLIX</h1> 
                <div class="boutons-hero"> 
                    <a href="#top10" class="btn btn-rouge">Regarder</a> 
                    <a href="#nouveautes" class="btn btn-sombre">Plus d'infos</a> 
                </div>
            </div>
        </section>

        <section class="section-films" id="top10"> 
            <div class="entete-section"> 
                <h2 class="titre">TOP 10 FILMS 2025</h2> 
            </div>

            <div class="carousel"> <!-- carrousel des films. -->
                <button class="avant" type="button" aria-label="Films précédents">‹</button> <!-- bouton pour aller à gauche. -->
                <div class="fenetre-carousel"> 
                    <div class="derouler"> 
                        <?php foreach ($topFilms as $film) : ?> 
                            <article class="tourner film-card" data-title="<?= htmlspecialchars(strtolower($film['titre'])) ?>"> <!-- carte d'un film. -->
                                <span class="rang"><?= $film['rang'] ?></span> <!-- affiche le rang du film. -->
                                <img src="<?= htmlspecialchars($film['image']) ?>" alt="Affiche du film <?= htmlspecialchars($film['titre']) ?>"> <!-- affiche l'image du film. -->
                                <h3><?= htmlspecialchars($film['titre']) ?></h3> <!-- affiche le titre du film. -->
                            </article>
                        <?php endforeach; ?> 
                    </div>
                </div>
                <button class="suivant" type="button" aria-label="Films suivants">›</button> <!-- bouton pour aller à droite. -->
            </div>
        </section>

        <section class="message"> 
            <h2>Bienvenue dans notre sélection des meilleurs films</h2> <!-- titre du message. -->
            <p class="texte"> 
                Choisis un film, fais défiler les affiches et utilise la barre de recherche pour retrouver rapidement un titre.
            </p>
        </section>

        <section class="section-films" id="nouveautes"> 
            <div class="entete-section"> 
                <h2 class="titre">Nouveautés sur AZFLIX</h2> 
            </div>

            <div class="carousel"> <!-- carrousel des nouveautés. -->
                <button class="avant" type="button" aria-label="Nouveautés précédentes">‹</button> 
                <div class="fenetre-carousel"> 
                    <div class="derouler"> 
                        <?php foreach ($nouveautes as $film) : ?> 
                            <article class="tourner film-card" data-title="<?= htmlspecialchars(strtolower($film['titre'])) ?>"> <!-- carte d'un film. -->
                                <img src="<?= htmlspecialchars($film['image']) ?>" alt="Affiche du film <?= htmlspecialchars($film['titre']) ?>"> <!-- affiche l'image du film. -->
                                <h3><?= htmlspecialchars($film['titre']) ?></h3> <!-- affiche le titre du film. -->
                            </article>
                        <?php endforeach; ?> 
                    </div>
                </div>
                <button class="suivant" type="button" aria-label="Nouveautés suivantes">›</button> 
            </div>
        </section>
    </main>

    <footer> 
        <p>© 2026 AZFLIX. Tous droits réservés.</p> 
    </footer>

    <script src="AZFLIX.js"></script> 
</body>
</html>
