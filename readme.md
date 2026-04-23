# Epsilon

Petit projet PHP d'upload d'images et de PDF.

## Workflow

1. L'utilisateur sélectionne un fichier sur `index.php` et soumet le formulaire.
2. `upload.php` reçoit la requête POST et effectue les vérifications :
   - méthode HTTP, présence du fichier, erreurs d'upload
   - taille max (2 Mo)
   - extension autorisée (`jpg`, `jpeg`, `png`, `gif`, `webp`, `pdf`)
   - correspondance entre extension et type MIME réel
3. Le fichier est renommé de façon unique puis déplacé dans `uploads/`.
4. Une redirection vers `index.php` affiche le message de succès ou d'erreur.
5. `index.php` liste les fichiers déjà présents dans `uploads/`.

## Fonctions PHP notables

- `is_uploaded_file()` : vérifie que le fichier provient bien d'un upload HTTP.
- `move_uploaded_file()` : déplace le fichier temporaire vers sa destination finale.
- `mime_content_type()` : détecte le type MIME réel pour éviter les extensions falsifiées.
- `pathinfo()` : extrait l'extension du nom de fichier.
- `uniqid()` : génère un nom unique et évite les collisions.
- `urlencode()` / `header('Location: ...')` : redirection avec paramètres de message.

## Structure

```
index.php      Formulaire et liste des fichiers
upload.php     Traitement et validation
header.php     En-tête commun
style.css      Styles
uploads/       Fichiers uploadés (ignoré par git)
```

## Utilisation

Placer le dossier dans `htdocs` de MAMP, puis accéder à `http://localhost/uploadEPSILON`.
