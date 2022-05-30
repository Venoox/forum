-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: forum
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text DEFAULT NULL,
  `parent_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_category` (`parent_category`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_category`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Računalništvo',NULL,8),(5,'Pomoč in nasveti','Če imate kakršnekoli težave z računalnikom in jih ne znate uvrstiti v katerega od spodnjih oddelkov, je to pravo mesto za vas.',1),(6,'Informacijska varnost','Sefi, požarni zidovi in fotokopirni stroji.',1),(7,'Konzole','Svet konzol in iger zanje.',1),(8,'guard',NULL,NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'Slovenia');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `thread` (`thread`),
  KEY `user` (`user`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`thread`) REFERENCES `thread` (`id`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (10,5,8,'Priklopil sem že kar nekaj teh mesh kompletov 2, 3 pack\r\nampak do zdaj se nisem posvečal temu, kateri modelu dopuščajo da vse tri ali dve povežeš v lokalno mrežo in se vsi obnašajo kot AP\r\nVečina ko sem jih imel v rokah se povezujejo med sabo preko wifi, jaz pa bi rad da so povezani preko lana za uplink (lokalna mrežna)\r\n\r\nKateri modeli po cenovni lestvici to omogočajo 100 eur +','2022-05-30 07:20:47','0000-00-00 00:00:00'),(11,6,8,'Pozdravljeni, ena vzdrževalna stranka mi je fasala crypto ransomware na win serv2019standard preko Microsoft SQL Serverja, imel sem redirektan zunanji port iz 1433 na xxxxxx port na mikrotiku. Zajebal sem ker sem pozabil aktivirat drop rulo za nedovoljene ip-je. No v glavnem v enem slabem tednu je napadalcu uspelo prebit zaščito in okužit celoten domenski server, stem da je bilo cca 10.000 requesto in je ugotovil geslo ali kar koli mu je uspelo mislim neverjetno, še Microsoft mi verjetno nebi tak hitro prišel na strežnik. Kaj je to spet kaj novega ker do sedaj sem vedno imel napade preko emaila , rdp,.. nikoli pa še preko sql-a ali je to že stara zgodba?','2022-05-30 07:21:10','0000-00-00 00:00:00'),(12,7,8,'Zivijo,\r\n\r\nse da kje na spletu dobiti zastonj slovenske eknjige? Nekaj sem jih nasel na partisu, bi pa rad se kaj.\r\n\r\nMam nek xy bralnik, ki bere med drugim tudi .mobi, .epub, .pdf. Kaksne so prednosti/slabosti teh formatov? Oziroma v katerem formatu jih je najbolje imeti?','2022-05-30 07:21:28','0000-00-00 00:00:00'),(13,8,8,'Kateri antivirusni program je najbolj unčinkovit, se pravi, da vsebuje tudi požarni zid, da pregleduje pošto,... Oz. Katerega imate na svojem računalniku?\r\n\r\nKaj pravite za sophos antivirusni program ali je boljši od norton-a?\r\n\r\nNo, zanima me kaj več o antivirusnih programih!','2022-05-30 07:21:48','0000-00-00 00:00:00'),(14,9,8,'zanimam se za nakup xbox-a, ampak nikdar nisem imel nobene konzole, tako da se opravičujem za totalno noob vprašanje:\r\n\r\na lahko z xboxom gledam filme prek mreže (iz NAS-a)? se pravi, da bi imel xbox kot nek medijski center pod tv-jem.\r\nhvala :)','2022-05-30 07:22:06','0000-00-00 00:00:00'),(15,5,11,'Recimo tplink deco x20.','2022-05-30 07:22:34','0000-00-00 00:00:00'),(16,6,11,'Stara zgodba. Čudim se, da nisi slišal za SQL slamer. Od takrat naprej gre praktično vsa komunikacija vedno prek nečesa vmes.','2022-05-30 07:22:55','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Admin'),(2,'Moderator'),(3,'Member');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thread`
--

DROP TABLE IF EXISTS `thread`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text DEFAULT NULL,
  `category` int(11) NOT NULL,
  `created_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `original_poster` int(11) NOT NULL,
  `locked` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `original_poster` (`original_poster`),
  CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  CONSTRAINT `thread_ibfk_2` FOREIGN KEY (`original_poster`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thread`
--

LOCK TABLES `thread` WRITE;
/*!40000 ALTER TABLE `thread` DISABLE KEYS */;
INSERT INTO `thread` VALUES (5,'Mesh wifi kompleti in mrežna povezava med njimi',NULL,5,'2022-05-30 07:20:47',8,0),(6,'Izsiljevalski virus napad preko \"Microsoft SQL Server\"',NULL,5,'2022-05-30 07:21:10',8,0),(7,'E knjige',NULL,5,'2022-05-30 07:21:28',8,0),(8,'Anti-virus programi',NULL,6,'2022-05-30 07:21:48',8,0),(9,'Xbox One',NULL,7,'2022-05-30 07:22:06',8,0);
/*!40000 ALTER TABLE `thread` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `profile_picture` text NOT NULL DEFAULT 'assets/profile_pictures/default.png',
  `country` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_active` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `role` (`role`),
  KEY `country` (`country`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`role`) REFERENCES `role` (`id`),
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`country`) REFERENCES `country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (8,'venoox','admin@admin.com','$2y$10$1X4o6wkRo0cA.Rr7MfHisuIdxxwcAhjqy4MMKXX2eT7DPI9ydZLGO',1,'Hello World!!','assets/profile_pictures/default.png',1,'2022-05-24 18:39:56','2022-05-30 07:23:17'),(9,'venooxmod','mod@mod.com','$2y$10$e0EqhZtZEV/6WUpDEndnFuEano4FQ8dH6RhmnulV/uACdb7pgCxqq',2,'','assets/profile_pictures/default.png',1,'2022-05-30 05:38:36','2022-05-30 05:43:25'),(11,'useruser','user@user.com','$2y$10$1X4o6wkRo0cA.Rr7MfHisuIdxxwcAhjqy4MMKXX2eT7DPI9ydZLGO',3,'','assets/profile_pictures/default.png',1,'2022-05-30 06:11:05','2022-05-30 07:23:03');
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

-- Dump completed on 2022-05-30  9:23:53
