<?php
// On définit le dossier des uploads
$dossierUploads = __DIR__ . '/uploads';

// On récupère les messages envoyés dans l'URL
$message = isset($_GET['msg'])    ? $_GET['msg']    : '';
$raison  = isset($_GET['raison']) ? $_GET['raison'] : '';

// On lit le contenu du dossier uploads
$fichiers = [];
if (is_dir($dossierUploads)) {
	foreach (scandir($dossierUploads) as $nom) {
		// On ignore les entrées spéciales
		if ($nom === '.' || $nom === '..' || $nom === '.gitkeep') continue;
		// On ajoute le fichier à la liste
		if (is_file($dossierUploads . '/' . $nom)) $fichiers[] = $nom;
	}
	// On trie les fichiers par ordre alphabétique
	sort($fichiers);
}

// On protège le texte affiché
function echapper($texte) {
	return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Upload de fichiers</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?php // On inclut le header ?>
	<?php include 'header.php'; ?>

	<main class="container" style="color: red;">
		<h1>Upload de fichiers</h1>

		<?php // On affiche le message de retour ?>
		<?php if ($message === 'ok'): ?>
			<p>Upload réussi.</p>
		<?php elseif ($message === 'erreur'): ?>
			<p>Erreur : <?= echapper($raison ?: 'inconnue') ?></p>
		<?php endif; ?>

		<?php // On affiche le formulaire d'envoi ?>
		<form method="post" action="upload.php" enctype="multipart/form-data">
			<p><input type="file" name="fichier" accept="application/pdf,image/*" required></p>
			<p>Formats autorisés : PDF et images</p>
			<p><input type="submit" value="Envoyer"></p>
		</form>

		<h2>Fichiers déjà uploadés</h2>

		<?php // On affiche la liste des fichiers ?>
		<?php if (count($fichiers) === 0): ?>
			<p>Aucun fichier.</p>
		<?php else: ?>
			<ul>
				<?php foreach ($fichiers as $fichier): ?>
					<li>
						<a href="uploads/<?= rawurlencode($fichier) ?>" target="_blank">
							<?= echapper($fichier) ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</main>

	<?php // On affiche le footer ?>
	<footer><p>Elias BOUZEKOUK</p></footer>
</body>
</html>
