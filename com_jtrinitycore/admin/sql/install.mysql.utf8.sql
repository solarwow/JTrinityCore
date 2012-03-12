DROP TABLE IF EXISTS `#__jtc_items`;
CREATE TABLE `#__jtc_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `cost` int NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `realmid` int(11) NOT NULL DEFAULT '-1',
  `description` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `class` int NOT NULL DEFAULT '0',
  `allowablerace` int NOT NULL DEFAULT '0',
  `subclass` int NOT NULL DEFAULT '0',
  `itemlevel` int NOT NULL DEFAULT '0',
  `requiredlevel` int NOT NULL DEFAULT '0',
  `inventorytype` int NOT NULL DEFAULT '0',
  `quality` tinyint NOT NULL DEFAULT '0',
  `icon` varchar(50) NOT NULL DEFAULT '',
   UNIQUE(itemid),
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jtc_userpoints`;
CREATE TABLE `#__jtc_userpoints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `points` int NOT NULL DEFAULT '0',
  `active` bool NOT NULL DEFAULT '0',
  `lastdate` datetime NOT NULL,  
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jtc_orders`;
CREATE TABLE `#__jtc_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `points` int NOT NULL DEFAULT '0',
  `description` varchar(100) NOT NULL DEFAULT '',
  `productid` int(11) NOT NULL DEFAULT '0',
  `charid` int NOT NULL DEFAULT '0',
  `realmid` int NOT NULL DEFAULT '0',
  `ordertype` tinyint NOT NULL DEFAULT '0',
  `orderdate` datetime NOT NULL,  
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__jtc_donations`;
CREATE TABLE `#__jtc_donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL DEFAULT '0.0',
  `paypal_txn_id` varchar(100) NOT NULL DEFAULT '0',
  `completed` bit NOT NULL DEFAULT 0,
  `donationdate` datetime NOT NULL,  
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jtc_powerleveling`;
CREATE TABLE `#__jtc_powerleveling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minLevel` int NOT NULL DEFAULT '1',
  `maxLevel` int NOT NULL DEFAULT '1',
  `cost` int NOT NULL DEFAULT '0',  
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jtc_gold`;
CREATE TABLE `#__jtc_gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL DEFAULT '1',
  `cost` int NOT NULL DEFAULT '1',  
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jtc_realms`;
CREATE TABLE `#__jtc_realms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realmid` int(11) NOT NULL,
  `realmname` varchar(20) NOT NULL DEFAULT '',
  `charactersdb` varchar(20) NOT NULL DEFAULT 'characters',
  `worlddb` varchar(20) NOT NULL DEFAULT 'world',
  `versionserver` varchar(10) NOT NULL DEFAULT '3.3.5a',
  `servertype` varchar(20) NOT NULL DEFAULT 'PVP',
  `descriptiontitle` varchar(20) NOT NULL DEFAULT 'Rates: ',
  `description` varchar(30) NOT NULL DEFAULT 'x1 Blizzlike',
  `ip` varchar(20) NOT NULL DEFAULT '127.0.0.1',
  `port` int NOT NULL DEFAULT '8085',
  `population` int NOT NULL DEFAULT '0',  
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

