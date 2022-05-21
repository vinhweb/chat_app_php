<?php
include_once "api/app/controller/AuthController.php";
include_once "api/app/Config.php";
include_once "api/app/controller/UserController.php";

$auth = new AuthController();
$auth->checkAuth();

$user = new UserController();
$row = $user->getUserById($_GET['user_id']);

include_once "part/header.php";
?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <a href="users.php" class="back-icon">
          <i class="fas fa-arrow-left"></i>
        </a>
        <img src="api/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['lname'].' '.$row['fname']; ?></span>
          <div><?php echo $row['status']; ?></div>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" name="incoming_id" class="incoming_id" value="<?php echo $_GET['user_id']; ?>" id="" hidden>
        <input type="text" name="message" class="input-field" placeholder="Nhập nội dung ở đây..." autocomplete="off">
        <button>
          <i class="fab fa-telegram-plane"></i>
        </button>
      </form>
    </section>
  </div>

  <script src="assets/chat-event.js"></script>
</body>
</html>