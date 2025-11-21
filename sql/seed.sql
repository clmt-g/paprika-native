-- ============================================
-- Seed file for Firemen Database
-- Generated for project Paprika
-- ============================================

-- Disable foreign key checks for insertion
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- Table: user
-- ============================================
TRUNCATE TABLE `user`;

INSERT INTO `user` (`id`, `nom`, `prenom`, `login`, `passwd`, `role`, `deleted`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$MJXPc2sZgX7y8oLLVJWKGeUIOPzGxQtrkuSs5bA/q9J2v1swcVEb2', 'admin', 0),
(2, 'Default', 'Default', 'default@gmail.com', '$2y$10$bEBgIDmHAWeFl7sknm1HMeBF0PuwqLgfDk6FeBQnIdHRsxuHAAadm', 'default', 0),
(3, 'Secretaire', 'Secretaire', 'secretaire@gmail.com', '$2y$10$D48QPmt06GKInO7ufdJx/OVn23BPp.tIODPUhK7cpFmc271oIndBu', 'secretaire', 0),
(4, 'Dupont', 'Jean', 'j.dupont@gmail.com', '$2y$10$ASAEnEFmk7KbF67iZq6nye7D2rkODaHIJ2sGFd0c5VZdlT/VCUvg6', 'default', 0),
(5, 'Martin', 'Sophie', 's.martin@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'secretaire', 0),
(6, 'Dubois', 'Marie', 'm.dubois@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'secretaire', 0),
(7, 'Leroy', 'Pierre', 'p.leroy@gmail.com', '$2y$10$RnnZz7GtUO9ry2MnD.JK8Oc.ssziEYCARTZhEraF5QsQuNzAv0c4i', 'admin', 0),
(8, 'Bernard', 'Luc', 'l.bernard@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'admin', 0),
(9, 'Petit', 'Claire', 'c.petit@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'default', 0),
(10, 'Moreau', 'Thomas', 't.moreau@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'default', 0),
(11, 'Laurent', 'Julie', 'j.laurent@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'secretaire', 0),
(12, 'Simon', 'Marc', 'm.simon@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'admin', 0),
(13, 'Michel', 'Emma', 'e.michel@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'default', 0),
(14, 'Lefebvre', 'Paul', 'p.lefebvre@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'secretaire', 0),
(15, 'Garnier', 'Laura', 'l.garnier@gmail.com', '$2y$10$SR4ZaaHJ55RUw8NjoEhDKOw/r42wU3y/kH4U4jN0GKRpT4UDPxtjy', 'default', 0);

-- ============================================
-- Table: typecasernes
-- ============================================
TRUNCATE TABLE `typecasernes`;

INSERT INTO `typecasernes` (`CodeTypeC`, `NomType`) VALUES
(1, 'Pro'),
(2, 'Mixte'),
(3, 'Volontaires');

-- ============================================
-- Table: casernes
-- ============================================
TRUNCATE TABLE `casernes`;

INSERT INTO `casernes` (`NumCaserne`, `Adresse`, `CP`, `Ville`, `CodeTypeC`, `deleted`) VALUES
(1, 'Rue de la Paix', '69001', 'Lyon', 1, 0),
(2, 'Avenue Foch', '69002', 'Lyon', 1, 0),
(3, 'Pl Bellecour', '69003', 'Lyon', 1, 0),
(4, 'Cours Lafayette', '69004', 'Lyon', 1, 0),
(5, 'Rue Garibaldi', '69005', 'Lyon', 1, 0),
(6, 'Av Lacassagne', '69006', 'Lyon', 1, 0),
(7, 'Rue de Gerland', '69007', 'Lyon', 1, 0),
(8, 'Cours Vitton', '69008', 'Lyon', 1, 0),
(9, 'Rue Duguesclin', '69009', 'Lyon', 1, 0),
(10, 'Pl des Terreaux', '69100', 'Villeurbanne', 1, 0),
(11, 'Av Einstein', '69500', 'Bron', 2, 0),
(12, 'Rue Mairie', '69301', 'Caluire', 2, 0),
(13, 'Pl Liberté', '69400', 'Arnas', 2, 0),
(14, 'République', '69600', 'Oullins', 2, 0),
(15, 'Av des Alpes', '69700', 'Givors', 2, 0),
(16, 'Rue du Centre', '69800', 'Saint-Priest', 3, 0),
(17, 'Pl du Village', '69200', 'Vénissieux', 3, 0),
(18, 'Rue Église', '69120', 'Vaulx-en-Velin', 3, 0),
(19, 'Av de la Gare', '69140', 'Rillieux', 1, 0),
(20, 'Chemin Rural', '73800', 'Lozanne', 3, 0),
(21, 'Rue du Rhône', '73000', 'Chambéry', 2, 0),
(22, 'Avenue Centrale', '69130', 'Écully', 1, 0);

-- ============================================
-- Table: grades
-- ============================================
TRUNCATE TABLE `grades`;

INSERT INTO `grades` (`CodeGrade`, `NomGrade`, `CoefIndem`) VALUES
('1C', '1ere classe', 6),
('AC', 'Adjudent chef', 8),
('Ad', 'Adjudent', 8),
('Ca', 'Caporal', 7),
('CC', 'Capo. Chef', 7),
('Ct', 'Capitaine', 10),
('In', 'Infirmier', 10),
('Lt', 'Lieutenant', 10),
('Ma', 'Major', 9),
('SC', 'Sgt Chef', 8),
('Sg', 'Sergent', 8),
('SP', 'Sapeur', 6);

-- ============================================
-- Table: pompiers
-- ============================================
TRUNCATE TABLE `pompiers`;

INSERT INTO `pompiers` (`Matricule`, `Prenom`, `Nom`, `ChefAgret`, `DateNaissance`, `NumCaserne`, `CodeGrade`, `MatriculeRespo`, `deleted`) VALUES
('P000001', 'Robert', 'Durant', 'O', '1975-03-15', 8, 'Ct', 'P000001', 0),
('P000002', 'Harry', 'Dupont', 'N', '1985-07-22', 1, 'CC', 'P000001', 0),
('P000003', 'Pierre', 'Bernard', 'N', '1990-11-08', 1, 'Ma', 'P000002', 0),
('P000004', 'Robert', 'Donald', 'N', '1988-04-12', 11, 'Sg', 'P000001', 0),
('P000005', 'Luc', 'Moreau', 'N', '1992-09-03', 1, 'SP', 'P000001', 0),
('P000006', 'Anne', 'Leroy', 'O', '1978-01-18', 2, 'Ct', 'P000007', 0),
('P000007', 'Thomas', 'Garcia', 'N', '1983-06-25', 2, 'Lt', 'P000006', 0),
('P000008', 'Julie', 'Roux', 'N', '1987-12-14', 2, 'SC', 'P000006', 0),
('P000009', 'Marc', 'Vincent', 'N', '1991-05-07', 2, 'Ca', 'P000006', 0),
('P000010', 'Emma', 'Simon', 'N', '1993-08-19', 2, 'SP', 'P000006', 0),
('P000011', 'Paul', 'Michel', 'O', '1976-10-30', 3, 'Ct', 'P000011', 0),
('P000012', 'Laura', 'Lefebvre', 'N', '1984-02-17', 3, 'Lt', 'P000011', 0),
('P000013', 'David', 'Mercier', 'N', '1989-07-11', 3, 'Ma', 'P000011', 0),
('P000014', 'Claire', 'Blanc', 'N', '1986-03-28', 3, 'Ad', 'P000011', 0),
('P000015', 'Nicolas', 'Girard', 'N', '1994-01-05', 3, 'SP', 'P000011', 0),
('P000016', 'Isabelle', 'Bonnet', 'O', '1977-08-13', 4, 'Lt', 'P000016', 0),
('P000017', 'Antoine', 'Dupuis', 'N', '1982-11-26', 4, 'In', 'P000016', 0),
('P000018', 'Nathalie', 'Lambert', 'N', '1988-04-09', 4, 'SC', 'P000016', 0),
('P000019', 'Julien', 'Fontaine', 'N', '1990-12-21', 4, 'Ca', 'P000016', 0),
('P000020', 'Céline', 'Robin', 'N', '1995-06-16', 4, 'SP', 'P000016', 0),
('P000021', 'François', 'Morel', 'O', '1974-05-02', 5, 'Ct', 'P000021', 0),
('P000022', 'Valérie', 'Fournier', 'N', '1981-09-15', 5, 'Lt', 'P000021', 0),
('P000023', 'Olivier', 'Giraud', 'N', '1987-01-23', 5, 'Ma', 'P000021', 0),
('P000024', 'Sandrine', 'Muller', 'N', '1985-08-07', 5, 'Sg', 'P000021', 0),
('P000025', 'Fabien', 'Henry', 'N', '1992-03-12', 5, 'SP', 'P000021', 0),
('P000026', 'Catherine', 'Rodriguez', 'O', '1979-07-28', 6, 'Lt', 'P000026', 0),
('P000027', 'Stéphane', 'Martinez', 'N', '1983-12-04', 6, 'In', 'P000026', 0),
('P000028', 'Aurélie', 'Thomas', 'N', '1986-10-17', 6, 'AC', 'P000026', 0),
('P000029', 'Maxime', 'Petit', 'N', '1989-04-25', 6, 'Ca', 'P000026', 0),
('P000030', 'Amélie', 'Robert', 'N', '1993-11-08', 6, 'SP', 'P000026', 0),
('P000031', 'Philippe', 'Richard', 'O', '1973-02-14', 7, 'Ct', 'P000031', 0),
('P000032', 'Sylvie', 'Durand', 'N', '1980-06-30', 7, 'Lt', 'P000031', 0),
('P000033', 'Christophe', 'Morvan', 'N', '1984-09-22', 7, 'Ma', 'P000031', 0),
('P000034', 'Virginie', 'Leclercq', 'N', '1987-01-15', 7, 'Sg', 'P000031', 0),
('P000035', 'Romain', 'Gauthier', 'N', '1991-05-18', 7, 'SP', 'P000031', 0),
('P000036', 'Martine', 'Joly', 'O', '1976-11-03', 8, 'Lt', 'P000036', 0),
('P000037', 'Éric', 'Meunier', 'N', '1982-04-19', 8, 'In', 'P000036', 0),
('P000038', 'Pascale', 'Barbier', 'N', '1985-08-26', 8, 'SC', 'P000036', 0),
('P000039', 'Sébastien', 'Brun', 'N', '1988-12-11', 8, 'Ca', 'P000036', 0),
('P000040', 'Delphine', 'Roy', 'N', '1994-07-05', 8, 'SP', 'P000036', 0),
('P000041', 'Alain', 'Faure', 'O', '1975-09-27', 9, 'Ct', 'P000041', 0),
('P000042', 'Corinne', 'Vidal', 'N', '1983-01-08', 9, 'Lt', 'P000041', 0),
('P000043', 'Bruno', 'Chevalier', 'N', '1986-05-14', 9, 'Ma', 'P000041', 0),
('P000044', 'Karine', 'Colin', 'N', '1989-10-29', 9, 'Ad', 'P000041', 0),
('P000045', 'Florian', 'Da Silva', 'N', '1992-02-23', 9, 'SP', 'P000041', 0),
('P000046', 'Brigitte', 'Perrin', 'O', '1978-06-16', 10, 'Lt', 'P000046', 0),
('P000047', 'Gilles', 'Caron', 'N', '1981-11-12', 10, 'In', 'P000046', 0),
('P000048', 'Monique', 'Girard', 'N', '1984-03-05', 10, 'SC', 'P000046', 0),
('P000049', 'Laurent', 'Picard', 'N', '1987-07-20', 10, 'Ca', 'P000046', 0),
('P000050', 'Agnès', 'Roger', 'N', '1990-12-02', 10, 'SP', 'P000046', 0),
('P000051', 'Daniel', 'Arnaud', 'O', '1974-04-11', 11, 'Ct', 'P000051', 0),
('P000052', 'Françoise', 'Lemaire', 'N', '1982-08-18', 11, 'Lt', 'P000051', 0),
('P000053', 'Thierry', 'Boucher', 'N', '1985-12-25', 11, 'Ma', 'P000051', 0),
('P000054', 'Patricia', 'Carpentier', 'N', '1988-06-07', 11, 'Sg', 'P000051', 0),
('P000055', 'Ludovic', 'Charpentier', 'N', '1991-10-14', 11, 'SP', 'P000051', 0),
('P000056', 'Sylvain', 'Marie', 'O', '1977-01-29', 12, 'Lt', 'P000056', 0),
('P000057', 'Dominique', 'Guillot', 'N', '1980-05-06', 12, 'In', 'P000056', 0),
('P000058', 'Caroline', 'Berger', 'N', '1983-09-13', 12, 'AC', 'P000056', 0),
('P000059', 'Frédéric', 'Fleury', 'N', '1986-02-28', 12, 'Ca', 'P000056', 0),
('P000060', 'Laetitia', 'Leclerc', 'N', '1989-07-09', 12, 'SP', 'P000056', 0),
('P000061', 'Jean-Pierre', 'Benoit', 'O', '1975-11-21', 13, 'Lt', 'P000061', 0),
('P000062', 'Chantal', 'Payet', 'N', '1982-03-16', 13, 'In', 'P000061', 0),
('P000063', 'Pascal', 'Lacroix', 'N', '1985-07-24', 13, 'SC', 'P000061', 0),
('P000064', 'Annie', 'Olivier', 'N', '1988-11-10', 13, 'Ca', 'P000061', 0),
('P000065', 'Vincent', 'Neveu', 'N', '1991-04-01', 13, 'SP', 'P000061', 0),
('P000066', 'Michel', 'Jean', 'O', '1973-08-08', 14, 'Ct', 'P000066', 0),
('P000067', 'Elisabeth', 'Marchand', 'N', '1981-12-15', 14, 'Lt', 'P000066', 0),
('P000068', 'Yves', 'Roussel', 'N', '1984-04-22', 14, 'Ma', 'P000066', 0),
('P000069', 'Murielle', 'Denis', 'N', '1987-08-17', 14, 'Sg', 'P000066', 0),
('P000070', 'Jérôme', 'Lejeune', 'N', '1990-01-04', 14, 'SP', 'P000066', 0),
('P000071', 'André', 'Leduc', 'O', '1976-05-31', 15, 'Lt', 'P000071', 0),
('P000072', 'Josiane', 'Brunet', 'N', '1983-09-07', 15, 'In', 'P000071', 0),
('P000073', 'Régis', 'Lemoine', 'N', '1986-01-14', 15, 'AC', 'P000071', 0),
('P000074', 'Béatrice', 'Hubert', 'N', '1989-05-20', 15, 'Ca', 'P000071', 0),
('P000075', 'Cédric', 'Renard', 'N', '1992-09-26', 15, 'SP', 'P000071', 0),
('P000076', 'Gérard', 'Schmitt', 'O', '1974-02-12', 16, 'Lt', 'P000076', 0),
('P000077', 'Nicole', 'Bonnet', 'N', '1979-06-19', 16, 'In', 'P000076', 0),
('P000078', 'Christian', 'Meyer', 'N', '1982-10-26', 16, 'SC', 'P000076', 0),
('P000079', 'Véronique', 'Garnier', 'N', '1985-03-13', 16, 'Ca', 'P000076', 0),
('P000080', 'Damien', 'Fabre', 'N', '1988-07-28', 16, 'SP', 'P000076', 0),
('P000081', 'Bernard', 'Sanchez', 'O', '1977-12-05', 17, 'Lt', 'P000081', 0),
('P000082', 'Jacqueline', 'Pons', 'N', '1980-04-12', 17, 'In', 'P000081', 0),
('P000083', 'Patrice', 'Germain', 'N', '1983-08-19', 17, 'AC', 'P000081', 0),
('P000084', 'Sabine', 'Costa', 'N', '1986-12-04', 17, 'Ca', 'P000081', 0),
('P000085', 'Michaël', 'Philippe', 'N', '1989-03-21', 17, 'SP', 'P000081', 0),
('P000086', 'Claude', 'Masson', 'O', '1975-07-15', 18, 'Lt', 'P000086', 0),
('P000087', 'Marie-Claude', 'Aubry', 'N', '1981-11-22', 18, 'In', 'P000086', 0),
('P000088', 'Hervé', 'Lesage', 'N', '1984-02-28', 18, 'SC', 'P000086', 0),
('P000089', 'Nadine', 'Poirier', 'N', '1987-06-15', 18, 'Ca', 'P000086', 0),
('P000090', 'Guillaume', 'Bourgeois', 'N', '1990-10-01', 18, 'SP', 'P000086', 0),
('P000091', 'Robert', 'Maillard', 'O', '1973-04-07', 19, 'Ct', 'P000091', 0),
('P000092', 'Martine', 'Gillet', 'N', '1980-08-14', 19, 'Lt', 'P000091', 0),
('P000093', 'Jean-Luc', 'Cousin', 'N', '1983-12-21', 19, 'Ma', 'P000091', 0),
('P000094', 'Christiane', 'Lamy', 'N', '1986-05-08', 19, 'Ad', 'P000091', 0),
('P000095', 'Alexandre', 'Guilbert', 'N', '1989-09-24', 19, 'SP', 'P000091', 0),
('P000096', 'Henri', 'Moulin', 'O', '1976-01-10', 20, 'Lt', 'P000096', 0),
('P000097', 'Odette', 'Tessier', 'N', '1982-05-17', 20, 'In', 'P000096', 0),
('P000098', 'Jean-Marc', 'Humbert', 'N', '1985-09-23', 20, 'SC', 'P000096', 0),
('P000099', 'Sylviane', 'Jacquet', 'N', '1988-01-30', 20, 'Ca', 'P000096', 0),
('P000100', 'Raphaël', 'Pereira', 'N', '1991-06-06', 20, 'SP', 'P000096', 0);
