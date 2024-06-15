<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data</title>
</head>

<body>
    <h2>Form Input Data</h2>
    <form method="POST" action="proses_input.php" id="inputForm">
        <label for="level">Pilih Level:</label>
        <select name="level" id="level" onchange="updateIdField()">
            <option value="admin">Admin</option>
            <option value="pekerja">Pekerja</option>
        </select>
        <br><br>
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" readonly>
        <br><br>
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama">
        <br><br>
        <label for="alamat">Alamat:</label>
        <input type="text" name="alamat" id="alamat">
        <br><br>
        <input type="submit" value="Submit">
    </form>

    <script>
        function updateIdField() {
            var level = document.getElementById("level").value;
            var idField = document.getElementById("id");

            // Reset nilai ID
            idField.value = "";

            if (level === "admin") {
                // Ambil ID terbaru dari admin
                <?php
                $sql_level_admin = "SELECT MAX(id_admin) AS max_id FROM tb_admin";
                $result_level_admin = mysqli_query($koneksi, $sql_level_admin);

                if ($result_level_admin) {
                    $row_level_admin = mysqli_fetch_assoc($result_level_admin);
                    if ($row_level_admin['max_id']) {
                        $last_number_admin = (int) substr($row_level_admin['max_id'], 1);
                        $new_number_admin = $last_number_admin + 1;
                        $new_id_admin = "A" . str_pad($new_number_admin, 3, '0', STR_PAD_LEFT);
                    } else {
                        $new_id_admin = "A001";
                    }
                    echo "idField.value = '$new_id_admin';";
                }
                ?>
            } else if (level === "pekerja") {
                // Ambil ID terbaru dari pekerja
                <?php
                $sql_level_pekerja = "SELECT MAX(id_pekerja) AS max_id FROM tb_pekerja";
                $result_level_pekerja = mysqli_query($koneksi, $sql_level_pekerja);

                if ($result_level_pekerja) {
                    $row_level_pekerja = mysqli_fetch_assoc($result_level_pekerja);
                    if ($row_level_pekerja['max_id']) {
                        $last_number_pekerja = (int) substr($row_level_pekerja['max_id'], 1);
                        $new_number_pekerja = $last_number_pekerja + 1;
                        $new_id_pekerja = "P" . str_pad($new_number_pekerja, 3, '0', STR_PAD_LEFT);
                    } else {
                        $new_id_pekerja = "P001";
                    }
                    echo "idField.value = '$new_id_pekerja';";
                }
                ?>
            }
        }
        // Panggil fungsi updateIdField() sekali pada awalnya untuk menetapkan nilai ID sesuai dengan level yang dipilih (jika ada)
        updateIdField();
    </script>
</body>

</html>