<?php
include_once "part/header.php";
?>
<body>
  <div class="wrapper">
    <section class="form login">
      <header>Chatapp Realtime</header>
      <form action="#">
        <div class="error-text"></div>


        <div class="field input">
          <label for="">Email</label>
          <input type="text" name="email" placeholder="Nhập Email" required>
        </div>

        
        <div class="field input">
          <label for="">Mật khẩu</label>
          <input type="password" name="password" placeholder="Nhập mật khẩu" required>
          <i class="fas fa-eye"></i>
        </div>

        <div class="field button">
          <input type="submit" value="Bắt đầu Chat">
        </div>

      </form>
      <div class="link">Chưa có tài khoản? <a href="index.php">Đăng ký ngay</a></div>
    </section>
  </div>

  <script src="assets/password-event.js"></script>
  <script src="assets/login.js"></script>
</body>
</html>