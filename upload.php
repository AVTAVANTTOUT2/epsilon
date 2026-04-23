<?php
// On définit le dossier de destination
$dossierUploads = __DIR__ . '/uploads';

// On définit la taille maximale autorisée
$tailleMax = 2 * 1024 * 1024;

// On définit les extensions et types MIME autorisés
$mimesAutorises = [
	'jpg'  => 'image/jpeg',
	'jpeg' => 'image/jpeg',
	'png'  => 'image/png',
	'gif'  => 'image/gif',
	'webp' => 'image/webp',
	'pdf'  => 'application/pdf',
];

// On renvoie l'utilisateur vers index.php avec un message
function rediriger($message, $raison = '') {
	$url = 'index.php?msg=' . urlencode($message);
	if ($raison !== '') $url .= '&raison=' . urlencode($raison);
	header('Location: ' . $url);
	exit;
}

// On vérifie que la requête est bien un POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') rediriger('erreur', 'methode_interdite');

// On vérifie qu'un fichier a été envoyé
if (!isset($_FILES['fichier'])) rediriger('erreur', 'fichier_manquant');

// On récupère le fichier envoyé
$fichier = $_FILES['fichier'];

// On vérifie qu'il n'y a pas eu d'erreur pendant l'upload
if ($fichier['error'] !== UPLOAD_ERR_OK)     rediriger('erreur', 'erreur_upload');
if (!is_uploaded_file($fichier['tmp_name'])) rediriger('erreur', 'upload_invalide');

// On vérifie la taille du fichier
if ($fichier['size'] > $tailleMax) rediriger('erreur', 'trop_gros');

// On récupère l'extension du fichier
$extension = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

// On vérifie que l'extension est autorisée
if (!isset($mimesAutorises[$extension])) rediriger('erreur', 'extension_interdite');

// On vérifie que le type MIME réel correspond à l'extension
$mimeReel = mime_content_type($fichier['tmp_name']);
if ($mimeReel !== $mimesAutorises[$extension]) rediriger('erreur', 'mime_interdit');

// On génère un nom unique pour le fichier
$nouveauNom = uniqid('f_', true) . '.' . $extension;
$destination = $dossierUploads . '/' . $nouveauNom;

// On déplace le fichier dans le dossier uploads
if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
	rediriger('erreur', 'depot_echec');
}

// On redirige vers la page d'accueil avec le message de succès
rediriger('ok');
