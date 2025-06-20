USE library;

INSERT INTO users (name, email, password, role)
VALUES
    ('Alice Smith', 'alice@example.com', 'pAss123&', 'reader'),
    ('Bob Johnson', 'bob@example.com', 'pasS456&', 'admin'),
    ('Carol Lee', 'carol@example.com', 'paSs789&', 'reader'),
    ('David Kim', 'david@example.com', 'daVid123&', 'reader'),
    ('Emma White', 'emma@example.com', 'emMa456&', 'admin'),
    ('Frank Brown', 'frank@example.com', 'fRank789&', 'reader'),
    ('Grace Green', 'grace@example.com', 'gEace123&', 'reader'),
    ('Henry Black', 'henry@example.com', 'hEnry456&', 'reader'),
    ('Isabelle Grey', 'isabelle@example.com', 'Isa789&', 'reader'),
    ('Jack Blue', 'jack@example.com', 'jacK123&', 'admin');

INSERT INTO books (title, author, isbn)
VALUES
    ('The Silent Forest', 'Mark Stone', '9781234567890'),
    ('Understanding SQL', 'Laura Bright', '9780987654321'),
    ('Ocean Deep', 'Nina Waters', '9782345678901'),
    ('The Future Code', 'Alan Byte', '9783456789012'),
    ('Mindset Shift', 'Carol Dweck', '9784567890123'),
    ('Secrets of the Sky', 'Tom Cloud', '9785678901234'),
    ('Learning Python', 'Guido Rossum', '9786789012345'),
    ('History of Art', 'Maria Canvas', '9787890123456'),
    ('Space Odyssey', 'Arthur Clark', '9788901234567'),
    ('The Art of War', 'Sun Tzu', '9789012345678');

INSERT INTO categories (name)
VALUES
    ('Science Fiction'),
    ('Education'),
    ('Technology'),
    ('History'),
    ('Philosophy'),
    ('Self-Help'),
    ('Fantasy'),
    ('Programming'),
    ('Biography'),
    ('Psychology');

INSERT INTO book_category (bookId, categoryId)
VALUES
    (1, 1), (1, 7),
    (2, 2), (2, 8),
    (3, 1), (3, 10),
    (4, 3), (4, 8),
    (5, 6),
    (6, 7), (6, 1),
    (7, 8), (7, 3),
    (8, 4),
    (9, 1),
    (10, 5);

INSERT INTO users_books (bookId, userId)
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6),
    (7, 7),
    (8, 8),
    (9, 9),
    (10, 10);
