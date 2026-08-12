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
    echo "Test" ;
}
echo "<br>";






//$dt = new DateTime("022-01-30T05:20:51Z", new DateTimeZone('Asia/Amman'));

//echo $dt->format('Y-m-d h:i:s');

$time = strtotime("022-01-30T05:20:51Z".' UTC');
$dateInLocal = date("Y-m-d H:i:s", $time);

echo $dateInLocal;