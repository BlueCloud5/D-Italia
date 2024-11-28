<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaHexadecimal(false|string $hexa)
{

    if ($hexa === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta el hexadecimal.",
            type: "/error/faltahexadecimal.html",
            detail: "La solicitud no tiene el valor de hexadecimal."
        );

    $trimHexa = trim($hexa);

    if ($trimHexa === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Hexadecimal en blanco.",
            type: "/error/hexadecimalenblanco.html",
            detail: "Pon texto en el campo hexadecimal.",
        );

    return $trimHexa;
}
