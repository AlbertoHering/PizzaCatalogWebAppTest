<?php

require_once('base.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pizzas Catalog | Web App Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="scripts/jquery.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
</head>
<body>
    <ul id="nav">
       <li><a href="/" class="active">Home</a></li>
       <li><a href="/">About</a></li>
       <li><a href="/">Contact Us</a></li>
       <li>Web App Test</li>
    </ul>
    <div id="header" class="jumbotron text-center">
        <h1>Pizzas Catalog</h1>
        <div id="gradient-overlay"></div>
    </div>
    <div class="container">
        <div id="body_wrapper">
            <div id="catalog">
                <div id="intro_wrapper" class="row">
                    <div id="intro">
                        <p>Welcome to our <strong>pizza catalog</strong>, where culinary creativity meets your cravings! At our pizza haven, 
                            we offer a delectable selection of handcrafted delights, currently boasting two signature pies: 
                            the timeless classic <strong>'Fun Pizza'</strong> and the flavor-packed <strong>'Super Mushroom Pizza'</strong>.</p>
                        <p>Dive into a world of savory satisfaction as you explore our menu brimming with tantalizing toppings and premium 
                            ingredients. But here's the twist - the power to customize is in your hands! Choose from a variety of mouthwatering 
                            toppings to craft your perfect pizza masterpiece.</p>
                        <p>Whether you're a fan of the classics or a bold adventurer seeking new flavor sensations, our menu caters to all 
                            tastes and preferences. Join us on a culinary journey and indulge in the art of pizza perfection.</p>
                        <p>Ready to embark on a flavor adventure? Place your order now and let your taste buds savor the magic of 
                            customized pizza goodness!</p>
                    </div>
                </div>
                <div class="row">
                    <?php getPizzas(); ?>
                </div>
            </div>
            <div id="order" class="row hide">
                <div class="col-sm-12 align-center">
                    <h3 class="text-bg-success">Order Confirmation</h3>
                    <p id="order_number"></p>
                    <p id="order_pizza" class="pizza_name"></p>
                    <ul id="order_ingredients" class="ing_label"></ul>
                    <p id="order_total" class="total_label"></p>
                    <p class="thank_you container-sm text-success mt-2">Thank you for placing an order at Pizza Catalog!</p>
                    <p class="container-sm text-success mt-2"><button type="button" class="btn btn-secondary btn-return">Return to Main Page</button></p>
                </div>
            </div>
            <div id="error" class="row hide">
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Something went wrong. Please try again!
                </div>
            </div>
            <div id="delivery" class="container-xxl text-success border mt-2">
                Express Delivery Available!
            </div>
        </div>
        <div id="slogan">
            Customized pizza at its best!
        </div>
    </div>
    <div id="footer" class="text-center">
        <strong>Pizza Catalog</strong> &#174; 2024 All Rights Reserved
    </div>
    <script src="scripts/scripts.js"></script>
</body>

</html>