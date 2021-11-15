SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS semmarplataforma;

USE semmarplataforma;

DROP TABLE IF EXISTS banco;

CREATE TABLE `banco` (
  `id_banco` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_banco` varchar(50) DEFAULT NULL,
  `moneda_banco` varchar(50) DEFAULT NULL,
  `tipo_cuenta_banco` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_banco`),
  KEY `ix_tmp_autoinc` (`id_banco`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO banco VALUES("1","sca","Soles","Ahorros");



DROP TABLE IF EXISTS beneficiario;

CREATE TABLE `beneficiario` (
  `id_beneficiario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_ben` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_beneficiario`),
  KEY `ix_tmp_autoinc` (`id_beneficiario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO beneficiario VALUES("1","CLIENTE");
INSERT INTO beneficiario VALUES("2","PROVEEDOR");



DROP TABLE IF EXISTS categoriabanco;

CREATE TABLE `categoriabanco` (
  `id_cat_banco` int(11) NOT NULL AUTO_INCREMENT,
  `id_banco` int(11) DEFAULT NULL,
  `nombre_cate` varchar(50) DEFAULT NULL,
  `monto_actual` decimal(18,2) DEFAULT NULL,
  `monto_retirado` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id_cat_banco`),
  KEY `ix_tmp_autoinc` (`id_cat_banco`),
  KEY `fk_categoriabanco_banco` (`id_banco`),
  CONSTRAINT `fk_categoriabanco_banco` FOREIGN KEY (`id_banco`) REFERENCES `banco` (`id_banco`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO categoriabanco VALUES("1","1","cjs dajk","60.00","0.00");



DROP TABLE IF EXISTS cotizacion;

CREATE TABLE `cotizacion` (
  `id_cotizacion` varchar(20) NOT NULL,
  `cod_cot` varchar(30) DEFAULT NULL,
  `fecha_cot` varchar(25) DEFAULT NULL,
  `nombre_cot` varchar(50) DEFAULT NULL,
  `nota_cot` longtext DEFAULT NULL,
  `estado_cot` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS cotizacioncliente;

CREATE TABLE `cotizacioncliente` (
  `id_cotcli` varchar(20) NOT NULL,
  `cod_cot` varchar(50) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `cantidad_cotcli` int(11) DEFAULT NULL,
  `subtotal_cotcli` decimal(18,2) DEFAULT NULL,
  `igv_cotcli` decimal(18,2) DEFAULT NULL,
  `total_cotcli` decimal(18,2) DEFAULT NULL,
  `moneda_cotcli` varchar(20) DEFAULT NULL,
  `nota_cotcli` longtext DEFAULT NULL,
  `fecha_cotcli` varchar(25) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_cotcli`),
  KEY `fk_cotizacioncliente_persona` (`id_persona`),
  CONSTRAINT `fk_cotizacioncliente_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO cotizacioncliente VALUES("COT-48367641","9889","2","1","1.00","0.18","1.00","Soles","CONDICIONES Y TERMINOS\n- VALIDEZ DE LA OFERTA:\n- LOS PRECIOS INCLUYEN EL IGV\n- TIEMPO DE ENTREGA: 10 DIAS\n- FORMA DE PAGO: CREDITO COMERCIAL 30 DIAS\n- MONEDA: SOLES\n                    ","2021-10-12 03:05:54","Pendiente");



DROP TABLE IF EXISTS detallecotizacion;

CREATE TABLE `detallecotizacion` (
  `id_detalle_cot` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) DEFAULT NULL,
  `cod_det_cot` varchar(50) DEFAULT NULL,
  `id_cotizacion` varchar(20) DEFAULT NULL,
  `cantidad_det` int(11) DEFAULT NULL,
  `unidad_det` varchar(30) DEFAULT NULL,
  `desc_det` longtext DEFAULT NULL,
  PRIMARY KEY (`id_detalle_cot`),
  KEY `ix_tmp_autoinc` (`id_detalle_cot`),
  KEY `fk_detallecotizacion_cotizacion` (`id_cotizacion`),
  KEY `fk_detallecotizacion_persona` (`id_persona`),
  CONSTRAINT `fk_detallecotizacion_cotizacion` FOREIGN KEY (`id_cotizacion`) REFERENCES `cotizacion` (`id_cotizacion`),
  CONSTRAINT `fk_detallecotizacion_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS detallecotizacioncliente;

CREATE TABLE `detallecotizacioncliente` (
  `id_detalle_cot_cli` int(11) NOT NULL AUTO_INCREMENT,
  `id_cotcli` varchar(20) DEFAULT NULL,
  `desc_det_cotcli` longtext DEFAULT NULL,
  `unidad_det_cotcli` varchar(20) DEFAULT NULL,
  `cantidad_det_cotcli` int(11) DEFAULT NULL,
  `precio_det_cotcli` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle_cot_cli`),
  KEY `ix_tmp_autoinc` (`id_detalle_cot_cli`),
  KEY `fk_detallecotizacioncliente_cotizacioncliente` (`id_cotcli`),
  CONSTRAINT `fk_detallecotizacioncliente_cotizacioncliente` FOREIGN KEY (`id_cotcli`) REFERENCES `cotizacioncliente` (`id_cotcli`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO detallecotizacioncliente VALUES("1","COT-48367641","kjjkjk","KG","1","1.00");



DROP TABLE IF EXISTS detalleorden;

CREATE TABLE `detalleorden` (
  `id_detalle_orden` int(11) NOT NULL AUTO_INCREMENT,
  `id_orden` varchar(20) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `cantidad_ord` int(11) DEFAULT NULL,
  `unidad_ord` varchar(25) DEFAULT NULL,
  `desc_ord` longtext DEFAULT NULL,
  `precio_uni` decimal(18,2) DEFAULT NULL,
  `precio_total` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle_orden`),
  KEY `ix_tmp_autoinc` (`id_detalle_orden`),
  KEY `fk_detalleorden_ordencompra` (`id_orden`),
  KEY `fk_detalleorden_persona` (`id_persona`),
  CONSTRAINT `fk_detalleorden_ordencompra` FOREIGN KEY (`id_orden`) REFERENCES `ordencompra` (`id_orden`),
  CONSTRAINT `fk_detalleorden_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS detalleordencliente;

CREATE TABLE `detalleordencliente` (
  `id_det_ordencli` int(11) NOT NULL AUTO_INCREMENT,
  `id_ordencli` varchar(20) DEFAULT NULL,
  `desc_det_ordencli` longtext DEFAULT NULL,
  `unidad_det_ordencli` varchar(20) DEFAULT NULL,
  `cantidad_det_ordencli` int(11) DEFAULT NULL,
  `precio_det_ordencli` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id_det_ordencli`),
  KEY `ix_tmp_autoinc` (`id_det_ordencli`),
  KEY `fk_detalleordencliente_ordencliente` (`id_ordencli`),
  CONSTRAINT `fk_detalleordencliente_ordencliente` FOREIGN KEY (`id_ordencli`) REFERENCES `ordencliente` (`id_ordencli`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

INSERT INTO detalleordencliente VALUES("5","ORD95822712","JDJSDJK","Unidad","1","1000.00");
INSERT INTO detalleordencliente VALUES("6","ORD95822712","PEP","Unidad","1","200.00");
INSERT INTO detalleordencliente VALUES("7","ORD95822712","jkjkjk","UNIDAD","1","23.00");
INSERT INTO detalleordencliente VALUES("8","ORD95822712","jkjk","Unidad","1","12.00");
INSERT INTO detalleordencliente VALUES("9","ORD95822712","kjkjjk","UNIDAD","1","1.00");
INSERT INTO detalleordencliente VALUES("10","ORD95822712","1","Unidad","1","1.00");
INSERT INTO detalleordencliente VALUES("11","ORD95822712","kjjkjk","UNIDAD","1","1.00");
INSERT INTO detalleordencliente VALUES("12","ORD95822712","kjjkjk","UNIDAD","1","1.00");
INSERT INTO detalleordencliente VALUES("13","ORD95822712","kjjkjk","UNIDAD","1","1.00");
INSERT INTO detalleordencliente VALUES("14","ORD95822712","kjjkjk","UNIDAD","1","1.00");
INSERT INTO detalleordencliente VALUES("15","ORD95822712","kjjkjk","UNIDAD","1","1.00");
INSERT INTO detalleordencliente VALUES("16","ORD95822712","jkjkjkj","UNIDAD","1","30.00");
INSERT INTO detalleordencliente VALUES("17","ORD95822712","jkkj","UNIDAD","1","12.00");
INSERT INTO detalleordencliente VALUES("18","ORD95822712","jkk","UNIDAD","1","1.00");



DROP TABLE IF EXISTS distribucioncostos;

CREATE TABLE `distribucioncostos` (
  `id_dis` int(11) NOT NULL AUTO_INCREMENT,
  `id_ordencli` varchar(20) NOT NULL,
  `id_cat_banco` int(11) DEFAULT NULL,
  `desc_dis` longtext DEFAULT NULL,
  `precio_dis` decimal(18,2) DEFAULT NULL,
  `moneda_dis` varchar(20) DEFAULT NULL,
  `tipo_cambio_dis` decimal(18,2) DEFAULT NULL,
  `categoria_dis` varchar(50) DEFAULT NULL,
  `fecha_dis` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_dis`),
  KEY `ix_tmp_autoinc` (`id_dis`),
  KEY `fk_distribucioncostos_categoriabanco` (`id_cat_banco`),
  KEY `fk_distribucioncostos_ordencliente` (`id_ordencli`),
  CONSTRAINT `fk_distribucioncostos_categoriabanco` FOREIGN KEY (`id_cat_banco`) REFERENCES `categoriabanco` (`id_cat_banco`),
  CONSTRAINT `fk_distribucioncostos_ordencliente` FOREIGN KEY (`id_ordencli`) REFERENCES `ordencliente` (`id_ordencli`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS distribuciongastos;

CREATE TABLE `distribuciongastos` (
  `id_distribucion_gastos` int(11) NOT NULL AUTO_INCREMENT,
  `id_ordencli` varchar(20) DEFAULT NULL,
  `id_banco` int(11) DEFAULT NULL,
  `desc_gasto` varchar(50) DEFAULT NULL,
  `monto_gasto` decimal(18,2) DEFAULT NULL,
  `fecha_gasto` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_distribucion_gastos`),
  KEY `ix_tmp_autoinc` (`id_distribucion_gastos`),
  KEY `fk_distribuciongastos_banco1` (`id_banco`),
  KEY `fk_distribuciongastos_ordencliente` (`id_ordencli`),
  CONSTRAINT `fk_distribuciongastos_banco` FOREIGN KEY (`id_banco`) REFERENCES `banco` (`id_banco`),
  CONSTRAINT `fk_distribuciongastos_banco1` FOREIGN KEY (`id_banco`) REFERENCES `banco` (`id_banco`),
  CONSTRAINT `fk_distribuciongastos_ordencliente` FOREIGN KEY (`id_ordencli`) REFERENCES `ordencliente` (`id_ordencli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS email;

CREATE TABLE `email` (
  `id_email` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_email`),
  KEY `ix_tmp_autoinc` (`id_email`),
  KEY `fk_email_persona` (`id_persona`),
  CONSTRAINT `fk_email_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO email VALUES("1","1","GAB@GMAIL.COM");
INSERT INTO email VALUES("2","2","GABIQ@GMAIC.COM");



DROP TABLE IF EXISTS estadoordencliente;

CREATE TABLE `estadoordencliente` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado`),
  KEY `ix_tmp_autoinc` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO estadoordencliente VALUES("1","INICIADO");
INSERT INTO estadoordencliente VALUES("2","EJECUCION");
INSERT INTO estadoordencliente VALUES("3","FACTURACION");
INSERT INTO estadoordencliente VALUES("4","CANCELADO");



DROP TABLE IF EXISTS numorden;

CREATE TABLE `numorden` (
  `id_numero_orden` int(11) NOT NULL AUTO_INCREMENT,
  `id_ordencli` varchar(20) DEFAULT NULL,
  `num_orden` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_numero_orden`),
  KEY `ix_tmp_autoinc` (`id_numero_orden`),
  KEY `fk_numorden_ordencliente` (`id_ordencli`),
  CONSTRAINT `fk_numorden_ordencliente` FOREIGN KEY (`id_ordencli`) REFERENCES `ordencliente` (`id_ordencli`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

INSERT INTO numorden VALUES("5","ORD95822712","9329838932");
INSERT INTO numorden VALUES("6","ORD95822712","9090");
INSERT INTO numorden VALUES("7","ORD95822712","jkjkjkj");
INSERT INTO numorden VALUES("8","ORD95822712","kj");
INSERT INTO numorden VALUES("9","ORD95822712","jkjkjk");
INSERT INTO numorden VALUES("10","ORD95822712","io");
INSERT INTO numorden VALUES("11","ORD95822712","1");
INSERT INTO numorden VALUES("12","ORD95822712","1");
INSERT INTO numorden VALUES("13","ORD95822712","1");
INSERT INTO numorden VALUES("14","ORD95822712","1");
INSERT INTO numorden VALUES("15","ORD95822712","1");
INSERT INTO numorden VALUES("16","ORD95822712","jk");
INSERT INTO numorden VALUES("17","ORD95822712","kjk");
INSERT INTO numorden VALUES("18","ORD95822712","jkjk");



DROP TABLE IF EXISTS ordencliente;

CREATE TABLE `ordencliente` (
  `id_ordencli` varchar(20) NOT NULL,
  `id_cotcli` varchar(20) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `igv_ordencli` decimal(18,2) DEFAULT NULL,
  `subtotal_ordencli` decimal(18,2) DEFAULT NULL,
  `moneda_ordencli` varchar(20) DEFAULT NULL,
  `tipo_cambio_ordencli` decimal(18,2) DEFAULT NULL,
  `total_ordencli` decimal(18,2) DEFAULT NULL,
  `pago_efectivo_ordencli` decimal(18,2) DEFAULT NULL,
  `tipo_cambio_efectivo_ordencli` decimal(18,2) DEFAULT NULL,
  `moneda_pago_efectivo_ordencli` varchar(50) DEFAULT NULL,
  `tipo_servicio` varchar(50) DEFAULT NULL,
  `numero_guia` varchar(20) DEFAULT NULL,
  `fecha_ordencli` varchar(20) DEFAULT NULL,
  `fecha_factura` varchar(20) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ordencli`),
  KEY `fk_ordencliente_cotizacioncliente1` (`id_cotcli`),
  KEY `fk_ordencliente_estadoordencliente` (`id_estado`),
  KEY `fk_ordencliente_persona` (`id_persona`),
  CONSTRAINT `fk_ordencliente_cotizacioncliente` FOREIGN KEY (`id_cotcli`) REFERENCES `cotizacioncliente` (`id_cotcli`),
  CONSTRAINT `fk_ordencliente_cotizacioncliente1` FOREIGN KEY (`id_cotcli`) REFERENCES `cotizacioncliente` (`id_cotcli`),
  CONSTRAINT `fk_ordencliente_estadoordencliente` FOREIGN KEY (`id_estado`) REFERENCES `estadoordencliente` (`id_estado`),
  CONSTRAINT `fk_ordencliente_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO ordencliente VALUES("ORD95822712","","1","0.00","1.00","Soles","1.00","1.00","0.00","","","Fabricacion","jk1","2021-10-12 02:12:13","","1");



DROP TABLE IF EXISTS ordencompra;

CREATE TABLE `ordencompra` (
  `id_orden` varchar(20) NOT NULL,
  `nombre_ord` longtext DEFAULT NULL,
  `fecha_ord` varchar(20) DEFAULT NULL,
  `subtotal_ord` decimal(18,2) DEFAULT NULL,
  `igv_ord` decimal(18,2) DEFAULT NULL,
  `total_ord` decimal(18,2) DEFAULT NULL,
  `nota_ord` longtext DEFAULT NULL,
  `estado_ord` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS pagoexterno;

CREATE TABLE `pagoexterno` (
  `id_pago_externo` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat_banco` int(11) DEFAULT NULL,
  `desc_pago` longtext DEFAULT NULL,
  `monto_pago` decimal(18,2) DEFAULT NULL,
  `tipo_cambio_pago` decimal(18,2) DEFAULT NULL,
  `fecha_pago` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pago_externo`),
  KEY `ix_tmp_autoinc` (`id_pago_externo`),
  KEY `fk_pagoproveedor_categoriabanco1` (`id_cat_banco`),
  CONSTRAINT `fk_pagoproveedor_categoriabanco1` FOREIGN KEY (`id_cat_banco`) REFERENCES `categoriabanco` (`id_cat_banco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS pagoproveedor;

CREATE TABLE `pagoproveedor` (
  `id_pago_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) DEFAULT NULL,
  `id_cat_banco` int(11) DEFAULT NULL,
  `desc_pago` longtext DEFAULT NULL,
  `monto_pago` decimal(18,2) DEFAULT NULL,
  `fecha_pago` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pago_proveedor`),
  KEY `ix_tmp_autoinc` (`id_pago_proveedor`),
  KEY `fk_pagoproveedor_categoriabanco` (`id_cat_banco`),
  KEY `fk_pagoproveedor_persona` (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO pagoproveedor VALUES("1","3","1","PAGO POR SERVICIO","1000.00","2021-09-22 11:52:52");
INSERT INTO pagoproveedor VALUES("2","3","1","EPPS","100.00","2021-09-22 11:54:13");



DROP TABLE IF EXISTS persona;

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_persona` int(11) DEFAULT NULL,
  `id_beneficiario` int(11) DEFAULT NULL,
  `razon_social` varchar(50) DEFAULT NULL,
  `representante` varchar(50) DEFAULT NULL,
  `ruc` varchar(20) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_persona`),
  KEY `ix_tmp_autoinc` (`id_persona`),
  KEY `fk_persona_beneficiario` (`id_beneficiario`),
  KEY `fk_persona_tipopersona` (`id_tipo_persona`),
  CONSTRAINT `fk_persona_beneficiario` FOREIGN KEY (`id_beneficiario`) REFERENCES `beneficiario` (`id_beneficiario`),
  CONSTRAINT `fk_persona_tipopersona` FOREIGN KEY (`id_tipo_persona`) REFERENCES `tipopersona` (`id_tipo_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO persona VALUES("1","1","2","SEMMAR","GAB","933292399","99349324","Activo");
INSERT INTO persona VALUES("2","1","1","GAB","LUIS","99009","9090","Activo");



DROP TABLE IF EXISTS sysdiagrams;

CREATE TABLE `sysdiagrams` (
  `name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `principal_id` int(11) NOT NULL,
  `diagram_id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) DEFAULT NULL,
  `definition` longblob DEFAULT NULL,
  PRIMARY KEY (`diagram_id`),
  UNIQUE KEY `uk_principal_name` (`principal_id`,`name`),
  KEY `ix_tmp_autoinc` (`diagram_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO sysdiagrams VALUES("Diagram_0","1","1","1","ĞÏà¡±á\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0>\0\0şÿ	\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\04\0\0\0\0\0\0şÿÿÿ\0\0\0\0\0\0\0\0ÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿıÿÿÿ6\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0\0\0\0\0\0\0şÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0 \0\0\0!\0\0\0\"\0\0\0#\0\0\0$\0\0\0%\0\0\0&\0\0\0\'\0\0\0(\0\0\0)\0\0\0*\0\0\0+\0\0\0,\0\0\0-\0\0\0.\0\0\0/\0\0\00\0\0\01\0\0\02\0\0\03\0\0\0şÿÿÿşÿÿÿU\0\0\0şÿÿÿ8\0\0\09\0\0\0:\0\0\0;\0\0\0<\0\0\0=\0\0\0>\0\0\0?\0\0\0@\0\0\0A\0\0\0B\0\0\0C\0\0\0D\0\0\0E\0\0\0F\0\0\0G\0\0\0H\0\0\0I\0\0\0J\0\0\0K\0\0\0L\0\0\0M\0\0\0N\0\0\0O\0\0\0P\0\0\0Q\0\0\0R\0\0\0S\0\0\0T\0\0\0şÿÿÿV\0\0\0W\0\0\0şÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿR\0o\0o\0t\0 \0E\0n\0t\0r\0y\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÿÿÿÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0pf§=è¾×5\0\0\0€\0\0\0\0\0\0f\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÿÿÿÿÿÿÿÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ú\0\0\0\0\0\0o\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0WK\0\0\0\0\0\0\0C\0o\0m\0p\0O\0b\0j\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÿÿÿÿÿÿÿÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0_\0\0\0\0\0\0\0\00\0\n\0\0€P\0\0\0\0ÿÿP\0\0\0\0}\0\0‚V\0\0/=\0\0¶\0\0q¨\0\0IŸÿÿÒ»ÿÿŞ€[ñ•Ğ° \0ª\0½Ë\\\0\0\00\0\0\0\0\0\0\0\0\0<\0k\0\0\0	\0\0\0\0\0\0\0Ùæ°éĞ­Q\0 ÉW9ô;„aÇC…5)†áÕRø 2}²Øb•B˜\'<%¢Ú-\0\0(\0C\0\0\0\0\0\0\0SDMÒÑc\0`—ÒßH4ÉÒwywØp\0[„œ\0\0(\0C\0\0\0\0\0\0\0QDMÒÑc\0`—ÒßH4ÉÒwywØp\0[„œG\0\0\0\0\0\0Çq\0\00\0¥	\0\0\0\0€\0\0\0œ\0\0\0€\0\0\0\0€SchGrid\0|üÿÿZ¦ÿÿBancoid\0\0\0<\0¥	\0\0\0\0€\0\0\0´\0\0\0€\0\0\0\0€SchGrid\0FºÿÿH©ÿÿCotizacionCliente\0\0\0\0\04\0¥	\0\0\0\0€\0\0\0¦\0\0\0€\0\0\n\0\0€SchGrid\0v™ÿÿ¼éÿÿCotizacion\0\0\0\0<\0¥	\0\0\0\0€\0\0\0´\0\0\0€\0\0\0\0€SchGrid\0¡ÿÿ2Îÿÿdetallecotizacion\0\0\0\0\0<\0¥	\0\0\0\0€\0\0\0¶\0\0\0€\0\0\0\0€SchGrid\0´âÿÿ ÑÿÿDistribucionCostosn\0\0\0<\0¥	\0\0\0\0€\0\0\0¶\0\0\0€\0\0\0\0€SchGrid\0RêÿÿšÿÿDistribucionGastos\0\0\0\04\0¥	\0\0\0\0€\0\0\0ª\0\0\0€\0\0\0\0€SchGrid\0`¾ÿÿ`¾ÿÿOrdenCliente\0\04\0¥	\0\0\0\0€\0\0\0¨\0\0\0€\0\0\0\0€SchGrid\0\"Àÿÿ.ğÿÿOrdenCompra\0\0\04\0¥	\0\0\0\0€	\0\0\0ª\0\0\0€\0\0\0\0€SchGrid\0º¯ÿÿ¼éÿÿDetalleOrden\0\00\0¥	\0\0\0\0€\n\0\0\0 \0\0\0€\0\0\0\0€SchGrid\0ÿÿ²ÿÿpersona\0\0\04\0¥	\0\0\0\0€\0\0\0¨\0\0\0€\0\0\0\0€SchGrid\0 †ÿÿ|±ÿÿTipoPersona\0\0\04\0¥	\0\0\0\0€\0\0\0ª\0\0\0€\0\0\0\0€SchGrid\0¤‰ÿÿnİÿÿBeneficiario\0\0t\0¥	\0\0\0\0€\0\0\0b\0\0\0€\0\0K\0\0€Control\0ÍšÿÿÖÇÿÿRelationship \'fk_persona_beneficiario\' between \'Beneficiario\' and \'persona\'\0\0\0(\0µ\0\0\0\0€\0\0\01\0\0\0a\0\0\0€\0\0Control\0ÿÿ¯Ôÿÿ\0\0t\0¥	\0\0\0\0€\0\0\0b\0\0\0€\0\0I\0\0€Control\0-˜ÿÿ-±ÿÿRelationship \'fk_persona_tipopersona\' between \'TipoPersona\' and \'persona\'\0\0\0\0\0(\0µ\0\0\0\0€\0\0\01\0\0\0_\0\0\0€\0\0Control\0—ÿÿ#³ÿÿ\0\0|\0¥	\0\0\0\0€\0\0\0R\0\0\0€\0\0S\0\0€Control\0!¿ÿÿwíÿÿRelationship \'fk_detalleorden_ordencompra\' between \'OrdenCompra\' and \'DetalleOrden\'\0\0\0(\0µ\0\0\0\0€\0\0\01\0\0\0i\0\0\0€\0\0Control\0Ñ¯ÿÿ‰øÿÿ\0\0t\0¥	\0\0\0\0€\0\0\0Z\0\0\0€\0\0K\0\0€Control\0ƒ¯ÿÿÈÿÿRelationship \'fk_detalleorden_persona\' between \'persona\' and \'DetalleOrden\'\0\0\0(\0µ\0\0\0\0€\0\0\01\0\0\0a\0\0\0€\0\0Control\0G´ÿÿBÑÿÿ\0\0ˆ\0¥	\0\0\0\0€\0\0\0j\0\0\0€\0\0_\0\0€Control\0¤»ÿÿÆÿÿRelationship \'fk_ordencliente_cotizacioncliente\' between \'CotizacionCliente\' and \'OrdenCliente\'\0\0\0(\0µ\0\0\0\0€\0\0\01\0\0\0u\0\0\0€\0\0Control\0{®ÿÿwËÿÿ\0\0t\0¥	\0\0\0\0€\0\0\0R\0\0\0€\0\0K\0\0€Control\0ƒ¯ÿÿÈÿÿRelationship \'fk_ordencliente_persona\' between \'persona\' and \'OrdenCliente\'\0\0(\0µ\0\0\0\0€\0\0\01\0\0\0a\0\0\0€\0\0Control\0Ô°ÿÿÇÊÿÿ\0\0€\0¥	\0\0\0\0€\0\0\0R\0\0\0€\0\0U\0\0€Control\0§ÿÿÚÇÿÿRelationship \'fk_detallecotizacion_persona\' between \'persona\' and \'detallecotizacion\'\0\0\0\0\0(\0µ\0\0\0\0€\0\0\01\0\0\0k\0\0\0€\0\0Control\0Z˜ÿÿ¶Ëÿÿ\0\0„\0¥	\0\0\0\0€\0\0\0R\0\0\0€\0\0[\0\0€Control\0§ÿÿ{áÿÿRelationship \'fk_detallecotizacion_cotizacion\' between \'Cotizacion\' and \'detallecotizacion\'n\0\0(\0µ\0\0\0\0€\0\0\01\0\0\0q\0\0\0€\0\0Control\0t—ÿÿMæÿÿ\0\0|\0¥	\0\0\0\0€!\0\0\0R\0\0\0€\0\0S\0\0€Control\0{ûÿÿ££ÿÿRelationship \'fk_distribuciongastos_banco\' between \'Banco\' and \'DistribucionGastos\'n\0\0(\0µ\0\0\0\0€\"\0\0\01\0\0\0i\0\0\0€\0\0Control\0íÿÿ›©ÿÿ\0\0€\0¥	\0\0\0\0€#\0\0\0R\0\0\0€\0\0U\0\0€Control\0ƒ¯ÿÿgÄÿÿRelationship \'fk_cotizacioncliente_persona\' between \'persona\' and \'CotizacionCliente\'\0\0\0\0\0(\0µ\0\0\0\0€$\0\0\01\0\0\0k\0\0\0€\0\0Control\0¶­ÿÿ­Æÿÿ\0\0ˆ\0¥	\0\0\0\0€%\0\0\0j\0\0\0€\0\0`\0\0€Control\0¤»ÿÿÆÿÿRelationship \'fk_ordencliente_cotizacioncliente1\' between \'CotizacionCliente\' and \'OrdenCliente\'\0\0(\0µ\0\0\0\0€&\0\0\01\0\0\0w\0\0\0€\0\0Control\0­ÿÿwËÿÿ\0\0Œ\0¥	\0\0\0\0€\'\0\0\0R\0\0\0€\0\0a\0\0€Control\0³áÿÿeÎÿÿRelationship \'fk_distribucioncostos_ordencliente\' between \'OrdenCliente\' and \'DistribucionCostos\'\0\0\0\0\0(\0µ\0\0\0\0€(\0\0\01\0\0\0w\0\0\0€\0\0Control\0ĞÿÿşÛÿÿ\0\0Œ\0¥	\0\0\0\0€)\0\0\0Z\0\0\0€\0\0a\0\0€Control\0éØÿÿQ«ÿÿRelationship \'fk_distribuciongastos_ordencliente\' between \'OrdenCliente\' and \'DistribucionGastos\'\0\0\0\0\0(\0µ\0\0\0\0€*\0\0\01\0\0\0w\0\0\0€\0\0Control\0/Ûÿÿ®ÿÿ\0\0|\0¥	\0\0\0\0€+\0\0\0R\0\0\0€\0\0T\0\0€Control\0{ûÿÿ££ÿÿRelationship \'fk_distribuciongastos_banco1\' between \'Banco\' and \'DistribucionGastos\'\0\0(\0µ\0\0\0\0€,\0\0\01\0\0\0k\0\0\0€\0\0Control\0dìÿÿ›©ÿÿ\0\00\0¥	\0\0\0\0€-\0\0\0œ\0\0\0€\0\0\0\0€SchGrid\0Š…ÿÿÀÇÿÿEmailid\0\0\0h\0¥	\0\0\0\0€.\0\0\0R\0\0\0€\0\0=\0\0€Control\0——ÿÿ¿ÆÿÿRelationship \'fk_email_persona\' between \'persona\' and \'Email\'\0\0\0\0\0(\0µ\0\0\0\0€/\0\0\01\0\0\0S\0\0\0€\0\0Control\0n–ÿÿOÆÿÿ\0\0<\0¥	\0\0\0\0€0\0\0\0¶\0\0\0€\0\0\0\0€SchGrid\0(Øÿÿ¨²ÿÿEstadoOrdenCliente\0\0\0\0Œ\0¥	\0\0\0\0€1\0\0\0R\0\0\0€\0\0a\0\0€Control\0\'×ÿÿ,ºÿÿRelationship \'fk_ordencliente_estadoordencliente\' between \'EstadoOrdenCliente\' and \'OrdenCliente\'\0\0\0\0\0(\0µ\0\0\0\0€2\0\0\01\0\0\0w\0\0\0€\0\0Control\0¯Äÿÿö¼ÿÿ\0\08\0¥	\0\0\0\0€3\0\0\0®\0\0\0€\0\0\0\0€SchGrid\0tõÿÿ,¶ÿÿCategoriaBanco\0\0\0\0t\0¥	\0\0\0\0€7\0\0\0R\0\0\0€\0\0K\0\0€Control\0E\0\06²ÿÿRelationship \'fk_categoriabanco_banco\' between \'Banco\' and \'CategoriaBanco\'\0\0\0(\0µ\0\0\0\0€8\0\0\01\0\0\0a\0\0\0€\0\0Control\05÷ÿÿá´ÿÿ\0\08\0¥	\0\0\0\0€9\0\0\0¬\0\0\0€\0\0\0\0€SchGrid\0Rêÿÿ`¾ÿÿTransacciones	\0\0\0\0„\0¥	\0\0\0\0€:\0\0\0j\0\0\0€\0\0[\0\0€Control\0¸òÿÿ+µÿÿRelationship \'FK_Transacciones_CategoriaBanco\' between \'CategoriaBanco\' and \'Transacciones\'\0\0\0(\0µ\0\0\0\0€;\0\0\01\0\0\0q\0\0\0€\0\0Control\0Şàÿÿ‹»ÿÿ\0\0@\0¥	\0\0\0\0€<\0\0\0Â\0\0\0€\0\0\0\0€SchGrid\0Ö¢ÿÿ²¨ÿÿDetalleCotizacionCliente\0\0 \0¥	\0\0\0\0€=\0\0\0R\0\0\0€\0\0w\0\0€Control\0ã´ÿÿa¬ÿÿRelationship \'fk_detallecotizacioncliente_cotizacioncliente\' between \'CotizacionCliente\' and \'DetalleCotizacionCliente\'\0\0\0(\0µ\0\0\0\0€>\0\0\01\0\0\0\0\0\0€\0\0Control\0-¬ÿÿñ«ÿÿ\0\0<\0¥	\0\0\0\0€?\0\0\0¸\0\0\0€\0\0\0\0€SchGrid\0Â\0\0ÀÇÿÿDetalleOrdenCliente\0\0\0Œ\0¥	\0\0\0\0€@\0\0\0R\0\0\0€\0\0c\0\0€Control\0VæÿÿÇÍÿÿRelationship \'fk_detalleordencliente_ordencliente\' between \'OrdenCliente\' and \'DetalleOrdenCliente\'\0\0\0(\0µ\0\0\0\0€A\0\0\01\0\0\0y\0\0\0€\0\0Control\0ëÿÿĞÿÿ\0\0\0¥	\0\0\0\0€B\0\0\0R\0\0\0€\0\0e\0\0€Control\0åúÿÿƒÄÿÿRelationship \'fk_distribucioncostos_categoriabanco\' between \'CategoriaBanco\' and \'DistribucionCostos\'\0€?\0\0(\0µ\0\0\0\0€C\0\0\01\0\0\0{\0\0\0€\0\0Control\0†çÿÿËÿÿ\0\00\0¥	\0\0\0\0€D\0\0\0 \0\0\0€\0\0\0\0€SchGrid\0²¨ÿÿ¬ÛÿÿUsuario\0\0\00\0¥	\0\0\0\0€E\0\0\0¢\0\0\0€\0\0\0\0€SchGrid\0¨ÿÿ®ÊÿÿNumOrden\0\04\0¥	\0\0\0\0€F\0\0\0¨\0\0\0€\0\0\0\0€SchGrid\0Œ¿ÿÿL‡ÿÿPagoExterno\0\0\0„\0¥	\0\0\0\0€I\0\0\0b\0\0\0€\0\0Y\0\0€Control\0æÿÿõœÿÿRelationship \'FK_PagoProveedor_CategoriaBanco\' between \'CategoriaBanco\' and \'PagoExterno\'\0\0\0\0\0(\0µ\0\0\0\0€J\0\0\01\0\0\0q\0\0\0€\0\0Control\0-ìÿÿk¬ÿÿ\0\0€\0¥	\0\0\0\0€K\0\0\0R\0\0\0€\0\0W\0\0€Control\0Væÿÿ_½ÿÿRelationship \'FK_Transacciones_OrdenCliente\' between \'OrdenCliente\' and \'Transacciones\'\0\0\0(\0µ\0\0\0\0€L\0\0\01\0\0\0m\0\0\0€\0\0Control\0/àÿÿï¼ÿÿ\0\0x\0¥	\0\0\0\0€M\0\0\0R\0\0\0€\0\0M\0\0€Control\0ƒ¯ÿÿ¥ÂÿÿRelationship \'FK_Transacciones_persona\' between \'persona\' and \'Transacciones\'„\0\0(\0µ\0\0\0\0€N\0\0\01\0\0\0c\0\0\0€\0\0Control\0 ÆÿÿëÄÿÿ\0\0x\0¥	\0\0\0\0€O\0\0\0j\0\0\0€\0\0M\0\0€Control\0Ğÿÿ2µÿÿRelationship \'FK_NumOrden_OrdenCliente\' between \'OrdenCliente\' and \'NumOrden\'\0\0\0\0\0(\0µ\0\0\0\0€P\0\0\01\0\0\0c\0\0\0€\0\0Control\0”Âÿÿä¸ÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0!C4\0\0\09\0\0“\0\0xV4\0\0\0\0\0B\0a\0n\0c\0o\0\0\0\0\0\0\0\0\0\0\0Ä\"\0\0\0\0\0\0Å\"\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0*\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0ó\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0“\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0T\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0B\0a\0n\0c\0o\0\0\0!C4\0\0\09\0\0ğ\0\0xV4\0\0\0\0\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0š™™>\0\0\0\0\0\0\0\0\0\0\0\0©¨¨>\0\0\0?\0\0\0\0\0\0\0\0\0\0\0\0­¬,>333?\0\0\0\0\0\0\0\0\0\0\0\0áà`=fff?\0\0\0\0\0\0\0\0\0\0\0\0ÁÀ@<\0\0€?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0V,\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0ğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0l\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0!C4\0\0\09\0\0‰\0\0xV4\0\0\0\0\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0\0\0V?ÜÛ[?êéi?\0\0€?\0\0€?×ÖV?ÜÛ[?êéi?\0\0€?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0d\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0‰\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0^\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0\0\0!C4\0\0\09\0\0\0\0xV4\0\0\0\0\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0\0\0\0\0€?×ÖV?ÜÛ[?êéi?\0\0€?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0l\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0\0\0!C4\0\0\0\")\0\0ß\0\0xV4\0\0\0\0\0D\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0C\0o\0s\0t\0o\0s\0\0\0€?×ÖV?ÜÛ[?êéi?\0\0€?\0\0\0?\0\0\0\0\0\0\0\0\0\0\0\0­¬,>333?\0\0\0\0\0\0\0\0\0\0\0\0áà`=fff?\0\0\0\0\0\0\0\0\0\0\0\0ÁÀ@<\0\0€?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0ß\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0n\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0D\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0C\0o\0s\0t\0o\0s\0\0\0!C4\0\0\09\0\0(\0\0xV4\0\0\0\0\0D\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0G\0a\0s\0t\0o\0s\0\0\0\0\0\0@p@\0\0\0\0\0Àp@\0\0\0\0\0\0@\0\0\0\0\0\0ğ?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ğ?\0\0\0\0\0\0\0\0˜;Gr\0\0\0\0\0\0\0\0 <GrØXGrp@¨p@¨\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0î\0\0\0\0\0\0\0\0\0 A\0\0‚C\0\0 A\0€„C\0\0 @\0\0‚C\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0(\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0n\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0D\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0G\0a\0s\0t\0o\0s\0\0\0!C4\0\0\0\")\0\0<,\0\0xV4\0\0\0\0\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0Îc\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0+\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0<,\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0a\'\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0b\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0!C4\0\0\09\0\0\0\0xV4\0\0\0\0\0O\0r\0d\0e\0n\0C\0o\0m\0p\0r\0a\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0`q@\0\0\0\0\0@p@\0\0\0\0\0\0ğ?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ğ?\0\0\0\0\0\0\0\0˜;Gr\0\0\0\0\0\0\0\0 <GrØXGrX<û\nX<û\n\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0’î\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0‚C\0\0‚Ã\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0`\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0O\0r\0d\0e\0n\0C\0o\0m\0p\0r\0a\0\0\0!C4\0\0\09\0\0\0\0xV4\0\0\0\0\0D\0e\0t\0a\0l\0l\0e\0O\0r\0d\0e\0n\0\0\0[?êéi?\0\0€?\0\0€?×ÖV?ÜÛ[?êéi?\0\0€?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0b\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0D\0e\0t\0a\0l\0l\0e\0O\0r\0d\0e\0n\0\0\0!C4\0\0\0\0\0\0\0xV4\0\0\0\0\0p\0e\0r\0s\0o\0n\0a\0\0\0ø\n„=û\n\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0`q@\0\0\0\0\0@p@\0\0\0\0\0\0ğ?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ğ?\0\0\0\0\0\0\0\0˜;Gr\0\0\0\0\0\0\0\0 <GrØXGr =û\n =û\n\0\0\0\0\0\0\0\0\0\0\0\0\0\0Àî\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0‚C\0\0‚Ã\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0X\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0p\0e\0r\0s\0o\0n\0a\0\0\0!C4\0\0\09\0\0	\0\0xV4\0\0\0\0\0T\0i\0p\0o\0P\0e\0r\0s\0o\0n\0a\0\0\0ÜÛ[?êéi?\0\0€?\0\0€?×ÖV?ÜÛ[?êéi?\0\0€?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0	\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0`\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0T\0i\0p\0o\0P\0e\0r\0s\0o\0n\0a\0\0\0!C4\0\0\09\0\0	\0\0xV4\0\0\0\0\0B\0e\0n\0e\0f\0i\0c\0i\0a\0r\0i\0o\0\0\0\0\0¿1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0*\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0	\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0b\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0B\0e\0n\0e\0f\0i\0c\0i\0a\0r\0i\0o\0\0\0\0\0dœÿÿnİÿÿdœÿÿ\0Ôÿÿ&ÿÿ\0Ôÿÿ&ÿÿ‘Êÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÿ¯Ôÿÿô\0\0X\0\03\0\0\0\0\0\0\0ô\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0p\0e\0r\0s\0o\0n\0a\0_\0b\0e\0n\0e\0f\0i\0c\0i\0a\0r\0i\0o\0\0\0Y™ÿÿFºÿÿt›ÿÿFºÿÿt›ÿÿ¨²ÿÿÿÿ¨²ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0—ÿÿ#³ÿÿ.\0\0X\0\0=\0\0\0\0\0\0\0.\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0p\0e\0r\0s\0o\0n\0a\0_\0t\0i\0p\0o\0p\0e\0r\0s\0o\0n\0a\0\0\0¸Àÿÿ.ğÿÿ¸Àÿÿ;\0\0\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ñ¯ÿÿ‰øÿÿ8\0\0X\0\02\0\0\0\0\0\0\08\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0o\0r\0d\0e\0n\0_\0o\0r\0d\0e\0n\0c\0o\0m\0p\0r\0a\0\0\0¯°ÿÿÊÿÿzÂÿÿÊÿÿzÂÿÿ¼éÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0G´ÿÿBÑÿÿ„\0\0X\0\02\0\0\0\0\0\0\0„\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0o\0r\0d\0e\0n\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0`¾ÿÿ8Éÿÿ`¾ÿÿÈÊÿÿĞ¼ÿÿÈÊÿÿĞ¼ÿÿìÈÿÿ`¾ÿÿìÈÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0{®ÿÿwËÿÿÌ\0\0X\0\0+\0\0\0\0\0\0\0Ì\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma!\0f\0k\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0¯°ÿÿÊÿÿ`¾ÿÿÊÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ô°ÿÿÇÊÿÿh\0\0X\0\02\0\0\0\0\0\0\0h\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0²¨ÿÿ‘Êÿÿ²¨ÿÿ2Îÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Z˜ÿÿ¶Ëÿÿ©\0\0X\0\02\0\0\0\0\0\0\0©\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0²¨ÿÿ¼éÿÿ²¨ÿÿ6äÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0t—ÿÿMæÿÿ\0\0X\0\02\0\0\0\0\0\0\0\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0\0\0ıÿÿZ¦ÿÿıÿÿ4®ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\"\0\0\0\0\0\0\0íÿÿ›©ÿÿQ\0\0X\0\02\0\0\0\0\0\0\0Q\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0g\0a\0s\0t\0o\0s\0_\0b\0a\0n\0c\0o\0\0\0¯°ÿÿşÅÿÿFºÿÿşÅÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0$\0\0\0\0\0\0\0¶­ÿÿ­Æÿÿ‹\0\0X\0\02\0\0\0\0\0\0\0‹\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0`¾ÿÿ8Éÿÿ`¾ÿÿÈÊÿÿĞ¼ÿÿÈÊÿÿĞ¼ÿÿìÈÿÿ`¾ÿÿìÈÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0&\0\0\0\0\0\0\0­ÿÿwËÿÿy\0\0X\0\0,\0\0\0\0\0\0\0y\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\"\0f\0k\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\01\0\0\0JãÿÿœêÿÿJãÿÿ Ñÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0(\0\0\0\0\0\0\0ĞÿÿşÛÿÿ–\0\0X\0\07\0\0\0\0\0\0\0–\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\"\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0c\0o\0s\0t\0o\0s\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0€Úÿÿ`¾ÿÿ€ÚÿÿÌ¬ÿÿRêÿÿÌ¬ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0*\0\0\0\0\0\0\0/Ûÿÿ®ÿÿ³\0\0X\0\01\0\0\0\0\0\0\0³\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\"\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0g\0a\0s\0t\0o\0s\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0ıÿÿZ¦ÿÿıÿÿ4®ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0,\0\0\0\0\0\0\0dìÿÿ›©ÿÿÿ\0\0X\0\02\0\0\0\0\0\0\0ÿ\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0g\0a\0s\0t\0o\0s\0_\0b\0a\0n\0c\0o\01\0!C4\0\0\09\0\0:\0\0xV4\0\0\0\0\0E\0m\0a\0i\0l\0\0\0s|\0\0\0\0\0\0i|\0\0\0\0\0\0t|\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0)\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0:\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0T\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0E\0m\0a\0i\0l\0\0\0\0\0ÿÿVÈÿÿÃ˜ÿÿVÈÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0/\0\0\0\0\0\0\0n–ÿÿOÆÿÿw	\0\0X\0\02\0\0\0\0\0\0\0w	\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0e\0m\0a\0i\0l\0_\0p\0e\0r\0s\0o\0n\0a\0!C4\0\0\09\0\0;\n\0\0xV4\0\0\0\0\0E\0s\0t\0a\0d\0o\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0@p@\0\0\0\0\0Àp@\0\0\0\0\0\0@\0\0\0\0\0\0ğ?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ğ?\0\0\0\0\0\0\0\0˜;\"m\0\0\0\0\0\0\0\0 <\"mØX\"mX^éX^é\0\0\0\0\0\0\0\0\0\0\0\0\0\0xÍº\0\0\0\0\0\0\0\0\0 A\0\0‚C\0\0 A\0€„C\0\0 @\0\0‚C\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0;\n\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0n\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0E\0s\0t\0a\0d\0o\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0¾Øÿÿã¼ÿÿ¾Øÿÿ`¾ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\02\0\0\0\0\0\0\0¯Äÿÿö¼ÿÿ`\0\0X\0\01\0\0\0\0\0\0\0`\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\"\0f\0k\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0e\0s\0t\0a\0d\0o\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0!C4\0\0\09\0\0\0\0xV4\0\0\0\0\0C\0a\0t\0e\0g\0o\0r\0i\0a\0B\0a\0n\0c\0o\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0*\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0f\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0C\0a\0t\0e\0g\0o\0r\0i\0a\0B\0a\0n\0c\0o\0\0\0\0\0Ü\0\0í´ÿÿÜ\0\0,¶ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\08\0\0\0\0\0\0\05÷ÿÿá´ÿÿø\0\0X\0\02\0\0\0\0\0\0\0ø\0\0X\0\0\0\0\0\0\0\0\0€\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0f\0k\0_\0c\0a\0t\0e\0g\0o\0r\0i\0a\0b\0a\0n\0c\0o\0_\0b\0a\0n\0c\0o\0!C4\0\0\09\0\0\0\0xV4\0\0\0\0\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0\0\0êéi?\0\0€?\0\0€?×ÖV?ÜÛ[?êéi?\0\0€?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0é\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0d\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0\0\0\0\0tõÿÿÂ¶ÿÿäóÿÿÂ¶ÿÿäóÿÿÜºÿÿ6÷ÿÿÜºÿÿ6÷ÿÿ`¾ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0;\0\0\0\0\0\0\0Şàÿÿ‹»ÿÿí\0\0X\0\02\0\0\0\0\0\0\0í\0\0X\0\0\0\0\0\0\0ÿÿÿ\0\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0F\0K\0_\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0_\0C\0a\0t\0e\0g\0o\0r\0i\0a\0B\0a\0n\0c\0o\0!C4\0\0\09\0\0‰\0\0xV4\0\0\0\0\0D\0e\0t\0a\0l\0l\0e\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0‰\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0z\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0D\0e\0t\0a\0l\0l\0e\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0Fºÿÿø­ÿÿ¶ÿÿø­ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0>\0\0\0\0\0\0\0-¬ÿÿñ«ÿÿ‹\0\0X\0\01\0\0\0\0\0\0\0‹\0\0X\0\0\0\0\0\0\0ÿÿÿ\0\0\0€\0\0\0\0\0\0\0DB\0Tahoma-\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\0!C4\0\0\09\0\0‰\0\0xV4\0\0\0\0\0D\0e\0t\0a\0l\0l\0e\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0)\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0‰\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0p\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0D\0e\0t\0a\0l\0l\0e\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0‚çÿÿ^ÏÿÿÂ\0\0^Ïÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0A\0\0\0\0\0\0\0ëÿÿĞÿÿC\0\0X\0\02\0\0\0\0\0\0\0C\0\0X\0\0\0\0\0\0\0ÿÿÿ\0\0\0€\0\0\0\0\0\0\0DB\0Tahoma#\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0|üÿÿ:Çÿÿ|üÿÿ Ñÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0C\0\0\0\0\0\0\0†çÿÿËÿÿG\0\0X\0\02\0\0\0\0\0\0\0G\0\0X\0\0\0\0\0\0\0ÿÿÿ\0\0\0€\0\0\0\0\0\0\0DB\0Tahoma$\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0c\0o\0s\0t\0o\0s\0_\0c\0a\0t\0e\0g\0o\0r\0i\0a\0b\0a\0n\0c\0o\0!C4\0\0\09\0\0\0\0xV4\0\0\0\0\0U\0s\0u\0a\0r\0i\0o\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0 \0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0€£øŞ[	\0\0\0\0\0\0\0\0¼¦\0\0\0\0\0\0\0\0\0\0\0\0øcš\0\0\0\0\0\0\0\0\0X¼¦\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Èƒâ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0é[	\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0‹kƒGÀÇ;aŠßv†“ \0\0\0Hdš\0\0\0\0ˆƒâãrÙ•„”\'l$ßº§ğÇI\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0	#\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0X\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0U\0s\0u\0a\0r\0i\0o\0\0\0!C4\0\0\0\")\0\0µ\0\0xV4\0\0\0\0\0N\0u\0m\0O\0r\0d\0e\0n\0\0\0\0\0\0\0\0øŠç\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0µ\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0	\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0Z\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0	\0\0\0N\0u\0m\0O\0r\0d\0e\0n\0\0\0!C4\0\0\0\")\0\0d\0\0xV4\0\0\0\0\0P\0a\0g\0o\0E\0x\0t\0e\0r\0n\0o\0\0\0r\0\0\0êéi?\0\0€?\0\0€?×ÖV?ÜÛ[?êéi?\0\0€?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0,\0\0\0,\0\0\0,\0\0\04\0\0\0\0\0\0\0\0\0\0\0\")\0\0d\0\0\0\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0b\0\0H\0\0\0\0ß\0\0ì\0\0\'\0\0±\0\0\'\0\0Ë\0\0U\0\0\0\0\0\0\0\0\09\0\0‰\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\09\0\04\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\0\0\0\0Ñ1\0\0	#\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0ª\n\0\0\0\0xV4\0\0\0`\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0P\0a\0g\0o\0E\0x\0t\0e\0r\0n\0o\0\0\0\0\0\nöÿÿ,¶ÿÿ\nöÿÿr®ÿÿúçÿÿr®ÿÿúçÿÿ°Ÿÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0J\0\0\0\0\0\0\0-ìÿÿk¬ÿÿš\0\0X\0\02\0\0\0\0\0\0\0š\0\0X\0\0\0\0\0\0\0ÿÿÿ\0\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0F\0K\0_\0P\0a\0g\0o\0P\0r\0o\0v\0e\0e\0d\0o\0r\0_\0C\0a\0t\0e\0g\0o\0r\0i\0a\0B\0a\0n\0c\0o\0\0\0‚çÿÿö¾ÿÿRêÿÿö¾ÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0L\0\0\0\0\0\0\0/àÿÿï¼ÿÿv\0\0X\0\02\0\0\0\0\0\0\0v\0\0X\0\0\0\0\0\0\0ÿÿÿ\0\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0F\0K\0_\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0_\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0¯°ÿÿ<ÄÿÿRêÿÿ<Äÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0N\0\0\0\0\0\0\0 ÆÿÿëÄÿÿÁ\0\0X\0\02\0\0\0\0\0\0\0Á\0\0X\0\0\0\0\0\0\0ÿÿÿ\0\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0F\0K\0_\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0(Øÿÿ`¾ÿÿ(Øÿÿ^¶ÿÿÎÒÿÿ^¶ÿÿÎÒÿÿDËÿÿ>ÑÿÿDËÿÿ\0\0\0\0\0\0\0ğğğ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0P\0\0\0\0\0\0\0”Âÿÿä¸ÿÿ‹\0\0X\0\02\0\0\0\0\0\0\0‹\0\0X\0\0\0\0\0\0\0ÿÿÿ\0\0\0€\0\0\0\0\0\0\0DB\0Tahoma\0F\0K\0_\0N\0u\0m\0O\0r\0d\0e\0n\0_\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0şÿÿÿşÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0	\0\0\0\n\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0şÿÿÿşÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿÿ\0şÿ\n\0\0ÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Microsoft DDS Form 2.0\0\0\0\0Embedded Object\0\0\0\0\0ô9²q\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Na¼\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ûæ°éĞ­Q\0 ÉW9\0\0\0@¢=è¾×\0\0HE\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ä\0\0D\0a\0t\0a\0 \0S\0o\0u\0r\0c\0e\0=\0.\0;\0I\0n\0i\0t\0i\0a\0l\0 \0C\0a\0t\0a\0l\0o\0g\0=\0S\0e\0m\0m\0a\0r\0P\0l\0a\0t\0a\0f\0o\0r\0m\0a\0;\0I\0n\0t\0e\0g\0r\0a\0t\0e\0d\0 \0S\0e\0c\0u\0r\0i\0t\0y\0=\0T\0r\0u\0e\0;\0M\0u\0l\0t\0i\0p\0l\0e\0A\0c\0t\0i\0v\0e\0R\0e\0s\0u\0l\0t\0S\0e\0t\0s\0=\0F\0a\0l\0s\0e\0;\0C\0o\0n\0n\0e\0c\0t\0 \0T\0i\0m\0e\0o\0u\0t\0=\03\00\0;\0T\0r\0u\0s\0t\0S\0e\0r\0v\0e\0\0D\0d\0s\0S\0t\0r\0e\0a\0m\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\07\0\0\0Û;\0\0\0\0\0\0S\0c\0h\0e\0m\0a\0 \0U\0D\0V\0 \0D\0e\0f\0a\0u\0l\0t\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0&\0\0ÿÿÿÿÿÿÿÿÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0D\0S\0R\0E\0F\0-\0S\0C\0H\0E\0M\0A\0-\0C\0O\0N\0T\0E\0N\0T\0S\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0,\0\0\0\0\0\0\0ÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0h\0\0\0\0\0\0S\0c\0h\0e\0m\0a\0 \0U\0D\0V\0 \0D\0e\0f\0a\0u\0l\0t\0 \0P\0o\0s\0t\0 \0V\06\0\0\0\0\0\0\0\0\0\0\0\0\06\0\0ÿÿÿÿÿÿÿÿÿÿÿÿ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0IŸÿÿÒ»ÿÿ\0&\0\0\0s\0c\0h\0_\0l\0a\0b\0e\0l\0s\0_\0v\0i\0s\0i\0b\0l\0e\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0d\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0	\0\0\0	\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\n\0\0\0\n\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0\0\0\0\0\0\0\0\0\0\0@\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0p\0e\0r\0s\0o\0n\0a\0_\0b\0e\0n\0e\0f\0i\0c\0i\0a\0r\0i\0o\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0^ñ`^ñ\0\0\0\0\0\0\0\0­\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0>\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0p\0e\0r\0s\0o\0n\0a\0_\0t\0i\0p\0o\0p\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0eñ`eñ\0\0\0\0\0\0\0\0­\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0H\0\0\0*2p\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0o\0r\0d\0e\0n\0_\0o\0r\0d\0e\0n\0c\0o\0m\0p\0r\0a\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0eñ eñ\0\0\0\0\0\0\0\0­\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0@\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0o\0r\0d\0e\0n\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0`ñ `ñ\0\0\0\0\0\0\0\0­\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0T\0\0\0\0\0\0\0\0\0d\0b\0o\0\0\0f\0k\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0`ñ `ñ\0\0\0\0\0\0\0\0­\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0@\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0`ñ``ñ\0\0\0\0\0\0\0\0­\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0J\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0dñ dñ\0\0\0\0\0\0\0\0­\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0P\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0_ñà_ñ\0\0\0\0\0\0\0\0­\0\0\0\0\0!\0\0\0!\0\0\0\0\0\0\0H\0\0\0*2p\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0g\0a\0s\0t\0o\0s\0_\0b\0a\0n\0c\0o\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0\"\0\0\0\"\0\0\0!\0\0\0\0\0\0^ñ ^ñ\0\0\0\0\0\0\0\0­\0\0\0\0\0#\0\0\0#\0\0\0\0\0\0\0J\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0$\0\0\0$\0\0\0#\0\0\0\0\0\0_ñ`_ñ\0\0\0\0\0\0\0\0­\0\0\0\0\0%\0\0\0%\0\0\0\0\0\0\0V\0\0\0yst\0\0\0d\0b\0o\0\0\0f\0k\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\01\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0&\0\0\0&\0\0\0%\0\0\0\0\0\0dñàdñ\0\0\0\0\0\0\0\0­\0\0\0\0\0\'\0\0\0\'\0\0\0\0\0\0\0V\0\0\0yst\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0c\0o\0s\0t\0o\0s\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0(\0\0\0(\0\0\0\'\0\0\0\0\0\0dñ dñ\0\0\0\0\0\0\0\0­\0\0\0\0\0)\0\0\0)\0\0\0\0\0\0\0V\0\0\0\0\0\0\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0g\0a\0s\0t\0o\0s\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0*\0\0\0*\0\0\0)\0\0\0\0\0\0eñ eñ\0\0\0\0\0\0\0\0­\0\0\0\0\0+\0\0\0+\0\0\0\0\0\0\0J\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0g\0a\0s\0t\0o\0s\0_\0b\0a\0n\0c\0o\01\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0,\0\0\0,\0\0\0+\0\0\0\0\0\0ï`ï\0\0\0\0\0\0\0\0­\0\0\0\0\0-\0\0\0-\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0.\0\0\0.\0\0\0\0\0\0\02\0\0\0…ú\0\0\0d\0b\0o\0\0\0f\0k\0_\0e\0m\0a\0i\0l\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0/\0\0\0/\0\0\0.\0\0\0\0\0\0TğÈTğ\0\0\0\0\0\0\0\0­\0\0\0\0\00\0\0\00\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\01\0\0\01\0\0\0\0\0\0\0V\0\0\0\0\0\0\0\0\0d\0b\0o\0\0\0f\0k\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0e\0s\0t\0a\0d\0o\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\02\0\0\02\0\0\01\0\0\0\0\0\0UğUğ\0\0\0\0\0\0\0\0­\0\0\0\0\03\0\0\03\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\07\0\0\07\0\0\0\0\0\0\0@\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0f\0k\0_\0c\0a\0t\0e\0g\0o\0r\0i\0a\0b\0a\0n\0c\0o\0_\0b\0a\0n\0c\0o\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\08\0\0\08\0\0\07\0\0\0\0\0\0TğˆTğ\0\0\0\0\0\0\0\0­\0\0\0\0\09\0\0\09\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0:\0\0\0:\0\0\0\0\0\0\0P\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0F\0K\0_\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0_\0C\0a\0t\0e\0g\0o\0r\0i\0a\0B\0a\0n\0c\0o\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0;\0\0\0;\0\0\0:\0\0\0\0\0\0TğHTğ\0\0\0\0\0\0\0\0­\0\0\0\0\0<\0\0\0<\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0=\0\0\0=\0\0\0\0\0\0\0l\0\0\0\0\0\0\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\0_\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0>\0\0\0>\0\0\0=\0\0\0\0\0\0TğTğ\0\0\0\0\0\0\0\0­\0\0\0\0\0?\0\0\0?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0@\0\0\0@\0\0\0\0\0\0\0X\0\0\0yst\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0e\0t\0a\0l\0l\0e\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0_\0o\0r\0d\0e\0n\0c\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0A\0\0\0A\0\0\0@\0\0\0\0\0\0PğˆPğ\0\0\0\0\0\0\0\0­\0\0\0\0\0B\0\0\0B\0\0\0\0\0\0\0Z\0\0\0ÿÿÿ\0\0\0d\0b\0o\0\0\0f\0k\0_\0d\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0c\0o\0s\0t\0o\0s\0_\0c\0a\0t\0e\0g\0o\0r\0i\0a\0b\0a\0n\0c\0o\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0C\0\0\0C\0\0\0B\0\0\0\0\0\0SğÈSğ\0\0\0\0\0\0\0\0­\0\0\0\0\0D\0\0\0D\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\01\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0E\0\0\0E\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0F\0\0\0F\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ğ\0\0\0(\0\0\0A\0c\0t\0i\0v\0e\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0\0\0\0\0\0\0\0\0\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\00\0\0\0\0\0\0\0:\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\0,\01\08\09\00\0,\05\0,\01\02\06\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\01\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\02\05\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\02\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\03\0\0\0\0\0\0\0\0\0\02\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0\0\0 \0\0\0T\0a\0b\0l\0e\0V\0i\0e\0w\0M\0o\0d\0e\0:\04\0\0\0\0\0\0\0>\0\0\04\0,\00\0,\02\08\04\0,\00\0,\02\03\01\00\0,\01\02\0,\02\07\03\00\0,\01\01\0,\01\06\08\00\0\0\0I\0\0\0I\0\0\0\0\0\0\0P\0\0\0?¤Z\0\0\0d\0b\0o\0\0\0F\0K\0_\0P\0a\0g\0o\0P\0r\0o\0v\0e\0e\0d\0o\0r\0_\0C\0a\0t\0e\0g\0o\0r\0i\0a\0B\0a\0n\0c\0o\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0J\0\0\0J\0\0\0I\0\0\0\0\0\0PğHPğ\0\0\0\0\0\0\0\0­\0\0\0\0\0K\0\0\0K\0\0\0\0\0\0\0L\0\0\0\05\0\0\0\0d\0b\0o\0\0\0F\0K\0_\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0_\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0L\0\0\0L\0\0\0K\0\0\0\0\0\0NğÈNğ\0\0\0\0\0\0\0\0­\0\0\0\0\0M\0\0\0M\0\0\0\0\0\0\0B\0\0\0*2p\0\0\0d\0b\0o\0\0\0F\0K\0_\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0_\0p\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0N\0\0\0N\0\0\0M\0\0\0\0\0\0OğˆOğ\0\0\0\0\0\0\0\0­\0\0\0\0\0O\0\0\0O\0\0\0\0\0\0\0B\0\0\0*2p\0\0\0d\0b\0o\0\0\0F\0K\0_\0N\0u\0m\0O\0r\0d\0e\0n\0_\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0\0\0\0\0\0Ä\0\0\0\0P\0\0\0P\0\0\0O\0\0\0\0\0\0SğˆSğ\0\0\0\0\0\0\0\0­\0\0\0\0\0}\0\0\0!\0\0\0\0\0\0\0\0\0\0\0\0\0?\0\0\0+\0\0\0\0\0\0\0\0\0\0\0\0\0?\0\0\07\0\0\0\0\0\03\0\0\0\0\0\06\0\0\0=\0\0\0\0\0\0<\0\0\0N\0\0\0Q\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0¬\0\0\0%\0\0\0\0\0\0\0\0\0\0\0\0¬\0\0\0\0\0\0\0\0\0\0\0\02\0\0\0\0\0\0K\0\0\0\0\0\09\0\0\0‹\0\0\0@\0\0\0\'\0\0\0\0\0\0\0\0\0}\0\0\0\0\0\0\0)\0\0\0\0\0\0\0\0\0^\0\0\0~\0\0\0@\0\0\0\0\0\0?\0\0\0Ã\0\0\0X\0\0\0O\0\0\0\0\0\0E\0\0\0V\0\0\0‹\0\0\0\0\0\0\0\0\0	\0\0\0\0\0\0\09\0\0\0M\0\0\0\n\0\0\09\0\0\0{\0\0\0R\0\0\0.\0\0\0\n\0\0\0-\0\0\0ˆ\0\0\0A\0\0\0\0\0\0\n\0\0\0	\0\0\0\0\0\0>\0\0\0\0\0\0\n\0\0\0\0\0\0\0\0\0°\0\0\0\0\0\0\n\0\0\0\0\0\0%\0\0\0\0\0\0#\0\0\0\n\0\0\0\0\0\0\0\0\0 \0\0\0\0\0\0\0\0\0\n\0\0\0]\0\0\0>\0\0\0\0\0\0\0\0\0\n\0\0\0>\0\0\0\0\0\01\0\0\00\0\0\0\0\0\0\0\0\0X\0\0\0I\0\0\03\0\0\0F\0\0\0\0\0\0\0‰\0\0\0:\0\0\03\0\0\09\0\0\0@\0\0\0*\0\0\0B\0\0\03\0\0\0\0\0\0\0\0\0V\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0r\0C\0e\0r\0t\0i\0f\0i\0c\0a\0t\0e\0=\0F\0a\0l\0s\0e\0;\0P\0a\0c\0k\0e\0t\0 \0S\0i\0z\0e\0=\04\00\09\06\0;\0A\0p\0p\0l\0i\0c\0a\0t\0i\0o\0n\0 \0N\0a\0m\0e\0=\0\"\0M\0i\0c\0r\0o\0s\0o\0f\0t\0 \0S\0Q\0L\0 \0S\0e\0r\0v\0e\0r\0 \0M\0a\0n\0a\0g\0e\0m\0e\0n\0t\0 \0S\0t\0u\0d\0i\0o\0\"\0\0\0\0€\0\0\0\0D\0i\0a\0g\0r\0a\0m\0_\00\0\0\0\0&\0\0\0\0P\0a\0g\0o\0E\0x\0t\0e\0r\0n\0o\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0N\0u\0m\0O\0r\0d\0e\0n\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0U\0s\0u\0a\0r\0i\0o\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0(\0\0\0D\0e\0t\0a\0l\0l\0e\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0d\0b\0o\0\0\0\0&\02\0\0\0D\0e\0t\0a\0l\0l\0e\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0T\0r\0a\0n\0s\0a\0c\0c\0i\0o\0n\0e\0s\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0C\0a\0t\0e\0g\0o\0r\0i\0a\0B\0a\0n\0c\0o\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0&\0\0\0E\0s\0t\0a\0d\0o\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0E\0m\0a\0i\0l\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0B\0e\0n\0e\0f\0i\0c\0i\0a\0r\0i\0o\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0T\0i\0p\0o\0P\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0p\0e\0r\0s\0o\0n\0a\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0D\0e\0t\0a\0l\0l\0e\0O\0r\0d\0e\0n\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0O\0r\0d\0e\0n\0C\0o\0m\0p\0r\0a\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0O\0r\0d\0e\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0&\0\0\0D\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0G\0a\0s\0t\0o\0s\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0&\0\0\0D\0i\0s\0t\0r\0i\0b\0u\0c\0i\0o\0n\0C\0o\0s\0t\0o\0s\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0$\0\0\0d\0e\0t\0a\0l\0l\0e\0c\0o\0t\0i\0z\0a\0c\0i\0o\0n\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0\0\0\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0\0\0\0\0\0d\0b\0o\0\0\0\0&\0$\0\0\0C\0o\0t\0i\0z\0a\0c\0i\0o\0n\0C\0l\0i\0e\0n\0t\0e\0\0\0\0\0\0d\0b\0o\0\0\0\0$\0\0\0\0B\0a\0n\0c\0o\0\0\0\0\0\0d\0b\0o\0\0\0\0\0\0Ö…	³»kòEš¸7dğ2p\0N\0\0\0{\01\06\03\04\0C\0D\0D\07\0-\00\08\08\08\0-\04\02\0E\03\0-\09\0F\0A\02\0-\0B\06\0D\03\02\05\06\03\0B\09\01\0D\0}\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0bˆR");



DROP TABLE IF EXISTS tipopersona;

CREATE TABLE `tipopersona` (
  `id_tipo_persona` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_persona`),
  KEY `ix_tmp_autoinc` (`id_tipo_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO tipopersona VALUES("1","NATURAL");
INSERT INTO tipopersona VALUES("2","JURI");



DROP TABLE IF EXISTS transacciones;

CREATE TABLE `transacciones` (
  `id_transacciones` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) DEFAULT NULL,
  `id_ordencli` varchar(20) DEFAULT NULL,
  `id_cat_banco` int(11) DEFAULT NULL,
  `monto_tra` decimal(18,2) DEFAULT NULL,
  `tipo_tra` varchar(20) DEFAULT NULL,
  `fecha_tra` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_transacciones`),
  KEY `ix_tmp_autoinc` (`id_transacciones`),
  KEY `fk_transacciones_categoriabanco` (`id_cat_banco`),
  KEY `fk_transacciones_ordencliente` (`id_ordencli`),
  KEY `fk_transacciones_persona` (`id_persona`),
  CONSTRAINT `fk_transacciones_categoriabanco` FOREIGN KEY (`id_cat_banco`) REFERENCES `categoriabanco` (`id_cat_banco`),
  CONSTRAINT `fk_transacciones_ordencliente` FOREIGN KEY (`id_ordencli`) REFERENCES `ordencliente` (`id_ordencli`),
  CONSTRAINT `fk_transacciones_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS usuario;

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `tipo_usuario` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `ix_tmp_autoinc` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO usuario VALUES("1","CE","1","ADMINISTRADOR","ACTIVO");



SET FOREIGN_KEY_CHECKS=1;