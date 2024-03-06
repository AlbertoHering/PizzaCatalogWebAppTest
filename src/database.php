<?php

class Database {
    private $host = 'db';
    private $username = 'admin';
    private $password = 'admin';
    private $database = 'db';
    private $connection;
    private $currency = ' EUR';

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }

        return $this->connection;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getPizzas()
    {
        $pizzas = [];
        $query  = 'SELECT `id`, `name` FROM `pizzas` ORDER BY `order_id` ASC';
        $conn   = $this->getConnection();
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $pizzas = $result->fetch_all(MYSQLI_ASSOC);
        }
        $conn->close();
    
        return $pizzas;
    }

    public function getIngredientsByPizza(
        $pizza_id = null
    ) {
        if (empty($pizza_id) || !is_numeric($pizza_id)) {

            return [];
        }        

        $ingredientsByPizza = [];
        $query  = "SELECT   `i`.`id`, `i`.`name`, `i`.`cost`
                FROM        `pizza_ingredients` as `pi` 
                JOIN        `ingredients` as `i` ON `pi`.`ingredient_id` = `i`.`id`
                WHERE       `pi`.`pizza_id` = {$pizza_id} 
                ORDER BY    `pi`.`order_id` ASC";
        $conn   = $this->getConnection();
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $ingredientsByPizza = $result->fetch_all(MYSQLI_ASSOC);
        }
        $conn->close();

        if (!empty($ingredientsByPizza)) {
            foreach ($ingredientsByPizza as $key => $ingredient) {
                $ingredientsByPizza[$key]['formatted_cost'] = number_format($ingredient['cost'], 2) . $this->currency;
            }
        }

      return $ingredientsByPizza;
    }

    /**
     * Insert Order
     *
     * @param int $pizzaId
     * @param string $ingredientIds
     * @param mixed $totalAdjusted
     * @return int
     */
    public function insertOrder(
        $pizzaId,
        $ingredientIds,
        $totalAdjusted
    ): int {
        $query  = "CALL insert_order(?, ?, ?)";
        $conn   = $this->getConnection();
        $stmt   = $conn->prepare($query);
        $stmt->bind_param("iss", $pizzaId, $ingredientIds, $totalAdjusted);
        $stmt->execute();
        if ($stmt->error) {
            printf("Error: %s\n", $stmt->error);
            exit();
        }
        $stmt->bind_result($order_id);
        $stmt->fetch();
        $stmt->close();
        $conn->close();            

        return $order_id;
    }
}
