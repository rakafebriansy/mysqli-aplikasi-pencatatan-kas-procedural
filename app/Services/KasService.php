<?php

function tambahKas(\mysqli $connection, string $nama, string $tanggal_pembayaran, int $nominal): int
{
    validateKas($nama, $tanggal_pembayaran, $nominal);
    mysqli_begin_transaction($connection);
    try {
        $stmt = mysqli_prepare($connection, 'INSERT INTO kas (nama, tanggal_pembayaran, nominal) VALUES (?,?,?)');
        mysqli_stmt_bind_param($stmt, 'ssi', $nama, $tanggal_pembayaran, $nominal);
        if($stmt->execute()) {
            $id = mysqli_insert_id($connection);
        }
        mysqli_commit($connection);
        return $id;
    } catch (\Exception $e) {
        mysqli_rollback($connection);
        throw $e;
    }
}
function lihatSemuaKas(\mysqli $connection): array
{
    mysqli_begin_transaction($connection);
    try {
        $result = mysqli_query($connection, 'SELECT * FROM kas ORDER BY tanggal_pembayaran ASC');
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        mysqli_commit($connection);
        return $rows;
    } catch (\Exception $e){
        mysqli_rollback($connection);
        throw $e;
    }
}
function hapusKas(\mysqli $connection, int $id): void
{
    mysqli_begin_transaction($connection);
    try {
        $stmt = mysqli_prepare($connection, 'DELETE FROM kas WHERE id=? ');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $stmt->execute();
        mysqli_commit($connection);
    } catch (\Exception $e) {
        mysqli_rollback($connection);
        throw $e;
    }
}
function ubahKas(\mysqli $connection, int $id, string $nama, string $tanggal_pembayaran, int $nominal): void
{
    validateKas($nama, $tanggal_pembayaran, $nominal);
    mysqli_begin_transaction($connection);
    try {
        $stmt = mysqli_prepare($connection, 'UPDATE kas SET nama = ?, tanggal_pembayaran = ?, nominal = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'sssi', $nama, $tanggal_pembayaran, $nominal, $id);
        $stmt->execute();
        mysqli_commit($connection);
    } catch (\Exception $e) {
        mysqli_rollback($connection);
        throw $e;
    }
}
function jumlahKasPerBulan(\mysqli $connection): string
{
    try {
        $query = <<<SQL
        SELECT EXTRACT(YEAR FROM tanggal_pembayaran) AS tahun, EXTRACT(MONTH FROM tanggal_pembayaran) AS bulan, 
        SUM(nominal) AS total FROM kas
        GROUP BY EXTRACT(YEAR FROM tanggal_pembayaran), EXTRACT(MONTH FROM tanggal_pembayaran)
        ORDER BY tahun, bulan;
        SQL;
        $result = mysqli_query($connection, $query);
        $raw = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);
        $sum = sumMap($raw);
        mysqli_commit($connection);
        return json_encode($sum);
    } catch (\Exception $e){
        mysqli_rollback($connection);
        throw $e;
    }
}
function validateKas(string $nama, string $tanggal_pembayaran, int $nominal): void
{
    if ($nama == null || trim($nama) == '') {
        throw new \Exception('Nama tidak boleh kosong!');
    }
    if ($tanggal_pembayaran == null || trim($tanggal_pembayaran) == '') {
        throw new \Exception('tanggal_pembayaran tidak boleh kosong!');
    }
    if ($nominal == null || $nominal == 0) {
        throw new \Exception('Nominal tidak boleh nol!');
    }
}
function sumMap(array $raw): array
{
    $sum = [];
    foreach($raw as $item) {
        if(!isset($sum[$item['tahun']])) $sum[$item['tahun']] = [0,0,0,0,0,0,0,0,0,0,0,0];
        $index = (int)$item['bulan']-1;
        $sum[$item['tahun']][$index] = (int)$item['total'];
    }
    return $sum;
}

