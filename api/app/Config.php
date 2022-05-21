<?php

class Config{
    public function connect(){
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $dbname = "chatapp";

        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        if(!$conn){
            echo "Lỗi kết nối Database".mysqli_connect_error();
        }
        return $conn;
    }
}