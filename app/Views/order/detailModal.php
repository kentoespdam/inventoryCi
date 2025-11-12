<div class="modal fade" id="modalDetail" role="dialog" aria-labelledby="modalDetail">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <h2 class="modal-header">Input Detail Order</h2>
            <div class="modal-body">
                <div class="card-content">
                    <form id="frmDetail" action="#" method="post" class="form-horizontal" onsubmit="return false">
                        <div class="form-group">
                            <label for="kode" class="control-label col-lg-4">Kode</label>
                            <div class="col-lg-6">
                                <select name="kode" id="kode" class="form-control select2"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kdBarang" class="control-label col-lg-4">Kd Barang</label>
                            <div class="col-lg-6">
                                <select name="kdBarang" id="kdBarang" class="form-control select2"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ukuran" class="control-label col-lg-4">Ukuran</label>
                            <div class="col-lg-6">
                                <input type="text" name="ukuran" id="ukuran" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="satuan" class="control-label col-lg-4">Satuan</label>
                            <div class="col-lg-6">
                                <input type="text" name="satuan" id="satuan" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keluar" class="control-label col-lg-4">Total Keluar</label>
                            <div class="col-lg-6">
                                <input type="text" name="keluar" id="keluar" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rata" class="control-label col-lg-4">Rata-Rata</label>
                            <div class="col-lg-6">
                                <input type="text" name="rata" id="rata" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jml" class="control-label col-lg-4">Stok</label>
                            <div class="col-lg-6">
                                <input type="text" name="jml" id="jml" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="minta" class="control-label col-lg-4">Diminta</label>
                            <div class="col-lg-6">
                                <input type="text" name="minta" id="minta" class="form-control" />
                            </div>
                        </div>

                        <hr class="garisBawah">
                        <button id="btSimpanDetail" class="btn btn-primary btn-block">SIMPAN</button>
                        <span id="btBatalDetail" class="btn btn-danger btn-block">BATAL</span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>