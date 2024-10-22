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

$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
//mail("idosh74@gmail.com","My subject",$msg);


$host = 'localhost';
$dbname = 'u574399506_testlog';
$username = 'u574399506_testlog';
$password = 'Sandbox1PA$$';

try {
    // Create a new PDO instance and connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch data from the 'users' table
	$query = "SELECT tl_runners.member_name as name,DATEDIFF(CURDATE(), max(tl_events.run_date)) as days from tl_runners join tl_events on (tl_events.runner_id=tl_runners.id) where tl_runners.m_show_profile=1 group by tl_runners.member_name having DATEDIFF(CURDATE(), max(tl_events.run_date))>10 order by 2 desc";

    //$query = "SELECT id, member_num FROM tl_runners";
    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Begin building the HTML content
    $htmlContent = '<html><body>';
    $htmlContent .= '<h1>Users List</h1>';
    $htmlContent .= '<table border="1" cellpadding="5" cellspacing="0">';
    $htmlContent .= '<tr><th>Name</th><th>Days since last update</th></tr>';

    // Loop through each row of the query results and add rows to the HTML table
    foreach ($results as $row) {
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        $htmlContent .= '<td>' . htmlspecialchars($row['days']) . '</td>';
        $htmlContent .= '</tr>';
    }

    // End the HTML table and page
    $htmlContent .= '</table>';
    $htmlContent .= '</body></html>';

    // Output the HTML content (for testing purposes)
    echo $htmlContent;

} catch (PDOException $e) {
    // Handle connection errors
    echo "Database connection failed: " . $e->getMessage();
}

$to = "idosh74@gmail.com";
$subject = "HTML Report from SQL Data";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: capitalrunners8@gmail.com" . "\r\n";

// Use the PHP mail() function to send the email
//if (mail($to, $subject, $htmlContent, $headers)) {
if (mail($to, $subject, $msg, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}


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
$query_dq = "SELECT tl_quotes.date as date, tl_quotes.quote as quote, tl_quotes.author as author, tl_quotes.html as html from tl_quotes where tl_quotes.date=CURDATE()";
$result_dq = mysqli_query($link, $query_dq) or die("Query failed");
$row_dq = mysqli_fetch_array($result_dq, MYSQLI_ASSOC);
$dq_count = empty($row_dq);
echo "test daily quote";
echo "<br>";

echo $dq_count;
echo "<br>";

echo "test daily quote";
echo "<br>";

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



