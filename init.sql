CREATE USER 'root'@'%' IDENTIFIED BY 'example';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

CREATE DATABASE IF NOT EXISTS dev;
USE dev;

CREATE TABLE `stations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `x` FLOAT NOT NULL,
  `y` FLOAT NOT NULL,
  PRIMARY KEY(id)  
);

create TABLE `bikes` (
    `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `station` int,
    FOREIGN KEY (station) REFERENCES stations(id)
);

INSERT INTO  stations (`name`, `x`, `y`) VALUES 
('Station1', 51.475382710029656, 11.986716683067106),
('Station2', 51.474428206441516, 11.988309833822942),
('Station3', 51.475798527121526, 11.982817256733131);

INSERT INTO  bikes (`station`) VALUES 
(1),
(1),
(1),
(2),
(2),
(3),
(3),
(3),
(3);