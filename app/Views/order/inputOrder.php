<div class="col-lg-4 col-md-12 col-sm-12">
    <fieldset>
        <legend>Order</legend>

        <div class="form-group">
            <label for="tgltrans" class="control-label col-lg-3">Tanggal</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <input type="hidden" name="created_by" id="created_by">
                    <input type="text" name="tgltrans" id="tgltrans" class="form-control" readonly required>
                    <span class="input-group-addon bg-primary text-white">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="lewat" class="control-lable col-lg-3">Nomor</label>
            <div class="col-lg-9">
                <input type="text" name="nomor" id="nomor" class="form-control" placeholder="nomor surat">
            </div>
        </div>

        <div class="form-group">
            <label for="lewat" class="control-lable col-lg-3">Lewat</label>
            <div class="col-lg-9">
                <input type="text" name="lewat" id="lewat" class="form-control" placeholder="lewat">
            </div>
        </div>

        <div class="form-group">
            <label for="lewat" class="control-lable col-lg-3">Sifat</label>
            <div class="col-lg-9">
                <!-- <input type="text" name="sifat" id="sifat" class="form-control" placeholder="sifat surat"> -->
                <select name="sifat" id="sifat" class="form-control select2" required>
                    <option value="Tidak Urgent">Tidak Urgent</option>
                    <option value="Urgent">Urgent</option>
                    <option value="Sangat Urgent">Sangat Urgent</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="perihal" class="control-label col-lg-3">Perihal</label>
            <div class="col-lg-9">
                <textarea name="perihal" id="perihal" cols="30" rows="10" class="form-control textarea" required></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="unit" class="control-label col-lg-3">Unit</label>
            <div class="col-lg-9">
                <select name="unit" id="unit" class="form-control select2" require></select>
            </div>
        </div>

        <div class="form-group">
            <label for="spv" class="control-label col-lg-3">Supervisor</label>
            <div class="col-lg-9">
                <select name="spv" id="spv" class="form-control select2" required></select>
            </div>
        </div>

        <div class="form-group">
            <label for="manager" class="control-label col-lg-3">Manager</label>
            <div class="col-lg-9">
                <select name="manager" id="manager" class="form-control select2" required></select>
            </div>
        </div>

        <div class="form-group">
            <label for="direksi" class="control-label col-lg-3">Direksi</label>
            <div class="col-lg-9">
                <select name="direksi" id="direksi" class="form-control select2" required></select>
            </div>
        </div>

        <div class="form-group">
            <label for="keterangan" class="conteol-label col-lg-3">Keterangan</label>
            <div class="col-lg-9">
                <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control textarea"></textarea>
            </div>
        </div>
    </fieldset>
</div>