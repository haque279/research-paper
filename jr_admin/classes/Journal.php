<?php

class Journal{
    public function journal_upload($data, $files)
    {
        //print_r($data);exit();
        $check = filesize($files['journal_file']['tmp_name']);
        $directory = "jr_admin/journal/";
        $target_file = $directory . date('d-m-Y-h-i-s_') . $files['journal_file']['name'];
        $file_name = "journal/" . date('d-m-Y-h-i-s_') . $files['journal_file']['name'];
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
        $file_size = $files['journal_file']['size'];
        $check = filesize($files['journal_file']['tmp_name']);
        //echo $target_file;


        if (file_exists($target_file)) {
            $message = 'Sorry File already exists.';
            return $message;
            exit();
        } else {
            if ($file_size > 20000000) {
                $message = 'Sorry uour file Size is too large.';
                return $message;
//                    exit();
            } else {
                if ($file_type != 'docx' && $file_type != 'doc' ) {
                    $message = 'Sorry your file type is not valid.';
                    return $message;
                    exit();
                } else {
                    move_uploaded_file($files['journal_file']['tmp_name'], $target_file);
                    $date = date('Y-m-d');
                    $sql = "INSERT INTO tbl_journal
                        (journal_user_id,
                        journal_title, journal_file,
                        journal_date)
                        VALUES ('$data[journal_user_id]','$data[journal_title]',
                        '$file_name','$date' )";

                    $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

                    $query = $stmt->execute();

                    if ($query) {
                        $subject = "Bank Parikrama Account";
                        $txt = "Dear Author,"."  "."
Thanks for article submission. Article has been saved successfully. Your article is now under Preliminary Review Stage. Please wait for the feedback from BIBM.  ";
                        $headers = "From: bibmresearch@bibm.org.bd";
                        $user_email = $_SESSION['user_email'];
                        mail($user_email,$subject,$txt,$headers);

                        $subject = "Bank Parikrama Account";
                        $txt = "Dear Admin,"."\r\n"."
A new article has been submitted from Author. 
  "."\r\n"."Article Title: ".$data['journal_title']."\r\n"."Author Name: ".$_SESSION['user_name'];
                        $headers = "From: bibmresearch@bibm.org.bd";
                        $user_email ="bibmresearch@bibm.org.bd";
                        mail($user_email,$subject,$txt,$headers);


                        $_SESSION['message'] = " Article has been saved successfully. Now you can update your (Author) information by clicking Update Information button. You can add more authors. ";
                        header('location:author.php');


                    } else {

                    }

                }
            }
        }
    }
        

    public function journal_upload_update($data, $files) {
        $check = filesize($files['journal_file']['tmp_name']);
        $directory = "jr_admin/journal/";
        $target_file = $directory . date('d-m-Y-h-i-s_') . $files['journal_file']['name'];
        $target_file2 = $directory . date('d-m-Y-h-i-s_') . $files['modification_summary']['name'];
        $file_name = "journal/" . date('d-m-Y-h-i-s_') . $files['journal_file']['name'];
        $file_name2 = "journal/" . date('d-m-Y-h-i-s_') . $files['modification_summary']['name'];
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
        $file_type2 = pathinfo($target_file2, PATHINFO_EXTENSION);
        $file_size = $files['journal_file']['size'];
        $file_size2 = $files['modification_summary']['size'];
        $check = filesize($files['journal_file']['tmp_name']);
        $check2 = filesize($files['modification_summary']['tmp_name']);
        if ($check && $check2) {
            if (file_exists($target_file)) {
                $message = 'Sorry File already exists.';
                return $message;
                exit();
            } else {
                if ($file_size > 20000000 && $file_size2 > 20000000) {
                    $message = 'Sorry uour file Size is too large.';
                    return $message;
//                    exit();
                } else {
                    if ($file_type != 'docx' && $file_type != 'doc') {
                        $message =  'Sorry your file type is not valid.';
                        return $message;
                        exit();
                    }
                    elseif ($file_type2 != 'docx' && $file_type2 != 'doc') {
                        $message =  'Sorry your file type is not valid.';
                        return $message;
                        exit();
                    } else {
                        move_uploaded_file($files['journal_file']['tmp_name'], $target_file);
                        move_uploaded_file($files['modification_summary']['tmp_name'], $target_file2);
                        $date = date('Y-m-d');
                        $sql = "UPDATE tbl_journal set modified_journal_file='$file_name',modification_summary='$file_name2', journal_date='$date', journal_status='3', modification_status='1' WHERE journal_id='$data[journal_id]'  ";
//                        $sql = "INSERT INTO tbl_journal
//                        (journal_user_id,
//                        journal_title, journal_file,
//                        journal_date)
//                        VALUES ('$data[journal_user_id]','$data[journal_title]',
//                        '$target_file','$date' )";

                        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

                        $query = $stmt->execute();

                        if( $query ) {
                            $journal_id  = $data['journal_id'];
                            $date = date('Y-m-d H:i:s');
                            $sql = "UPDATE tbl_review_report set author_submission_date= '$date' WHERE journal_id='$data[journal_id]'  ";
                            $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                            $query = $stmt->execute();

                            $subject = "Bank Parikrama Account";
                            $txt = "Dear Author,"."  "."
Thanks for Modified article submission. Article has been saved successfully.  Please wait for the feedback from BIBM.  ";
                            $headers = "From: bibmresearch@bibm.org.bd";
                            $user_email = $_SESSION['user_email'];
                            mail($user_email,$subject,$txt,$headers);

                            $subject = "Bank Parikrama Account";
                            $txt = "Dear Admin,"."  "."
An Article has been modified by the author(s). Article No.: ".$journal_id;
                            $headers = "From: bibmresearch@bibm.org.bd";
                            $user_email ="bibmresearch@bibm.org.bd";
                            mail($user_email,$subject,$txt,$headers);

                            $_SESSION['message'] = " Article Update Successfully . ";
                            header('location:author.php');




                        } else {

                        }

                    }
                }
            }

        }
        else {
            $message = 'Sorry ! this is not an valid doc !';
            return $message;
            exit();
        }
    }

    public function journal_upload_update_two($data, $files) {
        $check = filesize($files['journal_file']['tmp_name']);
        $directory = "journal/";
        $target_file = $directory .date('d-m-Y-h-i-s_'). $files['journal_file']['name'];
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
        $file_size = $files['journal_file']['size'];
        $check = filesize($files['journal_file']['tmp_name']);
       
            if (file_exists($target_file)) {
                $message = 'Sorry File already exists.';
                return $message;
                exit();
            } else {
                if ($file_size > 20000000) {
                    $message = 'Sorry uour file Size is too large.';
                    return $message;
//                    exit();
                } else {
                    if ($file_type != 'docx' && $file_type != 'doc' && $file_type != 'pdf') {
                        $message =  'Sorry your file type is not valid.';
                        return $message;
                        exit();
                    } else {
                        move_uploaded_file($files['journal_file']['tmp_name'], $target_file);
                        $date = date('Y-m-d');
                        $sql = "UPDATE tbl_journal set journal_file='$target_file ', journal_date='$date', journal_status='55' WHERE journal_id='$data[journal_id]'  ";
//                        $sql = "INSERT INTO tbl_journal
//                        (journal_user_id,
//                        journal_title, journal_file,
//                        journal_date)
//                        VALUES ('$data[journal_user_id]','$data[journal_title]',
//                        '$target_file','$date' )";

                        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

                        $query = $stmt->execute();

                        if( $query ) {
                            $_SESSION['message'] = " Journal update Successfully . ";
                            header('location:author.php');




                        } else {

                        }

                    }
                }
            }

        
        
    }

    public function journal_view ($user){
        $sql = "SELECT j.*
        FROM tbl_journal as j
        INNER JOIN tbl_user as u on j.journal_user_id=u.user_id
        WHERE j.journal_user_id=$user
         AND ( j.journal_status= 0 OR
         j.journal_status= 1 OR
         j.journal_status= 2 OR
         j.journal_status= 3 OR
         j.journal_status= 4 OR
         j.journal_status= 5 OR
         j.journal_status= 6 OR
         j.journal_status= 7 OR
         j.journal_status= 8 OR
         j.journal_status= 9 OR
         j.journal_status= 10 OR
         j.journal_status= 11 OR
         j.journal_status= 12
         )";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }
    public function journal_modified_view ($user){
        $sql = "SELECT j.journal_file, j.journal_title, j.journal_id, j.journal_status
        FROM tbl_journal as j
        INNER JOIN tbl_user as u on j.journal_user_id=u.user_id
        WHERE j.journal_user_id=$user AND j.journal_status= 3 AND j.modification_status=99 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }
    public function journal_modified_view_two ($user){
        $sql = "SELECT j.journal_file, j.journal_title, j.journal_id, j.journal_status
        FROM tbl_journal as j
        INNER JOIN tbl_user as u on j.journal_user_id=u.user_id
        WHERE j.journal_user_id=$user AND (j.journal_status= 45 OR j.journal_status= 46)";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }


    public function add_additional_author($data){
        $journal_id = $data['additional_author_journal_id'];
        $user_id = $data['additional_author_name_user_id'];
        $user_name = $data['additional_author_name'];
        $user_position = $data['additional_author_position'];
        $user_contact_no = $data['additional_author_contact_no'];
        $user_email = $data['additional_author_email'];
        $user_tel = $data['additional_author_tel'];
        $user_fax = $data['additional_author_fax'];
        $user_web = $data['additional_author_web'];
        $user_skype = $data['additional_author_skype'];
        $user_institute = $data['additional_author_institute'];
        $user_address = $data['additional_author_address'];
        $user_country = $data['additional_author_country'];


        $sql = "INSERT INTO tbl_additional_author
(additional_author_journal_id,
additional_author_user_id,
additional_author_name, additional_author_position,
additional_author_contact_no, additional_author_email,
additional_author_tel, additional_author_fax, additional_author_web, additional_author_skype, additional_author_institute, additional_author_address, additional_author_country
)
 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $arr = array($journal_id, $user_id, $user_name, $user_position, $user_contact_no, $user_email,
                $user_tel, $user_fax, $user_web, $user_skype, $user_institute, $user_address, $user_country );

            $stmt->execute($arr);

        $_SESSION['message'] = "Information updated successfully.";
        header("location: author.php");

    }

    public function reviewer_report($journal_id){
        $sql = "SELECT * FROM tbl_review_report WHERE journal_id=$journal_id ORDER BY review_report_id DESC LIMIT 1 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function view_additional_author_all($journal_id){
        $sql = "SELECT * FROM tbl_additional_author WHERE additional_author_journal_id='$journal_id'  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }
    public function view_additional_author_by_id($id){
        $sql = "SELECT * FROM tbl_additional_author WHERE additional_author_id='$id' LIMIT 1 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function view_journal_by_author($id){
        $sql = "SELECT journal_id, journal_title FROM tbl_journal WHERE journal_user_id='$id'  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }




    public function update_author($data){
        $journal_id = $data['additional_author_journal_id'];
        $user_id = $data['additional_author_id'];
        $user_name = $data['additional_author_name'];
        $user_position = $data['additional_author_position'];
        $user_contact_no = $data['additional_author_contact_no'];
        $user_email = $data['additional_author_email'];
        $user_tel = $data['additional_author_tel'];
        $user_fax = $data['additional_author_fax'];
        $user_web = $data['additional_author_web'];
        $user_skype = $data['additional_author_skype'];
        $user_institute = $data['additional_author_institute'];
        $user_address = $data['additional_author_address'];
        $user_country = $data['additional_author_country'];

        $sql = "UPDATE tbl_additional_author SET 
additional_author_journal_id='$journal_id',
additional_author_name='$user_name',
additional_author_position='$user_position',
additional_author_contact_no='$user_contact_no',
additional_author_email='$user_email',
additional_author_tel='$user_tel',
additional_author_fax='$user_fax',
additional_author_web='$user_web',
additional_author_skype='$user_skype',
additional_author_institute='$user_institute',
additional_author_address='$user_address',
additional_author_country='$user_country' 
WHERE additional_author_id='$user_id'";



            $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

            $stmt->execute();

        $_SESSION['message'] = "Information updated successfully done";
        header("location: author.php");

    }

    public function view_additional_author($data){
        $sql = "SELECT * FROM tbl_additional_author WHERE additional_author_user_id='$data'  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function view_additional_author_email($data, $journal_id){
        $sql = "SELECT additional_author_email   FROM tbl_additional_author WHERE additional_author_user_id=$data AND additional_author_journal_id= $journal_id ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function journal_view_with_author($data){
        $sql = "SELECT * FROM tbl_additional_author AS a, tbl_journal AS j
        WHERE j.journal_id = a.additional_author_journal_id
        AND a.additional_author_user_id = j.journal_user_id
        AND  a.additional_author_user_id= $data ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

//    public function journal_mod_update($data){
//        $sql = "UPDATE tbl_journal SET journal_status = 1
//WHERE journal_id=$data";
//        $stmt = DB::prepare($sql);
//        $stmt->execute();
//
//    }

    public function view_user_by_id ($data){
        $sql = "SELECT * FROM tbl_user WHERE user_id='$data' ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }








}