<?php
require 'auth.php';
require 'koneksi.php';

$id=(int)($_GET['id'] ?? 0);
$q=$pdo->prepare("SELECT foto FROM clothes WHERE id=? AND user_id=?");
$q->execute([$id,$_SESSION['user_id']]);
$r=$q->fetch();

if($r){
    $pdo->prepare("DELETE FROM clothes WHERE id=? AND user_id=?")
        ->execute([$id,$_SESSION['user_id']]);

    $f="uploads/".$r['foto'];
    if($r['foto'] && is_file($f)) unlink($f);
}

header("Location:index.php");
exit;
?>