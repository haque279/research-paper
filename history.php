<?php
session_start();
spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
?>
<?php

if(isset($_SESSION['user_name'])){
    echo  $user_id = $_SESSION['user_id'];
    echo "<hr>";
     $user_name = $_SESSION['user_name'];

}
$obj_history = new History();
$result = $obj_history->view_history($user_id);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <td>id</td>
            <td>journal</td>
            <td>date</td>
            <td>reviewer</td>
            <td>status</td>
            <td>comments</td>
        </tr>
        <?php foreach ($result as $res){ ?>
        <?php if ($res['journal_status']==11){ ?>
        <tr>
            <td><?php echo $res['user_id']; ?></td>
            <td><?php echo $res['journal_id']; ?></td>
            <td><?php echo $res['i_date']; ?></td>
            <td><?php echo $res['reviewer_id']; ?></td>
            <td><?php echo $res['journal_status']; ?></td>
            <td><?php echo $res['comments']; ?></td>
        </tr>
        <?php } ?>
        <?php } ?>
    </table>
</body>
</html>


