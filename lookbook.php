<?php
require 'auth.php';
require 'koneksi.php';
$msg='';

if(isset($_POST['upload'])){
    $f=$_FILES['pdf']; $judul=trim($_POST['judul']);

    if($judul==='' || $f['error']!==UPLOAD_ERR_OK) $msg="Data atau upload tidak valid!";
    elseif($f['size']>10*1024*1024) $msg="PDF maksimal 10 MB!";
    elseif(strtolower(pathinfo($f['name'],PATHINFO_EXTENSION))!=='pdf' || (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name'])!=='application/pdf') $msg="File harus PDF!";
    else{
        $nama=bin2hex(random_bytes(16)).'.pdf';
        if(move_uploaded_file($f['tmp_name'],__DIR__.'/lookbooks/'.$nama)){
            $q=$pdo->prepare("INSERT INTO lookbooks(user_id,judul,file_pdf) VALUES(?,?,?)");
            $q->execute([$_SESSION['user_id'],$judul,$nama]);
            $msg="PDF berhasil diunggah!";
        } else $msg="Gagal menyimpan PDF!";
    }
}

$q=$pdo->prepare("SELECT * FROM lookbooks WHERE user_id=? ORDER BY id DESC");
$q->execute([$_SESSION['user_id']]); $data=$q->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">

<div class="container mt-5" style="max-width:750px;font-family:Poppins">
<h2 style="font-family:'Playfair Display'">Fashion Lookbook</h2>
<p>Simpan inspirasi outfit favoritmu </p>
<p><?= htmlspecialchars($msg) ?></p>

<form method="post" enctype="multipart/form-data" class="card p-3 mb-4">
<input name="judul" class="form-control mb-2" placeholder="Judul Lookbook" maxlength="150" required>
<input type="file" name="pdf" class="form-control mb-2" accept=".pdf,application/pdf" required>
<button name="upload" class="btn btn-success">Upload PDF</button>
</form>

<h4>Koleksi Lookbook Saya</h4>
<?php foreach($data as $r): ?>
<div class="card p-3 mb-2">
<strong><?= htmlspecialchars($r['judul']) ?></strong>
<small><?= $r['created_at'] ?></small>
<a href="lookbooks/<?= rawurlencode($r['file_pdf']) ?>" target="_blank" class="btn btn-outline-dark mt-2">Lihat PDF</a>
</div>
<?php endforeach; ?>

<?php if(!$data): ?><p class="text-muted">Belum ada lookbook.</p><?php endif; ?>
<a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
</div>