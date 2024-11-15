<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaMatch($match)
{

    if ($match === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta el match.",
            type: "/error/faltamatch.html",
            detail: "La solicitud no tiene el valor de match.",
        );

    if ($match === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Match en blanco.",
            type: "/error/matchenblanco.html",
            detail: "Pon texto en el campo match.",
        );

    return $match;
}
