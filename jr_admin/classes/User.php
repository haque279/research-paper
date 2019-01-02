<?php
    
class User{

    public function user_login($data){
        $user_email = $data['user_email'];
        $password = $data['user_password'];
        $sql = "SELECT user_password FROM tbl_user WHERE user_email='$user_email'  AND (user_access_level=1  OR user_access_level=0 ) ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $pass = $stmt2-> fetch(PDO::FETCH_ASSOC);
        $hashed_password = $pass['user_password'];
        if(password_verify($password, $hashed_password)) {
            $sql = "SELECT * FROM tbl_user WHERE user_email='$user_email'  AND (user_access_level=1  OR user_access_level=0 ) ";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $result = $stmt2-> fetch(PDO::FETCH_ASSOC);
            if($result){
                $_SESSION['user_name']=$result['user_name'];
                $_SESSION['user_id']=$result['user_id'];
                $_SESSION['user_email']=$result['user_email'];
                $_SESSION['user_access_level']=$result['user_access_level'];
                header("location: author.php");
            }else{

                header("location: not_confirm.php");
            }
        }

    }

//    pending user how can not upload anything

    public function user_login_pending($data){
        $user_email = $data['user_email'];
        $_SESSION['user_email']=$user_email;
        $sql = "SELECT * FROM tbl_user WHERE user_email='$user_email'  AND user_access_level=9 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetch(PDO::FETCH_ASSOC);
        if($result){
            $_SESSION['user_name_pending']=$result['user_name'];
            $_SESSION['user_id']=$result['user_id'];

            header('location:not_confirm.php');
        }
    }

    public function add_user($data){
    //echo 'hi';
    //echo '<pre>';print_r($data);exit();
        $password = $data['user_password'];
        if($password){
            if(strlen($password)<8){
                header('location: reg_not_confirm.php');
            }
            else{
                $user_password = password_hash($password, PASSWORD_DEFAULT);
                $user_name = $data['user_name'];
                $user_email = $data['user_email'];
                $user_address = $data['user_address'];
                $user_contact_no = $data['user_contact_no'];
                $sql = "SELECT * FROM tbl_user WHERE user_email='$user_email' ";
                $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                $stmt2->execute();
                $result = $stmt2-> fetchAll();
                if(!$result){

                    $stmt = DB::prepare("INSERT INTO tbl_user (user_name, user_email, user_password, user_address, user_contact_no, user_access_level) VALUES (?, ?, ?, ?, ?, ? )");  
                    $arr = array($user_name, $user_email, $user_password, $user_address, $user_contact_no, 0);

                    $result2 = $stmt->execute($arr);
                    if($result2){
                        $subject = "Bank Parikrama Account";
                        $txt = "Dear Author,"."<br>"."
Thanks for registration. You can now log in and submit your article(s). Do not include any type of author(s) details in the Article.";
                        $headers = "From: bibmresearch@bibm.org.bd";
                        mail($user_email,$subject,$txt,$headers);
                        header('location: reg_confirm.php');
                        //exit();
                    }


                } else {header('location: reg_not_confirm.php');}
            }
        } else { header('location: reg_not_confirm.php');}


    }



    public function view_user ($data){
        $user_email = $data['user_email'];
        $sql = "SELECT * FROM tbl_user WHERE user_email='$user_email' ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
    }


    public function send_feedback ($data){



//        $to = "bibmresearch@bibm.org.bd";
        $date = date('d-F-Y');
        $to = 'bibmresearch@bibm.org.bd'; // note the comma
        $name = $data['name'];
        $email = $data['email'];
        $message = $data['message'];

// Subject
        $subject = 'Feedback of Journal';

// Message
        $message = "
    <!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <title>Journal</title>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet'>
    <style>
        body {
            font-size: 14px;
            font-family: 'Ubuntu', sans-serif;
            color: #999
        }
        
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ddd;
            border: 2px solid #F0F0F0;
            border-radius: 2px
        }
        
        .divider {
            background: #fff;
            height: 0
        }
        
        .one_second {
            width: 50%;
            float: left;
        }
        
        .one {
            width: 100%;
            float: left;
        }
        
        .text {
            padding: 10px 30px;
            border-radius: 7px;
            background: #fff;
            overflow: hidden
        }
        
        .text img {
            border: 1px solid #e2e2e2;
            padding: 3px;
        }
        
        .wrapper_inner {
            overflow: hidden
        }
        
        .center {
            text-align: center
        }
        
        .pull_right {
            float: right
        }
        
        .date {
            font-size: 14px;
            font-weight: 500;
            color: #999;
            margin-top: 15px
        }
        
        .headline {
            font-size: 30px;
            color: #098CAC;
            font-weight: 700;
            margin: 10px 0
        }
        
        h2 {
            color: #2D519F;
        }
        
        .full {
            width: 100%
        }
        
        
        
        
        .divider {height: 20px; clear: both; background: #F0F0F0}
    </style>
</head>

<body>
    <div class='wrapper'>
        <div class='wrapper_inner'>
            <div class='one'>
                <div class='text'>
                    <div class='headline'>Feedback of Journal<span class='date pull_right'>$date</span></div>
                    <hr>
                    <div class='one_second'>
                        <p>Guest Name:</p>
                        <p>Guest Email:</p>
                        <p>Guest Message:</p>
                    </div>
                    <div class='one_second'>
                        <p>$name</p>
                        <p>$email</p>
                        <p>$message</p>
                    </div>
                </div>
            </div>
        </div>


      
    </div>
</body>

</html>
";

// To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
        $headers[] = 'To: Journal Bibm <bibmresearch@bibm.org.bd>, Kelly <bibmresearch@bibm.org.bd>';
        $headers[] = 'From:Journal BIBM <bibmresearch@bibm.org.bd>';
//        $headers[] = 'Cc: admin@gtrsystem.com';
//        $headers[] = 'Bcc: support@gtrsystem.com';

// Mail it

        mail($to, $subject, $message, implode("\r\n", $headers));
        $sms = "your feedback has been send";
        return $sms;


    }

}