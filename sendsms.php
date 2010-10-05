#!/usr/local/bin/php
<?php
/**
* Send SMS Messages via Clickatell
*
* @author       Jacques Marneweck <jacques@php.net>
* @copyright    2003-2010 Jacques Marneweck. All rights strictly reserved.
* @package      SMS_Clickatell
*/

require_once 'PEAR.php';
require_once 'SMS/Clickatell.php';

set_time_limit(0);
error_reporting(E_ALL);

if ($_SERVER['argc'] != 3) {
    die ("Usage: {$_SERVER['argv'][0]} [msisdn] [subject] [message]");
}

$sms = new SMS_Clickatell;
$res = $sms->init (
    array (
        'user' => 'username',
        'pass' => 'password',
        'api_id' => 'api_id',
    )
);
if (PEAR::isError($res)) {
    die ($res->getMessage());
}
$res = $sms->auth();
if (PEAR::isError($res)) {
    die ($res->getMessage());
}

$climsgid = md5(md5(uniqid(mt_rand(), true)) .
                md5(uniqid(rand(), true)));
$sent = $sms->sendmsg (
    array (
        'to' => $_SERVER['argv'][1],
        'text' => $_SERVER['argv'][3],
        'msg_type' => 'SMS_TEXT',
        'climsgid' => $climsgid,
    )
);
if (PEAR::isError($sent)) {
    die ($sent->getMessage());
}
