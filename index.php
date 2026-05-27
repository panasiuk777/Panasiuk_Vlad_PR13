<?php

header("Content-Type: application/json");

$file = "products.json";


if (!file_exists($file)) {

    file_put_contents($file, json_encode([]));

}


$data = json_decode(file_get_contents($file), true);


$method = $_SERVER['REQUEST_METHOD'];


$request = $_SERVER['REQUEST_URI'];


$request = explode('/', trim($request, '/'));


$id = null;

if (isset($request[2])) {

    $id = $request[2];

}


if ($method === 'GET') {

    echo json_encode($data, JSON_PRETTY_PRINT);

    exit;

}


if ($method === 'POST') {

    $input = json_decode(file_get_contents("php://input"), true);


    if (

        !isset($input['name']) ||

        !isset($input['price']) ||

        !isset($input['quantity'])

    ) {

        http_response_code(400);

        echo json_encode([

            "message" => "Заповніть всі поля"

        ]);

        exit;

    }


    $newProduct = [

        "id" => count($data) + 1,

        "name" => $input['name'],

        "price" => $input['price'],

        "quantity" => $input['quantity']

    ];


    $data[] = $newProduct;


    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    echo json_encode([

        "message" => "Товар додано",

        "product" => $newProduct

    ]);

    exit;

}


if ($method === 'PUT') {

    if ($id === null) {

        http_response_code(400);

        echo json_encode([

            "message" => "ID не вказаний"

        ]);

        exit;

    }
$input = json_decode(file_get_contents("php://input"), true);

    foreach ($data as &$product) {

        if ($product['id'] == $id) {

            if (isset($input['name'])) {

                $product['name'] = $input['name'];

            }

            if (isset($input['price'])) {

                $product['price'] = $input['price'];

            }

            if (isset($input['quantity'])) {

                $product['quantity'] = $input['quantity'];

            }


            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

            echo json_encode([

                "message" => "Товар оновлено",

                "product" => $product

            ]);

            exit;

        }

    }

    http_response_code(404);

    echo json_encode([

        "message" => "Товар не знайдено"

    ]);

    exit;

}


if ($method === 'DELETE') {

    if ($id === null) {

        http_response_code(400);

        echo json_encode([

            "message" => "ID не вказаний"

        ]);

        exit;

    }

    foreach ($data as $key => $product) {

        if ($product['id'] == $id) {

            unset($data[$key]);


            $data = array_values($data);


            file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

            echo json_encode([

                "message" => "Товар видалено"

            ]);

            exit;

        }

    }

    http_response_code(404);

    echo json_encode([

        "message" => "Товар не знайдено"

    ]);

    exit;

}


http_response_code(405);

echo json_encode([

    "message" => "Метод не дозволений"

]);

?>