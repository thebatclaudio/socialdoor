<?php
/**
 * This is the install file
 * Remember to delete it after installation
 */

include_once "config.php";

$dbConn = new DBConn();

$sql = "CREATE TABLE IF NOT EXISTS `comments` (
		  `idComment` int(11) NOT NULL AUTO_INCREMENT,
		  `idUser` int(11) NOT NULL,
		  `idPost` int(11) NOT NULL,
		  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `content` text NOT NULL,
		  `ip` varchar(15) NOT NULL,
		  PRIMARY KEY (`idComment`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
		
		CREATE TABLE IF NOT EXISTS `notifications` (
		  `idNotification` int(11) NOT NULL AUTO_INCREMENT,
		  `idUser` int(11) NOT NULL,
		  `content` text NOT NULL,
		  `read` int(1) NOT NULL DEFAULT '0',
		  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`idNotification`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
		
		CREATE TABLE IF NOT EXISTS `openedDoors` (
		  `idUser` int(11) NOT NULL,
		  `idDoor` int(11) NOT NULL,
		  `message` varchar(240) NOT NULL,
		  `accepted` int(11) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`idUser`,`idDoor`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		
		CREATE TABLE IF NOT EXISTS `posts` (
		  `idPost` int(11) NOT NULL AUTO_INCREMENT,
		  `idUser` int(11) NOT NULL,
		  `idOwner` int(11) DEFAULT NULL,
		  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `content` text NOT NULL,
		  `ip` varchar(15) NOT NULL,
		  PRIMARY KEY (`idPost`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
		
		CREATE TABLE IF NOT EXISTS `posts_users` (
		  `idPost` int(11) NOT NULL,
		  `idUser` int(11) NOT NULL,
		  PRIMARY KEY (`idPost`,`idUser`),
		  KEY `idPost` (`idPost`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		
		CREATE TABLE IF NOT EXISTS `rooms` (
		  `idUser` int(11) NOT NULL,
		  `bgColor` varchar(7) NOT NULL,
		  `textColor1` varchar(7) NOT NULL,
		  `textColor2` varchar(7) NOT NULL,
		  `bgPost` varchar(7) NOT NULL,
		  PRIMARY KEY (`idUser`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		
		CREATE TABLE IF NOT EXISTS `users` (
		  `idUser` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(20) NOT NULL,
		  `surname` varchar(20) NOT NULL,
		  `birthday` date NOT NULL,
		  `sex` int(1) NOT NULL,
		  `city` varchar(40) NOT NULL,
		  `email` varchar(40) NOT NULL,
		  `password` varchar(64) NOT NULL,
		  `pic` int(1) NOT NULL DEFAULT '0',
		  `ip` varchar(15) NOT NULL,
		  `signupDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `website` varchar(50) DEFAULT NULL,
		  `work` varchar(30) DEFAULT NULL,
		  `relationship` varchar(20) DEFAULT NULL,
		  PRIMARY KEY (`idUser`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1;	";

if(!$dbConn->execute($sql)){
	echo "Ops! There was an error!";
} else {
	echo "Socialdoor has been successfully installed!";
}
?>