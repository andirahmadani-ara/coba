<?php
require 'koneksi.php';
$error='';

if(isset($_POST['daftar'])){
    $n=trim($_POST['nama']);
    $e=trim($_POST['email']);
    $p=$_POST['password'];

    $q=$pdo->prepare("SELECT id FROM users WHERE email=?");
    $q->execute([$e]);

    if($q->fetch()) $error="Email sudah terdaftar!";
    elseif(!filter_var($e,FILTER_VALIDATE_EMAIL)) $error="Email tidak valid!";
    elseif(strlen($p)<6) $error="Password minimal 6 karakter!";
    else{
        $q=$pdo->prepare("INSERT INTO users(nama,email,password) VALUES(?,?,?)");
        $q->execute([$n,$e,password_hash($p,PASSWORD_DEFAULT)]);
        header("Location: login.php");
        exit;
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">

<div class="container mt-5" style="max-width:400px;font-family:Poppins">
<h2 class="text-center" style="font-family:'Playfair Display'">Create Account</h2>
<p class="text-center">Join Digital Wardrobe ✨</p>
<p class="text-danger"><?= htmlspecialchars($error) ?></p>

<form method="post">
<input name="nama" class="form-control mb-3" placeholder="Nama lengkap" required>
<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password (min. 6 karakter)" minlength="6" required>
<button name="daftar" class="btn btn-dark w-100">Register</button>
</form>

<p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
</div>
