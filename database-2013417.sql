-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.14-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for database-2013417
CREATE DATABASE IF NOT EXISTS `database-2013417` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `database-2013417`;

-- Dumping structure for table database-2013417.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_uuid` char(36) NOT NULL DEFAULT uuid(),
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `address` varchar(25) NOT NULL,
  `city` varchar(25) NOT NULL,
  `province` varchar(25) NOT NULL,
  `postalcode` varchar(7) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` char(255) NOT NULL DEFAULT '',
  `creation` datetime NOT NULL DEFAULT current_timestamp(),
  `modification` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`customer_uuid`),
  UNIQUE KEY `username` (`username`),
  KEY `firstname` (`firstname`),
  KEY `password` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table database-2013417.customers: ~2 rows (approximately)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`customer_uuid`, `firstname`, `lastname`, `address`, `city`, `province`, `postalcode`, `username`, `password`, `creation`, `modification`) VALUES
	('391bff8f-3de8-11eb-b1a5-b1dd3d9c57df', 'Bruce', 'Banner', 'Avengers Tower', 'New York', 'New York', '98900', 'bruce', '$2y$10$pbkM486Ghru1x2mbpl/RNOy6wdtaOwmgOI5/oKppm.GUI5vmANLeu', '2020-12-14 03:41:56', '2020-12-14 03:41:56'),
	('50cd7425-3bdb-11eb-813d-c0b883e47cb1', 'Tony', 'Stark', 'Stark Tower', 'New York', 'New York', '11005', 'tony', '$2y$10$6OLze/eDgWaGgmINMtY5QOGeP.RIJX3vddfkS/sW2abzRHAvBukeK', '2020-12-11 13:04:30', '2020-12-11 13:04:30'),
	('9f6995f3-3de2-11eb-b1a5-b1dd3d9c57df', 'Steve', 'Rogers', 'Avengers Tower', 'New York', 'New York', '98900', 'steve', '$2y$10$BIEaQxFht4/hBtn9hF1wI.1Zz0/4MWHyAum42YyIzGARVH.9g5oHW', '2020-12-14 03:01:51', '2020-12-14 03:36:58');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Dumping structure for procedure database-2013417.customers_select
DELIMITER //
CREATE PROCEDURE `customers_select`()
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created customers_select procedure
	*/
	/*Procedure to select all the data from table customers, sorted by firstname*/
	SELECT	*
	FROM		customers
	ORDER BY firstname;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.customer_delete
DELIMITER //
CREATE PROCEDURE `customer_delete`(
	IN `p_customer_uuid` CHAR(36)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created customer_delete procedure
	*/
	/*Procedure to delete a specific customer based on customer_uuid*/
	DELETE 
	FROM		customers
	WHERE 	customer_uuid = p_customer_uuid;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.customer_insert
DELIMITER //
CREATE PROCEDURE `customer_insert`(
	IN `p_firstname` VARCHAR(20),
	IN `p_lastname` VARCHAR(20),
	IN `p_address` VARCHAR(25),
	IN `p_city` VARCHAR(25),
	IN `p_province` VARCHAR(25),
	IN `p_postalcode` VARCHAR(7),
	IN `p_username` VARCHAR(12),
	IN `p_password` CHAR(255)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created customer_insert procedure
	*/
	/*Procedure to insert data into table customers*/
	INSERT INTO customers
	(firstname, lastname, address, city, province, postalcode, username, PASSWORD)
	VALUES
	(p_firstname, p_lastname, p_address, p_city, p_province, p_postalcode, p_username, p_PASSWORD);
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.customer_load
DELIMITER //
CREATE PROCEDURE `customer_load`(
	IN `p_customer_uuid` CHAR(36)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 03-12-2020	Created customer_load procedure
	*/
	/*Procedure to load all the field of table customers based on customer_uuid*/
	SELECT 	*
	FROM		customers
	WHERE 	customer_uuid = p_customer_uuid;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.customer_login
DELIMITER //
CREATE PROCEDURE `customer_login`(
	IN `p_username` VARCHAR(12),
	IN `p_password` CHAR(255)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 03-12-2020	Created customer_login procedure
	*/
	/*Procedure to select customer_uuid, firstname and lastname from table customers based on username*/
	SELECT	customer_uuid, firstname, lastname
	FROM		customers
	WHERE		username = p_username AND password = p_password;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.customer_update
DELIMITER //
CREATE PROCEDURE `customer_update`(
	IN `p_customer_uuid` CHAR(36),
	IN `p_firstname` VARCHAR(20),
	IN `p_lastname` VARCHAR(20),
	IN `p_address` VARCHAR(25),
	IN `p_city` VARCHAR(25),
	IN `p_province` VARCHAR(25),
	IN `p_postalcode` VARCHAR(7),
	IN `p_username` VARCHAR(12),
	IN `p_password` CHAR(255)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created customer_update procedure
	*/
	/*Procedure to update all the fields of a specific row in the table customers based on customer_uuid*/
	UPDATE customers
	SET 	firstname = p_firstname,
			lastname = p_lastname,
			address = p_address,
			city = p_city,
			province = p_province,
			postalcode = P_postalcode,
			username = p_username,
			PASSWORD = p_password,
			modification = NOW()
	WHERE customer_uuid = p_customer_uuid;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.get_password
DELIMITER //
CREATE PROCEDURE `get_password`(
	IN `p_username` VARCHAR(12)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created get_password procedure
	*/
	/*Procedure to retreive the password from table customers based on username*/
	SELECT	password
	FROM 		customers
	WHERE 	username = p_username;
END//
DELIMITER ;

-- Dumping structure for table database-2013417.products
CREATE TABLE IF NOT EXISTS `products` (
  `product_uuid` char(36) NOT NULL DEFAULT uuid(),
  `product_code` varchar(12) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` decimal(7,2) NOT NULL DEFAULT 0.00,
  `cost_price` decimal(7,2) DEFAULT 0.00,
  `creation` datetime NOT NULL DEFAULT current_timestamp(),
  `modification` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`product_uuid`),
  KEY `description` (`description`),
  KEY `product_code` (`product_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table database-2013417.products: ~3 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`product_uuid`, `product_code`, `description`, `price`, `cost_price`, `creation`, `modification`) VALUES
	('56e0f06e-3a2c-11eb-b325-fecbfc8dce5f', 'P101Cycle', 'Gear Cycle', 199.99, 159.99, '2020-12-05 00:31:57', '2020-12-05 00:31:57'),
	('56e0f333-3a2c-11eb-b325-fecbfc8dce5f', 'P102Tredmill', 'Running Tredmill', 299.99, 199.99, '2020-12-05 13:04:16', '2020-12-05 13:04:16'),
	('e1e915a8-3de3-11eb-b1a5-b1dd3d9c57df', 'P103Rowers', 'Static Rowers', 249.99, 199.99, '2020-12-14 03:10:52', '2020-12-14 03:10:52');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for procedure database-2013417.products_select
DELIMITER //
CREATE PROCEDURE `products_select`()
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created products_select procedure
	*/
	/*Procedure to select all the data from table products, sorted by description*/
	SELECT 	*
	FROM		products
	ORDER BY description;
END//
DELIMITER ;

-- Dumping structure for view database-2013417.products_view
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `products_view` (
	`product_uuid` CHAR(36) NOT NULL COLLATE 'utf8mb4_general_ci',
	`product_code` VARCHAR(12) NOT NULL COLLATE 'utf8mb4_general_ci',
	`description` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	`price` DECIMAL(7,2) NOT NULL,
	`cost_price` DECIMAL(7,2) NULL,
	`creation` DATETIME NOT NULL,
	`modification` DATETIME NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for procedure database-2013417.product_delete
DELIMITER //
CREATE PROCEDURE `product_delete`(
	IN `p_product_uuid` CHAR(36)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created product_delete procedure
	*/
	/*Procedure to delete a specific product based on product_uuid*/
	DELETE 
	FROM 		products
	WHERE 	product_uuid = p_product_uuid;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.product_insert
DELIMITER //
CREATE PROCEDURE `product_insert`(
	IN `p_product_code` VARCHAR(12),
	IN `p_description` VARCHAR(100),
	IN `p_price` DECIMAL(7,2),
	IN `p_cost_price` DECIMAL(7,2)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created products_insert procedure
	*/
	/*Procedure to insert data into table products*/
	INSERT INTO products
	(product_code, description, price, cost_price)
	VALUES
	(p_product_code, p_description, p_price, p_cost_price);
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.product_load
DELIMITER //
CREATE PROCEDURE `product_load`(
	IN `p_product_uuid` CHAR(36)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 06-12-2020	Created product_load procedure
	*/
	/*Procedure to select all the fields from table products based on product_uuid*/
	SELECT 	*
	FROM 		products
	WHERE 	product_uuid = p_product_uuid;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.product_update
DELIMITER //
CREATE PROCEDURE `product_update`(
	IN `p_product_code` VARCHAR(12),
	IN `p_description` VARCHAR(100),
	IN `p_price` DECIMAL(7,2),
	IN `p_cost_price` DECIMAL(7,2),
	IN `p_product_uuid` CHAR(36)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created product_update procedure
	*/
	/*Procedure to update the data of a specific row of table products, based on product_uuid*/
	UPDATE products
	SET 	product_code = p_product_code,
			description = p_description,
			price = p_price,
			cost_price = p_cost_price,
			modification = NOW()
	WHERE product_uuid = p_product_uuid;
END//
DELIMITER ;

-- Dumping structure for table database-2013417.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `purchase_uuid` char(36) NOT NULL DEFAULT uuid(),
  `customer_uuid` char(36) NOT NULL,
  `product_uuid` char(36) NOT NULL,
  `quantity` int(3) NOT NULL DEFAULT 0,
  `subtotal` decimal(7,2) NOT NULL,
  `taxes` decimal(7,2) NOT NULL,
  `grandtotal` decimal(7,2) NOT NULL,
  `comments` varchar(200) DEFAULT '',
  `creation` datetime NOT NULL DEFAULT current_timestamp(),
  `modification` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`purchase_uuid`),
  KEY `customer_uuid` (`customer_uuid`),
  KEY `product_code` (`product_uuid`) USING BTREE,
  KEY `creation` (`creation`),
  KEY `grandtotal` (`grandtotal`),
  CONSTRAINT `customer_uuid` FOREIGN KEY (`customer_uuid`) REFERENCES `customers` (`customer_uuid`),
  CONSTRAINT `product_uuid` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`product_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table database-2013417.purchases: ~1 rows (approximately)
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` (`purchase_uuid`, `customer_uuid`, `product_uuid`, `quantity`, `subtotal`, `taxes`, `grandtotal`, `comments`, `creation`, `modification`) VALUES
	('69c022b8-3de8-11eb-b1a5-b1dd3d9c57df', '391bff8f-3de8-11eb-b1a5-b1dd3d9c57df', '56e0f06e-3a2c-11eb-b325-fecbfc8dce5f', 5, 999.95, 151.99, 1151.94, 'Need Fast Delivery', '2020-12-14 03:43:18', '2020-12-14 03:43:18'),
	('76c999cd-3de8-11eb-b1a5-b1dd3d9c57df', '391bff8f-3de8-11eb-b1a5-b1dd3d9c57df', 'e1e915a8-3de3-11eb-b1a5-b1dd3d9c57df', 2, 499.98, 76.00, 575.98, 'Send Additional Accessories', '2020-12-14 03:43:39', '2020-12-14 03:43:39'),
	('855c4dce-3de8-11eb-b1a5-b1dd3d9c57df', '50cd7425-3bdb-11eb-813d-c0b883e47cb1', '56e0f333-3a2c-11eb-b325-fecbfc8dce5f', 8, 2399.92, 364.79, 2764.71, 'Good Condition', '2020-12-14 03:44:04', '2020-12-14 03:44:04');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;

-- Dumping structure for procedure database-2013417.purchases_filter
DELIMITER //
CREATE PROCEDURE `purchases_filter`(
	IN `p_searched_date` DATE,
	IN `p_customer_uuid` CHAR(36)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 06-12-2020	Created purchases_filter procedure
	*/
	/*Procedure to select purchase_uuid, product_uuid, firstname, lastname, city, comments, price, quantity, subtotal, taxes, grandtotal
	from table purchases, products, customers using JOINS where purchases.product_uuid = products.product_uuid and 
	purchases.customer_uuid = customer.customer_uuid*/
	SELECT purchases.purchase_uuid, products.product_uuid, customers.firstname, customers.lastname, customers.city, purchases.comments, 
	products.price, purchases.quantity, purchases.subtotal, purchases.taxes, purchases.grandtotal
	FROM purchases JOIN customers ON purchases.customer_uuid = customers.customer_uuid
	JOIN products ON purchases.product_uuid = products.product_uuid
	WHERE (purchases.creation >= p_searched_date AND purchases.customer_uuid = p_customer_uuid)
	ORDER BY purchases.creation;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.purchases_select
DELIMITER //
CREATE PROCEDURE `purchases_select`()
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created purchases_select procedure
	*/
	/*Procedure to select all the data from table purchases, sorted by grandtotal*/
	SELECT 	*
	FROM 		purchases
	ORDER BY grandtotal;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.purchase_delete
DELIMITER //
CREATE PROCEDURE `purchase_delete`(
	IN `p_purchase_uuid` CHAR(36)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created purchase_delete procedure
	*/
	/*Procedure to delete a specific row from table purchases, based on purchase_uuid*/
	DELETE 
	FROM 	purchases
	WHERE purchase_uuid = p_purchase_uuid;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.purchase_insert
DELIMITER //
CREATE PROCEDURE `purchase_insert`(
	IN `p_customer_uuid` CHAR(36),
	IN `p_product_uuid` CHAR(36),
	IN `p_quantity` INT(3),
	IN `p_comments` VARCHAR(200),
	IN `p_subtotal` DECIMAL(7,2),
	IN `p_taxes` DECIMAL(7,2),
	IN `p_grandtotal` DECIMAL(7,2)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created purchases_filter procedure
	Prince Verma(2013417) 06-12-2020	Modified the fields, deleted sale_price, added subtotal, taxes, grandtotal
	*/
	/*Procedure to insert data into table purchases*/
	INSERT INTO purchases
	(customer_uuid, product_uuid, quantity, comments, subtotal, taxes, grandtotal)
	VALUES
	(p_customer_uuid, p_product_uuid, p_quantity, p_comments, p_subtotal, p_taxes, p_grandtotal);
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.purchase_load
DELIMITER //
CREATE PROCEDURE `purchase_load`(
	IN `p_purchase_uuid` CHAR(36)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 06-12-2020	Created purchase_load procedure
	*/
	/*Procedure to select all the data from table purchases based on purchase_uuid*/
	SELECT 	*
	FROM 		purchases
	WHERE 	purchase_uuid = p_purchase_uuid;
END//
DELIMITER ;

-- Dumping structure for procedure database-2013417.purchase_update
DELIMITER //
CREATE PROCEDURE `purchase_update`(
	IN `p_purchase_uuid` CHAR(36),
	IN `p_customer_uuid` CHAR(36),
	IN `p_product_uuid` CHAR(36),
	IN `p_quantity` INT(3),
	IN `p_comments` VARCHAR(200),
	IN `p_subtotal` DECIMAL(7,2),
	IN `p_taxes` DECIMAL(7,2),
	IN `p_grandtotal` DECIMAL(7,2)
)
BEGIN
	/*Revision History
	Prince Verma(2013417) 02-12-2020	Created purchase_update procedure
	Prince Verma(2013417) 06-12-2020	Modified fields, deleted sale_price, added subtotal, taxes, grandtotal
	*/
	/*Procedure to update all the fields of a specific row of table purchases, based on purchase_uuid*/
	UPDATE purchases
	SET 	customer_uuid = p_customer_uuid,
			product_uuid = p_product_uuid,
			quantity = p_quantity,
			comments = p_comments,
			subtotal = p_subtotal,
			taxes = p_taxes,
			grandtotal = p_grandtotal,
			modification = NOW()
	WHERE purchase_uuid = p_purchase_uuid;
END//
DELIMITER ;

-- Dumping structure for view database-2013417.products_view
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `products_view`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `products_view` AS select `products`.`product_uuid` AS `product_uuid`,`products`.`product_code` AS `product_code`,`products`.`description` AS `description`,`products`.`price` AS `price`,`products`.`cost_price` AS `cost_price`,`products`.`creation` AS `creation`,`products`.`modification` AS `modification` from `products` order by `products`.`product_code`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
