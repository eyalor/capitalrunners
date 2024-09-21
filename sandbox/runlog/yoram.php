<?php
header('Access-Control-Allow-Origin: *');
require_once 'php/html_page_init.php';
require_once 'php/member_authentication.php';
require_once 'php/constants.php';
require_once 'php/utils.php';

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



$json = file_get_contents('php://input');
$data = json_decode($json);
echo $data->email;
echo $data->password;


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

$link = mysqli_connect("localhost", "u574399506_testlog", "Sandbox1PA$$", "u574399506_testlog") or die("Could not connect");

//	$link = mysqli_connect("localhost", "u574399506_testlog", "Sandbox1PA$$", "u574399506_testlog" ) or die("Could not connect");
mysqli_set_charset($link, "utf8");
mysqli_select_db($link, "u574399506_testlog") or die("Could not select database");
$query_dq = "SELECT count(*) as quote from tl_quotes where tl_quotes.date=CURDATE()";
$result_dq = mysqli_query($link, $query_dq) or die("Query failed");
$row_dq = mysqli_fetch_array($result_dq, MYSQLI_ASSOC);
echo $row_dq;



//$dt = new DateTime("022-01-30T05:20:51Z", new DateTimeZone('Asia/Amman'));

//echo $dt->format('Y-m-d h:i:s');

$time = strtotime("022-01-30T05:20:51Z".' UTC');
$dateInLocal = date("Y-m-d H:i:s", $time);

echo $dateInLocal;
echo "<br>";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://zenquotes.io/api/today");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curl);
curl_close($curl);
echo $output;
echo "test";

