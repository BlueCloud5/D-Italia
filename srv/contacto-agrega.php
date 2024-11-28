<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaNombre.php";
require_once __DIR__ . "/../lib/php/validaApellidos.php";
require_once __DIR__ . "/../lib/php/validaCorreo.php";
require_once __DIR__ . "/../lib/php/validaTelefono.php";
require_once __DIR__ . "/../lib/php/validaMensaje.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_CONTACTO.php";

ejecutaServicio(function () {

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

    $pdo = Bd::pdo();
    insert(pdo: $pdo, into: CONTACTO, values: [CON_NOMBRE => $nombre, CON_APELLIDOS => $apellidos, CON_CORREO => $correo, CON_TELEFONO => $telefono, CON_MENSAJE => $mensaje]);
    $id = $pdo->lastInsertId();

    $encodeId = urlencode($id);
    devuelveCreated("/srv/contacto.php?id=$encodeId", [
        "id" => ["value" => $id],
        "nombre" => ["value" => $nombre],
        "apellidos" => ["value" => $apellidos],
        "correo" => ["value" => $correo],
        "telefono" => ["value" => $telefono],
        "mensaje" => ["value" => $mensaje]
    ]);
});
