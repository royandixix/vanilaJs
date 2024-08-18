<?php

// koneksikan ke database
$db = mysqli_connect("localhost", "root", "", "db_crud_php");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Cek jika fungsi query sudah dideklarasikan
if (!function_exists('query')) {
    function query($query)
    {
        global $db;
        $result = mysqli_query($db, $query);
        if (!$result) {
            die("Query failed: " . mysqli_error($db));
        }
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

// Contoh penggunaan fungsi query untuk mendapatkan data dari tabel tbl_siswa
$data = query("SELECT * FROM tbl_siswa");

?>
