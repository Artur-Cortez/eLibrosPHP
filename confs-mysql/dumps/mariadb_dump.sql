-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: db    Database: mariadb
-- ------------------------------------------------------
-- Server version	10.4.34-MariaDB-1:10.4.34+maria~ubu2004

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
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo` enum('ADM','FUN') DEFAULT 'ADM',
  `rg` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_administrador_user` (`id_usuario`),
  CONSTRAINT `fk_administrador_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autor`
--

DROP TABLE IF EXISTS `autor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_autor_user` (`id_usuario`),
  CONSTRAINT `fk_autor_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autor`
--

LOCK TABLES `autor` WRITE;
/*!40000 ALTER TABLE `autor` DISABLE KEYS */;
/*!40000 ALTER TABLE `autor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autor_historico`
--

DROP TABLE IF EXISTS `autor_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autor_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor_id` int(11) NOT NULL,
  `tipo_alteracao` enum('1','2','3') NOT NULL,
  `detalhes` text DEFAULT NULL,
  `data_alteracao` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_autor_historico_autor` (`autor_id`),
  KEY `fk_autor_historico_user` (`id_usuario`),
  CONSTRAINT `fk_autor_historico_autor` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_autor_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autor_historico`
--

LOCK TABLES `autor_historico` WRITE;
/*!40000 ALTER TABLE `autor_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `autor_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinho`
--

DROP TABLE IF EXISTS `carrinho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `total` decimal(5,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `fk_carrinho_cliente` (`cliente_id`),
  CONSTRAINT `fk_carrinho_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinho`
--

LOCK TABLES `carrinho` WRITE;
/*!40000 ALTER TABLE `carrinho` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrinho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria_historico`
--

DROP TABLE IF EXISTS `categoria_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `tipo_alteracao` enum('1','2','3') NOT NULL,
  `detalhes` text DEFAULT NULL,
  `data_alteracao` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria_historico_categoria` (`categoria_id`),
  KEY `fk_categoria_historico_user` (`id_usuario`),
  CONSTRAINT `fk_categoria_historico_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_categoria_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_historico`
--

LOCK TABLES `categoria_historico` WRITE;
/*!40000 ALTER TABLE `categoria_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `endereco_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_user` (`id_usuario`),
  KEY `fk_cliente_endereco` (`endereco_id`),
  CONSTRAINT `fk_cliente_endereco` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_cliente_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupom`
--

DROP TABLE IF EXISTS `cupom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cupom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `tipo_valor` enum('1','2') NOT NULL DEFAULT '1',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupom`
--

LOCK TABLES `cupom` WRITE;
/*!40000 ALTER TABLE `cupom` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupom_historico`
--

DROP TABLE IF EXISTS `cupom_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cupom_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cupom_id` int(11) NOT NULL,
  `tipo_alteracao` enum('1','2','3') NOT NULL,
  `detalhes` text DEFAULT NULL,
  `data_alteracao` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cupom_historico_cupom` (`cupom_id`),
  KEY `fk_cupom_historico_user` (`id_usuario`),
  CONSTRAINT `fk_cupom_historico_cupom` FOREIGN KEY (`cupom_id`) REFERENCES `cupom` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cupom_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupom_historico`
--

LOCK TABLES `cupom_historico` WRITE;
/*!40000 ALTER TABLE `cupom_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupom_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco`
--

DROP TABLE IF EXISTS `endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cep` varchar(9) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` int(11) NOT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `identificacao` varchar(30) DEFAULT 'Endereço',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco`
--

LOCK TABLES `endereco` WRITE;
/*!40000 ALTER TABLE `endereco` DISABLE KEYS */;
/*!40000 ALTER TABLE `endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genero_literario`
--

DROP TABLE IF EXISTS `genero_literario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genero_literario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genero_literario`
--

LOCK TABLES `genero_literario` WRITE;
/*!40000 ALTER TABLE `genero_literario` DISABLE KEYS */;
/*!40000 ALTER TABLE `genero_literario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genero_literario_historico`
--

DROP TABLE IF EXISTS `genero_literario_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genero_literario_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genero_id` int(11) NOT NULL,
  `tipo_alteracao` enum('1','2','3') NOT NULL,
  `detalhes` text DEFAULT NULL,
  `data_alteracao` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_genero_literario_historico_genero` (`genero_id`),
  KEY `fk_genero_literario_historico_user` (`id_usuario`),
  CONSTRAINT `fk_genero_literario_historico_genero` FOREIGN KEY (`genero_id`) REFERENCES `genero_literario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_genero_literario_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genero_literario_historico`
--

LOCK TABLES `genero_literario_historico` WRITE;
/*!40000 ALTER TABLE `genero_literario_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `genero_literario_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_carrinho`
--

DROP TABLE IF EXISTS `item_carrinho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_carrinho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(5,2) NOT NULL,
  `carrinho_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_carrinho_livro` (`livro_id`),
  KEY `fk_item_carrinho_carrinho` (`carrinho_id`),
  CONSTRAINT `fk_item_carrinho_carrinho` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinho` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_item_carrinho_livro` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_carrinho`
--

LOCK TABLES `item_carrinho` WRITE;
/*!40000 ALTER TABLE `item_carrinho` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_carrinho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro`
--

DROP TABLE IF EXISTS `livro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `subtitulo` varchar(200) DEFAULT NULL,
  `data_de_publicacao` date DEFAULT NULL,
  `ano_de_publicacao` int(11) NOT NULL,
  `capa` varchar(255) DEFAULT NULL,
  `ISBN` varchar(15) NOT NULL,
  `sinopse` text DEFAULT NULL,
  `editora` varchar(100) DEFAULT 'Editora não informada',
  `preco` decimal(5,2) NOT NULL DEFAULT 0.00,
  `desconto` decimal(5,2) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `qtd_vendidos` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ISBN` (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro`
--

LOCK TABLES `livro` WRITE;
/*!40000 ALTER TABLE `livro` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_autor`
--

DROP TABLE IF EXISTS `livro_autor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_autor` (
  `livro_id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  PRIMARY KEY (`livro_id`,`autor_id`),
  KEY `fk_livro_autor_autor` (`autor_id`),
  CONSTRAINT `fk_livro_autor_autor` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_autor_livro` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_autor`
--

LOCK TABLES `livro_autor` WRITE;
/*!40000 ALTER TABLE `livro_autor` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_autor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_autor_historico`
--

DROP TABLE IF EXISTS `livro_autor_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_autor_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `tipo_alteracao` enum('1','2','3') NOT NULL,
  `detalhes` text DEFAULT NULL,
  `data_alteracao` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_livro_autor_historico_livro` (`livro_id`),
  KEY `fk_livro_autor_historico_autor` (`autor_id`),
  KEY `fk_livro_autor_historico_user` (`id_usuario`),
  CONSTRAINT `fk_livro_autor_historico_autor` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_autor_historico_livro` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_autor_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_autor_historico`
--

LOCK TABLES `livro_autor_historico` WRITE;
/*!40000 ALTER TABLE `livro_autor_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_autor_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_categoria`
--

DROP TABLE IF EXISTS `livro_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_categoria` (
  `livro_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`livro_id`,`categoria_id`),
  KEY `fk_livro_categoria_categoria` (`categoria_id`),
  CONSTRAINT `fk_livro_categoria_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_categoria_livro` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_categoria`
--

LOCK TABLES `livro_categoria` WRITE;
/*!40000 ALTER TABLE `livro_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_categoria_historico`
--

DROP TABLE IF EXISTS `livro_categoria_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_categoria_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `tipo_alteracao` enum('1','2','3') NOT NULL,
  `detalhes` text DEFAULT NULL,
  `data_alteracao` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_livro_categoria_historico_livro` (`livro_id`),
  KEY `fk_livro_categoria_historico_categoria` (`categoria_id`),
  KEY `fk_livro_categoria_historico_user` (`id_usuario`),
  CONSTRAINT `fk_livro_categoria_historico_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_categoria_historico_livro` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_categoria_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_categoria_historico`
--

LOCK TABLES `livro_categoria_historico` WRITE;
/*!40000 ALTER TABLE `livro_categoria_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_categoria_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_genero`
--

DROP TABLE IF EXISTS `livro_genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_genero` (
  `livro_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL,
  PRIMARY KEY (`livro_id`,`genero_id`),
  KEY `fk_livro_genero_genero` (`genero_id`),
  CONSTRAINT `fk_livro_genero_genero` FOREIGN KEY (`genero_id`) REFERENCES `genero_literario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_genero_livro` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_genero`
--

LOCK TABLES `livro_genero` WRITE;
/*!40000 ALTER TABLE `livro_genero` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_genero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_genero_literario_historico`
--

DROP TABLE IF EXISTS `livro_genero_literario_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_genero_literario_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo_alteracao` enum('1','2','3') NOT NULL,
  `detalhes` text DEFAULT NULL,
  `data_alteracao` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_livro_genero_literario_historico_livro` (`livro_id`),
  KEY `fk_livro_genero_literario_historico_genero` (`genero_id`),
  KEY `fk_livro_genero_literario_historico_user` (`id_usuario`),
  CONSTRAINT `fk_livro_genero_literario_historico_genero` FOREIGN KEY (`genero_id`) REFERENCES `genero_literario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_genero_literario_historico_livro` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_genero_literario_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_genero_literario_historico`
--

LOCK TABLES `livro_genero_literario_historico` WRITE;
/*!40000 ALTER TABLE `livro_genero_literario_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_genero_literario_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro_historico`
--

DROP TABLE IF EXISTS `livro_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livro_historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_id` int(11) NOT NULL,
  `tipo_alteracao` enum('1','2','3') NOT NULL,
  `detalhes` text DEFAULT NULL,
  `data_alteracao` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_livro_historico_livro` (`livro_id`),
  KEY `fk_livro_historico_user` (`id_usuario`),
  CONSTRAINT `fk_livro_historico_livro` FOREIGN KEY (`livro_id`) REFERENCES `livro` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_livro_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro_historico`
--

LOCK TABLES `livro_historico` WRITE;
/*!40000 ALTER TABLE `livro_historico` DISABLE KEYS */;
/*!40000 ALTER TABLE `livro_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `numero_pedido` varchar(12) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `endereco_id` int(11) NOT NULL,
  `status_pedido` enum('PRO','CAN','CON','ENV','ENT') NOT NULL DEFAULT 'PRO',
  `data_de_pedido` datetime NOT NULL,
  `entrega_estimada` datetime NOT NULL,
  `data_de_entrega` datetime NOT NULL,
  `valor_total` decimal(5,2) NOT NULL DEFAULT 0.00,
  `desconto` decimal(5,2) DEFAULT 0.00,
  `quantia_itens` int(11) NOT NULL DEFAULT 0,
  `cupom_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`numero_pedido`),
  KEY `fk_pedido_cupom` (`cupom_id`),
  KEY `fk_pedido_cliente` (`cliente_id`),
  KEY `fk_pedido_endereco` (`endereco_id`),
  CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pedido_cupom` FOREIGN KEY (`cupom_id`) REFERENCES `cupom` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_pedido_endereco` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_item`
--

DROP TABLE IF EXISTS `pedido_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_item` (
  `pedido_id` varchar(12) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`pedido_id`,`item_id`),
  KEY `fk_pedido_item_item` (`item_id`),
  CONSTRAINT `fk_pedido_item_item` FOREIGN KEY (`item_id`) REFERENCES `item_carrinho` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pedido_item_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`numero_pedido`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_item`
--

LOCK TABLES `pedido_item` WRITE;
/*!40000 ALTER TABLE `pedido_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `CPF` varchar(11) DEFAULT NULL,
  `foto_de_perfil` varchar(255) DEFAULT NULL,
  `genero` enum('F','M','NB','PND','NI') DEFAULT 'NI',
  `data_de_nascimento` date DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `CPF` (`CPF`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-22 18:33:50
