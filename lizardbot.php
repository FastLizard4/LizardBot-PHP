#!/usr/bin/php
<?php
error_reporting(E_ALL & ~E_NOTICE);
$cmdcount = 0;
$pingcount = 0;
$ctcpcount = 0;
$aicount = 0;
$insultcount = 0;
$fishcount = 0;
echo "Determining what configuration file we should use...\r\n";
$dir = $_SERVER['argv'][1];
$cfg = FALSE;
if(!$dir) {
	$dir = 'lizardbot.conf.php';
	$cfg = TRUE; 
}
if($cfg) {
	echo "{$c_green}Will use the default configuration file, {$dir}{$c_n}\r\n";
} else {
	echo "{$c_green}Will use the user-specified config file {$dir}{$c_n}\r\n";
}
echo "Loading essential config files...\r\n";
$rehash = TRUE;
require("default.conf.php");
require($dir);
$rehash = FALSE;

//Load hasPriv function
function hasPriv($priv) {
	global $privgroups, $users, $d, $setIsOnWindows, $setUsePCREs;
	$parsed = $d[0];
	foreach( $users as $user => $group ) {
		if($setUsePCREs || $setIsOnWindows) {
			if($user == "*!*@*") continue;
			if( preg_match( $user, $parsed/*['n!u@h']*/ ) ) {
				if( isset( $privgroups[$group][$priv] ) ) {
					return $privgroups[$group][$priv];
				} else {
					return 0;
				}
			}
		} elseif (!$setUsePCREs && !$setIsOnWindows) {
			if( fnmatch( $user, $parsed/*['n!u@h']*/ ) ) {
				if( isset( $privgroups[$group][$priv] ) ) {
					return $privgroups[$group][$priv];
				} else {
					return 0;
				}
			}
		}
	}
	$d[0] = $parsed;
}

echo "OK!\r\n";
if(!$setIsOnWindows) {
	$c_n = chr(27) . "[0m";
	$c_dark = chr(27) . "[01;90m";
	$c_red = chr(27) . "[01;91m";
	$c_green = chr(27) . "[01;92m";
	$c_yellow = chr(27) . "[01;93m";
	$c_blue = chr(27) . "[01;94m";
	$c_pink = chr(27) . "[01;95m";
	$c_cyan = chr(27) . "[01;96m";
	$c_bold = chr(27) . "[01;1m";
	$c_ul = chr(27) . "[01;4m";
	$c_b_dark = chr(27) . "[01;5m";
	$c_b_light = chr(27) . "[01;7m";
	$c_b_red = chr(27) . "[01;41m";
	$c_b_green = chr(27) . "[01;42m";
	$c_b_yellow = chr(27) . "[01;43m";
	$c_b_blue = chr(27) . "[01;44m";
	$c_b_pink = chr(27) . "[01;45m";
	$c_b_cyan = chr(27) . "[01;46m";
	$c_b_light_bold = chr(27) . "[01;47m";
}
echo $c_green;
?>
*******************************************************************************
 _      _______  _________  __________   _______    ____
| |    |__   __||_______/ /| _______  | | |___| |  | || \
| |       | |          / / | |      | | | |___| |  | | | |
| |       | |         / /  | |______| | | |___|_|  | | | | BOT
| |___  __| |__   ___/ /__ | |______| | | |  \  \  | |_| |
|_____||_______| |________||_|      |_| |_|   \__\ |____/

LizardBot for PHP: IRC bot developed by FastLizard4 (who else?) and the LizardBot Development Team
Version 7.3.0.0b (major.minor.build.revision) BETA
Licensed under the Creative Commons GNU General Public License 2.0 (GPL)
For licensing details, contact me or read this page:
http://creativecommons.org/licenses/GPL/2.0/
REPORT BUGS AND SUGGESTIONS TO BUGZILLA (http://scalar.cluenet.org/bugzilla)

LICENSING DETAILS:
LizardBot for PHP (IRC bot) written by FastLizard4 and the LizardBot Development Team
Copyright (C) 2008-2013 FastLizard4 and the LizardBot Development Team

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
A human-readable version of the complete license is available at
http://creativecommons.org/licenses/GPL/2.0/

PandoraBot extension courtesy of Ttech (PHP-5 OOP)
<?php echo $c_blue; ?>
*******************************************************************************
*KNOWN ISSUES WITH THE BOT:
 1. Private messages may not work as expected.
 2. No logging functions (may be implemented some time in the future)
*******************************************************************************
<?php
//Check for updates
echo "{$c_yellow}Checking for updates...\r\n";
$version = "7.3.0.0b";
$upfp = @fopen('http://fastlizard4.org/w/index.php?title=LizardBot/Latest&action=raw', 'r');
$data = @fgets($upfp);
@fclose($upfp);
if(!$data) {
echo "{$_bold}Check for updates failed!{$c_n}\r\n";
}
if($data == $version) {
	echo "{$c_green}>>>>You have the latest version, {$version}<<<<{$c_n}\r\n";
} else {
	echo "{$c_red}>>>>You do not have the latest version, {$data}<<<<{$c_n}\r\n";
}
/**********************************************
BEGIN PANDORABOT
**********************************************/
echo "Loading pandorabot extension...\r\n";
// *PHP 5* ONLY

class pandorabot {

    public $botid;
    public $_Pipe; // This will be our cURL handle in a bit
    public $timout = 50;
    public $default_response = "Probably"; // Use the function to set this.
    private $path_url = "http://www.pandorabots.com/pandora/talk?botid="; // So we can easily change url if needed
//    private $path_url = "http://localhost/~fastlizard4/blank.html";



/* Sanity Checking Function */
    public function pandorabot($botid=""){
        /* Run all init and such now. */
        $botid = trim($botid);
        if(isset($botid)){
            // Init Curl
            $this->_Pipe = curl_init();
            curl_setopt($this->_Pipe, CURLOPT_URL, $this->path_url.$botid);
            curl_setopt($this->_Pipe, CURLOPT_POST, 1);
            curl_setopt($this->_Pipe, CURLOPT_RETURNTRANSFER, 1);
        }
    }


    public function default_response($response=""){
        /* Check to see if $response is set otherwise we return the default */
        if(isset($response)){
            // Check to make sure new response is actually there
            if(!$this->sanitize($response) == FALSE){
                $this->default_response = $this->sanitize($response); // Set response
            }
        } else {
            // No new response set, return the already set one.
            return $this->default_response;
        }
    }

    public function say($user_input){
        $name = "input"; // Used to submit the form post
        $input = $this->sanitize($user_input);
        // Stupid debug stuff
    //    echo $this->timeout."<br />";
        curl_setopt($this->_Pipe, CURLOPT_TIMEOUT, $this->timout);
        curl_setopt ($this->_Pipe, CURLOPT_POSTFIELDS, "Name=$name&input=$input");
        curl_setopt ($this->_Pipe, CURLOPT_FOLLOWLOCATION, 1);
        $reply = curl_exec($this->_Pipe);
        if(isset($reply) && !preg_match('/^\s*$/', $reply)){
            return $this->get_say($reply);
        } elseif(!isset($reply) || preg_match('/^\s*$/', $reply)) {
            return $this->default_response;
	}
        curl_close($this->_Pipe);
    }

    public function set_timeout($int){
        if(!is_int($int)){
            $this->timeout = 60;
            return FALSE;
        } else {
            $this->timeout = $int;
            return TRUE;
        }
    }

    private function sanitize($string){
        $string = trim(str_replace("\n", "", stripslashes(html_entity_decode($string))));
            if(!empty($string)){
                return $string;
            } else { // Nothing is returned, return false
                return FALSE;
            }
    }

    private function get_say($input, $tag='font'){
        // Do a little regex to get the bot reply
        $pattern = "#<$tag color=\"\\w+\">(.*?)</$tag>#";
        $var = preg_match($pattern, $input, $matches);
        $result = $this->sanitize($matches[1]); // Get outout and send for validation
        /* Simple Sanity Check  - Null */
            if($result == FALSE OR empty($result)){
                return $this->default_response();
            } else {
                return $result; // Return valid string.
            }
    }

}
echo "Pandorabot class loaded!\r\n";
echo "Preparing fishb0t module...\r\n";
$fishCresponses = array
	(
                    '/hampster/i'            => '%n: There is no \'p\' in hamster you retard.',
                    '/vinegar.*aftershock/i'    => 'Ah, a true connoisseur!',
                    '/aftershock.*vinegar/i'    => 'Ah, a true connoisseur!',
                    '/^some people are being fangoriously devoured by a gelatinous monster$/i'
                                    => 'Hillary\'s legs are being digested.',
                    '/^ag$/i'            => 'Ag, ag ag ag ag ag AG AG AG!',
                    '/^(fishbot|%f) owns$/i'        => 'Aye, I do.',
                    '/vinegar/i'            => 'Nope, too sober for vinegar.  Try later.',
                    '/martian/i'            => 'Don\'t run! We are your friends!',
                    '/^just then, he fell into the sea$/i'
                                    => 'Ooops!',
                    '/aftershock/i'            => 'mmmm, Aftershock.',
                    '/^why are you here\?$/i'    => 'Same reason.  I love candy.',
                    '/^spoon$/i'            => 'There is no spoon.',
                    '/^(bounce|wertle)$/i'        => 'moo',
                    '/^crack$/i'            => 'Doh, there goes another bench!',
                    '/^you can\'t just pick people at random!$/i'
                                    => 'I can do anything I like, %n, I\'m eccentric!  Rrarrrrrgh!  Go!',
                    '/^flibble$/i'            => 'plob',
                    '/(the fishbot has created splidge|fishbot created splidge)/i'
                                    => 'omg no! Think I could show my face around here if I was responsible for THAT?',
                    '/^now there\'s more than one of them\?$/i'
                                    => 'A lot more.',
                    '/^i want everything$/i'    => 'Would that include a bullet from this gun?',
                    '/we are getting aggravated/i'    => 'Yes, we are.',
                    '/^how old are you, (fishbot|%f)\?$/i'
                                    => chr(1).'ACTION is older than time itself!'.chr(1),
                    '/^atlantis$/i'            => 'Beware the underwater headquarters of the trout and their bass henchmen. From there they plan their attacks on other continents.',
                    '/^oh god$/i'            => 'fishbot will suffice.',
                    '/^(fishbot|%f)$/i'            => 'Yes?',
                    '/^what is the matrix\?$/i'    => 'No-one can be told what the matrix is.  You have to see it for yourself.',
                    '/^what do you need\?$/i'    => 'Guns. Lots of guns.',
                    '/^i know kungfu$/i'        => 'Show me.',
                    '/^cake$/i'            => 'fish',
                    '/^trout go m[o0][o0]$/i'    => 'Aye, that\'s cos they\'re fish.',
                    '/^kangaroo$/i'            => 'The kangaroo is a four winged stinging insect.',
                    '/^sea bass$/i'            => 'Beware of the mutant sea bass and their laser cannons!',
                    '/^trout$/i'            => 'Trout are freshwater fish and have underwater weapons.',
                    '/has returned from playing counterstrike/i'
                                    => 'like we care fs :(',
                    '/^where are we\?$/i'        => 'Last time I looked, we were in %c.',
                    '/^where do you want to go today\?$/i'
                                    => 'anywhere but redmond :(.',
                    '/^fish go m[o0][o0]$/i'    => chr(1).'ACTION notes that %n is truly enlightened.'.chr(1),
                    '/^(.*) go m[o0][o0]$/i'    => '%n: only when they are impersonating fish.',
                    '/^fish go (.+)$/i'    => '%n LIES! Fish don\'t go %1! fish go m00!',
                    '/^you know who else (.*)$/i'    => '%n: YA MUM!',
                    '/^if there\'s one thing i know for sure, it\'s that fish don\'t m00\.?$/i'
                                    => '%n: HERETIC! UNBELIEVER!',
                    '/^(fishbot|%f): muahahaha\. ph33r the dark side\. :\)$/i'
                                    => '%n: You smell :P',
                    '/^ammuu\?$/i'            => '%n: fish go m00 oh yes they do!',
                    '/^fish$/i'            => '%n: fish go m00!',
                    '/^snake$/i'            => 'Ah snake a snake! Snake, a snake! Ooooh, it\'s a snake!',
                    '/^carrots handbags cheese$/i'    => 'toilets russians planets hamsters weddings poets stalin KUALA LUMPUR! pygmies budgies KUALA LUMPUR!',
                    '/sledgehammer/i'        => 'sledgehammers go quack!',
                    '/^badger badger badger badger badger badger badger badger badger badger badger badger$/i'
                                    => 'mushroom mushroom!',
                    '/^moo\?$/i'            => 'To moo, or not to moo, that is the question. Whether \'tis nobler in the mind to suffer the slings and arrows of outrageous fish...',
                    '/^herring$/i'            => 'herring(n): Useful device for chopping down tall trees. Also moos (see fish).',
                    '/www\.outwar\.com/i'        => 'would you please GO AWAY with that outwar rubbish!',
                    '/^god$/i'            => 'Sometimes the garbage disposal gods demand a spoon.',
                    '/stupid bot[!?.]*$/i' => '%n: Stupid human.',
                    '/fail bot[!?.]*$/i' => '%n: Fail human.',
		    '/good bot[!?.]*$/i' => chr(1).'ACTION purrs at %n'.chr(1),
		    '/^I am the Doctor,? and you are the Daleks!?$/i' => 'WE ARE THE DALEKS!! Exterminate! EXTEEERRRRMIIINAAAATE!',
		    '/^ping$/i' => 'pong',
		    '/^pong$/i' => 'pang',
		    '/^pang$/i' => 'pung',
		    '/^pung$/i' => 'derp'
                );
            
            $fishAresponses = array
                (
                    '/hampster/i'            => '%n: There is no \'p\' in hamster you retard.',
                    '/^feeds (fishbot|%f) hundreds and thousands$/i'
                                    => 'MEDI.. er.. FISHBOT',
                    '/(vinegar.*aftershock|aftershock.*vinegar)/i'
                                    => 'Ah, a true connoisseur!',
                    '/vinegar/i'            => 'Nope, too sober for vinegar.  Try later.',
                    '/martians/i'            => 'Don\'t run! We are your friends!',
                    '/aftershock/i'            => 'mmmm, Aftershock.',
                    '/(the fishbot has created splidge|fishbot created splidge)/i'
                                    => 'omg no! Think I could show my face around here if I was responsible for THAT?',
                    '/we are getting aggravated/i'    => 'Yes, we are.',
                    '/^strokes (fishbot|%f)$/i'        => chr(1).'ACTION m00s loudly at %n.'.chr(1),
                    '/^slaps (.*) around a bit with a large trout$/i'
                                    => 'trouted!',
                    '/has returned from playing counterstrike/i'
                                    => 'like we care fs :(',
                    '/^fish go m[o0][o0]$/i'    => chr(1).'ACTION notes that %n is truly enlightened.'.chr(1),
                    '/^(.*) go m[o0][o0]$/i'    => '%n: only when they are impersonating fish.',
                    '/^fish go (.+)$/i'    => '%n LIES! Fish don\'t go %1! fish go m00!',
                    '/^you know who else (.*)$/i'    => '%n: YA MUM!',
                    '/^thinks happy thoughts about pretty (.*)$/i'
                                    => chr(1).'ACTION has plenty of pretty %1. Would you like one %n?'.chr(1),
                    '/^snaffles a (.*) off (fishbot|%f).?$/i'
                                    => ':(',
                    '/stupid bot[!?.]*$/i' => '%n: Stupid human.',
                    '/fail bot[!?.]*$/i' => '%n: Fail human.',
                    '/good bot[!?.]*$/i' => chr(1).'ACTION purrs at %n'.chr(1),
                    '/^ping$/i' => 'pong',
                    '/^pong$/i' => 'pang',
                    '/^pang$/i' => 'pung',
                    '/^pung$/i' => 'derp'
                );
echo "Fishb0t module readied!  FISH GO M00 OH YES THEY DO! [citation needed]\r\n";
/**********************************************
END PANDORABOT
**********************************************/
$rehash = FALSE;
function tr(&$var) {
	$var = trim($var);
}
if($setIsOnWindows) {
	echo "Will skip signal handlers, we're running on Windows...\r\n";
} else {
	echo "Preparing signal handlers...\r\n";
	declare(ticks = 1);
	function SIGHUP() {
		global $users, $privgroups, $dir;
		echo "-!- Caught SIGHUP (1), now rehasing\r\n";
		$rehash = TRUE;
		require("default.conf.php");
		include($dir);
		if($setMySQLTablePre) {
			$setMySQLTablePre .= "_";
		}
		$rehash = FALSE;
		echo "-!- Rehash complete.\r\n";
	}
	function SIGTERM() {
	global $c_n, $c_red;
	//        die();
	        global $ircc, $irc;
	        fwrite($ircc, "QUIT :Oh noes! :O Caught deadly signal 15 SIGTERM!!\r\n");
	        echo <<<IRCO
{$c_red}-!- QUIT :Oh noes! :O Caught deadly signal 15 SIGTERM!!\n
*** DISCONNECTING FROM {$irc['address']}!\n
IRCO;
	        fclose($ircc);
	        die("Caught SIGTERM!\n{$c_n}");
	}
	function SIGINT() {
		global $c_n, $c_red;
	        global $ircc, $irc;
	        fwrite($ircc, "QUIT :Oh noes! :O Caught deadly SIGINT (^C) from terminal!!!\r\n");
	        echo <<<IRCO
{$c_red}-!- QUIT :Oh noes! :O Caught deadly SIGINT!!\n
*** DISCONNECTING FROM {$irc['address']}!\n
IRCO;
	        fclose($ircc);
	        die("Caught SIGINT!\n{$c_n}");
	}
	echo "Initializing Signal Handlers...\r\n";
// setup signal handlers
	pcntl_signal(SIGHUP, "SIGHUP");
	pcntl_signal(SIGTERM, "SIGTERM");
	pcntl_signal(SIGINT, "SIGINT");
	echo "Success!\r\n";
}
//PHP Bot for FastLizard4
echo "Welcome to the interface for LizardBot-1!\r\n";
echo "Determining what configuration file we should use...\r\n";
$dir = $_SERVER['argv'][1];
$cfg = FALSE;
if(!$dir) {
	$dir = 'lizardbot.conf.php';
	$cfg = TRUE; 
}
if($cfg) {
	echo "{$c_green}Will use the default configuration file, {$dir}{$c_n}\r\n";
} else {
	echo "{$c_green}Will use the user-specified config file {$dir}{$c_n}\r\n";
}
echo "Loading essential config files...\r\n";
require("default.conf.php");
require($dir);
echo "OK!\r\n";
echo "Verifying required settings are present...\r\n";
if(!$users) {
	die("{$c_red}Users array missing.{$c_n}\r\n");
}
if(!$privgroups) {
	die("{$c_red}Privgroups array missing.{$c_n}\r\n");
}
if(!$nickname) {
	die("{$c_red}Default nickname missing from config file.{$c_n}\r\n");
}
if(!$setTrigger) {
	$setTrigger = "@";
}
if(!$setEnableMySQL) {
	echo "{$c_yellow}MySQL and all commands requiring MySQL are disabled.{$c_n}\r\n";
}
if($setEnableMySQL) {
	echo "{$c_green}MySQL support enabled!{$c_n}\r\n";
	if(!$setMySQLHost) {
		die("{$c_red}MySQL database server address not specified (\$setMySQLHost)!{$c_n}\r\n");
	} elseif(!$setMySQLPort) {
		echo "{$c_yellow}No port for connecting to the MySQL server specified, will use\r\n";
		echo "default of 3306...{$c_n}\r\n";
		$setMySQLPort = 3306;
	} elseif(!$setMySQLUserName) {
		die("{$c_red}No MySQL database connection username specified!{$c_n}\r\n");
	} elseif(!$setMySQLPassword) {
		echo "{$c_yellow}Really?  No password for connecting to MySQL specified.\r\n";
		echo "If none is needed, you're doing it wrong....{$c_n}\r\n";
	} elseif(!$setMySQLDB) {
		die("{$c_red}No MySQL database to use specified in the config file!{$c_n}\r\n");
	}
	if($setMySQLTablePre) {
		$setMySQLTablePre .= "_";
	}
}
echo "Creating the MySQL-related functions....\r\n";
if(!$setEnableMySQL) {
	echo "You might be wondering why this is happening even though MySQL\r\n";
	echo "is disabled.  The functions are being created so that you can\r\n";
	echo "enable MySQL support while the bot is running without crashing\r\n";
	echo "the bot.  However, before you try to do this (enable MySQL\r\n";
	echo "support while the bot is running), make sure that you have read\r\n";
	echo "the MySQL documentation on the wiki *COMPLETELY*, or bad stuff\r\n";
	echo "*WILL* happen.\r\n";
}
function dbConnect() {
	global $setMySQLHost, $setMySQLPort, $setMySQLUserName, $setMySQLPassword, $setMySQLDB;
	$mysql =  mysqli_connect($setMySQLHost, $setMySQLUserName, $setMySQLPassword, $setMySQLDB, $setMySQLPort) OR
	print("{$c_red}Failed to connect to the MySQL server!  Details:\r\n" .
	mysqli_connect_error() . "{$c_n}\r\n");
	return $mysql;
}
function mkSane($mysql, $data) {
	return trim(mysqli_real_escape_string($mysql, $data));
}
function dbQuery($mysql, $query, &$result) {
        $result = mysqli_query($mysql, $query);
        if(!$result) {
                echo "\r\nERROR: An error occured in the database query:\r\n";
                echo "\t" . $query . "\r\n";
                echo "MySQL returned the following error:\r\n";
                echo "\t" . mysqli_error($mysql) . "\r\n";
                return "An error occured in the MySQL database query.  Please check the console for details.";
        } else {
                return false;
        }
}
if($setEnableMySQL) {
	echo "Verifying connection to MySQL database....";
	$mysql = dbConnect();
	if(!mysql) {die();}
	mysqli_close($mysql);
	echo "{$_green}    done!{$c_n}\r\n";
}
if(!$setBitlyAPISleep || !is_int($setBitlyAPISleep)) {
	$setBitlyAPISleep = 30;
}
if(!$timezone) {
	echo <<<EOD
{$c_red}WARNING!  You did not specify a time zone!  This means you are using
the timezone being used by your computer or in your PHP configuration file.  It
is strongly recommended that you set the timezone using the \$timezone variable in
your LizardBot configuration file!  You have been warned!{$c_n}\r\n
EOD;
} else {
	date_default_timezone_set($timezone);
}
echo "OK!";
if($autoconnect['enabled']) {
	echo <<<EOD
\r\n{$c_yellow}ATTENTION!  Autoconnect directives are enabled in your configuration file!\r\n
The bot will begin autoconnecting in 7 seconds... press ^C NOW if you do not want this to happen!{$c_n}\r\n
EOD;
	sleep(7);
}
echo <<<CONSOLEOUTPUT
\n{$c_bold}Please enter the FULL address of the network you wish to join.\r\n
Specify it as address:port.  If no port is specified, 6667 is used.\r\n
{$c_ul}For example: irc.myircnetwork.com:8001 (REQUIRED): 
CONSOLEOUTPUT;
if($autoconnect['enabled'] && $autoconnect['network']) {
	$irc['address'] = $autoconnect['network'];
	if(stristr($irc['address'], ":")) {
		$temp = explode(":", $irc['address']);
		$irc['address'] = $temp[0];
		$irc['port'] = $temp[1];
	}
} elseif($autoconnect['enabled'] && !$autoconnect['network']) {
	die("\r\n{$c_red}ERROR: Autoconnect is enabled, but no network was given in config file.{$c_n}\r\n");
} elseif(!$autoconnect['enabled']) {
	while(!$irc['address']) {
		$irc['address'] = fgets(STDIN);
		tr($irc['address']);
		if(stristr($irc['address'], ":")) {
			$temp = explode(":", $irc['address']);
			$irc['address'] = $temp[0];
			$irc['port'] = $temp[1];
		}
	}
}
if(!$irc['address']) {
	die("${c_red}No address given.{$c_n}\r\n");
}
//$nick = $setNick;
echo <<<EOD
{$c_n}{$c_green}Input of "{$irc['address']}" received!{$c_n}\r\n
{$c_bold}Please enter the desired nickname for your bot.  If you enter "." and strike
enter, the default (in brackets) will be used\r\n
{$c_ul}Nickname [$nickname]: 
EOD;
if($autoconnect['enabled'] && $autoconnect['nick']) {
	$nick = $autoconnect['nick'];
} elseif($autoconnect['enabled'] && !$autoconnect['nick']) {
	die("\r\n{$c_red}ERROR: Autoconnect is enabled, but no nickname was given in config file.{$c_n}\r\n");
} elseif(!$autoconnect['enabled']) {
	while(!$nick) {
		fscanf(STDIN, "%s", $nick);
	}
}
if($nick == ".") {
	$nick = $nickname;
	echo <<<EOD
{$c_n}{$c_green}No nickname received, using default of $nickname.{$c_n}\r\n
EOD;
} else {
	echo <<<EOD
{$c_n}{$c_green}Input of {$nick} received, using that as our nick.{$c_n}\r\n
EOD;
}
echo <<<EOD
{$c_bold}Now checking validity of the nickname using standard regex tests...\r\n
EOD;
if(!preg_match('/^([A-Za-z_\[\]\|])([\w-\[\]\^\|`])*$/', $nick)) {
	echo <<<EOD
{$c_n}{$c_red}The regex does not match the nick, meaning that the IRC daemon of the server
you are attempting to connect to would likely reject your registration signal.
Please restart the program and select a valid nick.\r\n
A valid nick is: First character is any letter A-Z or a-z, all other characters
up to 12 can be A-Z, a-z, 0-9, _, -, or ^.\r\n
EOD;
	die($c_n);
}
echo <<<EOD
{$c_ul}Should I send identification information to NickServ? (yes/no, default no): 
EOD;
if($autoconnect['enabled'] && $autoconnect['identify']) {
	$irc['identify'] = $autoconnect['identify'];
} elseif($autoconnect['enabled'] && !$autoconnect['identify']) {
	die("\r\n{$c_red}ERROR: Autoconnect is enabled, but no id mode was given in the config file.{$c_n}\r\n");
} elseif(!$autoconnect['enabled']) {
	while(!$irc['identify']) {
		fscanf(STDIN, "%s", $irc['identify']);
	}
}
switch ($irc['identify']) {
	case "yes":
	case "y":
		echo "{$c_n}{$c_green}OK, will send identification info to NickServ.{$c_n}\r\n";
		$irc['get-ident'] = true;
		$irc['identify'] = true;
	break;
	case "no":
	case "n":
	default:
		echo "{$c_n}{$c_green}OK, will not send identification info to NickServ.${c_n}\r\n";
		$irc['get-ident'] = false;
		$irc['identify'] = false;
	break;
}
if(!$setNSUsername) {
	$irc['default-ns'] = "  ";
} else {
	$irc['default-ns'] = "  [$setNSUsername]: ";
}
if($irc['get-ident']) {
	echo <<<EOD
{$c_bold}You will shortly be requested to enter the primary nickname of your account.
Note that this is only usable on Atheme, and cannot be used with other daemons,
such as Anope to the point that identification will fail.  It is recommended
you use this function with Atheme to guarantee your bot correctly identifies.\r\n
To send the default (if present), enter "." and strike enter.  To send NO
primary username, enter "#" and strike enter.  Otherwise, enter the username
you would like to use and strike enter.\r\n
Please note that this is not the same as the bot nickname.\r\n
{$c_ul}OK, what is the primary username on the account?{$irc['default-ns']}
EOD;
	if($autoconnect['enabled'] && $autoconnect['id-nick']) {
		$NSUsername = $autoconnect['id-nick'];
	} elseif($autoconnect['enabled'] && !$autoconnect['id-nick']) {
		die("\r\n{$c_red}ERROR: Autoconnect is enabled, but no nickserv username is in the config file.{$c_white}\r\n");
	} elseif(!$autoconnect['enabled']) {
		while(!$NSUsername) {
			fscanf(STDIN, "%s", $NSUsername);
		}
	}
	if($NSUsername == ".") {
		$irc['ns-username'] = $setNSUsername . " ";
		echo <<<EOD
{$c_n}{$c_green}No input received, using default {$setNSUsername}.{$c_n}\r\n
EOD;
	} elseif($NSUsername == "#") {
		echo <<<EOD
{$c_n}{$c_green}"#" received, will not send a username to NickServ.{$c_n}\r\n
EOD;
		$irc['ns-username'] = NULL;
	} else {
		$irc['ns-username'] = $NSUsername . " ";
		echo <<<EOD
{$c_n}{$c_green}Input of {$NSUsername} received, using that to identify.{$c_n}\r\n
EOD;
	}
	echo <<<EOD
{$c_bold}You will now be prompted to enter the NickServ password.  Please note that THE
PASSWORD IS NOT SAVED and it will be VISIBLE IN THE CONSOLE IN CLEAR TEXT, but
should disappear when it leaves the screen buffer.  For this reason, you should
make sure any files containg a shell log should only be readable by you and
only priveleged others.\r\n
IF YOU DO NOT WANT TO ENTER A PASSWORD AND ABORT IDENTIFICATION, ENTER "." AND
STRIKE ENTER AT THIS PROMPT.\r\n
{$c_ul}OK, what is the password?  
EOD;
	if($autoconnect['enabled'] && $autoconnect['id-pass']) {
		$NSPassword = $autoconnect['id-pass'];
	} elseif($autoconnect['enabled'] && !$autoconnect['id-pass']) {
		die("\r\n{$c_red}ERROR: Autoconnect is enabled, but no nickserv password was given in config.{$c_n}\r\n");
	} elseif(!$autoconnect['enabled']) {
		while(!$NSPassword) {
			fscanf(STDIN, "%s", $NSPassword);
		}
	}
	if($NSPassword == ".") {
		echo "{$c_n}{$c_yellow}No input received, WILL NOT IDENTIFY!\r\n";
		$irc['identify'] = false;
		
	} else {
		$irc['ns-password'] = $NSPassword;
		unset($NSPassword);
		echo "{$c_n}{$c_green}Input received, using that to identify.\r\n";
		$irc['identify'] = true;
	}
	unset($autoconnect['id-pass']); //For security purposes
}
/*foreach($irc as $key => $val) {
	echo "$key => $val\r\n";
}*/
echo <<<CONSOLEOUTPUT
{$c_n}Attempting to connect to "{$irc['address']}"...\n
Now commencing connection process...\n
Opening socket...\n
CONSOLEOUTPUT;
$n = 0;
$open = false;
//$fp = array();
while(!$open) {
	if(isset($fp[$n])) {
	$n++;
} else {
	$open = true;
	if(!$irc['port']) { $irc['port'] = 6667; }
//	echo $irc . "\r\n";
	try { 
		if(!$fp[$n] = fsockopen($irc['address'], $irc['port'], $error, $error2, 15)) {
			if(stristr($error2, "A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.")) {
				$error2 .= "(Connection Timed Out)";
			}
			throw new Exception("Could not open socket! (ERRNO: 1)\r\nTechnical details:\r\nE1: $error\r\nE2: $error2");
		}
	} catch (Exception $e) {
		echo "{$c_red}Could not connect because: " . $e->getMessage() . "\n";
		die($c_n);
	}
	echo <<<CONSOLEOUTPUT
Socket to {$irc['address']} opened on port {$irc['port']}...\n
Socket ID is: $n\n
-!- CONNECTING TO {$irc['address']}:{$irc['port']} ...\n
CONSOLEOUTPUT;
echo <<<STDOUT
Sleeping for 5 seconds to make sure we are connected before registering...\r\n
STDOUT;
sleep(5);
}
}
if(!$setIdent) $setIdent = "bot";
if(!$setGecos) $setGecos = "bot";
if($fp[$n]) {
	$connected = false;
	for($i = 1; $i <=2; $i++) {
		global $fp;
		fwrite($fp[$n], "USER $setIdent bot bot :$setGecos\r\n");
		echo <<<IRCO
-!- USER $setIdent bot bot :$setGecos\r\n
IRCO;
		fwrite($fp[$n], "NICK $nick\r\n");
		echo <<<IRCO
-!- NICK $nick\r\n
IRCO;
if($i == 1) {
	echo "Waiting 2 seconds before resending registration for good measure...\r\n";
	sleep(2);
}
	}
}
if($irc['identify']) {
	echo "Waiting 2 seconds before sending identification information to make sure we're registered...\r\n";
	sleep(2);
	fwrite($fp[$n], "PRIVMSG NickServ :IDENTIFY " . $irc['ns-username'] . $irc['ns-password'] . "\r\n");
	echo <<<IRCO
*** ID INFO SENT\r\n
IRCO;
	$irc['ns-username'] = NULL;
}
echo "Waiting 5 seconds to make sure we're all good to begin the sync process...\r\n";
sleep(5);
if($setAutoModes) {
	echo "Now setting usermode(s) +{$setAutoModes} on myself...\r\n";
	fwrite($fp[$n], "MODE {$nick} +{$setAutoModes}\r\n");
}
echo <<<CONSOLEOUTPUT
\n{$c_ul}Please enter a comma-delimited list of channels to join: 
CONSOLEOUTPUT;
if($autoconnect['enabled'] && $autoconnect['channels']) {
	$irc['channels'] = $autoconnect['channels'];
} elseif($autoconnect['enabled'] && !$autoconnect['channels']) {
	die("\r\n{$c_red}ERROR: Autoconnect is enabled, but no channels were specified in config file.{$c_n}\r\n");
} elseif(!$autoconnect['enabled']) {
	while(!$irc['channels']) {
		fscanf(STDIN, "%s", $irc['channels']);
	}
}
echo <<<CONSOLEOUTPUT
{$c_n}{$c_green}Input of "{$irc['channels']}" received!{$c_n}\n
Joining...\n
CONSOLEOUTPUT;
$uptime['start'] = time();
$irc['channels'] = explode(",", $irc['channels']);
foreach($irc['channels'] AS $channel) {
	fwrite($fp[$n], "JOIN $channel\r\n");
	echo <<<IRCO
-!- JOIN $channel\n
IRCO;
}
$ircc = $fp[$n];
$delimiter = "@";
/*foreach($irc['channels'] AS $channel) {
  fwrite($ircc, "PRIVMSG $channel :LizardBot is now online!! :DD\r\n");
}*/
echo <<<IRCO
*** Sent join messages\n
IRCO;
while(!feof($fp[$n])) {//While connected to IRC...
/* if(fscanf(STDIN, "%s", $irc['command']) == 1) {
//if($irc['command']) {
fwrite($ircc, "{$irc['command']}\r\n");
echo "{$irc['command']}\n";
echo <<<CONSOLEOUTPUT
Input of "{$irc['command']}" received!\n
CONSOLEOUTPUT;
} */
	$toRead = array($ircc, $ircc);
	$toWrite = NULL;
	$toExcept = NULL;
	$toTimeout = 15;
	if(stream_select($toRead, $toWrite, $toExcept, $toTimeout) || $setEnableDelays) {
		$data = str_replace(array("\n", "\r"), '', fgets($ircc, 1024));
		echo $data . "\n";
	} else {
		$data = NULL;
	}
	$data2 = str_replace(":", "", $data);
	$data3 = str_replace("$$", ":", $data2);
	$d = explode(' ', $data3);
	$c = $d[2];
	if(!$muted) {
		if($d[3] == "{$setTrigger}test"&& hasPriv('*')) {
			$cmdcount++;
			fwrite($ircc, "PRIVMSG $c :OLOL!\r\n");
			echo <<<IRCO
-!- PRIVMSG #lobby :OLOL!\n
IRCO;
		}
		if($d[3] == "{$setTrigger}die" && hasPriv('die')) {
			$cmdcount++; // 9_9
			if(true) {
				fwrite($ircc, "QUIT :Ordered to death by {$d[0]}!\r\n");
				echo <<<IRCO
{$c_red}-!- QUIT :Ordered to death!\n
*** DISCONNECTING FROM {$irc['address']}!\n
IRCO;
				fclose($ircc);
				die("Terminated!\n{$c_n}");
			} else {
//        fwrite($ircc, "NOTICE $c :*** WARNING: (PING FastLizard4) {$d[0]} ({$d[2]}) attempted to kill me!\r\n");
				echo <<<IRCO
*** @die access violation logged!\n
IRCO;
			}
		}
	if(hasPriv('say')) {
		if($d[3] == "{$setTrigger}say") {
			$cmdcount++;
			if($d[2] != $nick) {
				$ndata = explode(":{$setTrigger}say ", $data);
				$rdata = $ndata[1];
				fwrite($ircc, "PRIVMSG $c :$rdata\r\n");
				echo <<<IRCO
-!- PRIVMSG $c :$rdata\n
IRCO;
			} else {
				$kdata = explode(":{$setTrigger}say ", $data);
				$cdata = $kdata[1];
				$ndata = explode(" ", $cdata);
				$c = $ndata[0];
				$ndata[0] = NULL;
				$rdata = trim(implode(" ", $ndata));
				fwrite($ircc, "PRIVMSG $c :$rdata\r\n");
				echo <<<IRCO
-!- PRIVMSG $c :$rdata\n
IRCO;
			}
		}
	}
	if(hasPriv('do')) {
		if($d[3] == "{$setTrigger}do") {
			$cmdcount++;
			if($d[2] != $nick) {
				$ndata = explode(":{$setTrigger}do ", $data);
				$ddata = $ndata[1];
				$rdata = chr(001) . "ACTION $ddata" . chr(001);
				fwrite($ircc, "PRIVMSG $c :$rdata\r\n");
				echo <<<IRCO
-!- CTCP $c ACTION $rdata\n
IRCO;
			} else {
				$kdata = explode(":{$setTrigger}do ", $data);
				$cdata = $kdata[1];
				$ndata = explode(" ", $cdata);
				$c = $ndata[0];
				$ndata[0] = NULL;
				$ddata = implode(" ", $ndata);
				$me = trim($ddata);
				$rdata = trim(chr(001) . "ACTION $me" . chr(001));
				fwrite($ircc, "PRIVMSG $c :$rdata\r\n");
				echo <<<IRCO
-!- CTCP $c ACTION $rdata\n
IRCO;
			}
		}
	}
	if($d[3] == "{$setTrigger}join" && hasPriv('join')) {
		$cmdcount++;
		fwrite($ircc, "JOIN {$d[4]}\r\n");
		fwrite($ircc, "PRIVMSG {$d[4]} :{$d[0]} has ordered me to join the channel.\r\n");
		echo <<<IRCO
-!- JOIN {$d[4]}\n
IRCO;
	}
	if($d[3] == "{$setTrigger}part" && hasPriv('part')) {
		$cmdcount++;
		fwrite($ircc, "PART {$d[4]} :Ordered to death by {$d[0]}!\r\n");
		echo <<<IRCO
-!- PART {$d[4]}\n
IRCO;
	}
	if(hasPriv('notice')) {
		if($d[3] == "{$setTrigger}notice") {
			$cmdcount++;
			if($d[2] != $nick) {
				$ndata = explode(":{$setTrigger}notice ", $data);
				$rdata = $ndata[1];
				fwrite($ircc, "NOTICE $c :$rdata\r\n");
				echo <<<IRCO
-!- NOTICE $c :$rdata\n
IRCO;
			} else {
				$kdata = explode(":{$setTrigger}notice ", $data);
				$cdata = $kdata[1];
				$ndata = explode(" ", $cdata);
				$c = $ndata[0];
				$ndata[0] = NULL;
				$rdata = implode(" ", $ndata);
				fwrite($ircc, "NOTICE $c :$rdata\r\n");
				echo <<<IRCO
-!- NOTICE $c :$rdata\n
IRCO;
			}  
		}
	}
	if($d[3] == "{$setTrigger}raw" && hasPriv('raw')) {
		$cmdcount++;
		if(true) {
			$kdata = explode("{$setTrigger}raw ", $data);
			$rdata = $kdata[1];
			fwrite($ircc, "$rdata\r\n");
			echo <<<IRCO
-!- MANUAL RAW COMMAND ISSUED BY {$d[0]}: $rdata\n
IRCO;
		} else {
			fwrite($ircc, "PRIVMSG $c :Access denied.\r\n");
			echo <<<IRCO
PRIVMSG $c :Access denied.\r\n
IRCO;
		}
	}
	if($d[0] == 'PING') {
		$pingcount++;
		fwrite($ircc, "PONG {$d[1]}\r\n");
		echo <<<IRCO
PONG {$d[1]}\n
IRCO;
	}
	if($d[3] == "{$setTrigger}fap" && hasPriv('fap')) {
		$cmdcount++;
		if(!$d[4]) {
			$who = explode("!", $d[0]);
			$who2 = $who[0];
		} else {
			$who2 = $d[4];
		}
		fwrite($ircc, "PRIVMSG $c :Ceiling_Cat is watching $who2 masturbate\r\n");
		echo <<<IRCO
PRIVMSG $c :Ceiling_Cat is watching $who2 masturbate\n
IRCO;
	}
	if(hasPriv('op')) {
		if($d[3] == "{$setTrigger}kick") {
			$cmdcount++;
//$data1 = explode("{$setTrigger}kick ", $data);
			if($d[2] != $nick) {
				$kdata = explode(":{$setTrigger}kick ", $data);
				$cdata = $kdata[1];
				$ndata = explode(" ", $cdata);
				$target = $ndata[0];
				$ndata[0] = NULL;
				$comment = implode(" ", $ndata);
			} else {
				$kdata = explode(":{$setTrigger}kick ", $data);
				$cdata = $kdata[1];
				$ndata = explode(" ", $cdata);
				$c = $ndata[0];
				$target = $ndata[1];
				$ndata[0] = NULL;
				$ndata[1] = NULL;
				$comment = implode(" ", $ndata);
			}
			fwrite($ircc, "KICK $c $target :$comment\r\n");
			echo <<<IRCO
-!- KICK $c $target :$comment\n
IRCO;
		}
	}
	if($d[3] == "{$setTrigger}op" && hasPriv('op')) {
		$cmdcount++;
		fwrite($ircc, "PRIVMSG ChanServ :OP $c\r\n");
		echo <<<IRCO
PRIVMSG ChanServ :OP $c\n
IRCO;
	}
	if($d[3] == "{$setTrigger}deop" && hasPriv('op')) {
		$cmdcount++;
		fwrite($ircc, "MODE $c -o {$nick}\r\n");
		echo <<<IRCO
MODE $c -o LizardBot-1\n
IRCO;
	}
	if($d[3] == chr(001) . "VERSION" . chr(001)) {
		$ctcpcount++;
		$target = explode("!", $d[0]);
		$target = $target[0];
		$data = "NOTICE $target :";
		$data .= chr(001);
		$data .= "VERSION " . $setCTCPVersion;
		$data .= chr(001);
		$data .= "\r\n";
		fwrite($ircc, $data);
		echo <<<IRCO
-!- SENT CTCP VERSION REPLY TO $target\n
IRCO;
	}


	
	if($d[3] == chr(001) . "TIME" . chr(001)) {
		$ctcpcount++;
		$target = explode("!", $d[0]);
		$target = $target[0];
		$data = "NOTICE $target :";
		$data .= chr(001);
		$data .= "TIME " . date('r');
		$data .= chr(001);
		$data .= "\r\n";
		fwrite($ircc, $data);
		echo <<<IRCO
-!- SENT CTCP TIME REPLY TO $target\n
IRCO;
	}
	if($d[3] == chr(001) . "USERINFO" . chr(001)) {
		$ctcpcount++;
		$target = explode("!", $d[0]);
		$target = $target[0];
		$data = "NOTICE $target :";
		$data .= chr(001);
		$data .= "USERINFO " . $setCTCPUserinfo;
		$data .= chr(001);
		$data .= "\r\n";
		fwrite($ircc, $data);
		echo <<<IRCO
-!- SENT CTCP USERINFO REPLY TO $target\n
IRCO;
	}
	if($d[3] == chr(001) . "CLIENTINFO" . chr(001)) {
		$ctcpcount++;
		$target = explode("!", $d[0]);
		$target = $target[0];
		$data = "NOTICE $target :";
		$data .= chr(001);
		$data .= "CLIENTINFO CLIENTINFO FINGER TIME USERINFO VERSION";
		$data .= chr(001);
		$data .= "\r\n";
		fwrite($ircc, $data);
		echo <<<IRCO
-!- SENT CTCP CLIENTINFO REPLY TO $target\n
IRCO;
	}


	if($d[3] == chr(001) . "FINGER" . chr(001)) {
		$ctcpcount++;
		$target = explode("!",$d[0]);
		$target = $target[0];
		$data = "NOTICE $target :";
		$data .= chr(001);
		$data .= "FINGER ". $setCTCPVersion;
		$data .= chr(001);
		$data .= "\r\n";
		fwrite($ircc, $data);
		echo <<<IRCO
-!- SENT CTCP FINGER REPLY TO $target\n
IRCO;
	}
	if($d[3] == "{$setTrigger}rehash" && hasPriv('rehash')) {
		$cmdcount++;
		if($d[2] == $nick) {
			$kdata = explode($d[0], "!");
			$target = $kdata[0];
		} else {
			$target = $d[2];
		}
		fwrite($ircc, "PRIVMSG $target :Rehashing...\r\n");
		echo "PRIVMSG $target :Rehashing...\r\n";
		$rehash = true;
		require("default.conf.php");
		include($dir);
		if($setMySQLTablePre) {
			$setMySQLTablePre .= "_";
		}
		echo "Rehashed!\r\n";
		fwrite($ircc, "PRIVMSG $target :Rehashed config file.\r\n");
		echo "PRIVMSG $target :Rehashed config file.\r\n";
	}
	if($d[3] == "{$setTrigger}nick" && hasPriv('nick')) {
		$cmdcount++;
		$nick = $d[4];
		fwrite($ircc, "NICK $nick\r\n");
		echo "-!- NICK $nick\r\n";
	}

	if(($d[3] == "{$setTrigger}info" || $d[3] == "{$setTrigger}help") && hasPriv('*')) {
		$cmdcount++;
		$target = explode("!", $d[0]);
		$target2 = $target[0];
		if(!stristr($d[2], "#")) {
			$c = $target2[0];
		}
/*		fwrite($ircc, "PRIVMSG $c :$target2: Hello!  I am LizardBot-1, FastLizard4's PHP bot.  I am written 
in PHP 5 Procedural.  I work on both Windows and *Nix systems with PHP installed.  I am run from the command line.  These are the commands you can run (the trigger is {$setTrigger}):\r\n");
		sleep(2);
		fwrite($ircc, "PRIVMSG $c :$target2: test, join, part, do, op, deop, kick, fap, notice.  Restricted commands: <hidden>.\r\n");
		sleep(1);
		fwrite($ircc, "PRIVMSG $c :$target2: You have the access level of: " . showPriv() . "\r\n");
		sleep(1);
		fwrite($ircc, "PRIVMSG $c :$target2: Extensions: Pandorabot by Ttech (PHP-5-OOP)\r\n");
		sleep(2);*/
		fwrite($ircc, "PRIVMSG $c :$target2: For help and copyrights, see http://fastlizard4.org/wiki/LizardBot\r\n");
		echo "
-!- $target2 requested {$setTrigger}info\n
";
	}
	if(preg_match('/^[,.?!@#$%^&*-+_=|]+help$/', $d[3]) && $setEnableAllTriggerHelp && hasPriv('*') && $d[3] != "{$setTrigger}help") {
                $cmdcount++;
                $target = explode("!", $d[0]);
                $target2 = $target[0];
                if(!stristr($d[2], "#")) {
                        $c = $target2[0];
                }
		fwrite($ircc, "PRIVMSG $c :$target2: You have triggered my general help command by using a \"standard\" bot trigger that is not my normal trigger.  For your reference, my normal trigger (which you must use for triggering all my commands) is {$setTrigger}\r\n");
                fwrite($ircc, "PRIVMSG $c :$target2: For help and copyrights, see http://fastlizard4.org/wiki/LizardBot\r\n");
	}
	if($d[3] == "{$setTrigger}nyse" && hasPriv('nyse')) {
		$cmdcount++;
		$symbol = $d[4];
		$url = sprintf('http://quote.yahoo.com/d/quotes.csv?s=%s&f=nl1c6k2t1vp', urlencode($symbol));
		echo "-!- Getting quote for $symbol\r\n";
		$quoteurl = @fopen($url, 'r') OR $data = "Error connecting to Yahoo!";
		$read = fgetcsv($quoteurl);
		fclose($quoteurl);
		$colorend = "\003";
		if($read[2] >= 0) {
			$color = "\0033";
//			$read[2] = "+" . $read[2];
		} elseif($read[2] <= 0) {
			$color = "\0034";
		} elseif($read[2] == 0) {
			$color = NULL;
			$colorend = NULL;
		}
		$pcnt = explode(" ", $read[3]);
		if(strcasecmp($read[0], $symbol) != 0) {
			if(!$setNoBolds) {$bold = "\002";}
			$data = "The latest value for {$bold}'{$read[0]}'{$bold} (\0036$symbol\003) is " . chr(003) . "12" . "\$" . $read[1] . "\003 (delta:" . $color . " " . $read[2] . $colorend . " or" . $color . " " . $pcnt[2] . $colorend . " from last close of " . $read[6] . "; last trade at " . $read[4] . " eastern time; mkt volume: " . $read[5] . ") (Source: Yahoo!)";
		} else {
			$data = "Invalid symbol.";
		}
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "PRIVMSG $c :" . $e . $data . "\r\n";
	}
	if($d[3] == "{$setTrigger}fantasy" && hasPriv('*')) {
		$cmdcount++;
		if(!$setFantasy) {
			$data = "Fantasy is off.";
		} else {
			$data = "Fantasy is on.";
		}
                $target = explode("!", $d[0]);
                $e = $target[0] . ": ";
                if($d[2] == $nick) {
                        $target = explode("!", $d[0]);
                        $c = $target[0];
                        $e = NULL;
                } else {
                        $c = $d[2];
                }
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
	}
	if($d[3] == "{$setTrigger}fantasy-on" && hasPriv('mute')) {
		$cmdcount++;
		$setFantasy = TRUE;
		$ai = new pandorabot("838c59c76e36816b");
		if(!$setAIDefaultRE) { $setAIDefaultRE = "Probably"; }
		$ai->default_response = $setAIDefaultRE;
		$data = "Fantasy turned on!";
                $target = explode("!", $d[0]);
                $e = $target[0] . ": ";
                if($d[2] == $nick) {
                        $target = explode("!", $d[0]);
                        $c = $target[0];
                        $e = NULL;
                } else {
                        $c = $d[2];
                }
                fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
                echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
	}
        if($d[3] == "{$setTrigger}fantasy-off" && hasPriv('mute')) {
        	$cmdcount++;
                $setFantasy = FALSE;
		unset($ai);
                $data = "Fantasy turned off!";
                $target = explode("!", $d[0]);
                $e = $target[0] . ": ";
                if($d[2] == $nick) {
                        $target = explode("!", $d[0]);
                        $c = $target[0];
                        $e = NULL;
                } else {
                        $c = $d[2];
                }
                fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
                echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
        }
	if($setFantasy && hasPriv('fantasy')) {
		if(!$ai) {
			$ai = new pandorabot("838c59c76e36816b");
	                if(!$setAIDefaultRE) { $setAIDefaultRE = "Probably"; }
	                $ai->default_response = $setAIDefaultRE;
		}
//		$data-ai = explode(":", $data);
		$dataai = explode(" :", $data);
//		echo "dataai: " . $dataai[2] . "\r\n";
//		echo "dataai1: " . $dataai[1] . "\r\n";
		$nicksan = preg_quote($nick, '/');
		$regex = "/^";
		$regex .= $nicksan;
		$regex .= "(: |, | - ).*$/i";
		if(preg_match($regex, $dataai[1])) {
			$parseai = explode(" ", $dataai[1]);
//			echo "parseai: " . $parseai . "\r\n";
			$parseai[0] = null;
			$parsedata = implode(" ", $parseai);
//			echo "parsedata: " . $parsedata . "\r\n";
			$msg = $parsedata; // This is the message you get from IRC 
			$ai->set_timeout(180); // 60 should be fine
			$rofl = $ai->say($msg); // This is what you want to get back to the user. 
			$aicount++;
			if(!$rofl || preg_match('/^\s*$/', $rofl)) { $rofl = $ai->default_response; }
	                $target = explode("!", $d[0]);
        	        $e = $target[0] . ": ";
			sleep(2);
                	if($d[2] == $nick) {
                        	$target = explode("!", $d[0]);
	                        $c = $target[0];
        	                $e = NULL;
                	} else {
	                        $c = $d[2];
        	        }
	                fwrite($ircc, "PRIVMSG $c :" . $e . $rofl . "\r\n");
        	        echo "-!- PRIVMSG $c :" . $e . $rofl . "\r\n";
		}
	}
	if($d[3] == "{$setTrigger}exec" && hasPriv('exec') && $setEnableExec) {
		$cmdcount++;
		$tgc = $d[2];
		$tgf = $d[0];
		$d[0] = NULL;
		$d[1] = NULL;
		$d[2] = NULL;
		$d[3] = NULL;
                $target = explode("!", $tgf);
                $e = $target[0] . ": ";
		$data = implode(" ", $d);
//                $patterns = array("/\e*/");
//                $replacements = array(" ");
//                $sandata = preg_replace($patterns, $replacements, $data);
		unset($execresult);
		$result = exec($data, $execresult, $return);
		if($tgc == $nick) {
			$target = explode("!", $tgf);
                                $c = $target[0];
                                $e = NULL;
                        } else {
                                $c = $tgc;
                        }
		$returndata = implode(" ", $execresult);
		if($return == 127) { $return .= " (Command Unrecognized)"; }
		$output = "Output: " . $returndata . "; Return: " . $return;
		fwrite($ircc, "PRIVMSG $c :" . $e . $output . "\r\n");
                echo "-!- PRIVMSG $c :" . $e . $output . "\r\n";
	}
	if($d[3] == "{$setTrigger}tinyurl" && hasPriv('tinyurl')) {
		$cmdcount++;
		$ndata = explode(":{$setTrigger}tinyurl ", $data);
		$rdata = $ndata[1];
		$data = NULL;
		$tinyurl = trim($rdata);
//		$tinyurl = urlencode($tinyurl);
		if(!preg_match('#^(http|https)://.*$#i', $tinyurl)) {
			$data = "Invalid URL.";
		} else {
			$tinyfp = fopen("http://tinyurl.com/api-create.php?url={$tinyurl}","r") OR $data = "Error in connection to TinyURL API.";
			if(!$data) {
				$data   = fgets($tinyfp);
				fclose($tinyfp); //Remember to close all sockets!
			}
		}
		/* BEGIN DETERMINATION BLOCK */
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		} /* END DETERMINATION BLOCK */
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
	}
	if($d[3] == "{$setTrigger}eval" && hasPriv('eval') && $setEnableEval) {
		$cmdcount++;
                $tgc = $d[2];
                $tgf = $d[0];
                $d[0] = NULL;
                $d[1] = NULL;
                $d[2] = NULL;
                $d[3] = NULL;
                $target = explode("!", $tgf);
                $e = $target[0] . ": ";
                $data = implode(" ", $d);
//                $patterns = array("/\e*/");
//                $replacements = array(" ");
//                $sandata = preg_replace($patterns, $replacements, $data);
//                unset($execresult);
		if(!$setNoBolds) { $bold = "\002"; }
		try {
	                $result = eval($data);
		} catch(Exception $e) {
			$result = $bold . "ERROR: " . $bold . $e->__toString();
		}
                if($tgc == $nick) {
                        $target = explode("!", $tgf);
                                $c = $target[0];
                                $e = NULL;
                        } else {
                                $c = $tgc;
                        }
		$status = ($result) ? "true" : "false";
		$output = "Code returned: $result ($status)";
                fwrite($ircc, "PRIVMSG $c :" . $e . $output . "\r\n");
                echo "-!- PRIVMSG $c :" . $e . $output . "\r\n";
        }
	if($d[3] == "{$setTrigger}update" && hasPriv('*')) {
		$cmdcount++;
		echo "Checking for updates...\r\n";
		$version = "7.3.0.0b";
		$upfp = @fopen('http://fastlizard4.org/w/index.php?title=LizardBot/Latest&action=raw', 'r');
		$data = @fgets($upfp);
		@fclose($upfp);
                $target = explode("!", $d[0]);
                $e = $target[0] . ": ";
                if($d[2] == $nick) {
                        $target = explode("!", $d[0]);
                        $c = $target[0];
                        $e = NULL;
                } else {
                        $c = $d[2];
                }
		if(!$data) {
			$output = "Check for updates failed!";
		}
		if($data == $version) {
		        $output = "LizardBot is up-to-date";
		} else {
		        $output = "LizardBot version {$data} is available.  Please update, or get details at http://fastlizard4.org/wiki/LizardBot/CL#latest";
		}
                fwrite($ircc, "PRIVMSG $c :" . $e . $output . "\r\n");
                echo "-!- PRIVMSG $c :" . $e . $output . "\r\n";
	}
	if($d[3] == "{$setTrigger}wot" && hasPriv('*')) {
		$cmdcount++;
                $site = $d[4];
                $url = sprintf('http://api.mywot.com/0.4/public_link_json?hosts=%s/&callback=jsonp1225957266492&_=1225957271558', $site);
                echo "-!- Getting WoT ratings for {$site}\r\n";
                $woturl = @fopen($url, 'r') OR $data = "Error connecting to WoT API!";
                $jsonout = fgets($woturl);
                fclose($woturl);
		$first = $jsonout;
		$second = explode("(", $first);
		$third = explode(")", $second[1]);
		$json = $third[0];
//		echo $json . "\r\n";
/*                $patterns = array("[", "]");
                $replacements = array("{", "}");
                $jsono = str_replace($patterns, $replacements, $json);
                $patterns = " ";
                $replacements = "";
                $jsonin = str_replace($patterns, $replacements, $jsono);
		echo $jsonin . "\r\n";*/
		$array2 = json_decode($json, TRUE);
/*		foreach($array2 AS $key => $value) {
			if(!is_scalar($value)) {
				foreach($value AS $vkey => $vval) {
					if(!is_scalar($vval)) {
						foreach($vval AS $vvkey => $vvval) {
							
							$vval = "<<<ARRAY>>>";
						}
					}
					echo <<<STDOUT
\t([{$vkey}] => {$vval})\r\n
STDOUT;
					$value = "<<<ARRAY>>>";
				}
			}
			echo <<<STDOUT
[{$key}] => {$value}\r\n
STDOUT;
		}*/
                if($d[2] == $nick) {
                        $target = explode("!", $d[0]);
                        $c = $target[0];
                        $e = NULL;
                } else {
                        $c = $d[2];
			$target = explode("!", $d[0]);
			$e = $target[0] . ":";
                }
		if(!$setNoBolds) {
			$bold = "\002";
		} else {
			$bold = NULL;
		}
//		$wotarray = $array2[$site];
		$wot = array();
/*		foreach($wotarray[0] AS $key => $value) {
	                $patterns = array("\r\n", "\r", "\n");
	                $replacements = "";
	                $wotarray[0][$key] = str_replace($patterns, $replacements, $value);
		}
                foreach($wotarray[1] AS $key => $value) {
                        $patterns = array("\r\n", "\r", "\n");
                        $replacements = "";
                        $wotarray[1][$key] = str_replace($patterns, $replacements, $value);
                }
                foreach($wotarray[2] AS $key => $value) {
                        $patterns = array("\r\n", "\r", "\n");
                        $replacements = "";
                        $wotarray[2][$key] = str_replace($patterns, $replacements, $value);
                }
                foreach($wotarray[4] AS $key => $value) {
                        $patterns = array("\r\n", "\r", "\n");
                        $replacements = "";
                        $wotarray[4][$key] = str_replace($patterns, $replacements, $value);
                }*/
		$wot['trustworthiness']['rating'] = trim($array2[$site][0][0]);
		$wot['trustworthiness']['reliable'] = trim($array2[$site][0][1]);
		$wot['vendor reliability']['rating'] = trim($array2[$site][1][0]);
		$wot['vendor reliability']['reliable'] = trim($array2[$site][1][1]);
//		echo $array2[$site][1][1] . "\r\n";
//		echo $wot['vendor reliability']['reliable'] . "\r\n";
//		echo $wot['vendor reliability']['reliable'] . "\r\n";
		$wot['privacy']['rating'] = trim($array2[$site][2][0]);
		$wot['privacy']['reliable'] = trim($array2[$site][2][1]);
		$wot['child safety']['rating'] = trim($array2[$site][4][0]);
		$wot['child safety']['reliable'] = trim($array2[$site][4][1]);
		if($wot['trustworthiness']['rating'] >= 80) {
			$color[0] = "\0033";
		} elseif($wot['trustworthiness']['rating'] >= 60 && $wot['trustworthiness']['rating'] < 79) {
			$color[0] = "\0039";
		} elseif($wot['trustworthiness']['rating'] >= 40 && $wot['trustworthiness']['rating'] < 59) {
			$color[0] = "\0038";
		} elseif($wot['trustworthiness']['rating'] >= 20 && $wot['trustworthiness']['rating'] < 39) {
			$color[0] = "\0037";
		} elseif($wot['trustworthiness']['rating'] >= 0 && $wot['trustworthiness']['rating'] < 19) {
			$color[0] = "\0034";
		} else { $color[0] = "\0034"; $wot['trustworthiness']['rating'] = "NO DATA"; }
                if($wot['vendor reliability']['rating'] >= 80) {
                        $color[1] = "\0033";
                } elseif($wot['vendor reliability']['rating'] >= 60 && $wot['vendor reliability']['rating'] < 79) {
                        $color[1] = "\0039";
                } elseif($wot['vendor reliability']['rating'] >= 40 && $wot['vendor reliability']['rating'] < 59) {
                        $color[1] = "\0038";
                } elseif($wot['vendor reliability']['rating'] >= 20 && $wot['vendor reliability']['rating'] < 39) {
                        $color[1] = "\0037";
                } elseif($wot['vendor reliability']['rating'] >= 0 && $wot['vendor reliability']['rating'] < 19) {
                        $color[1] = "\0034";
                } else { $color[1] = "\0034"; $wot['vendor reliability']['rating'] = "NO DATA"; }
                if($wot['privacy']['rating'] >= 80) {
                        $color[2] = "\0033";
                } elseif($wot['privacy']['rating'] >= 60 && $wot['privacy']['rating'] < 79) {
                        $color[2] = "\0039";
                } elseif($wot['privacy']['rating'] >= 40 && $wot['privacy']['rating'] < 59) {
                        $color[2] = "\0038";
                } elseif($wot['privacy']['rating'] >= 20 && $wot['privacy']['rating'] < 39) {
                        $color[2] = "\0037";
                } elseif($wot['privacy']['rating'] >= 0 && $wot['privacy']['rating'] < 19) {
                        $color[2] = "\0034";
                } else { $color[2] = "\0034"; $wot['privacy']['rating'] = "NO DATA"; }
                if($wot['child safety']['rating'] >= 80) {
                        $color[4] = "\0033";
                } elseif($wot['child safety']['rating'] >= 60 && $wot['child safety']['rating'] < 79) {
                        $color[4] = "\0039";
                } elseif($wot['child safety']['rating'] >= 40 && $wot['child safety']['rating'] < 59) {
                        $color[4] = "\0038";
                } elseif($wot['child safety']['rating'] >= 20 && $wot['child safety']['rating'] < 39) {
                        $color[4] = "\0037";
                } elseif($wot['child safety']['rating'] >= 0 && $wot['child safety']['rating'] < 19) {
                        $color[4] = "\0034";
                } else { $color[4] = "\0034"; $wot['child safety']['rating'] = "NO DATA"; }
		$toirc = "The WoT rating for {$site} is: Trust: {$bold}{$color[0]}<\003{$bold} {$wot['trustworthiness']['rating']}, {$wot['trustworthiness']['reliable']} {$bold}{$color[0]}>\003{$bold}; Reliability: {$bold}{$color[1]}<\003{$bold} {$wot['vendor reliability']['rating']}, {$wot['vendor reliability']['reliable']} {$bold}{$color[1]}>\003{$bold}; Privacy: {$bold}{$color[2]}<\003{$bold} {$wot['privacy']['rating']}, {$wot['privacy']['reliable']} {$bold}{$color[2]}>\003{$bold}; Child Safety: {$bold}{$color[4]}<\003{$bold} {$wot['child safety']['rating']}, {$wot['child safety']['reliable']} {$bold}{$color[4]}>\003{$bold} (http://www.mywot.com/en/scorecard/{$site})";
                $patterns = array("\r\n", "\r", "\n");
                $replacements = "";
                $outtoirc = str_replace($patterns, $replacements, $toirc);
                fwrite($ircc, "PRIVMSG $c :" . $e . $outtoirc . "\r\n");
                echo "-!- PRIVMSG $c :" . $e . $outtoirc . "\r\n";
		unset($color);
	}
	if($d[3] == "{$setTrigger}gcalc" && hasPriv('*') && $setTrustGoogle) {
		$cmdcount++;
		/*
		* VARIABLES
		*   $toGoogle: Data to be sent to Google
		*     $google: Fp for Google
		*  $googleURL: The URL we should connect to
		*       $data: Data to be returned to IRC
		* $googleOutn: Data from Google
		*      $tnick: Target nick
		*         $tt: Placeholder
		*/
		$stopExecution = FALSE;
		$tt = $d[0];
		$d[0] = NULL;
		$d[1] = NULL;
		$tnick = $d[2];
		$d[2] = NULL;
		$d[3] = NULL;
		$toGoogle = implode(" ", $d);
		$googleURL = 'http://www.google.com/search?q=' . urlencode($toGoogle);
		$googleOut = NULL;
		$google = @fopen($googleURL, 'r') OR $data = "Error connecting to Google!  Oh noes!";
		while(!feof($google)) {
			if(!$googleOut) {
				$googleOut = fgets($google);
			} else {
				$googleOut .= fgets($google);
			}
		}
		fclose($google);
		unset($google);
		if(!stristr($googleOut, '<img src="/images/icons/onebox/calculator-40.gif" width=40 height=40 alt="">')) {
			$data = "Error: An invalid calculation was specified.";
			$stopExecution = TRUE;
		}
		if(!$stopExecution) {
			//Note: The following code comes from http://www.hawkee.com/snippet/5812/ and is modified to work here
	                $f = array("Â", "<font size=-2> </font>", " &#215; 10", "<sup>", "</sup>");$t = array("", "", "e", "^", "");
	                preg_match('/<h2 class=r style="font-size:138%"><b>(.*?)<\/b><\/h2>/', $googleOut, $matches);
	                if (!$matches['1']){
	                        $data = 'Your input could not be processed..';
	                } else {
	                        $data = str_replace($f, $t, $matches['1']);
	                }
		}
		unset($googleOut);
		unset($toGoogle);
		unset($googleURL);
		$target = explode("!", $tt);
		$e = $target[0] . ": ";
		if($tnick == $nick) {
			$target = explode("!", $tt);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $tnick;
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
		unset($c);
		unset($e);
		unset($data);
		unset($tt);
		unset($tnick);
		unset($stopExecution);
	}
/*	if($d[3] == "{$setTrigger}editcount" && hasPriv('*')) {
		$cmdcount++;
		$error = FALSE;
		/************************
		 Editcount function
		 *Determines a user's editcount on various Wikimedia wikis
		 *May be upgraded in the future to use non-wikimedia wikis
		 *Variables used:
		 **
		 **********************/
/*		$editcount['user'] = $d[4];
		$editcount['wiki'] = $d[6];
		$editcount['lang'] = $d[5];
		if(!$editcount['wiki']) { $editcount['wiki'] = "wikipedia"; }
		if(!$editcount['lang']) { $editcount['lang'] = "en"; }
		if(!$editcount['user']) {
			$error = TRUE;
			$data = "Error: No username was specified.  Please specify one.";
		} else {
			$editcount['user'] = urlencode($editcount['user']);
			$editcount['lang'] = urlencode($editcount['lang']);
			$editcount['wiki'] = urlencode($editcount['wiki']);
		}
		if(!$error) {
			$soxtoolURL = "http://toolserver.org/~soxred93/count/index.php?name={$editcount['user']}&lang={$editcount['lang']}&wiki={$editcount['wiki']}";
			$data = NULL;
			$soxtoolOut = NULL;
			$soxtool = @fopen($soxtoolURL, 'r') OR $data = "Error connecting to SoxRed's editcounter!  Oh noes!";
			$i = 0;
			while(!feof($soxtool) && $i <= 50) {
				if(!$soxtoolOut) {
					$soxtoolOut = fgets($soxtool);
				} else {
					$soxtoolOut .= fgets($soxtool);
				}
				$i++;
			}
			$editcount['live'] = explode("<b>Live edits: ", $soxtoolOut);
			$editcount['live']['parsed'] = explode("</b><br />", $editcount['live'][1]);
			$editcount['userrights'] = explode("User groups: ", $soxtoolOut);
			$editcount['userrights']['parsed'] = explode("<br />", $editcount['userrights'][1]);
			$editcount['first edit'] = explode("First edit: ", $soxtoolOut);
			$editcount['first edit']['parsed'] = explode("<br />", $editcount['first edit'][1]);
			$editcount['deleted'] = explode("Deleted edits: ", $soxtoolOut);
			$editcount['deleted']['parsed'] = explode("<br />", $editcount['deleted'][1]);
			$editcount['total'] = explode("Total edits (including deleted): ", $soxtoolOut);
			$editcount['total']['parsed'] = explode("<br />", $editcount['total'][1]);
			if($setNoBolds) {
				$bold = NULL;
			} else {
				$bold = "\002";
			}
			$data .= "\0032Contribs: http://{$editcount['lang']}.{$editcount['wiki']}.org/wiki/Special:Contributions/{$editcount['user']}\003 - ";
			$data .= "\0037Userrights: {$editcount['userrights']['parsed'][0]}\003 - \0036First edit: {$editcount['first edit']['parsed'][0]}\003 - {$bold}\00312Total edits: {$editcount['total']['parsed'][0]} \003(\0034Deleted: {$editcount['deleted']['parsed'][0]}\003 - \0033Live: {$editcount['live']['parsed'][0]}\003){$bold} - \00310{$soxtoolURL}\003";
		}
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
		unset($error, $editcount, $data, $soxtoolURL, $soxtool, $soxtoolOut, $c, $e, $target);
	} */
	if($d[3] == "{$setTrigger}insult" && hasPriv('insult') && $setInsultUsers) {
		$insultcount++;
		$cmdcount++;
		$error = NULL;
		$insult = @fopen("http://www.pangloss.com/seidel/Shaker/index.html", 'r') OR $error = "Unable to connect to internet.  Is it broken by Conficker?";
		$insultOut = NULL;
		if($error) {
			$data = $error;
		} else {
			while(!feof($insult)) {
				if(!$insultOut) {
					$insultOut = fgets($insult);
				} else {
					$insultOut .= fgets($insult);
				}
			}
			$parsed = array();
			$parsed[0] = explode("<font size=\"+2\">", $insultOut);
			$parsed[1] = explode("</font>", $parsed[0][1]);
			$result = strip_tags($parsed[1][0]);
			$data = trim($result);
		}
		$target = explode("!", $d[0]);
		if($d[4] && strcasecmp($d[4], $nick)) {
			$e = $d[4] . ": ";
		} else {
			if(!strcasecmp($d[4], $nick)) {
				$e = $target[0] . ": I refuse to insult myself, so I will now insult you.  ";
			} else {
				$e = $target[0] . ": ";
			}
		}
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
		fclose($insult);
	}
	if($d[3] == "{$setTrigger}status" && hasPriv('*')) {
		$cmdcount++;
		$totalcount = $cmdcount + $pingcount + $ctcpcount + $aicount + $fishcount;
		$uptime['days'] = (time() - $uptime['start'])/86400;
		$uptime['days'] = floor($uptime['days']);
		$uptime['current'] = gmdate('H:i:s', time() - $uptime['start']);
		$uptime['current'] = $uptime['days'] . ' days, ' . $uptime['current'];
		$php_os = PHP_OS;
		$data = "I am bot {$nick}. Software: LizardBot for PHP v{$version} (http://fastlizard4.org/wiki/LizardBot) on OS {$php_os}; Uptime: {$uptime['current']}; I have been used a total of {$totalcount} times (Commands: {$cmdcount} [Of which, {$insultcount} were insult commands], Server pings: {$pingcount}, Recognized CTCPs: {$ctcpcount}, AI calls: {$aicount}, Fishbot calls: {$fishcount}).";
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
	}
	if($d[3] == "{$setTrigger}untiny" && hasPriv('tinyurl')) {
		$cmdcount++;
		$tinynumber = $d[4];
		$url = "http://tinyurl.com/preview.php?num={$tinynumber}";
		$tinyurl = @fopen($url, 'r') OR $error = "Unable to connect to TinyURL to make the URL longer.  Perhaps the Internet needs help in maing the URL longer; give it some Viagra.";
		$tinyOut = NULL;
		if($error) {
			$data = $error;
		} else {
			while(!feof($tinyurl)) {
				if(!$tinyOut) {
					$tinyOut = fgets($tinyurl);
				} else {
					$tinyOut .= fgets($tinyurl);
				}
			}
			$parsed = array();
			$parsed[0] = explode("<blockquote>", $tinyOut);
			$parsed[1] = explode("</blockquote>", $parsed[0][1]);
			$result = strip_tags($parsed[1][0]);
			$data = trim($result);
			if(!$data) {
				$data = "Error in the input you gave me.  Remember that the only parameter this command needs is the NUMBER after http://tinyurl.com/, not the entire TinyURL.  Verify that the provided TinyURL ID is valid, and that you even provided an input.";
			}
		}
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
		fclose($tinyurl);
	}
	if($d[3] == "{$setTrigger}bit.ly" && hasPriv('bit.ly') && $setEnableBitly && $setBitlyLogin && $setBitlyAPIKey) {
		/* Right then.  Here lies the code that allows bit.ly (another URL shortener
		** interaction.  I'm going to try to actually document the code, since it will
		** be unusually complex.  It will use cURL and bit.ly's API, version 3.  So, if you're
		** ready for your brain to be exploded, read on!
		*/
		// First thing is that the bit.ly API is rate limited.  So, we'll prevent the bot from 
		// making an API request too often by noting the time of each request.  This will be
		// user configurable.
		$bitlyThisRequestTime = time();
		if($bitlyThisRequestTime - $bitlyLastRequestTime < $setBitlyAPISleep) { //We've exceeded the bot-based ratelimit, so abort.
			$data = "Rate limit exceeded.  Please wait a few seconds, or contact the bot's operator to get the limit raised.";
		} else { // Ratelimit OK, proceed
			$bitlyLastRequestTime = $bitlyThisRequestTime;
			// Many of the cURL options (i.e., curl_setopt()) are going to be common across all possible API queries, so we're
			// going to go ahead and start "building" the query
			$apiPipe = curl_init();
			$apiPipeSetoptSuccess = curl_setopt_array($apiPipe, array( // Begin setting cURL Options
				CURLOPT_AUTOREFERER    => TRUE          ,
				CURLOPT_VERBOSE        => TRUE          , // So, if necessary, bot operators can read debugging stuff from STDERR
				CURLOPT_CONNECTTIMEOUT => 20            , // 20 seconds for a timeout seems reasonable enough.  Lower might be better, though
				CURLOPT_PORT           => 80            ,
//				CURLOPT_PROTOCOLS      => CURLPROTO_HTTP,
				CURLOPT_TIMEOUT        => 30            , // 30 seconds is the maximum amount of time we want to wait for this to work
				CURLOPT_RETURNTRANSFER => TRUE          , // I would like my data back, kthx
				CURLOPT_USERAGENT      => "LizardBot-PHP/7.3.0.0b (compatible; +http://fastlizard4.org/wiki/LizardBot)" //Set our useragent
				));
			if(!$apiPipeSetoptSuccess) { // Uhoh, it looks like that, for some reason, configuration of the pipe failed.
				$data = "For some reason, curl_setopt_array() configuration failed.  Perhaps you're running an obsolete version of PHP-cURL?  Or perhaps your version of PHP is outdated?";
			} else { // Configuration worked, so we're free to continue.
				// First, we set the URL base for all API queries.
				$apiPipeURLBase = 'http://api.bit.ly/v3/';
				// Now, we need to figure out what query we need to run.
				if($d[4] == "shorten") { // User wants to shorten a link
					if(!$d[5]) {
						$data = "A required parameter, the URL to shorten, was not provided.  Syntax: @bit.ly shorten URLtoShorten";
					} else {
						$apiPipeRequestURL = $apiPipeURLBase . "shorten?format=json&domain=bit.ly&login={$setBitlyLogin}&apiKey={$setBitlyAPIKey}&";
						// Now we need to handle the long URL that needs to be shortened.  It must be URL encoded.
						$apiPipeRequestLongUrlE = explode('shorten', $data);
						$apiPipeRequestLongUrl = rawurlencode(trim($apiPipeRequestLongUrlE[1]));
						$apiPipeRequestURL .= "longUrl={$apiPipeRequestLongUrl}";
						curl_setopt($apiPipe, CURLOPT_URL, $apiPipeRequestURL); //Set the URL to be exec'd
						$apiPipeReturn = curl_exec($apiPipe); // GO!
						$apiPipeOut = json_decode($apiPipeReturn, TRUE); // So we can like do stuff with the data we get back
						if($apiPipeOut['status_code'] != 200) { // Whoops, we can has problem
							$data = "Hmm, something went wrong when I tried to shorten your URL.  Here's what I got back from the API: ERROR {$apiPipeOut['status_code']}: {$apiPipeOut['status_txt']}.";
						} else { // Looks like everything ran correctly, so proceed
							if($apiPipeOut['data']['new_hash']) {
								$newHash = "Yes.";
							} else {
								$newHash = "No.";
							}
						$data = "Shortened URL: {$apiPipeOut['data']['url']} - Is this the first time the long URL you entered was shortened? {$newHash}";
						}
					}
				} elseif($d[4] == "expand") { // User wants to expand
					if(!$d[5]) {
						$data = "A required parameter, the (full) URL to expand, was not found.  Syntax: @bit.ly expand bit.lyURL";
					} else {
						//This is pretty much a reuse of the shorten code
						$apiPipeRequestURL = $apiPipeURLBase . "expand?format=json&login={$setBitlyLogin}&apiKey={$setBitlyAPIKey}&";
						$apiPipeRequestLongUrlE = explode('expand', $data);
						$apiPipeRequestLongUrl = rawurlencode(trim($apiPipeRequestLongUrlE[1]));
						$apiPipeRequestURL .= "shortUrl={$apiPipeRequestLongUrl}";
						curl_setopt($apiPipe, CURLOPT_URL, $apiPipeRequestURL); //Set the URL to be exec'd
						$apiPipeReturn = curl_exec($apiPipe); // GO!
						$apiPipeOut = json_decode($apiPipeReturn, TRUE); // So we can like do stuff with the data we get back
						if($apiPipeOut['status_code'] != 200) { // Whoops, we can has problem
							$data = "Hmm, something went wrong when I tried to expand your bit.ly URL.  Here's what I got back from the API: ERROR {$apiPipeOut['status_code']}: {$apiPipeOut['status_txt']}.";
						} else { // Looks like everything ran correctly, so proceed
							if($apiPipeOut['data']['expand'][0]['error']) {
								$data = "The API returned an error for your short URL.  Here it is: {$apiPipeOut['data']['expand'][0]['error']}.";
							} else {
								$data = "For the short URL {$apiPipeOut['data']['expand'][0]['short_url']}, the corresponding long URL is: {$apiPipeOut['data']['expand'][0]['long_url']}";
							}
						}
					}
				} elseif($d[4] == "clicks") { // User wants to get clicks for an already existing URL
					if(!$d[5]) {
						$data = "A required parameter, the bit.ly URL to get click data for, was not found.  Syntax: @bit.ly clicks bit.lyURL";
					} else {
						//This is pretty much a reuse of the expand code
						$apiPipeRequestURL = $apiPipeURLBase . "clicks?format=json&login={$setBitlyLogin}&apiKey={$setBitlyAPIKey}&";
						$apiPipeRequestLongUrlE = explode('clicks', $data);
						$apiPipeRequestLongUrl = rawurlencode(trim($apiPipeRequestLongUrlE[1]));
						$apiPipeRequestURL .= "shortUrl={$apiPipeRequestLongUrl}";
						curl_setopt($apiPipe, CURLOPT_URL, $apiPipeRequestURL); //Set the URL to be exec'd
						$apiPipeReturn = curl_exec($apiPipe); // GO!
						$apiPipeOut = json_decode($apiPipeReturn, TRUE); // So we can like do stuff with the data we get back
						if($apiPipeOut['status_code'] != 200) { // Whoops, we can has problem
							$data = "Hmm, something went wrong when I tried to expand your bit.ly URL.  Here's what I got back from the API: ERROR {$apiPipeOut['status_code']}: {$apiPipeOut['status_txt']}.";
						} else { // Looks like everything ran correctly, so proceed
							if($apiPipeOut['data']['clicks'][0]['error']) {
								$data = "The API returned an error for your short URL.  Here it is: {$apiPipeOut['data']['clicks'][0]['error']}.";
							} else {
								if($apiPipeOut['data']['clicks'][0]['global_clicks'] == $apiPipeOut['data']['clicks'][0]['user_clicks'] &&  $apiPipeOut['data']['clicks'][0]['user_clicks'] != 0) {
									$data = "For the short URL {$apiPipeOut['data']['clicks'][0]['short_url']}, which is an \"aggregate\" or \"global\" bit.ly URL, there have been {$apiPipeOut['data']['clicks'][0]['global_clicks']} clicks.";
								} else {
									$data = "For the short URL {$apiPipeOut['data']['clicks'][0]['short_url']}, the number of clicks is {$apiPipeOut['data']['clicks'][0]['user_clicks']} and the number of global clicks on the aggregate (global) bit.ly URL is {$apiPipeOut['data']['clicks'][0]['global_clicks']}.";
								}
							}
						}
					}
				} elseif($d[4] == "checkpro") { // User wants to see if a domain is a bit.ly pro domain
					if(!$d[5]) {
						$data = "A required parameter, the domain to check, was not found.  Syntax: @bit.ly checkpro domainToCheck";
					} else {
						//This is pretty much a reuse of the expand code
						$apiPipeRequestURL = $apiPipeURLBase . "bitly_pro_domain?format=json&login={$setBitlyLogin}&apiKey={$setBitlyAPIKey}&";
						$apiPipeRequestLongUrlE = explode('checkpro', $data);
						$apiPipeRequestLongUrl = rawurlencode(trim($apiPipeRequestLongUrlE[1]));
						$apiPipeRequestURL .= "domain={$apiPipeRequestLongUrl}";
						curl_setopt($apiPipe, CURLOPT_URL, $apiPipeRequestURL); //Set the URL to be exec'd
						$apiPipeReturn = curl_exec($apiPipe); // GO!
						$apiPipeOut = json_decode($apiPipeReturn, TRUE); // So we can like do stuff with the data we get back
						if($apiPipeOut['status_code'] != 200) { // Whoops, we can has problem
							$data = "Hmm, something went wrong when I tried to expand your bit.ly URL.  Here's what I got back from the API: ERROR {$apiPipeOut['status_code']}: {$apiPipeOut['status_txt']}.";
						} else { // Looks like everything ran correctly, so proceed
							if($apiPipeOut['data']['bitly_pro_domain']) {
								$data = "The domain you entered, {$apiPipeOut['data']['domain']}, IS a bitly pro domain.";
							} else {
								$data = "The domain you entered, {$apiPipeOut['data']['domain']}, IS NOT a bitly pro domain.";
							}
						}
					}
				} elseif($d[4] == "lookup") { // User wants to lookup an already existing bit.ly link for a long URL
					if(!$d[5]) {
						$data = "A required parameter, the long URL to check, was not found.  Syntax: @bit.ly lookup longURL";
					} else {
						//This is pretty much a reuse of the expand code
						$apiPipeRequestURL = $apiPipeURLBase . "lookup?format=json&login={$setBitlyLogin}&apiKey={$setBitlyAPIKey}&";
						$apiPipeRequestLongUrlE = explode('lookup', $data);
						$apiPipeRequestLongUrl = rawurlencode(trim($apiPipeRequestLongUrlE[1]));
						$apiPipeRequestURL .= "url={$apiPipeRequestLongUrl}";
						curl_setopt($apiPipe, CURLOPT_URL, $apiPipeRequestURL); //Set the URL to be exec'd
						$apiPipeReturn = curl_exec($apiPipe); // GO!
						$apiPipeOut = json_decode($apiPipeReturn, TRUE); // So we can like do stuff with the data we get back
						if($apiPipeOut['status_code'] != 200) { // Whoops, we can has problem
							$data = "Hmm, something went wrong when I tried to expand your bit.ly URL.  Here's what I got back from the API: ERROR {$apiPipeOut['status_code']}: {$apiPipeOut['status_txt']}.";
						} else { // Looks like everything ran correctly, so proceed
							if($apiPipeOut['data']['lookup'][0]['error']) {
								$data = "The API returned an error for your long URL.  Here it is: {$apiPipeOut['data']['lookup'][0]['error']}.  If this is NOT_FOUND, it means that no bit.ly URL yet exists for the long URL you entered.";
							} else {
								$data = "For the long URL {$apiPipeOut['data']['lookup'][0]['url']}, the following bit.ly short URL already exists: {$apiPipeOut['data']['lookup'][0]['short_url']}";
							}
						}
					}
				} elseif($d[4] == "info") { // User wants to get info
					if(!$d[5]) {
						$data = "A required parameter, the bit.ly URL to get info for, was not found.  Syntax: @bit.ly info bit.lyURL";
					} else {
						//This is pretty much a reuse of the shorten code
						$apiPipeRequestURL = $apiPipeURLBase . "info?format=json&login={$setBitlyLogin}&apiKey={$setBitlyAPIKey}&";
						$apiPipeRequestLongUrlE = explode('info', $data);
						$apiPipeRequestLongUrl = rawurlencode(trim($apiPipeRequestLongUrlE[1]));
						$apiPipeRequestURL .= "shortUrl={$apiPipeRequestLongUrl}";
						curl_setopt($apiPipe, CURLOPT_URL, $apiPipeRequestURL); //Set the URL to be exec'd
						$apiPipeReturn = curl_exec($apiPipe); // GO!
						$apiPipeOut = json_decode($apiPipeReturn, TRUE); // So we can like do stuff with the data we get back
						if($apiPipeOut['status_code'] != 200) { // Whoops, we can has problem
							$data = "Hmm, something went wrong when I tried to expand your bit.ly URL.  Here's what I got back from the API: ERROR {$apiPipeOut['status_code']}: {$apiPipeOut['status_txt']}.";
						} else { // Looks like everything ran correctly, so proceed
							if($apiPipeOut['data']['info'][0]['error']) {
								$data = "The API returned an error for your short URL.  Here it is: {$apiPipeOut['data']['info'][0]['error']}.";
							} else {
								if($apiPipeOut['data']['info'][0]['created_by'] == "bitly") {
									$data = "For the short URL {$apiPipeOut['data']['info'][0]['short_url']}, the page title is: \"{$apiPipeOut['data']['info'][0]['title']}\".  The bit.ly URL is an aggregate URL.";
								} else {
									$data = "For the short URL {$apiPipeOut['data']['info'][0]['short_url']}, the page title is: \"{$apiPipeOut['data']['info'][0]['title']}\" and the bit.ly URL was created by the bit.ly user \"{$apiPipeOut['data']['info'][0]['created_by']}\".";
								}
							}
						}
					}
				} else {
					$data = "A required parameter, the action, was not provided.  Syntax: @bit.ly action [otherArguments]";
				}
			}
		}
		curl_close($apiPipe); //End the cURL session
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
	}
	if($d[3] == "{$setTrigger}fish" && hasPriv('*')) {
		$cmdcount++;
		if($setEnableFishbot) {
			$data = "Fishb0t module is enabled.";
		} else {
			$data = "Fishb0t module is disabled.";
		}
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
	}
	if($d[3] == "{$setTrigger}fish-on" && hasPriv('mute')) {
		$setEnableFishbot = TRUE;
		$data = "Fishb0t enabled!";
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
	}
	if($d[3] == "{$setTrigger}fish-off" && hasPriv('mute')) {
		$setEnableFishbot = FALSE;
		$data = "Fishb0t disabled!";
		$target = explode("!", $d[0]);
		$e = $target[0] . ": ";
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
		echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
	}
	if($setEnableReminders && $setEnableMySQL) {
		if(!is_array($reminder)) { //Build the array from database
			$reminder = array();
			$query = "SELECT `reminder_id`, `reminder_target_nick` FROM `{$setMySQLTablePre}reminders` ORDER BY `reminder_id` ASC";
			$mysql = dbConnect();
			$r = dbQuery($mysql, $query, $result);
			if($r) {
				$setEnableReminders = false; //This is a sorta permament error
			} else {
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					$reminder[$row['reminder_id']] = $row['reminder_target_nick'];
				}
				mysqli_free_result($result);
			}
			mysqli_close($mysql);
		}
		//Code to allow adding reminders:
		if($d[3] == "{$setTrigger}remind" && hasPriv('remind')) {
			$reminderReminder = $d[0];
	                $target = explode("!", $d[0]);
	                $e = $target[0] . ": ";
	                if($d[2] == $nick) {
	                        $target = explode("!", $d[0]);
	                        $c = $target[0];
	                        $e = NULL;
	                } else {
	                        $c = $d[2];
	                }
			if(!$d[5]) {
				$data = "ERROR: Too few parameters for the @remind command.  Syntax: @remind <target> <message>";
			} else {
				$reminderTarget = $d[4];
				$reminderText = explode("{$setTrigger}remind {$d[4]}", $data);
				$reminderText = trim($reminderText[1]);
				$reminderTime = gmdate("Y-m-d H:i:s");
				$d[0] = NULL; //Clear this so that the bot doesn't instantly remind the requester if the reminder is a self-reminder
				//Ok, we have all the variables we need, so sanitize input and build the query:
				$mysql = dbConnect();
				if(!$mysql) { $data = "Eror connecting to MySQL."; }
				$reminderTarget = mkSane($mysql, $reminderTarget);
				$reminderReminder = mkSane($mysql, $reminderReminder);
				$reminderText = mkSane($mysql, $reminderText);
				$reminderTime = mkSane($mysql, $reminderTime);
				//Get the definitions set up
				$query = "INSERT INTO `{$setMySQLTablePre}reminders` (`reminder_text`, `reminder_target_nick`, `reminder_time`, `reminder_requester`) VALUES ('{$reminderText}', '{$reminderTarget}', 	'{$reminderTime}', '{$reminderReminder}')";
				if(dbQuery($mysql, $query, $result)) {
					//Fail!
					$data = "An error occured executing the database query.  Check the console for details.";
				} else {
					//Success
					//Reload the array!
		                        $reminders = array();
		                        $reminder = array();
		                        $query = "SELECT `reminder_id`, `reminder_target_nick` FROM `{$setMySQLTablePre}reminders` ORDER BY `reminder_id` ASC";
		                        $r = dbQuery($mysql, $query, $result);
					$data = NULL;
		                        if($r) {
						$data = "Hmm, there was an error reloading the array.... ";
		                        } else {
		                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		                                        $reminder[$row['reminder_id']] = $row['reminder_target_nick'];
		                                }
		                                mysqli_free_result($result);
		                        }
					if($setRemindOnJoin) {
						$orJoin = "or join ";
					} else {
						unset($orJoin);
					}
					$data .= "OK, I'll tell them the next time I see them talk in {$orJoin}a channel I'm in.";
				}
				unset($result);
				mysqli_close($mysql);
			}
	                fwrite($ircc, "PRIVMSG $c :" . $e . $data . "\r\n");
	                echo "-!- PRIVMSG $c :" . $e . $data . "\r\n";
		}
		//Code to allow retrieval of reminders, ignoring PMs to the bot
		if(($d[1] == "PRIVMSG" || ($d[1] == "JOIN" && $setRemindOnJoin)) && $d[2] != $nick) {
			$success = false;
			$t = explode('!', $d[0]);
			$userNick = $t[0];
			$t = explode('@', $d[0]);
			$userHost = $t[1];
			$data = NULL;
			foreach($reminder as $id => $target) {
				if(stristr($userNick, $target) || stristr($userHost, $target) == $target) {
					//We have a winner!
					$mysql = dbConnect();
					$query = "SELECT `reminder_text`, `reminder_time`, `reminder_requester` FROM `{$setMySQLTablePre}reminders` WHERE `reminder_target_nick`='{$target}'";
					if(dbQuery($mysql, $query, $result)) {
						//FAIL!
						$data = "An error occured in the database query.  Check the console for details.";
					} else {
						//Success!
						$success = true;
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
							$message = "{$userNick}: {$row['reminder_requester']} asked me at {$row['reminder_time']} (Y-M-D H:M:S, UTC) to tell you {$row['reminder_text']}";
							fwrite($ircc, "PRIVMSG {$d[2]} :{$message}\r\n");
						}
						mysqli_free_result($result);
					}
					//...now delete those messages from the database.
					if($success) {
						$query = "DELETE FROM `{$setMySQLTablePre}reminders` WHERE `reminder_target_nick`='{$target}'";
						dbQuery($mysql, $query, $result); unset($result);
					}
					mysqli_close($mysql);
				}
			}
			if($success) { //Reload the arrays now, too
	                        $reminder = array();
	                        $query = "SELECT `reminder_id`, `reminder_target_nick` FROM `{$setMySQLTablePre}reminders` ORDER BY `reminder_id` ASC";
	                        $mysql = dbConnect();
	                        $r = dbQuery($mysql, $query, $result);
	                        if($r) {
					//Do nothing, it shouldn't cause *that* much harm....
	                        } else {
	                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	                                        $reminder[$row['reminder_id']] = $row['reminder_target_nick'];
	                                }
	                                mysqli_free_result($result);
	                        }
	                        mysqli_close($mysql);
			}
		}
	}
	if($setEnableFishbot && hasPriv('fish')) {
		$stop = FALSE;
		$target = explode("!", $d[0]);
		$e = $target[0];
		if($d[2] == $nick) {
			$target = explode("!", $d[0]);
			$c = $target[0];
			$e = NULL;
		} else {
			$c = $d[2];
		}
		unset($d[0], $d[1], $d[2]);
		$fishdata = trim(implode(" ", $d));
		if($fishdata) {
			$data = NULL;
			if(preg_match("/" . chr(001) . "ACTION.*/i", $fishdata)) {
				//Type is CTCP ACTION
				//$after = explode("\001ACTION", $d[3]);
				//$new = explode("\001", $after[1]);
				//$toProcess = trim($new[0]);
				$toProcess = str_replace(array("\001ACTION ","\001"), array('',''), $fishdata);
				/*
				foreach($fishAresponses AS $regex => $response) {
					if(preg_match($regex, $toProcess)) {
						$data = $response;
					} else {
						$data = NULL;
					}
				} */
				foreach($fishAresponses as $regex2 => $mtpl) {
					$regex = str_replace('%f', preg_quote($nick, '/'), $regex2);
					if(preg_match($regex,$toProcess,$m) && !$stop) {
						$data = str_replace(array('%n','%c','%1'),array($e,$c,$m[1]),$mtpl);
						$stop = TRUE;
					}
				}
			} else {
				//Type is standard message
				/*
				foreach($fishCresponses AS $regex => $response) {
					if(preg_match($regex, trim($d[3]))) {
						$data = $response;
					} else {
						$data = NULL;
					}
				}*/
				foreach($fishCresponses as $regex2 => $mtpl) {
					$regex = str_replace('%f', preg_quote($nick, '/'), $regex2);
					if(preg_match($regex,$fishdata,$m) && !$stop) {
						$data = str_replace(array('%n','%c','%1'),array($e,$c,$m[1]),$mtpl);
						$stop = TRUE;
					}
				}
			}
			if($data) {
				fwrite($ircc, "PRIVMSG $c :" . $data . "\r\n");
				echo "-!- PRIVMSG $c :" . $data . "\r\n";
				$fishcount++;
			}
		}
		unset($fishdata, $toProcess);
	}
}
if($d[3] == "{$setTrigger}mute" && hasPriv('mute')) {
	$cmdcount++;
	$target = explode("!", $d[0]);
	$target2 = $target[0];
	if(!stristr($d[2], "#")) {
		$c = $target2[0];
	}
	$muted = $users['*!*@*'];
	$users['*!*@*'] = 'ignore';
	fwrite($ircc, "PRIVMSG $c :$target2: Bot now muted.\r\n");
}
if($d[3] == "{$setTrigger}unmute" && hasPriv('mute')) {
	$cmdcount++;
	$target = explode("!", $d[0]);
	$target2 = $target[0];
	if(!stristr($d[2], "#")) {
		$c = $target2[0];
	}
	$users['*!*@*'] = $muted;
	$muted = NULL;
	fwrite($ircc, "PRIVMSG $c :$target2: Bot now unmuted.\r\n");
}
}
