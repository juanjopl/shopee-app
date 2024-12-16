-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: db_tienda_segunda_mano
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `categoria`
--
CREATE DATABASE shopeedb;
USE shopeedb;

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `idCategoria` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE KEY `id_UNIQUE` (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Motor'),(2,'Moda y Accesorios'),(3,'Hogar y Jardín'),(4,'TV, Audio y Foto'),(5,'Telefonía'),(6,'Informática'),(7,'Inmobiliaria'),(8,'Empleo'),(9,'Formación y libros'),(10,'Servicios'),(11,'Juegos'),(12,'Videojuegos y Consolas'),(13,'Bebes'),(14,'Aficiones y Ocio'),(15,'Colecciones'),(16,'Deportes'),(17,'Mascota'),(18,'Otros');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotosproductos`
--

DROP TABLE IF EXISTS `fotosproductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fotosproductos` (
  `idFotoProducto` int NOT NULL AUTO_INCREMENT,
  `imagen` longblob,
  `idProducto` int NOT NULL,
  PRIMARY KEY (`idFotoProducto`),
  KEY `fk_fotosProductos_productos1_idx` (`idProducto`),
  CONSTRAINT `fk_fotosProductos_productos1` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotosproductos`
--

LOCK TABLES `fotosproductos` WRITE;
/*!40000 ALTER TABLE `fotosproductos` DISABLE KEYS */;
/*!40000 ALTER TABLE `fotosproductos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historicousuarios`
--

DROP TABLE IF EXISTS `historicousuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historicousuarios` (
  `idHistorico` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `passAntigua` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idHistorico`),
  UNIQUE KEY `id_UNIQUE` (`idHistorico`),
  KEY `fk_historicoUsuarios_usuarios1_idx` (`idUsuario`),
  CONSTRAINT `fk_historicoUsuarios_usuarios1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historicousuarios`
--

LOCK TABLES `historicousuarios` WRITE;
/*!40000 ALTER TABLE `historicousuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `historicousuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opiniones`
--

DROP TABLE IF EXISTS `opiniones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opiniones` (
  `idOpiniones` int NOT NULL AUTO_INCREMENT,
  `valoracion` int DEFAULT NULL,
  `mensaje` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fechaOpinion` datetime DEFAULT NULL,
  `idProducto` int NOT NULL,
  `idUsuarioOpinion` int NOT NULL,
  PRIMARY KEY (`idOpiniones`),
  KEY `fk_opiniones_usuarios1_idx` (`idUsuarioOpinion`),
  KEY `fk_valoraciones_productos2_idx` (`idProducto`),
  CONSTRAINT `fk_opiniones_usuarios1` FOREIGN KEY (`idUsuarioOpinion`) REFERENCES `usuarios` (`idUsuario`),
  CONSTRAINT `fk_valoraciones_productos2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opiniones`
--

LOCK TABLES `opiniones` WRITE;
/*!40000 ALTER TABLE `opiniones` DISABLE KEYS */;
/*!40000 ALTER TABLE `opiniones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `idProducto` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `descripcion` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `estado` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `precio` int DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idVendedor` int NOT NULL,
  `idComprador` int DEFAULT NULL,
  `idCategoria` int NOT NULL,
  `idSubcategoria` int NOT NULL,
  `estadoProducto` enum('reservado','negociacion-1','negociacion-2','negociacion-3','comprado','activo') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `oferta` int DEFAULT NULL,
  PRIMARY KEY (`idProducto`),
  UNIQUE KEY `id_UNIQUE` (`idProducto`),
  KEY `fk_productos_usuarios_idx` (`idVendedor`),
  KEY `fk_productos_usuarios1_idx` (`idComprador`),
  KEY `fk_productos_categoria1_idx` (`idCategoria`),
  KEY `fk_productos_subcategoria1_idx` (`idSubcategoria`),
  CONSTRAINT `fk_productos_categoria1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  CONSTRAINT `fk_productos_comprador` FOREIGN KEY (`idComprador`) REFERENCES `usuarios` (`idUsuario`),
  CONSTRAINT `fk_productos_subcategoria1` FOREIGN KEY (`idSubcategoria`) REFERENCES `subcategoria` (`idSubcategoria`),
  CONSTRAINT `fk_productos_vendedor` FOREIGN KEY (`idVendedor`) REFERENCES `usuarios` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategoria`
--

DROP TABLE IF EXISTS `subcategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategoria` (
  `idSubcategoria` int NOT NULL AUTO_INCREMENT,
  `idCategoria` int NOT NULL,
  `descripcion` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idSubcategoria`),
  KEY `fk_subcategoria_categoria2_idx` (`idCategoria`),
  CONSTRAINT `fk_subcategoria_categoria2` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategoria`
--

LOCK TABLES `subcategoria` WRITE;
/*!40000 ALTER TABLE `subcategoria` DISABLE KEYS */;
INSERT INTO `subcategoria` VALUES (1,1,'Coches'),(2,1,'Motos'),(3,1,'Caravanas'),(4,1,'Furgonetas'),(5,1,'Remolques'),(6,1,'Piezas'),(7,1,'Accesorios'),(8,1,'Otros'),(9,2,'Camisas'),(10,2,'Pantalones'),(11,2,'Camisetas'),(12,2,'Sudaderas'),(13,2,'Jerseys'),(14,2,'Chaquetas'),(15,2,'Abrigos'),(16,2,'Calzados'),(17,2,'Accesorios'),(18,2,'Otros'),(19,3,'Sillas'),(20,3,'Mesas'),(21,3,'Armarios'),(22,3,'Sofas'),(23,3,'Somieres'),(24,3,'Cajones'),(25,3,'Estanterías'),(26,3,'Hamacas'),(27,3,'Decoraciones'),(28,3,'Piscinas hinchables'),(29,3,'Bricolaje'),(30,3,'Otros'),(31,4,'Televisiones'),(32,4,'Altavoces'),(33,4,'Radios'),(34,4,'Cámaras'),(35,4,'Proyectores'),(36,4,'Piezas / recambios'),(37,4,'Otros'),(38,5,'Smartphones'),(39,5,'Tablets'),(40,5,'Cargadores'),(41,5,'Fundas'),(42,5,'Teléfonos fijo'),(43,5,'Fax'),(44,5,'Otros'),(45,6,'Portátiles'),(46,6,'Ordenadores de sobremesa'),(47,6,'Impresoras'),(48,6,'Monitores'),(49,6,'Componentes'),(50,6,'Periféricos'),(51,6,'Software'),(52,6,'Otros'),(53,7,'Alquiler/venta de viviendas'),(54,7,'Alquiler/venta de locales'),(55,7,'Alquiler/venta de oficinas'),(56,7,'Alquiler/venta de garajes'),(57,7,'Alquiler/venta de trasteros'),(58,7,'Alquiler vacacional'),(59,7,'Otros'),(60,8,'Necesidad de personal'),(61,8,'Otros'),(62,9,'Clases particulares'),(63,9,'Autoescuela'),(64,9,'Cursos de idiomas'),(65,9,'Libros'),(66,9,'Libros escolares'),(67,9,'Apuntes univerisatios'),(68,9,'Otros'),(69,10,'Para la persona'),(70,10,'Para el hogar'),(71,10,'Para el trabajo'),(72,10,'Para el motor'),(73,10,'Otros'),(74,11,'Juguetes'),(75,11,'Juegos de mesa'),(76,11,'Juegos de bar'),(77,11,'Otros'),(78,12,'Videojuegos'),(79,12,'Consolas'),(80,12,'Mandos'),(81,12,'Accesorios'),(82,12,'Productos exclusivos'),(83,12,'Otros'),(84,13,'Cunas'),(85,13,'Tronas'),(86,13,'Accesorios'),(87,13,'Juguetes'),(88,13,'Silla de paseo'),(89,13,'Cochecitos'),(90,13,'Higiene y cuidado'),(91,13,'Otros'),(92,14,'Casa rural'),(93,14,'Puenting'),(94,14,'Airsoft'),(95,14,'Surf'),(96,14,'Montañismo'),(97,14,'Drones'),(98,14,'Caza'),(99,14,'Pesca'),(100,14,'Coches teledirigidos'),(101,14,'Otros'),(102,15,'Cuadros'),(103,15,'Cartas'),(104,15,'Dedales'),(105,15,'Monedas'),(106,15,'Billetes'),(107,15,'Decoraciones'),(108,15,'Otros'),(109,16,'Ropa deportiva'),(110,16,'Maquinaria deportiva'),(111,16,'Raquetas, balones, pelotas...'),(112,16,'Otros'),(113,17,'Accesorios'),(114,17,'Higiene'),(115,17,'Comida'),(116,17,'Juguetes'),(117,17,'Servicios de cuidado'),(118,17,'Otros'),(119,18,'Otro tipo de productos');
/*!40000 ALTER TABLE `subcategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `apellido1` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `apellido2` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fechaNac` date DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `estado` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `perfil` int DEFAULT NULL,
  `avatar` longblob,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `id_UNIQUE` (`idUsuario`),
  UNIQUE KEY `usuario_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-10 13:36:52
