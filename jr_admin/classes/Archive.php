<?php
include "DB.php";

class Archive
{
    public function add_j_arcive($data){
        $sql1 = "SELECT  * FROM tbl_journal_archive ORDER BY j_archive_id DESC LIMIT 1 ";
        $stmt1 = DB::prepare($sql1);
        $stmt1->execute();
        $result1 = $stmt1-> fetch(PDO::FETCH_ASSOC);
        $j_archive_position=$result1['j_archive_id']+1;
        print_r($result1);

        $j_archive_title = $data['j_archive_title'] ;
        $j_archive_link= $data['j_archive_link'] ;
        $sql = "INSERT INTO tbl_journal_archive
            (j_archive_title,
            j_archive_link, j_archive_position )
            VALUES (?, ?, ?)";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $arr = array( $j_archive_title, $j_archive_link, $j_archive_position );
        $stmt->execute($arr);
        header('location:journal_archive.php?message=Added to Archive');

    }

    public function view_j_archive(){
        $sql = "SELECT * FROM  tbl_journal_archive ORDER BY j_archive_position DESC, j_archive_id DESC ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }
    public function view_j_archive_edit($id){
        $sql = "SELECT * FROM  tbl_journal_archive WHERE j_archive_id=$id  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function edit_j_archive($data){
        $j_archive_id = $data['j_archive_id'] ;
        $j_archive_title = $data['j_archive_title'] ;
        $j_archive_link= $data['j_archive_link'] ;
        $j_archive_position = $data['j_archive_position'] ;
        $sql = "UPDATE tbl_journal_archive SET  j_archive_title=?,j_archive_link=?,j_archive_position=? WHERE j_archive_id=?";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $arr = array( $j_archive_title, $j_archive_link, $j_archive_position, $j_archive_id );
        $stmt->execute($arr);
        header('location:journal_archive_view.php?message=Updated from Archive');
    }

    public function delete_archive($id){
        $sql = "DELETE FROM tbl_journal_archive WHERE  j_archive_id=$id ";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt->execute();
        header('location:journal_archive_view.php?message=Deleted from Archive');
    }

//    current issue


    public function view_current_issue_edit($id){
        $sql = "SELECT * FROM  current_issue WHERE current_id=$id  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function edit_current_issue($data){
        $current_title = $data['current_title'] ;
        $current_content= $data['current_content'] ;
        $sql = "UPDATE current_issue SET  current_title=?,current_content=? WHERE current_id=1";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $arr = array( $current_title, $current_content );
        $stmt->execute($arr);
        header('location:current_issue.php?message=Updated Current Issue');
    }


//  forthcoming papers

    public function view_forthcoming_papers($id){
        $sql = "SELECT * FROM  tbl_forthcoming WHERE forthcoming_id=$id  ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }

    public function edit_forthcoming_papers($data){
        $forthcoming_title = $data['forthcoming_title'] ;
        $sql = "UPDATE tbl_forthcoming SET  forthcoming_title=? WHERE forthcoming_id=1";
        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $arr = array( $forthcoming_title );
        $stmt->execute($arr);
        header('location:forthcoming_papers.php?message=Updated Forthcoming Issue');
    }


}