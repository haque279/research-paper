<?php

class Fronview{

    public function update($data, $files)
    {



        $id = $data['id'];
        if(isset($data['title'])){ $title = $data['title']; } else {$title = null; }
        if(isset($data['text'])){ $text = $data['text']; } else {$text = null; }
        if(isset($data['value1'])){ $value1 = $data['value1']; } else {$value1 = null; }
        if(isset($data['value2'])){ $value2 = $data['value2']; } else {$value2 = null; }

        if (strlen($files['journal_file']['name']) > 0){
            $rand = rand(1000,9999);
           
            $check = filesize($files['journal_file']['tmp_name']);
            $directory = "file/";
            $target_file = $directory . date('d-m-Y-h-i-s_') . $files['journal_file']['name'];
            $file_name = "file/" . date('d-m-Y-h-i-s_') . $files['journal_file']['name'];
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

            $file_size = $files['journal_file']['size'];
            $check = filesize($files['journal_file']['tmp_name']);
            if ($file_size > 20000000) {
               echo $message = 'Sorry uour file Size is too large.';
                return $message;
//                    exit();
            } else {


                if ($file_type != 'jpg' && $file_type != 'png' ) {
                    $message = 'Sorry your file type is not valid.';
                    return $message;
                    exit();
                } else {
                    move_uploaded_file($files['journal_file']['tmp_name'], $target_file);
                    $sql = "UPDATE tbl_front set journal_file='$file_name', title='$title', text='$text', value1='$value1', value2='$value2' WHERE id='$id'  ";

                }
            }
        }else {
            $sql = "UPDATE tbl_front set  title='$title', text='$text', value1='$value1', value2='$value2' WHERE id='$id'  ";
        }

        $stmt = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $query = $stmt->execute();
        if ($query){
            $message = 'Update Successfully done';
        }

        header('location: front.php?id='.$id.'&message='.$message);
    }






    public function view ($id){
        $sql = "SELECT * FROM tbl_front WHERE id=$id LIMIT 1 ";
        $stmt2 = DB::prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $stmt2->execute();
        $result = $stmt2-> fetchAll();
        return $result;
    }







}