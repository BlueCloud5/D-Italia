<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaFechaDeCreacion(false|string $fechaDeCreacion)
{

    if ($fechaDeCreacion === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta la fecha de creación.",
            type: "/error/faltafechadecreacion.html",
            detail: "La solicitud no tiene el valor de la fecha de creación."
        );

    $trimFechaDeCreacion = trim($fechaDeCreacion);

    if ($trimFechaDeCreacion === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Fecha de creación en blanco.",
            type: "/error/fechadecreacionenblanco.html",
            detail: "Selecciona una fecha de creación.",
        );

    return $trimFechaDeCreacion;
}
