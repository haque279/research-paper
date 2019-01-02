<?php
session_start();
include "DB.php";
class Dis {
    public function dis(){
        $user_id = $_GET['id'];

        $sql = "SELECT * FROM tbl_user WHERE user_id='$user_id' ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();


        $stmt = DB::prepare("UPDATE tbl_user SET user_access_level=2 WHERE user_id= $user_id ", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $stmt->execute();
        $subject = "Bank Parikrama Account";
        $txt = "Dear Author,"."\r\n"."
Sorry. Your Article has been disapproved. ";
        $headers = "From: bibmresearch@bibm.org.bd";
        $user_email = $_GET['email'];
        mail($user_email,$subject,$txt,$headers);
        $_SESSION['message']= "Disapproved the user";
        header('Location:../view_user.php');
    }
}
$obj_dis = new Dis();
$obj_dis->dis();