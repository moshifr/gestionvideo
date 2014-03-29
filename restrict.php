<?php 

if(getenv('ENV') == 'preprod')
{
	$co = mysql_connect("localhost", "msd", "msd365secure", "msd") or die("Impossible de se connecter : " . mysql_error());
}
else
{
	$co = mysql_connect("bddmywrite", "msd", "msd365secure", "msd") or die("Impossible de se connecter : " . mysql_error());
}
mysql_select_db('msd');

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if($_SERVER['HTTP_X_FORWARDED_FOR'])
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];


$pos = strpos($ip, ',');
if ($pos !== false)
{
	//gestion des ip multiples
	$redirect = true;
	$arrayIP = explode(',', $ip);
	foreach($arrayIP as $value)
	{
		if(substr($value,0,7) == '155.91.' || trim($value) == '92.103.8.138')
		{
			$redirect = false;
		}
	}	
}
elseif(
	//liste ip autoris�es
	$ip != '81.255.83.190' &&
	$ip != '82.227.138.98' &&
	$ip != '88.184.182.35' &&
	$ip != '82.247.11.191' &&
	$ip != '149.6.165.222' &&
	$ip != '82.237.25.207' &&
	$ip != '192.168.23.109' &&
	$ip != '92.103.8.138' &&
//	$ip != '155.91.0.1' &&
//	$ip != '155.91.0.2' &&
//	$ip != '155.91.0.3' &&
//	$ip != '155.91.0.4' &&
//	$ip != '155.91.0.5' &&
//	$ip != '155.91.0.6' &&
//	$ip != '155.91.0.7' &&
//	$ip != '155.91.0.8' &&
//	$ip != '155.91.0.9' && 
//	$ip != '155.91.0.10' &&
//	$ip != '155.91.0.11' &&
//	$ip != '155.91.0.12' &&
//	$ip != '155.91.0.13' &&
//	$ip != '155.91.0.14' &&
//	$ip != '155.91.0.15' &&
//	$ip != '155.91.0.16' &&
	$ip != '82.120.188.228' &&
	$ip != '172.16.11.141' && //ipad client
	$ip != '82.240.235.193' && //wifi365
	$ip != '88.171.197.18' && //wifi lambert
//	substr($ip,0,9) != '155.91.64' &&
//	substr($ip,0,9) != '155.91.65'&&
	substr($ip,0,7) != '155.91.'
	//substr($ip,0,6) != '92.90.'
)
{
	$redirect = true;
}
else
{
	$redirect = false;
}

if($_GET['mode']=='safe365')
	$redirect = false;
	
if($redirect === true)
{
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$db_query = 'INSERT INTO log_redirection VALUES ("", "'. $ip .'", "'.$user_agent.'", NOW())';
	mysql_query($db_query);
	header('Location: http://www.msd-france.com/',false,301);
	exit();
}

?> 