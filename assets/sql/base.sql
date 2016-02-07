CREATE TABLE IF NOT EXISTS `userdata` (
  `userid` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `sex` int(11) NOT NULL,
  `college` varchar(64) DEFAULT NULL,
  `year` varchar(8) DEFAULT NULL,
  `department` varchar(32) DEFAULT NULL,
  `collegeid` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ipaddress` varchar(32) DEFAULT NULL,
  `registration` int(2) DEFAULT '0',
  `hospitality` int(2) DEFAULT '0',
  `workshop` int(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `userdata`
 ADD PRIMARY KEY (`userid`), ADD UNIQUE KEY `email` (`email`);

CREATE TABLE userauth (
`userid` INT(11) UNIQUE KEY,
`email` VARCHAR(64) UNIQUE KEY,
`password` VARCHAR(512),
`activated` INT(1) DEFAULT 0,
`lastlogin` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
`ipaddress` VARCHAR(32),
FOREIGN KEY (`userid`) REFERENCES `userdata`(`userid`),
FOREIGN KEY (`email`) REFERENCES `userdata`(`email`)
) ENGINE=InnoDB;

CREATE TABLE events (
`eventid` INT(11) NOT NULL AUTO_INCREMENT,
`ename` VARCHAR(64) NOT NULL,
`min` INT(2) NOT NULL DEFAULT 1,
`max` INT(2) NOT NULL DEFAULT 1,
`confirmation` INT(1) NOT NULL DEFAULT 0,
PRIMARY KEY(`eventid`)
) ENGINE=InnoDB;

CREATE TABLE teams (
`teamid` INT(11) NOT NULL AUTO_INCREMENT,
`eventid` INT(11) NOT NULL,
`ename` VARCHAR(64) NOT NULL,
`status` INT NOT NULL DEFAULT 0,
`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`tsize` INT(2) NOT NULL DEFAULT 1,
`user1id` INT(11) NOT NULL,
`user2id` INT(11),
`user3id` INT(11),
`user4id` INT(11),
`user5id` INT(11),
`user6id` INT(11),
`user7id` INT(11),
`user8id` INT(11),
`user9id` INT(11),
`user1name` VARCHAR(32) NOT NULL,
`user2name` VARCHAR(32),
`user3name` VARCHAR(32),
`user4name` VARCHAR(32),
`user5name` VARCHAR(32),
`user6name` VARCHAR(32),
`user7name` VARCHAR(32),
`user8name` VARCHAR(32),
`user9name` VARCHAR(32),
`ipaddress` VARCHAR(32),
PRIMARY KEY (`teamid`),
FOREIGN KEY (`eventid`) REFERENCES `events`(`eventid`),
FOREIGN KEY (`user1id`) REFERENCES `userdata`(`userid`)
) ENGINE=InnoDB;

CREATE TABLE userevents1 (
`userid` INT(11) NOT NULL UNIQUE KEY,
`teamids` VARCHAR(1024) NOT NULL DEFAULT "[]",
`eventids` VARCHAR(1024) NOT NULL DEFAULT "[]",
FOREIGN KEY (`userid`) REFERENCES `userdata`(`userid`)
) ENGINE=InnoDB;

CREATE TABLE userevents (
`userid` INT(11) NOT NULL,
`teamid` INT(11) NOT NULL,
`eventid` INT(11) NOT NULL,
FOREIGN KEY (`userid`) REFERENCES `userdata`(`userid`),
FOREIGN KEY (`teamid`) REFERENCES `teams`(`teamid`),
FOREIGN KEY (`eventid`) REFERENCES `events`(`eventid`),
UNIQUE KEY `user_event` (`userid`, `eventid`)
) ENGINE=InnoDB;

CREATE TABLE workshops (
`workshopid` INT(11) NOT NULL AUTO_INCREMENT,
`wname` VARCHAR(64) NOT NULL,
`min` INT(2) NOT NULL DEFAULT 1,
`max` INT(2) NOT NULL DEFAULT 1,
`ccapacity` INT(5) NOT NULL DEFAULT 200,
`wcapacity` INT(5) NOT NULL DEFAULT 200,
`ccurrent` INT(5) NOT NULL DEFAULT 0,
`wcurrent` INT(5) NOT NULL DEFAULT 0,
PRIMARY KEY(`workshopid`)
) ENGINE=InnoDB;

CREATE TABLE userworkshops (
`userid` INT(11) NOT NULL,
`teamid` INT(11) NOT NULL,
`workshopid` INT(11) NOT NULL,
FOREIGN KEY (`userid`) REFERENCES `userdata`(`userid`),
FOREIGN KEY (`teamid`) REFERENCES `teams`(`teamid`),
FOREIGN KEY (`workshopid`) REFERENCES `workshops`(`workshopid`),
UNIQUE KEY `user_workshop` (`userid`, `workshopid`)
) ENGINE=InnoDB;

CREATE TABLE wteams (
`teamid` INT(11) NOT NULL AUTO_INCREMENT,
`workshopid` INT(11) NOT NULL,
`wname` VARCHAR(64) NOT NULL,
`status` INT NOT NULL DEFAULT 0,
`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`tsize` INT(2) NOT NULL DEFAULT 1,
`user1id` INT(11) NOT NULL,
`user2id` INT(11),
`user3id` INT(11),
`user4id` INT(11),
`user5id` INT(11),
`user6id` INT(11),
`user1name` VARCHAR(32) NOT NULL,
`user2name` VARCHAR(32),
`user3name` VARCHAR(32),
`user4name` VARCHAR(32),
`user5name` VARCHAR(32),
`user6name` VARCHAR(32),
`ipaddress` VARCHAR(32) DEFAULT '0.0.0.0',
PRIMARY KEY (`teamid`),
FOREIGN KEY (`workshopid`) REFERENCES `workshops`(`workshopid`),
FOREIGN KEY (`user1id`) REFERENCES `userdata`(`userid`)
) ENGINE=InnoDB;


CREATE TABLE transactions (
`transactionid` VARCHAR(64) NOT NULL,
`status` INT(2) NOT NULL DEFAULT '0',
`userid` INT(11) NOT NULL,
`workshopid` INT(11) DEFAULT NULL,
`registrationids` VARCHAR(1024) NOT NULL DEFAULT '[]',
`hospitalityids` VARCHAR(1024) NOT NULL DEFAULT '[]',
`timeinitial` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`timefinal` TIMESTAMP,
`ipaddressinitial` VARCHAR(32) NOT NULL DEFAULT '0.0.0.0',
`ipaddressfinal` VARCHAR(32) NOT NULL DEFAULT '0.0.0.0',
PRIMARY KEY(transactionid),
FOREIGN KEY(`userid`) REFERENCES `userdata`(`userid`),
FOREIGN KEY(`workshopid`) REFERENCES `workshops`(`workshopid`)
) ENGINE=InnoDB;