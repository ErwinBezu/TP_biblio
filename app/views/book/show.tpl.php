<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Livre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .book-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .book-title {
            color: #333;
            font-size: 28px;
            margin: 0 0 10px 0;
        }
        .book-author {
            color: #666;
            font-size: 18px;
            font-style: italic;
        }
        .book-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .detail-label {
            font-weight: bold;
            color: #495057;
            width: 120px;
            flex-shrink: 0;
        }
        .detail-value {
            color: #333;
            flex-grow: 1;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .actions {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .book-icon {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 20px;
        }
        .no-isbn {
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($book) && $book): ?>
        <div class="book-header">
            <div class="book-icon">📖</div>
            <h1 class="book-title"><?= htmlspecialchars($book->getTitle() ?? 'Titre non défini') ?></h1>
            <p class="book-author">par <?= htmlspecialchars($book->getAuthor() ?? 'Auteur inconnu') ?></p>
        </div>

        <div class="book-details">
            <div class="detail-row">
                <div class="detail-label">ID :</div>
                <div class="detail-value"><?= htmlspecialchars($book->getId() ?? 'N/A') ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Titre :</div>
                <div class="detail-value"><?= htmlspecialchars($book->getTitle() ?? 'Titre non défini') ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Auteur :</div>
                <div class="detail-value"><?= htmlspecialchars($book->getAuthor() ?? 'Auteur inconnu') ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">ISBN :</div>
                <div class="detail-value">
                    <?php if ($book->getIsbn()): ?>
                        <?= htmlspecialchars($book->getIsbn()) ?>
                    <?php else: ?>
                        <span class="no-isbn">Non renseigné</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Catégories :</div>
                <div class="detail-value">
                    <?php if (!empty($book->getCategories())): ?>
                        <?= implode(', ', array_map('htmlspecialchars', $book->getCategories())) ?>
                    <?php else: ?>
                        <span class="no-isbn">Aucune catégorie</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="/books" class="btn btn-secondary">← Retour à la liste</a>
            <a href="/books/edit/<?= $book->getId() ?>" class="btn btn-warning">✏️ Modifier</a>
            <a href="/books/delete/<?= $book->getId() ?>"
               class="btn btn-danger"
               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">🗑️ Supprimer</a>
        </div>

    <?php else: ?>
        <div style="text-align: center; padding: 40px;">
            <h1>📚 Livre introuvable</h1>
            <p>Le livre demandé n'existe pas ou a été supprimé.</p>
            <a href="/books" class="btn btn-primary">← Retour à la liste</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>