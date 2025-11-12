<?php $this->extend('template/index'); ?>

<?php $this->section('content') ?>
<div class="col-lg-12 col-md-12 col-xs-12">
    <div class="box-content bordered primary">
        <h4 class="box-title">
            <i class="ico glyphicon glyphicon-home"></i>
            Stok Barang
        </h4>
        <div class="card-content">
            <?= $this->include('dashboard/filter') ?>
            <hr class="garisBawah">
            <table class="table hovered bordered" id="tbl" width="100%"></table>
        </div>
    </div>
    <!-- /.box-content -->
</div>
<?php $this->endSection() ?>

<?php $this->section('js_content') ?>
<script type="module" defer src="/assets/custom/js/dashboard/script.js"></script>
<?php $this->endSection() ?>