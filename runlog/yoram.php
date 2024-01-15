<?php
header('Access-Control-Allow-Origin: *');
require_once 'php/html_page_init.php';

echo $memberId;
echo "<br>";
echo $memberAuthentication->getMemberName();
echo "<br>";
echo $memberAuthentication->isAdmin();
echo "<br>";
echo $memberAuthentication->isCoach();
echo "<br>";
echo $memberAuthentication->getStravaId();
echo "<br>";

require_once 'member_authentication.php';
require_once 'constants.php';
require_once 'utils.php';

$json = file_get_contents('php://input');
$data = json_decode($json);
echo $data->email;
echo $data->password;
$memberAuthentication = new memberAuthentication();
if (!$memberAuthentication->isMemberAuthenticated())
{
    echo $data->email;
    echo $data->password;
    
}

if ($memberAuthentication->isAdmin())
{
    echo "True Admin";
}
echo "<br>";


if ($memberAuthentication->isCoach())
{
    echo "True Coach";
}
echo "<br>";


if ($_SESSION[MEMBER_ADMIN_SESSION_KEY_NAME])
{
    echo "True Admin Session Variable" ;
}
echo "<br>";






//$dt = new DateTime("022-01-30T05:20:51Z", new DateTimeZone('Asia/Amman'));

//echo $dt->format('Y-m-d h:i:s');

$time = strtotime("022-01-30T05:20:51Z".' UTC');
$dateInLocal = date("Y-m-d H:i:s", $time);

echo $dateInLocal;