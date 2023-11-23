<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa Universitas Fontaine</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            width: 100%;
        }

        h2 {
            margin-bottom: 0;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 80%;
            text-align: center;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        input[type="text"] {
            padding: 8px;
        }

        select, button {
            padding: 10px;
            margin-right: 10px;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>DATA MAHASISWA UNIVERSITAS FONTAINE</h2><br>

<div style="margin-bottom: 20px;">
        <label for="prodi">Pilih Program Studi:</label>
        <select id="prodi">
            <option value="">Semua Program Studi</option>
            <?php
            include('koneksi.php');
            $sql = "SELECT DISTINCT program_studi FROM mahasiswa";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['program_studi'] . "'>" . $row['program_studi'] . "</option>";
            }
            ?>
        </select>

        <button onclick="cariData()">Cari</button>
    </div>

<form id="form-mahasiswa">
    NIM: <input type="text" name="nim" id="nim" required>
    Nama: <input type="text" name="nama" id="nama" required>
    Program Studi: <input type="text" name="program_studi" id="program_studi" required>
    <button type="button" onclick="simpanData()">Simpan</button>
</form>


<table border="1">
    <thead>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody id="tabel_mahasiswa">
    </tbody>
</table>

<script>
function editData(nim) {
    var nama = prompt("Masukkan nama baru:");
    var program_studi = prompt("Masukkan program studi baru:");

    $.ajax({
        type: "POST",
        url: "ubahdata.php",
        data: { aksi: "edit", nim: nim, nama: nama, program_studi: program_studi },
        success: function(response) {
            alert(response);
            tampilkanDataMahasiswa();
        }
    });
}

function hapusData(nim) {
    var konfirmasi = confirm("Anda yakin ingin menghapus data?");
    if (konfirmasi) {
        $.ajax({
            type: "POST",
            url: "hapusdata.php",
            data: { aksi: "hapus", nim: nim },
            success: function(response) {
                alert(response);
                tampilkanDataMahasiswa();
            }
        });
    }
}

function simpanData() {
    var nim = $("#nim").val();
    var nama = $("#nama").val();
    var program_studi = $("#program_studi").val();

    $.ajax({
        type: "POST",
        url: "simpandata.php",
        data: { nim: nim, nama: nama, program_studi: program_studi },
        success: function(response) {
            alert(response);
            tampilkanDataMahasiswa();
        }
    });
}

function tampilkanDataMahasiswa() {
    $.ajax({
        type: "GET",
        url: "tampildata.php",
        success: function(response) {
            $("#tabel_mahasiswa").html(response);
        }
    });
}

function cariData() {
            var selectedProdi = $("#prodi").val();
            var keyword = $("#keyword").val();

            $.ajax({
                type: "GET",
                url: "caridata.php",
                data: { prodi: selectedProdi, keyword: keyword },
                success: function (response) {
                    $("#tabel_mahasiswa").html(response);
                }
            });
        }

$(document).ready(function() {
    tampilkanDataMahasiswa();
});
</script>

</body>
</html>
