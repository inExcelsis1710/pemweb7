<?php
include ('koneksi.php');

$sql = "SELECT * FROM mahasiswa";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nim"] . "</td>";
        echo "<td>" . $row["nama"] . "</td>";
        echo "<td>" . $row["program_studi"] . "</td>";
        echo "<td>
                <button onclick='editData(\"" . $row["nim"] . "\")'>Edit</button>
                <button onclick='hapusData(\"" . $row["nim"] . "\")'>Hapus</button>
              </td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Tidak ada data mahasiswa.</p>";
}

$conn->close();
?>
