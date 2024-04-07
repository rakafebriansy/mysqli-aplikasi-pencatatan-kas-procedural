<?php

require_once 'app/Config/Database.php';
require_once 'app/Services/KasService.php';
require_once 'app/Helpers/Helper.php';

$mysqli = getConnection();
$id = (int)$_POST['id'];

try {
    hapusKas($mysqli,$id);
    $message = 'Data telah berhasil dihapus.';
    redirectMsg('/', $message, false);
} catch (\Exception $e) {
    redirectMsg('/',$e->getMessage(), true);
}