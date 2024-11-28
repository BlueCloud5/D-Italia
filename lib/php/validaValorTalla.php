<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaValorTalla(false|string $valorTalla)
{

    if ($valorTalla === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta el valor de la talla.",
            type: "/error/faltavalortalla.html",
            detail: "La solicitud no tiene el valor de la talla."
        );

    $trimValorTalla = trim($valorTalla);

    if ($trimValorTalla === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Valor de la talla en blanco.",
            type: "/error/valortallaenblanco.html",
            detail: "Pon texto en el campo valor de la talla.",
        );

    return $trimValorTalla;
}
