<?php

require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_ROL.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/ROL_ID_ADMINISTRADOR.php";

class Bd
{
  private static ?PDO $pdo = null;

  static function pdo(): PDO
  {
    if (self::$pdo === null) {

      // self::$pdo = new PDO(
      //   // cadena de conexión
      //   "mysql:host=localhost;dbname=ditalia-srv",
      //   // usuario
      //   "root",
      //   // contraseña
      //   "",
      //   // Opciones: pdos no persistentes y lanza excepciones.
      //   [PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      // );
      self::$pdo = new PDO(
        // cadena de conexión
        "mysql:host=sql300.infinityfree.com;dbname=if0_37624350_ditalia;",
        // usuario
        "if0_37624350",
        // contraseña
        "VgVyaqsM4W7d",
        // Opciones: pdos no persistentes y lanza excepciones.
        [PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );

      // Creación de tabla CATEGORIA
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS CATEGORIA (
          CAT_ID INT AUTO_INCREMENT,
          CAT_NOMBRE VARCHAR(100) NOT NULL,
          CAT_DESCRIPCION TEXT NOT NULL,
          CAT_ESTADO VARCHAR(50) NOT NULL,
          CONSTRAINT CAT_PK PRIMARY KEY (CAT_ID),
          CONSTRAINT CAT_NOM_UNQ UNIQUE (CAT_NOMBRE),
          CONSTRAINT CAT_NOM_NV CHECK (CHAR_LENGTH(CAT_NOMBRE) > 0),
          CONSTRAINT CAT_DES_NV CHECK (CHAR_LENGTH(CAT_DESCRIPCION) > 0),
          CONSTRAINT CAT_EST_NV CHECK (CHAR_LENGTH(CAT_ESTADO) > 0)
        ) ENGINE=InnoDB"
      );

      // Creación de tabla COLOR
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS COLOR (
          COL_ID INT AUTO_INCREMENT,
          COL_NOMBRE VARCHAR(100) NOT NULL,
          COL_HEXADECIMAL VARCHAR(100) NOT NULL,
          COL_DESCRIPCION TEXT NOT NULL,
          COL_ESTADO VARCHAR(50) NOT NULL,
          CONSTRAINT COL_PK PRIMARY KEY (COL_ID),
          CONSTRAINT COL_NOM_UNQ UNIQUE (COL_NOMBRE),
          CONSTRAINT COL_NOM_NV CHECK (CHAR_LENGTH(COL_NOMBRE) > 0),
          CONSTRAINT COL_HEX_UNQ UNIQUE(COL_HEXADECIMAL),
          CONSTRAINT COL_HEXA_NV CHECK (CHAR_LENGTH(COL_HEXADECIMAL) > 0),
          CONSTRAINT COL_DES_UNQ UNIQUE (COL_DESCRIPCION),
          CONSTRAINT COL_DES_NV CHECK (CHAR_LENGTH(COL_DESCRIPCION) > 0),
          CONSTRAINT COL_EST_NV CHECK (CHAR_LENGTH(COL_ESTADO) > 0)
        ) ENGINE=InnoDB"
      );

      // Creación de tablas para la logica de autenticación
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS USUARIO (
          USU_ID INT AUTO_INCREMENT,
          USU_CUE VARCHAR(255) NOT NULL,
          USU_MATCH TEXT NOT NULL,
          CONSTRAINT USU_PK PRIMARY KEY (USU_ID),
          CONSTRAINT USU_CUE_UNQ UNIQUE (USU_CUE),
          CONSTRAINT USU_CUE_NV CHECK (CHAR_LENGTH(USU_CUE) > 0)
        ) ENGINE=InnoDB"
      );

      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS ROL (
          ROL_ID VARCHAR(255) NOT NULL,
          ROL_DESCRIPCION TEXT NOT NULL,
          CONSTRAINT ROL_PK PRIMARY KEY (ROL_ID),
          CONSTRAINT ROL_DESCR_UNQ UNIQUE (ROL_DESCRIPCION),
          CONSTRAINT ROL_ID_NV CHECK (CHAR_LENGTH(ROL_ID) > 0),
          CONSTRAINT ROL_DESCR_NV CHECK (CHAR_LENGTH(ROL_DESCRIPCION) > 0)
        ) ENGINE=InnoDB"
      );

      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS USU_ROL (
          USU_ID INT NOT NULL,
          ROL_ID VARCHAR(255) NOT NULL,
          CONSTRAINT USU_ROL_PK PRIMARY KEY (USU_ID, ROL_ID),
          CONSTRAINT USU_ROL_USU_FK FOREIGN KEY (USU_ID) REFERENCES USUARIO (USU_ID),
          CONSTRAINT USU_ROL_ROL_FK FOREIGN KEY (ROL_ID) REFERENCES ROL (ROL_ID)
        ) ENGINE=InnoDB"
      );


      if (selectFirst(
        pdo: self::$pdo,
        from: ROL,
        where: [ROL_ID => ROL_ID_ADMINISTRADOR]
      ) === false) {
        insert(
          pdo: self::$pdo,
          into: ROL,
          values: [
            ROL_ID => ROL_ID_ADMINISTRADOR,
            ROL_DESCRIPCION => "Administra el sistema."
          ]
        );
      }

      if (selectFirst(self::$pdo, ROL, [ROL_ID => ROL_ID_CLIENTE]) === false) {
        insert(
          pdo: self::$pdo,
          into: ROL,
          values: [
            ROL_ID => ROL_ID_CLIENTE,
            ROL_DESCRIPCION => "Realiza compras."
          ]
        );
      }
    }

    if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "pepito"]) === false) {
      insert(
        pdo: self::$pdo,
        into: USUARIO,
        values: [
          USU_CUE => "pepito",
          USU_MATCH => password_hash("cuentos", PASSWORD_DEFAULT)
        ]
      );
      $usuId = self::$pdo->lastInsertId();
      insertBridges(
        pdo: self::$pdo,
        into: USU_ROL,
        valuesDePadre: [USU_ID => $usuId],
        valueDeHijos: [ROL_ID => [ROL_ID_CLIENTE]]
      );
    }

    if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "susana"]) === false) {
      insert(
        pdo: self::$pdo,
        into: USUARIO,
        values: [
          USU_CUE => "susana",
          USU_MATCH => password_hash("alegria", PASSWORD_DEFAULT)
        ]
      );
      $usuId = self::$pdo->lastInsertId();
      insertBridges(
        pdo: self::$pdo,
        into: USU_ROL,
        valuesDePadre: [USU_ID => $usuId],
        valueDeHijos: [ROL_ID => [ROL_ID_ADMINISTRADOR]]
      );
    }

    if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "bebe"]) === false) {
      insert(
        pdo: self::$pdo,
        into: USUARIO,
        values: [
          USU_CUE => "bebe",
          USU_MATCH => password_hash("saurio", PASSWORD_DEFAULT)
        ]
      );
      $usuId = self::$pdo->lastInsertId();
      insertBridges(
        pdo: self::$pdo,
        into: USU_ROL,
        valuesDePadre: [USU_ID => $usuId],
        valueDeHijos: [ROL_ID => [ROL_ID_ADMINISTRADOR, ROL_ID_CLIENTE]]
      );
    }

    return self::$pdo;
  }
}
