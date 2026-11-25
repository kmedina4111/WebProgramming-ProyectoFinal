CREATE DATABASE IF NOT EXISTS nexuscorp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nexuscorp;


DROP TABLE IF EXISTS laptops;
DROP TABLE IF EXISTS fabricantes;
DROP TABLE IF EXISTS usuarios;


CREATE TABLE usuarios (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario    VARCHAR(50)  NOT NULL UNIQUE,
    nombre     VARCHAR(100) NOT NULL DEFAULT '',
    password   VARCHAR(255) NOT NULL,                       
    rol        ENUM('admin', 'cliente') NOT NULL DEFAULT 'cliente', 
    foto       VARCHAR(255) NULL,                           
    creado_en  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


CREATE TABLE fabricantes (
    id_fabricante      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_fabricante  VARCHAR(100) NOT NULL UNIQUE         
) ENGINE=InnoDB;


CREATE TABLE laptops (
    numero_serie     VARCHAR(50)   PRIMARY KEY,             
    modelo           VARCHAR(100)  NOT NULL,
    descripcion      TEXT          NULL,                    
    procesador           VARCHAR(100)  NOT NULL,             
    tarjeta_grafica      VARCHAR(100)  NOT NULL,             
    ram_gb               SMALLINT UNSIGNED NOT NULL,        
    almacenamiento_gb    SMALLINT UNSIGNED NOT NULL,        
    tipo_almacenamiento  ENUM('SSD', 'HDD') NOT NULL DEFAULT 'SSD',
    precio           DECIMAL(10,2) NOT NULL,              
    precio_anterior  DECIMAL(10,2) NULL,                 
    id_fabricante    INT UNSIGNED  NOT NULL,
    foto             VARCHAR(255)  NULL,                    
    activo           TINYINT(1)    NOT NULL DEFAULT 1,    
    creado_en        TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP

                        
) ENGINE=InnoDB;

-- Reglas de validacion
ALTER TABLE laptops
    ADD CONSTRAINT chk_laptops_precio          CHECK (precio > 0),
    ADD CONSTRAINT chk_laptops_precio_anterior CHECK (precio_anterior IS NULL OR precio_anterior > precio),
    ADD CONSTRAINT chk_laptops_ram             CHECK (ram_gb > 0),
    ADD CONSTRAINT chk_laptops_almacenamiento  CHECK (almacenamiento_gb > 0);

    -- Relacion con fabricantes       
ALTER TABLE laptops
    ADD CONSTRAINT fk_laptops_fabricante
    FOREIGN KEY (id_fabricante) REFERENCES fabricantes (id_fabricante)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;