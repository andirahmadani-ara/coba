<?php
require 'auth.php';
require 'koneksi.php';

$q=$pdo->prepare("SELECT * FROM clothes WHERE user_id=? AND kategori=?");
$q->execute([$_SESSION['user_id'],'atasan']); $a=$q->fetchAll();
$q->execute([$_SESSION['user_id'],'bawahan']); $b=$q->fetchAll();

$atasan=$bawahan=null;
if(isset($_POST['tampil'])){
    $q=$pdo->prepare("SELECT * FROM clothes WHERE id=? AND user_id=? AND kategori=?");
    $q->execute([(int)$_POST['atasan'],$_SESSION['user_id'],'atasan']); $atasan=$q->fetch();
    $q->execute([(int)$_POST['bawahan'],$_SESSION['user_id'],'bawahan']); $bawahan=$q->fetch();
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
<h2>Mix & Match</h2>
<form method="post">
<select name="atasan" class="form-control mb-2" required>
<option value="">Pilih Atasan</option>
<?php foreach($a as $x): ?>
<option value="<?= $x['id'] ?>"><?= htmlspecialchars($x['nama']) ?></option>
<?php endforeach; ?>
</select>
<select name="bawahan" class="form-control mb-2" required>
<option value="">Pilih Bawahan</option>
<?php foreach($b as $x): ?>
<option value="<?= $x['id'] ?>"><?= htmlspecialchars($x['nama']) ?></option>
<?php endforeach; ?>
</select>
<button name="tampil" class="btn btn-success">Tampilkan</button>
</form>

<?php if($atasan && $bawahan): ?>
<div class="text-center mt-4">
<h4>Outfit Mix & Match</h4>
<div class="card p-3 mx-auto" style="max-width:350px">
<?php foreach([$atasan,$bawahan] as $r): ?>
<img src="uploads/<?= htmlspecialchars($r['foto'] ?? '') ?>" height="300" style="width:100%;object-fit:cover">
<h5 class="mt-2"><?= htmlspecialchars($r['nama']) ?></h5>
<p><?= htmlspecialchars($r['kategori']) ?> | <?= htmlspecialchars($r['warna']) ?> | <?= htmlspecialchars($r['style']) ?></p>
<?php if($r===$atasan): ?><hr><?php endif; ?>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>

<a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
</div>