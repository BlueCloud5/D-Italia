<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaEstado(false|string $estado)
{

    if ($estado === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta seleccionar el estado.",
            type: "/error/faltaestado.html",
            detail: "La solicitud no tiene el valor de estado."
        );

    $trimEstado = trim($estado);

    if ($trimEstado === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Estado sin selección.",
            type: "/error/estadoenblanco.html",
            detail: "Selecciona una opción del campo estado.",
        );

    return $trimEstado;
}
