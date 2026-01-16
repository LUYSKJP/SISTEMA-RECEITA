-- SQL schema for Receitas & Rotulagem ANVISA

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `brand` varchar(150) DEFAULT NULL,
  `moisture` decimal(6,2) DEFAULT NULL,
  `density` decimal(6,3) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ingredient_nutrients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_id` int(11) NOT NULL,
  `kcal` decimal(8,2) DEFAULT 0,
  `carbs` decimal(8,2) DEFAULT 0,
  `sugars_total` decimal(8,2) DEFAULT 0,
  `sugars_added` decimal(8,2) DEFAULT 0,
  `protein` decimal(8,2) DEFAULT 0,
  `fat_total` decimal(8,2) DEFAULT 0,
  `fat_saturated` decimal(8,2) DEFAULT 0,
  `fat_trans` decimal(8,2) DEFAULT 0,
  `fiber` decimal(8,2) DEFAULT 0,
  `sodium` decimal(8,2) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `ingredient_id` (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `allergen_catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ingredient_allergens` (
  `ingredient_id` int(11) NOT NULL,
  `allergen_id` int(11) NOT NULL,
  PRIMARY KEY (`ingredient_id`,`allergen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `yield_final_g` decimal(10,2) DEFAULT 0,
  `loss_percent` decimal(5,2) DEFAULT 0,
  `portion_g` decimal(10,2) DEFAULT 0,
  `household_measure` varchar(100) DEFAULT NULL,
  `servings_per_package` decimal(10,2) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `recipe_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity_g` decimal(10,2) DEFAULT 0,
  `unit` varchar(10) DEFAULT 'g',
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `recipe_allergens` (
  `recipe_id` int(11) NOT NULL,
  `allergen_id` int(11) NOT NULL,
  PRIMARY KEY (`recipe_id`,`allergen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `regulatory_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(80) NOT NULL,
  `name` varchar(150) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `label_width` int(11) DEFAULT 720,
  `label_height` int(11) DEFAULT 540,
  `fop_width` int(11) DEFAULT 220,
  `fop_height` int(11) DEFAULT 80,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `vdr_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regulatory_version_id` int(11) NOT NULL,
  `nutrient_key` varchar(50) NOT NULL,
  `vdr_value` decimal(10,2) NOT NULL,
  `unit` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `regulatory_version_id` (`regulatory_version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `fop_thresholds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regulatory_version_id` int(11) NOT NULL,
  `nutrient_key` varchar(50) NOT NULL,
  `threshold_value` decimal(10,2) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `basis` varchar(20) DEFAULT '100g',
  PRIMARY KEY (`id`),
  KEY `regulatory_version_id` (`regulatory_version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `label_rounding_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regulatory_version_id` int(11) NOT NULL,
  `nutrient_key` varchar(50) NOT NULL,
  `significant_threshold` decimal(10,4) DEFAULT 0,
  `decimals` int(11) DEFAULT 1,
  `rounding_mode` varchar(20) DEFAULT 'nearest',
  `unit` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `regulatory_version_id` (`regulatory_version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
