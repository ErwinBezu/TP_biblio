<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Livre</title>
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
        h1 {
            color: #333;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #ffc107;
            box-shadow: 0 0 5px rgba(255,193,7,0.3);
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-secondary {
            background-color: #6c757d;
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
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .form-actions {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .required {
            color: #dc3545;
        }
        .form-help {
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
        }
        .book-info {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>✏️ Modifier le livre</h1>

    <?php if (isset($error)): ?>
        <div class="error">
            ⚠️ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="success">
            ✅ <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($book) && $book): ?>
        <div class="book-info">
            <strong>Livre ID #<?= $book->getId() ?></strong> - Modification en cours
        </div>

        <form method="POST" action="/books/edit/<?= $book->getId() ?>">
            <div class="form-group">
                <label for="title">Titre <span class="required">*</span></label>
                <input type="text"
                       id="title"
                       name="title"
                       required
                       value="<?= htmlspecialchars($_POST['title'] ?? $book->getTitle() ?? '') ?>"
                       placeholder="Entrez le titre du livre">
                <div class="form-help">Le titre du livre est obligatoire</div>
            </div>

            <div class="form-group">
                <label for="author">Auteur <span class="required">*</span></label>
                <input type="text"
                       id="author"
                       name="author"
                       required
                       value="<?= htmlspecialchars($_POST['author'] ?? $book->getAuthor() ?? '') ?>"
                       placeholder="Entrez le nom de l'auteur">
                <div class="form-help">Le nom de l'auteur est obligatoire</div>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text"
                       id="isbn"
                       name="isbn"
                       value="<?= htmlspecialchars($_POST['isbn'] ?? $book->getIsbn() ?? '') ?>"
                       placeholder="Entrez l'ISBN (optionnel)"
                       pattern="[0-9\-X]{10,17}">
                <div class="form-help">Format : 978-2-123456-78-9 ou 2123456789 (optionnel)</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-warning">💾 Sauvegarder les modifications</button>
                <a href="/books/show/<?= $book->getId() ?>" class="btn btn-secondary">❌ Annuler</a>
            </div>
        </form>

    <?php else: ?>
        <div style="text-align: center; padding: 40px;">
            <h2>📚 Livre introuvable</h2>
            <p>Le livre que vous tentez de modifier n'existe pas ou a été supprimé.</p>
            <a href="/books" class="btn btn-secondary">← Retour à la liste</a>
        </div>
    <?php endif; ?>
</div>

<script>
    // Validation côté client
    document.querySelector('form')?.addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const author = document.getElementById('author').value.trim();

        if (!title || !author) {
            e.preventDefault();
            alert('Le titre et l\'auteur sont obligatoires !');
        }
    });
</script>
</body>
</html>