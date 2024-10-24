<?php
header('Access-Control-Allow-Origin: *');
require_once 'php/html_page_init.php';
require_once 'php/member_authentication.php';
require_once 'php/constants.php';
require_once 'php/utils.php';

// PHP function to handle the AJAX request
if (isset($_POST['ajax_request'])) {
    myPhpFunction();
    exit; // Stop further execution after handling the AJAX request
}

// Function to be called
function myPhpFunction() {
    echo "PHP function called via AJAX!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call PHP Function with AJAX</title>
    <script>
        function callPhpFunction() {
            // Create an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true); // Send POST request to the same PHP file
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Output the response from the PHP function
                    document.getElementById("result").innerHTML = xhr.responseText;
                }
            };
            // Send the AJAX request with a POST variable to trigger the PHP function
            xhr.send("ajax_request=true");
        }
    </script>
</head>
<body>

    <!-- Button to trigger the AJAX call -->
    <button type="button" onclick="callPhpFunction()">Call PHP Function via AJAX</button>

    <!-- Div to display the result from PHP -->
    <div id="result"></div>

</body>
</html>
