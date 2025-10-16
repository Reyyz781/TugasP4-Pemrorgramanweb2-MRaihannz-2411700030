<form method="POST">
    <input type="hidden" name="action" value="create">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Program Studi/Jurusan *</label>
            <input type="text" name="prodi_jurusan" class="form-control" required placeholder="Contoh: Teknik Informatika">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Kode Prodi *</label>
            <input type="text" name="kode_prodi" class="form-control" required placeholder="Contoh: TI01">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-control" required>
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Jenjang *</label>
            <select name="jenjang" class="form-control" required>
                <option value="D3">D3</option>
                <option value="S1" selected>S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Kaprodi *</label>
            <input type="text" name="kaprodi" class="form-control" required placeholder="Contoh: Dr. Ahmad Wijaya">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Fakultas *</label>
        <input type="text" name="fakultas" class="form-control" required placeholder="Contoh: Fakultas Teknik">
    </div>
    <button type="submit" class="btn btn-primary">Tambah Program Studi</button>
</form>