<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaCorreo(false|string $correo)
{

    if ($correo === false)
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Falta el correo electrónico.",
            type: "/error/faltacorreo.html",
            detail: "La solicitud no tiene el valor del correo electrónico."
        );

    $trimCorreo = trim($correo);

    if ($trimCorreo === "")
        throw new ProblemDetails(
            status: BAD_REQUEST,
            title: "Correo electrónico en blanco.",
            type: "/error/correoenblanco.html",
            detail: "Pon texto en el de correo electrónico.",
        );

    return $trimCorreo;
}
