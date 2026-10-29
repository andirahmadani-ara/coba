<?php
require 'auth.php';
require 'koneksi.php';

if(($_SESSION['role'] ?? '')!=='admin'){
    header("Location:index.php");
    exit;
}

$users=$pdo->query("SELECT id,nama,email,created_at FROM users ORDER BY id DESC")->fetchAll();
$total=count($users);
$pdf=$pdo->query("SELECT COUNT(*) FROM lookbooks")->fetchColumn();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">

<style>
body{font-family:Poppins;background:#f8f1e7}
h2{font-family:'Playfair Display'}
.card{border:0;border-radius:12px}
</style>

<div class="container mt-5">
<h2>Admin Dashboard</h2>
<p>Selamat datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</p>

<div class="row mb-4">
<div class="col-md-6 mb-3">
<div class="card p-3 shadow-sm">
<p class="mb-1 text-muted">Total Pengguna</p>
<h3><?= $total ?></h3>
</div>
</div>
<div class="col-md-6 mb-3">
<div class="card p-3 shadow-sm">
<p class="mb-1 text-muted">Total Lookbook</p>
<h3><?= $pdf ?></h3>
</div>
</div>
</div>

<div class="card p-3 shadow-sm">
<h5>Daftar Pengguna</h5>
<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Tanggal Daftar</th></tr></thead>
<tbody>
<?php foreach($users as $u): ?>
<tr>
<td><?= $u['id'] ?></td>
<td><?= htmlspecialchars($u['nama']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= htmlspecialchars($u['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<a href="logout.php" class="btn btn-dark mt-3">Logout</a>
</div>