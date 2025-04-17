-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: filmsdb
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `acteurs`
--

DROP TABLE IF EXISTS `acteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acteurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acteurs`
--

LOCK TABLES `acteurs` WRITE;
/*!40000 ALTER TABLE `acteurs` DISABLE KEYS */;
INSERT INTO `acteurs` VALUES (1,'Leonardo DiCaprio'),(2,'Jamie Foxx'),(3,'Arnold Schwarzenegger'),(4,'Christian Bale'),(5,'Tom Hanks'),(6,'Matt Damon'),(7,'Kate Winslet'),(8,'Joseph Gordon-Levitt'),(9,'Mark Wahlberg'),(10,'Amy Adams'),(11,'Robert Downey Jr.'),(12,'Scarlett Johansson'),(13,'Chris Hemsworth'),(14,'Chris Evans'),(15,'Brie Larson'),(16,'Zoe Saldana'),(17,'Tom Cruise'),(18,'Brad Pitt'),(19,'Ryan Reynolds'),(20,'Angelina Jolie'),(21,'Morgan Freeman'),(22,'Natalie Portman'),(23,'Harrison Ford'),(24,'Jared Leto'),(25,'Emma Stone'),(26,'Dwayne Johnson'),(27,'Will Smith'),(28,'Eva Mendes'),(29,'Samuel L. Jackson'),(30,'Matt Smith'),(31,'Gal Gadot');
/*!40000 ALTER TABLE `acteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Action'),(2,'Drame');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `film_acteurs`
--

DROP TABLE IF EXISTS `film_acteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `film_acteurs` (
  `film_id` int NOT NULL,
  `acteur_id` int NOT NULL,
  PRIMARY KEY (`film_id`,`acteur_id`),
  KEY `acteur_id` (`acteur_id`),
  CONSTRAINT `film_acteurs_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE,
  CONSTRAINT `film_acteurs_ibfk_2` FOREIGN KEY (`acteur_id`) REFERENCES `acteurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `film_acteurs`
--

LOCK TABLES `film_acteurs` WRITE;
/*!40000 ALTER TABLE `film_acteurs` DISABLE KEYS */;
INSERT INTO `film_acteurs` VALUES (1,1),(2,1),(5,1),(7,1),(8,1),(11,1),(12,1),(13,1),(14,1),(17,1),(18,1),(20,1),(2,2),(19,2),(3,3),(4,4),(18,4),(3,5),(5,5),(6,5),(13,5),(15,5),(16,5),(17,5),(20,5),(3,6),(5,6),(7,6),(13,6),(18,6),(19,6),(6,7),(11,7),(20,7),(1,8),(4,8),(2,9),(4,9),(14,9),(17,9),(1,10),(6,10),(7,11),(8,12),(14,12),(8,13),(10,13),(15,13),(9,14),(9,15),(9,16),(10,17),(16,17),(10,18),(19,18),(11,19),(12,19),(15,19),(12,20),(16,20);
/*!40000 ALTER TABLE `film_acteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `films`
--

DROP TABLE IF EXISTS `films`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `films` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text,
  `realisateur_id` int DEFAULT NULL,
  `categorie_id` int DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `realisateur_id` (`realisateur_id`),
  KEY `categorie_id` (`categorie_id`),
  CONSTRAINT `films_ibfk_1` FOREIGN KEY (`realisateur_id`) REFERENCES `realisateurs` (`id`),
  CONSTRAINT `films_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `films`
--

LOCK TABLES `films` WRITE;
/*!40000 ALTER TABLE `films` DISABLE KEYS */;
INSERT INTO `films` VALUES (1,'Inception','Un homme tente de faire voler des idées dans le subconscient.',1,1,12.99,'https://image.tmdb.org/t/p/w500/qmDpIHrmpJINaRKAfWQfftjCdyi.jpg'),(2,'Django Unchained','Un esclave affranchi devient un chasseur de primes.',3,1,11.99,'https://image.tmdb.org/t/p/w500/7oWY8VDWW7thTzWh3OKYRkWUlD5.jpg'),(3,'Terminator 2','Le T-800 doit protéger un jeune garçon.',4,1,10.99,'https://image.tmdb.org/t/p/w500/5WPIz6km23jXcDqkV08OO3XJ0iP.jpg'),(4,'The Dark Knight','Batman lutte contre le Joker pour sauver Gotham.',1,1,13.99,'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg'),(5,'Saving Private Ryan','En mission de sauvetage pendant la Seconde Guerre mondiale.',2,1,9.99,'https://image.tmdb.org/t/p/w500/1wY4psJ5NVEhCuOYROwLH2XExM2.jpg'),(6,'Mad Max: Fury Road','La guerre post-apocalyptique dans le désert.',6,1,14.99,'https://image.tmdb.org/t/p/w500/kqjL17yufvn9OVLyXYpvtyrFfak.jpg'),(7,'Gladiator','Un général romain cherche à venger la mort de sa famille.',6,1,13.99,'https://image.tmdb.org/t/p/w500/ty8TGRuvJLPUmAR1H1nRIsgwvim.jpg'),(8,'John Wick','Un ancien tueur à gages revient pour venger son chien.',7,1,12.99,'https://image.tmdb.org/t/p/w500/5vHssUeVe25bMrof1HyaPyWgaP.jpg'),(9,'The Avengers','Les super-héros unissent leurs forces pour sauver la Terre.',8,1,15.99,'https://image.tmdb.org/t/p/w500/RYMX2wcKCBAr24UyPD7xwmjaTn.jpg'),(10,'Fast & Furious 7','Les véhicules et l’action pour protéger les siens.',9,1,11.99,'https://image.tmdb.org/t/p/w500/dCgm7efXDmiABSdWDHBDBx2jwmn.jpg'),(11,'Shutter Island','Une enquête sur une disparition dans un hôpital psychiatrique.',5,2,12.99,'https://image.tmdb.org/t/p/w500/kve20tXwUZpu4GUX8l6X7Z4jmL6.jpg'),(12,'The Departed','L’histoire de deux hommes infiltrés dans le crime et la police.',5,2,11.99,'https://image.tmdb.org/t/p/w500/auS1hTGYOx7cAr6r1r9XcZYx3Kr.jpg'),(13,'The Pursuit of Happyness','Un père et son fils luttent pour survivre à la pauvreté.',2,2,10.99,'https://image.tmdb.org/t/p/w500/6RgD1v2jlV5kqUYF9blw4lBhxQ2.jpg'),(14,'A Beautiful Mind','L’histoire d’un mathématicien brillant mais atteint de schizophrénie.',2,2,13.99,'https://image.tmdb.org/t/p/w500/5j1Pgl1NzkztWlEqsF1S7TWgJGb.jpg'),(15,'Forrest Gump','Un homme simple mais avec une vie extraordinaire.',2,2,9.99,'https://image.tmdb.org/t/p/w500/yn5ihODtZ7ofn8pDYfxCmxh8AXI.jpg'),(16,'The Shawshank Redemption','Un homme condamné à tort trouve l’espoir derrière les barreaux.',2,2,14.99,'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg'),(17,'The Green Mile','Un gardien de prison et un condamné possédant des pouvoirs spéciaux.',10,2,12.99,'https://image.tmdb.org/t/p/w500/velWPhVMQeQKcxggNEU8YmIo52R.jpg'),(18,'The Godfather','Une famille mafieuse et la succession du pouvoir.',10,2,15.99,'https://image.tmdb.org/t/p/w500/eEslKSwcqmiNS6va24Pbxf2UKmJ.jpg'),(19,'The Social Network','L’histoire de la création de Facebook et des conflits qui en ont découlé.',9,2,13.99,'https://image.tmdb.org/t/p/w500/n0ybibhJtQ5icDqTp8eRytcIHJx.jpg'),(20,'Titanic','L’histoire d’un amour tragique sur le Titanic.',4,2,11.99,'https://image.tmdb.org/t/p/w500/9xjZS2rlVxm8SFx8kPC3aIGCOYQ.jpg');
/*!40000 ALTER TABLE `films` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paniers`
--

DROP TABLE IF EXISTS `paniers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paniers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `film_id` int NOT NULL,
  `quantite` int DEFAULT '1',
  `date_ajout` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `film_id` (`film_id`),
  CONSTRAINT `paniers_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `paniers_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paniers`
--

LOCK TABLES `paniers` WRITE;
/*!40000 ALTER TABLE `paniers` DISABLE KEYS */;
/*!40000 ALTER TABLE `paniers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `realisateurs`
--

DROP TABLE IF EXISTS `realisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `realisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `realisateurs`
--

LOCK TABLES `realisateurs` WRITE;
/*!40000 ALTER TABLE `realisateurs` DISABLE KEYS */;
INSERT INTO `realisateurs` VALUES (1,'Christopher Nolan'),(2,'Steven Spielberg'),(3,'Quentin Tarantino'),(4,'James Cameron'),(5,'Martin Scorsese'),(6,'Ridley Scott'),(7,'Paul Greengrass'),(8,'Michael Bay'),(9,'David Fincher'),(10,'Ridley Scott');
/*!40000 ALTER TABLE `realisateurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateurs`
--

LOCK TABLES `utilisateurs` WRITE;
/*!40000 ALTER TABLE `utilisateurs` DISABLE KEYS */;
INSERT INTO `utilisateurs` VALUES (1,'user1@example.com','password123'),(2,'user2@example.com','securepassword'),(3,'user3@example.com','anotherpassword');
/*!40000 ALTER TABLE `utilisateurs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-17 20:22:28
