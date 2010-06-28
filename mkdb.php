#!/usr/bin/php
<?php
function dbQuery($mysql, $query) {
	$result = mysqli_query($mysql, $query);
	if(!$result) {
	        echo "\r\nERROR: An error occured in the database query:\r\n";
	        echo "\t" . $query . "\r\n";
	        echo "MySQL returned the following error:\r\n";
	        echo "\t" . mysqli_error($mysql) . "\r\n";
		return false;
	} else {
		return $result;
	}
}
// This PHP script will create the MySQL tables used by LizardBot for certain features.
// MySQL is NOT REQUIRED for LizardBot, but enables some extra features.
echo "Determining what configuration file we should use...\r\n";
$dir = $_SERVER['argv'][1];
$cfg = FALSE;
if(!$dir) {
        $dir = 'lizardbot.conf.php';
        $cfg = TRUE;
}
if($cfg) {
        echo "Will use the default configuration file, {$dir}\r\n";
} else {
        echo "Will use the user-specified config file {$dir}\r\n";
}
require_once($dir);
if(!$setEnableMySQL) {
	echo "WARNING: LizardBot's configuration file currently has MySQL usage *DISABLED*.\r\n";
	echo "While you can leave it this way, this script will be pretty useless unless you enable\r\n";
	echo "MySQL support....\r\n";
} elseif(!$setMySQLHost) {
	die("ERROR: You didn't define the MySQL database host in the configuration file.\r\n");
} elseif(!$setMySQLPort) {
	die("WARNING: You haven't specified a port to use to connect to MySQL.  Will default to 3306....\r\n");
	$setMySQLPort = 3306;
} elseif(!$setMySQLUserName) {
	die("ERROR: You haven't specified the username to use to access MySQL.\r\n");
} elseif(!$setMySQLPassword) {
	echo "WARNING: You haven't specified the password to use to access MySQL.  If you really don't\r\n";
	echo "need a pasword to connection, you're doing something wrong....\r\n";
} elseif(!$setMySQLDB) {
	die("ERROR: You haven't specified the name of the database to use  It does not have to exist yet.\r\n" .
	 "(if it does not exist, it will be automatically created.)\r\n");
} elseif(!$setMySQLTablePre) {
	echo "WARNING: You haven't specified a prefix to use for this LizardBot's tables.\r\n";
	echo "While this isn't too serious, it will make things difficult if you evern plan\r\n";
	echo "on running multiple MySQL-enabled instances of LizardBot.\r\n";
}
if($setMySQLTablePre) {
	$setMySQLTablePre .= "_";
}
echo "Connecting to MySQL...";
$mysql = mysqli_connect($setMySQLHost, $setMySQLUserName, $setMySQLPassword, NULL, $setMySQLPort) OR die(
 "\r\nFailed to connect to MySQL.  Please check your configuration settings.\r\nDetails: " .
 mysqli_connect_error() . "\r\n");
echo "    done!\r\n";
echo "Creating database (if it doesn't already exist)...";
if(dbQuery($mysql, "CREATE DATABASE IF NOT EXISTS `{$setMySQLDB}`")) {
	echo "    done!\r\n";
} else {
	die();
}
echo "Selecting the database for use...";
if(dbQuery($mysql, "USE `{$setMySQLDB}`")) {
	echo "    done!\r\n";
} else {
	die();
}
echo "Creating table `reminders` (for the reminder functionality of the bot)...";
$query = 
"CREATE TABLE IF NOT EXISTS `{$setMySQLTablePre}reminders` (
`reminder_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`reminder_text` VARCHAR(255) NOT NULL,
`reminder_time` DATETIME NOT NULL,
`reminder_requester` VARCHAR(255) NOT NULL,
`reminder_target_nick` VARCHAR(64) NOT NULL
) ENGINE=MyISAM";
if(dbQuery($mysql, $query)) {
	echo "    done!\r\n";
} else {
	die();
}
echo "Closing connection to MySQL....";
mysqli_close($mysql);
echo "    done!\r\n";
echo "LizardBot database setup is now complete!\r\n";
?>
