<?php

require_once('database.php');

/**
 * Get Pizzas
 * 
 * @return void
 */
function getPizzas()
{
    $model  = new Database();
    $pizzas = $model->getPizzas();
    if (!empty($pizzas)) {
        foreach ($pizzas as $pizza)
        {
            $ingredients = getIngredients($pizza['id']);

            if (empty($ingredients)) {
                continue;
            }
        
            $pizzaId    = 'pizza_' . $pizza['id'];
            $pizzaName  = htmlspecialchars($pizza['name']);      
            echo <<<HTML
                <div class="col-sm-6 pizza" id="$pizzaId">
                    <h3 class="pizza_name">$pizzaName</h3>
                    <p>Select your desired toppings:</p>
            HTML;

            getIngredientsList($ingredients, $pizza['id']);
            echo <<<HTML
                    <p class="total_label">Total: <span class="total" data-id="$pizzaId"></span> EUR</p>
                    <br /><button type="button" class="btn btn-primary pizza-order" data-id="$pizzaId">Complete Order</button>
                </div>
            HTML;
        }        
    }
}

/**
 * Get Ingredients
 * 
 * @param mixed $pizzaId
 * @return array
 */
function getIngredients(
    $pizzaId = null
): array {
    $ingredients = [];

    if (empty($pizzaId) || !is_numeric($pizzaId)) {

        return $ingredients;
    }

    $model = new Database();
    $ingredientsByPizza = $model->getIngredientsByPizza($pizzaId);
    if (!empty($ingredientsByPizza)) {
        $ingredients = $ingredientsByPizza;
    }

    return $ingredients;
}

/**
 * Get Ingredients List
 *
 * @param int $ingredientsByPizza
 * @param int $pizzaId
 * @return void
 */
function getIngredientsList(
    $ingredientsByPizza = null,
    $pizzaId = null
): void {
    foreach ($ingredientsByPizza as $ingredient)
    {
        $id = $ingredient['id'];
        $pizzaCheckboxId    = 'pizza_' . $pizzaId . '_' . $id;
        $ingredientName     = htmlspecialchars($ingredient['name']);
        $formattedCost      = htmlspecialchars($ingredient['formatted_cost']);
    
        echo <<<HTML
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="$pizzaCheckboxId" name="ingredient" value="$id" data-parent="$pizzaId" data-cost="{$ingredient['cost']}" checked>
                <label class="form-check-label ing_label" for="$pizzaCheckboxId">
                    $ingredientName <span class="ing_price">Price: $formattedCost</span>
                </label>
            </div>
        HTML;
    }    
}
