<?php

namespace FirewallForce\KcWebApp\Tests;

require_once __DIR__ . '/../lib/Saludo.php';

use PHPUnit\Framework\TestCase;
use FirewallForce\KcWebApp\Lib\Saludo;

class SaludoTest extends TestCase
{
    public function testObtenerSaludo()
    {
        $saludo = new Saludo();

        // Pruebas para distintos rangos de horas
        $this->assertEquals("Buenas noches", $saludo->obtenerSaludo(0));
        $this->assertEquals("Buenas noches", $saludo->obtenerSaludo(23));
        $this->assertEquals("Buenos días", $saludo->obtenerSaludo(6));
        $this->assertEquals("Buenas tardes", $saludo->obtenerSaludo(15));
        $this->assertEquals("¡Hola!", $saludo->obtenerSaludo(12));
    }
}
