<form method="POST">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?php echo $prodi->id; ?>">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Program Studi/Jurusan *</label>
            <input type="text" name="prodi_jurusan" class="form-control" value="<?php echo $prodi->prodi_jurusan; ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Kode Prodi *</label>
            <input type="text" name="kode_prodi" class="form-control" value="<?php echo $prodi->kode_prodi; ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-control" required>
                <option value="aktif" <?php echo $prodi->status == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="tidak aktif" <?php echo $prodi->status == 'tidak aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Jenjang *</label>
            <select name="jenjang" class="form-control" required>
                <option value="D3" <?php echo $prodi->jenjang == 'D3' ? 'selected' : ''; ?>>D3</option>
                <option value="S1" <?php echo $prodi->jenjang == 'S1' ? 'selected' : ''; ?>>S1</option>
                <option value="S2" <?php echo $prodi->jenjang == 'S2' ? 'selected' : ''; ?>>S2</option>
                <option value="S3" <?php echo $prodi->jenjang == 'S3' ? 'selected' : ''; ?>>S3</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Kaprodi *</label>
            <input type="text" name="kaprodi" class="form-control" value="<?php echo $prodi->kaprodi; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Fakultas *</label>
        <input type="text" name="fakultas" class="form-control" value="<?php echo $prodi->fakultas; ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Update Program Studi</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>