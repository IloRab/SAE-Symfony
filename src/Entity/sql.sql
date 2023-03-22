-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour site
CREATE DATABASE IF NOT EXISTS `site` /*!40100 DEFAULT CHARACTER SET utf8mb4 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `site`;

-- Listage de la structure de procédure site. ajout_alimfav
DELIMITER //
CREATE PROCEDURE `ajout_alimfav`(
	IN `IdUser` VARCHAR(50),
	IN `AlimCode` INT
)
BEGIN
REPLACE INTO alimfavori VALUES(IdUser,AlimCode,YEAR(SYSDATE()));
END//
DELIMITER ;

-- Listage de la structure de table site. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Identifiant` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `Prenom` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `Naissance` date NOT NULL,
  `CodePostale` int unsigned NOT NULL,
  `Telephone` int unsigned NOT NULL,
  `Ville` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `Adresse` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`Identifiant`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

-- Listage de la structure de table site. aliment
CREATE TABLE IF NOT EXISTS `aliment` (
  `alim_code` int unsigned NOT NULL AUTO_INCREMENT,
  `alim_nom_fr` varchar(200) CHARACTER SET utf8mb4 NOT NULL,
  `alim_nom_sci` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `alim_grp_nom_fr` varchar(50) NOT NULL,
  `alim_ssgrp_nom_fr` varchar(50) NOT NULL,
  `alim_ssssgrp_nom_fr` varchar(50) NOT NULL,
  `energie(kcal/100g)` varchar(10) NOT NULL DEFAULT '-',
  `eau(g/100g)` varchar(10) NOT NULL DEFAULT '-',
  `proteines(g/100g)` varchar(10) NOT NULL DEFAULT '-',
  `glucides(g/100g)` varchar(10) NOT NULL DEFAULT '-',
  `lipides(g/100g)` varchar(10) NOT NULL DEFAULT '-',
  `sucres(g/100g)` varchar(10) NOT NULL DEFAULT '-',
  PRIMARY KEY (`alim_code`)
) ENGINE=InnoDB AUTO_INCREMENT=96782 DEFAULT CHARSET=utf8mb4;




-- Listage de la structure de procédure site. ajout_user
DELIMITER //
CREATE PROCEDURE `ajout_user`(
	IN `Id` VARCHAR(50),
	IN `mdp` VARCHAR(150),
	IN `Nom` VARCHAR(50),
	IN `Prenom` VARCHAR(50),
	IN `DateOfBirth` VARCHAR(10),
	IN `CodePostale` INT,
	IN `Tel` INT,
	IN `City` VARCHAR(30),
	IN `Address` VARCHAR(100)
)
BEGIN
INSERT INTO utilisateur(Identifiant,pwd,Nom,Prenom,Naissance, CodePostale,Telephone,Ville,Adresse) VALUES(Id,SHA2(mdp,512),Nom,Prenom, DateOfBirth,CodePostale,Tel,City,Address);
END//
DELIMITER ;

DELIMITER //

CREATE FUNCTION `verif_pwd` (attempt VARCHAR(150), identifiant_administre VARCHAR(50))
	RETURNS BOOLEAN
	READS SQL DATA
	DETERMINISTIC
BEGIN
  DECLARE correct_hash VARCHAR(150);

  SELECT u.pwd INTO correct_hash
  FROM utilisateur AS u
  WHERE u.Identifiant = identifiant_administre
  LIMIT 1;

  RETURN SHA2(attempt, 512) = correct_hash;

END; //

DELIMITER ;

-- Listage de la structure de table site. alimfavori
CREATE TABLE IF NOT EXISTS `alimfavori` (
  `Identifiant_User` varchar(50) NOT NULL DEFAULT '',
  `alim_code` int unsigned NOT NULL,
  `Annee` year NOT NULL,
  PRIMARY KEY (`Identifiant_User`,`alim_code`,`Annee`) USING BTREE,
  KEY `FK_Aliment` (`alim_code`),
  KEY `FK_Administre` (`Identifiant_User`) USING BTREE,
  CONSTRAINT `FK_Aliment` FOREIGN KEY (`alim_code`) REFERENCES `aliment` (`alim_code`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_User` FOREIGN KEY (`Identifiant_User`) REFERENCES `utilisateur` (`Identifiant`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table site.alimfavori : ~1 rows (environ)

-- Listage de la structure de procédure site. delete_user
DELIMITER //
CREATE PROCEDURE `delete_user`(
	IN `id` VARCHAR(50)
)
BEGIN
DELETE FROM utilisateur WHERE identifiant= id;
END//
DELIMITER ;

-- Listage de la structure de table site. sante_alim
CREATE TABLE IF NOT EXISTS `sante_alim` (
  `Code_alim` int unsigned NOT NULL,
  `Score` int unsigned NOT NULL,
  PRIMARY KEY (`Code_alim`),
  CONSTRAINT `FK__aliment` FOREIGN KEY (`Code_alim`) REFERENCES `aliment` (`alim_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

-- Listage de la structure de table site. score_sante
CREATE TABLE IF NOT EXISTS `score_sante` (
  `IdentifiantUser` varchar(50) NOT NULL,
  `Score` int NOT NULL,
  PRIMARY KEY (`IdentifiantUser`),
  CONSTRAINT `FK_User_score` FOREIGN KEY (`IdentifiantUser`) REFERENCES `utilisateur` (`Identifiant`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table site.score_sante : ~0 rows (environ)


-- Listage des données de la table site.utilisateur : ~0 rows (environ)

-- Listage de la structure de déclencheur site. calcul_score_aliment
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `calcul_score_aliment` AFTER INSERT ON `aliment` FOR EACH ROW BEGIN
	DECLARE score INT;
	SET score = FLOOR(0 + RAND()*(100-0));
	INSERT INTO sante_alim VALUES(NEW.alim_code, score);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Listage de la structure de déclencheur site. calcul_score_sante
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `calcul_score_sante` AFTER INSERT ON `alimfavori` FOR EACH ROW BEGIN 
	DECLARE sante INT;
	DECLARE done INT DEFAULT FALSE;
	DECLARE alim INTEGER;
	DECLARE nb_alim INTEGER;
	DECLARE score_alim INTEGER;
	DECLARE cur1 CURSOR FOR SELECT alim_code FROM alimfavori WHERE Identifiant_User= NEW.Identifiant_User;
   DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

SET sante = 0;
SELECT COUNT(alim_code) INTO nb_alim FROM alimfavori WHERE Identifiant_User=NEW.Identifiant_User;
OPEN cur1;
calcul: LOOP
	FETCH cur1 INTO alim;
	IF done then 
		LEAVE calcul;
	END IF;
SELECT score INTO score_alim FROM sante_alim WHERE code_alim = alim;
SET sante = sante + score_alim;
END LOOP calcul;
CLOSE cur1;
SET sante= sante / nb_alim;
REPLACE INTO score_sante VALUES(NEW.Identifiant_User,sante);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
