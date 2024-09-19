
-- Gestion des problèmes de format (accentution) pour les INSERT TO dans alwaysdata
SET NAMES 'utf8mb4';
SET CHARACTER SET utf8mb4;
SET COLLATION_CONNECTION = 'utf8mb4_unicode_ci';

DROP DATABASE olindo55_arcadia;
CREATE DATABASE olindo55_arcadia;
USE  olindo55_arcadia;

-- table biome
CREATE TABLE biome(
   id INT AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   description TEXT NOT NULL,
   image_url VARCHAR(250) NOT NULL,
   image_url_hd VARCHAR(250) NOT NULL,
   image_alt VARCHAR(250) NOT NULL,
   PRIMARY KEY(id)
);

INSERT INTO biome (name, description, image_url, image_url_hd, image_alt) VALUES 
('jungle', 
 'La jungle est un écosystème complexe et dynamique où cohabitent une multitude d\'animaux, des plus petits insectes aux majestueux félins. C\'est un lieu de biodiversité sans égal, offrant un refuge à des espèces uniques et souvent menacées.', 
 '/asset/images/biome/chris-abney-qLW70Aoo8BE-unsplash.jpg',
 '/asset/images/biome/high-resolution/chris-abney-qLW70Aoo8BE-unsplash.jpg',
 'Image de la jungle dense'
),
('marais', 
 'Bienvenue dans l\'univers fascinant des marais, ces écosystèmes mystérieux et riches en vie, où l\'eau douce rencontre la terre. Les marais sont des lieux de biodiversité exceptionnelle, abritant une multitude d\'espèces animales et végétales qui coexistent dans une harmonie délicate.', 
 '/asset/images/biome/marie-helene-rots-aBepZL2ASGw-unsplash.jpg',
 '/asset/images/biome/high-resolution/marie-helene-rots-aBepZL2ASGw-unsplash.jpg',
 'Image d\'un marais au crépuscule'
),
('savane', 
 'La savane est un écosystème unique, caractérisé par ses saisons sèches et humides, et abritant une diversité impressionnante de faune. Ici, la vie sauvage s\'organise autour des points d\'eau vitaux, et chaque animal joue un rôle crucial dans l\'équilibre de cet environnement.', 
 '/asset/images/biome/daphne-fecheyr-N7uZUNwcrog-unsplash.jpg',
 '/asset/images/biome/high-resolution/daphne-fecheyr-N7uZUNwcrog-unsplash.jpg',
 'Image d\'une savane africaine'
),
('désert',
 'Le désert est un écosystème aride et souvent hostile, caractérisé par des températures extrêmes et une très faible précipitation. Malgré ces conditions sévères, il abrite une faune et une flore adaptées à la vie dans un environnement sec et chaud.',
 '/asset/images/biome/giorgio-parravicini-12IHVEFRacQ-unsplash.jpg',
 '/asset/images/biome/high-resolution/giorgio-parravicini-12IHVEFRacQ-unsplash.jpg',
 'Image d\'un désert' 
);

-- table breed
CREATE TABLE breed(
   id INT AUTO_INCREMENT,
   name VARCHAR(50),
   diet VARCHAR(50) NOT NULL,
   PRIMARY KEY(id)
);

INSERT INTO breed (name, diet) VALUES
('Tigre de Sumatra', 'carnivore'),
('Serpent réticulé', 'carnivore'),
('Léopard des neiges', 'carnivore'),
('Singe Capucin', 'omnivore'),
('Loris Lent', 'omnivore'),
('Alligator du Mississippi', 'carnivore'),
('Python Birman', 'carnivore'),
('Grenouille taureau', 'carnivore'),
('Ibis sacré', 'omnivore'),
('Caïman à lunettes', 'carnivore'),
('Lion d\'Afrique', 'carnivore'),
('Guépard', 'carnivore'),
('Zèbre de Grévy', 'herbivore'),
('Éléphant d\'Afrique', 'herbivore'),
('Hyène tachetée', 'carnivore'),
('Fennec', 'omnivore'),
('Dromadaire', 'herbivore'),
('Scorpion', 'carnivore'),
('Lézard à cornes', 'insectivore'),
('Hibou des neiges', 'carnivore');

-- table animal
CREATE TABLE animal(
   id INT AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   image_url VARCHAR(250) NOT NULL,
   image_alt VARCHAR(250),
   biome_id INT NOT NULL,
   breed_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(biome_id) REFERENCES biome(id),
   FOREIGN KEY(breed_id) REFERENCES breed(id)
);

-- Insertion pour la jungle
INSERT INTO animal (name, image_url, image_alt, biome_id, breed_id)
SELECT 'Java', '/asset/images/animals/tigre_sumatra.jpg', 'Tigre de Sumatra', 
       (SELECT id FROM biome WHERE name = 'jungle'), 
       (SELECT id FROM breed WHERE name = 'Tigre de Sumatra')
UNION ALL
SELECT 'Elo', '/asset/images/animals/serpent_reticule.jpg', 'Serpent réticulé', 
       (SELECT id FROM biome WHERE name = 'jungle'), 
       (SELECT id FROM breed WHERE name = 'Serpent réticulé')
UNION ALL
SELECT 'Worlde', '/asset/images/animals/leopard_neiges.jpg', 'Léopard des neiges', 
       (SELECT id FROM biome WHERE name = 'jungle'), 
       (SELECT id FROM breed WHERE name = 'Léopard des neiges')
UNION ALL
SELECT 'Node', '/asset/images/animals/singe_capucin.jpg', 'Singe Capucin', 
       (SELECT id FROM biome WHERE name = 'jungle'), 
       (SELECT id FROM breed WHERE name = 'Singe Capucin')
UNION ALL
SELECT 'Linux', '/asset/images/animals/loris_lent.jpg', 'Loris Lent', 
       (SELECT id FROM biome WHERE name = 'jungle'), 
       (SELECT id FROM breed WHERE name = 'Loris Lent');

-- Insertion pour le marais
INSERT INTO animal (name, image_url, image_alt, biome_id, breed_id)
SELECT 'Script', '/asset/images/animals/alligator_mississippi.jpg', 'Alligator du Mississippi', 
       (SELECT id FROM biome WHERE name = 'marais'), 
       (SELECT id FROM breed WHERE name = 'Alligator du Mississippi')
UNION ALL
SELECT 'Kernel', '/asset/images/animals/python_birman.jpg', 'Python Birman', 
       (SELECT id FROM biome WHERE name = 'marais'), 
       (SELECT id FROM breed WHERE name = 'Python Birman')
UNION ALL
SELECT 'Docker', '/asset/images/animals/grenouille_taureau.jpg', 'Grenouille taureau', 
       (SELECT id FROM biome WHERE name = 'marais'), 
       (SELECT id FROM breed WHERE name = 'Grenouille taureau')
UNION ALL
SELECT 'Shell', '/asset/images/animals/ibis_sacre.jpg', 'Ibis sacré', 
       (SELECT id FROM biome WHERE name = 'marais'), 
       (SELECT id FROM breed WHERE name = 'Ibis sacré')
UNION ALL
SELECT 'Escuelle', '/asset/images/animals/caiman_lunettes.jpg', 'Caïman à lunettes', 
       (SELECT id FROM biome WHERE name = 'marais'), 
       (SELECT id FROM breed WHERE name = 'Caïman à lunettes');

-- Insertion pour la savane
INSERT INTO animal (name, image_url, image_alt, biome_id, breed_id)
SELECT 'Array', '/asset/images/animals/lion_afrique.jpg', 'Lion d''Afrique', 
       (SELECT id FROM biome WHERE name = 'savane'), 
       (SELECT id FROM breed WHERE name = 'Lion d''Afrique')
UNION ALL
SELECT 'Turing', '/asset/images/animals/guepard.jpg', 'Guépard', 
       (SELECT id FROM biome WHERE name = 'savane'), 
       (SELECT id FROM breed WHERE name = 'Guépard')
UNION ALL
SELECT 'Jobs', '/asset/images/animals/zebre_grevy.jpg', 'Zèbre de Grévy', 
       (SELECT id FROM biome WHERE name = 'savane'), 
       (SELECT id FROM breed WHERE name = 'Zèbre de Grévy')
UNION ALL
SELECT 'Lambda', '/asset/images/animals/elephant_afrique.jpg', 'Éléphant d''Afrique', 
       (SELECT id FROM biome WHERE name = 'savane'), 
       (SELECT id FROM breed WHERE name = 'Éléphant d''Afrique')
UNION ALL
SELECT 'Api', '/asset/images/animals/hyene_tachetee.jpg', 'Hyène tachetée', 
       (SELECT id FROM biome WHERE name = 'savane'), 
       (SELECT id FROM breed WHERE name = 'Hyène tachetée');

-- Insertion pour le désert
INSERT INTO animal (name, image_url, image_alt, biome_id, breed_id)
SELECT 'Firefox', '/asset/images/animals/fennec.jpg', 'Fennec', 
       (SELECT id FROM biome WHERE name = 'désert'), 
       (SELECT id FROM breed WHERE name = 'Fennec')
UNION ALL
SELECT 'Toto', '/asset/images/animals/dromadaire.jpg', 'Dromadaire', 
       (SELECT id FROM biome WHERE name = 'désert'), 
       (SELECT id FROM breed WHERE name = 'Dromadaire')
UNION ALL
SELECT 'Bill', '/asset/images/animals/scorpion.jpg', 'Scorpion', 
       (SELECT id FROM biome WHERE name = 'désert'), 
       (SELECT id FROM breed WHERE name = 'Scorpion')
UNION ALL
SELECT 'Torvalds', '/asset/images/animals/lezard_cornes.jpg', 'Lézard à cornes', 
       (SELECT id FROM biome WHERE name = 'désert'), 
       (SELECT id FROM breed WHERE name = 'Lézard à cornes')
UNION ALL
SELECT 'Foo', '/asset/images/animals/hibou_neige.jpg', 'Hibou des neiges', 
       (SELECT id FROM biome WHERE name = 'désert'), 
       (SELECT id FROM breed WHERE name = 'Hibou des neiges');


-- table role
CREATE TABLE role(
   id INT AUTO_INCREMENT,
   role VARCHAR(50) NOT NULL,
   PRIMARY KEY(id)
);

INSERT INTO role (role) VALUES
('administrateur'),
('employé'),
('vétérinaire');


-- table users
CREATE TABLE users(
   id INT AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   forename VARCHAR(50) NOT NULL,
   email VARCHAR(250) NOT NULL,
   password CHAR(60) NOT NULL,
   role_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(role_id) REFERENCES role(id)
);
INSERT INTO users (name, forename, email, password, role_id) VALUES
('NONO', 'José', 'nono.jose@arcadia.com', '$2y$10$NPAGwajRc0vLIBGf/beq5ed9ZWkgZhTyZGVrnc/yzlvahxvfYfL8W', 1),
('MICHEMUCHE', 'Jean', 'jean.michemuche@arcadia.com', '$2y$10$NPAGwajRc0vLIBGf/beq5ed9ZWkgZhTyZGVrnc/yzlvahxvfYfL8W', 2),
('DOLITTLE', 'John', 'docteur.dolittle@arcadia.com', '$2y$10$NPAGwajRc0vLIBGf/beq5ed9ZWkgZhTyZGVrnc/yzlvahxvfYfL8W', 3);


-- table feeding
CREATE TABLE feeding(
   id INT AUTO_INCREMENT,
   date_feeding DATETIME NOT NULL,
   type_food VARCHAR(50),
   quantity INT,
   user_id INT NOT NULL,
   animal_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(user_id) REFERENCES users(id),
   FOREIGN KEY(animal_id) REFERENCES animal(id)
);


INSERT INTO feeding (date_feeding, type_food, quantity, user_id, animal_id) VALUES 
('2024-08-25 08:30:00', 'Croquettes', 200, 2, 2),
('2024-08-25 12:00:00', 'Foin', 300, 2, 3),
('2024-08-26 09:00:00', 'Poisson', 150, 2, 1),
('2024-08-26 14:00:00', 'Granulés', 250, 2, 4),
('2024-08-26 18:00:00', 'Viande', 500, 2, 5),
('2024-08-27 07:30:00', 'Légumes', 200, 2, 2);

-- table vet_report
CREATE TABLE vet_report(
   id INT AUTO_INCREMENT,
   date_report DATETIME NOT NULL,
   comment TEXT NOT NULL,
   score INT NOT NULL,
   user_id INT NOT NULL,
   animal_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(user_id) REFERENCES users(id),
   FOREIGN KEY(animal_id) REFERENCES animal(id)
);

INSERT INTO vet_report (date_report, comment, score, user_id, animal_id) VALUES 
('2024-08-20 10:00:00', 'L\'animal présente une légère boiterie. Recommandation : repos et anti-inflammatoires.', 3, 2, 2),
('2024-08-21 14:30:00', 'Examen annuel complet. Tous les signes vitaux sont normaux.', 5, 2, 3),
('2024-08-22 09:15:00', 'L\'animal montre des signes de stress. Recommandation : augmenter les activités d\'enrichissement.', 2, 2, 1),
('2024-08-23 11:45:00', 'Petite coupure sur la patte avant gauche. Désinfection effectuée, à surveiller.', 4, 2, 4),
('2024-08-24 16:00:00', 'Problèmes dentaires détectés. Nécessite une intervention mineure.', 3, 2, 5),
('2024-08-25 12:30:00', 'Comportement alimentaire anormal. Suggère une observation accrue pendant les repas.', 4, 2, 2),
('2024-08-26 08:00:00', 'Aucune anomalie détectée lors de l\'examen quotidien.', 5, 2, 3);

-- table biome_report
CREATE TABLE biome_report(
   id INT AUTO_INCREMENT,
   date_report DATETIME,
   comment TEXT,
   score INT NOT NULL,
   user_id INT NOT NULL,
   biome_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(user_id) REFERENCES users(id),
   FOREIGN KEY(biome_id) REFERENCES biome(id)
);

INSERT INTO biome_report (date_report, comment, score, user_id, biome_id) VALUES 
('2024-08-20 10:00:00', 'L\'habitat est en excellent état, les plantes sont en pleine croissance et l\'eau est claire.', 5, 2, 1),
('2024-08-21 14:30:00', 'Certaines zones montrent des signes de dégradation du sol. Nécessite une intervention pour régénérer la végétation.', 4, 2, 3),
('2024-08-22 09:15:00', 'Le système d\'irrigation fonctionne correctement mais nécessite un nettoyage. Aucune autre anomalie détectée.', 4, 2, 2),
('2024-08-25 12:30:00', 'Problèmes d\'accumulation de déchets dans les zones de nourrissage. Un plan de nettoyage doit être mis en place.', 2, 2, 3),
('2024-08-26 08:00:00','L\'habitat est en bon état général mais les structures d\'abri montrent des signes d\'usure.', 3, 2, 4);

-- table service
CREATE TABLE service(
   id INT AUTO_INCREMENT,
   name VARCHAR(50),
   description TEXT,
   image_url VARCHAR(250),
   image_alt VARCHAR(250) NOT NULL,
   user_id INT,
   PRIMARY KEY(id),
   FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO service (name, description, image_url, image_alt, user_id) VALUES 
('Visites guidées',
'Découvrez le zoo comme jamais auparavant grâce à nos visites guidées! Accompagné par un guide passionné, explorez les différentes espèces animales et apprenez des anecdotes fascinantes sur leur habitat et leur comportement. Que vous soyez curieux ou expert, cette visite enrichissante vous plongera dans le monde des animaux tout en répondant à vos questions. Idéale pour les familles et les groupes, elle vous offre une occasion unique de voir de plus près la vie sauvage et de comprendre les enjeux de la conservation. Une expérience éducative et immersive à ne pas manquer!',
'/asset/images/services/visites_guidees.jpg',
'Un guide explique le zoo aux visiteurs',
NULL),
('Restauration',
'Après une journée d’exploration, faites une pause gourmande dans notre restaurant. Nous proposons une cuisine variée, élaborée à partir de produits frais, pour satisfaire tous les appétits. Que vous souhaitiez un repas complet ou simplement une collation, notre menu s’adapte à vos envies. Profitez de notre terrasse en plein air pour savourer votre repas dans un cadre naturel et apaisant. Notre restaurant est également équipé pour accueillir les familles avec des options pour enfants. Reposez-vous et rechargez vos batteries avant de continuer votre aventure au zoo.',
'/asset/images/services/kristof-korody-udN5SKlmtqg-unsplash.jpg',
'Une assiette d\'un plat servis dans notre restaurant',
NULL),
('Petit train',
'Embarquez à bord de notre petit train pour une visite relaxante du zoo! Ce moyen de transport ludique est idéal pour découvrir les différents espaces du parc sans effort. Le trajet vous emmène à travers nos habitats thématiques, vous offrant une vue d’ensemble sur les animaux et leur environnement. Le petit train est accessible à tous, y compris aux familles avec enfants et aux personnes à mobilité réduite. Une façon confortable et amusante de parcourir le zoo, tout en profitant de commentaires audio pour enrichir votre visite. Laissez-vous guider.',
'/asset/images/services/casey-horner-p69o_a7XqDM-unsplash.jpg',
'Le petit train sort du biome Jungle',
NULL),
('Nourrissage',
'Vivez un moment privilégié en assistant au nourrissage des animaux! Nos soigneurs vous invitent à découvrir les coulisses du zoo en vous montrant comment ils prennent soin de nos pensionnaires. Vous pourrez observer de près le comportement des animaux durant ce moment crucial de la journée et en apprendre davantage sur leur régime alimentaire. C’est l’occasion parfaite pour poser toutes vos questions et mieux comprendre les besoins spécifiques de chaque espèce. Une activité captivante qui ravira petits et grands, tout en sensibilisant à la conservation et au bien-être animal.',
'/asset/images/services/daiga-ellaby-p-vf1RhLzsc-unsplash.jpg',
'Un soigneur nourrissant les animaux',
NULL),
('Spectacles',
'Laissez-vous émerveiller par nos spectacles animaliers, où la nature devient spectacle! Nos spectacles sont conçus pour éduquer tout en divertissant, mettant en scène des animaux fascinants qui dévoilent leurs talents naturels. Chaque représentation est unique, mettant en lumière les comportements instinctifs et les capacités extraordinaires de nos animaux vedettes. Que ce soit un spectacle de perroquets colorés ou un show avec nos animaux sauvages, vous en sortirez avec des souvenirs inoubliables. Une expérience à ne pas manquer pour toute la famille, mêlant pédagogie et émerveillement.',
'/asset/images/services/ankush-minda-Bsxv_Nbs-VY-unsplash.jpg',
'Un spectacle de perroquet',
NULL),
('Ateliers éducatifs',
'Encouragez la curiosité et la créativité de vos enfants avec nos ateliers éducatifs! Conçus pour les plus jeunes, ces ateliers interactifs leur permettent de découvrir le monde des animaux de manière ludique. Accompagnés de nos animateurs, les enfants participent à des activités manuelles, des jeux éducatifs et des expériences sensorielles qui éveillent leur intérêt pour la nature et la biodiversité. Chaque atelier est une aventure unique, adaptée à l\'âge et au rythme des participants. Offrez-leur une expérience d\'apprentissage amusante et enrichissante qui complétera leur visite au zoo.',
'/asset/images/services/atelier-enfants.jpg',
'Atelier éducatif pour les enfants',
NULL),
('Expositions',
'Plongez au cœur de la biodiversité avec nos expositions thématiques! Ces espaces dédiés vous invitent à découvrir des espèces rares et fascinantes, des insectes aux reptiles, en passant par des plantes exotiques. Chaque exposition est soigneusement conçue pour offrir un aperçu approfondi de l’écosystème représenté, avec des informations claires et accessibles. Vous aurez l’occasion d’explorer des environnements recréés avec soin, où chaque détail compte. Que vous soyez passionné de biologie ou simple curieux, nos expositions enrichissent votre visite en vous offrant une immersion totale dans le monde naturel.',
'/asset/images/services/butterfly-biodiversity-two-column.jpg.thumb.768.768.jpg',
'Différent papillons',
NULL);

-- table comment
CREATE TABLE comment(
   id INT AUTO_INCREMENT,
   pseudo VARCHAR(50) NOT NULL,
   comment TEXT NOT NULL,
   date_comment DATETIME NOT NULL,
   score INT NOT NULL,
   published BOOLEAN NOT NULL DEFAULT FALSE,
   user_id INT,
   PRIMARY KEY(id),
   FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO comment (pseudo, comment, date_comment, score, published, user_id) VALUES
('ZooLover89', 'Le zoo est fantastique ! Les animaux ont l\'air en bonne santé et les enclos sont bien entretenus.',  '2024-08-20 14:30:00', 5, TRUE, 1),
('AnimalFan2024', 'L\'environnement est agréable, mais j\'ai remarqué que certains enclos sont un peu sales.',  '2024-08-21 10:15:00', 3, TRUE, 1),
('EcoWarrior', 'Les efforts pour la conservation sont louables, mais j\'espère que les animaux auront plus d\'espace à l\'avenir.',  '2024-08-22 16:00:00', 4, TRUE, 1),
('FamilyOuting', 'Le zoo est bien conçu pour les familles, mais les prix des snacks sont un peu élevés.',  '2024-08-23 12:45:00', 4, TRUE, 1),
('OccasionalVisitor', 'Je trouve que les animaux ne semblent pas très actifs. Peut-être qu\'il faudrait plus d\'enrichissement.',  '2024-08-24 09:00:00', 2, FALSE, 1);


CREATE TABLE opening (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day_name VARCHAR(10) NOT NULL,        
    opening_hour INT NOT NULL,  
    opening_minute INT NOT NULL, 
    closing_hour INT NOT NULL,    
    closing_minute INT NOT NULL,  
    closure BOOLEAN        
);

INSERT INTO opening (day_name, opening_hour, opening_minute, closing_hour, closing_minute, closure) VALUES
('Lundi', 9, 0, 17, 30, 0),    
('Mardi', 9, 0, 17, 30, 0),   
('Mercredi', 9, 0, 17, 30, 0),
('Jeudi', 9, 0, 17, 30, 0),  
('Vendredi', 9, 0, 17, 30, 0), 
('Samedi', 10, 0, 14, 0, 0),   
('Dimanche', 0, 0, 0, 0, 1);   

CREATE TABLE dietary (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO dietary (name) VALUES
('Carnivore'),
('Herbivore'),
('Omnivore'),
('Insectivore'),
('Frugivore'),
('Granivore'),
('Folivore'),
('Piscivore'),
('Nectarivore'),
('Detritivore'),
('Coprophage'),
('Hématophage');