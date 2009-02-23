<?php
/***************************************
LizardBot configuration file
****************************************
Options:
[REQUIRED]
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
      $setCTCPTime: Set the CTCP TIME reply.  String, null for no reply.
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
***************************************/
#################################################
#                     REQUIRED                  #
#                       BLOCK                   #
#################################################
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
#################################################
#                    RECOMMENDED                #
#                       BLOCK                   #
#################################################
  $setIdent = "LizardBot";
  $setGecos = "PHP-LizardBot v{$version} - http://scalar.cluenet.org/~fastlizard4/lizardbot.php";
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
   $setCTCPVersion = "PHP-LizardBot (Written in PHP 5 Procedural by FastLizard4 and the LizardBot Development Team) v{$version} http://scalar.cluenet.org/~fastlizard4/lizardbot.php";
      $setCTCPTime = "My my, aren't we nosy? :P";
  $setCTCPUserinfo = "PHP-LizardBot: Boldly Going Where No Bot Has Gone Before! - http://scalar.cluenet.org/~fastlizard4/lizardbot.php";
$setCTCPClientinfo = "I am PHP-LizardBot version {$version}.  I support these CTCP commands: VERSION TIME USERINFO CLIENTINFO";
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
/****************************************
SYSTEM DEFINED FUNCTIONS - ALL SETINGS MUST GO ABOVE THIS!
*****************************************/ 
if(!$rehash) {
	function hasPriv($priv) {
		global $privgroups, $users, $d;
		$parsed = $d[0];
		foreach( $users as $user => $group ) {
			if( fnmatch( $user, $parsed/*['n!u@h']*/ ) ) {
				if( isset( $privgroups[$group][$priv] ) ) {
					return $privgroups[$group][$priv];
				} else {
					return 0;
				}
			}
		}
		$d[0] = $parsed;
	}
	function showPriv() {
		global $privgroups, $users, $d;
		$parsed = $d[0];
		foreach( $users as $user => $group ) {
			if( fnmatch( $user, $parsed/*['n!u@h']*/ ) ) {
				return "$group";
			} else {
				return "Error getting priv";
			}
		}
	}
}
?>
