<?php
require 'auth.php';
require 'koneksi.php';

$id=(int)($_GET['id'] ?? 0);
$q=$pdo->prepare("SELECT * FROM clothes WHERE id=? AND user_id=?");
$q->execute([$id,$_SESSION['user_id']]);
$row=$q->fetch();

if(!$row){header("Location:index.php");exit;}

if(isset($_POST['update'])){
    $q=$pdo->prepare("UPDATE clothes SET nama=?,kategori=?,warna=?,style=? WHERE id=? AND user_id=?");
    $q->execute([
        $_POST['nama'],$_POST['kategori'],$_POST['warna'],
        $_POST['style'],$id,$_SESSION['user_id']
    ]);
    header("Location:index.php");
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
<h2>Edit Pakaian</h2>

<form method="post">
<input name="nama" value="<?= htmlspecialchars($row['nama']) ?>" class="form-control mb-2" required>
<input name="kategori" value="<?= htmlspecialchars($row['kategori']) ?>" class="form-control mb-2" required>
<input name="warna" value="<?= htmlspecialchars($row['warna']) ?>" class="form-control mb-2" required>
<input name="style" value="<?= htmlspecialchars($row['style']) ?>" class="form-control mb-2" required>

<button name="update" class="btn btn-success">Update</button>
<a href="index.php" class="btn btn-secondary">Kembali</a>
</form>
</div>