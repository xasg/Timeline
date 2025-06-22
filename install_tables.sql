-- Additional tables for media management and settings

CREATE TABLE IF NOT EXISTS `media_files` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_type` enum('image', 'video', 'document') NOT NULL,
  `uploaded_at` timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `setting_key` varchar(100) NOT NULL UNIQUE,
  `setting_value` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_title', '10 AÑOS ANUIES TIC'),
('site_description', 'Una década de innovación y colaboración en la educación superior mexicana'),
('items_per_page', '10'),
('allow_youtube_embed', '1'),
('auto_publish', '0'),
('enable_comments', '0');