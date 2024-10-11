<?php
require_once "../controller/cartControlador.php";

$action = $_POST['action'];
$productId = $_POST['product_id'];
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

$cartController = new cartControlador();

switch ($action) {
    case 'add':
        $cartController->addToCart($productId, $quantity);
        break;
    case 'remove':
        $cartController->removeFromCart($productId);
        break;
    case 'update':
        $cartController->updateCart($productId, $quantity);
        break;
    case 'get':
        $cartController->getCartItems();
        break;
}
