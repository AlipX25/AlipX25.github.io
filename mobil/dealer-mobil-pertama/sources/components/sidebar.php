<div class="side-bar side-bar-lg-active" data-theme="purple">
    <!-- Brand details -->
    <div class="side-menu-brand d-flex flex-column justify-content-center align-items-center clear mt-3">
        <a href="<?php echo $sourcePath; ?>/../index.php" class="brand-name mt-2 ml-2 font-weight-bold">Diamond Cars</a>
    </div>
    <!-- Side bar menu -->
    <div class="the_menu mt-5">
        <!-- Heading -->
        <div class="side-menu-heading d-flex">
            <h6 class=" font-weight-bold pb-2 mx-3"> Halo, <?php echo $sessionNamaLengkap ?></h6>
            <a href="<?php echo $sourcePath; ?>/logout.php" class="font-weight-bold ml-auto px-3">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>

        <!-- Menu item -->
        <div id="accordion">
            <ul class="side-menu p-0 m-0 mt-3">
                <li class="side-menu-item px-3"><a href="<?php echo $sourcePath; ?>/../index.php" class="w-100 py-3 pl-4">Dashboard</a></li>

                <?php if ($sessionType == "user") { ?>
                    <!-- Sub menu parent -->
                    <li class="side-menu-item px-3"><a href="<?php echo $sourcePath; ?>/models/merk/tabel.php" class="w-100 py-3 pl-4">Merk</a></li>
                    <li class="side-menu-item px-3"><a href="<?php echo $sourcePath; ?>/models/jenis/tabel.php" class="w-100 py-3 pl-4">Jenis Mobil</a></li>
                    <li class="side-menu-item px-3"><a href="<?php echo $sourcePath; ?>/models/mobil/tabel.php" class="w-100 py-3 pl-4">Mobil</a></li>

                    <?php if (checkRole($sessionRole, 3)) { ?>
                        <li class="side-menu-item px-3"><a href="<?php echo $sourcePath; ?>/models/user/tabel.php" class="w-100 py-3 pl-4">User</a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>