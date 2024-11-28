<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaModelo(false|string $modelo)
{

    if ($modelo === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta el modelo.",
            type: "/error/faltamodelo.html",
            detail: "La solicitud no tiene el valor del modelo."
        );

    $trimModelo = trim($modelo);

    if ($trimModelo === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Modelo en blanco.",
            type: "/error/modeloenblanco.html",
            detail: "Pon texto en el campo modelo.",
        );

    return $trimModelo;
}
