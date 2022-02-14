# phpboard
-- testdb.board definition

CREATE TABLE `board` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `subject` varchar(245) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  `modifydate` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8mb4;

-- testdb.file_table definition

CREATE TABLE `file_table` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  `status` tinyint(4) DEFAULT 1,
  `memoid` int(11) DEFAULT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4;

-- testdb.members definition

CREATE TABLE `members` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(145) DEFAULT NULL,
  `email` varchar(245) DEFAULT NULL,
  `username` varchar(145) DEFAULT NULL,
  `passwd` varchar(200) DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;


-- testdb.memo definition

CREATE TABLE `memo` (
  `memoid` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `memo` varchar(300) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `regdate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`memoid`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

-- testdb.recommend definition

CREATE TABLE `recommend` (
  `reid` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`reid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
