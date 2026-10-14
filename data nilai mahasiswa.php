<?php

function tentukanGrade($nilai) {
    if ($nilai >= 85) return "A";
    elseif ($nilai >= 75) return "B";
    elseif ($nilai >= 65) return "C";
    elseif ($nilai >= 50) return "D";
    else return "E";
}

function hitungRataRata($daftarNilai) {
    return array_sum($daftarNilai) / count($daftarNilai);
}

$nim = $nama = $fakultas = $prodi = $semester = "";
$mata_kuliah = [];
$nilaiMatkul = [];
$rata_rata = $gradeAkhir = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST["nim"];
    $nama = $_POST["nama"];
    $fakultas = $_POST["fakultas"];
    $prodi = $_POST["prodi"];
    $semester = $_POST["semester"];
    $mata_kuliah = $_POST["mata_kuliah"];
    $nilaiMatkul = $_POST["nilai"];
    $rata_rata = hitungRataRata($nilaiMatkul);
    $gradeAkhir = tentukanGrade($rata_rata);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #0b3c6d; margin: 0; padding: 30px; }
        .container { width: 700px; margin: auto; background-color: #f0f0f0; padding: 25px; border-radius: 10px; }
        h1 { text-align: center; color: #04264a; }
        label { display: block; margin-top: 15px; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; box-sizing: border-box; }
        button { margin-top: 20px; width: 100%; padding: 12px; background-color: #234f7d; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #163652; }
        table { border-collapse: collapse; margin-top: 20px; width: 100%; }
        th, td { border: 1px solid #050505; padding: 8px 14px; text-align: center; }
        th { background: #2c5282; color: #fff; }
        .hasil { margin-top: 30px; padding: 20px; background-color: #eef5fa; border-radius: 8px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Input Data Mahasiswa</h1>
    <form method="POST">
        <label>NIM</label>
        <input type="text" name="nim" required>
        <label>Nama Mahasiswa</label>
        <input type="text" name="nama" required>
        <label>Fakultas</label>
        <input type="text" name="fakultas" required>
        <label>Program Studi</label>
        <input type="text" name="prodi" required>
        <label>Semester</label>
        <select name="semester" required>
            <option value="">-- Pilih Semester --</option>
            <?php for ($i=1; $i<=8; $i++) echo "<option value='$i'>Semester $i</option>"; ?>
        </select>

        <h3>Nilai Mata Kuliah</h3>
        <label>Pemrograman Web</label>
        <input type="number" name="nilai[]" step="0.01" required>
        <label>Basis Data</label>
        <input type="number" name="nilai[]" step="0.01" required>
        <label>Algoritma dan Struktur Data</label>
        <input type="number" name="nilai[]" step="0.01" required>
        <label>Jaringan Komputer</label>
        <input type="number" name="nilai[]" step="0.01" required>

        <button type="submit">Simpan Data</button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
    <div class="hasil">
        <h2>Laporan Nilai Mahasiswa</h2>
        <p><strong>NIM:</strong> <?= htmlspecialchars($nim) ?></p>
        <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
        <p><strong>Fakultas:</strong> <?= htmlspecialchars($fakultas) ?></p>
        <p><strong>Program Studi:</strong> <?= htmlspecialchars($prodi) ?></p>
        <p><strong>Semester:</strong> <?= htmlspecialchars($semester) ?></p>

        <table>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>Nilai</th>
                <th>Grade</th>
                <th>Keterangan</th>
            </tr>
            <?php
            $mataKuliahList = ["Pemrograman Web", "Basis Data", "Algoritma dan Struktur Data", "Jaringan Komputer"];
            $no = 1;
            foreach ($nilaiMatkul as $index => $nilai) {
                $grade = tentukanGrade($nilai);
                echo "<tr>";
                echo "<td>$no</td>";
                echo "<td>{$mataKuliahList[$index]}</td>";
                echo "<td>" . number_format($nilai, 2) . "</td>";
                echo "<td>$grade</td>";
                echo "<td>" . ($nilai >= 65 ? "Lulus" : "Tidak Lulus") . "</td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </table>

        <p><strong>Rata-rata:</strong> <?= number_format($rata_rata, 2) ?></p>
        <p><strong>Grade Akhir:</strong> <?= $gradeAkhir ?></p>
        <p><strong>Keterangan:</strong> <?= $rata_rata >= 65 ? "LULUS" : "TIDAK LULUS" ?></p>
    </div>
    <?php } ?>
</div>
</body>
</html>
