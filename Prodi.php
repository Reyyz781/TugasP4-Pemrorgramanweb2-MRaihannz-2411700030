<?php
class Prodi {
    private $conn;
    private $table_name = "prodi";

    public $id;
    public $prodi_jurusan;
    public $kode_prodi;
    public $status;
    public $jenjang;
    public $kaprodi;
    public $fakultas;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create table jika belum ada
    public function createTable() {
        $query = "CREATE TABLE IF NOT EXISTS " . $this->table_name . " (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            prodi_jurusan VARCHAR(255) NOT NULL,
            kode_prodi VARCHAR(10) NOT NULL UNIQUE,
            status ENUM('aktif', 'tidak aktif') DEFAULT 'aktif',
            jenjang ENUM('D3', 'S1', 'S2', 'S3') NOT NULL,
            kaprodi VARCHAR(255) NOT NULL,
            fakultas VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    // Create - Tambah data prodi
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET prodi_jurusan=:prodi_jurusan, kode_prodi=:kode_prodi, 
                     status=:status, jenjang=:jenjang, kaprodi=:kaprodi, fakultas=:fakultas";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->prodi_jurusan = htmlspecialchars(strip_tags($this->prodi_jurusan));
        $this->kode_prodi = htmlspecialchars(strip_tags($this->kode_prodi));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->jenjang = htmlspecialchars(strip_tags($this->jenjang));
        $this->kaprodi = htmlspecialchars(strip_tags($this->kaprodi));
        $this->fakultas = htmlspecialchars(strip_tags($this->fakultas));

        // Bind parameters
        $stmt->bindParam(":prodi_jurusan", $this->prodi_jurusan);
        $stmt->bindParam(":kode_prodi", $this->kode_prodi);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":jenjang", $this->jenjang);
        $stmt->bindParam(":kaprodi", $this->kaprodi);
        $stmt->bindParam(":fakultas", $this->fakultas);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read - Ambil semua data prodi
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read One - Ambil satu data prodi berdasarkan ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->prodi_jurusan = $row['prodi_jurusan'];
            $this->kode_prodi = $row['kode_prodi'];
            $this->status = $row['status'];
            $this->jenjang = $row['jenjang'];
            $this->kaprodi = $row['kaprodi'];
            $this->fakultas = $row['fakultas'];
            return true;
        }
        return false;
    }

    // Update - Update data prodi
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                 SET prodi_jurusan=:prodi_jurusan, kode_prodi=:kode_prodi, 
                     status=:status, jenjang=:jenjang, kaprodi=:kaprodi, fakultas=:fakultas
                 WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->prodi_jurusan = htmlspecialchars(strip_tags($this->prodi_jurusan));
        $this->kode_prodi = htmlspecialchars(strip_tags($this->kode_prodi));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->jenjang = htmlspecialchars(strip_tags($this->jenjang));
        $this->kaprodi = htmlspecialchars(strip_tags($this->kaprodi));
        $this->fakultas = htmlspecialchars(strip_tags($this->fakultas));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind parameters
        $stmt->bindParam(":prodi_jurusan", $this->prodi_jurusan);
        $stmt->bindParam(":kode_prodi", $this->kode_prodi);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":jenjang", $this->jenjang);
        $stmt->bindParam(":kaprodi", $this->kaprodi);
        $stmt->bindParam(":fakultas", $this->fakultas);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete - Hapus data prodi
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Search - Cari data prodi
    public function search($keywords) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE prodi_jurusan LIKE ? OR kode_prodi LIKE ? OR kaprodi LIKE ? OR fakultas LIKE ?
                 ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
        $stmt->bindParam(4, $keywords);

        $stmt->execute();
        return $stmt;
    }
}
?>