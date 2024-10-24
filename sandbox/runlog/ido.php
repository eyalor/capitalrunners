<?php
header('Access-Control-Allow-Origin: *');
require_once 'php/html_page_init.php';
require_once 'php/member_authentication.php';
require_once 'php/constants.php';
require_once 'php/utils.php';


// PHP function to be called
function myPhpFunction() {
    echo "PHP function called successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call PHP Function from Button</title>
</head>
<body>

    <!-- Create a form with a submit button -->
    <form method="POST">
        <button type="submit" name="call_function">Call PHP Function</button>
    </form>

    <?php
    // Check if the button was clicked
    if (isset($_POST['call_function'])) {
        // Call the PHP function when the button is clicked
        myPhpFunction();
    }
    ?>

</body>
</html>
