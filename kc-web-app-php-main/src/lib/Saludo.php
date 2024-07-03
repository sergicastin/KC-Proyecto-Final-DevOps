<?php

namespace FirewallForce\KcWebApp\Lib;

class Saludo
{
    public function obtenerSaludo($hora)
    {
        $hora = (int)$hora;

        if ($hora >= 19 || $hora < 4) {
            return "Buenas noches";
        } elseif ($hora >= 5 && $hora < 12) {
            return "Buenos días";
        } elseif ($hora >= 13 && $hora < 19) {
            return "Buenas tardes";
        } else {
            return "¡Hola!";
        }
    }
}
