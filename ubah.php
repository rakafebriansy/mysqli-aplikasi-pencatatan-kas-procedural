<?php

require_once 'app/Config/Database.php';
require_once 'app/Services/KasService.php';
require_once 'app/Helpers/Helper.php';

$mysqli = getConnection();
$id = $_POST['id'];
$nama = $_POST['nama'];
$tanggal_pembayaran = $_POST['tanggal'];
$nominal = (int)$_POST['nominal'];

try {
    ubahKas($mysqli, $id, $nama, $tanggal_pembayaran, $nominal);
    $message = 'Data berhasil diperbarui.';
    redirectMsg('/', $message, false);
} catch (\Exception $e) {
    redirectMsg('/',$e->getMessage(), true);
}