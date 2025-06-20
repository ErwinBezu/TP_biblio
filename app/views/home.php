<?php
use App\Controllers\BookController;

$bookController = new BookController();
$books = $bookController->findAll();
?>

<html lang="fr">
<body>
<h1>Hello world</h1>

<h2>Liste des livres</h2>
<ul>
    <?php foreach ($books as $book): ?>
        <li>
            <strong><?= htmlspecialchars($book['title']) ?></strong> —
            Auteur : <?= htmlspecialchars($book['author']) ?> —
            ISBN : <?= htmlspecialchars($book['isbn']) ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>

</html>
