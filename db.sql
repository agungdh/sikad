-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: 127.0.0.1	Database: sikad
-- ------------------------------------------------------
-- Server version 	5.5.5-10.3.17-MariaDB-0ubuntu0.19.04.1
-- Date: Sat, 05 Oct 2019 11:23:55 +0700

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matkul`
--

LOCK TABLES `matkul` WRITE;
/*!40000 ALTER TABLE `matkul` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `matkul` VALUES (1,'MPK020418','Pendidikan Agama'),(2,'MKK020218','Konsep Sistem Informasi'),(3,'MKK021718','Akuntansi'),(4,'MKK020118','Algoritma dan Pemrograman '),(5,'MPK020518','Bahasa Indonesia'),(6,'MKK022118','Prak algoritma & pemrog'),(7,'MPK020318','PKN'),(8,'MKK022018','Kalkulus'),(9,'MPK020118','Bahasa Inggris 1'),(10,'MKB020418','Perencanaan Sistem Informasi'),(11,'MKK020618','Sistem Basis Data'),(12,'MKB021718','Keamanan JarKom'),(13,'MKB021018','E-Bisnis'),(14,'MKB020118','Analisis Proses Bisnis'),(15,'MKK021318','Struktur Data'),(16,'MKB020518','Pemrograman Web '),(17,'MKB020503','Perancangan Sistem Informasi'),(18,'MKK020616','Keamanan Komputer'),(19,'MKB020606','Pemrograman Orientasi Objek'),(20,'MKK020718','Audit Sistem Informasi'),(21,'MKB020911','E-Bisnis'),(22,'MKK020819','Metode Penelitian'),(23,'MKB038216','Pengembangan E Bisnis'),(24,'MBB020901','Kerja Praktek'),(25,'MKB020810','Keamanan Jaringan Komputer'),(26,'MKB020809','Sistem Penunjang Keputusan'),(27,'MBB021002','Skripsi');
/*!40000 ALTER TABLE `matkul` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `matkul` with 27 row(s)
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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosen`
--

LOCK TABLES `dosen` WRITE;
/*!40000 ALTER TABLE `dosen` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dosen` VALUES (1,'026065502','ANJAR SULASTIONO'),(2,'0224117302','ANTO PURWO SANTOSO'),(3,'0227048201',' Apri Candra W,S.Kom., M.T.I'),(4,'0205058203','DWI KARYAWATI'),(5,'021106830','EKA GERHAYU'),(6,'0215057201','EUIS MUSTIKA PRIYANGANTI'),(7,'0203058701','HERI NURDIYANTO, S.Kom,M.T.I'),(8,'017047501','ISMALIA AFRIANI'),(9,'024117304','KURNIAWAN SAPUTRA'),(10,'0206047803','KUSWANTO'),(11,'0208028401','M. Nur Ikhsanto, S.Kom, M.T.I'),(12,'030035705','MACHUDOR YUSMAN M'),(13,'0204107701','NINING ISTI UTAMI'),(14,'0210107002','R EKA GRALESMANA'),(15,'0206108304','REFLI DWIYANA'),(16,'0204077902','Ridwan Yusuf, S.T, M.T.I'),(17,'0214098501','SEPTIAN DICKY CHANDRA, S.Si,M.T.I'),(18,'0207098101','SUKRI ADI UTAMA'),(19,'0210078301','Surono,S.Kom,M.T.I'),(20,'020016601','SYAFIUDDIN'),(21,'0216128403','TANFII DIAN ROHMAN'),(22,'0211018601','Tri Aristi Saputri, S.Kom., M.T.I'),(23,'0219047601','Untoro Apsiswanto, S.T., M.T.I'),(24,'002','Suprianto, S.Kom, M.T.I'),(25,'001','ROHANIA, S.Pd, M.Pd'),(26,'004004136','Benny Nurdianto, S.Kom'),(27,'0221038402','Budi Sutomo, S.Kom, M.T.I'),(28,'0214118604','M. Reza Redo Islami, S.Kom, M.T.I'),(29,'016','RIRIN WIDIANINGRUM, M.Pd, M.M'),(30,'006','Jevan Nelson, S.Kom'),(31,'004','Irfan Nur Afni, ST., M.T.I'),(32,'0225058601','M. Adie Syaputra, S.Kom, M.T.I'),(33,'0220048704','NIZAMIYATI, S.Kom,M.Ti'),(34,'007','JUNI BAYU, S.Pd,M.Pd'),(35,'008','Arif Ismunandar, MM'),(36,'0226098502','Sita Muharni, S.Kom., M.T.I'),(37,'010','Drs. Wardaya, M.Pd'),(38,'011','Haris Setiaji, S.Kom, M.T.I'),(39,'012','Zainuddin, ST., M.T.I'),(40,'004026267','median satria'),(41,'004101152','EKA GUSTINA SARI'),(42,'004015227','Tri Budi Hartono, S.Kom'),(43,'013','Ayu Umaka, SE,MM'),(44,'014','Ade Sukma Arum, S,Pd'),(45,'015','Ade Sanjaya, MM'),(46,'017','MUHAJIR, S.Kom.i'),(47,'018','BIGI UNDADRAJA, S.TP,M.Si'),(48,'019','Ambar Pristia Rini, M.Pd'),(49,'020','Andreas Perdana, S.Kom, M.T.I'),(50,'021','YULDIKA PRASETYA'),(51,'082176099413','Bintang Ubamnata'),(52,'022','Yuspa Fitri Meza,S.Pd');
/*!40000 ALTER TABLE `dosen` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dosen` with 52 row(s)
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal`
--

LOCK TABLES `jadwal` WRITE;
/*!40000 ALTER TABLE `jadwal` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `jadwal` VALUES (1,35,3,'1SI M1','Selasa','18 : 30 - 20:00','B II','2019/2020 S1'),(2,35,3,'1SI P1','Rabu','10 : 00 - 11:30','B I','2019/2020 S1'),(3,35,3,'1SI P1','Kamis','13 : 00 - 14:30','A VI','2019/2020 S1'),(4,35,3,'1SI M1','Kamis','20 : 00 - 21:30','B I','2019/2020 S1'),(5,28,26,'7SI P1','Selasa','15 : 00 - 16:30','B I','2019/2020 S1'),(6,28,26,'7SI P1','Kamis','15 : 00 - 16:30','B II','2019/2020 S1');
/*!40000 ALTER TABLE `jadwal` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `jadwal` with 6 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Sat, 05 Oct 2019 11:23:55 +0700
