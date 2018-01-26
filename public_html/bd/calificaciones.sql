-- MySQL Script generated by MySQL Workbench
-- Fri Jan 26 00:00:57 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema actividades
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema actividades
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `actividades` DEFAULT CHARACTER SET utf8 ;
USE `actividades` ;

-- -----------------------------------------------------
-- Table `actividades`.`alumno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `actividades`.`alumno` (
  `idalumno` INT NOT NULL AUTO_INCREMENT,
  `matricula` VARCHAR(6) NULL,
  `nombre` VARCHAR(100) NULL,
  PRIMARY KEY (`idalumno`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `actividades`.`materia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `actividades`.`materia` (
  `idmateria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`idmateria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `actividades`.`actividad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `actividades`.`actividad` (
  `idactividad` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `valor` INT NULL,
  `materia_idmateria` INT NOT NULL,
  `corte` INT NULL,
  PRIMARY KEY (`idactividad`),
  INDEX `fk_actividad_materia1_idx` (`materia_idmateria` ASC),
  CONSTRAINT `fk_actividad_materia1`
    FOREIGN KEY (`materia_idmateria`)
    REFERENCES `actividades`.`materia` (`idmateria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `actividades`.`alumnos_inscritos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `actividades`.`alumnos_inscritos` (
  `alumno_idalumno` INT NOT NULL,
  `materia_idmateria` INT NOT NULL,
  PRIMARY KEY (`alumno_idalumno`, `materia_idmateria`),
  INDEX `fk_alumno_has_materia_materia1_idx` (`materia_idmateria` ASC),
  INDEX `fk_alumno_has_materia_alumno1_idx` (`alumno_idalumno` ASC),
  CONSTRAINT `fk_alumno_has_materia_alumno1`
    FOREIGN KEY (`alumno_idalumno`)
    REFERENCES `actividades`.`alumno` (`idalumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_has_materia_materia1`
    FOREIGN KEY (`materia_idmateria`)
    REFERENCES `actividades`.`materia` (`idmateria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `actividades`.`calificaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `actividades`.`calificaciones` (
  `calificacion` INT NULL,
  `recuperacion` INT NULL,
  `alumno_idalumno` INT NOT NULL,
  `materia_idmateria` INT NOT NULL,
  `actividad_idactividad` INT NOT NULL,
  INDEX `fk_calificaciones_alumno1_idx` (`alumno_idalumno` ASC),
  INDEX `fk_calificaciones_materia1_idx` (`materia_idmateria` ASC),
  INDEX `fk_calificaciones_actividad1_idx` (`actividad_idactividad` ASC),
  CONSTRAINT `fk_calificaciones_alumno1`
    FOREIGN KEY (`alumno_idalumno`)
    REFERENCES `actividades`.`alumno` (`idalumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_calificaciones_materia1`
    FOREIGN KEY (`materia_idmateria`)
    REFERENCES `actividades`.`materia` (`idmateria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_calificaciones_actividad1`
    FOREIGN KEY (`actividad_idactividad`)
    REFERENCES `actividades`.`actividad` (`idactividad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `actividades`.`maestro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `actividades`.`maestro` (
  `idmaestro` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `contrasena` VARCHAR(45) NULL,
  PRIMARY KEY (`idmaestro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `actividades`.`maestro_materia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `actividades`.`maestro_materia` (
  `maestro_idmaestro` INT NOT NULL,
  `materia_idmateria` INT NOT NULL,
  PRIMARY KEY (`maestro_idmaestro`, `materia_idmateria`),
  INDEX `fk_maestro_has_materia_materia1_idx` (`materia_idmateria` ASC),
  INDEX `fk_maestro_has_materia_maestro1_idx` (`maestro_idmaestro` ASC),
  CONSTRAINT `fk_maestro_has_materia_maestro1`
    FOREIGN KEY (`maestro_idmaestro`)
    REFERENCES `actividades`.`maestro` (`idmaestro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_maestro_has_materia_materia1`
    FOREIGN KEY (`materia_idmateria`)
    REFERENCES `actividades`.`materia` (`idmateria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `actividades`.`tutorados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `actividades`.`tutorados` (
  `maestro_idmaestro` INT NOT NULL,
  `alumno_idalumno` INT NOT NULL,
  PRIMARY KEY (`maestro_idmaestro`, `alumno_idalumno`),
  INDEX `fk_maestro_has_alumno_alumno1_idx` (`alumno_idalumno` ASC),
  INDEX `fk_maestro_has_alumno_maestro1_idx` (`maestro_idmaestro` ASC),
  CONSTRAINT `fk_maestro_has_alumno_maestro1`
    FOREIGN KEY (`maestro_idmaestro`)
    REFERENCES `actividades`.`maestro` (`idmaestro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_maestro_has_alumno_alumno1`
    FOREIGN KEY (`alumno_idalumno`)
    REFERENCES `actividades`.`alumno` (`idalumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
