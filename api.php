<?php
    // ตั้งค่า headers สำหรับการตอบสนอง
    header("Content-Type: application/json");

    // รับข้อมูลจาก request
    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    $resource = $request[0];

    // ฟังก์ชันสำหรับการตอบสนอง JSON
    function respond($status, $data) {
        http_response_code($status);
        echo json_encode($data);
    }

    // ตัวอย่างข้อมูล
    $items = [
        1 => ['id' => 1, 'name' => 'Item 1'],
        2 => ['id' => 2, 'name' => 'Item 2'],
        3 => ['id' => 3, 'name' => 'Item 3']
    ];

    // สร้าง API endpoint
    switch ($method) {
        case 'GET':
            if ($resource == 'items') {
                respond(200, $items);
            } elseif (isset($request[1]) && isset($items[$request[1]])) {
                respond(200, $items[$request[1]]);
            } else {
                respond(404, ['message' => 'Item not found']);
            }
            break;

        case 'POST':
            // รับข้อมูลจาก body
            $input = json_decode(file_get_contents('php://input'), true);
            $newId = max(array_keys($items)) + 1;
            $items[$newId] = $input;
            respond(201, ['id' => $newId, 'data' => $input]);
            break;

        case 'PUT':
            if (isset($request[1]) && isset($items[$request[1]])) {
                $input = json_decode(file_get_contents('php://input'), true);
                $items[$request[1]] = $input;
                respond(200, ['data' => $input]);
            } else {
                respond(404, ['message' => 'Item not found']);
            }
            break;

        case 'DELETE':
            if (isset($request[1]) && isset($items[$request[1]])) {
                unset($items[$request[1]]);
                respond(204, []);
            } else {
                respond(404, ['message' => 'Item not found']);
            }
            break;

        default:
            respond(405, ['message' => 'Method not allowed']);
            break;
    }
?>
