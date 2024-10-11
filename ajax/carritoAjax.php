<?php
session_start();
require_once "../config/SERVER.php";
require_once "../model/mainModel.php"; // Asegúrate de que mainModel esté correctamente configurado
$ins_carrito =new mainModel();

if (isset($_POST['modulo_carrito'])) {
    $modulo_carrito = $_POST['modulo_carrito'];

    switch ($modulo_carrito) {
        case 'agregar':
            // Agregar producto al carrito
            $idProducto = $ins_carrito::decryption($_POST['idProducto']);
            $producto = mainModel::getProductoPorID($idProducto); // Obtener información del producto desde la BD

            // Si ya existe en el carrito, incrementar cantidad
            if (isset($_SESSION['carrito'][$idProducto])) {
                $_SESSION['carrito'][$idProducto]['cantidad']++;
            } else {
                // Si no existe, agregarlo al carrito
                $_SESSION['carrito'][$idProducto] = [
                    'id' => $producto['idPro'],
                    'nombre' => $producto['nomPro'],
                    'precio' => $producto['precio'],
                    'cantidad' => 1
                ];
            }
            echo json_encode(['status' => 'success']);
            break;

        case 'eliminar':
            // Eliminar producto del carrito
            $idProducto = $_POST['idProducto'];
            unset($_SESSION['carrito'][$idProducto]);
            echo json_encode(['status' => 'success']);
            break;

        case 'actualizar':
            // Actualizar cantidad del producto en el carrito
            $idProducto = $_POST['idProducto'];
            $cantidad = $_POST['cantidad'];
            if (isset($_SESSION['carrito'][$idProducto])) {
                $_SESSION['carrito'][$idProducto]['cantidad'] = $cantidad;
            }
            echo json_encode(['status' => 'success']);
            break;

        case 'finalizar':
            // Procesar la compra (esto depende de tu lógica)
            unset($_SESSION['carrito']); // Vaciar el carrito al finalizar la compra
            echo json_encode(['status' => 'success']);
            break;
    }
}
