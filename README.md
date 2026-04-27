# AZFLIX

Projet PHP/JavaScript inspire d'une plateforme de streaming.

## Lancer le site

Depuis le dossier du projet :

```bash
php -S 0.0.0.0:8002
```

Puis ouvrir :

```text
http://IP_DE_LA_VM:8002/azflix.php
```

## Base de donnees

Importer le fichier SQL :

```bash
mysql -u user -p < sql/azflix.sql
```

Copier ensuite le fichier de configuration exemple :

```bash
cp config/database.example.php config/database.php
```

Puis modifier `config/database.php` avec vos identifiants MySQL.

## Connexion test

La page de connexion contient encore un compte de test :

```text
Identifiant : admin
Mot de passe : test
```
