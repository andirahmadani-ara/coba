<?php
require 'auth.php';
require 'koneksi.php';

if(isset($_POST['simpan'])){
    $foto=$_FILES['foto']['name'];
    $namaFoto=time().'_'.basename($foto);

    if($_FILES['foto']['error']===UPLOAD_ERR_OK &&
       move_uploaded_file($_FILES['foto']['tmp_name'],"uploads/".$namaFoto)){

        $q=$pdo->prepare("INSERT INTO clothes(user_id,nama,kategori,warna,style,foto) VALUES(?,?,?,?,?,?)");
        $q->execute([
            $_SESSION['user_id'],
            $_POST['nama'],
            $_POST['kategori'],
            $_POST['warna'],
            $_POST['style'],
            $namaFoto
        ]);

        header("Location:index.php");
        exit;
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
<h2>Tambah Pakaian</h2>

<form method="post" enctype="multipart/form-data">
<input name="nama" class="form-control mb-2" placeholder="Nama" required>

<select name="kategori" class="form-control mb-2" required>
<option value="">Pilih Kategori</option>
<option value="atasan">Atasan</option>
<option value="bawahan">Bawahan</option>
</select>

<input name="warna" class="form-control mb-2" placeholder="Warna" required>
<input name="style" class="form-control mb-2" placeholder="Style" required>
<input type="file" name="foto" class="form-control mb-2" accept="image/*" required>

<button name="simpan" class="btn btn-success">Simpan</button>
<a href="index.php" class="btn btn-secondary">Kembali</a>
</form>
</div>