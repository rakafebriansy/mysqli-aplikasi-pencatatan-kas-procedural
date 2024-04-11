<?php

require_once 'app/Config/Database.php';
require_once 'app/Services/KasService.php';
require_once 'app/Helpers/Helper.php';

$mysqli = getConnection();
$nama = $_POST['nama'];
$tanggal_pembayaran = $_POST['tanggal'];
$nominal = $_POST['nominal'];

try {
    tambahKas($mysqli, $nama, $tanggal_pembayaran, $nominal);
    $message = 'Data berhasil ditambah.';
    redirectMsg('/',$message,false);
} catch (\Exception $e) {
    redirectMsg('/',$e->getMessage(),true);
}