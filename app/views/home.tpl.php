<html lang="fr">
<body>
<h1>Hello world</h1>
<?php if (!empty($reviews)): ?>
<div class="book-count">
    Total : <?= count($reviews) ?> reviews<?= count($reviews) > 1 ? 's' : '' ?>
</div>
<?php else: ?>
    <div class="no-books">
        <h2>📖 Aucune review trouvés</h2>
        <p>Ajouter un commentaire à un livre !</p>
    </div>
<?php endif; ?>
</body>
</html>