-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: 127.0.0.1	Database: sikad
-- ------------------------------------------------------
-- Server version 	5.5.5-10.3.17-MariaDB-0ubuntu0.19.04.1
-- Date: Fri, 04 Oct 2019 11:37:50 +0700

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
-- Table structure for table `matkul`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matkul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(191) NOT NULL,
  `matkul` varchar(191) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matkul`
--

LOCK TABLES `matkul` WRITE;
/*!40000 ALTER TABLE `matkul` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `matkul` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `matkul` with 0 row(s)
--

--
-- Table structure for table `dosen`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dosen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nidn` varchar(191) NOT NULL,
  `nama` varchar(191) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nidn` (`nidn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosen`
--

LOCK TABLES `dosen` WRITE;
/*!40000 ALTER TABLE `dosen` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `dosen` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dosen` with 0 row(s)
--

--
-- Table structure for table `jadwal`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dosen` int(11) NOT NULL,
  `id_matkul` int(11) NOT NULL,
  `kelas` varchar(191) NOT NULL,
  `hari` varchar(191) NOT NULL,
  `waktu` varchar(191) NOT NULL,
  `ruangan` varchar(191) NOT NULL,
  `semester` varchar(191) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dosen` (`id_dosen`),
  KEY `id_matkul` (`id_matkul`),
  CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id`),
  CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_matkul`) REFERENCES `matkul` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal`
--

LOCK TABLES `jadwal` WRITE;
/*!40000 ALTER TABLE `jadwal` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `jadwal` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `jadwal` with 0 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Fri, 04 Oct 2019 11:37:50 +0700
