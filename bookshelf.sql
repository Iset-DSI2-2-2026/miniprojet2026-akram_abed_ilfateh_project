-- Drop existing tables if they exist
DROP TABLE IF EXISTS livre_tag;
DROP TABLE IF EXISTS livre;
DROP TABLE IF EXISTS auteur;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS `user`;

-- Create Auteur table
CREATE TABLE auteur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    biographie LONGTEXT DEFAULT NULL,
    nationalite VARCHAR(50) NOT NULL
);

-- Create Genre table
CREATE TABLE genre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE,
    description LONGTEXT DEFAULT NULL,
    couleur VARCHAR(7) NOT NULL
);

-- Create Tag table
CREATE TABLE tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE,
    couleur VARCHAR(7) NOT NULL
);

-- Create Livre table
CREATE TABLE livre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    resume LONGTEXT NOT NULL,
    isbn VARCHAR(13) NOT NULL,
    nb_pages INT NOT NULL,
    date_publication DATE NOT NULL,
    disponible TINYINT NOT NULL DEFAULT 1,
    image_name VARCHAR(255) DEFAULT NULL,
    auteur_id INT NOT NULL,
    genre_id INT NOT NULL,
    FOREIGN KEY (auteur_id) REFERENCES auteur(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genre(id) ON DELETE CASCADE
);

-- Create livre_tag junction table
CREATE TABLE livre_tag (
    livre_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (livre_id, tag_id),
    FOREIGN KEY (livre_id) REFERENCES livre(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tag(id) ON DELETE CASCADE
);

-- Create User table
CREATE TABLE `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(180) NOT NULL UNIQUE,
    pseudo VARCHAR(50) NOT NULL,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insert sample genres
INSERT INTO genre (nom, description, couleur) VALUES
('Roman', 'Romans littéraires', '#FF5733'),
('Science-Fiction', 'Futur et technologies', '#33FF57'),
('Policier', 'Enquêtes et mystères', '#3357FF'),
('Fantasy', 'Magie et créatures fantastiques', '#FF33F5'),
('Biographie', 'Vies de personnages célèbres', '#F5FF33'),
('Histoire', 'Événements historiques', '#33FFF5');

-- Insert sample tags
INSERT INTO tag (nom, couleur) VALUES
('Bestseller', '#FF0000'),
('Classique', '#0000FF'),
('Coup de cœur', '#FFD700'),
('Nouveau', '#00FF00'),
('Prix littéraire', '#800080'),
('Film adapté', '#FF8C00'),
('Collection', '#008080'),
('Édition limitée', '#FF69B4');

-- Insert sample authors
INSERT INTO auteur (nom, prenom, biographie, nationalite) VALUES
('Hugo', 'Victor', 'Écrivain français, auteur des Misérables', 'Française'),
('Dumas', 'Alexandre', 'Auteur des Trois Mousquetaires', 'Française'),
('Orwell', 'George', 'Écrivain anglais, auteur de 1984', 'Anglaise'),
('Rowling', 'J.K.', 'Auteure de Harry Potter', 'Anglaise'),
('Christie', 'Agatha', 'Reine du crime', 'Anglaise');

-- Insert sample books
INSERT INTO livre (titre, resume, isbn, nb_pages, date_publication, disponible, auteur_id, genre_id) VALUES
('Les Misérables', 'Histoire de Jean Valjean dans la France du XIXe siècle', '9782253004221', 1500, '1862-01-01', 1, 1, 1),
('1984', 'Une dystopie sur la surveillance totale', '9780451524935', 328, '1949-06-08', 1, 3, 2),
('Harry Potter à l\'école des sorciers', 'Un jeune sorcier découvre ses pouvoirs', '9782070584628', 320, '1997-06-26', 1, 4, 4),
('Le Comte de Monte-Cristo', 'Une histoire de vengeance et de justice', '9782253003835', 1248, '1844-01-01', 1, 2, 1),
('Le Crime de l\'Orient-Express', 'Enquête sur un meurtre dans un train', '9782702435678', 320, '1934-01-01', 1, 5, 3);

-- Link books with tags
INSERT INTO livre_tag (livre_id, tag_id) VALUES
(1, 2), (1, 4),
(2, 1), (2, 2), (2, 5),
(3, 1), (3, 4), (3, 6),
(4, 2), (4, 4),
(5, 1), (5, 3);
