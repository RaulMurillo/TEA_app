<?php

class AddRecurrentTaskValidador
{
    /**
     * Analiza una petición y determina si es válida o no.
     * @param array $cuerpo Cuerpo de la petición a analizar
     * @return bool
     */
    public function validar(array $cuerpo): bool
    {
        // ¯\_(ツ)_/¯ Deberíamos hacer una comprobación de tipos y rangos de valores, pero vamos con prisa
        return
            isset($cuerpo['Tini'])
            && isset($cuerpo['Tfin'])
            && isset($cuerpo['Path_picto'])
            && isset($cuerpo['Tutor'])
            && isset($cuerpo['Nino'])
            && isset($cuerpo['Text'])
            && isset($cuerpo['Dia'])
            && isset($cuerpo['Tipo'])
            && isset($cuerpo['Enlace'])
            && isset($cuerpo['Periodo']);
    }
}
