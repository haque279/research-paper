<?php

class Count
{
    public function total_author(){
        $sql="SELECT user_id FROM tbl_user WHERE user_access_level = 1 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> RowCount();
        return  $result;
    }
    public function total_journal(){
        $sql="SELECT journal_id FROM tbl_journal ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> RowCount();
        return  $result;
    }
    public function journal_priliminary(){
        $sql="SELECT journal_id FROM tbl_journal WHERE journal_status= 1 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> RowCount();
        return  $result;
    }
    public function journal_secondary_one(){
        $sql="SELECT journal_id FROM tbl_journal WHERE journal_status= 11 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> RowCount();
        return  $result;
    }
    public function journal_secondary_two(){
        $sql="SELECT journal_id FROM tbl_journal WHERE journal_status= 22 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> RowCount();
        return  $result;
    }
    public function journal_modified(){
        $sql="SELECT journal_id FROM tbl_journal WHERE journal_status= 12 or journal_status= 45 or journal_status= 46 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> RowCount();
        return  $result;
    }
    public function journal_rejected(){
        $sql="SELECT journal_id FROM tbl_journal WHERE journal_status= 99 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> RowCount();
        return  $result;
    }
    public function journal_waiting_publication(){
        $sql="SELECT journal_id FROM tbl_journal WHERE journal_status= 44 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> RowCount();
        return  $result;
    }
}