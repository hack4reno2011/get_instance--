{\rtf1\ansi\ansicpg1252\deff0\deflang1033{\fonttbl{\f0\fswiss\fcharset0 Arial;}}
{\*\generator Msftedit 5.41.15.1515;}\viewkind4\uc1\pard\f0\fs20 --\par
-- Table structure for table `data`\par
--\par
\par
CREATE TABLE IF NOT EXISTS `data` (\par
  `id` int(5) NOT NULL auto_increment,\par
  `alarm_level` int(5) NOT NULL,\par
  `call_type` varchar(25) NOT NULL,\par
  `jurisdiction` varchar(5) NOT NULL,\par
  `station` int(5) NOT NULL,\par
  `receive_datetime` datetime NOT NULL,\par
  `dispatch_first_time` time NOT NULL,\par
  `onscene_first_time` time NOT NULL,\par
  `fire_control_time` time NOT NULL,\par
  `close_time` time NOT NULL,\par
  PRIMARY KEY  (`id`)\par
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;\par
}
 