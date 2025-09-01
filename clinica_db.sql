-- Version: 2.0
-- Este script asume que la tabla 'pacientes' ya existe.
-- Crea la tabla 'citas' y la relaciona con 'pacientes'.

CREATE TABLE `citas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` INT(11) NOT NULL,
  `doctor_asignado` VARCHAR(100) DEFAULT 'Dr. Muelas',
  `fecha_cita` DATE NOT NULL,
  `diente_tratado` VARCHAR(50) DEFAULT NULL,
  `descripcion` TEXT NOT NULL,
  `debe` DECIMAL(10, 2) DEFAULT 0.00,
  `haber` DECIMAL(10, 2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `paciente_id` (`paciente_id`),
  CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar historial de ejemplo para los pacientes existentes
-- Asegúrate de que los IDs de paciente (1, 2, 3) coincidan con los de tu tabla 'pacientes'
INSERT INTO `citas` (`paciente_id`, `fecha_cita`, `diente_tratado`, `descripcion`, `debe`, `haber`) VALUES
(1, '2023-10-15', 'Pieza 16', 'Consulta inicial y limpieza profunda.', 50.00, 50.00),
(1, '2023-11-20', 'Pieza 24', 'Restauración con resina compuesta.', 100.00, 0.00),
(2, '2023-11-02', 'N/A', 'Revisión semestral y fluorización.', 75.00, 250.00),
(3, '2023-09-28', 'Pieza 46', 'Endodoncia y preparación para corona.', 320.50, 100.00);