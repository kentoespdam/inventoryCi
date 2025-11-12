<?php $this->extend('template/index'); ?>

<?php $this->section('content') ?>
<div class="col-lg-12" id="box-table">
    <div class="box-content bordered primary">
        <h4 class="box-title">
            <i class="ico glyphicon glyphicon-home"></i>
            List Order
        </h4>
        <div class="card-content ">
            <table class="table hovered bordered display" id="tbl" width="100%"></table>
            <hr class="garisBawah">
            <button id="btBuatOrder" class="btn btn-block btn-primary">Buat Order</button>
        </div>
    </div>
    <!-- /.box-content -->
</div>

<div class="col-lg-12" id="box-form">
    <div class="box-content bordered primary">
        <h4 class="box-title">
            <i class="ico glyphicon glyphicon-home"></i>
            Input Order
        </h4>
        <div class="card-content">
            <form id="frm" action="#" method="post" class="form-horizontal">
                <?= $this->include('order/inputOrder') ?>
                <?= $this->include('order/detailOrder') ?>
                <div class="col-lg-12">
                    <hr class="garisBawah">
                    <button id="btSimpan" class="btn btn-primary btn-block">SIMPAN</button>
                    <span id="btBatal" class="btn btn-danger btn-block">BATAL</span>
                </div>
            </form>
        </div>
    </div>
    <!-- /.box-content -->
</div>
<?php $this->endSection() ?>

<?php $this->section('js_content') ?>
<script type="module" defer src="/assets/custom/js/order/script.js"></script>
<script type="module" defer src="/assets/custom/js/order/form.js"></script>
<script type="module" defer src="/assets/custom/js/order/formDetail.js"></script>
<?php $this->endSection() ?>

<?php $this->section('modal_content') ?>
<?= $this->include('order/detailModal') ?>
<?php $this->endSection() ?>