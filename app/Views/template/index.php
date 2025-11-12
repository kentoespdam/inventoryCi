<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0" />
    <title>Inventory</title>
    <?= $this->include('template/_css'); ?>
    <?= $this->renderSection('css_content') ?>
</head>

<body>
    <?= $this->include('template/_topbar'); ?>
    <?= $this->include('template/_sidebar'); ?>

    <div id='wrapper' class="container-fluid">
        <div class="main-content">
            <?= $this->renderSection('content') ?>
            <?= $this->include('template/_footer'); ?>
        </div>
    </div>

    <?= $this->include('template/_js'); ?>
    <?= $this->renderSection('js_content') ?>

    <?= $this->renderSection('modal_content') ?>
</body>

</html>