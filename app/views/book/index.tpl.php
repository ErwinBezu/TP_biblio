
<h1>Liste des livres</h1>


<?php if (!empty($books)): ?>
    <ul>
        <?php foreach ($books as $book): ?>
            <li><?= htmlspecialchars($book['title']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun livre trouvé.</p>
<?php endif; ?>