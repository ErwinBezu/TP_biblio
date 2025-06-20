<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Livres</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .no-books {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
        .book-count {
            color: #6c757d;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📚 Bibliothèque - Gestion des Livres</h1>

    <a href="/books/create" class="btn">➕ Ajouter un nouveau livre</a>

    <?php if (!empty($books)): ?>
        <div class="book-count">
            Total : <?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?>
        </div>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>ISBN</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book->getId() ?? 'N/A') ?></td>
                    <td><strong><?= htmlspecialchars($book->getTitle() ?? 'Titre non défini') ?></strong></td>
                    <td><?= htmlspecialchars($book->getAuthor() ?? 'Auteur inconnu') ?></td>
                    <td><?= htmlspecialchars($book->getIsbn() ?? 'ISBN non défini') ?></td>
                    <td>
                        <div class="actions">
                            <a href="/books/show/<?= $book->getId() ?>" class="btn" style="padding: 5px 10px; font-size: 12px;">👁️ Voir</a>
                            <a href="/books/edit/<?= $book->getId() ?>" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px;">✏️ Modifier</a>
                            <a href="/books/delete/<?= $book->getId() ?>"
                               class="btn btn-danger"
                               style="padding: 5px 10px; font-size: 12px;"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">🗑️ Supprimer</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-books">
            <h2>📖 Aucun livre trouvé</h2>
            <p>Votre bibliothèque est vide. Commencez par ajouter votre premier livre !</p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>