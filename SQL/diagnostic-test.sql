-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla diagnostic-test.branches
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `id_warehouse` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_warehouse` (`id_warehouse`),
  CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`id_warehouse`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla diagnostic-test.branches: ~0 rows (aproximadamente)
INSERT INTO `branches` (`id`, `name`, `id_warehouse`) VALUES
	(1, 'Sucursal 1', 1),
	(2, 'Sucursal 2', 1),
	(3, 'Sucursal 3', 2),
	(4, 'Sucursal 4', 2);

-- Volcando estructura para tabla diagnostic-test.currencies
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla diagnostic-test.currencies: ~0 rows (aproximadamente)
INSERT INTO `currencies` (`id`, `name`, `symbol`) VALUES
	(1, 'DÓLAR', '$'),
	(2, 'EURO', '€'),
	(3, 'SOL', 'S/');

-- Volcando estructura para tabla diagnostic-test.materials
CREATE TABLE IF NOT EXISTS `materials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla diagnostic-test.materials: ~0 rows (aproximadamente)
INSERT INTO `materials` (`id`, `name`) VALUES
	(1, 'Plástico'),
	(2, 'Metal'),
	(3, 'Madera'),
	(4, 'Vidrio'),
	(5, 'Textil');

-- Volcando estructura para tabla diagnostic-test.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `id_warehouse` int DEFAULT NULL,
  `id_branch` int DEFAULT NULL,
  `id_currency` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `id_warehouse` (`id_warehouse`),
  KEY `id_branch` (`id_branch`),
  KEY `id_currency` (`id_currency`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_warehouse`) REFERENCES `warehouses` (`id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_branch`) REFERENCES `branches` (`id`),
  CONSTRAINT `products_ibfk_3` FOREIGN KEY (`id_currency`) REFERENCES `currencies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla diagnostic-test.products: ~2 rows (aproximadamente)
INSERT INTO `products` (`id`, `code`, `name`, `price`, `description`, `id_warehouse`, `id_branch`, `id_currency`) VALUES
	(8, 'PPP111', 'Pruebaa', 1200.00, 'descripcion', 1, 1, 1),
	(9, 'PPP112', 'Pruebaa', 1200.00, 'descripcion', 1, 1, 1),
	(10, 'PPP113', 'pr', 1200.00, 'asdasdasdd', 1, 1, 1);

-- Volcando estructura para tabla diagnostic-test.product_material
CREATE TABLE IF NOT EXISTS `product_material` (
  `product_id` int NOT NULL,
  `material_id` int NOT NULL,
  PRIMARY KEY (`product_id`,`material_id`),
  KEY `material_id` (`material_id`),
  CONSTRAINT `product_material_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_material_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla diagnostic-test.product_material: ~0 rows (aproximadamente)
INSERT INTO `product_material` (`product_id`, `material_id`) VALUES
	(8, 1),
	(9, 1),
	(10, 1),
	(8, 2),
	(9, 2),
	(10, 2),
	(9, 3),
	(9, 4),
	(9, 5);

-- Volcando estructura para tabla diagnostic-test.warehouses
CREATE TABLE IF NOT EXISTS `warehouses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla diagnostic-test.warehouses: ~0 rows (aproximadamente)
INSERT INTO `warehouses` (`id`, `name`) VALUES
	(1, 'Bodega 1'),
	(2, 'Bodega 2');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
