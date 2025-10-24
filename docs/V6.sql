CREATE DATABASE  IF NOT EXISTS `acai` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `acai`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: acai
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `cadastro_usuarios`
--

DROP TABLE IF EXISTS `cadastro_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cadastro_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_usuario` enum('cliente','admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cliente',
  `endereco` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `referencia` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cadastro_usuarios`
--

LOCK TABLES `cadastro_usuarios` WRITE;
/*!40000 ALTER TABLE `cadastro_usuarios` DISABLE KEYS */;
INSERT INTO `cadastro_usuarios` VALUES (3,'Teste 1','teste@teste.com','$2y$10$K90PQL/dYFjdpARWv7SRCuDzly91BfgekGc4v9AyXJVlyWSD7rnFG','admin','Rua Teste','Teste','1','Teste',NULL),(4,'Cliente 1','cliente@cliente.com','$2y$10$AH7sukykT/gVQzB5/Rn0x.n9ZuDUwl59B3Zu9hDoT1XQ/DE7iUZT2','cliente','Rua Cliente','Cliente','1','Cliente',NULL);
/*!40000 ALTER TABLE `cadastro_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enderecos`
--

DROP TABLE IF EXISTS `enderecos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enderecos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `cep` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `bairro` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `endereco` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `numero` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `referencia` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `cadastro_usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enderecos`
--

LOCK TABLES `enderecos` WRITE;
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `em_estoque` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes`
--

LOCK TABLES `ingredientes` WRITE;
/*!40000 ALTER TABLE `ingredientes` DISABLE KEYS */;
INSERT INTO `ingredientes` VALUES (1,'300 ml',15.00,'tamanho_copo',1),(2,'400 ml',18.00,'tamanho_copo',1),(3,'500 ml',21.00,'tamanho_copo',1),(4,'500 ml',22.00,'tamanho_marmita',1),(5,'770 ml',35.00,'tamanho_marmita',1),(6,'Paçoca',0.00,'complemento_gratis',1),(7,'Leite em pó',0.00,'complemento_gratis',1),(8,'Confete',0.00,'complemento_gratis',1),(9,'Granola',0.00,'complemento_gratis',1),(10,'Granulado',0.00,'complemento_gratis',1),(11,'Banana',0.00,'complemento_gratis',1),(12,'Chocoball',0.00,'complemento_gratis',1),(13,'Gotas de chocolate',0.00,'complemento_gratis',1),(14,'Mel',0.00,'complemento_gratis',1),(15,'Leite condensado',0.00,'complemento_gratis',1),(16,'Amendoim torrado',0.00,'complemento_gratis',1),(17,'Cobertura de morango',0.00,'complemento_gratis',1),(18,'Cobertura de chocolate',0.00,'complemento_gratis',1),(19,'Cobertura de uva',0.00,'complemento_gratis',1),(20,'Cobertura de caramelo',0.00,'complemento_gratis',1),(21,'Bis',2.00,'adicional_pago',1),(22,'Ovomaltine',3.00,'adicional_pago',1),(23,'Sucrilhos',3.00,'adicional_pago',1),(24,'Morango',3.00,'adicional_pago',1),(25,'Uva',3.00,'adicional_pago',1),(26,'Manga',3.00,'adicional_pago',1),(27,'Creme de ninho',3.50,'adicional_pago',1),(28,'Creme de avelã',3.00,'adicional_pago',1),(29,'Creme de morango',4.00,'adicional_pago',1),(30,'Creme de amendoim',3.00,'adicional_pago',1),(31,'Creme de bombom',3.00,'adicional_pago',1),(32,'Jujuba',3.00,'adicional_pago',1);
/*!40000 ALTER TABLE `ingredientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_itens`
--

DROP TABLE IF EXISTS `pedido_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido_itens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tamanho` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complementos` text COLLATE utf8mb4_general_ci,
  `adicionais` text COLLATE utf8mb4_general_ci,
  `observacao` text COLLATE utf8mb4_general_ci,
  `valor_item` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  CONSTRAINT `pedido_itens_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_itens`
--

LOCK TABLES `pedido_itens` WRITE;
/*!40000 ALTER TABLE `pedido_itens` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido_itens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `tipo_entrega` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Em preparação',
  `data_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `cadastro_usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-24 19:47:31
