<?php $this->extend('template/index'); ?>

<?php $this->section('content') ?>
<div class="col-lg-12" id="box-table">
    <div class="box-content bordered primary">
        <h4 class="box-title">
            <i class="ico glyphicon glyphicon-home"></i>
            List Order
        </h4>
        <div class="card-content">
            <form action="#" id="frm" class="frm-horizontal" onsubmit="return false;">
                <div class="form-group">
                    <div class="col-lg-3">
                        <div class="input-group date">
                            <input type="text" id="tgl" name="tgl" class="form-control">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                </div>
                <button id="cari" class="btn btn-xs btn-primary">CARI</button>
            </form>
            <hr class="garisBawah">
            <table class="table hovered bordered nowrap" id="tbl" width="100%"></table>
        </div>
    </div>
    <!-- /.box-content -->
</div>

<?php $this->endSection() ?>

<?php $this->section('js_content') ?>
<script type="module" defer src="/assets/custom/js/order/arsip.js"></script>
<?php $this->endSection() ?>