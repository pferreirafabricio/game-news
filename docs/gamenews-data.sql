-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: gamenews
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `video_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Pokémon Go','Pokemon GO in 2019 is a game I shouldn’t care about. When it launched in 2016 it was in a lot of ways a mediocre experience.','SWtDeeXtMZM'),(2,'God of War','His vengeance against the gods of Olympus far behind him, Kratos now lives as a man in the lands of Norse Gods and monsters.','K0u_kAWLJOA'),(3,'Grand Theft Auto IV','What does the American Dream mean today? For Niko Belic, fresh off the boat from Europe.','ZQzIZkxsWYw'),(4,'Super Mario Galaxy','The ultimate Nintendo hero is taking the ultimate step ... out into space. Join Mario as he ushers in a new era of video games, defying gravity across all the planets in the galaxy. ','Nh-o3aeSMIM'),(5,'Red Dead Redemption','Developed by Rockstar San Diego, as a follow up to the 2004 hit game \'Red Dead Revolver,\' \'Red Dead Redemption\' is a Western epic.','PD24MkbHQrc'),(6,'Shadow of the Colossus','Shadow of the Colossus, released in Japan as Wander and the Colossus, is an action-adventure game developed by SIE Japan Studio and Team Ico.','8qNxyP6u2Kg'),(7,'Halo 2','The Covenant alien race threatens to destroy all humankind, and the only thing standing in its way is Master Chief, a genetically enhanced supersoldier.','k4NXV40gW7k'),(8,'Bomberman','Bomberman is a strategic, maze-based video game franchise originally developed by Hudson Soft and currently owned by Konami.','Xef0tkXmSp4');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-11 20:38:03
