<?php
  include_once "api/app/controller/AuthController.php";
  include_once "api/app/Config.php";
  include_once "api/app/controller/UserController.php";

  $auth = new AuthController();
  $auth->checkAuth();

  $user = new UserController();
  $row = $user->getUserById($_SESSION['unique_id']);

  include_once "part/header.php";
?>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <img src="api/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['lname'].' '.$row['fname']; ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="api/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Đăng xuất</a>
      </header>
      <div class="search">
        <span class="text">Lựa chọn bạn bè để trò chuyện</span>
        <input class="" type="text" name="search" id="" placeholder="Nhập tên để tìm kiếm">
        <button class=""><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
      </div>
    </section>
  </div>

  <script src="assets/users-event.js"></script>
</body>
</html>