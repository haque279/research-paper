<?php
session_start();
include "DB.php";

class App{
    public function app(){
        $user_id = $_GET['id'];

        $sql = "SELECT * FROM tbl_user WHERE user_id='$user_id' ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();


        $stmt = DB::prepare("UPDATE tbl_user SET user_access_level=1 WHERE user_id= $user_id ", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $stmt->execute();
        $subject = "Bank Parikrama Account";
        $txt = "Dear Author,"."<br>"."
Thank you for showing interest in publishing article in Bank Parikrama. Your ID is now approved. You can now login and check the status of your article(s). ";
        $headers = "From: bibmresearch@bibm.org.bd";
        $user_email = $_GET['email'];
        mail($user_email,$subject,$txt,$headers);
        $_SESSION['message']= "Approved the user";

        header('Location:../view_user.php');
    }
}

$obj_app = new App();
$obj_app->app();