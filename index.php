<?php
include_once 'config.php';
include_once 'Prodi.php';

$database = new Database();
$db = $database->getConnection();
$prodi = new Prodi($db);

// Create table jika belum ada
$prodi->createTable();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$search_keyword = isset($_POST['search']) ? $_POST['search'] : '';

// Handle form actions - PERBAIKAN: Cek apakah $_POST ada dan memiliki action
if($_POST && isset($_POST['action'])){
    $form_action = $_POST['action'];
    
    if($form_action == 'create'){
        $prodi->prodi_jurusan = $_POST['prodi_jurusan'];
        $prodi->kode_prodi = $_POST['kode_prodi'];
        $prodi->status = $_POST['status'];
        $prodi->jenjang = $_POST['jenjang'];
        $prodi->kaprodi = $_POST['kaprodi'];
        $prodi->fakultas = $_POST['fakultas'];
        
        if($prodi->create()){
            echo "<div class='alert alert-success'>Program Studi berhasil ditambahkan.</div>";
        } else{
            echo "<div class='alert alert-danger'>Gagal menambahkan Program Studi.</div>";
        }
    }
    
    if($form_action == 'update'){
        $prodi->id = $_POST['id'];
        $prodi->prodi_jurusan = $_POST['prodi_jurusan'];
        $prodi->kode_prodi = $_POST['kode_prodi'];
        $prodi->status = $_POST['status'];
        $prodi->jenjang = $_POST['jenjang'];
        $prodi->kaprodi = $_POST['kaprodi'];
        $prodi->fakultas = $_POST['fakultas'];
        
        if($prodi->update()){
            echo "<div class='alert alert-success'>Program Studi berhasil diupdate.</div>";
        } else{
            echo "<div class='alert alert-danger'>Gagal mengupdate Program Studi.</div>";
        }
    }
}

// Handle delete
if($action == 'delete'){
    $prodi->id = $id;
    if($prodi->delete()){
        echo "<div class='alert alert-success'>Program Studi berhasil dihapus.</div>";
    } else{
        echo "<div class='alert alert-danger'>Gagal menghapus Program Studi.</div>";
    }
}

// Read data
if($search_keyword){
    $stmt = $prodi->search($search_keyword);
} else {
    $stmt = $prodi->read();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Program Studi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .table-responsive { margin-top: 20px; }
        .btn-group { margin-bottom: 20px; }
        .alert { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Sistem CRUD Program Studi</h2>
        
        <!-- Form Pencarian -->
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari program studi, kode, kaprodi, atau fakultas..." value="<?php echo htmlspecialchars($search_keyword); ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="index.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Form Tambah/Edit Data -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <?php echo ($action == 'edit' && $id) ? 'Edit Program Studi' : 'Tambah Program Studi Baru'; ?>
            </div>
            <div class="card-body">
                <?php
                if($action == 'edit' && $id){
                    $prodi->id = $id;
                    if($prodi->readOne()){
                        // Form edit
                        include 'form_edit.php';
                    } else {
                        echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>";
                        // Tampilkan form create sebagai fallback
                        include 'form_create.php';
                    }
                } else {
                    // Form create
                    include 'form_create.php';
                }
                ?>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Daftar Program Studi</span>
                    <span class="badge bg-light text-dark">
                        Total: <?php echo $stmt->rowCount(); ?> Data
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="50">ID</th>
                                <th>Program Studi/Jurusan</th>
                                <th width="120">Kode Prodi</th>
                                <th width="100">Status</th>
                                <th width="80">Jenjang</th>
                                <th>Kaprodi</th>
                                <th>Fakultas</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($stmt->rowCount() > 0){
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    extract($row);
                                    $status_badge = $status == 'aktif' ? 'success' : 'danger';
                                    echo "<tr>";
                                    echo "<td>{$id}</td>";
                                    echo "<td><strong>{$prodi_jurusan}</strong></td>";
                                    echo "<td><code>{$kode_prodi}</code></td>";
                                    echo "<td><span class='badge bg-{$status_badge}'>{$status}</span></td>";
                                    echo "<td>{$jenjang}</td>";
                                    echo "<td>{$kaprodi}</td>";
                                    echo "<td>{$fakultas}</td>";
                                    echo "<td class='text-center'>";
                                    echo "<a href='index.php?action=edit&id={$id}' class='btn btn-warning btn-sm'>Edit</a> ";
                                    echo "<a href='index.php?action=delete&id={$id}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus {$prodi_jurusan}?\")'>Hapus</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center py-4'>";
                                if($search_keyword) {
                                    echo "Tidak ada data yang cocok dengan pencarian '<strong>" . htmlspecialchars($search_keyword) . "</strong>'.";
                                } else {
                                    echo "Belum ada data program studi. Silakan tambah data baru.";
                                }
                                echo "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>