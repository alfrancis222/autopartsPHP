CREATE DATABASE IF NOT EXISTS autoparts_site CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE autoparts_site;

DROP TABLE IF EXISTS parts;
DROP TABLE IF EXISTS subtopics;

CREATE TABLE subtopics (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL
);

CREATE TABLE parts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subtopic_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(255) NOT NULL DEFAULT '',
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  picture VARCHAR(100) NULL,
  is_deleted TINYINT(1) NOT NULL DEFAULT 0,
  deleted_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (subtopic_id) REFERENCES subtopics(id)
);

INSERT INTO subtopics (name) VALUES
('Engine'), ('Brakes'), ('Suspension'), ('Electrical'), ('Body and exterior');

INSERT INTO parts (subtopic_id, name, description, price) VALUES
(1, 'Oil filter', 'Spin-on oil filter for 1.3L to 1.5L petrol engines.', 285.00),
(1, 'Spark plug set (4)', 'Iridium spark plugs, 4 pieces per box.', 1450.00),
(2, 'Front brake pads', 'Semi-metallic pads, fits most compact sedans.', 1890.00),
(3, 'Shock absorber (rear)', 'Gas-charged rear shock, sold per piece.', 2650.00),
(4, 'Car battery 12V 45Ah', 'Maintenance-free battery with 12-month warranty.', 4200.00);
