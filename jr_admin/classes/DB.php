<?php
require "config.php";
class DB{

    private static $conn;

public static function connection(){

    try {
        self::$conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        // set the PDO error mode to exception
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    return self::$conn;
}
public static function prepare($sql){
    return self::connection()->prepare($sql);
}
}
DB::connection();