$(document).ready(function()
{
    const pizzaIngredients  = {};
    const multiplingFactor  = 1.5;
    const disabledClass     = 'btn-warning';
    const currency          = 'EUR';

    function updatePizzaIngredients(pizzaId) {

        const ingredients       = [];
        const ingredientLabels  = [];
        let total               = 0;
        let totalAdjusted       = 0;
        let totalAdjustedFormatted = 0;

        $('#' + pizzaId).find('input[name="ingredient"]').each(function() {

            const ingredientId      = $(this).val();
            const ingredientLabel   = $(this).attr('id');
            const isChecked         = $(this).is(':checked');
            if (isChecked) {
                ingredients.push(ingredientId);
                ingredientLabels.push($('label[for=' + ingredientLabel + ']').html());
                total += parseFloat($(this).attr('data-cost'));
            }
        });

        const isDisabled =  ingredients.length === 0;
        $('.btn[data-id="' + pizzaId + '"]')
            .prop('disabled', isDisabled)
            .toggleClass(disabledClass, isDisabled);

        totalAdjusted = (total * multiplingFactor);
        totalAdjustedFormatted = totalAdjusted.toFixed(2);
        $('.total[data-id="' + pizzaId + '"]')
            .text(totalAdjustedFormatted);

        pizzaIngredients[pizzaId] = {
            id: pizzaId,
            name: $('#' + pizzaId).find('h3').html(),
            ingredients: ingredients,
            ingredientLabels: ingredientLabels,
            totalAdjusted: totalAdjusted,
            totalAdjustedFormatted: `${totalAdjustedFormatted} ${currency}`
        };
    }

    function showError() {
        $('#catalog').slideUp('fast', function() {
            $('#error').slideDown('fast');
            setTimeout(function() {
                $('#error').slideUp('fast', function() {
                    $('#catalog').slideDown('fast');
                })
            }, 4000);
        });
    }

    $('.pizza').each(function() {
        updatePizzaIngredients($(this).attr('id'));
    });

    $('input[name="ingredient"]').change(function() {
        const pizzaId = $(this).closest('.pizza').attr('id');
        updatePizzaIngredients(pizzaId);
    });

    $('.pizza-order').click(function() {
        const pizzaId = $(this).closest('.pizza').attr('id');
        if (pizzaId === $(this).data('id')) {
            const pizza = pizzaIngredients[pizzaId];
            $.ajax({
                url: 'api.php',
                method: 'POST',
                data: pizza,
                success: function(responseData) {

                    const responseObj   = JSON.parse(responseData);
                    const response      = responseObj.response;
                    const orderNumber   = responseObj.orderNumber;

                    if (response === 1) {
                        $('#order_number').html(`Order Number #${orderNumber}`);
                        $('#order_pizza').html(pizza.name);
                        $('#order_ingredients').html('<li>' + pizza.ingredientLabels.join('</li><li>') + '</li>');
                        $('#order_total').html(`Order Total: ${pizza.totalAdjustedFormatted}`);
                        $('#catalog').slideUp('fast', function() {
                            $('#order').slideDown();
                        });
                    } else {
                        showError();
                    }
                },
                error: function(xhr, status, error) {
                    showError();
                }
            });
        }
    });

    $('.btn-return').click(function() {
        window.location = '/';
    })
});
