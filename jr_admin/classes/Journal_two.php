<?php

class Journal_two
{


    public function journal_view_by_id ($id){
        $sql="SELECT * FROM tbl_journal
        WHERE journal_id=$id)";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function view_additional_author($data, $journal_id){
        $sql = "SELECT * FROM tbl_additional_author WHERE additional_author_user_id='$data' AND additional_author_journal_id=$journal_id ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }
}