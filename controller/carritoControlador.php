<?php

if ($peticionAjax) {
    require_once "../model/mainModel.php";
} else {
    require_once "./model/mainModel.php";
}

class carritoControlador extends mainModel
{
    /* Agregar producto al carrito */
    public function agregar_producto_carrito_controlador()
    {
        $id_producto = mainModel::limpiar_cadena($_POST['idProducto']);
        $cantidad = mainModel::limpiar_cadena($_POST['cantidadProducto']);

        // Verificar si los campos no están vacíos
        if (empty($id_producto) || empty($cantidad)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error",
                "Texto" => "Debe llenar todos los campos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Validar que la cantidad sea un número válido
        if (!is_numeric($cantidad) || $cantidad < 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error",
                "Texto" => "La cantidad debe ser un número positivo",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Verificar si el producto existe en la base de datos
        $check_producto = mainModel::ejecutar_consulta_simple("SELECT * FROM productos WHERE idProducto='$id_producto'");
        if ($check_producto->rowCount() == 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error",
                "Texto" => "El producto no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Lógica para agregar el producto al carrito (puedes usar sesiones o base de datos)
        // Suponiendo que utilizamos sesiones:
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Agregar el producto al carrito
        $producto = $check_producto->fetch();
        $item_carrito = [
            "id" => $producto['idProducto'],
            "nombre" => $producto['nombreProducto'],
            "cantidad" => $cantidad,
            "precio" => $producto['precioProducto']
        ];

        $_SESSION['carrito'][] = $item_carrito;

        $alerta = [
            "Alerta" => "simple",
            "Titulo" => "Producto agregado",
            "Texto" => "El producto ha sido agregado al carrito",
            "Tipo" => "success"
        ];
        echo json_encode($alerta);
    }

    /* Eliminar producto del carrito */
    public function eliminar_producto_carrito_controlador()
    {
        $id_producto = mainModel::limpiar_cadena($_POST['idProducto']);

        if (empty($id_producto)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error",
                "Texto" => "El ID del producto es requerido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Verificar si el producto está en el carrito
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $indice => $producto) {
                if ($producto['id'] == $id_producto) {
                    unset($_SESSION['carrito'][$indice]); // Eliminar producto
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Producto eliminado",
                        "Texto" => "El producto ha sido eliminado del carrito",
                        "Tipo" => "success"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
        }

        $alerta = [
            "Alerta" => "simple",
            "Titulo" => "Error",
            "Texto" => "El producto no se encuentra en el carrito",
            "Tipo" => "error"
        ];
        echo json_encode($alerta);
    }

    /* Actualizar cantidad de un producto en el carrito */
    public function actualizar_producto_carrito_controlador()
    {
        $id_producto = mainModel::limpiar_cadena($_POST['idProducto']);
        $nueva_cantidad = mainModel::limpiar_cadena($_POST['nuevaCantidad']);

        if (empty($id_producto) || empty($nueva_cantidad)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error",
                "Texto" => "Todos los campos son requeridos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (!is_numeric($nueva_cantidad) || $nueva_cantidad < 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error",
                "Texto" => "La cantidad debe ser válida",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $indice => $producto) {
                if ($producto['id'] == $id_producto) {
                    $_SESSION['carrito'][$indice]['cantidad'] = $nueva_cantidad;
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Cantidad actualizada",
                        "Texto" => "La cantidad ha sido actualizada correctamente",
                        "Tipo" => "success"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
        }

        $alerta = [
            "Alerta" => "simple",
            "Titulo" => "Error",
            "Texto" => "El producto no se encuentra en el carrito",
            "Tipo" => "error"
        ];
        echo json_encode($alerta);
    }
}
