<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaNombre.php";
require_once __DIR__ . "/../lib/php/validaApellidos.php";
require_once __DIR__ . "/../lib/php/validaCorreo.php";
require_once __DIR__ . "/../lib/php/validaTelefono.php";
require_once __DIR__ . "/../lib/php/validaMensaje.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");
    $nombre = recuperaTexto("nombre");
    $apellidos = recuperaTexto("apellidos");
    $correo = recuperaTexto("correo");
    $telefono = recuperaTexto("telefono");
    $mensaje = recuperaTexto("mensaje");

    $nombre = validaNombre($nombre);
    $apellidos = validaApellidos($apellidos);
    $correo = validaCorreo($correo);
    $telefono = validaTelefono($telefono);
    $mensaje = validaMensaje($mensaje);

    update(
        pdo: Bd::pdo(),
        table: CONTACTO,
        set: [CON_NOMBRE => $nombre, CON_APELLIDOS => $apellidos, CON_CORREO => $correo, CON_TELEFONO => $telefono, CON_MENSAJE => $mensaje],
        where: [CAT_ID => $id]
    );

    devuelveJson([
        "id" => ["value" => $id],
        "nombre" => ["value" => $nombre],
        "apellidos" => ["value" => $apellidos],
        "correo" => ["value" => $correo],
        "telefono" => ["value" => $telefono],
        "mensaje" => ["value" => $mensaje]
    ]);
});
