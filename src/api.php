<?php

require_once('database.php');

$data = urldecode(file_get_contents('php://input'));
parse_str($data, $postData);

$pizzaId        = isset($postData['id']) 
                    ? $postData['id'] 
                    : null;
$ingredientIds  = isset($postData['ingredients']) 
                    ? $postData['ingredients'] 
                    : [];
$totalAdjusted  = isset($postData['totalAdjusted']) 
                    ? $postData['totalAdjusted'] 
                    : null;

if (
    empty($pizzaId)
    || empty($ingredientIds)
    || empty($totalAdjusted)
) {
    response(0);
}

$model      = new Database();
$id         = (int) explode('_', $pizzaId)[1];
$total      = (float) $totalAdjusted;
$orderId    = $model->insertOrder($id, $ingredientIds, $totalAdjusted);
response(1, $orderId);

/**
 * Output reponse
 * 
 * @param int $responseId
 * @param int $orderNumber
 * @return void
 */
function response(
    $responseId,
    $orderNumber = null
): void {

    $response = ['response' => $responseId];

    if (!empty($orderNumber)) {
        $response['orderNumber'] = $orderNumber;
    }

    echo json_encode($response);
    exit();
}