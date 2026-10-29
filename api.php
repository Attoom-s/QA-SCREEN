<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$action = $_GET['action'] ?? '';
$dir = __DIR__ . '/data/';

if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

switch ($action) {
    case 'get_casos':
        echo file_exists($dir . 'casos_prueba.json') ? file_get_contents($dir . 'casos_prueba.json') : json_encode([]);
        break;

    case 'save_caso':
        $file = $dir . 'casos_prueba.json';
        $input = json_decode(file_get_contents('php://input'), true);
        if ($input) {
            $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
            $data = array_filter($data, fn($item) => $item['id'] !== $input['id']);
            array_push($data, $input);
            file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo json_encode(['status' => 'success']);
        }
        break;

    case 'delete_caso':
        $file = $dir . 'casos_prueba.json';
        $id = $_GET['id'] ?? '';
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            $data = array_filter($data, fn($item) => $item['id'] !== $id);
            file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo json_encode(['status' => 'deleted']);
        }
        break;

    case 'get_equivalencias':
        echo file_exists($dir . 'equivalencias.json') ? file_get_contents($dir . 'equivalencias.json') : json_encode([]);
        break;

    case 'get_limites':
        echo file_exists($dir . 'limites.json') ? file_get_contents($dir . 'limites.json') : json_encode([]);
        break;

    case 'get_rubrica':
        echo file_exists($dir . 'rubrica.json') ? file_get_contents($dir . 'rubrica.json') : json_encode([]);
        break;

    case 'get_evaluacion':
        echo file_exists($dir . 'evaluacion.json') ? file_get_contents($dir . 'evaluacion.json') : json_encode([]);
        break;

    case 'get_bugs':
        echo file_exists($dir . 'bugs.json') ? file_get_contents($dir . 'bugs.json') : json_encode([]);
        break;

    case 'save_bug':
        $file = $dir . 'bugs.json';
        $input = json_decode(file_get_contents('php://input'), true);
        if ($input) {
            $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
            $data = array_filter($data, fn($item) => $item['id'] !== $input['id']);
            array_push($data, $input);
            file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo json_encode(['status' => 'success']);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción desconocida']);
        break;
}