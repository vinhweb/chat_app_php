<?php
class AuthController{
    private Config $conn;

    public function __construct()
    {
        if(!isset($_SESSION)){
            session_start();
        }
        $this->conn = new Config();
    }

    public function checkAuth(){
        if(!isset($_SESSION['unique_id'])){
            header("location: login.php");
        }
    }

    public function signUp(){
        $fname = mysqli_real_escape_string($this->conn->connect(), $_POST['fname']);
        $lname = mysqli_real_escape_string($this->conn->connect(), $_POST['lname']);
        $email = mysqli_real_escape_string($this->conn->connect(), $_POST['email']);
        $password = mysqli_real_escape_string($this->conn->connect(), $_POST['password']);

        if(empty($fname) or empty($lname) or empty($email) or empty($password)){
            echo "Mọi trường đều bắt buộc";
            return;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "$email không là email hợp lệ!";
            return;
        }

        if($this->checkIssetEmail($email)){
            return;
        }

        if(isset($_FILES['image'])){
           $img_name = $_FILES['image']['name'];
           $img_type = $_FILES['image']['type'];
           $tmp_name = $_FILES['image']['tmp_name'];

           $img_explode = explode('.', $img_name);
           $img_ext = end($img_explode);

           $extensions = ["jpeg", "png", "jpg"];
           if(!in_array($img_ext, $extensions)){
               echo "Vui lòng đăng file ảnh - jpeg, png, jpg";
               return;
           }

           $types = ['image/jpeg', 'image/jpg', 'image/png'];
           if(!in_array($img_type, $types)){
               echo "Vui lòng đăng file ảnh - jpeg, png, jpg";
               return;
           }

           $time = time();
           $new_img_name = $time.$img_name;
           if(move_uploaded_file($tmp_name,"images/".$new_img_name)){
               $ran_id = rand(time(), 1000000000);
               $status = "Đang hoạt động";
               $encrypt_pass = md5($password);
               $insert_query = mysqli_query($this->conn->connect(),
                   "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                         VALUES ({$ran_id}, '${fname}', '${lname}', '${email}', '${encrypt_pass}', '${new_img_name}', '${status}')");
               if(!$insert_query){
                   echo "Có lỗi xảy ra. Vui lòng thử lại!";
                   return;
               }

               $select_sql2 = mysqli_query($this->conn->connect(), "SELECT * FROM users WHERE email = '${email}'");
               if(!mysqli_num_rows($select_sql2) > 0){
                   echo "Email này không tồn tại!";
                   return;
               }

               $result = mysqli_fetch_assoc($select_sql2);
               $_SESSION['unique_id'] = $result['unique_id'];
               echo "success";
           }
        }
    }

    public function logIn(){
        $email = mysqli_real_escape_string($this->conn->connect(), $_POST['email']);
        $password = mysqli_real_escape_string($this->conn->connect(), $_POST['password']);

        if(empty($email) or empty($password)){
            echo "Mọi trường đều bắt buộc";
            return;
        }

        $sql = mysqli_query($this->conn->connect(), "SELECT * FROM users WHERE email = '${email}'");
        if(!mysqli_num_rows($sql) > 0){
            echo "Email này không tồn tại!";
            return;
        }

        $row = mysqli_fetch_assoc($sql);
        $user_pass = md5($password);
        $enc_pass = $row['password'];
        if($user_pass !== $enc_pass){
            echo "Email hoặc Mật khẩu không chính xác";
            return;
        }

        $status = "Đang hoạt động";
        $sql2 = mysqli_query($this->conn->connect(),
            "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
        if($sql2){
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";
        } else {
            echo "Có lỗi xảy ra. Vui lòng thử lại!";
        }
    }

    public function logOut(){
        $this->checkAuth();

        $logout_id = mysqli_real_escape_string($this->conn->connect(), $_GET['logout_id']);
        if(isset($logout_id)){
            $status = "Không hoạt động";
            $sql = mysqli_query($this->conn->connect(),
                "UPDATE users SET status = '{$status}' WHERE unique_id={$logout_id}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            } else {
                header("location: ../users.php");
            }
        }
    }

    private function checkIssetEmail($email){
        $sql = mysqli_query($this->conn->connect(), "SELECT * FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0){
            echo "$email - Email này đã tồn tại!";
            return true;
        }
        return false;
    }
}