<?php
require __DIR__ . '/vendor/autoload.php';

use Jenssegers\Agent\Agent;

function getUniqueVisitors() {
    $lines = file(__DIR__ . '/logs/access.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ips = array_map(function($line) {
        preg_match('/IP: ([\d\.]+)/', $line, $matches);
        return $matches[1] ?? null; // Utilizar null si no se encuentra una coincidencia
    }, $lines);
    $ips = array_filter($ips); // Eliminar elementos nulos
    return count(array_unique($ips));
}

// Crear instancia de Agent
$agent = new Agent();

// Obtener la IP del visitante
$ip = $_SERVER['REMOTE_ADDR'];

// Obtener el User Agent del visitante
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Obtener información detallada del dispositivo
$device = $agent->device();
$browser = $agent->browser();
$platform = $agent->platform();

// Obtener la fecha y hora actuales
$fechaHora = date('Y-m-d H:i:s');

// Registro de datos
$registro = sprintf(
    "[%s] IP: %s, User Agent: %s, Dispositivo: %s, Navegador: %s, Plataforma: %s\n",
    $fechaHora,
    $ip,
    $userAgent,
    $device,
    $browser,
    $platform
);

// Guardar el registro en un archivo de log
file_put_contents(__DIR__ . '/logs/access.log', $registro, FILE_APPEND);

// Contar el número de líneas en el archivo de log
$lineas = count(file(__DIR__ . '/logs/access.log'));

// Contar visitantes únicos
$visitantesUnicos = getUniqueVisitors();

// Contar accesos por navegador
$navegadores = [];
$navegadores[$browser] = isset($navegadores[$browser]) ? $navegadores[$browser] + 1 : 1;

// Contar accesos por plataforma
$plataformas = [];
$plataformas[$platform] = isset($plataformas[$platform]) ? $plataformas[$platform] + 1 : 1;

/**
 * ********* METRICS **********
 */

// Formato JSON
// header('Content-Type: application/json');
// echo json_encode(['access_count' => $lineas]);

/* ***************************************** */

// Formato HTML
// echo "<!DOCTYPE html>
// <html lang='es'>
// <head>
//     <meta charset='UTF-8'>
//     <meta name='viewport' content='width=device-width, initial-scale=1.0'>
//     <title>Contador de Accesos</title>
// </head>
// <body>
//     <h1>Contador de Accesos</h1>
//     <p>El número de accesos registrados es: <strong>$lineas</strong></p>
// </body>
// </html>";

/* ***************************************** */

// Formato Prometheus
header('Content-Type: text/plain');
echo "# HELP access_count Total number of accesses\n";
echo "# TYPE access_count counter\n";
echo "access_count $lineas\n\n";

echo "# HELP unique_visitors_count Total number of unique visitors\n";
echo "# TYPE unique_visitors_count gauge\n";
echo "unique_visitors_count $visitantesUnicos\n\n";

echo "# HELP browser_access_count Number of accesses by browser\n";
echo "# TYPE browser_access_count counter\n";
foreach ($navegadores as $browser => $count) {
    echo "browser_access_count{browser=\"$browser\"} $count\n\n";
}

echo "# HELP platform_access_count Number of accesses by platform\n";
echo "# TYPE platform_access_count counter\n";
foreach ($plataformas as $platform => $count) {
    echo "platform_access_count{platform=\"$platform\"} $count\n\n";
}