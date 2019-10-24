-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2019 at 06:12 AM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `labWeb`
--
CREATE DATABASE IF NOT EXISTS `labWeb` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `labWeb`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarVinculacion` (IN `pidEmp` INT, IN `pidRoute` INT, IN `pdur` INT, IN `pcost` INT, IN `pdis` INT, IN `pidUser` INT, IN `phIni` VARCHAR(80), IN `phFin` VARCHAR(80))  NO SQL
BEGIN
	UPDATE  RutaXEmpresa
    set 
    	duracion = pdur    ,
        discapacitado = pdis,
        costo = pcost ,
        horarioInicio =phIni , 
        horarioFin  = phFin
    WHERE idEmpresa = pidEmp AND
    	  idRuta    = pidRoute;

CALL crearLog("Actualización Empresa y Ruta",now(),pidUser,'Empresa');

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cambiarContrasena` (IN `puser` VARCHAR(45), IN `pnueva` VARCHAR(105))  NO SQL
    DETERMINISTIC
BEGIN
	UPDATE Usuario  
    set contrasena =  pnueva
    WHERE  puser =   usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkUsuario` (IN `puser` VARCHAR(50))  NO SQL
BEGIN
    SELECT EXISTS(SELECT usuario FROM Usuario WHERE usuario = puser and activado = 1) 	AS existe;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `crearEmpresa` (IN `pname` VARCHAR(100), IN `pzona` VARCHAR(150), IN `pdir` VARCHAR(200), IN `plat` DOUBLE, IN `plong` DOUBLE, IN `ptel` VARCHAR(20), IN `pmail` VARCHAR(100), IN `psos` VARCHAR(20), IN `piduser` INT, IN `phorario` INT, IN `phora2` INT)  NO SQL
BEGIN
	INSERT INTO Empresa (nombre, zona, direccionFisica, latitud, longitud, telefono, correo, horario1,horario2, contactoEmergencia, idUsuario )
    values(pname, pzona, pdir, plat, plong, ptel, pmail, phorario,phora2, psos, 	 piduser);
    
    call crearLog("Crear Empresa", now(), piduser, "Empresa");
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `crearLog` (IN `paccion` VARCHAR(200), IN `pfecha` DATE, IN `piduser` INT, IN `pnameTabla` VARCHAR(200))  NO SQL
BEGIN
	INSERT into LogHistorial (accion, fecha, idUsuario, nombreTabla)
    VALUES  (paccion,pfecha, piduser, pnameTabla);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `crearParada` (IN `idRoute` INT, IN `plng` DOUBLE, IN `plat` DOUBLE, IN `piduser` INT)  NO SQL
BEGIN
INSERT INTO Parada (idRuta, longitud, latitud)
VALUES (idRoute,plng,plat);  
call crearLog("Crear Ruta", now(), piduser, "Ruta");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `crearRuta` (IN `pnumero` VARCHAR(100), IN `pdescp` VARCHAR(250), IN `latptoIni` DOUBLE, IN `lngptoIni` DOUBLE, IN `latptoFin` DOUBLE, IN `lngptoFin` DOUBLE, IN `pidUser` INT, IN `pInicio` INT, IN `pDesti` INT)  NO SQL
BEGIN
	INSERT into Ruta(numeroRuta, descripcion,puntoInicioLat,puntoInicioLng,ptoFinalLat,ptoFinalLng,idUsuario, lugarInicio, lugarDestino) 
    values (pnumero,pdescp,latptoIni,lngptoIni,latptoFin,lngptoFin,pidUser,pInicio,pDesti );

call crearLog("Crear Ruta", now(), pidUser, "Ruta");
select max(idRuta) FROM Ruta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `desactivarUsuario` (IN `piduser` INT, IN `puser` VARCHAR(45), IN `pcontra` VARCHAR(105))  NO SQL
BEGIN
UPDATE Usuario 
set activado = 0 
where idusuario  =  piduser and puser  = usuario  and contrasena = pcontra;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deshabilitarEmpresa` (IN `pcmpny` INT, IN `piduser` INT)  NO SQL
BEGIN
	
	UPDATE Empresa  
    set activado = not activado
    WHERE  idEmpresa =  pcmpny;
    
    call crearLog("Habilitación de Empresa", now(), piduser, "Empresa");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deshabilitarRuta` (IN `idRoute` INT)  NO SQL
BEGIN
	
	UPDATE Ruta  
    set activado = not activado
    WHERE  idRuta =  idRoute;
    
    call crearLog("Habilitación de Ruta", now(), piduser, "Ruta");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deshabilitarVinculacion` (IN `pemp` INT, IN `proute` INT, IN `piduser` INT)  NO SQL
BEGIN
	DELETE FROM RutaXEmpresa
    where idEmpresa  = pemp and idRuta =proute;
    call crearLog("Desvinculación Empresa/Ruta", now(), piduser, "Empresa");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `editarEmpresa` (IN `pidcpy` INT, IN `emer` VARCHAR(20), IN `pmail` VARCHAR(100), IN `pdirf` VARCHAR(200), IN `piduser` INT, IN `plat` DOUBLE, IN `plong` DOUBLE, IN `pname` VARCHAR(100), IN `ptel` VARCHAR(20), IN `pzone` VARCHAR(100), IN `phoras` INT, IN `phoras2` INT)  NO SQL
BEGIN
	UPDATE  Empresa  
    set contactoEmergencia =   emer,
    	correo             =   pmail,
        direccionFisica    =   pdirf , 
        horario1           =   phoras ,  
        horario2           =   phoras2 ,  
        idUsuario          =   piduser , 
        latitud            =   plat,
        longitud           =   plong,
        nombre             =   pname,
        telefono           =   ptel,
        zona               =   pzone
    WHERE  idEmpresa  =  pidcpy;
    
    call crearLog("Actualizar Empresa", now(), piduser, "Empresa");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `editarRuta` (IN `pnumero` VARCHAR(100), IN `pdescp` VARCHAR(250), IN `latptoIni` DOUBLE, IN `lngptoIni` DOUBLE, IN `latptoFin` DOUBLE, IN `lngptoFin` DOUBLE, IN `pidUser` INT, IN `pInicio` INT, IN `pDesti` INT, IN `pidRuta` INT)  NO SQL
BEGIN
	UPDATE Ruta SET
    numeroRuta = pnumero,
    descripcion = pdescp,
    puntoInicioLat = latptoIni,
    puntoInicioLng = lngptoIni,
    ptoFinalLat = latptoFin,
    ptoFinalLng = lngptoFin,
    idUsuario = pidUser,
    lugarInicio = pInicio,
    lugarDestino = pDesti
    WHERE idRuta = pidRuta;
call crearLog("Editar Ruta", now(), pidUser, "Ruta");

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getClave` (IN `puser` VARCHAR(50))  NO SQL
BEGIN
	SELECT contrasena from Usuario WHERE usuario = puser;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getEmpresaIndividual` (IN `pidempre` INT)  NO SQL
BEGIN
	SELECT contactoEmergencia, correo, direccionFisica, horario1,horario2, idUsuario, latitud, longitud, nombre, telefono, zona, activado from Empresa where 
     idEmpresa =  pidempre ;



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getEmpresas` ()  NO SQL
BEGIN
	SELECT idEmpresa, nombre, zona, latitud, longitud, direccionFisica, 	horario1,horario2, telefono, correo, contactoEmergencia from Empresa ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getEmpresasSimple` ()  NO SQL
BEGIN
	SELECT  idEmpresa ,  nombre
    from Empresa;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getIdUser` (IN `puser` VARCHAR(50))  NO SQL
BEGIN
SELECT idUsuario from Usuario WHERE Usuario.usuario = puser;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getLog` (IN `pidUser` INT, IN `pArea` VARCHAR(100), IN `pfecha` VARCHAR(20))  NO SQL
BEGIN
DECLARE  idRes int;
DECLARE  areaP varchar(100);
DECLARE  fechaP varchar(20);

if pidUser = 0 THEN
	set idRes = null;
ELSE 
	set idRes = pidUser;
end if;
if pArea = "-"THEN
	set areaP = null;
ELSE 
	set areaP = pArea;
end if;
if pfecha = "-"THEN
	set fechaP = null;
ELSE 
	set fechaP = pfecha;
end if;



SELECT  data2.usuario , data1.nombreTabla,  data1.accion, data1.fecha
from (
    SELECT  idUsuario, nombreTabla, accion, fecha
    from LogHistorial 
    where  nombreTabla =  ifnull(areaP, nombreTabla) AND
    		idUsuario   =  ifnull(idRes, idUsuario) and
    		fecha =  ifnull (date(fechaP), fecha)
      
	) as data1 
inner join Usuario data2
on data1.idUsuario  =  data2.idusuario;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getLogSimple` ()  NO SQL
BEGIN
SELECT  data2.usuario , data1.nombreTabla,  data1.accion, data1.fecha
from (
    SELECT  idUsuario, nombreTabla, accion, fecha
    from LogHistorial 
	) as data1 
inner join Usuario data2
on data1.idUsuario  =  data2.idusuario;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getMaxRuta` ()  NO SQL
BEGIN
SELECT MAX(idRuta) from Ruta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getParadas` (IN `pidroute` INT)  NO SQL
BEGIN


SELECT latitud , longitud 
FROM Parada where idRuta = pidroute;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProvincias` ()  NO SQL
BEGIN
SELECT * from Provincia;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getRutas` ()  NO SQL
SELECT idRuta,numeroRuta, descripcion, lugarInicio, lugarDestino, ptoFinalLat, ptoFinalLng, puntoInicioLat,puntoInicioLng , idUser 
from Ruta
where activado =  true$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getRutasIndividual` (IN `pidRuta` INT)  NO SQL
BEGIN

SELECT data5.numeroRuta, data5.descripcion, data5.idDist idDistritoDestino, data5.nombre,     data3.idDistrito idDistritoPartida,data3.nombre nombre2,data5.puntoInicioLat, data5.puntoInicioLng, data5.ptoFinalLat,
	data5.ptoFinalLng, data5.usuario, data5.activado
FROM (

SELECT data1.numeroRuta,data1.descripcion, data2.nombre , data1.lugarInicio idDist, data1.lugarDestino, data1.puntoInicioLat, data1.puntoInicioLng, data1.ptoFinalLat, data1.ptoFinalLng, data4.usuario ,data1.activado
FROM(
    SELECT numeroRuta, descripcion, lugarInicio, lugarDestino, ptoFinalLat, ptoFinalLng, puntoInicioLat,puntoInicioLng , idUsuario ,activado
    from Ruta
    where activado =  true and idRuta = pidRuta 
    ) as data1
INNER JOIN Distrito data2 
on data2.idDistrito = data1.lugarInicio
INNER JOIN Usuario data4 
on data4.idusuario = data1.idUsuario

) data5
INNER JOIN Distrito data3 
on data3.idDistrito = data5.lugarDestino;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getRutasSimple` ()  NO SQL
BEGIN
SELECT Ruta.idRuta, Ruta.numeroRuta FROM Ruta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsers` ()  NO SQL
BEGIN
SELECT Usuario.usuario, Usuario.idusuario FROM Usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getVinculacion` (IN `pidRoute` INT, IN `pidEmp` INT)  NO SQL
BEGIN
	DECLARE vin  int;
    DECLARE res boolean;
    set vin = 0;
    set res =false; 
    SELECT costo into vin from RutaXEmpresa 
    where idRuta  = pidRoute and pidEmp = idEmpresa;
    
    if vin != 0 THEN
    	set res = true;
    END if;
    
    SELECT res;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getVinculacionIndividual` (IN `pidRoute` INT, IN `pidEmp` INT)  NO SQL
BEGIN
SELECT  duracion, costo, discapacitado, activado,horarioInicio, horarioFin
FROM RutaXEmpresa
WHERE idEmpresa  =pidEmp  and
 	   idRuta    =pidRoute;
       
       
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `linkearRutaEmpresa` (IN `pidemp` INT, IN `pidrut` INT, IN `pcost` INT, IN `pdur` INT, IN `pdisc` TINYINT, IN `pidUser` INT, IN `phInicio` VARCHAR(80), IN `phFin` VARCHAR(80))  NO SQL
BEGIN
INSERT INTO RutaXEmpresa (idEmpresa, idRuta, costo, duracion, discapacitado, activado, horarioInicio, horarioFin) 
VALUES (pidemp,pidrut,pcost,pdur,pdisc,1,phInicio,phFin  );
CALL crearLog("Link de Empresa y Ruta",now(),pidUser,'Empresa');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerCantones` (IN `pprov` INT)  NO SQL
BEGIN
SELECT * from Canton WHERE Canton.idProvincia = pprov;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerDistritos` (IN `pcant` INT)  NO SQL
BEGIN
SELECT * FROM Distrito WHERE Distrito.idCanton = pcant;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerUltimoId` ()  NO SQL
BEGIN
COMMIT;
SELECT LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrarUsuario` (IN `pnombre` VARCHAR(45), IN `pap1` VARCHAR(45), IN `pap2` VARCHAR(45), IN `puser` VARCHAR(45), IN `pmail` VARCHAR(45), IN `pcelular` VARCHAR(45), IN `ptelefono` VARCHAR(45), IN `pclave` VARCHAR(105))  NO SQL
BEGIN
	insert into Usuario (nombre, apellido1, apellido2, usuario, email, celular, telefono, contrasena)
	values(pnombre, pap1,  pap2, puser, pmail, pcelular, ptelefono, pclave);
    
   
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Canton`
--

CREATE TABLE `Canton` (
  `idProvincia` int(11) NOT NULL,
  `idCanton` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `Canton`
--

INSERT INTO `Canton` (`idProvincia`, `idCanton`, `nombre`) VALUES
(1, 1, 'SAN JOSE'),
(1, 2, 'ESCAZU'),
(1, 3, 'DESAMPARADOS'),
(1, 4, 'PURISCAL'),
(1, 5, ' TARRAZU'),
(1, 6, 'ASERRI'),
(1, 7, ' MORA'),
(1, 8, ' GOICOECHEA'),
(1, 9, 'SANTA ANA'),
(1, 10, ' ALAJUELITA'),
(1, 11, ' CORONADO'),
(1, 12, ' ACOSTA'),
(1, 13, ' TIBAS'),
(1, 14, ' MORAVIA'),
(1, 15, ' MONTES DE OCA'),
(1, 16, ' TURRUBARES'),
(1, 17, ' DOTA'),
(1, 18, ' CURRIDABAT'),
(1, 19, ' PEREZ ZELEDON'),
(1, 20, ' LEON CORTES'),
(2, 201, 'ALAJUELA'),
(2, 202, ' SAN RAMON'),
(2, 203, '  GRECIA'),
(2, 204, ' SAN MATEO'),
(2, 205, ' ATENAS'),
(2, 206, ' NARANJO'),
(2, 207, ' PALMARES'),
(2, 208, ' POAS'),
(2, 209, ' OROTINA'),
(2, 210, ' SAN CARLOS'),
(2, 211, ' ALFARO RUIZ'),
(2, 212, ' VALVERDE VEGA'),
(2, 213, ' UPALA'),
(2, 214, ' LOS CHILES'),
(2, 215, ' GUATUSO'),
(2, 216, ' RIO CUARTO'),
(3, 301, ' CARTAGO'),
(3, 302, ' PARAISO'),
(3, 303, ' LA UNION'),
(3, 304, ' JIMENEZ'),
(3, 305, ' TURRIALBA'),
(3, 306, ' ALVARADO'),
(3, 307, 'OREAMUNO'),
(3, 308, ' EL GUARCO'),
(4, 401, ' HEREDIA'),
(4, 402, ' BARVA'),
(4, 403, ' SANTO DOMINGO'),
(4, 404, ' SANTA BARBARA'),
(4, 405, ' SAN RAFAEL'),
(4, 406, ' SAN ISIDRO'),
(4, 407, ' BELEN'),
(4, 408, ' FLORES'),
(4, 409, ' SAN PABLO'),
(4, 410, ' SARAPIQUI'),
(5, 501, ' LIBERIA'),
(5, 502, ' NICOYA'),
(5, 503, ' SANTA CRUZ'),
(5, 504, ' BAGACES'),
(5, 505, ' CARRILLO'),
(5, 506, ' CAÑAS'),
(5, 507, ' ABANGARES'),
(5, 508, ' TILARAN'),
(5, 509, 'NANDAYURE'),
(5, 510, ' LA CRUZ'),
(5, 511, ' HOJANCHA'),
(6, 601, ' PUNTARENAS'),
(6, 602, ' ESPARZA'),
(6, 603, ' BUENOS AIRES'),
(6, 604, ' MONTES DE ORO'),
(6, 605, ' OSA'),
(6, 606, ' AGUIRRE'),
(6, 607, ' GOLFITO'),
(6, 608, ' COTO BRUS'),
(6, 609, ' PARRITA'),
(6, 610, ' CORREDORES'),
(6, 611, ' GARABITO'),
(7, 701, ' LIMON'),
(7, 702, ' POCOCI'),
(7, 703, ' SIQUIRRES'),
(7, 704, ' TALAMANCA'),
(7, 705, ' MATINA'),
(7, 706, ' GUACIMO');

-- --------------------------------------------------------

--
-- Table structure for table `Distrito`
--

CREATE TABLE `Distrito` (
  `idCanton` int(11) NOT NULL,
  `idDistrito` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `Distrito`
--

INSERT INTO `Distrito` (`idCanton`, `idDistrito`, `nombre`) VALUES
(1, 101, 'Carmen'),
(1, 102, 'Merced'),
(1, 103, 'Hospital'),
(1, 104, 'Catedral'),
(1, 105, 'Zapote'),
(1, 106, 'San Francisco de Dos Ríos'),
(1, 107, 'Uruca'),
(1, 108, 'Mata Redonda'),
(1, 109, 'Pavas'),
(1, 110, 'Hatillo'),
(1, 111, 'San Sebastián'),
(2, 201, 'Escazú'),
(2, 202, 'San Antonio'),
(2, 203, 'San Rafael'),
(3, 301, 'Desamparados'),
(3, 302, 'San Miguel'),
(3, 303, 'San Juan de Dios'),
(3, 304, 'San Rafael Arriba'),
(3, 305, 'San Antonio'),
(3, 306, 'Frailes'),
(3, 307, 'Patarrá'),
(3, 308, 'San Cristóbal'),
(3, 309, 'Rosario'),
(3, 310, 'Damas'),
(3, 311, 'San Rafael Abajo'),
(3, 312, 'Gravilias'),
(3, 313, 'Los Guido'),
(4, 401, 'Santiago'),
(4, 402, 'Mercedes Sur'),
(4, 403, 'Barbacoas'),
(4, 404, 'Grifo Alto'),
(4, 405, 'San Rafael'),
(4, 406, 'Candelarita'),
(4, 407, 'Desamparaditos'),
(4, 408, 'San Antonio'),
(4, 409, 'Chires'),
(4, 410, 'La Cangreja'),
(5, 501, 'San Marcos'),
(5, 502, 'San Lorenzo'),
(5, 503, 'San Carlos'),
(6, 601, 'Aserrí'),
(6, 602, 'Tarbaca o Praga'),
(6, 603, 'Vuelta de Jorco'),
(6, 604, 'San Gabriel'),
(6, 605, 'La Legua'),
(6, 606, 'Monterrey'),
(6, 607, 'Salitrillos'),
(7, 701, 'Ciudad Colón'),
(7, 702, 'Guayabo'),
(7, 703, 'Tabarcia'),
(7, 704, 'Piedras Negras'),
(7, 705, 'Picagres'),
(7, 706, 'Jaris'),
(7, 707, 'Quitirrisi'),
(8, 801, 'Guadalupe'),
(8, 802, 'San Francisco'),
(8, 803, 'Calle Blancos'),
(8, 804, 'Mata de Plátano'),
(8, 805, 'Ipís'),
(8, 806, 'Rancho Redondo'),
(8, 807, 'Purral'),
(9, 901, 'Santa Ana'),
(9, 902, 'Salitral'),
(9, 903, 'Pozos o Concepción'),
(9, 904, 'Uruca o San Joaquín'),
(9, 905, 'Piedades'),
(9, 906, 'Brasil'),
(10, 1001, 'Alajuelita'),
(10, 1002, 'San Josecito'),
(10, 1003, 'San Antonio'),
(10, 1004, 'Concepción'),
(10, 1005, 'San Felipe'),
(11, 1101, 'San Isidro'),
(11, 1102, 'San Rafael'),
(11, 1103, 'Dulce Nombre o Jesús'),
(11, 1104, 'Patalillo'),
(11, 1105, 'Cascajal'),
(12, 1201, 'San Ignacio'),
(12, 1202, 'Guaitil'),
(12, 1203, 'Palmichal'),
(12, 1204, 'Cangrejal'),
(12, 1205, 'Sabanillas'),
(13, 1301, 'San Juan'),
(13, 1302, 'Cinco Esquinas'),
(13, 1303, 'Anselmo Llorente'),
(13, 1304, 'León XIII'),
(13, 1305, 'Colima'),
(14, 1401, 'San Vicente'),
(14, 1402, 'San Jerónimo'),
(14, 1403, 'La Trinidad'),
(15, 1501, 'San Pedro'),
(15, 1502, 'Sabanilla'),
(15, 1503, 'Mercedes o Betania'),
(15, 1504, 'San Rafael'),
(16, 1601, 'San Pablo'),
(16, 1602, 'San Pedro'),
(16, 1603, 'San Juan de Mata'),
(16, 1604, 'San Luis'),
(16, 1605, 'Carara'),
(17, 1701, 'Santa María'),
(17, 1702, 'Jardín'),
(17, 1703, 'Copey'),
(18, 1801, 'Curridabat'),
(18, 1802, 'Granadilla'),
(18, 1803, 'Sánchez'),
(18, 1804, 'Tirrases'),
(19, 1901, 'San Isidro de El General'),
(19, 1902, 'General'),
(19, 1903, 'Daniel Flores'),
(19, 1904, 'Rivas'),
(19, 1905, 'San Pedro'),
(19, 1906, 'Platanares'),
(19, 1907, 'Pejibaye'),
(19, 1908, 'Cajón o Carmen'),
(19, 1909, 'Barú'),
(19, 1910, 'Río Nuevo'),
(19, 1911, 'Páramo'),
(19, 1912, 'La Amistad'),
(20, 2001, 'San Pablo'),
(20, 2002, 'San Andrés'),
(20, 2003, 'Llano Bonito'),
(20, 2004, 'San Isidro'),
(20, 2005, 'Santa Cruz'),
(20, 2006, 'San Antonio'),
(201, 2101, 'Alajuela'),
(201, 2102, 'San José'),
(201, 2103, 'Carrizal'),
(201, 2104, 'San Antonio'),
(201, 2105, 'Guácima'),
(201, 2106, 'San Isidro'),
(201, 2107, 'Sabanilla'),
(201, 2108, 'San Rafael'),
(201, 2109, 'Río Segundo'),
(201, 2110, 'Desamparados'),
(201, 2111, 'Turrucares'),
(201, 2112, 'Tambor'),
(201, 2113, 'La Garita'),
(201, 2114, 'Sarapiquí'),
(202, 2201, 'San Ramón'),
(202, 2202, 'Santiago'),
(202, 2203, 'San Juan'),
(202, 2204, 'Piedades Norte'),
(202, 2205, 'Piedades Sur'),
(202, 2206, 'San Rafael'),
(202, 2207, 'San Isidro'),
(202, 2208, 'Angeles'),
(202, 2209, 'Alfaro'),
(202, 2210, 'Volio'),
(202, 2211, 'Concepción'),
(202, 2212, 'Zapotal'),
(202, 2213, 'San Isidro de Peñas Blancas'),
(202, 2214, 'San Lorenzo'),
(203, 2301, 'Grecia'),
(203, 2302, 'San Isidro'),
(203, 2303, 'San José'),
(203, 2304, 'San Roque'),
(203, 2305, 'Tacares'),
(203, 2306, 'Puente Piedra'),
(203, 2307, 'Bolívar'),
(204, 2401, 'San Mateo'),
(204, 2402, 'Desmonte'),
(204, 2403, 'Jesús María'),
(204, 2404, 'Labrador'),
(205, 2501, 'Atenas'),
(205, 2502, 'Jesús'),
(205, 2503, 'Mercedes'),
(205, 2504, 'San Isidro'),
(205, 2505, 'Concepción'),
(205, 2506, 'San José'),
(205, 2507, 'Santa Eulalia'),
(205, 2508, 'Escobal'),
(206, 2601, 'Naranjo'),
(206, 2602, 'San Miguel'),
(206, 2603, 'San José'),
(206, 2604, 'Cirrí Sur'),
(206, 2605, 'San Jerónimo'),
(206, 2606, 'San Juan'),
(206, 2607, 'Rosario'),
(207, 2701, 'Palmares'),
(207, 2702, 'Zaragoza'),
(207, 2703, 'Buenos Aires'),
(207, 2704, 'Santiago'),
(207, 2705, 'Candelaria'),
(207, 2706, 'Esquipulas'),
(207, 2707, 'La Granja'),
(208, 2801, 'San Pedro'),
(208, 2802, 'San Juan'),
(208, 2803, 'San Rafael'),
(208, 2804, 'Carrillos'),
(208, 2805, 'Sabana Redonda'),
(209, 2901, 'Orotina'),
(209, 2902, 'Mastate'),
(209, 2903, 'Hacienda Vieja'),
(209, 2904, 'Coyolar'),
(209, 2905, 'Ceiba'),
(210, 21001, 'Quesada'),
(210, 21002, 'Florencia'),
(210, 21003, 'Buenavista'),
(210, 21004, 'Aguas Zarcas'),
(210, 21005, 'Venecia'),
(210, 21006, 'Pital'),
(210, 21007, 'Fortuna'),
(210, 21008, 'Tigra'),
(210, 21009, 'Palmera'),
(210, 21010, 'Venado'),
(210, 21011, 'Cutris'),
(210, 21012, 'Monterrey'),
(210, 21013, 'Pocosol'),
(211, 21101, 'Zarcero'),
(211, 21102, 'Laguna'),
(211, 21103, 'Tapezco'),
(211, 21104, 'Guadalupe'),
(211, 21105, 'Palmira'),
(211, 21106, 'Zapote'),
(211, 21107, 'Brisas'),
(212, 21201, 'Sarchí Norte'),
(212, 21202, 'Sarchí Sur'),
(212, 21203, 'Toro Amarillo'),
(212, 21204, 'San Pedro'),
(212, 21205, 'Rodríguez'),
(213, 21301, 'Upala'),
(213, 21302, 'Aguas Claras'),
(213, 21303, 'San José o Pizote'),
(213, 21304, 'Bijagua'),
(213, 21305, 'Delicias'),
(213, 21306, 'Dos Ríos'),
(213, 21307, 'Yolillal'),
(213, 21308, 'Canalete'),
(214, 21401, 'Los Chiles'),
(214, 21402, 'Caño Negro'),
(214, 21403, 'Amparo'),
(214, 21404, 'San Jorge'),
(215, 21501, 'San Rafael'),
(215, 21502, 'Buenavista'),
(215, 21503, 'Cote'),
(215, 21504, 'Katira'),
(216, 21601, 'Rio Cuarto'),
(301, 30101, 'Oriental'),
(301, 30102, 'Occidental'),
(301, 30103, 'Carmen'),
(301, 30104, 'San Nicolás'),
(301, 30105, 'Aguacaliente '),
(301, 30106, 'Guadalupe Arenilla'),
(301, 30107, 'Corralillo'),
(301, 30108, 'Tierra Blanca'),
(301, 30109, 'Dulce Nombre'),
(301, 30110, 'Llano Grande'),
(301, 30111, 'Quebradilla'),
(302, 30201, 'Paraíso'),
(302, 30202, 'Santiago'),
(302, 30203, 'Orosi'),
(302, 30204, 'Cachí'),
(302, 30205, 'Llanos de Sta Lucia'),
(303, 30301, 'Tres Ríos'),
(303, 30302, 'San Diego'),
(303, 30303, 'San Juan'),
(303, 30304, 'San Rafael'),
(303, 30305, 'Concepción'),
(303, 30306, 'Dulce Nombre'),
(303, 30307, 'San Ramón'),
(303, 30308, 'Río Azul'),
(304, 30401, 'Juan Viñas'),
(304, 30402, 'Tucurrique'),
(304, 30403, 'Pejibaye'),
(305, 30501, 'Turrialba'),
(305, 30502, 'La Suiza'),
(305, 30503, 'Peralta'),
(305, 30504, 'Santa Cruz'),
(305, 30505, 'Santa Teresita'),
(305, 30506, 'Pavones'),
(305, 30507, 'Tuis'),
(305, 30508, 'Tayutic'),
(305, 30509, 'Santa Rosa'),
(305, 30510, 'Tres Equis'),
(305, 30511, 'La Isabel'),
(305, 30512, 'Chirripo'),
(306, 30601, 'Pacayas'),
(306, 30602, 'Cervantes'),
(306, 30603, 'Capellades'),
(307, 30701, 'San Rafael'),
(307, 30702, 'Cot'),
(307, 30703, 'Potrero Cerrado'),
(307, 30704, 'Cipreses'),
(307, 30705, 'Santa Rosa'),
(308, 30801, 'El Tejar'),
(308, 30802, 'San Isidro'),
(308, 30803, 'Tobosi'),
(308, 30804, 'Patio de Agua'),
(401, 40101, 'Heredia'),
(401, 40102, 'Mercedes'),
(401, 40103, 'San Francisco'),
(401, 40104, 'Ulloa'),
(401, 40105, 'Vara Blanca'),
(402, 40201, 'Barva'),
(402, 40202, 'San Pedro'),
(402, 40203, 'San Pablo'),
(402, 40204, 'San Roque'),
(402, 40205, 'Santa Lucía'),
(402, 40206, 'San José de la Montaña'),
(403, 40301, 'Santo Domingo'),
(403, 40302, 'San Vicente'),
(403, 40303, 'San Miguel'),
(403, 40304, 'Paracito'),
(403, 40305, 'Santo Tomás'),
(403, 40306, 'Santa Rosa'),
(403, 40307, 'Tures'),
(403, 40308, 'Pará'),
(404, 40401, 'Santa Bárbara'),
(404, 40402, 'San Pedro'),
(404, 40403, 'San Juan'),
(404, 40404, 'Jesús'),
(404, 40405, 'Santo Domingo del Roble'),
(404, 40406, 'Puraba'),
(405, 40501, 'San Rafael'),
(405, 40502, 'San Josecito'),
(405, 40503, 'Santiago'),
(405, 40504, 'Angeles'),
(405, 40505, 'Concepción'),
(406, 40601, 'San Isidro'),
(406, 40602, 'San José'),
(406, 40603, 'Concepción'),
(406, 40604, 'San Francisco'),
(407, 40701, 'San Antonio'),
(407, 40702, 'La Rivera'),
(407, 40703, 'Asunción'),
(408, 40801, 'San Joaquín'),
(408, 40802, 'Barrantes'),
(408, 40803, 'Llorente'),
(409, 40901, 'San Pablo'),
(409, 40902, 'Rincon de Sabanilla'),
(410, 41001, 'Puerto Viejo'),
(410, 41002, 'La Virgen'),
(410, 41003, 'Horquetas'),
(410, 41004, 'Llanuras del Gaspar'),
(410, 41005, 'Cureña'),
(501, 50101, 'Liberia'),
(501, 50102, 'Cañas Dulces'),
(501, 50103, 'Mayorga'),
(501, 50104, 'Nacascolo'),
(501, 50105, 'Curubande'),
(502, 50201, 'Nicoya'),
(502, 50202, 'Mansión'),
(502, 50203, 'San Antonio'),
(502, 50204, 'Quebrada Honda'),
(502, 50205, 'Sámara'),
(502, 50206, 'Nosara'),
(502, 50207, 'Belén de Nosarita'),
(503, 50301, 'Santa Cruz'),
(503, 50302, 'Bolsón'),
(503, 50303, 'Veintisiete de Abril'),
(503, 50304, 'Tempate'),
(503, 50305, 'Cartagena'),
(503, 50306, 'Cuajiniquil'),
(503, 50307, 'Diriá'),
(503, 50308, 'Cabo Velas'),
(503, 50309, 'Tamarindo'),
(504, 50401, 'Bagaces'),
(504, 50402, 'Fortuna'),
(504, 50403, 'Mogote'),
(504, 50404, 'Río Naranjo'),
(505, 50501, 'Filadelfia'),
(505, 50502, 'Palmira'),
(505, 50503, 'Sardinal'),
(505, 50504, 'Belén'),
(506, 50601, 'Cañas'),
(506, 50602, 'Palmira'),
(506, 50603, 'San Miguel'),
(506, 50604, 'Bebedero'),
(506, 50605, 'Porozal'),
(507, 50701, 'Juntas'),
(507, 50702, 'Sierra'),
(507, 50703, 'San Juan'),
(507, 50704, 'Colorado'),
(508, 50801, 'Tilarán'),
(508, 50802, 'Quebrada Grande'),
(508, 50803, 'Tronadora'),
(508, 50804, 'Santa Rosa'),
(508, 50805, 'Líbano'),
(508, 50806, 'Tierras Morenas'),
(508, 50807, 'Arenal'),
(509, 50901, 'Carmona'),
(509, 50902, 'Santa Rita'),
(509, 50903, 'Zapotal'),
(509, 50904, 'San Pablo'),
(509, 50905, 'Porvenir'),
(509, 50906, 'Bejuco'),
(510, 51001, 'La Cruz'),
(510, 51002, 'Santa Cecilia'),
(510, 51003, 'Garita'),
(510, 51004, 'Santa Elena'),
(511, 51101, 'Hojancha'),
(511, 51102, 'Monte Romo'),
(511, 51103, 'Puerto Carrillo'),
(511, 51104, 'Huacas'),
(511, 51105, 'Matambú'),
(601, 60101, 'Puntarenas'),
(601, 60102, 'Pitahaya'),
(601, 60103, 'Chomes'),
(601, 60104, 'Lepanto'),
(601, 60105, 'Paquera'),
(601, 60106, 'Manzanillo'),
(601, 60107, 'Guacimal'),
(601, 60108, 'Barranca'),
(601, 60109, 'Monte Verde'),
(601, 60110, 'Isla del Coco'),
(601, 60111, 'Cóbano'),
(601, 60112, 'Chacarita'),
(601, 60113, 'Chira (Isla)'),
(601, 60114, 'Acapulco'),
(601, 60115, 'El Roble'),
(601, 60116, 'Arancibia'),
(602, 60201, 'Espíritu Santo'),
(602, 60202, 'San Juan Grande'),
(602, 60203, 'Macacona'),
(602, 60204, 'San Rafael'),
(602, 60205, 'San Jerónimo'),
(602, 60206, 'Caldera'),
(603, 60301, 'Buenos Aires'),
(603, 60302, 'Volcán'),
(603, 60303, 'Potrero Grande'),
(603, 60304, 'Boruca'),
(603, 60305, 'Pilas'),
(603, 60306, 'Colinas o Bajo de Maíz'),
(603, 60307, 'Chánguena'),
(603, 60308, 'Biolley'),
(603, 60309, 'Brunka'),
(604, 60401, 'Miramar'),
(604, 60402, 'Unión'),
(604, 60403, 'San Isidro'),
(605, 60501, 'Ciudad Cortés'),
(605, 60502, 'Palmar'),
(605, 60503, 'Sierpe'),
(605, 60504, 'Bahía Ballena'),
(605, 60505, 'Piedras Blancas'),
(605, 60506, 'Bahia Drake'),
(606, 60601, 'Quepos'),
(606, 60602, 'Savegre'),
(606, 60603, 'Naranjito'),
(607, 60701, 'Golfito'),
(607, 60702, 'Puerto Jiménez'),
(607, 60703, 'Guaycará'),
(607, 60704, 'Pavones o Villa Conte'),
(608, 60801, 'San Vito'),
(608, 60802, 'Sabalito'),
(608, 60803, 'Agua Buena'),
(608, 60804, 'Limoncito'),
(608, 60805, 'Pittier'),
(608, 60806, 'Gutierrez Brown'),
(609, 60901, 'Parrita'),
(610, 61001, 'Corredores'),
(610, 61002, 'La Cuesta'),
(610, 61003, 'Paso Canoas'),
(610, 61004, 'Laurel'),
(611, 61101, 'Jacó'),
(611, 61102, 'Tárcoles'),
(701, 70101, 'Limón'),
(701, 70102, 'Valle  La Estrella'),
(701, 70103, 'Río Blanco'),
(701, 70104, 'Matama'),
(702, 70201, 'Guápiles'),
(702, 70202, 'Jiménez'),
(702, 70203, 'Rita'),
(702, 70204, 'Roxana'),
(702, 70205, 'Cariari'),
(702, 70206, 'Colorado'),
(702, 70207, 'La Colonia'),
(703, 70301, 'Siquirres'),
(703, 70302, 'Pacuarito'),
(703, 70303, 'Florida'),
(703, 70304, 'Germania'),
(703, 70305, 'Cairo'),
(703, 70306, 'Alegría'),
(704, 70401, 'Bratsi'),
(704, 70402, 'Sixaola'),
(704, 70403, 'Cahuita'),
(704, 70404, 'Telire'),
(705, 70501, 'Matina'),
(705, 70502, 'Batán'),
(705, 70503, 'Carrandí'),
(706, 70601, 'Guácimo'),
(706, 70602, 'Mercedes'),
(706, 70603, 'Pocora'),
(706, 70604, 'Río Jiménez'),
(706, 70605, 'Duacarí');

-- --------------------------------------------------------

--
-- Table structure for table `Empresa`
--

CREATE TABLE `Empresa` (
  `idEmpresa` int(20) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `zona` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccionFisica` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `contactoEmergencia` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `activado` tinyint(1) NOT NULL DEFAULT '1',
  `idUsuario` int(45) NOT NULL,
  `horario1` int(11) NOT NULL,
  `horario2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `Empresa`
--

INSERT INTO `Empresa` (`idEmpresa`, `nombre`, `zona`, `direccionFisica`, `latitud`, `longitud`, `telefono`, `correo`, `contactoEmergencia`, `activado`, `idUsuario`, `horario1`, `horario2`) VALUES
(2, 'La500', 'Heredia-Cartago', 'San José', 9.971698362782197, -84.18904781341554, '+50622665566', 'ddd@gmail.com', '+50622558877', 1, 11, 7, 10),
(4, 'Busetas Heredianas', 'Heredia-San José', 'San Sebastián', 10.073604055040425, -84.19140815734863, '+50622665566', 'c543631@urhen.com', '+50622558877', 1, 11, 12, 16);

-- --------------------------------------------------------

--
-- Table structure for table `LogHistorial`
--

CREATE TABLE `LogHistorial` (
  `idLogHistorial` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nombreTabla` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `accion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `LogHistorial`
--

INSERT INTO `LogHistorial` (`idLogHistorial`, `fecha`, `nombreTabla`, `accion`, `idUsuario`) VALUES
(2, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(3, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(4, '2019-10-15', 'Empresa', 'Actualizar Empresa', 11),
(5, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(6, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(7, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(8, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(9, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(10, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(11, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(12, '2019-10-21', 'Empresa', 'Crear Empresa', 1),
(13, '2019-10-21', 'Empresa', 'Crear Empresa', 11),
(14, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(15, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(16, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 1),
(17, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(18, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 11),
(19, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 11),
(20, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 11),
(21, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 11),
(22, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 11),
(23, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 11),
(24, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(25, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 11),
(26, '2019-10-21', 'Empresa', 'Habilitación de Empresa', 11),
(27, '2019-10-21', 'Empresa', 'Actualizar Empresa', 11),
(28, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(29, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(30, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(31, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(32, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(33, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(34, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(35, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(36, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(37, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(38, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(39, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(40, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(41, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(42, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(43, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(44, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(45, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(46, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(47, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(48, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(49, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(50, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(51, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(52, '2019-10-22', 'Parada', 'Crear Parada', 11),
(53, '2019-10-22', 'Parada', 'Crear Parada', 11),
(54, '2019-10-22', 'Parada', 'Crear Parada', 11),
(55, '2019-10-22', 'Parada', 'Crear Parada', 11),
(56, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(57, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(58, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(59, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(60, '2019-10-22', 'Parada', 'Crear Parada', 11),
(61, '2019-10-22', 'Parada', 'Crear Parada', 11),
(62, '2019-10-22', 'Parada', 'Crear Parada', 11),
(63, '2019-10-22', 'Empresa', 'Actualizar Empresa', 11),
(64, '2019-10-22', 'Ruta', 'Crear Ruta', 11),
(65, '2019-10-22', 'Parada', 'Crear Ruta', 11),
(66, '2019-10-22', 'Parada', 'Crear Ruta', 11),
(67, '2019-10-22', 'Parada', 'Crear Ruta', 11),
(68, '2019-10-22', 'Parada', 'Crear Ruta', 11),
(69, '2019-10-22', 'Parada', 'Crear Ruta', 11),
(70, '2019-10-22', 'Empresa', 'Habilitación de Empresa', 11),
(71, '2019-10-23', 'Empresa', 'Link de Empresa y Ruta', 11),
(72, '2019-10-23', 'Empresa', 'Link de Empresa y Ruta', 11),
(73, '2019-10-23', 'Empresa', 'Link de Empresa y Ruta', 11),
(74, '2019-10-23', 'Empresa', 'Link de Empresa y Ruta', 11),
(75, '2019-10-23', 'Empresa', 'Vinculación Empresa/Ruta', 11),
(76, '2019-10-23', 'Empresa', 'Vinculación Empresa/Ruta', 11),
(77, '2019-10-23', 'Empresa', 'Link de Empresa y Ruta', 11),
(78, '2019-10-23', 'Empresa', 'Link de Empresa y Ruta', 11),
(79, '2019-10-23', 'Empresa', 'Desvinculación Empresa/Ruta', 11),
(80, '2019-10-23', 'Empresa', 'Link de Empresa y Ruta', 11),
(81, '2019-10-23', 'Empresa', 'Actualización Empresa y Ruta', 11),
(82, '2019-10-23', 'Ruta', 'Crear Ruta', 11),
(83, '2019-10-23', 'Ruta', 'Crear Ruta', 11),
(84, '2019-10-23', 'Parada', 'Crear Ruta', 11),
(85, '2019-10-23', 'Parada', 'Crear Ruta', 11),
(86, '2019-10-23', 'Ruta', 'Crear Ruta', 11),
(87, '2019-10-23', 'Ruta', 'Crear Ruta', 11),
(88, '2019-10-23', 'Parada', 'Crear Ruta', 11),
(89, '2019-10-23', 'Parada', 'Crear Ruta', 11),
(90, '2019-10-23', 'Parada', 'Crear Ruta', 11),
(91, '2019-10-23', 'Ruta', 'Crear Ruta', 11),
(92, '2019-10-23', 'Parada', 'Crear Ruta', 11),
(93, '2019-10-23', 'Parada', 'Crear Ruta', 11),
(94, '2019-10-23', 'Parada', 'Crear Ruta', 11),
(95, '2019-10-24', 'Ruta', 'Crear Ruta', 11),
(96, '2019-10-24', 'Parada', 'Crear Ruta', 11),
(97, '2019-10-24', 'Parada', 'Crear Ruta', 11),
(98, '2019-10-24', 'Parada', 'Crear Ruta', 11),
(99, '2019-10-24', 'Parada', 'Crear Ruta', 11),
(100, '2019-10-24', 'Parada', 'Crear Ruta', 11),
(101, '2019-10-24', 'Parada', 'Crear Ruta', 11),
(102, '2019-10-24', 'Empresa', 'Actualización Empresa y Ruta', 11),
(103, '2019-10-24', 'Empresa', 'Link de Empresa y Ruta', 11),
(104, '2019-10-24', 'Empresa', 'Desvinculación Empresa/Ruta', 11),
(105, '2019-10-24', 'Empresa', 'Actualizar Empresa', 11);

-- --------------------------------------------------------

--
-- Table structure for table `Parada`
--

CREATE TABLE `Parada` (
  `idParada` int(11) NOT NULL,
  `idRuta` int(11) NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `Parada`
--

INSERT INTO `Parada` (`idParada`, `idRuta`, `latitud`, `longitud`) VALUES
(4, 24, 9.9374021409925, -84.074850082397),
(5, 24, 9.9316531691517, -84.090642929077),
(6, 24, 9.934231764605, -84.083797931671),
(7, 24, 9.9331326936181, -84.082252979279),
(8, 28, 9.9314840802153, -84.077425003052),
(9, 28, 9.9345276677013, -84.114675521851),
(10, 28, 9.936556710294, -84.132871627808),
(11, 29, 9.9383321122366, -84.108903408051),
(12, 29, 9.9338090454316, -84.110147953033),
(13, 29, 9.9327099730247, -84.098088741303),
(14, 29, 9.9378671269451, -84.098131656647),
(15, 29, 9.938966182023, -84.108860492706),
(16, 31, 9.9384589262922, -84.108989238739),
(17, 31, 9.9379516697746, -84.098217487335),
(18, 33, 9.9384589262922, -84.108989238739),
(19, 33, 9.9379516697746, -84.098217487335),
(20, 33, 9.9326544909063, -84.098088741303),
(21, 34, 9.9384589262922, -84.108989238739),
(22, 34, 9.9379516697746, -84.098217487335),
(23, 34, 9.9326544909063, -84.098088741303),
(24, 35, 9.9384589262922, -84.108989238739),
(25, 35, 9.9379516697746, -84.098217487335),
(26, 35, 9.9326544909063, -84.098088741303),
(27, 35, 9.9317245035206, -84.0940117836),
(28, 35, 9.9307945134918, -84.091651439667),
(29, 35, 9.9297377034328, -84.088990688324);

-- --------------------------------------------------------

--
-- Table structure for table `Provincia`
--

CREATE TABLE `Provincia` (
  `idProvincia` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `Provincia`
--

INSERT INTO `Provincia` (`idProvincia`, `nombre`) VALUES
(1, 'SAN JOSE'),
(2, 'ALAJUELA'),
(3, 'CARTAGO'),
(4, 'HEREDIA'),
(5, 'GUANACASTE'),
(6, 'PUNTARENAS'),
(7, 'LIMON');

-- --------------------------------------------------------

--
-- Table structure for table `Ruta`
--

CREATE TABLE `Ruta` (
  `idRuta` int(11) NOT NULL,
  `numeroRuta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `puntoInicioLat` double NOT NULL,
  `puntoInicioLng` double NOT NULL,
  `activado` tinyint(1) NOT NULL DEFAULT '1',
  `idUsuario` int(45) NOT NULL,
  `lugarInicio` int(11) NOT NULL,
  `lugarDestino` int(11) NOT NULL,
  `ptoFinalLat` double NOT NULL,
  `ptoFinalLng` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `Ruta`
--

INSERT INTO `Ruta` (`idRuta`, `numeroRuta`, `descripcion`, `puntoInicioLat`, `puntoInicioLng`, `activado`, `idUsuario`, `lugarInicio`, `lugarDestino`, `ptoFinalLat`, `ptoFinalLng`) VALUES
(24, '300', 'asdasd', 9.9374021409925, -84.074850082397, 1, 11, 2303, 30402, 9.9331326936181, -84.082252979279),
(28, '27', 'A caldera', 9.9314840802153, -84.077425003052, 1, 11, 202, 2202, 9.936556710294, -84.132871627808),
(29, '999', 'Vuelta a la sabana', 9.9383321122366, -84.108903408051, 1, 11, 109, 109, 9.938966182023, -84.108860492706),
(31, '2000', 'Prueba', 9.9384589262922, -84.108989238739, 1, 11, 101, 101, 9.9379516697746, -84.098217487335),
(33, '3000', 'Prueba 2', 9.9384589262922, -84.108989238739, 1, 11, 101, 101, 9.9326544909063, -84.098088741303),
(34, '4000', 'Prueba 3', 9.9384589262922, -84.108989238739, 1, 11, 101, 101, 9.9326544909063, -84.098088741303),
(35, '5000', 'Prueba 4', 9.9384589262922, -84.108989238739, 1, 11, 101, 101, 9.9297377034328, -84.088990688324);

-- --------------------------------------------------------

--
-- Table structure for table `RutaXEmpresa`
--

CREATE TABLE `RutaXEmpresa` (
  `idEmpresa` int(11) NOT NULL,
  `idRuta` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  `duracion` int(11) NOT NULL,
  `discapacitado` tinyint(1) NOT NULL,
  `activado` tinyint(1) NOT NULL DEFAULT '1',
  `horarioInicio` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `horarioFin` varchar(80) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `RutaXEmpresa`
--

INSERT INTO `RutaXEmpresa` (`idEmpresa`, `idRuta`, `costo`, `duracion`, `discapacitado`, `activado`, `horarioInicio`, `horarioFin`) VALUES
(4, 29, 500, 10, 1, 1, '06:00', '22:30');

-- --------------------------------------------------------

--
-- Table structure for table `TipoUsuario`
--

CREATE TABLE `TipoUsuario` (
  `idTipoUsuario` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Usuario`
--

CREATE TABLE `Usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `celular` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(105) COLLATE utf8_spanish_ci NOT NULL,
  `activado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `Usuario`
--

INSERT INTO `Usuario` (`idusuario`, `nombre`, `apellido1`, `apellido2`, `usuario`, `email`, `celular`, `telefono`, `contrasena`, `activado`) VALUES
(1, 'Gabriel', 'Solórzano', 'Chanto', 'gabritico', 'g.solorzano97@hotmail.com', '87062905', '87062905', 'b96945a8ed11c124d30ce1666152ca5d6147f624\n', 1),
(7, 'Natasha', 'Sánchez', 'Jiménez', 'ahsatan', 'ahsatan@gmail.com', '+70070145505', '+50670145505', 'Natasha123', 1),
(8, 'Ericka', 'Solano', 'Fernández', 'ersolano', 'sfsdf@gmail.com', '+5068989898', '+5062321212', 'HolaHola1', 1),
(11, 'Paolo', 'Blanco', 'Núñez', 'pblanco27', 'pblanco27@hotmail.es', '+50670145505', '+50622130350', 'c9b138ecb81a70339eac61a26161696641bc7b7f', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Canton`
--
ALTER TABLE `Canton`
  ADD PRIMARY KEY (`idCanton`),
  ADD KEY `idProvinciaCanton` (`idProvincia`);

--
-- Indexes for table `Distrito`
--
ALTER TABLE `Distrito`
  ADD PRIMARY KEY (`idDistrito`),
  ADD KEY `idCantonDistrito` (`idCanton`);

--
-- Indexes for table `Empresa`
--
ALTER TABLE `Empresa`
  ADD PRIMARY KEY (`idEmpresa`),
  ADD KEY `idcreadorEmpresa` (`idUsuario`);

--
-- Indexes for table `LogHistorial`
--
ALTER TABLE `LogHistorial`
  ADD PRIMARY KEY (`idLogHistorial`),
  ADD KEY `idModificador` (`idUsuario`);

--
-- Indexes for table `Parada`
--
ALTER TABLE `Parada`
  ADD PRIMARY KEY (`idParada`),
  ADD KEY `idRutatotstosParada` (`idRuta`);

--
-- Indexes for table `Provincia`
--
ALTER TABLE `Provincia`
  ADD PRIMARY KEY (`idProvincia`);

--
-- Indexes for table `Ruta`
--
ALTER TABLE `Ruta`
  ADD PRIMARY KEY (`idRuta`),
  ADD KEY `idcreadorRuta` (`idUsuario`),
  ADD KEY `idLugarIni` (`lugarInicio`),
  ADD KEY `idLugarDest` (`lugarDestino`);

--
-- Indexes for table `RutaXEmpresa`
--
ALTER TABLE `RutaXEmpresa`
  ADD PRIMARY KEY (`idEmpresa`,`idRuta`),
  ADD KEY `idRuta2` (`idRuta`);

--
-- Indexes for table `TipoUsuario`
--
ALTER TABLE `TipoUsuario`
  ADD PRIMARY KEY (`idTipoUsuario`);

--
-- Indexes for table `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Empresa`
--
ALTER TABLE `Empresa`
  MODIFY `idEmpresa` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `LogHistorial`
--
ALTER TABLE `LogHistorial`
  MODIFY `idLogHistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `Parada`
--
ALTER TABLE `Parada`
  MODIFY `idParada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `Ruta`
--
ALTER TABLE `Ruta`
  MODIFY `idRuta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `TipoUsuario`
--
ALTER TABLE `TipoUsuario`
  MODIFY `idTipoUsuario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Canton`
--
ALTER TABLE `Canton`
  ADD CONSTRAINT `idProvinciaCanton` FOREIGN KEY (`idProvincia`) REFERENCES `Provincia` (`idProvincia`);

--
-- Constraints for table `Distrito`
--
ALTER TABLE `Distrito`
  ADD CONSTRAINT `idCantonDistrito` FOREIGN KEY (`idCanton`) REFERENCES `Canton` (`idCanton`);

--
-- Constraints for table `Empresa`
--
ALTER TABLE `Empresa`
  ADD CONSTRAINT `idcreadorEmpresa` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idusuario`);

--
-- Constraints for table `LogHistorial`
--
ALTER TABLE `LogHistorial`
  ADD CONSTRAINT `idModificador` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idusuario`);

--
-- Constraints for table `Parada`
--
ALTER TABLE `Parada`
  ADD CONSTRAINT `idRutatotstosParada` FOREIGN KEY (`idRuta`) REFERENCES `Ruta` (`idRuta`);

--
-- Constraints for table `Ruta`
--
ALTER TABLE `Ruta`
  ADD CONSTRAINT `idLugarDest` FOREIGN KEY (`lugarDestino`) REFERENCES `Distrito` (`idDistrito`),
  ADD CONSTRAINT `idLugarIni` FOREIGN KEY (`lugarInicio`) REFERENCES `Distrito` (`idDistrito`),
  ADD CONSTRAINT `idcreadorRuta` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idusuario`);

--
-- Constraints for table `RutaXEmpresa`
--
ALTER TABLE `RutaXEmpresa`
  ADD CONSTRAINT `idEmpresatots2` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`),
  ADD CONSTRAINT `idRuta2` FOREIGN KEY (`idRuta`) REFERENCES `Ruta` (`idRuta`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
