-- apple_store.sql
-- Script pour créer la base de données et les tables
-- À utiliser si la création automatique n'a pas fonctionné

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS `apple_store`;
USE `apple_store`;

-- Créer la table des commandes
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_date` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Créer la table des articles de commande
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_total` decimal(10,2) NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Créer des indexes pour améliorer les performances
CREATE INDEX `idx_order_date` ON `orders`(`order_date`);
CREATE INDEX `idx_order_status` ON `orders`(`order_status`);
CREATE INDEX `idx_order_items_order_id` ON `order_items`(`order_id`);

-- Insérer des données de test (optionnel)
INSERT INTO `orders` (`order_date`, `total_amount`, `order_status`) VALUES
('2025-11-22 10:30:00', 1938.00, 'Pending'),
('2025-11-22 11:45:00', 2099.00, 'Processing'),
('2025-11-22 13:20:00', 569.00, 'Shipped');

INSERT INTO `order_items` (`order_id`, `product_name`, `product_price`, `quantity`, `item_total`) VALUES
(1, 'iPhone 17', 969.00, 2, 1938.00),
(2, 'MacBook Air 13" M4', 1099.00, 1, 1099.00),
(2, 'AirPods Pro 3', 299.00, 1, 299.00),
(3, 'Apple Watch Series 11', 569.00, 1, 569.00);
