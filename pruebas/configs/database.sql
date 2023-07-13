DROP TABLE IF EXISTS `usuario`; 
CREATE TABLE `usuario` (
  `mail` varchar(120) DEFAULT NULL,
  `nombre` varchar(120) DEFAULT NULL,
  `clave` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `usuario` (`mail`, `nombre`, `clave`) VALUES
('manuel@mail.com', 'Manuel', 'd95c40461f46b7d8341c404cd9ed2fd7a73dec9b08235bbf4eaacc24a4c68828');
COMMIT;