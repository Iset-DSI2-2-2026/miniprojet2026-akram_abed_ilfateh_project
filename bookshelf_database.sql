-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: bookshelf_db
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auteur`
--

DROP TABLE IF EXISTS `auteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auteur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `biographie` longtext,
  `nationalite` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auteur`
--

LOCK TABLES `auteur` WRITE;
/*!40000 ALTER TABLE `auteur` DISABLE KEYS */;
INSERT INTO `auteur` VALUES (1,'Hugo','Victor','Accusamus vel dolor nemo eos sapiente iusto. Dolorem ut ut dignissimos qui occaecati.','Française'),(2,'Dumas','Alexandre','Iste laudantium beatae ipsum itaque molestiae qui culpa. Voluptas blanditiis sint amet qui est quisquam ut delectus. Dignissimos voluptas et fugiat nobis recusandae aut iure qui.','Française'),(3,'Orwell','George','Optio ab sed velit incidunt tempora dicta. Quo officia deleniti dolorem impedit.','Anglaise'),(4,'Rowling','J.K.','Expedita nihil dolore non. Temporibus possimus dolores officiis consequatur. Enim ut explicabo ut atque in temporibus.','Anglaise'),(5,'Christie','Agatha','Exercitationem omnis quos repudiandae voluptatem eveniet nulla. Nihil ratione perspiciatis quis nostrum ipsam consequuntur dolorum.','Anglaise');
/*!40000 ALTER TABLE `auteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20260511190224','2026-05-11 19:02:38',1809);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `description` longtext,
  `couleur` varchar(7) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_835033F86C6E55B5` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,'Roman','Romans littéraires','#FF5733'),(2,'Science-Fiction','Futur et technologies','#33FF57'),(3,'Policier','Enquêtes et mystères','#3357FF'),(4,'Fantasy','Magie et créatures fantastiques','#FF33F5'),(5,'Biographie','Vies de personnages célèbres','#F5FF33'),(6,'Histoire','Événements historiques','#33FFF5');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livre`
--

DROP TABLE IF EXISTS `livre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `livre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `resume` longtext NOT NULL,
  `isbn` varchar(13) DEFAULT NULL,
  `nb_pages` int NOT NULL,
  `date_publication` date NOT NULL,
  `disponible` tinyint NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `auteur_id` int NOT NULL,
  `genre_id` int NOT NULL,
  `ajoute_par_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AC634F9960BB6FE6` (`auteur_id`),
  KEY `IDX_AC634F994296D31F` (`genre_id`),
  KEY `IDX_AC634F99DAA76F43` (`ajoute_par_id`),
  CONSTRAINT `FK_AC634F994296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`),
  CONSTRAINT `FK_AC634F9960BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`id`),
  CONSTRAINT `FK_AC634F99DAA76F43` FOREIGN KEY (`ajoute_par_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livre`
--

LOCK TABLES `livre` WRITE;
/*!40000 ALTER TABLE `livre` DISABLE KEYS */;
INSERT INTO `livre` VALUES (1,'Maiores neque repudiandae vero.','Tempora quae odit dolores. Sapiente enim et voluptas molestias et culpa est. Quo harum saepe enim iure fuga.','9794284223248',449,'2000-11-01',0,NULL,5,3,1),(2,'Placeat vitae cumque doloremque perspiciatis.','Earum voluptatem facilis at esse inventore. Inventore non repellat non. Ut eligendi atque accusantium est quo ut eos. Laudantium voluptate impedit molestias provident voluptatem.','9795295405296',316,'1994-01-07',1,NULL,2,3,2),(3,'Et quo est nesciunt.','Voluptatibus suscipit vel eos ducimus nesciunt id debitis. Architecto eveniet dolorem quaerat itaque alias. Atque recusandae eius odit nisi aut quasi rerum.','9793612079557',293,'2002-08-27',1,NULL,5,2,2),(4,'Velit odit ratione magni adipisci.','Molestiae rem ducimus maxime. Eius qui pariatur nobis quia. Minima non ea quod sunt. Tempore distinctio velit enim.','9794836456612',140,'2005-02-12',1,'Screenshot-from-2025-04-29-12-37-07-6a023e047ef1e.png',5,5,1),(5,'Vitae voluptas laborum sed.','Ut illum necessitatibus sed. Dolore eos debitis quas beatae. Ullam temporibus voluptas atque.','9790508691886',583,'2017-06-20',1,NULL,5,3,3),(6,'Aut totam officiis veniam.','Non rem nisi consectetur qui enim. Ut ducimus deleniti cum voluptatem laborum. Ut harum neque nesciunt praesentium accusantium. Distinctio ad est non temporibus maxime quia.','9797168080715',668,'2019-04-08',1,NULL,3,3,2),(7,'Sit ut mollitia maiores.','Dolorem nam nesciunt cumque exercitationem vitae iusto consequuntur. Possimus dolores consequuntur eaque et dolores vitae. Distinctio repellendus praesentium quisquam enim maxime.','9798247764762',699,'1978-02-09',0,NULL,4,5,1),(8,'Est eum fugit.','Consequatur adipisci eveniet incidunt mollitia. Itaque non aut nisi dolorem. Quia maxime suscipit neque at magnam. Unde atque ipsum similique.','9781526766007',376,'1983-11-05',1,NULL,5,2,2),(9,'Repudiandae possimus omnis culpa.','Quibusdam quis voluptas ut dolorem accusamus quibusdam odit. Et fugit repellat quod quos voluptatem. Similique voluptatem et corporis illo expedita beatae praesentium.','9790117985055',695,'1988-01-28',1,NULL,1,3,2),(10,'Quaerat consequatur incidunt.','Eos et sit ut sed nihil sed consequuntur. Harum est placeat fugiat. Assumenda id aliquid blanditiis sit velit blanditiis.','9792254881764',778,'2007-12-08',1,NULL,3,4,2),(11,'Totam atque beatae dolor.','Quos facilis rerum sint aspernatur commodi asperiores quisquam. Qui voluptas dignissimos libero labore.','9790038194000',525,'2020-05-08',1,NULL,3,6,3),(12,'Vero alias vel autem.','Neque facilis temporibus id necessitatibus necessitatibus repellendus aut. Optio enim quo est autem. Vitae et et eos fugit asperiores totam eaque.','9795894799765',513,'1992-09-20',1,NULL,2,2,1),(13,'Maiores maxime sunt iusto.','Et nam iusto consequatur in dolorem. Assumenda autem earum eos deserunt. Voluptas ut aut doloribus sapiente.','9787407500821',534,'2024-10-28',1,NULL,3,1,1),(14,'Veniam sapiente ut.','Consectetur necessitatibus velit at nam aut rem eum. Aut consectetur earum sint reiciendis ea cupiditate. Omnis harum ex sed sequi dolor corrupti accusamus.','9786021904152',143,'2012-06-09',0,NULL,5,4,2),(15,'Sequi ad distinctio.','Suscipit delectus perspiciatis voluptatum et nam. Beatae ut ducimus totam nesciunt. Voluptatum non et vero quia quia. Qui numquam assumenda neque tenetur deleniti omnis eos ab.','9786655736457',249,'2015-06-19',1,NULL,1,2,1),(16,'Ut est omnis.','Aut rerum natus saepe neque perspiciatis autem fuga temporibus. Quasi excepturi optio enim voluptas corporis ea nam. Est iure sunt corporis dicta minima vitae.','9788918585819',595,'2003-01-12',1,NULL,1,1,2),(17,'Placeat eveniet porro eos.','Nesciunt qui laudantium velit ea. Eos autem ut enim. Ea eaque omnis beatae minima blanditiis officiis. Est non nihil ab dolorem et nesciunt alias sint.','9793218265514',185,'2001-08-31',1,NULL,3,1,2),(18,'Neque at minima repudiandae.','Debitis distinctio veniam ipsa veniam fugiat autem qui. Maiores sequi est quibusdam ab ex illum enim. Sunt voluptatem tempora omnis assumenda fuga et tenetur.','9782689934869',664,'1997-06-14',1,NULL,1,3,3),(19,'Rerum optio dignissimos a.','Voluptatem excepturi ad deserunt quia iure consequatur. Nam dolores quam distinctio eveniet consequuntur non voluptate. Qui dicta sit ipsa voluptas neque deleniti quisquam. Velit deleniti voluptatem laborum consequatur.','9781570922367',453,'1989-08-03',1,NULL,5,4,3),(20,'Sunt ea.','Sed perferendis et esse. Nihil vel reiciendis quos aut iusto qui cupiditate temporibus. Molestiae et ratione veniam dolorem numquam voluptatem cupiditate adipisci. In quam sed maxime et quis ex.','9795557152180',623,'1981-11-07',0,NULL,3,6,3),(21,'Ut qui.','Ratione saepe consequatur eos optio temporibus. Non nostrum eius fugit molestias possimus est. Sit libero dicta exercitationem repellendus minus corrupti iusto.','9784848801906',116,'1982-05-04',1,NULL,4,1,3),(22,'Occaecati quas vel.','Neque non fugiat quaerat aut. Et necessitatibus laborum recusandae pariatur. Provident velit corrupti ut dolore rerum. Enim provident rerum pariatur aut quisquam velit.','9796987620355',473,'2004-10-30',1,NULL,5,1,2),(23,'Dolorem hic quis.','In corrupti rerum nesciunt voluptates tempore. Minima fugit voluptatum dolores soluta enim esse ab. Omnis sit ut consectetur nihil. Illum consectetur sit exercitationem voluptate velit dolores ullam.','9785430912796',747,'1992-05-01',1,NULL,5,4,1),(24,'Non ut libero qui.','Esse eos accusamus voluptas delectus. Aperiam quasi et labore quae sed. Eos maxime quo perspiciatis ut. Repudiandae nobis neque voluptas repudiandae officia officiis et.','9786762208441',618,'1989-07-02',0,NULL,3,3,3),(25,'Distinctio numquam quod voluptatem.','Velit qui voluptatem nihil sit quam. Id nulla aliquid sed sint est repellendus quos. Laborum et facilis tempore qui. Odio voluptatem ullam itaque fuga enim sint et quis. Explicabo maxime ullam quam voluptate.','9786687794333',424,'1982-05-14',1,NULL,2,4,3),(26,'Placeat eos sint.','Sed cupiditate necessitatibus quisquam deserunt ipsa cum. Distinctio quaerat in eveniet molestiae aut. Nulla optio qui velit ut. Qui natus sint eum assumenda sint accusamus.','9799009570904',630,'2010-02-10',1,NULL,2,5,1),(27,'Impedit fugit quia.','Tenetur quas sint sit unde veniam et. Eius numquam quas nemo vitae.','9780193262119',301,'2021-02-08',1,NULL,3,1,3),(28,'Ut minus delectus.','Et voluptatem odit aut eum omnis. Expedita autem delectus aut et et. Voluptatem eaque quos et sapiente fugit facere.','9782262990442',266,'1999-08-17',1,NULL,1,4,3),(29,'Natus blanditiis mollitia.','Rerum laudantium fugit et eum. Et enim sunt voluptate iste.','9796870408879',771,'1993-02-03',0,NULL,3,3,3),(30,'Consequatur quia fugiat consequatur.','Vitae debitis itaque asperiores omnis sed. Necessitatibus incidunt dicta odit ea. Voluptatum saepe sed labore voluptas a. Rerum temporibus rerum sapiente voluptas maiores velit culpa.','9784296078547',259,'1985-08-08',1,NULL,1,3,1);
/*!40000 ALTER TABLE `livre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livre_tag`
--

DROP TABLE IF EXISTS `livre_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `livre_tag` (
  `livre_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`livre_id`,`tag_id`),
  KEY `IDX_64DC1D0D37D925CB` (`livre_id`),
  KEY `IDX_64DC1D0DBAD26311` (`tag_id`),
  CONSTRAINT `FK_64DC1D0D37D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_64DC1D0DBAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livre_tag`
--

LOCK TABLES `livre_tag` WRITE;
/*!40000 ALTER TABLE `livre_tag` DISABLE KEYS */;
INSERT INTO `livre_tag` VALUES (1,7),(2,3),(2,8),(3,2),(3,6),(3,7),(4,3),(4,5),(5,3),(6,4),(7,4),(7,5),(7,6),(8,4),(9,4),(10,3),(11,4),(11,8),(12,2),(12,3),(12,5),(13,2),(13,5),(13,6),(14,6),(14,7),(14,8),(15,1),(16,1),(16,2),(16,3),(17,3),(17,4),(17,7),(18,5),(19,6),(19,7),(19,8),(20,5),(20,6),(21,2),(21,3),(21,7),(22,5),(22,8),(23,1),(23,5),(24,1),(24,5),(25,1),(25,3),(25,5),(26,2),(26,8),(27,2),(27,5),(27,8),(28,1),(28,3),(29,1),(29,5),(30,4),(30,5),(30,7);
/*!40000 ALTER TABLE `livre_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `couleur` varchar(7) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_389B7836C6E55B5` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'Bestseller','#FF0000'),(2,'Classique','#0000FF'),(3,'Coup de cœur','#FFD700'),(4,'Nouveau','#00FF00'),(5,'Prix littéraire','#800080'),(6,'Film adapté','#FF8C00'),(7,'Collection','#008080'),(8,'Édition limitée','#FF69B4');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@gmail.com','[\"ROLE_ADMIN\"]','$2y$13$.YYKHczH5NWaJYpd2EJbou6d.jb5TtkN8KiUMEMFLT4L1QsVNPzBe','admin'),(2,'bib@gmail.com','[\"ROLE_BIBLIOTHECAIRE\"]','$2y$13$daxopSJvGLKEExIh.d.Q0e8ubjC2dQEpuaIwRXNy3KmCCsg.oNoFG','bib'),(3,'user@gmail.com','[\"ROLE_USER\"]','$2y$13$NpA5D2yaxrSXkS6.DR5q8u0OLQEO24Aqku3bRPiFMj13zuZxltbKe','user');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-11 22:22:31
