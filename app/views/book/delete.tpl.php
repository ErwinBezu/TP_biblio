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
            max-width: 600px;
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
        }
        .book-detail strong {
            color: #495057;
        }
        .warning-message {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #ffeaa7;
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
            transition: background-color 0.3s;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
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

        <div class="warning-message">
            <strong>Attention !</strong> Cette action est irréversible. Le livre sera définitivement supprimé de la base de données.
        </div>

        <div class="book-info">
            <h3>Livre à supprimer :</h3>
            <div class="book-detail">
                <strong>ID :</strong> <?= htmlspecialchars($book->getId()) ?>
            </div>
            <div class="book-detail">
                <strong>Titre :</strong> <?= htmlspecialchars($book->getTitle() ?? 'Titre non défini') ?>
            </div>
            <div class="book-detail">
                <strong>Auteur :</strong> <?= htmlspecialchars($book->getAuthor() ?? 'Auteur inconnu') ?>
            </div>
            <div class="book-detail">
                <strong>ISBN :</strong> <?= htmlspecialchars($book->getIsbn() ?? 'Non renseigné') ?>
            </div>
        </div>

        <div class="actions">
            <form method="POST" action="/books/delete/<?= $book->getId() ?>" style="display: inline;">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous absolument sûr de vouloir supprimer ce livre ?')">
                    🗑️ Supprimer définitivement
                </button>
            </form>
            <a href="/books/show/<?= $book->getId() ?>" class="btn btn-secondary">
                ❌ Annuler
            </a>
        </div>

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