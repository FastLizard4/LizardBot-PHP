#!/usr/bin/php
<?php
$cmdcount = 0;
$pingcount = 0;
$ctcpcount = 0;
$aicount = 0;
$insultcount = 0;
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
require($dir);
$rehash = FALSE;
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

PHP-LizardBot: IRC bot developed by FastLizard4 (who else?) and the LizardBot Development Team
Version 6.1.0.0b (major.minor.build.revision) BETA
Licensed under the Creative Commons GNU General Public License 2.0 (GPL)
For licensing details, contact me or read this page:
http://creativecommons.org/licenses/GPL/2.0/
REPORT BUGS AND SUGGESTIONS TO BUGZILLA (http://scalar.cluenet.org/~fastlizard4/bugzilla)

LICENSING DETAILS:
PHP-LizardBot (IRC bot) written by FastLizard4 and the LizardBot Development Team
Copyright (C) 2008 FastLizard4 and the LizardBot Development Team

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
$version = "6.1.0.0b";
$upfp = @fopen('http://lizardwiki.gewt.net/w/index.php?title=LizardBot/Latest&action=raw', 'r');
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
        if(isset($reply) && !preg_match("/^\s*$/", $reply)){
            return $this->get_say($reply);
        } elseif(!isset($reply) || preg_match("/^\s*$/", $reply)) {
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
        $pattern = "#<$tag color=\"\w+\">(.*?)</$tag>#";
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
		echo "-!- Caught SIGHUP (1), now rehasing\r\n";
		$rehash = TRUE;
		include($dir);
		$rehash = FALSE;
		echo "-!- Rehash complete.\r\n";
	}
	function SIGTERM() {
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
if(!preg_match("/^([A-Za-z_\[\]\|])([\w-\[\]\^\|`])*$/", $nick)) {
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
	$data = str_replace(array("\n", "\r"), '', fgets($ircc, 1024));
	echo $data . "\n";
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
		$data .= "CLIENTINFO " . $setCTCPClientinfo;
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
		 $data .= "VERSION ". $setCTTCPVersion;
		 $data .= chr(001);
		 $data .= "\r\n";
		 fwrite($ircc,$data);
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
		include($dir);
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
		fwrite($ircc, "PRIVMSG $c :$target2: For help and copyrights, see http://scalar.cluenet.org/~fastlizard4/lizardbot.php\r\n");
		echo "
-!- $target2 requested {$setTrigger}info\n
";
	}
	if($d[3] == "{$setTrigger}nyse" && hasPriv('nyse')) {
		$cmdcount++;
		$symbol = $d[4];
		$url = sprintf('http://quote.yahoo.com/d/quotes.csv?s=%s&f=nl1c6k2t1vp', $symbol);
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
	if($d[3] == "{$setTrigger}fantasy" && hasPriv('mute')) {
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
		$patterns = array("/\|/", "/\[/", "/\]/");
		$replacements = array("\|", "\[", "\]");
		$nicksan = preg_replace($patterns, $replacements, $nick);
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
			if(!$rofl || preg_match("/^\s*$/", $rofl)) { $rofl = $ai->default_response; }
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
		$version = "6.1.0.0b";
		$upfp = @fopen('http://lizardwiki.gewt.net/w/index.php?title=LizardBot/Latest&action=raw', 'r');
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
		        $output = "LizardBot version {$data} is available.  Please update, or get details at http://scalar.cluenet.org/~fastlizard4/lizardbot.php?page=cl#latest";
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
		if(!stristr($googleOut, '<img src=/images/calc_img.gif width=40 height=30 alt="">')) {
			$data = "Error: An invalid calculation was specified.";
			$stopExecution = TRUE;
		}
		if(!$stopExecution) {
			$googleOut2 = explode("<div id=res", $googleOut);
			$googleOut3 = explode("<font size=-1", $googleOut2[1]);
			$googleOut4 = explode("<b>", $googleOut3[0]);
			$googleOut5 = explode("</b>", $googleOut4[1]);
		}
		unset($googleOut2);
		unset($googleOut3);
		unset($googleOut4);
		unset($googleOut);
		unset($toGoogle);
		unset($googleURL);
		if(!$stopExecution) {
			$predata =  $googleOut5[0];
			$predata2 = html_entity_decode($predata);
			$predata3 = str_replace("<sup>", "^", $predata2);
			$data = strip_tags($predata3);
			unset($predata);
			unset($predata2);
			unset($predata3);
		}
		unset($googleOut5);
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
	if($d[3] == "{$setTrigger}editcount" && hasPriv('*')) {
		$cmdcount++;
		$error = FALSE;
		/************************
		 Editcount function
		 *Determines a user's editcount on various Wikimedia wikis
		 *May be upgraded in the future to use non-wikimedia wikis
		 *Variables used:
		 **
		 **********************/
		$editcount['user'] = $d[4];
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
	}
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
		if($d[4] && $d[4] != $nick) {
			$e = $d[4] . ": ";
		} else {
			if($d[4] == $nick) {
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
		$totalcount = $cmdcount + $pingcount + $ctcpcount + $aicount;
		$uptime['days'] = (time() - $uptime['start'])/86400;
		$uptime['days'] = floor($uptime['days']);
		$uptime['current'] = gmdate('H:i:s', time() - $uptime['start']);
		$uptime['current'] = $uptime['days'] . ' days, ' . $uptime['current'];
		$php_os = PHP_OS;
		$data = "I am bot {$nick}. Software: PHP-LizardBot v{$version} (http://lizardwiki.gewt.net/wiki/LizardBot) on OS {$php_os}; Uptime: {$uptime['current']}; I have been used a total of {$totalcount} times (Commands: {$cmdcount} [Of which, {$insultcount} were insult commands], Server pings: {$pingcount}, Recognized CTCPs: {$ctcpcount}, AI calls: {$aicount}).";
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