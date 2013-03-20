CREATE TABLE `dynamicdns` (
  `Password` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ServerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Password`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `highscores` (
  `Name` text,
  `Date` date DEFAULT NULL,
  `Status` enum('dead','alive') DEFAULT NULL,
  `Score` text,
  `ServerID` int(11) NOT NULL DEFAULT '0',
  `ID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`,`ServerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `hostoverride` (
  `Password` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `HostName` text,
  PRIMARY KEY (`Password`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `localdns` (
  `IP` varchar(15) NOT NULL DEFAULT '',
  `HostName` text,
  PRIMARY KEY (`IP`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `servers` (
  `Version` text,
  `Players` int(11) DEFAULT NULL,
  `MaxPlayers` int(11) DEFAULT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UpSince` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `HostName` text NOT NULL,
  `Comment` text,
  `IP` varchar(15) DEFAULT NULL,
  `Port` int(11) NOT NULL DEFAULT '0',
  `ProxyIP` varchar(15) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Credential` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=322527 ;

CREATE TABLE `uplink` (
  `Password` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `IP` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Password`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
