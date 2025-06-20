<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Livre</title>
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
            border-bottom: 2px solid #007bff;
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
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0,123,255,0.3);
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>
<div class="container">
    <h1>📚 Ajouter un nouveau livre</h1>

    <?php if (isset($error)): ?>
        <div class="error">
            ⚠️ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/books/create">
        <div class="form-group">
            <label for="title">Titre <span class="required">*</span></label>
            <input type="text"
                   id="title"
                   name="title"
                   required
                   value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                   placeholder="Entrez le titre du livre">
            <div class="form-help">Le titre du livre est obligatoire</div>
        </div>

        <div class="form-group">
            <label for="author">Auteur <span class="required">*</span></label>
            <input type="text"
                   id="author"
                   name="author"
                   required
                   value="<?= htmlspecialchars($_POST['author'] ?? '') ?>"
                   placeholder="Entrez le nom de l'auteur">
            <div class="form-help">Le nom de l'auteur est obligatoire</div>
        </div>

        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text"
                   id="isbn"
                   name="isbn"
                   value="<?= htmlspecialchars($_POST['isbn'] ?? '') ?>"
                   placeholder="Entrez l'ISBN (optionnel)"
                   pattern="[0-9\-X]{10,17}">
            <div class="form-help">Format : 978-2-123456-78-9 ou 2123456789 (optionnel)</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">💾 Enregistrer le livre</button>
            <a href="/books" class="btn btn-secondary">❌ Annuler</a>
        </div>
    </form>
</div>

<script>
    // Validation côté client
    document.querySelector('form').addEventListener('submit', function(e) {
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