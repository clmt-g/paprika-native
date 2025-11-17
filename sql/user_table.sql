-- Création de la table user
CREATE TABLE user (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      nom VARCHAR(100) NOT NULL,
                      prenom VARCHAR(100) NOT NULL,
                      login VARCHAR(50) NOT NULL UNIQUE,
                      passwd VARCHAR(255) NOT NULL,
                      role ENUM('default', 'secretaire', 'admin') NOT NULL DEFAULT 'default',
                      deleted TINYINT(1) NOT NULL DEFAULT 0
);

-- Insertion des données de test
-- Tous les mots de passe sont "motdepasse" hashés avec PASSWORD_BCRYPT (coût 10)
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

-- 2 comptes default
INSERT INTO user (nom, prenom, login, passwd, role) VALUES
                                                        ('Dupont', 'Jean', 'j.dupont@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'default'),
                                                        ('Martin', 'Sophie', 's.martin@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'default');

-- 2 comptes secretaire
INSERT INTO user (nom, prenom, login, passwd, role) VALUES
                                                        ('Dubois', 'Marie', 'm.dubois@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'secretaire'),
                                                        ('Leroy', 'Pierre', 'p.leroy@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'secretaire');

-- 2 comptes admin
INSERT INTO user (nom, prenom, login, passwd, role) VALUES
                                                        ('Bernard', 'Luc', 'l.bernard@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'admin'),
                                                        ('Petit', 'Claire', 'c.petit@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'admin');