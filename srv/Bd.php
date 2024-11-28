<?php

require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/TABLA_CATEGORIA.php";
require_once __DIR__ . "/TABLA_COLOR.php";
require_once __DIR__ . "/TABLA_SERVICIO.php";
require_once __DIR__ . "/TABLA_TALLA.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_ROL.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/ROL_ID_ADMINISTRADOR.php";

class Bd
{
  private static ?PDO $pdo = null;

  static function pdo(): PDO
  {
    if (self::$pdo === null) {
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

      // Creación de tabla ARCHIVO
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS ARCHIVO (
          ARCH_ID INT AUTO_INCREMENT,
          ARCH_BYTES MEDIUMBLOB NOT NULL,
          CONSTRAINT ARCH_PK PRIMARY KEY (ARCH_ID)
        ) ENGINE=InnoDB"
      );

      // Creación de tabla TALLA
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS TALLA (
          TALL_ID INT AUTO_INCREMENT,
          TALL_VALOR VARCHAR(25) NOT NULL,
          CONSTRAINT TALL_PK PRIMARY KEY (TALL_ID),
          CONSTRAINT TALL_VALOR_UNQ UNIQUE (TALL_VALOR),
          CONSTRAINT TALL_VALOR_NV CHECK (CHAR_LENGTH(TALL_VALOR) > 0)
        ) ENGINE=InnoDB"
      );

      // Creación de tabla ROL
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

      // Creación de tabla CONTACTO
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS CONTACTO (
          CON_ID INT AUTO_INCREMENT,
          CON_NOMBRE VARCHAR(100) NOT NULL,
          CON_APELLIDOS VARCHAR(150) NOT NULL,
          CON_CORREO TEXT NOT NULL,
          CON_TELEFONO VARCHAR(100) NOT NULL,
          CON_MENSAJE TEXT NOT NULL,
          CONSTRAINT CON_PK PRIMARY KEY (CON_ID),
          CONSTRAINT CON_NOM_NV CHECK (CHAR_LENGTH(CON_NOMBRE) > 0),
          CONSTRAINT CON_APE_NV CHECK (CHAR_LENGTH(CON_APELLIDOS) > 0),
          CONSTRAINT CON_COR_NV CHECK (CHAR_LENGTH(CON_CORREO) > 0),
          CONSTRAINT CON_TEL_NV CHECK (CHAR_LENGTH(CON_TELEFONO) > 0),
          CONSTRAINT CON_MEN_NV CHECK (CHAR_LENGTH(CON_MENSAJE) > 0)
        ) ENGINE=InnoDB"
      );

      // Creación de tabla SERVICIO
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS SERVICIO (
          SER_ID INT AUTO_INCREMENT,
          SER_NOMBRE VARCHAR(100) NOT NULL,
          SER_DESCRIPCION TEXT NOT NULL,
          SER_ESTADO VARCHAR(50) NOT NULL,
          CONSTRAINT SER_PK PRIMARY KEY (SER_ID),
          CONSTRAINT SER_NOM_UNQ UNIQUE (SER_NOMBRE),
          CONSTRAINT SER_NOM_NV CHECK (CHAR_LENGTH(SER_NOMBRE) > 0),
          CONSTRAINT SER_DES_NV CHECK (CHAR_LENGTH(SER_DESCRIPCION) > 0),
          CONSTRAINT SER_EST_NV CHECK (CHAR_LENGTH(SER_ESTADO) > 0)
        ) ENGINE=InnoDB"
      );

      // Creación de tabla ACCESORIO
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS ACCESORIO (
          ACC_ID INT AUTO_INCREMENT,
          ACC_MODELO VARCHAR(100) NOT NULL,
          ACC_DESCRIPCION TEXT NOT NULL,
          ACC_PRECIO DECIMAL(10,2) NOT NULL,
          ACC_ESTADO VARCHAR(50) NOT NULL,
          ACC_FECHA_CREACION DATE NOT NULL,
          ARCH_ID INT NOT NULL,
          CAT_ID INT NOT NULL,
          COL_ID INT NOT NULL,
          CONSTRAINT ACC_PK PRIMARY KEY (ACC_ID),
          CONSTRAINT ACC_MOD_UNQ UNIQUE (ACC_MODELO),
          CONSTRAINT ACC_MOD_NV CHECK (CHAR_LENGTH(ACC_MODELO) > 0),
          CONSTRAINT ACC_DES_NV CHECK (CHAR_LENGTH(ACC_DESCRIPCION) > 0),
          CONSTRAINT ACC_EST_NV CHECK (CHAR_LENGTH(ACC_ESTADO) > 0),
          CONSTRAINT ACC_ARCH_FK FOREIGN KEY (ARCH_ID) REFERENCES ARCHIVO(ARCH_ID),
          CONSTRAINT ACC_CAT_FK FOREIGN KEY (CAT_ID) REFERENCES CATEGORIA(CAT_ID),
          CONSTRAINT ACC_COL_FK FOREIGN KEY (COL_ID) REFERENCES COLOR(COL_ID)
        ) ENGINE=InnoDB"
      );

      // Creación de tabla VESTIDO
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS VESTIDO (
          VES_ID INT AUTO_INCREMENT,
          VES_MODELO VARCHAR(100) NOT NULL,
          VES_DESCRIPCION TEXT NOT NULL,
          VES_PRECIO DECIMAL(10,2) NOT NULL,
          VES_ESTADO VARCHAR(50) NOT NULL,
          VES_FECHA_CREACION DATE NOT NULL,
          ARCH_ID INT NOT NULL,
          CAT_ID INT NOT NULL,
          COL_ID INT NOT NULL,
          TALL_ID INT NOT NULL,
          CONSTRAINT VES_PK PRIMARY KEY (VES_ID),
          CONSTRAINT VES_MOD_UNQ UNIQUE (VES_MODELO),
          CONSTRAINT VES_MOD_NV CHECK (CHAR_LENGTH(VES_MODELO) > 0),
          CONSTRAINT VES_DES_NV CHECK (CHAR_LENGTH(VES_DESCRIPCION) > 0),
          CONSTRAINT VES_EST_NV CHECK (CHAR_LENGTH(VES_ESTADO) > 0),
          CONSTRAINT VES_ARCH_FK FOREIGN KEY (ARCH_ID) REFERENCES ARCHIVO(ARCH_ID),
          CONSTRAINT VES_CAT_FK FOREIGN KEY (CAT_ID) REFERENCES CATEGORIA(CAT_ID),
          CONSTRAINT VES_COL_FK FOREIGN KEY (COL_ID) REFERENCES COLOR(COL_ID),
          CONSTRAINT VES_TALL_FK FOREIGN KEY (TALL_ID) REFERENCES TALLA(TALL_ID)
        ) ENGINE=InnoDB"
      );

      // Creación de tablas para la logica de autenticación
      self::$pdo->exec(
        "CREATE TABLE IF NOT EXISTS USUARIO (
          USU_ID INT AUTO_INCREMENT,
          USU_CUE VARCHAR(255) NOT NULL,
          USU_MATCH TEXT NOT NULL,
          USU_CORREO TEXT NOT NULL,
          USU_TELEFONO VARCHAR(100),
          USU_ESTADO VARCHAR(50) NOT NULL,
          USU_FECHA_CREACION DATE NOT NULL,
          ARCH_ID INT,
          CONSTRAINT USU_PK PRIMARY KEY (USU_ID),
          CONSTRAINT USU_CUE_UNQ UNIQUE (USU_CUE),
          CONSTRAINT USU_COR_UNQ UNIQUE (USU_CORREO),
          CONSTRAINT USU_TEL_UNQ UNIQUE (USU_TELEFONO),
          CONSTRAINT USU_CUE_NV CHECK (CHAR_LENGTH(USU_CUE) > 0),
          CONSTRAINT USU_MAT_NV CHECK (CHAR_LENGTH(USU_MATCH) > 0),
          CONSTRAINT USU_COR_NV CHECK (CHAR_LENGTH(USU_CORREO) > 0),
          CONSTRAINT USU_EST_NV CHECK (CHAR_LENGTH(USU_ESTADO) > 0),
          CONSTRAINT USU_ARC_FK FOREIGN KEY (ARCH_ID) REFERENCES ARCHIVO(ARCH_ID)
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

    if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "Alan"]) === false) {
      insert(
        pdo: self::$pdo,
        into: USUARIO,
        values: [
          USU_CUE => "Alan",
          USU_MATCH => password_hash("123456", PASSWORD_DEFAULT),
          USU_CORREO => "241271010@alumnos.utn.edu.mx",
          USU_TELEFONO => "5528229415",
          USU_ESTADO => "Activado",
          USU_FECHA_CREACION => date("Y-m-d H:i:s")
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

    if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "Usiel"]) === false) {
      insert(
        pdo: self::$pdo,
        into: USUARIO,
        values: [
          USU_CUE => "Usiel",
          USU_MATCH => password_hash("123456", PASSWORD_DEFAULT),
          USU_CORREO => "241271002@alumnos.utn.edu.mx",
          USU_TELEFONO => "5586932934",
          USU_ESTADO => "Activado",
          USU_FECHA_CREACION => date("Y-m-d H:i:s")
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

    if (selectFirst(self::$pdo, USUARIO, [USU_CUE => "BlueCloud"]) === false) {
      insert(
        pdo: self::$pdo,
        into: USUARIO,
        values: [
          USU_CUE => "BlueCloud",
          USU_MATCH => password_hash("123456", PASSWORD_DEFAULT),
          USU_CORREO => "utnbluecloud220@gmail.com",
          USU_TELEFONO => "5551113628",
          USU_ESTADO => "Activado",
          USU_FECHA_CREACION => date("Y-m-d H:i:s")
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

    $tallas = [
      [
        TALL_VALOR => 30,
      ],
      [
        TALL_VALOR => 32,
      ],
      [
        TALL_VALOR => 34,
      ],
      [
        TALL_VALOR => 36,
      ],
    ];

    foreach ($tallas as $talla) {
      if (selectFirst(self::$pdo, TALLA, [TALL_VALOR => $talla[TALL_VALOR]]) === false) {
        insert(
          pdo: self::$pdo,
          into: TALLA,
          values: $talla
        );
      }
    }

    $categorias = [
      [
        CAT_NOMBRE => "XV Años",
        CAT_DESCRIPCION => "Vestidos diseñados para resaltar en uno de los momentos más importantes de la vida de una joven: su fiesta de XV Años.",
        CAT_ESTADO => "Habilitado",
      ],
      [
        CAT_NOMBRE => "Bodas",
        CAT_DESCRIPCION => "Vestidos de novia que capturan la esencia de la elegancia y el romance, diseñados para el día más importante de tu vida.",
        CAT_ESTADO => "Habilitado",
      ],
    ];

    foreach ($categorias as $categoria) {
      if (selectFirst(self::$pdo, CATEGORIA, [CAT_NOMBRE => $categoria[CAT_NOMBRE]]) === false) {
        insert(
          pdo: self::$pdo,
          into: CATEGORIA,
          values: $categoria
        );
      }
    }

    $colores = [
      [
        COL_NOMBRE => "Blanco",
        COL_HEXADECIMAL => "#FFFFFF",
        COL_DESCRIPCION => "Color blanco",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Negro",
        COL_HEXADECIMAL => "#000000",
        COL_DESCRIPCION => "Color negro",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Rojo",
        COL_HEXADECIMAL => "#FF0000",
        COL_DESCRIPCION => "Color rojo",
        COL_ESTADO => "Deshabilitado",
      ],
      [
        COL_NOMBRE => "Azul",
        COL_HEXADECIMAL => "#0000FF",
        COL_DESCRIPCION => "Color azul",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Palo de rosa",
        COL_HEXADECIMAL => "#FFC0CB",
        COL_DESCRIPCION => "Color palo de rosa",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Azul cielo",
        COL_HEXADECIMAL => "#80BFFF",
        COL_DESCRIPCION => "Color azul cielo",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Oro",
        COL_HEXADECIMAL => "#D4AC37",
        COL_DESCRIPCION => "Color oro",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Rosa pastel",
        COL_HEXADECIMAL => "#F46E78",
        COL_DESCRIPCION => "Color rosa pastel",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Durazno",
        COL_HEXADECIMAL => "#FFD6BB",
        COL_DESCRIPCION => "Color durazno",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Vino",
        COL_HEXADECIMAL => "#8C030C",
        COL_DESCRIPCION => "Color vino",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Hueso",
        COL_HEXADECIMAL => "#F5EFD7",
        COL_DESCRIPCION => "Color hueso",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Verde seco",
        COL_HEXADECIMAL => "#6E770D",
        COL_DESCRIPCION => "Color verde seco",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Verde menta",
        COL_HEXADECIMAL => "#3ECF72",
        COL_DESCRIPCION => "Color verde menta",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Fiusha",
        COL_HEXADECIMAL => "#FF0080",
        COL_DESCRIPCION => "Color fiusha",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Azul marino",
        COL_HEXADECIMAL => "#000080",
        COL_DESCRIPCION => "Color azul marino",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Azul petroleo",
        COL_HEXADECIMAL => "#012E46",
        COL_DESCRIPCION => "Color azul petróleo",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Amarillo",
        COL_HEXADECIMAL => "#FFDD00",
        COL_DESCRIPCION => "Color amarillo",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Rojo quemado",
        COL_HEXADECIMAL => "#A23530",
        COL_DESCRIPCION => "Color rojo quemado",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Café",
        COL_HEXADECIMAL => "#A52A2A",
        COL_DESCRIPCION => "Color café",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Morado",
        COL_HEXADECIMAL => "#8000FF",
        COL_DESCRIPCION => "Color morado",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Azul aqua",
        COL_HEXADECIMAL => "#00FFFF",
        COL_DESCRIPCION => "Color azul aqua",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Naranja",
        COL_HEXADECIMAL => "#FF8000",
        COL_DESCRIPCION => "Color naranja",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Verde esmeralda",
        COL_HEXADECIMAL => "#009D71",
        COL_DESCRIPCION => "Color verde esmeralda",
        COL_ESTADO => "Habilitado",
      ],
      [
        COL_NOMBRE => "Verde pistache",
        COL_HEXADECIMAL => "#D3E09F",
        COL_DESCRIPCION => "Color verde pistache",
        COL_ESTADO => "Habilitado",
      ],
    ];

    foreach ($colores as $color) {
      if (selectFirst(self::$pdo, COLOR, [COL_NOMBRE => $color[COL_NOMBRE]]) === false) {
        insert(
          pdo: self::$pdo,
          into: COLOR,
          values: $color
        );
      }
    }

    $servicios = [
      [
        SER_NOMBRE => "Vestidos sobre diseño",
        SER_DESCRIPCION => "Personalización de vestidos para eventos especiales.",
        SER_ESTADO => "Deshabilitado",
      ],
      [
        SER_NOMBRE => "Toma de medidas para vestidos de XV años",
        SER_DESCRIPCION => "Servicio para garantizar un ajuste perfecto en vestidos de XV años.",
        SER_ESTADO => "Habilitado",
      ],
      [
        SER_NOMBRE => "Toma de medidas para vestidos de Bodas",
        SER_DESCRIPCION => "Medición precisa para confeccionar vestidos de novia.",
        SER_ESTADO => "Habilitado",
      ],
      [
        SER_NOMBRE => "Elaboración de ramo",
        SER_DESCRIPCION => "Creación de ramos personalizados para ocasiones especiales.",
        SER_ESTADO => "Habilitado",
      ],
      [
        SER_NOMBRE => "Elaboración de cojines",
        SER_DESCRIPCION => "Diseño y confección de cojines decorativos o temáticos.",
        SER_ESTADO => "Deshabilitado",
      ],
    ];

    foreach ($servicios as $servicio) {
      if (selectFirst(self::$pdo, SERVICIO, [SER_NOMBRE => $servicio[SER_NOMBRE]]) === false) {
        insert(
          pdo: self::$pdo,
          into: SERVICIO,
          values: $servicio
        );
      }
    }

    return self::$pdo;
  }
}
