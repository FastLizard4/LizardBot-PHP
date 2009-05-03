<?php
/***************************************
LizardBot configuration file
****************************************
*INSTRUCTIONS AREA FOR THE CONFIGURATION FILE.  READ THIS TOP SECTION COMPLETELY BEFORE
*CONFIGURING LIZARDBOT!  IF YOU WANT TO SEE THE SETTINGS, SCROLL DOWN BELOW THIS SECTION
Options:
[REQUIRED]
##Timezone configuration
YOU MUST SPECIFY THE BOT'S TIMEZONE.  TO DO SO, SET $timezone AS BELOW TO YOUR TIMEZONE, UNLESS
YOUR TIMEZONE IS ALREADY DEFINED IN YOUR PHP CONFIGURATION FILE.
         $timezone: Set the bot's timezone.  String.
                    For possible values, see http://us3.php.net/manual/en/timezones.php
##Nickname configuration
         $nickname: Set the bot's default nickname.  String.
##Users configuration
            $users: Set the privledged users.  See below for usage.
                    FORMAT:
                    $users = array(
                    	'<hostmask, first user, standard syntax>' => '<access level>'       ,
                    	'<hostmask, last user, standard syntax>'  => '<access level>'       ,
                    	'*!*@*'                                   => '<default access level>'
                    )
                    SPECIAL NOTE:
                    The default access level is overriden with the @mute command!
##Groups configuration
       $privgroups: Set the user access levels.  See below for usage.
                    FORMAT:
                    $privgroups['ignore'   ]             = 0; //'ignore' has no privs
                    $privgroups['*'        ]['*'       ] = 1; //All basic privs
                    $privgroups['<group 1>']             = $privgroups['*']; // '<group 1>' inherits '*'.
                    $privgroups['<group 1>']['<priv 1>'] = 1; //Grant <priv 1> to <group 1>
                    $privgroups['<group 1>']['<priv 2>'] = 1; //Grant <priv 2> to <group 1>
                    <...>
                    $privgroups['<group 2>']             = $privgroups['<group 1>']; // '<group 2>' inherits '<group 1>'.
                    $privgroups['<group 2>']['<priv 3>'] = 1; //Grant <priv 3> to <group 2>
                    $privgroups['<group 2>']['<priv 4>'] = 1; //Grant <priv 4> to <group 2>
                    <...>
                    $privgroups['root'     ]                 = $privgroups['<group 2>']; // 'root' inherits '<group 2>'.
                    $privgroups['root'     ]['rehash'  ] = 1; //Root can rehash
                    $privgroups['root'     ]['die'     ] = 1; //Root can kill bot
                    $privgroups['root'     ]['raw'     ] = 1; //Root can dump commands into the output stream
##Pandorabot configuration
          $fantasy: Enable pandorabot by default.  False to disable, true to enable.  Note that the 
                    @fantasy-[on, off] commands override this.
##Windows configuration.  If you are running the bot on Windows, you must set this to true!!!!!
   $setIsOnWindows: Tells the bot that its running on Windows.  Automatically sets $setUsePCREs to true.  Please read
                    the guide to running the bot on Windows here: http://lizardwiki.gewt.net/wiki/LizardBot/Windows
[RECOMMENDED]
         $setGecos: Set the bot's gecos, or real name.  String.  Default: bot
         $setIdent: Set the bot's username if no ident reply is sent.  String. Default: bot
       $setTrigger: Set the bot's command trigger.  String.  Default is '@'

##Services Configuration
    $setNSPassword: The default NickServ password
    $setNSUsername: The default NickServ username
[OPTIONAL]
##CTCP Configuration
   $setCTCPVersion: Set the CTCP VERSION reply.  String, null for no reply.
  $setCTCPUserinfo: Set the CTCP USERINFO reply.  String, null for no reply.
$setCTCPClientinfo: Set the CTCP CLIENTINFO reply.  String, null for no reply.
$setUnknownCTCP_RE: Set the reply for unknown CTCPs.  String, null for no reply.

       $setNoBolds: Supress bolds.  Boolean, true to hide.
   $setAIDefaultRE: Sets the default AI response.  String.

##MySQL Configuration
   $setEnableMySQL: Set to true to enable MySQL.  Boolean.
 $setMySQLUserName: Set the MySQL username.  String.
     $setMySQLHost: Set the host for the MySQL database.  String.
     $setMySQLPort: Set the port for the MySQL database.  Integer.
$setMySQLDefaultDB: Set the default database in MySQL.  Recommended, but not needed.
 $setMySQLTablePre: Set the table prefix.  String, default NULL.

    $setEnableExec: Whether or not to enable the @exec command.  Boolean, true to enable.
    $setEnableEval: Whehter or not to enable the @eval command.  Boolean, true to enable.

   $setTrustGoogle: If, for some reason, you are extremely paranoid and don't trust the Google,
                    set this to false.  Boolean, default TRUE.
                    
      $setUsePCREs: Instead of standard IRC hostmask syntax, use the more-powerful Perl Compatible
                    Regular Expressions.  Not recommended for novice users.  Boolean, default FALSE.
                    TRUE to use PCREs.
                    
   $setInsultUsers: Throw insults like the Bard!  When set to true, allows use of the insult command.
                    See the documentation at http://lizardwiki.gewt.net/wiki/LizardBot/Docs for details.
                    Boolean, default TRUE.

[AUTOCONNECT BLOCK]
This optional block, when configured, allows the bot to immeidately automatically connect to a network
when the configuration file is loaded.  Note that it is unoveridable - the bot will not prompt at all.
If the directives are present, the bot will connect if it has all the information it needs, otherwise,
the bot will automatically quit.

 $autoconnect['enabled']: Boolean.  Whether or not to process autoconnect block.  True to enable autoconnect,
                          false to disable autoconnect.  All settings below are only needed if this is set to true
 $autoconnect['network']: String.  What network the bot should connect to.  Format: network OR network:port.
                          If no port is provided, defaults to 6667.
    $autoconnect['nick']: String.  What nickname the bot should use.  You can specify . as the value for string
                          to use the default you stored in the configuration file (see $nickname in the required
                          block above).
$autoconnect['identify']: String.  Whether or not to identify.  'yes' or 'y' to identify, 'no' or 'n' to prevent
                          identification to services.
 $autoconnect['id-nick']: String.  Nickname to use for identification.  Note that this is only usable on
                          Atheme, and cannot be used with other daemons, such as Anope to the point that
                          identification will fail.  It is recommended you use this function with Atheme to guarantee
                          your bot correctly identifies.  To send the default (if present, see $setNSUsername above),
                          suppy '.'.  To send NO primary username, supply '#'.
                          Otherwise, enter the username you would like to use and strike enter.  Please note that this
                          is not the same as the bot nickname.  This does not need to be set if you disabled autoidentify
                          (above)
 $autoconnect['id-pass']: String.  Password to send for identification.
                          WARNING: PLEASE READ THE BELOW CAREFULLY
                          ENTERING YOUR PASSWORD HERE WILL STORE IT IN CLEAR TEXT!  IT WILL BE VISIBLE TO THE ENTIRE
                          WORLD UNLESS YOU TAKE STEPS TO PREVENT OTHERS FROM SEEING IT!  ON UNIX-BASED MACHINES, USE THE
                          COMMAND chmod 700 lizardbot.conf.php (replace lizardbot.conf.php with the name of your config
                          file as necessary) TO PREVENT OTHERS FROM READING IT.  IF YOU RUN WINDOWS, MAKE SURE A PASSWORD
                          IS SET WITH YOUR USER ACCOUNT AND USE WINDOWS EXPLORER TO MARK THE CONFIGURATION FILE AS 'PRIVATE'
                          IF YOU DO NOT LIKE STORING YOUR PASSWORD IN A FILE, DO NOT SUPPLY IDENTIFICATION INFO OR DO NOT USE
                          THE AUTOCONNECT FUNCTION!  This does not need to be set if you disabled autoidentify (above).
$autoconnect['channels']: String.  Comma-delimited list of channels that the bot should join after connecting.  For example:
                          '#chan1,##chan2,#chan3,#chan4' would be a valid entry, as would '#chan1'.
***************************************/
#################################################
#                     REQUIRED                  #
#                       BLOCK                   #
#################################################
##Timezone configuration
/*Again, here's a quick briefing on this setting:
Unless your timezone is specified in your PHP configuration file, you must specify
one here!  Set $timezone to the string which contains your timezone name.  For example"
$timezone = "America/Los_Angeles";
For a list of valid timezones, see http://us3.php.net/manual/en/timezones.php
*/
$timezone = "";

##Nickname configuration
$nickname = "";

##Users Configuration
//	Nick!User@Host mask						=> group
$users = array(
	'YOUR HOSTMASK HERE'                                                     => 'root'     ,
	'*!*@*'                                                                  => '*'
);

##Groups configuration
//         [ Group       ][ Privilege     ] = 1;
$privgroups[ 'ignore'    ]                  = 0;                      //'ignore' has no privs

$privgroups[ '*'         ][ '*'           ] = 1;                      //All basic privs
$privgroups[ '*'         ][ 'nyse'        ] = 1;
$privgroups[ '*'         ][ 'fantasy'     ] = 1;
$privgroups[ '*'         ][ 'insult'      ] = 1;
$privgroups[ '*'         ][ 'tinyurl'     ] = 1;

$privgroups[ 's-trusted' ]                  = $privgroups['*'];       // 's-trusted' inherits '*'
$privgroups[ 's-trusted' ][ 'fap'         ] = 1;
$privgroups[ 's-trusted' ][ 'say'         ] = 1;
$privgroups[ 's-trusted' ][ 'do'          ] = 1;

$privgroups[ 'trusted'   ]                  = $privgroups['s-trusted'];       // 'trusted' inherits 's-trusted'
$privgroups[ 'trusted'   ][ 'join'        ] = 1;
$privgroups[ 'trusted'   ][ 'part'        ] = 1;
$privgroups[ 'trusted'   ][ 'notice'      ] = 1;
$privgroups[ 'trusted'   ][ 'oper-tyronet'] = 1;
$privgroups[ 'trusted'   ][ 'op'          ] = 1;

$privgroups[ 'v-trusted' ]                  = $privgroups['trusted'];       // 'v-trusted' inherits 'trusted'
$privgroups[ 'v-trusted' ][ 'mute'        ] = 1;

$privgroups[ 'root'      ]                  = $privgroups['v-trusted']; // 'root' inherits 'v-trusted'.
$privgroups[ 'root'      ][ 'rehash'      ] = 1;
$privgroups[ 'root'      ][ 'die'         ] = 1;
$privgroups[ 'root'      ][ 'raw'         ] = 1;
$privgroups[ 'root'      ][ 'nick'        ] = 1;
$privgroups[ 'root'      ][ 'exec'        ] = 1;
$privgroups[ 'root'      ][ 'eval'        ] = 1;


##Pandorabot config
$setFantasy = FALSE;

##If you are on Windows, YOU MUST SET THIS TO TRUE!
$setIsOnWindows = FALSE;
#################################################
#                    RECOMMENDED                #
#                       BLOCK                   #
#################################################
  $setIdent = "LizardBot";
  $setGecos = "PHP-LizardBot v{$version} - http://lizardwiki.gewt.net/wiki/LizardBot";
$setTrigger = "@";

#################################################
#                    IDIOT LINE                 #
# Comment out or remove the line below.  This   #
# makes sure that you are actually reading and  #
# correctly making use of the config file.      #
# WHILE YOU ARE HERE - Did you remember to      #
# replace 'YOUR HOSTMASK HERE' in the $users    #
# array above with your hostmask?               #
#################################################
die(">>>PLEASE CONFIGURE THE BOT CORRECTLY!\r\n");

#################################################
#                     OPTIONAL                  #
#                       BLOCK                   #
#################################################
##CTCP Configuration
   $setCTCPVersion = "PHP-LizardBot (Written in PHP 5 Procedural by FastLizard4 and the LizardBot Development Team) v{$version} http://lizardwiki.gewt.net/wiki/LizardBot";
  $setCTCPUserinfo = "PHP-LizardBot: Boldly Going Where No Bot Has Gone Before! - http://lizardwiki.gewt.net/wiki/LizardBot";
$setUnknownCTCP_RE = NULL; //Not yet implemented

       $setNoBolds = FALSE;
   $setAIDefaultRE = "Probably";

##MySQL configuration
   $setEnableMySQL = NULL;  //Not yet implemented
 $setMySQLUserName = NULL;  //Not yet implemented
     $setMySQLHost = NULL;  //Not yet implemented
     $setMySQLPort = NULL;  //Not yet implemented
$setMySQLDefaultDB = NULL;  //Not yet implemented
 $setMySQLTablePre = NULL;  //Not yet implemented

$setNSPassword = NULL; //No longer implemented
$setNSUsername = NULL;

$setEnableExec = FALSE;
$setEnableEval = FALSE;

$setTrustGoogle = TRUE;

$setUsePCREs = FALSE;

$setInsultUsers = TRUE;

#################################################
#                   AUTOCONNECT                 #
#                       BLOCK                   #
#################################################
if(!$rehash) { //Don't touch this line, else you risk exposing your password
 $autoconnect['enabled'] = FALSE;
 $autoconnect['network'] = NULL;
    $autoconnect['nick'] = NULL;
$autoconnect['identify'] = NULL;
 $autoconnect['id-nick'] = NULL;
 $autoconnect['id-pass'] = NULL;
$autoconnect['channels'] = NULL;
} //Don't touch this line, else you risk exposing your password
/****************************************
SYSTEM DEFINED FUNCTIONS - ALL SETINGS MUST GO ABOVE THIS!
*****************************************/ 
if(!$rehash) {
	function hasPriv($priv) {
		global $privgroups, $users, $d, $setIsOnWindows, $setUsePCREs;
		$parsed = $d[0];
		foreach( $users as $user => $group ) {
			if($setUsePCREs || $setIsOnWindows) {
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
/*	function showPriv() {
		global $privgroups, $users, $d;
		$parsed = $d[0];
		foreach( $users as $user => $group ) {
			if( fnmatch( $user, $parsed/*['n!u@h'] ) ) {
				return "$group";
			} else {
				return "Error getting priv";
			}
		}
	} */
}
?>
