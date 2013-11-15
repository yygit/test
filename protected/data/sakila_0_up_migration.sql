SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

USE sakila;  

CREATE TABLE IF NOT EXISTS user (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
username VARCHAR(45) NOT NULL,
email VARCHAR(60) NOT NULL,
pass CHAR(64) NOT NULL,
type ENUM('public','author','admin') NOT NULL,
date_entered TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id),
UNIQUE INDEX username_UNIQUE (username ASC),
UNIQUE INDEX email_UNIQUE (email ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


INSERT INTO user (id, username, email, pass) VALUES (23, 'demo',
'demo@sample.com', SHA2('demodemodemo@sample.com', 256));

CREATE TABLE IF NOT EXISTS page (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
user_id INT UNSIGNED NOT NULL,
live TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
title VARCHAR(100) NOT NULL,
content LONGTEXT NULL,
date_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
date_published DATE NULL,
PRIMARY KEY (id),
INDEX fk_page_user_idx (user_id ASC),
INDEX date_published (date_published ASC),
CONSTRAINT fk_page_user
FOREIGN KEY (user_id)
REFERENCES user (id)
ON DELETE CASCADE
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

INSERT INTO page (id, user_id, title, content) VALUES
(1, 23, 'This is the page title.', 'This is the page content.');

CREATE TABLE IF NOT EXISTS comment (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
user_id INT UNSIGNED NOT NULL,
page_id INT UNSIGNED NOT NULL,
comment MEDIUMTEXT NOT NULL,
date_entered TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id),
INDEX fk_comment_user_idx (user_id ASC),
INDEX fk_comment_page_idx (page_id ASC),
INDEX date_entered (date_entered ASC),
CONSTRAINT fk_comment_user
FOREIGN KEY (user_id)
REFERENCES user (id)
ON DELETE CASCADE
ON UPDATE NO ACTION,
CONSTRAINT fk_comment_page
FOREIGN KEY (page_id)
REFERENCES page (id)
ON DELETE CASCADE
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

INSERT INTO comment (user_id, page_id, comment) VALUES
(23, 1, 'This is the comment.');

CREATE TABLE IF NOT EXISTS file (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
user_id INT UNSIGNED NOT NULL,
name VARCHAR(80) NOT NULL,
type VARCHAR(45) NOT NULL,
size INT UNSIGNED NOT NULL,
description MEDIUMTEXT NULL,
date_entered TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
date_updated DATETIME NULL,
PRIMARY KEY (id),
INDEX fk_file_user1_idx (user_id ASC),
INDEX name (name ASC),
INDEX date_entered (date_entered ASC),
CONSTRAINT fk_file_user
FOREIGN KEY (user_id)
REFERENCES user (id)
ON DELETE CASCADE
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


INSERT INTO file (id, user_id, name, type, size, description)
VALUES (2, 23, 'somefile.pdf', 'application/pdf', 239085,'This is the description');

CREATE TABLE IF NOT EXISTS page_has_file (
page_id INT UNSIGNED NOT NULL,
file_id INT UNSIGNED NOT NULL,
PRIMARY KEY (page_id, file_id),
INDEX fk_page_has_file_file_idx (file_id ASC),
INDEX fk_page_has_file_page_idx (page_id ASC),
CONSTRAINT fk_page_has_file_page
FOREIGN KEY (page_id)
REFERENCES page (id)
ON DELETE CASCADE
ON UPDATE NO ACTION,
CONSTRAINT fk_page_has_file_file
FOREIGN KEY (file_id)
REFERENCES file (id)
ON DELETE CASCADE
ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO page_has_file (page_id, file_id) VALUES (1, 2);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;  