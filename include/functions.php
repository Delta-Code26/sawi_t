<?php
include './include/koneksi.php';

// Function to fetch all data from a table
function fetchAll($conn, $table)
{
    $sql = "SELECT * FROM $table";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        $data[] = $row;
    }
    return $data;
}

// Function to fetch data by ID for a table
function fetchById($conn, $table, $id_column, $id_value)
{
    $sql = "SELECT * FROM $table WHERE $id_column = '$id_value'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_array($result, MYSQLI_BOTH);
}

// Function to add data to a table
function addData($conn, $table, $data)
{
    $columns = implode(", ", array_keys($data));
    $values = implode("', '", array_values($data));
    $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
    return mysqli_query($conn, $sql);
}

// Function to update data in a table
function updateData($conn, $table, $data, $id_column, $id_value)
{
    $set_values = [];
    foreach ($data as $column => $value) {
        $set_values[] = "$column = '$value'";
    }
    $set_values_string = implode(", ", $set_values);
    $sql = "UPDATE $table SET $set_values_string WHERE $id_column = '$id_value'";
    return mysqli_query($conn, $sql);
}

// Function to delete data from a table
function deleteData($conn, $table, $id_column, $id_value)
{
    $sql = "DELETE FROM $table WHERE $id_column = '$id_value'";
    return mysqli_query($conn, $sql);
}

// Function to search data in a table based on a keyword
function searchData($conn, $table, $column, $keyword)
{
    $sql = "SELECT * FROM $table WHERE $column LIKE '%$keyword%'";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        $data[] = $row;
    }
    return $data;
}


// panen create
function addPanen($conn, $data)
{
    $columns = implode(", ", array_keys($data));
    $values  = implode("', '", array_values($data));
    $sql = "INSERT INTO tb_panen ($columns) VALUES ('$values')";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        return false;
    }
}

// panen read
function fetchPanen($conn)
{
    $sql = "SELECT * FROM tb_panen";
    $result = mysqli_query($conn, $sql);
    $panen = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $panen[] = $row;
        }
    }

    return $panen;
}

function fetchPanenById($conn, $id)
{
    $sql = "SELECT * FROM tb_panen WHERE id_panen = '$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// panen update
function updatePanen($conn, $data, $id)
{
    $set = "";
    foreach ($data as $column => $value) {
        $set .= "$column = '$value', ";
    }
    $set = rtrim($set, ", ");

    $sql = "UPDATE tb_panen SET $set WHERE id_panen = '$id'";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        return false;
    }
}

// panen delete
function deletePanen($conn, $id)
{
    $sql = "DELETE FROM tb_panen WHERE id_panen = '$id'";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        return false;
    }
}

// mendapatkan id panen terbaru
function getNewPanenID($conn)
{
    $tanggal_sekarang = date('Ym');
    $cari_id_panen = mysqli_query($conn, "SELECT id_panen FROM tb_panen ORDER BY id_panen DESC LIMIT 1");

    if (mysqli_num_rows($cari_id_panen) > 0) {
        $data_id_panen = mysqli_fetch_array($cari_id_panen);
        $kode = $data_id_panen['id_panen'];
        $bulan_id_terakhir = substr($kode, 1, 6);

        if ($bulan_id_terakhir == $tanggal_sekarang) {
            $urut = (int)substr($kode, 7, 3) + 1;
        } else {
            $urut = 1;
        }
    } else {
        $urut = 1;
    }

    $nomor_urut = str_pad($urut, 3, '0', STR_PAD_LEFT);
    return 'H' . $tanggal_sekarang . $nomor_urut;
}

// mengambil data team
function getTeams($conn)
{
    $sql_team = "SELECT id_team, nama_team FROM tb_team";
    return mysqli_query($conn, $sql_team);
}

// mengambil data task
function getTasks($conn)
{
    $sql_task = "SELECT id_task, nama_task AS nama_task FROM tb_task";
    return mysqli_query($conn, $sql_task);
}

// menyimpan data panen
function savePanen($conn, $id_panen, $tgl_panen, $total_tandan, $total_berat, $id_team, $id_task)
{
    if ($total_tandan > 0) {
        $average_berat = $total_berat / $total_tandan;
    } else {
        $average_berat = 0;
    }

    $sql_insert = "INSERT INTO tb_panen (id_panen, tgl_panen, total_tandan, total_berat, average_berat, id_team, id_task)
                   VALUES ('$id_panen', '$tgl_panen', '$total_tandan', '$total_berat', '$average_berat', '$id_team', '$id_task')";

    return mysqli_query($conn, $sql_insert);
}

// mengambil data panen
function getPanenData($conn, $keyword = '')
{
    $sql_panen = "SELECT tb_panen.id_panen, tb_task.nama_task, tb_team.nama_team, tb_panen.tgl_panen, tb_panen.total_tandan, tb_panen.total_berat, tb_panen.average_berat
                  FROM tb_panen
                  INNER JOIN tb_task ON tb_panen.id_task = tb_task.id_task
                  INNER JOIN tb_team ON tb_panen.id_team = tb_team.id_team";

    if ($keyword) {
        $sql_panen .= " WHERE tb_task.nama_task LIKE '%$keyword%' OR tb_team.nama_team LIKE '%$keyword%'";
    }

    return $conn->query($sql_panen);
}
