<?php
session_start();
echo $_SESSION['user_name'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
 <h2>this is only for registered user </h2>

<?php
echo $_SESSION['user_name'];
?>
</body>
</html>