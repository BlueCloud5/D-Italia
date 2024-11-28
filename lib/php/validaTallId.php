<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaTallId(false|null|int $tallId)
{

    if ($tallId === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta tallId.",
            type: "/error/faltatallId.html",
            detail: "La solicitud no tiene el valor de tallId."
        );

    if ($tallId === null)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Talla sin selección.",
            type: "/error/tallaenblanco.html",
            detail: "Selecciona una opción del campo talla.",
        );

    return $tallId;
}
