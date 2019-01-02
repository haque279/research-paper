<?php

spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
?>
<?php
    $obj_journal = new Journal();
    $result = $obj_journal->journal_view();
echo $result['journal_title'];

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
            <td>date</td>
            <td>journal</td>
        </tr>

        <?php foreach( $result as $res) { ?>

        <tr>
            <td><?php echo $res['journal_title']; ?></td>
            <td><a href="<?php echo $row['journal_file']["name"]; ?>" > journal</a></td>
            <td><a href="journal/<?php echo $row['journal_file']['name'] ?>" target="_blank">view file</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>