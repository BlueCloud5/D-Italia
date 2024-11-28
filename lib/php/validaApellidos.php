<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaApellidos(false|string $apellidos)
{

    if ($apellidos === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Faltan los apellidos.",
            type: "/error/faltaapellidos.html",
            detail: "La solicitud no tiene el valor de los apellidos."
        );

    $trimApellidos = trim($apellidos);

    if ($trimApellidos === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Apellidos en blanco.",
            type: "/error/apellidosenblanco.html",
            detail: "Pon texto en el campo apellidos.",
        );

    return $trimApellidos;
}
