<?php
session_start();
require 'koneksi.php';
$error='';

if(isset($_POST['login'])){
    $q=$pdo->prepare("SELECT * FROM users WHERE email=?");
    $q->execute([trim($_POST['email'])]);
    $u=$q->fetch();

    if($u && password_verify($_POST['password'],$u['password'])){
    session_regenerate_id(true);
    $_SESSION['user_id']=$u['id'];
    $_SESSION['nama']=$u['nama'];
    $_SESSION['role']=$u['role'];

    header("Location: ".($u['role']=='admin'?'admin.php':'index.php'));
    exit;
}else $error="Email atau password salah!";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">

<div class="container mt-5" style="max-width:400px;font-family:Poppins">
<h2 class="text-center" style="font-family:'Playfair Display'">Digital Wardrobe</h2>
<p class="text-center">Welcome</p>
<p class="text-danger"><?= htmlspecialchars($error) ?></p>

<form method="post">
<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
<button name="login" class="btn btn-dark w-100">Login</button>
</form>

<p class="text-center mt-3">Belum punya akun? <a href="register.php">Register</a></p>
</div>