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
  `placeholder` varchar(124) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (6,2,'CUSTOMER',NULL,'Prodotto coinvolto:  Water+\nLorem ipsum volutpat magna mollis congue eget aptent enim odio nisl massa rutrum aliquam a ante sem facilisis porta in integer ut integer id phasellus nulla luctus, quis magna ultrices eleifend neque nunc suspendisse egestas vulputate ac vehicula vitae purus quam maecenas amet.\n\nEu curabitur eu nullam morbi venenatis habitasse etiam consequat ac, id habitant sit fusce cursus sollicitudin nullam eu vel, ullamcorper faucibus lorem ut tristique nibh quisque sem amet sit donec lobortis primis hendrerit tristique phasellus viverra augue pharetra nulla aptent nisl.\n','2017-09-04 09:13:54'),(7,3,'CUSTOMER',NULL,'Lorem ipsum nibh ante integer placerat mi torquent, suspendisse fringilla lacus blandit ut nulla nec, himenaeos pellentesque lectus suspendisse tempus lobortis urna netus hac curabitur aliquam inceptos viverra porttitor fermentum netus suspendisse quam himenaeos, aptent vivamus netus litora class fringilla ullamcorper sit hendrerit molestie.\nMassa at nibh ante fringilla inceptos nibh egestas fringilla torquent, massa viverra fusce purus ut dictum faucibus ac ad, nisl donec taciti etiam hendrerit turpis habitasse sollicitudin taciti fames tincidunt in nam lorem pellentesque turpis, potenti sit auctor aenean congue mollis, integer ante eros erat potenti ornare.\nMollis tristique in erat vehicula curabitur pulvinar sed fames tempus sem maecenas lobortis consectetur cubilia condimentum, morbi sapien fusce elementum mattis ante litora eget pellentesque sit est vestibulum mattis nisi nostra condimentum iaculis accumsan lobortis vel scelerisque risus nostra netus imperdiet ut suspendisse tellus.\n','2017-09-04 09:15:52'),(8,4,'CUSTOMER',NULL,'Codice fattura:  LT1234\nLorem ipsum bibendum ullamcorper pulvinar id sapien conubia fringilla justo rhoncus at torquent, vestibulum class suscipit aenean mattis primis vitae libero aenean dictumst urna auctor himenaeos cursus nisi ipsum tempus donec enim.\nNam himenaeos quisque torquent faucibus est egestas ligula aptent turpis, sagittis nibh laoreet tristique dictum diam libero ultricies at, fusce leo praesent justo tristique nisi in per fusce vehicula ante varius morbi.\n','2017-09-04 09:18:07'),(9,5,'CUSTOMER',NULL,'Prodotto coinvolto:  Sky Light\nLorem ipsum nisi eleifend neque aliquet nec ut consectetur nullam, dolor purus placerat enim ipsum dapibus platea rutrum lacus sem, aliquam senectus faucibus volutpat vitae arcu aptent a.\nHimenaeos ullamcorper viverra sapien accumsan ligula venenatis tellus, metus pretium aliquet velit varius taciti tristique sem, ut laoreet ac sed dolor nostra.\nMagna lacinia sem senectus ut tincidunt per mi blandit nam arcu, dictum ultricies vivamus iaculis aliquam nullam proin ullamcorper tempor massa facilisis, condimentum viverra molestie tristique molestie aliquam curae lacinia interdum euismod varius habitasse tempor mattis taciti habitasse.\nIaculis nisi ligula duis sociosqu morbi vestibulum non tincidunt curae, accumsan ornare imperdiet accumsan ultrices eleifend morbi leo nullam convallis, pulvinar tempor integer aliquam turpis tortor facilisis rhoncus.\n','2017-09-04 09:19:06'),(10,6,'CUSTOMER',NULL,'Codice fattura:  \nLorem ipsum sed accumsan etiam curabitur scelerisque condimentum sapien mollis habitasse, quisque pharetra commodo ligula primis dui quisque habitant consectetur volutpat cras quis vehicula vulputate accumsan vulputate nec magna est.\nEst hac posuere fringilla ligula egestas ac donec et risus mollis aliquet aliquam augue vulputate pharetra, integer curae et gravida mattis ultricies est tellus erat litora massa sed metus.\n','2017-09-04 09:20:47'),(12,8,'CUSTOMER',NULL,'Lorem ipsum imperdiet fringilla rutrum euismod consectetur mauris netus, velit hac integer auctor etiam rutrum id.\nFermentum est rutrum pellentesque mollis dapibus aliquet consequat netus, faucibus velit accumsan est inceptos sit luctus sociosqu, phasellus pulvinar cras tempor blandit massa tortor.\nVelit consequat cursus himenaeos curae ligula, euismod tortor proin molestie diam lobortis, duis etiam lobortis sem pulvinar sagittis fermentum a nisl magna tincidunt hac molestie, leo senectus aliquet sagittis vivamus pharetra.\nAptent est quis dapibus leo netus lorem taciti consequat imperdiet augue pretium, habitant nisl phasellus cursus sit curabitur massa taciti malesuada at conubia, enim commodo gravida accumsan commodo orci fames vel rhoncus sem.\nDapibus faucibus condimentum consectetur aenean habitasse tempor, faucibus sodales nec blandit id, malesuada aenean et metus suspendisse.\nDictumst aptent ac fusce leo class pulvinar luctus dolor, rutrum nec tortor nulla massa phasellus fermentum, sapien orci tempor ut accumsan eleifend proin.\n','2017-09-04 09:40:09'),(13,9,'CUSTOMER',NULL,'Prodotto coinvolto:  Water+\nLorem ipsum auctor fames ligula vulputate ut laoreet per cras, odio elit nisi lacinia sodales habitasse euismod venenatis taciti, faucibus porttitor nostra dictum enim donec mollis tellus placerat scelerisque nunc inceptos torquent sollicitudin.\nEtiam est neque malesuada pellentesque torquent iaculis morbi, pellentesque nisl vitae arcu tempor amet iaculis malesuada, nunc lectus faucibus magna donec nullam amet duis tempus rhoncus dictum maecenas dictum aliquet magna, purus non ac pharetra ullamcorper neque.\nCubilia consequat tincidunt curabitur in orci tempor accumsan tristique, sem est faucibus eros aenean neque porta quisque, eleifend mauris himenaeos tristique aptent ullamcorper potenti sit taciti quisque vel imperdiet facilisis curabitur imperdiet massa bibendum.\nPosuere erat varius quis adipiscing volutpat duis ut feugiat, molestie pharetra quis placerat nisi libero.\nInceptos ornare lobortis vel habitant ut aptent, commodo purus facilisis interdum sagittis tempus, erat maecenas nunc feugiat ut lobortis molestie felis urna.\n','2017-09-04 09:43:10'),(14,5,'OPERATOR',12,'Lorem ipsum imperdiet pellentesque tempus nibh nisl praesent in donec tristique amet placerat, cras egestas non ligula potenti consectetur varius vulputate feugiat per sit.\nFames curae amet ad aliquam ultrices placerat himenaeos quisque rutrum et libero tempus semper.\n','2017-09-04 09:44:02'),(15,3,'OPERATOR',12,'Lorem ipsum eleifend at diam faucibus ut curabitur, eleifend condimentum commodo ipsum consequat turpis integer, fames class velit ipsum sem consectetur.\nSuscipit phasellus tristique neque nam mollis congue dolor ut nunc facilisis, eleifend dictum phasellus fames varius massa facilisis euismod.\nFelis semper erat libero gravida a dui congue torquent auctor duis a, lacus aenean potenti habitant nulla maecenas tellus diam rutrum.\n','2017-09-04 09:44:55'),(16,5,'CUSTOMER',NULL,'Lorem ipsum fusce cursus urna sed sit, turpis sollicitudin nisi vulputate ante suscipit, mauris sollicitudin velit proin metus euismod ultrices nulla habitant suspendisse sed ac potenti, mi amet diam rutrum sodales cras consectetur placerat, nisi morbi torquent aenean convallis donec.\nOrnare amet velit primis donec vestibulum praesent placerat eget eleifend pellentesque nisi, elementum sit aenean aptent malesuada senectus magna amet phasellus malesuada ornare nibh et tristique vivamus ipsum litora sapien, facilisis condimentum commodo quisque semper cras malesuada.\nMagna eget cubilia mauris augue scelerisque justo ullamcorper cras, lobortis ornare vulputate potenti eleifend donec quisque.\nTorquent a sociosqu pellentesque sollicitudin taciti pellentesque sociosqu feugiat, ut bibendum cursus adipiscing quis euismod lorem class habitant, lacinia commodo sed habitant mauris purus cras elementum potenti tellus eu.\nArcu facilisis donec dui id at habitant senectus ultrices sit diam.\n','2017-09-04 09:46:07'),(17,5,'CUSTOMER',NULL,'Lorem ipsum a viverra convallis sociosqu risus diam duis gravida.\nPorttitor donec netus malesuada laoreet eleifend bibendum dictumst, felis sagittis sit etiam ultricies ante, consectetur adipiscing sed sodales inceptos sapien.\n','2017-09-04 10:10:08'),(18,10,'CUSTOMER',NULL,'Codice fattura:  MM0234\nLorem ipsum nec primis aptent torquent praesent enim fermentum.\nDui taciti hendrerit turpis nostra torquent nulla quam etiam venenatis, non potenti condimentum commodo hac maecenas taciti elit enim curae class congue cursus aenean arcu, ultrices amet aenean diam convallis integer laoreet curabitur, posuere pretium hac turpis donec lobortis.\nAd etiam ligula lacinia gravida phasellus orci gravida lacinia sed lacinia.\n','2017-09-04 10:25:16'),(19,11,'CUSTOMER',NULL,'Lorem ipsum morbi erat quam tempor platea neque, sagittis habitasse nullam mollis ornare et fermentum sociosqu, molestie mattis erat quis rhoncus sapien.\nNisl bibendum tellus habitant litora risus rhoncus sociosqu malesuada purus, himenaeos nec venenatis tempor mi rhoncus pulvinar egestas, aliquam quis primis dolor quam interdum nisi vehicula.\nPotenti scelerisque eros sem augue nullam conubia cursus nullam per.\n','2017-09-04 11:35:55'),(20,8,'OPERATOR',13,'Lorem ipsum class faucibus suscipit tincidunt eleifend viverra feugiat imperdiet, rutrum posuere cursus primis libero ornare dapibus quisque, consectetur quisque malesuada ipsum convallis mollis nisi per imperdiet condimentum feugiat dictumst vulputate nisl molestie suspendisse ultrices, netus nostra vivamus consequat justo at.\n','2017-09-05 14:00:11'),(21,12,'CUSTOMER',NULL,'Prodotto coinvolto:  Water+\nLorem ipsum elit tristique vehicula libero blandit rhoncus, porttitor amet ultrices nostra faucibus sagittis suspendisse nisi, condimentum consequat sem aliquet aptent sem orci tempus etiam fames.\nUt quisque donec ullamcorper magna ac purus inceptos ultrices rutrum conubia morbi, habitasse egestas enim nisl bibendum nullam posuere ac tempus.\nPorttitor quis torquent lobortis vehicula ligula ac turpis eget, nullam scelerisque rutrum bibendum vehicula aliquam ut, felis ultrices fermentum vulputate mauris lorem sagittis enim sagittis aenean nec et vivamus metus.\n','2017-09-05 14:04:23'),(24,14,'CUSTOMER',NULL,'More muttered together sensibly adequately and since dogged hardheadedly more wolf a crud in or against about tarantula that some ouch alas far oversold excepting dear much self-consciously black much nutria tragically until a sheep.\n\nExpansively gosh much desirable wiped yet one lethargically well impotent outside some affectionately this private after following tolerably amenable since.\n\nRavenously preparatory the about as hence far darn far well jauntily conclusive blubbered alas jeepers crud much but grimily then baneful far wanton dolphin.\n','2017-09-08 09:20:56'),(25,15,'CUSTOMER',NULL,'Prodotto coinvolto:  One Air\nLike coasted alas read rabbit far egret anteater mumbled amongst so more one far rhythmic badger bled rooster hello yikes the firefly vulnerably and this jeez darn immediately whimpered far that worm far alas shark.\nScallop this misread dachshund twitched owl and far unfitting eel muttered far faultily without that silently but the in far but beamed effectively groundhog the.\nA thus gibbered tamarin cockatoo greyhound rebukingly rooster labrador and onto vehemently impiously howled quetzal then hey against jeepers laggardly one strident unjustifiable tame wow before this intensely far bee depending far crud regretful.\n','2017-09-08 09:21:57'),(26,16,'CUSTOMER',NULL,'Codice fattura:  \nAgonizing ouch patted more much onto oyster well providently far locked grumbled dear winked that relentlessly plainly a because therefore hawk and.\nLess while alas laconically and fought much this stuck after yet until near a vaguely some until enormously dwelled more hence nutria warthog sparing human.\nPenguin and conscientiously porcupine jeez wow far crooked shark a inexhaustible remarkable irrational immediately hence a abandonedly in and hare much handsome winsomely forbade ouch pathetic away dear moaned.\n','2017-09-08 09:23:09'),(27,17,'CUSTOMER',NULL,'Macaw as careless rakishly more scratched a inescapable because through gosh daintily bright dalmatian additional prior where woodpecker that acutely crud opposite kangaroo ebulliently gawked much.\nAnd this turgid haltered marginal fanciful less wherever jeez ahead up cow laughing away awakened poured dear pessimistic cumulatively this far but inconspicuous weasel tartly some victoriously turbulently dear far less and ouch read.\nThis hen avowed reciprocating squid cowardly hopeful or reverently humorously normally and one one alas away lantern adamant regarding before grew astride the dug followed overlaid far a falcon trout inflexible ouch so.\n','2017-09-08 09:24:22'),(28,18,'CUSTOMER',NULL,'Prodotto coinvolto:  One Air\nStrange more anticipatively pending that darn mallard that with muttered sullen shamefully much.\nFar that coaxing nutria menially some then played dear crud temperate that this because much dealt subconscious on gosh more combed when sold until stared robin honey.\nSmugly placid far yellow and blew melodiously one hello tasteful depending far without purposefully that forecast excluding tenaciously outside as this hatchet jeez directed hello unicorn wedded amicably lizard dreamed dear.\n','2017-09-08 09:27:42'),(29,19,'CUSTOMER',NULL,'Lorem ipsum netus habitant ultricies vulputate turpis habitasse curabitur, faucibus integer cursus in et cursus hac nec, imperdiet sagittis pellentesque amet euismod nam et porttitor orci pharetra vel.\nLacinia turpis interdum ultricies fringilla quisque rutrum quisque ad sociosqu nostra pellentesque.\nCursus conubia congue ante nulla suscipit consequat litora felis eros, neque cubilia bibendum fames venenatis aliquam himenaeos torquent, hac nisl risus nam sed netus porta nisl.\n','2017-09-08 09:28:24'),(30,20,'CUSTOMER',NULL,'Codice fattura:  LL12333\nLorem ipsum curabitur fames non praesent nec metus aliquam leo lectus turpis sapien.\nUltricies velit sagittis porta maecenas condimentum urna ultrices, fermentum dapibus elit et eget ligula donec diam, purus magna blandit consectetur aenean amet.\nTincidunt primis aliquet donec primis ultricies praesent consectetur hac gravida viverra adipiscing.\n','2017-09-08 09:43:30'),(31,21,'CUSTOMER',NULL,'Lorem ipsum tempus faucibus hac ut mattis tristique a, ante interdum sociosqu aliquam faucibus pulvinar pellentesque nam, convallis tempus nullam sagittis interdum litora adipiscing.\nMi aptent diam metus rhoncus ut leo vehicula massa turpis interdum diam purus.\nVestibulum eleifend ultrices hac velit lobortis rutrum proin cubilia eros eget, vel nisl etiam pharetra sodales eget curabitur rutrum taciti varius, convallis donec dolor faucibus class etiam lectus id dapibus.\n','2017-09-08 09:44:15'),(32,22,'CUSTOMER',NULL,'Lorem ipsum quis venenatis ultricies placerat semper pulvinar donec viverra amet inceptos litora.\nNisl eros habitant class aptent phasellus blandit cras ornare ac elementum.\nAenean molestie enim pharetra lectus justo orci tortor donec ut tempus, eleifend nullam libero auctor nibh consequat diam sollicitudin felis, sodales vehicula tellus ultrices duis pretium aenean neque gravida.\n','2017-09-08 09:45:28'),(33,23,'CUSTOMER',NULL,'Codice fattura:  \nLorem ipsum facilisis leo lobortis malesuada neque diam suscipit ut gravida.\nMattis ornare sollicitudin tempor dapibus ornare mollis, cursus vitae consectetur ut ac interdum, eros mollis euismod pretium gravida.\nNunc morbi malesuada lectus sodales molestie proin felis diam habitant nullam, habitant bibendum aliquam pulvinar rhoncus tincidunt ligula purus rutrum, orci non sapien nec urna feugiat a vulputate iaculis.\n','2017-09-08 09:46:28'),(34,24,'CUSTOMER',NULL,'Lorem ipsum fringilla torquent ullamcorper duis integer suscipit aptent urna cras conubia.\nJusto hac rutrum eleifend aptent magna ligula gravida suscipit pulvinar porta netus fusce elementum, in adipiscing mattis commodo facilisis morbi feugiat dictum viverra dolor tempor proin.\nCurabitur taciti nibh cras mattis eu ut purus ut, facilisis vehicula elit iaculis bibendum euismod aptent eu, sed ornare velit fusce luctus at vivamus.\n','2017-09-08 09:47:44');
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
INSERT INTO `operators` VALUES (12,'admin','$2y$10$75DhgzZ8O6cfb11Ss/wh0.J6x.B2WLDs8YXzU73KyCRYvr6kTKR5C','Andrea','Giove','andreagiove@outlook.com','2017-08-29 00:00:00',1,1,NULL),(13,'m.rossi','$2y$10$70FLb3zOay695s1tKeRBEeC0lkb7X2oYvZxYUIroBLLmh3Kn.Hk0e','Mario','Rossi','m.rossi@prova.it',NULL,1,0,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_categories`
--

LOCK TABLES `ticket_categories` WRITE;
/*!40000 ALTER TABLE `ticket_categories` DISABLE KEYS */;
INSERT INTO `ticket_categories` VALUES (1,'Fatturazione'),(2,'Guasto tecnico'),(3,'Campagna pubblicitaria'),(5,'Altro');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (2,'Leonardo','Bianchi','l.bianchi@prova.it','Errore all\'avvio',2,NULL,1,'PENDING','2017-09-04 09:13:54','2017-09-04 09:13:54'),(3,'Sofia','Russo','sofia.russo@prova.it','Campagna pubblicitaria',3,12,1,'PENDING','2017-09-04 09:15:52','2017-09-04 09:44:55'),(4,'Giulia','Colombo','g.colombo83@prova.it','Interstatario errato',1,NULL,1,'PENDING','2017-09-04 09:18:07','2017-09-04 09:18:07'),(5,'Mattia','Gallo','mattia_gallo@prova.it','Errore inaspettato',2,12,2,'PENDING','2017-09-04 09:19:06','2017-09-04 10:10:08'),(6,'Gabriele','Rizzo','rizzo80@prova.it','Mancato invia della fattura',1,NULL,1,'PENDING','2017-09-04 09:20:47','2017-09-04 09:20:47'),(8,'Sara','Marino','s.marino@prova.it','Chiarificazioni sul prodotto',5,13,1,'OPEN','2017-09-04 09:40:09','2017-09-05 14:00:11'),(9,'Marco','Ferrari','m.ferrari@prova.it','Problema durante l\'installazione',2,NULL,1,'PENDING','2017-09-04 09:43:09','2017-09-04 09:43:10'),(10,'Riccardo','Romano','ric.rom@prova.it','Spiegazioni sulla fattura',1,NULL,1,'PENDING','2017-09-04 10:25:15','2017-09-04 10:25:16'),(11,'Andrea','Giove','andreagiove@outlook.com','Lorem ipsum adipiscing gravida amet sagittis conubia',5,NULL,1,'PENDING','2017-09-04 11:35:54','2017-09-04 11:35:55'),(12,'Davide','Conti','davide_conti@prova.it','Problema di connessione',2,NULL,1,'PENDING','2017-09-05 14:04:23','2017-09-05 14:04:23'),(14,'Martina','Costa','m.costa@prova.it','Lorem ipsum netus ad magna posuere accumsan.',5,NULL,1,'PENDING','2017-09-08 09:20:56','2017-09-08 09:20:56'),(15,'Leonardo','Fontana','l.fontana@prova.it','Lorem ipsum fusce cubilia metus.',2,NULL,1,'PENDING','2017-09-08 09:21:56','2017-09-08 09:21:57'),(16,'Diego','Bruno','diego_bruno@prova.it','Lorem ipsum ultrices duis elementum leo imperdiet condimentum placerat tortor ullamcorper conubia.',1,NULL,1,'PENDING','2017-09-08 09:23:09','2017-09-08 09:23:09'),(17,'Greta','De Luca','g.deluca@prova.it','Lorem ipsum ultrices aliquet mi malesuada pulvinar duis porta auctor himenaeos.',3,NULL,1,'PENDING','2017-09-08 09:24:22','2017-09-08 09:24:22'),(18,'Federico','Gentile','federico.gentile@prova.it','Platea varius amet porta vehicula',2,NULL,1,'PENDING','2017-09-08 09:27:42','2017-09-08 09:27:42'),(19,'Gaia','Vitale','g.vitale@prova.it','Mattis orci nunc sit ultricies',5,NULL,1,'PENDING','2017-09-08 09:28:24','2017-09-08 09:28:24'),(20,'Antonio','Esposito','a.esposito@prova.it','Consequat quisque cursus nec aenean quisque eros nam integer',1,NULL,1,'PENDING','2017-09-08 09:43:30','2017-09-08 09:43:30'),(21,'Ginevra','Russo','g.russo@prova.it','Curae enim suscipit lectus hac maecenas consequat viverra',3,NULL,1,'PENDING','2017-09-08 09:44:15','2017-09-08 09:44:15'),(22,'Filippo','Ricci','filippo_ricci@prova.it','Vel lorem feugiat congue ornare pretium curae varius ultricies',5,NULL,1,'PENDING','2017-09-08 09:45:28','2017-09-08 09:45:28'),(23,'Francesca','Mancini','f.mancini@prova.it','Rhoncus semper sodales quisque augue porta est blandit lacinia tincidunt',1,NULL,1,'PENDING','2017-09-08 09:46:28','2017-09-08 09:46:28'),(24,'Alessia','Giordano','a.giordano@prova.it','Dui aenean lobortis ad aliquet quisque vivamus amet',5,NULL,1,'PENDING','2017-09-08 09:47:44','2017-09-08 09:47:44');
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

-- Dump completed on 2017-09-08 10:31:35
