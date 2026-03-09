/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: GestioneConvegni
-- ------------------------------------------------------
-- Server version	10.11.14-MariaDB-0ubuntu0.24.04.1

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
-- Table structure for table `Convegni`
--

DROP TABLE IF EXISTS `Convegni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Convegni` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `nome_convegno` varchar(50) NOT NULL,
  `numero_partecipanti` int(6) DEFAULT NULL,
  `Data` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Convegni`
--

LOCK TABLES `Convegni` WRITE;
/*!40000 ALTER TABLE `Convegni` DISABLE KEYS */;
INSERT INTO `Convegni` VALUES
(1,'Bologna Digital Conference',1,NULL),
(2,'ciao',2,NULL),
(3,'Convegno Firenze 2026',3,NULL),
(4,'Milano Tech Summit 2026',15,NULL),
(5,'Roma Business Forum',8,NULL),
(6,'Venezia Startup Week',12,NULL),
(7,'volta in progress',10,NULL),
(13,'ciaodario',2,NULL);
/*!40000 ALTER TABLE `Convegni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Partecipanti`
--

DROP TABLE IF EXISTS `Partecipanti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Partecipanti` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_convegno` int(6) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_convegno` (`id_convegno`),
  CONSTRAINT `Partecipanti_ibfk_1` FOREIGN KEY (`id_convegno`) REFERENCES `Convegni` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Partecipanti`
--

LOCK TABLES `Partecipanti` WRITE;
/*!40000 ALTER TABLE `Partecipanti` DISABLE KEYS */;
INSERT INTO `Partecipanti` VALUES
(1,1,'Sergio','Antonelli'),
(2,2,'dario','ciao'),
(3,2,'nkjash','dhaskjdh'),
(4,3,'Marco','Rossi'),
(5,3,'Anna','Bianchi'),
(6,3,'Luigi','Verdi'),
(7,4,'Andrea','Ferrari'),
(8,4,'Elena','Russo'),
(9,4,'Giovanni','Colombo'),
(10,4,'Francesca','Conti'),
(11,4,'Davide','Marini'),
(12,4,'Sofia','Gallo'),
(13,4,'Roberto','Costa'),
(14,4,'Giulia','Moretti'),
(15,4,'Paolo','Martini'),
(16,4,'Laura','Santoro'),
(17,4,'Matteo','Barbieri'),
(18,4,'Chiara','Caputo'),
(19,4,'Alessandro','Grasso'),
(20,4,'Martina','Leone'),
(21,4,'Riccardo','Spada'),
(22,5,'Giacomo','Benedetti'),
(23,5,'Valentina','Gini'),
(24,5,'Michele','Sartori'),
(25,5,'Sara','Ferretti'),
(26,5,'Lorenzo','Pazzi'),
(27,5,'Federica','Lombardi'),
(28,5,'Simone','Bonetti'),
(29,5,'Ilaria','Benedetti'),
(30,6,'Alessio','Rossi'),
(31,6,'Beatrice','Moretti'),
(32,6,'Cristian','Russo'),
(33,6,'Debora','Marchetti'),
(34,6,'Emanuele','Neri'),
(35,6,'Federica','Giordano'),
(36,6,'Gianluigi','Salmoni'),
(37,6,'Helena','Caruso'),
(38,6,'Iacopo','Ferrara'),
(39,6,'Jacopo','Martinelli'),
(40,6,'Katia','Ferretti'),
(41,6,'Luca','Rossini'),
(60,13,'filippo','berti'),
(61,13,'filippo','berti');
/*!40000 ALTER TABLE `Partecipanti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Utenti`
--

DROP TABLE IF EXISTS `Utenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Utenti` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tipo` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utenti`
--

LOCK TABLES `Utenti` WRITE;
/*!40000 ALTER TABLE `Utenti` DISABLE KEYS */;
INSERT INTO `Utenti` VALUES
(1,'smonni0','Password1','user'),
(2,'dscatchard1','Password2','admin'),
(3,'cmcgahey2','Password3','admin'),
(4,'aassaf3','Password4','user'),
(5,'tuzelli4','Password5','user'),
(6,'csmees5','Password6','user'),
(7,'nstrephan6','Password7','user'),
(8,'aaylott7','Password8','admin'),
(9,'bpeffer8','Password9','admin'),
(10,'drodway9','Password10','user'),
(11,'dario','ciao','admin'),
(12,'ciao','dario','user'),
(13,'test_user_1768936656','Password123','user'),
(14,'test_user_1768936661','Password123','user'),
(15,'testadmin','testpass','admin');
/*!40000 ALTER TABLE `Utenti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'GestioneConvegni'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-20  8:54:51
