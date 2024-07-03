<?php

/**
 * COMPOSER AUTOLOAD
 */

if (file_exists('vendor/autoload.php')) {
    // El directorio vendor y el archivo autoload.php existen
    include 'vendor/autoload.php';
} else {
    // El directorio vendor o el archivo autoload.php no existen
    echo 'Error: El directorio vendor o el archivo autoload.php no existen.<br/>';
    echo 'Asegúrate de haber instalado las dependencias de Composer.<br/>';
    echo 'Para ello ejecuta: <br/><br/>';
    echo '<strong>#> composer require firewallforce/kc-web-app-php</strong>';
    // Detiene la ejecución del script
    die();
}

require_once __DIR__ . '/lib/Saludo.php';
use FirewallForce\KcWebApp\Lib\Saludo;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

// Inicializa el registrador de Prometheus
$registry = new CollectorRegistry(new InMemory());
$counter = $registry->getOrRegisterCounter('app', 'http_requests_total', 'HTTP requests', ['method', 'endpoint']);

// Incrementa el contador al inicio de cada solicitud
$counter->inc([$_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']]);

// Exponer las métricas en un endpoint
if ($_SERVER['REQUEST_URI'] === '/metrics') {
    $renderer = new RenderTextFormat();
    $result = $renderer->render($registry->getMetricFamilySamples());
    header('Content-type: text/plain; charset=utf-8');
    echo $result;
    exit;
}

$saludo = new Saludo();
$horaActual = date("H:i");
$horaFormateada = date("H:i", strtotime($horaActual) + (2 * 3600));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Firewall Force | Keepcoding Academy</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" href="favicon.png" type="image/x-icon">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <!-- Logo con imagen -->
        <a class="navbar-brand" href="#"><img src="img/logo-125X77.png" alt="Logo" height="77"></a>
        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">KEEPCODING 074</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>

    <header class="bg-dark text-white py-5">
        <div class="container text-center">
            <h1 class="display-4">Keepcoding Academy</h1>
            <h3><?php echo "Son las: " . $horaFormateada . " - " . $saludo->obtenerSaludo($horaFormateada); ?></h3>
            <p class="lead">
                Proyecto practico CI/CD - Compromiso con la educación y la tecnología
            </p>
        </div>
    </header>

    <div class="px-4 my-5 text-center border-bottom">
    
        <h1 class="display-4 fw-bold">Tecnología Educativa</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">La tecnología educativa está revolucionando la enseñanza, 
                facilitando el acceso a la información y fomentando la colaboración global. 
                Esta integración transformadora está redefiniendo la experiencia educativa 
                para estudiantes y educadores en todo el mundo.</p>
        </div>
    
        <div class="overflow-hidden" style="max-height: 30vh;">
            <div class="container px-5">
                <img 
                    src="img/happy-coding.jpg" 
                    class="img-fluid border rounded-3 shadow-lg mb-4" 
                    alt="Example image" 
                    width="300" 
                    loading="lazy">
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
