<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaDescripcion(false|string $descripcion)
{

    if ($descripcion === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta la descripción.",
            type: "/error/faltadescripcion.html",
            detail: "La solicitud no tiene el valor de descripción."
        );

    $trimDescripcion = trim($descripcion);

    if ($trimDescripcion === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Descripción en blanco.",
            type: "/error/descripcionenblanco.html",
            detail: "Pon texto en el campo descripción.",
        );

    return $trimDescripcion;
}
