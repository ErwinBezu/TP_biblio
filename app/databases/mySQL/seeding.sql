USE library;

INSERT INTO users (name, email) VALUES
                                    ('Alice Dupont', 'alice@example.com'),
                                    ('Bob Martin', 'bob@example.com'),
                                    ('Claire Leroy', 'claire@example.com'),
                                    ('David Moreau', 'david.moreau@example.com'),
                                    ('Émilie Petit', 'emilie.petit@example.com'),
                                    ('François Lemoine', 'francois.lemoine@example.com'),
                                    ('Gabriel Fontaine', 'gabriel.fontaine@example.com'),
                                    ('Hélène Bernard', 'helene.bernard@example.com'),
                                    ('Isabelle Caron', 'isabelle.caron@example.com'),
                                    ('Julien Robert', 'julien.robert@example.com');

INSERT INTO books (title, author, isbn) VALUES
                                            ('Le mystère de la forêt', 'Jean Valjean', '9781234567890'),
                                            ('Voyage au centre du code', 'Marie Curie', '9781234567891'),
                                            ("L\'ombre du bug", 'Alan Turing', '9781234567892'),
                                            ('Les algorithmes magiques', 'Ada Lovelace', '9781234567893'),
                                            ('La revanche du code', 'Grace Hopper', '9781234567894'),
                                            ('Dans les coulisses de la tech', 'Tim Berners-Lee', '9781234567895'),
                                            ('Les secrets de l’algorithme', 'Katherine Johnson', '9781234567896'),
                                            ('Code & Chocolat', 'Linus Torvalds', '9781234567897'),
                                            ('Déboguer la matrice', 'Neo Smith', '9781234567898'),
                                            ('Python et dragons', 'Guido van Rossum', '9781234567899');

INSERT INTO categories (name) VALUES
                                  ('Science-fiction'),
                                  ('Informatique'),
                                  ('Mystère'),
                                  ('Aventure');

INSERT INTO book_category (book_id, category_id) VALUES
                                                     (1, 3), -- Le mystère de la forêt → Mystère
                                                     (1, 4), -- Le mystère de la forêt → Aventure
                                                     (2, 2), -- Voyage au centre du code → Informatique
                                                     (3, 2), -- L'ombre du bug → Informatique
                                                     (3, 3), -- L'ombre du bug → Mystère
                                                     (4, 1), -- Les algorithmes magiques → Science-fiction
                                                     (4, 2); -- Les algorithmes magiques → Informatique

INSERT INTO users_books (user_id, book_id) VALUES
                                               (1, 1), -- Alice possède "Le mystère de la forêt"
                                               (2, 2), -- Bob possède "Voyage au centre du code"
                                               (3, 3), -- Claire possède "L'ombre du bug"
                                               (1, 4); -- Alice possède aussi "Les algorithmes magiques"


