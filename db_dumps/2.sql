-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: progweb
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('text','number','email','regex','textarea','select') NOT NULL,
  `ticket_category` int(11) NOT NULL,
  `label` varchar(60) NOT NULL,
  `placeholder` varchar(124) DEFAULT NULL,k
  `order_index` int(11) DEFAULT NULL,
  `min_value` int(11) DEFAULT NULL,
  `default_value` varchar(45) DEFAULT NULL,
  `max_value` int(11) DEFAULT NULL,
  `regex_pattern` varchar(255) DEFAULT NULL,
  `select_options` varchar(255) DEFAULT NULL,
  `required` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_custom_fields_ticket_categories1_idx` (`ticket_category`),
  CONSTRAINT `fk_custom_fields_ticket_categories1` FOREIGN KEY (`ticket_category`) REFERENCES `ticket_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields`
--

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
INSERT INTO `custom_fields` VALUES (1,'text',1,'Codice fattura','Numero di fattura in questione',NULL,NULL,NULL,NULL,NULL,NULL,0),(2,'select',2,'Prodotto coinvolto','Prodotto coinvolto nel guasto',NULL,NULL,NULL,NULL,NULL,'One Air,Water+,Sky Light',1);
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` int(11) NOT NULL,
  `type` enum('CUSTOMER','OPERATOR','INTERNAL') NOT NULL,
  `operator` int(11) DEFAULT NULL,
  `text` text NOT NULL,
  `send_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`ticket`),
  KEY `fk_messages_tickets1_idx` (`ticket`),
  KEY `fk_messages_users1_idx` (`operator`),
  CONSTRAINT `fk_messages_tickets1` FOREIGN KEY (`ticket`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users1` FOREIGN KEY (`operator`) REFERENCES `operators` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (6,2,'CUSTOMER',NULL,'Prodotto coinvolto:  Water+\nLorem ipsum volutpat magna mollis congue eget aptent enim odio nisl massa rutrum aliquam a ante sem facilisis porta in integer ut integer id phasellus nulla luctus, quis magna ultrices eleifend neque nunc suspendisse egestas vulputate ac vehicula vitae purus quam maecenas amet.\n\nEu curabitur eu nullam morbi venenatis habitasse etiam consequat ac, id habitant sit fusce cursus sollicitudin nullam eu vel, ullamcorper faucibus lorem ut tristique nibh quisque sem amet sit donec lobortis primis hendrerit tristique phasellus viverra augue pharetra nulla aptent nisl.\n','2017-09-04 09:13:54'),(7,3,'CUSTOMER',NULL,'Lorem ipsum nibh ante integer placerat mi torquent, suspendisse fringilla lacus blandit ut nulla nec, himenaeos pellentesque lectus suspendisse tempus lobortis urna netus hac curabitur aliquam inceptos viverra porttitor fermentum netus suspendisse quam himenaeos, aptent vivamus netus litora class fringilla ullamcorper sit hendrerit molestie.\nMassa at nibh ante fringilla inceptos nibh egestas fringilla torquent, massa viverra fusce purus ut dictum faucibus ac ad, nisl donec taciti etiam hendrerit turpis habitasse sollicitudin taciti fames tincidunt in nam lorem pellentesque turpis, potenti sit auctor aenean congue mollis, integer ante eros erat potenti ornare.\nMollis tristique in erat vehicula curabitur pulvinar sed fames tempus sem maecenas lobortis consectetur cubilia condimentum, morbi sapien fusce elementum mattis ante litora eget pellentesque sit est vestibulum mattis nisi nostra condimentum iaculis accumsan lobortis vel scelerisque risus nostra netus imperdiet ut suspendisse tellus.\n','2017-09-04 09:15:52'),(8,4,'CUSTOMER',NULL,'Codice fattura:  LT1234\nLorem ipsum bibendum ullamcorper pulvinar id sapien conubia fringilla justo rhoncus at torquent, vestibulum class suscipit aenean mattis primis vitae libero aenean dictumst urna auctor himenaeos cursus nisi ipsum tempus donec enim.\nNam himenaeos quisque torquent faucibus est egestas ligula aptent turpis, sagittis nibh laoreet tristique dictum diam libero ultricies at, fusce leo praesent justo tristique nisi in per fusce vehicula ante varius morbi.\n','2017-09-04 09:18:07'),(9,5,'CUSTOMER',NULL,'Prodotto coinvolto:  Sky Light\nLorem ipsum nisi eleifend neque aliquet nec ut consectetur nullam, dolor purus placerat enim ipsum dapibus platea rutrum lacus sem, aliquam senectus faucibus volutpat vitae arcu aptent a.\nHimenaeos ullamcorper viverra sapien accumsan ligula venenatis tellus, metus pretium aliquet velit varius taciti tristique sem, ut laoreet ac sed dolor nostra.\nMagna lacinia sem senectus ut tincidunt per mi blandit nam arcu, dictum ultricies vivamus iaculis aliquam nullam proin ullamcorper tempor massa facilisis, condimentum viverra molestie tristique molestie aliquam curae lacinia interdum euismod varius habitasse tempor mattis taciti habitasse.\nIaculis nisi ligula duis sociosqu morbi vestibulum non tincidunt curae, accumsan ornare imperdiet accumsan ultrices eleifend morbi leo nullam convallis, pulvinar tempor integer aliquam turpis tortor facilisis rhoncus.\n','2017-09-04 09:19:06'),(10,6,'CUSTOMER',NULL,'Codice fattura:  \nLorem ipsum sed accumsan etiam curabitur scelerisque condimentum sapien mollis habitasse, quisque pharetra commodo ligula primis dui quisque habitant consectetur volutpat cras quis vehicula vulputate accumsan vulputate nec magna est.\nEst hac posuere fringilla ligula egestas ac donec et risus mollis aliquet aliquam augue vulputate pharetra, integer curae et gravida mattis ultricies est tellus erat litora massa sed metus.\n','2017-09-04 09:20:47'),(12,8,'CUSTOMER',NULL,'Lorem ipsum imperdiet fringilla rutrum euismod consectetur mauris netus, velit hac integer auctor etiam rutrum id.\nFermentum est rutrum pellentesque mollis dapibus aliquet consequat netus, faucibus velit accumsan est inceptos sit luctus sociosqu, phasellus pulvinar cras tempor blandit massa tortor.\nVelit consequat cursus himenaeos curae ligula, euismod tortor proin molestie diam lobortis, duis etiam lobortis sem pulvinar sagittis fermentum a nisl magna tincidunt hac molestie, leo senectus aliquet sagittis vivamus pharetra.\nAptent est quis dapibus leo netus lorem taciti consequat imperdiet augue pretium, habitant nisl phasellus cursus sit curabitur massa taciti malesuada at conubia, enim commodo gravida accumsan commodo orci fames vel rhoncus sem.\nDapibus faucibus condimentum consectetur aenean habitasse tempor, faucibus sodales nec blandit id, malesuada aenean et metus suspendisse.\nDictumst aptent ac fusce leo class pulvinar luctus dolor, rutrum nec tortor nulla massa phasellus fermentum, sapien orci tempor ut accumsan eleifend proin.\n','2017-09-04 09:40:09'),(13,9,'CUSTOMER',NULL,'Prodotto coinvolto:  Water+\nLorem ipsum auctor fames ligula vulputate ut laoreet per cras, odio elit nisi lacinia sodales habitasse euismod venenatis taciti, faucibus porttitor nostra dictum enim donec mollis tellus placerat scelerisque nunc inceptos torquent sollicitudin.\nEtiam est neque malesuada pellentesque torquent iaculis morbi, pellentesque nisl vitae arcu tempor amet iaculis malesuada, nunc lectus faucibus magna donec nullam amet duis tempus rhoncus dictum maecenas dictum aliquet magna, purus non ac pharetra ullamcorper neque.\nCubilia consequat tincidunt curabitur in orci tempor accumsan tristique, sem est faucibus eros aenean neque porta quisque, eleifend mauris himenaeos tristique aptent ullamcorper potenti sit taciti quisque vel imperdiet facilisis curabitur imperdiet massa bibendum.\nPosuere erat varius quis adipiscing volutpat duis ut feugiat, molestie pharetra quis placerat nisi libero.\nInceptos ornare lobortis vel habitant ut aptent, commodo purus facilisis interdum sagittis tempus, erat maecenas nunc feugiat ut lobortis molestie felis urna.\n','2017-09-04 09:43:10'),(14,5,'OPERATOR',12,'Lorem ipsum imperdiet pellentesque tempus nibh nisl praesent in donec tristique amet placerat, cras egestas non ligula potenti consectetur varius vulputate feugiat per sit.\nFames curae amet ad aliquam ultrices placerat himenaeos quisque rutrum et libero tempus semper.\n','2017-09-04 09:44:02'),(15,3,'OPERATOR',12,'Lorem ipsum eleifend at diam faucibus ut curabitur, eleifend condimentum commodo ipsum consequat turpis integer, fames class velit ipsum sem consectetur.\nSuscipit phasellus tristique neque nam mollis congue dolor ut nunc facilisis, eleifend dictum phasellus fames varius massa facilisis euismod.\nFelis semper erat libero gravida a dui congue torquent auctor duis a, lacus aenean potenti habitant nulla maecenas tellus diam rutrum.\n','2017-09-04 09:44:55'),(16,5,'CUSTOMER',NULL,'Lorem ipsum fusce cursus urna sed sit, turpis sollicitudin nisi vulputate ante suscipit, mauris sollicitudin velit proin metus euismod ultrices nulla habitant suspendisse sed ac potenti, mi amet diam rutrum sodales cras consectetur placerat, nisi morbi torquent aenean convallis donec.\nOrnare amet velit primis donec vestibulum praesent placerat eget eleifend pellentesque nisi, elementum sit aenean aptent malesuada senectus magna amet phasellus malesuada ornare nibh et tristique vivamus ipsum litora sapien, facilisis condimentum commodo quisque semper cras malesuada.\nMagna eget cubilia mauris augue scelerisque justo ullamcorper cras, lobortis ornare vulputate potenti eleifend donec quisque.\nTorquent a sociosqu pellentesque sollicitudin taciti pellentesque sociosqu feugiat, ut bibendum cursus adipiscing quis euismod lorem class habitant, lacinia commodo sed habitant mauris purus cras elementum potenti tellus eu.\nArcu facilisis donec dui id at habitant senectus ultrices sit diam.\n','2017-09-04 09:46:07');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `progweb`.`messages_AFTER_INSERT` AFTER INSERT ON `messages` FOR EACH ROW
BEGIN
	declare ticket_status varchar(100);
    set ticket_status = if (new.type = 'CUSTOMER', 'PENDING', 'OPEN');
	update tickets set last_activity = CURRENT_TIMESTAMP, status = ticket_status where id = new.ticket;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `operators`
--

DROP TABLE IF EXISTS `operators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `recovery_token` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operators`
--

LOCK TABLES `operators` WRITE;
/*!40000 ALTER TABLE `operators` DISABLE KEYS */;
INSERT INTO `operators` VALUES (12,'admin','$2y$10$CcPievH0.T7fraXDMByfdu1Rd4gSNaEVDqbJ0h8huQ71L66uVbUEO','Andrea','Giove','andreagiove@outlook.com','2017-08-29 00:00:00',1,1,NULL),(13,'m.rossi','$2y$10$MfMJeqsSucZZvz1qEFSzXe.oWuI3jyFl.U5.sxIsHN1UoS2FNn.Gm','Mario','Rossi','m.rossi@prova.it',NULL,1,0,NULL);
/*!40000 ALTER TABLE `operators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_categories`
--

DROP TABLE IF EXISTS `ticket_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_categories`
--

LOCK TABLES `ticket_categories` WRITE;
/*!40000 ALTER TABLE `ticket_categories` DISABLE KEYS */;
INSERT INTO `ticket_categories` VALUES (1,'Fatturazione'),(2,'Guasto tecnico'),(3,'Servizio pubblicitario'),(5,'Altro');
/*!40000 ALTER TABLE `ticket_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_first_name` varchar(45) NOT NULL,
  `cust_last_name` varchar(45) NOT NULL,
  `cust_email` varchar(45) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `operator` int(11) DEFAULT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT '1',
  `status` enum('NEW','OPEN','PENDING','CLOSE') NOT NULL DEFAULT 'NEW',
  `open_at` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ticket_ticket_categories1_idx` (`category`),
  KEY `fk_tickets_users1_idx` (`operator`),
  KEY `ticket_status` (`status`),
  CONSTRAINT `fk_ticket_ticket_categories1` FOREIGN KEY (`category`) REFERENCES `ticket_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tickets_users1` FOREIGN KEY (`operator`) REFERENCES `operators` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (2,'Leonardo','Bianchi','l.bianchi@prova.it','Errore all\'avvio',2,NULL,1,'PENDING','2017-09-04 09:13:54','2017-09-04 09:13:54'),(3,'Sofia','Russo','sofia.russo@prova.it','Campagna pubblicitaria',3,12,0,'OPEN','2017-09-04 09:15:52','2017-09-04 09:44:55'),(4,'Giulia','Colombo','g.colombo83@prova.it','Interstatario errato',1,NULL,1,'PENDING','2017-09-04 09:18:07','2017-09-04 09:18:07'),(5,'Mattia','Gallo','mattia_gallo@prova.it','Errore inaspettato',2,12,2,'PENDING','2017-09-04 09:19:06','2017-09-04 09:46:07'),(6,'Gabriele','Rizzo','rizzo80@prova.it','Mancato invia della fattura',1,NULL,1,'PENDING','2017-09-04 09:20:47','2017-09-04 09:20:47'),(8,'Sara','Marino','s.marino@prova.it','Chiarificazioni sul prodotto',5,NULL,1,'PENDING','2017-09-04 09:40:09','2017-09-04 09:40:09'),(9,'Marco','Ferrari','m.ferrari@prova.it','Problema durante l\'installazione',2,NULL,1,'PENDING','2017-09-04 09:43:09','2017-09-04 09:43:10');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'progweb'
--

--
-- Dumping routines for database 'progweb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-04  9:50:54
