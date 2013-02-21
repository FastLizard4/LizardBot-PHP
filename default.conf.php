<?php
/***************************************
LizardBot DEFAULTS configuration file
****************************************
WARNING WARNING WARNING WARNING WARNING
DO  NOT  EDIT  THIS  FILE
IT WILL BE OVERWRITTEN ON BOT UPDATE!
EDIT THE lizardbot.conf.php FILE INSTEAD
AND PUT YOUR MODIFICATIONS THERE.
This file contains configuration defaults.
Any settings you put in lizardbot.conf.php
will override what's here, and they won't be
lost when you update the bot!

A file sample.lizardbot.conf.php is provided
and should be used as the basis for your own
configuration file; just remember to rename
sample.lizardbot.conf.php to something else
(say, lizardbot.conf.php).

This file MUST be in the same directory
as lizardbot.php
****************************************/
$timezone = "";

$nickname = "";

$users = array(
	'*!*@*'                                                                  => '*'
);

$privgroups[ 'ignore'    ]                  = 0;                      //'ignore' has no privs
$privgroups[ '*'         ][ '*'           ] = 1;                      //All basic privs
$privgroups[ '*'         ][ 'nyse'        ] = 1;
$privgroups[ '*'         ][ 'fantasy'     ] = 1;
$privgroups[ '*'         ][ 'insult'      ] = 1;
$privgroups[ '*'         ][ 'tinyurl'     ] = 1;
$privgroups[ '*'         ][ 'bit.ly'      ] = 1;
$privgroups[ '*'         ][ 'fish'        ] = 1;
$privgroups[ '*'         ][ 'remind'      ] = 1;
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

$setFantasy = FALSE;

$setIsOnWindows = FALSE;


    $setIdent = "LizardBot";
    $setGecos = "LizardBot for PHP v{$version} - http://fastlizard4.org/wiki/LizardBot";
  $setTrigger = "@";
$setAutoModes = "";

   $setCTCPVersion = "LizardBot for PHP (Written in PHP 5 Procedural by FastLizard4 and the LizardBot Development Team) v{$version} http://fastlizard4.org/wiki/LizardBot";
  $setCTCPUserinfo = "LizardBot for PHP: Boldly Going Where No Bot Has Gone Before! - http://fastlizard4.org/wiki/LizardBot";
$setUnknownCTCP_RE = NULL; //Not yet implemented

       $setNoBolds = FALSE;
   $setAIDefaultRE = "Probably";

   $setEnableMySQL = FALSE;
 $setMySQLUserName = NULL;
 $setMySQLPassword = NULL;
     $setMySQLHost = 'localhost';
     $setMySQLPort = 3306;
       $setMySQLDB = NULL;
 $setMySQLTablePre = 'lb';

  $setNSUsername = NULL;

  $setEnableExec = FALSE;
  $setEnableEval = FALSE;

 $setTrustGoogle = TRUE;

    $setUsePCREs = FALSE;

 $setInsultUsers = TRUE;

$setEnableDelays = FALSE;

$setEnableFishbot = FALSE;

$setEnableAllTriggerHelp = TRUE;

$setEnableReminders = TRUE;
   $setRemindOnJoin = FALSE;

  $setEnableBitly = FALSE;
$setBitlyAPISleep = 30;
   $setBitlyLogin = '';
  $setBitlyAPIKey = '';

if(!$rehash) {
 $autoconnect['enabled'] = FALSE;
 $autoconnect['network'] = NULL;
    $autoconnect['nick'] = NULL;
$autoconnect['identify'] = NULL;
 $autoconnect['id-nick'] = NULL;
 $autoconnect['id-pass'] = NULL;
$autoconnect['channels'] = NULL;
}
?>
