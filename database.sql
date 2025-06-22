-- ANUIES TIC Timeline Database Schema
CREATE DATABASE IF NOT EXISTS anuies_tic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE anuies_tic;

-- Timeline items table
CREATE TABLE timeline_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    extended_content TEXT,
    date VARCHAR(50) NOT NULL,
    type ENUM('eventos', 'proyectos', 'publicaciones') NOT NULL,
    image_url VARCHAR(500),
    media_type VARCHAR(50),
    is_published BOOLEAN DEFAULT TRUE,
    sort_order INT AUTO_INCREMENT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_type (type),
    INDEX idx_published (is_published),
    INDEX idx_sort_order (sort_order)
);

-- Media files table
CREATE TABLE media_files (
  id INT AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(255) NOT NULL,
  original_name VARCHAR(255) NOT NULL,
  file_path VARCHAR(500) NOT NULL,
  file_size INT NOT NULL,
  mime_type VARCHAR(100) NOT NULL,
  file_type ENUM('image', 'video', 'document') NOT NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin sessions table
CREATE TABLE admin_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(128) NOT NULL UNIQUE,
    user_id VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    INDEX idx_session_id (session_id),
    INDEX idx_expires (expires_at)
);

-- Insert initial timeline data
INSERT INTO timeline_items (title, description, extended_content, date, type, is_published, sort_order) VALUES 
('Creación del Comité ANUIES TIC', 'El Comité ANUIES TIC se constituyó como un espacio de colaboración y trabajo entre las instituciones de educación superior mexicanas para impulsar el uso y apropiación de las TIC.', 'Durante la sesión ordinaria del Consejo Nacional de la ANUIES, se aprobó la creación del Comité ANUIES TIC con el objetivo de promover la colaboración entre las instituciones de educación superior en materia tecnológica y de comunicación para elevar la calidad educativa.', 'Diciembre 2015', 'eventos', TRUE, 1),
('Primer Encuentro ANUIES TIC', 'Se realizó el primer encuentro nacional de responsables de TIC de las instituciones miembros, estableciendo un espacio permanente de intercambio y colaboración.', 'El evento reunió a más de 200 responsables de tecnologías de la información de universidades de todo el país, sentando las bases para una colaboración continua y el intercambio de experiencias en la implementación de soluciones tecnológicas para la educación superior.', 'Noviembre 2016', 'eventos', TRUE, 2),
('Primer Estudio de Estado Actual de las TIC', 'Se publicó el primer estudio sobre el estado actual de las Tecnologías de la Información y Comunicaciones en las Instituciones de Educación Superior en México.', 'Este estudio pionero permitió conocer la situación real de las TIC en las IES mexicanas, identificando áreas de oportunidad y mejores prácticas que luego se convertirían en proyectos estratégicos para el comité.', 'Noviembre 2016', 'proyectos', TRUE, 3),
('Publicación del Marco de Referencia TI', 'Se publicó el primer marco de referencia para la gestión de TI en instituciones educativas basado en mejores prácticas internacionales.', 'Este documento se convirtió en una guía fundamental para los departamentos de TI de las universidades mexicanas, adaptando estándares internacionales como COBIT, ITIL e ISO 20000 a la realidad de las instituciones educativas del país.', 'Mayo 2018', 'publicaciones', TRUE, 4),
('Lanzamiento de la Red Nacional de Investigación', 'Se estableció la Red Nacional de Investigación e Innovación en TIC para la Educación Superior, conectando investigadores de todo el país.', 'Esta red permitió crear sinergias entre los grupos de investigación en tecnologías educativas, promoviendo el desarrollo de soluciones innovadoras y el intercambio de conocimientos especializados.', 'Febrero 2019', 'proyectos', TRUE, 5),
('Programa de Capacitación Digital', 'Lanzamiento del programa nacional de capacitación en competencias digitales para personal académico y administrativo.', 'Este programa integral ha beneficiado a más de 5,000 personas en universidades de todo México, mejorando significativamente las capacidades tecnológicas del sector educativo superior.', 'Agosto 2020', 'proyectos', TRUE, 6),
('Red de Colaboración en Ciberseguridad', 'Establecimiento de la red nacional de ciberseguridad para proteger la infraestructura digital de las instituciones educativas.', 'Esta iniciativa ha fortalecido las defensas cibernéticas de más de 100 universidades, implementando protocolos de seguridad estandarizados y sistemas de monitoreo continuo.', 'Marzo 2021', 'eventos', TRUE, 7),
('Plataforma Nacional de Recursos Educativos', 'Creación de la plataforma centralizada para compartir recursos educativos digitales entre todas las instituciones miembro.', 'La plataforma alberga más de 10,000 recursos educativos digitales de alta calidad, facilitando el intercambio académico y mejorando la experiencia de aprendizaje en todo el país.', 'Septiembre 2022', 'publicaciones', TRUE, 8),
('Conferencia Internacional de Innovación Educativa', 'Organización de la primera conferencia internacional sobre innovación tecnológica en educación superior.', 'El evento reunió a más de 1,500 participantes de 15 países, estableciendo a México como un referente regional en innovación educativa y tecnología.', 'Junio 2023', 'eventos', TRUE, 9),
('Programa de Transformación Digital 2024', 'Lanzamiento del ambicioso programa de transformación digital integral para todas las universidades miembro.', 'Este programa representa la culminación de 10 años de trabajo colaborativo, estableciendo las bases para la próxima década de innovación en educación superior mexicana.', 'Enero 2024', 'proyectos', TRUE, 10);