<?php

// Incluir las funciones de utilidad
include 'helpers.php';

// Comprobar si la solicitud no es una petición Ajax
if (is_not_ajax()) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    return;
}

// Obtener el método de la solicitud
$method = get_method();

// Obtener los datos de la solicitud
$data = get_request_data();

// Inicializar el contador de solicitudes HTTP
$registry = new CollectorRegistry(new InMemory());
$counter = $registry->getOrRegisterCounter('app', 'http_requests_total', 'HTTP requests', ['method', 'endpoint']);

// Incrementar el contador de solicitudes HTTP
$counter->inc([$method, '/metrics']);

// Exponer las métricas en el endpoint /metrics
if ($method === 'GET' && $_SERVER['REQUEST_URI'] === '/metrics') {
    $renderer = new RenderTextFormat();
    $result = $renderer->render($registry->getMetricFamilySamples());
    header('Content-type: text/plain; charset=utf-8');
    echo $result;
    exit;
}

// Todas las demás solicitudes
send_response([
    'code' => 405,
    'status' => 'failed',
    'message' => 'Method not allowed'
], 405);
