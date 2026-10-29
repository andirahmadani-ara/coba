<?php
require 'auth.php';
require 'koneksi.php';

$q=$pdo->prepare("SELECT * FROM clothes WHERE user_id=?");
$q->execute([$_SESSION['user_id']]);
$data=$q->fetchAll();

$q=$pdo->prepare("SELECT kategori,COUNT(*) AS jumlah FROM clothes WHERE user_id=? GROUP BY kategori");
$q->execute([$_SESSION['user_id']]);
$kategori=$q->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<style>
body{font-family:Poppins;background:#f8f1e7}
h1{font:600 40px 'Playfair Display';text-align:center}
.sub{text-align:center;color:#777}
.card{border:0;border-radius:12px;overflow:hidden}
</style>

<div class="container mt-5">
<h1>Digital Wardrobe</h1>
<p class="sub">Simpan, kelola, dan padukan outfit favoritmu</p>

<a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Pakaian</a>
<a href="mixmatch.php" class="btn btn-success mb-3">Mix & Match</a>
<a href="logout.php" class="btn btn-dark mb-3">Logout</a>
<a href="lookbook.php" class="btn btn-secondary mb-3"> Fashion Lookbook</a>

<div class="row mb-4">
<div class="col-md-4 mb-3">
<div class="card p-3 shadow-sm">
<p class="text-muted mb-1">Total Pakaian</p>
<h2><?= count($data) ?></h2>
</div>
</div>

<div class="col-md-8 mb-3">
<div class="card p-3 shadow-sm">
<h5>Kategori Koleksi</h5>
<div style="height:280px;position:relative">
<canvas id="kategoriChart"></canvas>
</div>
</div>
</div>
</div>

<div class="row">
<?php foreach($data as $r): ?>
<div class="col-md-4 mb-4">
<div class="card p-2 shadow-sm">
<img src="uploads/<?= htmlspecialchars($r['foto'] ?? '') ?>" height="300" style="object-fit:cover">
<h5 class="mt-2"><?= htmlspecialchars($r['nama']) ?></h5>
<p><?= htmlspecialchars($r['kategori']) ?> | <?= htmlspecialchars($r['warna']) ?> | <?= htmlspecialchars($r['style']) ?></p>
<a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-warning">Edit</a>
<a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-danger mt-1" onclick="return confirm('Hapus pakaian ini?')">Hapus</a>
</div>
</div>
<?php endforeach; ?>
</div>
</div>

<script>
const labels=<?= json_encode(array_map('ucfirst',array_column($kategori,'kategori'))) ?>;
const jumlah=<?= json_encode(array_map('intval',array_column($kategori,'jumlah'))) ?>;

new Chart(document.getElementById('kategoriChart'),{
    type:'doughnut',
    plugins:[ChartDataLabels],
    data:{
        labels:labels,
        datasets:[{
            data:jumlah,
            backgroundColor:['#92715c','#d9b99b','#b7a18c','#e8d8c3'],
            borderColor:'#fff',
            borderWidth:2
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{position:'bottom'},
            datalabels:{
                color:'#fff',
                font:{weight:'bold',size:12},
                textStrokeColor:'#5a4436',
                textStrokeWidth:2,
                formatter:(nilai,ctx)=>ctx.chart.data.labels[ctx.dataIndex]+': '+nilai
            }
        }
    }
});
</script>