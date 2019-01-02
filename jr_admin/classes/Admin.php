<?php


class Admin {

    public function admin_login($data) {
        $admin_email = $data['admin_email'];
        $password = $data['admin_password'];
        $sql = "SELECT * FROM tbl_admin WHERE admin_email='$admin_email' AND admin_access_level=1 ";


        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);
        $rows = $stmt2->rowCount($result);
        if($rows){
            $hash = $result['admin_password'];
            if (password_verify($password, $hash)=='1') {
                $_SESSION['admin'] = $result['admin_name'];

                header('location:view_user.php');

            }else{
                return "Please try again";
            }}else{
            return "Please try again";
        }
    }

    public function reviewer_login($data) {
        $reviewer_email = $data['reviewer_email'];
        $reviewer_password = $data['reviewer_password'];
        $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_email= '$reviewer_email' ";


        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);
        $rows = $stmt2->rowCount($result);
        if($rows){
            $hash = $result['reviewer_password'];
            if (password_verify($reviewer_password, $hash)=='1') {
                $_SESSION['reviewer_id'] = $result['reviewer_id'];
                $_SESSION['reviewer_name'] = $result['reviewer_name'];
                $_SESSION['reviewer_email'] = $result['reviewer_email'];
                header('location:jr_admin/journal_review.php');
            }else{
                return "Please try again";
            }}else{
            return "Please try again";
        }

    }

    public function reviewer_change_password($data) {
        $reviewer_email = $data['reviewer_email'];
        $reviewer_password = $data['reviewer_password'];
        $new_password = $data['new_password'];
        $confirm_password = $data['confirm_password'];
        if ($new_password === $confirm_password){
            $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_email= '$reviewer_email' ";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $result = $stmt2->fetch(PDO::FETCH_ASSOC);
            $rows = $stmt2->rowCount($result);
            if($rows){
                $hash = $result['reviewer_password'];
                if (password_verify($reviewer_password, $hash)=='1') {
                    $reviewer_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql = "UPDATE tbl_reviewer SET reviewer_password='$reviewer_new_password' WHERE reviewer_email='$reviewer_email'";
                    $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                    $stmt2->execute();
                    return "<span style='color: green'>Password changed successfully</span>";
                }else{
                    return "Wrong Current Password";
                }}else{
                return "Wrong Current Password";
            }
        }else{
            return "Password does'nt match";
        }


    }



// public function reviewer_login($data){
//     $reviewer_email = $data['reviewer_email'];
//     $reviewer_password = md5($data['reviewer_password']);
//     $sql2 = "SELECT * FROM tbl_reviewer WHERE reviewer_email='$reviewer_email' AND reviewer_password='$reviewer_password' ";
//     $stmt3 = DB::prepare($sql2);
//     $stmt3->execute();
//     $result2 = $stmt3-> fetch(PDO::FETCH_ASSOC);
//     if($result2){
//        $_SESSION['reviewer']= $result['reviewer_name'];
//        $_SESSION['reviewer_id']= $result['reviewer_id'];
//
//         header('location:journal_review.php');
//     }else{
//
//          return "Please try again";
//
//     }
// }
//    Jannatun

    public function accepted_journal_info_by_id($journal_id) {
        $sql = "SELECT * FROM tbl_accepted_journal WHERE journal_id ='$journal_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        //echo "<pre>";
        //print_r($acc_info);exit();
        return $result;


    }

    public function articles_in_press() {
        $sql = "SELECT a.*, b.* from tbl_inpress_journal as a INNER JOIN tbl_journal as b on a.journal_id = b.journal_id ORDER BY a.id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        $i = 0;
        foreach ($result as $res) {
            $user_id = $res['journal_user_id'];
            $sql = "SELECT * FROM tbl_user WHERE user_id ='$user_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $user_info = $stmt2->fetch();
            $result[$i] = array_merge($res, $user_info);

            $i++;
        }

        return $result;
    }

    public function published_articles() {
        $sql = "SELECT a.*, b.* from tbl_published_journal as a INNER JOIN tbl_journal as b on a.journal_id = b.journal_id ORDER BY a.id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        $i = 0;
        foreach ($result as $res) {
            $user_id = $res['journal_user_id'];
            $sql = "SELECT * FROM tbl_user WHERE user_id ='$user_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $user_info = $stmt2->fetch();
            $journal_id = $res['journal_id'];
            $sql = "SELECT * FROM tbl_accepted_journal WHERE journal_id ='$journal_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $info = $stmt2->fetch();
            if ($info) {
                $result[$i] = array_merge($res, $user_info, $info);
            } else {
                $result[$i] = array_merge($res, $user_info);
            }
            $i++;
        }

        return $result;
    }
    public function save_inpress_details(){

    }
    public function update_inpress_details($data){
        $id = $data['id'];
        $issue_name = $data['issue_name'];
        $updated_at = strtotime(date("Y/m/d"));
        $sql = "UPDATE tbl_inpress_journal SET issue_name='$issue_name',updated_at='$updated_at' WHERE id='$id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
    }
    public function update_published_details($data){
        print_r($data);
        $id = $data['id'];
        $issue_name = $data['issue_name'];
        $published_year= date('Y-m-d H:i:s',strtotime(  $data['published_year']));
//        $published_year = $data['published_year'];
        $sql = "UPDATE tbl_published_journal SET issue_name='$issue_name',published_year='$published_year' WHERE id='$id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();

    }

    public function save_published_details($data) {
        $journal_id = $data['journal_id'];
        $issue_name = $data['issue_name'];
        $published_year = $data['published_year'];
        $created_at = strtotime(date("Y/m/d"));

        $sql = "INSERT INTO tbl_published_journal(journal_id,issue_name,published_year,created_at)"
            . "VALUES('$journal_id','$issue_name','$published_year','$created_at')";

        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
    }

    public function update_rejected_details($data) {

        $id = $data['id'];
        $rejected_date = strtotime($data['rejected_date']);
        $rejected_stage = $data['rejected_stage'];
        $details = $data['details'];

        $updated_at = strtotime(date("Y/m/d"));
        $sql = "UPDATE tbl_rejected_journal SET rejected_date='$rejected_date',rejected_stage='$rejected_stage',details='$details',updated_at='$updated_at' WHERE id='$id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
    }

    public function save_rejected_details($data) {

        $journal_id = $data['journal_id'];
        $rejected_date = strtotime($data['rejected_date']);
        $rejected_stage = $data['rejected_stage'];
        $details = $data['details'];
        //$acceptance_letter = $this->upload_file('acceptance_letter', $data);
        //$acceptance_letter = $data['acceptance_letter'];
        $created_at = strtotime(date("Y/m/d"));
        $sql = "INSERT INTO tbl_rejected_journal(journal_id,rejected_date,rejected_stage,details,created_at)"
            . "VALUES('$journal_id','$rejected_date','$rejected_stage','$details','$created_at')";

        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
    }

//    public function check_rejected_article_existance($journal_id) {
//        $sql = "SELECT * FROM tbl_rejected_journal WHERE journal_id='$journal_id'";
//        $stmt2 = DB::prepare($sql);
//        $stmt2->execute();
//        $result = $stmt2->fetch();
//        //print_r($result);exit();
//        return $result;
//    }

    public function rejected_articles() {
        $sql = "SELECT a.*, b.* from tbl_rejected_journal as a INNER JOIN tbl_journal as b on a.journal_id = b.journal_id ORDER BY a.id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        $i = 0;
        foreach ($result as $res) {
            $user_id = $res['journal_user_id'];
            $sql = "SELECT * FROM tbl_user WHERE user_id ='$user_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $user_info = $stmt2->fetch();
            $result[$i] = array_merge($res, $user_info);
            $i++;
        }

        return $result;
    }

    public function update_ec_meeting($data) {
        $id = $data['id'];
        $sql = "SELECT * FROM tbl_ec_meeting WHERE id='$id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $previous_info = $stmt2->fetch();

        $year = $data['year'];
        $no = $data['no'];
        $date = date('Y-m-d H:i:s', strtotime($data['date']));
        $minors = $this->upload_file('minors', $data);
        if ($minors == "") {
            $minors = $previous_info['minors'];
        }
        $details = $data['details'];
        $sql = "UPDATE tbl_ec_meeting SET year='$year',no='$no',date='$date',minors='$minors',details='$details' WHERE id='$id'";
        //echo $sql;exit();
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
    }

    public function journal_by_id($journal_id){
        $sql = "SELECT * FROM  tbl_journal WHERE journal_id='$journal_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_ec_meeting_info_by_id($id) {
        $sql = "SELECT * FROM tbl_ec_meeting WHERE id='$id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        //print_r($result);exit();
        return $result;
    }

    public function get_ec_meeting_info() {
        $sql = "SELECT * FROM tbl_ec_meeting ORDER BY id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        //print_r($result);exit();
        return $result;
    }

    public function add_new_meeting($data) {
        $year = $data['year'];
        $no = $data['no'];
        $date = strtotime($data['date']);
        $minors = $this->upload_file('minors', $data);
        $details = $data['details'];
        $created_at = strtotime(date("Y/m/d"));
        $sql = "INSERT INTO tbl_ec_meeting(year,no,date,minors,details,created_at)"
            . "VALUES('$year','$no','$date','$minors','$details','$created_at')";
        //echo $sql;exit();
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
    }

    public function update_acceptance_details($data, $file) {
        $sql = "SELECT * FROM tbl_accepted_journal WHERE journal_id='$data[journal_id]'";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
        $previous_info = $stmt->fetch();
        $accepted_journal_id = $data['accepted_journal_id'];
        $accepted_date = strtotime($data['accepted_date']);
        $acceptance_stage = $data['acceptance_stage'];
        $acceptance_letter = $this->upload_file('acceptance_letter', $file);
        if ($acceptance_letter == "") {
            $acceptance_letter = $previous_info['acceptance_letter'];
        }
//        $acceptance_letter = $file['acceptance_letter'];
        $updated_at = strtotime(date("Y/m/d"));


        $sql = "UPDATE tbl_accepted_journal SET accepted_date='$accepted_date',acceptance_stage='$acceptance_stage',acceptance_letter='$acceptance_letter',updated_at='$updated_at' WHERE accepted_journal_id='$accepted_journal_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
    }

    public function check_article_existance($data) {
        //print_r($data);exit();
        $journal_status = $data['journal_status'];
        $journal_id = $data['journal_id'];
        if ($journal_status == 6) {
            $sql = "SELECT * FROM tbl_accepted_journal WHERE journal_id='$journal_id'";
        } else if ($journal_status == 7) {
            $sql = "SELECT * FROM tbl_rejected_journal WHERE journal_id='$journal_id'";
        } else if ($journal_status == 8) {
            $sql = "SELECT * FROM tbl_published_journal WHERE journal_id='$journal_id'";
        } else if ($journal_status == 5) {
            $sql = "SELECT * FROM tbl_inpress_journal WHERE journal_id='$journal_id'";
        }
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        //print_r($result);exit();
        return $result;
    }

//    public function check_article_existance($journal_id){
//        $sql = "SELECT * FROM tbl_accepted_journal WHERE journal_id='$journal_id'";
//        $stmt2 = DB::prepare($sql);
//        $stmt2->execute();
//        $result = $stmt2->fetch();
//        //print_r($result);exit();
//        return $result;
//    }

    public function save_status_details($data) {
//        echo "<pre>";
//        print_r($data);
//        exit();
        $check = $this->check_article_existance($data);

        $journal_status = $data['journal_status'];
        $journal_id = $data['journal_id'];
        if ($journal_status == 6) {
            $accepted_date = strtotime($data['accepted_date']);
            $acceptance_stage = $data['acceptance_stage'];
            $acceptance_letter = $this->upload_file('acceptance_letter', $data);
            $created_at = strtotime(date("Y/m/d"));
            if (!$check) {
                $sql = "INSERT INTO tbl_accepted_journal(journal_id,accepted_date,acceptance_stage,acceptance_letter,created_at)"
                    . "VALUES('$journal_id','$accepted_date','$acceptance_stage','$acceptance_letter','$created_at')";
            } else {

                $updated_at = strtotime(date("Y/m/d"));
                $sql = "UPDATE tbl_accepted_journal SET accepted_date='$accepted_date',acceptance_stage='$acceptance_stage',acceptance_letter='$acceptance_letter',updated_at='$updated_at' WHERE accepted_journal_id='$check[accepted_journal_id]'";
            }

            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
        } else if ($journal_status == 7) {
            $rejected_date = strtotime($data['rejected_date']);
            $rejected_stage = $data['rejected_stage'];
            $created_at = strtotime(date("Y/m/d"));
            if (!$check) {
                $sql = "INSERT INTO tbl_rejected_journal(journal_id,rejected_date,rejected_stage,created_at)"
                    . "VALUES('$journal_id','$rejected_date','$rejected_stage','$created_at')";
            } else {
                $updated_at = strtotime(date("Y/m/d"));
                $sql = "UPDATE tbl_rejected_journal SET rejected_date='$rejected_date',rejected_stage='$rejected_stage',updated_at='$updated_at' WHERE id='$check[id]'";
            }
            //echo $sql;exit();
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
        } else if ($journal_status == 8) {
            $issue_name = $data['issue_name'];
            $published_year = $data['published_year'];
            $created_at = strtotime(date("Y/m/d"));
            if (!$check) {
                $sql = "INSERT INTO tbl_published_journal(journal_id,issue_name,published_year,created_at)"
                    . "VALUES('$journal_id','$issue_name','$published_year','$created_at')";
            } else {
                $updated_at = strtotime(date("Y/m/d"));
                $sql = "UPDATE tbl_published_journal SET issue_name='$issue_name',published_year='$published_year',updated_at='$updated_at' WHERE id='$check[id]'";
            }
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
        } else if ($journal_status == 5) {

            $issue_name = $data['issue_name'];
            $created_at = strtotime(date("Y/m/d"));
            if (!$check) {
                $sql = "INSERT INTO tbl_inpress_journal(journal_id,issue_name,created_at)"
                    . "VALUES('$journal_id','$issue_name','$created_at')";
            } else {
                $id = $check['id'];
                $updated_at = strtotime(date("Y/m/d"));
                $sql = "UPDATE tbl_inpress_journal SET issue_name='$issue_name',updated_at='$updated_at' WHERE id='$id'";
            }
            //echo $sql;exit();
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
        }
    }

    public function save_acceptance_details($data) {
        $journal_id = $data['journal_id'];
        $accepted_date = strtotime($data['accepted_date']);
        $acceptance_stage = $data['acceptance_stage'];
        $acceptance_letter = $this->upload_file('acceptance_letter', $data);
        //$acceptance_letter = $data['acceptance_letter'];
        $created_at = strtotime(date("Y/m/d"));
        $sql = "INSERT INTO tbl_accepted_journal(journal_id,accepted_date,acceptance_stage,acceptance_letter,created_at)"
            . "VALUES('$journal_id','$accepted_date','$acceptance_stage','$acceptance_letter','$created_at')";

        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
    }

    public function accepted_articles() {
        $sql = "SELECT a.*, b.* from tbl_accepted_journal as a INNER JOIN tbl_journal as b on a.journal_id = b.journal_id ORDER BY a.accepted_journal_id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        $i = 0;
        foreach ($result as $res) {
            $user_id = $res['journal_user_id'];
            $sql = "SELECT * FROM tbl_user WHERE user_id ='$user_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $user_info = $stmt2->fetch();
            $result[$i] = array_merge($res, $user_info);
            $i++;
        }

        return $result;
    }

    public function publishable_articles() {
        $sql = "SELECT a.*, b.* from tbl_publishable_journal as a INNER JOIN tbl_journal as b on a.journal_id = b.journal_id ORDER BY a.id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        $i = 0;
        foreach ($result as $res) {
            $user_id = $res['journal_user_id'];
            $sql = "SELECT * FROM tbl_user WHERE user_id ='$user_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $user_info = $stmt2->fetch();
            $result[$i] = array_merge($res, $user_info);
            $i++;
        }

        return $result;
    }

    public function update_verification_status($data) {
        $sql = "UPDATE tbl_journal_verification set status='$data[status]' WHERE verification_id='$data[verification_id]'";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $assign = $stmt->execute();
        return $assign;
    }

    public function update_verification_info($data) {
        $verification_id = $data['verification_id'];
        $verified_by = $data['verified_by'];
        $verifier_details = $data['verifier_details'];
        $sent_date = strtotime($data['sent_date']);
        $submission_due_date = strtotime($data['submission_due_date']);
        $submission_date = strtotime($data['submission_date']);
        $status = $data['status'];
        $updated_at = strtotime(date("Y/m/d"));

        $sql = "UPDATE tbl_journal_verification set verified_by='$verified_by',verifier_details='$verifier_details',sent_date='$sent_date',submission_due_date='$submission_due_date',"
            . "submission_date='$submission_date',status='$status',updated_at='$updated_at' WHERE verification_id='$verification_id'";
        //echo $sql;exit();
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
    }

    public function get_verification_info_by_verification_id($verification_id) {
        $sql = "SELECT * FROM tbl_journal_verification WHERE verification_id='$verification_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        return $result;
    }

    public function get_verification_info_by_journal_id($journal_id) {
        $sql = "SELECT * FROM tbl_journal_verification WHERE journal_id='$journal_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function add_verification_info($data) {

        $journal_id = $data['journal_id'];
        $verified_by = $data['verified_by'];
        $verifier_details = $data['verifier_details'];
        $sent_date = date('Y-m-d H:i:s',strtotime($data['sent_date']));
        $submission_due_date = date('Y-m-d H:i:s',strtotime($data['submission_due_date']));
        $submission_date = date('Y-m-d H:i:s',strtotime($data['submission_date']));
        $status = $data['status'];
        $sql = "INSERT INTO tbl_journal_verification(journal_id,verified_by,verifier_details,sent_date,submission_due_date,submission_date,status)"
            . "VALUES('$journal_id','$verified_by','$verifier_details','$sent_date','$submission_due_date','$submission_date','$status')";

        //echo $sql;exit();
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $query = $stmt2->execute();
        if ($query){
            $sql = "UPDATE tbl_journal set modification_status= '$status' WHERE journal_id='$journal_id'  ";
            $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt->execute();
        }
    }

    public function under_verification_articles() {
        $sql = "SELECT a.*, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id  WHERE a.journal_status=4 ORDER BY a.journal_id DESC  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        //print_r($result);exit();
        return $result;
    }

    public function update_review_report_info($data) {
        //echo "<pre>";
        //print_r($data);exit();
        $review_report_id = $data['review_report_id'];
        $reviewer_type = $data['reviewer_type'];
        $sql = "SELECT * FROM tbl_review_report WHERE review_report_id='$review_report_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $previous_info = $stmt2->fetch();
        $reviewer_review_report = $this->upload_file('reviewer_review_report', $data);
        $reviewer_review_paper = $this->upload_file('reviewer_review_paper', $data);
        $author_review_report = $this->upload_file('author_review_report', $data);
        $author_review_paper = $this->upload_file('author_review_paper', $data);
        if ($reviewer_review_report == "") {
            $reviewer_review_report = $previous_info['reviewer_review_report'];
        }
        if ($reviewer_review_paper == "") {
            $reviewer_review_paper = $previous_info['reviewer_review_paper'];
        }
        if ($author_review_report == "") {
            $author_review_report = $previous_info['author_review_report'];
        }
        if ($author_review_paper == "") {
            $author_review_paper = $previous_info['author_review_paper'];
        }
        $reviewer_sent_date = strtotime($data['reviewer_sent_date']);
        $reviewer_submission_due_date = strtotime($data['reviewer_submission_due_date']);
        $reviewer_submission_date = strtotime($data['reviewer_submission_date']);
        $author_sent_date = strtotime($data['author_sent_date']);
        $author_submission_due_date = strtotime($data['author_submission_due_date']);
        $author_submission_date = strtotime($data['author_submission_date']);
        $updated_at = strtotime(date("Y/m/d"));
        $update_sql = "UPDATE tbl_review_report SET reviewer_type='$reviewer_type',reviewer_review_report='$reviewer_review_report',reviewer_review_paper='$reviewer_review_paper',reviewer_sent_date='$reviewer_sent_date',reviewer_submission_due_date='$reviewer_submission_due_date',reviewer_submission_date='$reviewer_submission_date',"
            . "author_review_report='$author_review_report',author_review_paper='$author_review_paper',author_sent_date='$author_sent_date',author_submission_due_date='$author_submission_due_date',author_submission_date='$author_submission_date',updated_at='$updated_at' WHERE review_report_id='$review_report_id'";
        //echo $update_sql;exit();
        $stmt = DB::prepare($update_sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $assign = $stmt->execute();
    }

    public function get_review_report_info_by_id($review_report_id) {
        $sql = "SELECT * FROM tbl_review_report WHERE review_report_id='$review_report_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        return $result;
    }

    public function update_modification_status($data) {
        $sql = "UPDATE tbl_review_report set status='$data[status]' WHERE review_report_id='$data[review_report_id]'";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $assign = $stmt->execute();
        return $assign;
    }

    public function get_review_files_by_journal_id($journal_id) {
        $sql = "SELECT * FROM tbl_review_report WHERE journal_id='$journal_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function upload_file($filename, $data) {
        $allowedExts = array("pdf", "doc", "docx", "PDF", "DOC", "DOCX");
        $extension = end(explode(".", $_FILES[$filename]["name"]));
        if (($_FILES[$filename]["type"] == "application/pdf") || ($_FILES[$filename]["type"] == "application/msword") || ($_FILES[$filename]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($_FILES[$filename]["size"] < 20000000) && in_array($extension, $allowedExts)) {

            if ($_FILES[$filename]["error"] > 0) {
                echo "Return Code: " . $_FILES[$filename]["error"] . "<br>";
            } else {
                $target_file = basename($_FILES[$filename]["name"]);
                $split = array_shift(explode('.', $target_file)) . time() . "." . $extension;

                if (move_uploaded_file($_FILES[$filename]["tmp_name"], "review_files/" . $split)) {
                    return $split;
                    //$sql = "UPDATE tbl_reviewer_assign set review_report='$target_file' WHERE reviewer_assign_id= '$data[reviewer_assign_id]' ";
                    //$stmt = DB::prepare($sql);
                    //$assign = $stmt->execute();
                    //$_SESSION['message'] = "File Successfully Uploaded.";
                }
            }
        }
    }

    public function add_modification($data, $file) {
        $journal_id = $data['journal_id'];
//        print_r($_POST);
//        echo "<hr>";
//        print_r($_FILES);
//        exit;
        //Files Upload
        $reviewer_review_report_1 = $this->upload_file('reviewer_review_report_1', $file);
        $reviewer_review_paper_1 = $this->upload_file('reviewer_review_paper_1', $file);

        $reviewer_review_report_2 = $this->upload_file('reviewer_review_report_2', $file);
        $reviewer_review_paper_2 = $this->upload_file('reviewer_review_paper_2', $file);

        $reviewer_review_report_3 = $this->upload_file('reviewer_review_report_3', $file);
        $reviewer_review_paper_3 = $this->upload_file('reviewer_review_paper_3', $file);


        // END
//        echo "<pre>";
//        print_r($data);exit();
        $reviewer_sent_date= date('Y-m-d H:i:s',strtotime($data['reviewer_sent_date']));
        $reviewer_submission_due_date= date('Y-m-d H:i:s',strtotime($data['reviewer_submission_due_date']));
        $reviewer_submission_date= date('Y-m-d H:i:s',strtotime($data['reviewer_submission_date']));
        $sql = "INSERT INTO tbl_review_report(journal_id,
reviewer_review_report_1, reviewer_review_paper_1,
reviewer_review_report_2, reviewer_review_paper_2,
reviewer_review_report_3, reviewer_review_paper_3,
reviewer_sent_date,reviewer_submission_due_date,reviewer_submission_date)
VALUES('$journal_id',
'$reviewer_review_report_1','$reviewer_review_paper_1',
'$reviewer_review_report_2','$reviewer_review_paper_2',
'$reviewer_review_report_3','$reviewer_review_paper_3',
'$reviewer_sent_date','$reviewer_submission_due_date','$reviewer_submission_date') ";

        //echo $sql;
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
        //$_SESSION['message'] = "Information Successfully Saved.";
    }

    public function change_modification_status($journal_id){
        $sql = " UPDATE tbl_journal set modification_status='99' WHERE journal_id= $journal_id  ";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
    }

    public function display_modification_report($journal_id) {
        $sql = "SELECT * FROM tbl_review_report  WHERE journal_id='$journal_id' ORDER BY review_report_id DESC LIMIT 1 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function under_modification_journal_info_by_id($journal_id) {
        $sql = "SELECT a.*, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id WHERE a.journal_id='$journal_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        $sql = "SELECT * FROM tbl_reviewer_assign WHERE journal_id='$journal_id' and reviewer_type=1";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $reviewer_1_assign_info = $stmt2->fetch();
        // Reviewer 2
        $sql = "SELECT * FROM tbl_reviewer_assign WHERE journal_id='$journal_id' and reviewer_type=2";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $reviewer_2_assign_info = $stmt2->fetch();
        // Reviewer3
        $sql = "SELECT * FROM tbl_reviewer_assign WHERE journal_id='$journal_id' and reviewer_type=3";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $reviewer_3_assign_info = $stmt2->fetch();
        // END
        if ($reviewer_1_assign_info) {
            $reviewer_id = $reviewer_1_assign_info['reviewer_id'];
            $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_id='$reviewer_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $reviewer_1_info = $stmt2->fetch();
            $result['reviewer_1_id'] = $reviewer_1_info['reviewer_id'];
            $result['reviewer_1_name'] = $reviewer_1_info['reviewer_name'];
            $result['reviewer_1_assign_id'] = $reviewer_1_assign_info['reviewer_assign_id'];
        } else {
            $result['reviewer_1_id'] = '';
            $result['reviewer_1_name'] = '';
            $result['reviewer_1_assign_id'] = '';
        }
        if ($reviewer_2_assign_info) {
            $reviewer_id = $reviewer_2_assign_info['reviewer_id'];
            $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_id='$reviewer_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $reviewer_2_info = $stmt2->fetch();
            $result['reviewer_2_id'] = $reviewer_2_info['reviewer_id'];
            $result['reviewer_2_name'] = $reviewer_2_info['reviewer_name'];
            $result['reviewer_2_assign_id'] = $reviewer_2_assign_info['reviewer_assign_id'];
        } else {
            $result['reviewer_2_id'] = '';
            $result['reviewer_2_name'] = '';
            $result['reviewer_2_assign_id'] = $reviewer_2_assign_info['reviewer_assign_id'];
        }

        if ($reviewer_3_assign_info) {
            $reviewer_id = $reviewer_3_assign_info['reviewer_id'];
            $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_id='$reviewer_id'";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $reviewer_3_info = $stmt2->fetch();
            $result['reviewer_3_id'] = $reviewer_3_info['reviewer_id'];
            $result['reviewer_3_name'] = $reviewer_3_info['reviewer_name'];
            $result['reviewer_3_assign_id'] = $reviewer_3_assign_info['reviewer_assign_id'];
        } else {
            $result['reviewer_3_id'] = '';
            $result['reviewer_3_name'] = '';
            $result['reviewer_3_assign_id'] = $reviewer_3_assign_info['reviewer_assign_id'];
        }
//        echo '<pre>';
//        print_r($result);
//        exit();
        return $result;
    }

    public function save_submission_date($data) {
        $submission_date = $data['submitted_on'];
        $submission_date_timestamp = strtotime($submission_date);
        $sql = "UPDATE tbl_reviewer_assign set submission_date='$submission_date_timestamp' WHERE reviewer_assign_id= '$data[reviewer_assign_id]' ";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $assign = $stmt->execute();
    }

    public function under_modification_articles() {
        $sql = "SELECT a.*, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id WHERE a.journal_status=3 ORDER BY a.journal_id DESC  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        //print_r($result);exit();
        return $result;
    }

    public function update_honorarium_info($data) {
        $sent_date = $data['sent_date'];
        $sent_date_timestamp = strtotime($sent_date);
        if ($sent_date == "") {
            $sql = "UPDATE tbl_reviewer_assign set honorarium_status='$data[honorarium_status]',honorarium_sent_date='' WHERE reviewer_assign_id= '$data[reviewer_assign_id] ";
        } else {
            $sql = "UPDATE tbl_reviewer_assign set honorarium_status='$data[honorarium_status]',honorarium_sent_date='$sent_date_timestamp' WHERE reviewer_assign_id= '$data[reviewer_assign_id]' ";
        }
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $assign = $stmt->execute();
    }

    public function upload_review_report($data, $journal_status) {

        $allowedExts = array("pdf", "doc", "docx", "PDF", "DOC", "DOCX");
        $extension = end(explode(".", $_FILES["review_report"]["name"]));
        if (($_FILES["review_report"]["type"] == "application/pdf") || ($_FILES["review_report"]["type"] == "application/msword") || ($_FILES["review_report"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($_FILES["review_report"]["size"] < 20000000) && in_array($extension, $allowedExts)) {

            if ($_FILES["review_report"]["error"] > 0) {
                echo "Return Code: " . $_FILES["review_report"]["error"] . "<br>";
            } else {
                $target_file = basename($_FILES["review_report"]["name"]);
                $split = array_shift(explode('.', $target_file)) . time() . "." . $extension;

                if (move_uploaded_file($_FILES["review_report"]["tmp_name"], "review_files/" . $split)) {

                    $sql = "UPDATE tbl_reviewer_assign set review_report='$split' WHERE reviewer_assign_id= '$data[reviewer_assign_id]' ";
                    $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

                    $assign = $stmt->execute();
                    $_SESSION['message'] = "File Successfully Uploaded.";
                }
            }
        }
    }

    public function upload_review_paper($data, $journal_status) {

        $allowedExts = array("pdf", "doc", "docx", "PDF", "DOC", "DOCX");
        $extension = end(explode(".", $_FILES["review_paper"]["name"]));
        if (($_FILES["review_paper"]["type"] == "application/pdf") || ($_FILES["review_paper"]["type"] == "application/msword") || ($_FILES["review_paper"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($_FILES["review_paper"]["size"] < 20000000) && in_array($extension, $allowedExts)) {

            if ($_FILES["review_paper"]["error"] > 0) {
                echo "Return Code: " . $_FILES["review_paper"]["error"] . "<br>";
            } else {
                $target_file = basename($_FILES["review_paper"]["name"]);
                $split = array_shift(explode('.', $target_file)) . time() . "." . $extension;

                if (move_uploaded_file($_FILES["review_paper"]["tmp_name"], "review_files/" . $split)) {

                    $sql = "UPDATE tbl_reviewer_assign set review_paper='$split' WHERE reviewer_assign_id= '$data[reviewer_assign_id]' ";
                    $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

                    $assign = $stmt->execute();
                    $_SESSION['message'] = "File Successfully Uploaded.";
                }
            }
        }
    }

    public function update_comment($data) {
        $sql = "UPDATE tbl_reviewer_assign set comment='$data[comment]' WHERE reviewer_assign_id= '$data[reviewer_assign_id]' ";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $assign = $stmt->execute();
    }

    public function reviewer_assign_info_by_id($journal_id, $reviewer_type) {
        $sql = "SELECT a.*,b.* FROM tbl_reviewer_assign as a INNER JOIN tbl_reviewer as b on a.reviewer_id = b.reviewer_id WHERE a.journal_id='$journal_id' and a.reviewer_type='$reviewer_type'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        return $result;
    }

    public function journal_user_info_by_id($journal_id) {
        $sql = "SELECT a.*,b.* FROM tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id WHERE journal_id='$journal_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        return $result;
    }

    public function journal_info_by_id($journal_id) {
        $sql = "SELECT * FROM tbl_journal WHERE journal_id='$journal_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetch();
        return $result;
    }

    public function view_user_new() {
        // $sql = "SELECT a.journal_file, a.journal_date, a.journal_file, a.journal_title, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id";
        //  $sql = "SELECT a.journal_file, a.journal_date, a.journal_file, a.journal_title, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id ";


        $sql = "SELECT * FROM tbl_user ORDER BY user_id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        //echo "<pre>";
        //print_r($result);exit();
        return $result;
    }


    public function approved_user() {
        $sql = "SELECT * FROM tbl_user WHERE user_access_level=1";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }
    public function disapproved_user() {
        $sql = "SELECT * FROM tbl_user WHERE user_access_level=2";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }
    public function pending_user() {
        $sql = "SELECT * FROM tbl_user WHERE user_access_level=0";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function view_user_journal($id) {
        // $sql = "SELECT a.journal_file, a.journal_date, a.journal_file, a.journal_title, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id";
        $sql = "SELECT journal_file, journal_date, journal_file, journal_title from tbl_journal WHERE journal_user_id=$id";


        // $sql = "SELECT * FROM tbl_user";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        //echo "<pre>";
        //print_r($result);exit();
        return $result;
    }

    public function fact_sheet() {
        //$sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND j.journal_status= 0 ";
        $sql = "SELECT a.*, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id WHERE b.user_access_level=1 ORDER BY a.journal_id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function view_additional_user($id) {
        $sql = "SELECT additional_author_name from tbl_additional_author WHERE additional_author_journal_id=$id";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function save_status($data) {
        $journal_status = $data['journal_status'];
        $journal_id = $data['journal_id'];
        $sql = "UPDATE tbl_journal set journal_status='$journal_status' WHERE journal_id= '$data[journal_id]' ";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $assign = $stmt->execute();

        if ($journal_status==5){
            $stmt3 = DB::prepare("SELECT journal_title FROM tbl_journal WHERE journal_id = '$journal_id' ");
            $stmt3->execute();
            $j_titles = $stmt3->fetchAll();
            foreach ($j_titles as $j_title){
                $j_title = $j_title['journal_title'];
            }

            $stmt = DB::prepare("INSERT INTO tbl_inpress_journal (journal_id, issue_name) VALUES (?, ?)");
            $arr = array($journal_id, $j_title);

            $stmt->execute($arr);
        }

        if ($journal_status==6){
            $stmt3 = DB::prepare("SELECT journal_id FROM tbl_accepted_journal WHERE journal_id = '$journal_id'  LIMIT 1  ");
            $stmt3->execute();
            $ext = $stmt3->fetchAll();
            if (empty($ext)){
                $stmt = DB::prepare("INSERT INTO tbl_accepted_journal (journal_id) VALUES (?)");
                $arr = array($journal_id);
                $stmt->execute($arr);
            }
        }

        if ($journal_status==7){
            $stmt3 = DB::prepare("SELECT journal_id FROM tbl_rejected_journal WHERE journal_id = '$journal_id' LIMIT 1  ");
            $stmt3->execute();
            $ext = $stmt3->fetchAll();
            if (empty($ext)) {
                $stmt = DB::prepare("INSERT INTO tbl_rejected_journal (journal_id) VALUES (?)");
                $arr = array($journal_id);
                $stmt->execute($arr);
            }
        }

        if ($journal_status==8){
            $stmt3 = DB::prepare("SELECT journal_id FROM tbl_published_journal WHERE journal_id = '$journal_id' LIMIT 1  ");
            $stmt3->execute();
            $ext = $stmt3->fetchAll();
            if (empty($ext)) {
                $stmt = DB::prepare("INSERT INTO tbl_published_journal (journal_id) VALUES (?)");
                $arr = array($journal_id);
                $stmt->execute($arr);
            }
        }

        if ($journal_status==9){
            $stmt3 = DB::prepare("SELECT journal_id FROM tbl_publishable_journal WHERE journal_id = '$journal_id' LIMIT 1 ");
            $stmt3->execute();
            $ext = $stmt3->fetchAll();
            if (empty($ext)) {
                $stmt = DB::prepare("INSERT INTO tbl_publishable_journal (journal_id) VALUES (?)");
                $arr = array($journal_id);
                $stmt->execute($arr);
            }
        }

        if ($journal_status==10){
            $stmt3 = DB::prepare("SELECT journal_id FROM tbl_ec_meeting WHERE journal_id = '$journal_id' LIMIT 1 ");
            $stmt3->execute();
            $ext = $stmt3->fetchAll();
            if (empty($ext)) {
                $stmt = DB::prepare("INSERT INTO tbl_ec_meeting (journal_id) VALUES (?)");
                $arr = array($journal_id);
                $stmt->execute($arr);
            }
        }
    }

    public function save_preliminary_review_status($data) {
        $journal_status = $data['journal_preliminary_review_status'];
        $journal_id = $data['journal_id'];
        $sql = "UPDATE tbl_journal set journal_preliminary_review_status='$journal_status' WHERE journal_id= '$data[journal_id]' ";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $assign = $stmt->execute();
    }

    public function save_final_status($data) {
        $journal_status = $data['journal_final_review_status'];
        $journal_id = $data['journal_id'];
        $sql = "UPDATE tbl_journal set journal_final_review_status='$journal_status' WHERE journal_id= '$data[journal_id]' ";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $assign = $stmt->execute();
    }

    public function preliminary_review() {
        $sql = "SELECT a.*, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id WHERE a.journal_status=1 ORDER BY journal_id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        //print_r($result);exit();
        return $result;
    }

    public function final_review($journal_id = NULL) {
        if ($journal_id == NULL) {
            $sql = "SELECT a.*, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id WHERE journal_status=2  ORDER BY journal_id DESC  ";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $result = $stmt2->fetchAll();
        } else {
            $sql = "SELECT a.*, b.* from tbl_journal as a INNER JOIN tbl_user as b on a.journal_user_id = b.user_id WHERE a.journal_id='$journal_id'  ORDER BY journal_id DESC ";
            $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt2->execute();
            $result = $stmt2->fetchAll();
        }
        //print_r($result);exit();
        return $result;
    }

    public function update_reviewer($data) {
        $reviewer_id = $data['reviewer_id'];
        $reviewer = explode('|', $data['reviewer_id']);
        //print_r($data);exit();
//        $reviewer_id = $reviewer[0];
        $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_id='$reviewer_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $reviewer_info = $stmt2->fetch();
        //print_r($reviewer_info);exit();
        $reviewer_email = $reviewer_info['reviewer_email'];
        $journal_id = $data['journal_id'];
        //echo $journal_id;exit();
        $reviewer_type = $data['reviewer_type'];
        //$reviewer_id = $data['reviewer_id'];
        $assign_date = strtotime("now");
        $submission_due_date = strtotime($data['submission_due_date']);
        $comment = '';
        $honorarium_status = '';
        $honorarium_sent_date = '';
        if ($reviewer_type == 1) {
            $update_sql = "UPDATE tbl_journal set journal_reviewer1_assign_status=22, journal_reviewer_id=$reviewer_id WHERE journal_id= '$data[journal_id]' ";
        } else if ($reviewer_type == 2) {
            $update_sql = "UPDATE tbl_journal set journal_reviewer2_assign_status=2 WHERE journal_id= '$data[journal_id]' ";
        } else if ($reviewer_type == 3) {
            $update_sql = "UPDATE tbl_journal set journal_reviewer3_assign_status=2 WHERE journal_id= '$data[journal_id]' ";
        }
        $stmt = DB::prepare($update_sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $update = $stmt->execute();
        $sql = "UPDATE tbl_reviewer_assign SET reviewer_id='$reviewer_id',submission_due_date='$submission_due_date',assign_date='$assign_date' WHERE reviewer_assign_id='$data[reviewer_assign_id]'";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $assign = $stmt->execute();
        if ($assign) {
            //echo "hello";exit();
            //        send to history
            $status = 1;
            $id = $data['journal_id'];
            $i_date = strtotime(date('Y-m-d'));
            $data['due_date'] = $i_date;
            $data['comments'] = "";
            $r_link = "<a href='http://journal.bibm.org.bd/reviewer.php'>Login</a>";
            $sql = "INSERT INTO history (user_id, journal_id, i_date, due_date, journal_history_status, reviewer_id, comments)
VALUE ('$data[user_id]', '$id',
 '$i_date', '$submission_due_date', '$status',
  '$reviewer_id', '$data[comments]' )";
            $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt->execute();
            $subject = "Bank Parikrama Account";
//            $txt = "Dear Reviewer, "."<br>"."
//The Editorial Board of the Bank Parikrama, the quarterly Journal of BIBM, would request you to be the referee of an article. Please Log in to our Journal website through following link".$r_link;
            $txt = "Dear Reviewer, "."<br>"."
The Editorial Board of the Bank Parikrama, the quarterly Journal of BIBM, would request you to be the referee of an article.";
            $headers = "From: bibmresearch@bibm.org.bd";
            mail($reviewer_email, $subject, $txt, $headers);
            $message = "journal assign";
            return $message;
        }
    }

    public function journal_assign_to_reviewer_1($data) {

        $reviewer = explode('|', $data['reviewer_id']);
        //print_r($data);exit();
//        $reviewer_id = $reviewer[0];
        $reviewer_id = $data['reviewer_id'];
        $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_id='$reviewer_id'";
        $stmt2 = DB::prepare($sql);
        $stmt2->execute();
        $reviewer_info = $stmt2->fetch();
        //print_r($reviewer_info);exit();
        $reviewer_email = $reviewer_info['reviewer_email'];

        $sql = "UPDATE tbl_journal set journal_reviewer1_id='$reviewer_id' WHERE journal_id= '$data[journal_id]' ";
        $stmt = DB::prepare($sql);

        $assign = $stmt->execute();
        if ($assign) {
            //        send to history
            $status = 1;
            $id = $data['journal_id'];
            $i_date = date('Y-m-d');
            $data['due_date'] = $i_date;
            $data['comments'] = "";
            $sql = "INSERT INTO history (user_id, journal_id, i_date, due_date, journal_history_status, reviewer_id, comments)
VALUE ('$data[user_id]', '$id',
 '$i_date', '$data[due_date]', '$status',
  '$reviewer_id', '$data[comments]' )";
            $stmt = DB::prepare($sql);
            $stmt->execute();
            $subject = "Bank Parikrama Account";
            $txt = " One journal assigned to you. Please login website and review the journal " . "Due Date: " . $data['due_date'];
            $headers = "From: research@bibm.org.bd";
            mail($reviewer_email, $subject, $txt, $headers);
            $message = "journal assign";
            return $message;
        }
    }

    public function journal_assign_to_reviewer_2($data) {
        $reviewer = explode('|', $data['reviewer_id']);
        //print_r($data);exit();
        $reviewer_id = $reviewer[0];
        $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_id='$reviewer_id'";
        $stmt2 = DB::prepare($sql);
        $stmt2->execute();
        $reviewer_info = $stmt2->fetch();
        //print_r($reviewer_info);exit();
        $reviewer_email = $reviewer_info['reviewer_email'];

        $sql = "UPDATE tbl_journal set journal_reviewer2_id='$reviewer_id' WHERE journal_id= '$data[journal_id]' ";
        $stmt = DB::prepare($sql);

        $assign = $stmt->execute();
        if ($assign) {
            //        send to history
            $status = 1;
            $id = $data['journal_id'];
            $i_date = date('Y-m-d');
            $data['due_date'] = $i_date;
            $data['comments'] = "";
            $sql = "INSERT INTO history (user_id, journal_id, i_date, due_date, journal_history_status, reviewer_id, comments)
VALUE ('$data[user_id]', '$id',
 '$i_date', '$data[due_date]', '$status',
  '$reviewer_id', '$data[comments]' )";
            $stmt = DB::prepare($sql);
            $stmt->execute();
            $subject = "Bank Parikrama Account";
            $txt = " One journal assigned to you. Please login website and review the journal " . "Due Date: " . $data['due_date'];
            $headers = "From: research@bibm.org.bd";
            mail($reviewer_email, $subject, $txt, $headers);
            $message = "journal assign";
            return $message;
        }
    }
// END Jannatun
    public function view_user() {
        $sql = "SELECT * FROM tbl_user";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function view_approved_user() {
        $sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND j.journal_status= 0 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function view_approved_user_two() {
        $sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND j.journal_status= 11 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function view_approved_user_three() {
        $sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND j.journal_status= 22 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function view_approved_user_four() {
        $sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND (j.journal_status= 45 OR j.journal_status= 46) ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function under_modification() {
        $sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND (j.journal_status= 12 OR j.journal_status= 13 OR j.journal_status= 23 OR j.journal_status= 34) ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function rejected() {
        $sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND j.journal_status= 99  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function waiting_for_publish() {
        $sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND j.journal_status= 44 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function ec_meeting() {
        $sql = "SELECT  u.user_id, u.user_name, u.user_email, u.user_contact_no, j.journal_id, j.journal_title, j.journal_file FROM tbl_user as u INNER JOIN tbl_journal as j WHERE u.user_access_level=1 AND j.journal_user_id=u.user_id AND j.journal_status= 33 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function add_reviewer($data) {
        $reviewer_name = $data['reviewer_name'];
        $reviewer_details = $data['reviewer_details'];
        $reviewer_department = $data['reviewer_department'];
        $reviewer_contact_no = $data['reviewer_contact_no'];
        $reviewer_email = $data['reviewer_email'];
        $password =strtolower($reviewer_name[0])."@".$reviewer_email;
        $reviewer_password = password_hash($password, PASSWORD_DEFAULT);


        $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_email='$reviewer_email' ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        if (!$result) {

            $stmt = DB::prepare("INSERT INTO tbl_reviewer (reviewer_name, reviewer_details,reviewer_department,reviewer_contact_no, reviewer_email, reviewer_password) VALUES (?, ?, ?, ?, ?, ?)");
            $arr = array($reviewer_name, $reviewer_details, $reviewer_department, $reviewer_contact_no, $reviewer_email, $reviewer_password);

            $stmt->execute($arr);

            return $message = "registration successfully done";
        } else {
            return $exeption = "You are already Registered  ";
        }
    }

    public function view_reviewer() {
        $sql = "SELECT * FROM tbl_reviewer";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function journal_assign($data) {
        $reviewer = explode('|', $data['reviewer_id']);
        //print_r($data);exit();
//        $reviewer_id = $reviewer[0];
        $reviewer_id = $data['reviewer_id'];
        $sql = "SELECT * FROM tbl_reviewer WHERE reviewer_id='$reviewer_id'";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $reviewer_info = $stmt2->fetch();
        //print_r($reviewer_info);exit();
        $reviewer_email = $reviewer_info['reviewer_email'];
        $journal_id = $data['journal_id'];
        //echo $journal_id;exit();
        $reviewer_type = $data['reviewer_type'];
        //$reviewer_id = $data['reviewer_id'];
        $assign_date = strtotime("now");
        $submission_date = '';
        $submission_due_date = strtotime($data['submission_due_date']);
        $comment = '';
        $honorarium_status = '';
        $honorarium_sent_date = '';
        if ($reviewer_type == 1) {
            $update_sql = "UPDATE tbl_journal set journal_reviewer1_assign_status=2, journal_reviewer_id=$reviewer_id WHERE journal_id= '$data[journal_id]' ";
        } else if ($reviewer_type == 2) {
            $update_sql = "UPDATE tbl_journal set journal_reviewer2_assign_status=2, journal_reviewer_id=$reviewer_id WHERE journal_id= '$data[journal_id]' ";
        } else if ($reviewer_type == 3) {
            $update_sql = "UPDATE tbl_journal set journal_reviewer3_assign_status=2, journal_reviewer_id=$reviewer_id WHERE journal_id= '$data[journal_id]' ";
        }
        $stmt = DB::prepare($update_sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $update = $stmt->execute();
        $sql = "INSERT INTO tbl_reviewer_assign(journal_id,reviewer_type,reviewer_id,assign_date,submission_due_date,comment,honorarium_status,honorarium_sent_date)"
            . "VALUES('$journal_id','$reviewer_type','$reviewer_id','$assign_date','$submission_due_date','$comment','$honorarium_status','$honorarium_sent_date')";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $assign = $stmt->execute();
        if ($assign) {
            //        send to history
            $status = 1;
            $id = $data['journal_id'];
            $i_date = strtotime(date('Y-m-d'));
            $data['due_date'] = $i_date;
            $data['comments'] = "";
            $sql = "INSERT INTO history (user_id, journal_id, i_date, due_date, journal_history_status, reviewer_id, comments)
VALUE ('$data[user_id]', '$id',
 '$i_date', '$submission_due_date', '$status',
  '$reviewer_id', '$data[comments]' )";
            $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt->execute();
            $subject = "Bank Parikrama Account";

            $txt = "Dear Reviewer, "."<br>"."
The Editorial Board of the Bank Parikrama, the quarterly Journal of BIBM, would request you to be the referee of an article. Please Log in to our Journal website through following link:
…………………………………………………………………………………………………….

If you did not registered yet, please follow the link for registration as a Reviewer of Bank Parikrama:
…………………………………………………………………………………………………….

You can also visit: journal.bibm.org.bd";

            $headers = "From: bibmresearch@bibm.org.bd";
            mail($reviewer_email, $subject, $txt, $headers);
            $message = "journal assign";
            return $message;
        }
    }

//    public function journal_assign_two($data) {
//        $reviewer = explode('|', $data['reviewer_id']);
//        $reviewer_id = $reviewer[0];
//        $reviewer_email = $reviewer[1];
//        $sql = "UPDATE tbl_journal set journal_reviewer_id='$reviewer_id', journal_status=2 WHERE journal_id= '$data[journal_id]' ";
//        $stmt = DB::prepare($sql);
//
//        $assign = $stmt->execute();
//        if ($assign) {
//            //        send to history
//            $status = 2;
//            $id = $data['journal_id'];
//            $i_date = date('Y-m-d');
//            $sql = "INSERT INTO history (user_id, journal_id, i_date, due_date, journal_history_status, reviewer_id, comments)
//VALUE ('$data[user_id]', '$id',
// '$i_date', '$data[due_date]', '$status',
//  '$reviewer_id', '$data[comments]' )";
//            $stmt = DB::prepare($sql);
//            $stmt->execute();
//            $subject = "Bank Parikrama Account";
//            $txt = " One journal assigned to you. Please login website and reviewe the journal ";
//            $headers = "From: research@bibm.org.bd";
//            mail($reviewer_email, $subject, $txt, $headers);
//            $message = "journal assign";
//            return $message;
//        }
//    }
//
//    public function journal_assign_three($data) {
//        $reviewer = explode('|', $data['reviewer_id']);
//        $reviewer_id = $reviewer[0];
//        $reviewer_email = $reviewer[1];
//        $sql = "UPDATE tbl_journal set journal_reviewer_id='$reviewer_id', journal_status=3 WHERE journal_id= '$data[journal_id]' ";
//        $stmt = DB::prepare($sql);
//
//        $assign = $stmt->execute();
//        if ($assign) {
//            //        send to history
//            $status = 3;
//            $id = $data['journal_id'];
//            $i_date = date('Y-m-d');
//            $sql = "INSERT INTO history (user_id, journal_id, i_date, due_date, journal_history_status, reviewer_id, comments)
//VALUE ('$data[user_id]', '$id',
// '$i_date', '$data[due_date]', '$status',
//  '$reviewer_id', '$data[comments]' )";
//            $stmt = DB::prepare($sql);
//            $stmt->execute();
//            $subject = "Bank Parikrama Account";
//            $txt = " One journal assigned to you. Please login website and reviewe the journal ";
//            $headers = "From: research@bibm.org.bd";
//            mail($reviewer_email, $subject, $txt, $headers);
//            $message = "journal assign";
//            return $message;
//        }
//    }
//
//    public function journal_assign_four($data) {
//        $reviewer = explode('|', $data['reviewer_id']);
//        $reviewer_id = $reviewer[0];
//        $reviewer_email = $reviewer[1];
//        $sql = "UPDATE tbl_journal set journal_reviewer_id='$reviewer_id', journal_status=4 WHERE journal_id= '$data[journal_id]' ";
//        $stmt = DB::prepare($sql);
//
//        $assign = $stmt->execute();
//        if ($assign) {
//            //        send to history
//            $status = 4;
//            $id = $data['journal_id'];
//            $i_date = date('Y-m-d');
//            $sql = "INSERT INTO history (user_id, journal_id, i_date, due_date, journal_history_status, reviewer_id, comments)
//VALUE ('$data[user_id]', '$id',
// '$i_date', '$data[due_date]', '$status',
//  '$reviewer_id', '$data[comments]' )";
//            $stmt = DB::prepare($sql);
//            $stmt->execute();
//            $subject = "Bank Parikrama Account";
//            $txt = " One journal assigned to you. Please login website and reviewe the journal ";
//            $headers = "From: research@bibm.org.bd";
//            mail($reviewer_email, $subject, $txt, $headers);
//            $message = "journal assign";
//            return $message;
//        }
//    }

    public function journal_for_review($data) {

        $sql = " SELECT  DISTINCT tbl_journal.journal_id, tbl_user.user_id, tbl_user.user_name,  tbl_user.user_email, tbl_journal.journal_user_id, tbl_journal.journal_title, tbl_journal.journal_file, tbl_reviewer_assign.journal_id,  tbl_reviewer_assign.reviewer_id   FROM 	tbl_user, tbl_journal, tbl_reviewer_assign WHERE tbl_reviewer_assign.reviewer_id = $data AND tbl_journal.journal_user_id= tbl_user.user_id AND (tbl_journal.journal_preliminary_review_status =1 or tbl_journal.journal_final_review_status =1) AND tbl_journal.journal_reviewer1_assign_status =2 AND tbl_journal.journal_reviewer_id = $data And tbl_journal.journal_id = tbl_reviewer_assign.journal_id ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
//        var_dump($result);
//        exit;
        return $result;
    }

    public function journal_for_review_two($data) {
        $sql = " SELECT  DISTINCT tbl_journal.journal_id, tbl_user.user_id, tbl_user.user_name,  tbl_user.user_email, tbl_journal.journal_user_id, tbl_journal.journal_title, tbl_journal.journal_file, tbl_reviewer_assign.journal_id,  tbl_reviewer_assign.reviewer_id   FROM 	tbl_user, tbl_journal, tbl_reviewer_assign WHERE tbl_reviewer_assign.reviewer_id = $data AND tbl_journal.journal_user_id= tbl_user.user_id AND (tbl_journal.journal_preliminary_review_status =1 or tbl_journal.journal_final_review_status =1) AND tbl_journal.journal_reviewer2_assign_status =2 AND tbl_journal.journal_reviewer_id = $data And tbl_journal.journal_id = tbl_reviewer_assign.journal_id ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
//        var_dump($result);
//        exit;
        return $result;
    }

    public function journal_for_review_three($data) {
        $sql = " SELECT  DISTINCT tbl_journal.journal_id, tbl_user.user_id, tbl_user.user_name,  tbl_user.user_email, tbl_journal.journal_user_id, tbl_journal.journal_title, tbl_journal.journal_file, tbl_reviewer_assign.journal_id,  tbl_reviewer_assign.reviewer_id   FROM 	tbl_user, tbl_journal, tbl_reviewer_assign WHERE tbl_reviewer_assign.reviewer_id = $data AND tbl_journal.journal_user_id= tbl_user.user_id AND (tbl_journal.journal_preliminary_review_status =1 or tbl_journal.journal_final_review_status =1) AND tbl_journal.journal_reviewer3_assign_status =2 AND tbl_journal.journal_reviewer_id = $data And tbl_journal.journal_id = tbl_reviewer_assign.journal_id ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
//        var_dump($result);
//        exit;
        return $result;
    }

    public function journal_for_review_four($data) {
        $sql = " SELECT * FROM 	tbl_user, tbl_journal, tbl_reviewer_assign WHERE tbl_reviewer_assign.reviewer_id = $data AND .tbl_journal.journal_user_id= tbl_user.user_id AND journal_status=4 AND tbl_journal.journal_reviewer_id = tbl_reviewer_assign.reviewer_id ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function update_review_status($data) {
        $value = $data['review'];
        $id = $data['id'];
        $comments = $data['comments'];
        $send_date = date('Y-m-d');
        echo $comments;
        $sql2 = " UPDATE tbl_journal set journal_status=$value, journal_comments = '$data[comments]'  WHERE journal_id= $id ";
        $stmt2 = DB::prepare($sql2, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();

//        send to history
        $i_date = date('Y-m-d');
        $sql = "INSERT INTO history (user_id, journal_id, i_date, journal_history_status, reviewer_id, comments)
VALUE ('$data[user_id]', '$id',
 '$i_date', '$value',
  '$data[reviewer_id]', '$data[comments]' )";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
    }

    public static function sent_history($data) {
        $i_date = date('Y-m-d');
        $id = $data['id'];
        $journal_status = $data['journal_status'];
        $sql = "INSERT INTO history (user_id,  journal_id, i_date, journal_history_status, reviewer_id, comments)
VALUE ('$data[user_id]', '$id',
 '$i_date', '$journal_status',
  '$data[reviewer_id]', '$data[comments]' )";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
    }

    public $status = 0;

    public static function sent_history_with_id($data) {
        $i_date = date('Y-m-d');
        $id = $data['id'];
        $status = $data['journal_status'];
        $journal_status = $status;
        $sql = "INSERT INTO history (user_id, journal_id, i_date, journal_status, reviewer_id, comments)
VALUE ('$data[user_id]', '$id',
 '$i_date', '$journal_status',
  '$data[reviewer_id]', '$data[comments]' )";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
    }

    public function reviewer_review($data, $files) {

       
       
   
        $review_type = $data['review_type'];
        $comments = $data['comments'];
        $author_email = $data['user_email'];
        $author_name = $data['user_name'];
        $journal_title = $data['journal_title'];
        $reviewer_id = $data['reviewer_id'];
        $review = $data['review'];
        $journal_id = $data['journal_id'];

        // update tbl_reviewer_assing


        if($files['journal_file']['name'] != ""){
            $check = filesize($files['journal_file']['tmp_name']);
        $directory = "jr_admin/journal/";
        $target_file = $directory . date('d-m-Y-h-i-s_') . $files['journal_file']['name'];
        $file_name = "journal/" . date('d-m-Y-h-i-s_') . $files['journal_file']['name'];
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
        $file_size = $files['journal_file']['size'];
        $check = filesize($files['journal_file']['tmp_name']);

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

                        $sql3 = "UPDATE tbl_reviewer_assign set comment = '$comments', review_report = '$file_name'  WHERE journal_id= $journal_id AND reviewer_id = $reviewer_id ";

                    
                }
            }
        }else{
            $sql3 = "UPDATE tbl_reviewer_assign set comment = '$comments', review_report = 'paper'  WHERE journal_id= $journal_id AND reviewer_id = $reviewer_id ";
        }
        
        
        $stmt3 = DB::prepare($sql3, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt3->execute();

        $subject = "Bank Parikrama Account";
        $mail_message = "Reviewed from a reviewer, Reviewer id is: ".$reviewer_id. "<br />" .
        "Recomanded: ".$review . "<br />" ."<br />" .
        "Reviewer Comments: ".$comments . "<br />" .
        "Author Email: ".$author_email . "<br />" .
        "Author Name: ".$author_name . "<br />" .
        "Journal Title: ".$journal_title . "<br />" .
        "Journal Id: ".$journal_id;

        // email
        $from_name = "BIBM JOURNAL";
        $from_mail = "bibmresearch@bibm.org.bd";
        $mail_to = "haque279@gmail.com";
        $mail_subject = "Journal Review from Reviewer";
        $encoding = "utf-8";

    // Preferences for Subject field
    $subject_preferences = array(
        "input-charset" => $encoding,
        "output-charset" => $encoding,
        "line-length" => 76,
        "line-break-chars" => "\r\n"
    );

    // Mail header
    $header = "Content-type: text/html; charset=".$encoding." \r\n";
    $header .= "From: ".$from_name." <".$from_mail."> \r\n";
    $header .= "MIME-Version: 1.0 \r\n";
    $header .= "Content-Transfer-Encoding: 8bit \r\n";
    $header .= "Date: ".date("r (T)")." \r\n";
    $header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

    // Send mail
    mail($mail_to, $mail_subject, $mail_message, $header);
                
    
        
       

        if($review_type == 1){
            $sql2 = " UPDATE tbl_journal set journal_reviewer1_assign_status = 3  WHERE journal_id= $journal_id ";
        } elseif($review_type == 2){
            $sql2 = " UPDATE tbl_journal set journal_reviewer2_assign_status = 3  WHERE journal_id= $journal_id ";
        } elseif($review_type == 3){
            $sql2 = " UPDATE tbl_journal set journal_reviewer3_assign_status = 3  WHERE journal_id= $journal_id ";
        }

        $stmt2 = DB::prepare($sql2, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        header("location: journal_review.php");
        
    }

    public function send_email_mod($data) {
        $comments = $data['comments'];
        $reviewer_email = $data['user_email'];
        $subject = "Bank Parikrama Account";
        $txt = " Your journal need to modification. Please modify your journal, login and upload your journal by click on your journal name. " . "\n" . "Reviewer comments: " . $comments;
        $headers = "From: bibmresearch@bibm.org.bd";
        mail($reviewer_email, $subject, $txt, $headers);
    }

    public function send_email_confirm($data) {
        $comments = $data['comments'];
        $reviewer_email = $data['user_email'];
        $subject = "Bank Parikrama Account";
        $txt = " Congratulations. Your journal has been accepted " . "\n" . "Reviewer comments: " . $comments;
        $headers = "From: bibmresearch@bibm.org.bd";
        mail($reviewer_email, $subject, $txt, $headers);
    }

    public function send_email_rejected($data) {
        $comments = $data['comments'];
        $reviewer_email = $data['user_email'];
        $subject = "Bank Parikrama Account";
        $txt = " Your journal has been rejected. Good luck for next time. " . "\n" . "Reviewer comments: " . $comments;
        $headers = "From: bibmresearch@bibm.org.bd";
        mail($reviewer_email, $subject, $txt, $headers);
    }

    public function logout() {
        session_destroy();
        header("location:index.php");
    }

    public function logout_reviewer() {
        session_destroy();
        header("location:../index.php");
    }

    public function reviewer_single($reviewer_id) {
        $sql = "SELECT * from tbl_reviewer  WHERE reviewer_id=$reviewer_id  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
    }

    public function update_single_reviewer($data) {
        $reviewer_id= $data['reviewer_id'];
        $reviewer_name = $data['reviewer_name'];
        $reviewer_details = $data['reviewer_details'];
        $reviewer_department = $data['reviewer_department'];
        $reviewer_contact_no = $data['reviewer_contact_no'];
        $reviewer_email = $data['reviewer_email'];

        $sql = "UPDATE tbl_reviewer set reviewer_name= '$reviewer_name', reviewer_details= '$reviewer_details', reviewer_department= '$reviewer_department', reviewer_contact_no= '$reviewer_contact_no', reviewer_email= '$reviewer_email' 
   WHERE reviewer_id= $reviewer_id";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $query = $stmt->execute();
    }

    public function review_details($journal_id,$reviewer_id)
    {
        $sql = "SELECT * from tbl_reviewer_assign  WHERE reviewer_id=$reviewer_id AND journal_id = $journal_id ORDER BY reviewer_assign_id DESC LIMIT 1  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2->fetchAll();
        return $result;
        
    }

}