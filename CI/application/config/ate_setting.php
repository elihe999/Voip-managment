<?php

if ( ! defined('BASEPATH') )
{
    defined('BASEPATH') OR exit('No direct script access allowed');
}

/*
| -------------------------------------------------------------------------
| log settings
| -------------------------------------------------------------------------
| For each test function
| 
| REMEMBER TO MODIFY THIS FILE
|
*/

$config['case_setting'] = array(
    'main' => 'ate_setting',
    'sipp' => 'settings',
    'global' => 'globSettings',
    'webSocket'=> 'webSocket',
    'case_class' => 'case_list.txt',
    'cfg_save_value' => '_SAVED_VALUES.txt',
    'description' => '#desc'
);

$config['base_setting'] = array(
    'rootDir' => '/var/www/newblog/public/automation_test',
    'sipp_log' => '/var/www/newblog/public/sipp_test',
    'neo_user' => 'user',
    'sipp_history' => 'public/History',
    'public_area' => '/var/www/newblog/public',
    'wwwDir' => '/var/www/newblog',
    'configSuite' => 'public/suite',
    'db_device' => 'device_tb',
    'db_user' => 'user_tb',
    'suite_history' => 'suite_history_tb',
    'case_history' => 'case_history_tb',
    'cache' => '/var/www/newblog/cache'
);

$config['init_file_setting'] = array(
    'interface' => 'interface = enp2s0',
    'timeout' => 'compareTimeout = 11',
    'server' => 'serverPath = /var/www/html/automation_test/tftpServer',
    'serverUrl' => "serverURL = \"tftp://192.168.92.210\""
);