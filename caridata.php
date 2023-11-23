<?php
include('koneksi.php');

$prodi = isset($_GET['prodi']) ? $_GET['prodi'] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if (!empty($prodi) || !empty($keyword)) {
    $sql = "SELECT * FROM mahasiswa WHERE LOWER(program_studi) LIKE LOWER(?)";
    if (!empty($prodi)) {
        $sql .= " AND LOWER(program_studi) = LOWER(?)";
    }
    $stmt = $conn->prepare($sql);

    $param_keyword = '%' . strtolower($keyword) . '%';
    
    if (!empty($prodi)) {
        $param_prodi = strtolower($prodi);
        $stmt->bind_param('ss', $param_keyword, $param_prodi);
    } else {
        $stmt->bind_param('s', $param_keyword);
    }

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["nim"] . "</td><td>" . $row["nama"] . "</td><td>" . $row["program_studi"] . "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Program studi tidak ditemukan.</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='3'>Masukkan kata kunci atau pilih program studi untuk mencari data.</td></tr>";
}

$conn->close();
?>
