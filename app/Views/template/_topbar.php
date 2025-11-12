<div class='fixed-navbar'>
    <div class="pull-left">
        <button class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile" onclick="setAktif()"></button>
        <h1 class="page-title">Perumdam TS</h1>
    </div>

    <div class="pull-right">
        <div class="ico-item fa fa-user">
            <span class="page-title"><?= $_SESSION['nama'] ?></span>
            <input type="hidden" id="sesNipam" value="<?= $_SESSION['nipam']; ?>">
            <!-- <i class="fa fa-user"></i> -->
            <!-- <img src="/assets/images/logo.svg" alt="" class="ico-img" /> -->
            <ul class="sub-ico-item bg-danger" style="color:white;">
                <li>
                    <a href="/Auth/logout" style="color:white; font-weight:bold;">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    const setAktif = (aktif) => {
        document.body.classList.toggle('menu-active')
    }
</script>