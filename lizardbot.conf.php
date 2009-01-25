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
       $setTrigger: Set the bot's trigger.  String.  '@' by default.

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

   $setAIDefaultRE: Default AI response.  String.

##MySQL Configuration
   $setEnableMySQL: Set to true to enable MySQL.  Boolean.
 $setMySQLUserName: Set the MySQL username.  String.
     $setMySQLHost: Set the host for the MySQL database.  String.
     $setMySQLPort: Set the port for the MySQL database.  Integer.
$setMySQLDefaultDB: Set the default database in MySQL.  Recommended, but not needed.

    $setEnableExec: Whether @exec should be enabled.  Boolean, true to enable.
    $setEnableEval: Whether @eval should be enabled.  Boolean, true to enable.
***************************************/
#################################################
#                     REQUIRED                  #
#                       BLOCK                   #
#################################################
##Nickname configuration
$nickname = "LizardBot-1";

##Users Configuration
//	Nick!User@Host mask						=> group
$users = array(
	'*!*@wikipedia/FastLizard4'                                              => 'root'     ,
//	'*Lizar!FastLizard@pool-71-109-*-*.lsanca.dsl-w.verizon.net'             => 'root'     ,
        '*!FastLizard@TyroNet/NetAdmin/lizardwiki-founder.wikipedia.FastLizard4' => 'root'     ,
	'*!*@FastLizard4.users.en.wikipedia.org'                                 => 'root'     ,
//	'*!FastLizard@*.lsanca.dsl-w.verizon.net'                                => 'root'     ,
	'bumm13!n=bumm13@63-229-129-139.ptld.qwest.net'                          => 'trusted'  ,
	'*!n=SGN@Wikimedia-Commons/ShakataGaNai'                                 => 's-trusted',
	'*!*@wikipedia/Yamakiri'                                                 => 's-trusted',
	'*!n=hayley@*:1:217:3fff:fe84:e1be'                                      => 's-trusted',
	'*!*@unaffiliated/bol'                                                   => 's-trusted',
//	'GPT!~gpt@li40-213.members.linode.com'                                   => 'trusted'  ,
	'*!*@wikia/Eulalia459678'                                                => 's-trusted',
	'*!*@fullcirclemagazine/developer/ttech'                                 => 's-trusted',
	'*!*@unaffiliated/jamesontai'                                            => 's-trusted',
	'*!n=KFP@wikipedia/KFP'                                                  => 's-trusted',
	'*!*@Robert.users.cluenet.org'                                           => 'ignore'   ,
	'*!*@SB395.users.cluenet.org'                                            => 'ignore'   ,
	'SwirlBoy39!*@*'                                                         => 'ignore'   ,
	'*!*@wikipedia/SwirlBoy39'                                               => 'ignore'   ,
	'*!*@unaffiliated/vandalismdstryr/x-917232'                              => 'ignore'   ,
	'*!*@*'                                                                  => '*'
);

##Groups configuration
//         [ Group       ][ Privilege     ] = 1;
$privgroups[ 'ignore'    ]                  = 0;                      //'ignore' has no privs

$privgroups[ '*'         ][ '*'           ] = 1;                      //All basic privs
$privgroups[ '*'         ][ 'nyse'        ] = 1;
//$privgroups[ '*'         ][ 'fap'         ] = 1;
$privgroups[ '*'         ][ 'fantasy'     ] = 1;

$privgroups[ 's-trusted' ]                  = $privgroups['*'];       // 's-trusted' inherits '*'
$privgroups[ 's-trusted'   ][ 'fap'         ] = 1;
$privgroups[ 's-trusted'   ][ 'say'         ] = 1;
$privgroups[ 's-trusted'   ][ 'do'          ] = 1;

$privgroups[ 'trusted'   ]                  = $privgroups['s-trusted'];       // 'trusted' inherits 's-trusted'
$privgroups[ 'trusted'   ][ 'join'        ] = 1;
$privgroups[ 'trusted'   ][ 'part'        ] = 1;
//$privgroups[ 'trusted'   ][ 'fap'         ] = 1;
//$privgroups[ 'trusted'   ][ 'say'         ] = 1;
$privgroups[ 'trusted'   ][ 'notice'      ] = 1;
//$privgroups[ 'trusted'   ][ 'do'          ] = 1;
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
$setFantasy = TRUE;
#################################################
#                    RECOMMENDED                #
#                       BLOCK                   #
#################################################
  $setIdent = "FastLizard4";
  $setGecos = "LizardBot-1 v5.4.0.5 Operated By FastLizard4";
$setTrigger = "@";

#################################################
#                     OPTIONAL                  #
#                       BLOCK                   #
#################################################
##CTCP Configuration
   $setCTCPVersion = "LizardBot-1 (Written in PHP 5 Procedural by FastLizard4) v5.4.0.5 - PM my master for more information";
      $setCTCPTime = "My my, aren't we nosy? :P";
  $setCTCPUserinfo = "LizardBot-1: Boldly Going Where No Bot Has Gone Before!";
$setCTCPClientinfo = "I am LizardBot-1.  I support these CTCP commands: VERSION TIME USERINFO CLIENTINFO";
$setUnknownCTCP_RE = NULL; //Not yet implemented

       $setNoBolds = FALSE;
   $setAIDefaultRE = "I'm sorry Dave, I'm afraid I can't do that. (Pandorabot AI API failed!!)";

##MySQL configuration
   $setEnableMySQL = NULL;  //Not yet implemented
 $setMySQLUserName = NULL;  //Not yet implemented
     $setMySQLHost = NULL;  //Not yet implemented
     $setMySQLPort = NULL;  //Not yet implemented
$setMySQLDefaultDB = NULL;  //Not yet implemented

$setNSPassword = NULL; //No longer implemented
$setNSUsername = "LizardBot-1";

$setEnableExec = TRUE;
$setEnableEval = TRUE;
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
