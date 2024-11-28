<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaColId(false|null|int $colId)
{

    if ($colId === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta colId.",
            type: "/error/faltacolId.html",
            detail: "La solicitud no tiene el valor de colId."
        );

    if ($colId === null)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Color sin selección.",
            type: "/error/colorenblanco.html",
            detail: "Selecciona una opción del campo color.",
        );

    return $colId;
}
