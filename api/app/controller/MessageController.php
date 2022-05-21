<?php

class MessageController{
    private Config $conn;

    public function __construct()
    {
        if(!isset($_SESSION)){
            session_start();
        }
        $this->conn = new Config();
    }

    public function insertChat(){
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($this->conn->connect(), $_POST['incoming_id']);
        $message = mysqli_real_escape_string($this->conn->connect(), $_POST['message']);
        if(!empty($message)){
            $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                    VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')";
            mysqli_query($this->conn->connect(), $sql) or die();
        }
    }

    public function getChat(){
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($this->conn->connect(), $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($this->conn->connect(), $sql);
        if(mysqli_num_rows($query)>0){
            while ($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                  <div class="details">
                                    <p>'.$row['msg'].'</p>
                                  </div>
                                </div>';
                } else {
                    $output .= '<div class="chat incoming">
                                  <div class="details">
                                    <p>'.$row['msg'].'</p>
                                  </div>
                                </div>';
                }
            }
        } else {
            $output .= "<div class='text'>Không có tin nhắn. Khi bạn có, tin nhắn sẽ hiện tại đây.</div>";
        }
        echo $output;
    }
}