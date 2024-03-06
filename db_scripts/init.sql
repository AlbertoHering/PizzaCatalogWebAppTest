SET NAMES 'utf8';

CREATE TABLE `pizzas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `order_id` INT DEFAULT 0
);

INSERT INTO `pizzas` (`name`, `order_id`)
VALUES
('Fun Pizza', 1),
('Super Mushroom Pizza', 2);

CREATE TABLE `ingredients` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `cost` FLOAT(10,2) DEFAULT 0
);

INSERT INTO `ingredients` (`name`, `cost`)
VALUES
('bacon', 1.0),
('feta cheese', 1.0),
('mozzarella cheese', 0.5),
('oregano', 1.0),
('sliced mushrooms', 0.5),
('sliced onion', 0.5),
('tomato', 0.5),
('sausages', 1.0);

CREATE TABLE `pizza_ingredients` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `pizza_id` INT NOT NULL,
    FOREIGN KEY (`pizza_id`) REFERENCES `pizzas`(`id`),
    `ingredient_id` INT NOT NULL,
    FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients`(`id`),
    `order_id` INT DEFAULT 0
);

INSERT INTO `pizza_ingredients` (`pizza_id`, `ingredient_id`, `order_id`)
VALUES
(1, 7, 1),
(1, 5, 2),
(1, 2, 3),
(1, 8, 4),
(1, 6, 5),
(1, 3, 6),
(1, 4, 7),
(2, 7, 1),
(2, 1, 2),
(2, 3, 3),
(2, 5, 4),
(2, 4, 5);

CREATE TABLE `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `pizza_id` INT NOT NULL,
    FOREIGN KEY (`pizza_id`) REFERENCES `pizzas`(`id`),
    `total` FLOAT(10, 2) DEFAULT 0,
    `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE `order_ingredients` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `ingredient_id` INT NOT NULL
);

DELIMITER $$
CREATE PROCEDURE insert_order (
    IN pizzaId INT,
    IN ingredientIds VARCHAR(255),
    IN totalAdjusted FLOAT
)
BEGIN
    INSERT INTO `orders` (`pizza_id`, `total`)
        VALUES (pizzaId, totalAdjusted)
    ;
    SET @orderId = LAST_INSERT_ID()
    ;
    DROP TEMPORARY TABLE IF EXISTS `temp_ingredient_ids`
    ;
    CREATE TEMPORARY TABLE `temp_ingredient_ids` (`ingredient_id` INT) AS (
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(ingredientIds, ',', numbers.n), ',', -1) AS UNSIGNED) AS ingredient_id
        FROM (
            SELECT (a.n + b.n * 10 + 1) n
            FROM 
                (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a,
                (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
            ORDER BY n
        ) numbers
        WHERE numbers.n <= 1 + LENGTH(ingredientIds) - LENGTH(REPLACE(ingredientIds, ',', ''))
    );
    INSERT INTO `order_ingredients` (`order_id`, `ingredient_id`)
        SELECT @orderId, `ingredient_id`
        FROM `temp_ingredient_ids`
    ;
    DROP TEMPORARY TABLE IF EXISTS `temp_ingredient_ids`
    ;
    SELECT @orderId as `order_id`
    ;
END
$$

DELIMITER ;