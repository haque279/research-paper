<?php
include "DB.php";


class History {
    // this is old view history method.
//    public function view_history($user, $journal_id){
//        $sql = "
//        SELECT h.user_id, h.journal_id, h.reviewer_id, h.journal_history_status, h.i_date, h.comments,
//         u.user_id, u.user_name, h.due_date,
//         j.journal_id, j.journal_title, j.journal_reviewer_id, j.journal_status,
//         r.reviewer_name, r.reviewer_position, r.reviewer_institute, r.reviewer_email, r.reviewer_contact_no
//         FROM history as h,tbl_user as u, tbl_journal as j, tbl_reviewer as r
//         WHERE h.user_id= u.user_id AND u.user_id= $user AND h.reviewer_id=r.reviewer_id
//          AND h.journal_id=$journal_id AND j.journal_id= $journal_id
// ";
//        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
//        $stmt->execute();
//        $r = $stmt-> fetchAll();
//        return $r;
//
//    }


    public function view_history($user, $journal_id){
        $sql = "
        SELECT * FROM tbl_journal
         WHERE journal_user_id= $user AND journal_id= $journal_id
 ";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
        $r = $stmt-> fetchAll();
        return $r;
    }


    public function view_additional_author($data, $journal_id){
        $sql = "SELECT * FROM tbl_additional_author WHERE additional_author_user_id='$data' AND additional_author_journal_id=$journal_id ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function journal_view_by_id ($id){
        $sql="SELECT * FROM tbl_journal
        WHERE journal_id=$id";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }


}