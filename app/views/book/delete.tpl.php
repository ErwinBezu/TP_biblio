<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer le Livre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .warning-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .warning-icon {
            font-size: 64px;
            color: #dc3545;
            margin-bottom: 15px;
        }
        .warning-title {
            color: #dc3545;
            font-size: 24px;
            margin: 0;
        }
        .book-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
        }
        .book-detail {
            margin: 8px 0;
            display: flex;
        }
        .book-detail strong {
            color: #495057;
            width: 100px;
            flex-shrink: 0;
        }
        .categories-section {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #ffeaa7;
        }
        .categories-title {
            color: #856404;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .category-tag {
            display: inline-block;
            background-color: #ffc107;
            color: #212529;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            margin: 2px;
        }
        .no-categories {
            color: #856404;
            font-style: italic;
        }
        .warning-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
        }
        .danger-info {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-1px);
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .consequences {
            list-style: none;
            padding: 0;
        }
        .consequences li {
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .consequences li:before {
            content: '⚠️';
            margin-right: 8px;
        }
        .consequences li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($error)): ?>
        <div class="error">
            ⚠️ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($book) && $book): ?>
        <div class="warning-header">
            <div class="warning-icon">⚠️</div>
            <h1 class="warning-title">Confirmation de suppression</h1>
        </div>

        <div class="danger-info">
            <strong>🔥 ATTENTION - ACTION IRRÉVERSIBLE</strong><br>
            Cette suppression est définitive et ne peut pas être annulée
        </div>

        <div class="book-info">
            <h3 style="margin-top: 0; color: #dc3545;">📖 Livre à supprimer :</h3>

            <div class="book-detail">
                <strong>ID :</strong>
                <span><?= htmlspecialchars($book->getId()) ?></span>
            </div>
            <div class="book-detail">
                <strong>Titre :</strong>
                <span><?= htmlspecialchars($book->getTitle() ?? 'Titre non défini') ?></span>
            </div>
            <div class="book-detail">
                <strong>Auteur :</strong>
                <span><?= htmlspecialchars($book->getAuthor() ?? 'Auteur inconnu') ?></span>
            </div>
            <div class="book-detail">
                <strong>ISBN :</strong>
                <span><?= htmlspecialchars($book->getIsbn() ?? 'Non renseigné') ?></span>
            </div>
        </div>

        <!-- Section des catégories -->
    <?php if (!empty($categories)): ?>
        <div class="categories-section">
            <div class="categories-title">
                🏷️ Catégories associées (<?= count($categories) ?>) :
            </div>
            <?php foreach ($categories as $category): ?>
                <span class="category-tag">
                        <?= htmlspecialchars($category->getName()) ?>
                    </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

        <div class="warning-message">
            <strong>Conséquences de cette suppression :</strong>
            <ul class="consequences">
                <li>Le livre sera définitivement supprimé de la base de données</li>
                <?php if (!empty($categories)): ?>
                    <li>Toutes les associations avec les <?= count($categories) ?> catégorie<?= count($categories) > 1 ? 's' : '' ?> seront supprimées</li>
                <?php endif; ?>
                <li>Cette action ne peut pas être annulée</li>
                <li>Toutes les données liées à ce livre seront perdues</li>
            </ul>
        </div>

        <div class="actions">
            <form method="POST" action="/books/<?= $book->getId() ?>/delete" style="display: inline;">
                <button type="submit"
                        class="btn btn-danger"
                        onclick="return confirmDeletion()">
                    🗑️ Supprimer définitivement
                </button>
            </form>
            <a href="/books/<?= $book->getId() ?>" class="btn btn-secondary">
                ❌ Annuler et retourner au livre
            </a>
        </div>

        <script>
            function confirmDeletion() {
                const bookTitle = '<?= htmlspecialchars($book->getTitle() ?? "ce livre") ?>';
                const categoriesCount = <?= count($categories ?? []) ?>;

                let confirmMessage = `🔥 DERNIÈRE CONFIRMATION\n\n`;
                confirmMessage += `Vous êtes sur le point de supprimer définitivement :\n`;
                confirmMessage += `"${bookTitle}"\n\n`;

                if (categoriesCount > 0) {
                    confirmMessage += `⚠️ Ce livre est associé à ${categoriesCount} catégorie${categoriesCount > 1 ? 's' : ''}.\n`;
                    confirmMessage += `Ces associations seront également supprimées.\n\n`;
                }

                confirmMessage += `Cette action est IRRÉVERSIBLE.\n\n`;
                confirmMessage += `Tapez "SUPPRIMER" pour confirmer :`;

                const userInput = prompt(confirmMessage);

                if (userInput === "SUPPRIMER") {
                    return confirm(`✅ Confirmation finale.\n\nLe livre "${bookTitle}" va être supprimé.\n\nContinuer ?`);
                } else if (userInput !== null) {
                    alert('❌ Suppression annulée.\n\nVous devez taper exactement "SUPPRIMER" pour confirmer.');
                }

                return false;
            }

            // Focus sur le bouton annuler par défaut pour éviter les suppressions accidentelles
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.btn-secondary').focus();
            });
        </script>

    <?php else: ?>
        <div style="text-align: center; padding: 40px;">
            <h1>📚 Livre introuvable</h1>
            <p>Le livre que vous tentez de supprimer n'existe pas.</p>
            <a href="/books" class="btn btn-secondary">← Retour à la liste</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>