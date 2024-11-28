<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaTelefono(false|string $telefono)
{

    if ($telefono === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta el teléfono.",
            type: "/error/faltatelefono.html",
            detail: "La solicitud no tiene el valor del teléfono."
        );

    $trimTelefono = trim($telefono);

    if ($trimTelefono === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Teléfono en blanco.",
            type: "/error/telefonoenblanco.html",
            detail: "Pon texto en el campo teléfono.",
        );

    return $trimTelefono;
}
