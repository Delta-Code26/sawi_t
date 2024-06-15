<nav id="sidebar" class="bg-primary">
    <div class="sidebar-header text-center mb-0">
        <h3><span class='text-white fw-bold'>Sime</span> Darby</h3>
        <strong><span class='text-white'>S</span>D</strong>
    </div>
    <ul class="list-unstyled components text-light">
        <li class="<?= (!isset($page) || $page === '') ? 'active' : '' ?>">
            <a href="index.php">
                <div class="row">
                    <div class='col-12 col-md-2 sidebar-item-icon'>
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="col-10">Dashboard</span>
                </div>
            </a>
        </li>
        <?php
        $menuAdmin = [
            [
                "label" => "Data Admin",
                "icon" => "fa-address-book",
                "href" => "data_admin",
            ],
            [

                "label" => "Data Pekerja",
                "icon" => "fa-address-book",
                "href" => "data_pekerja",
            ],
            [
                "label" => "Data Panen",
                "icon" => "fa-money-check",
                "href" => "data_panen",
            ],
            [

                "label" => "Laporan",
                "icon" => "fa-money-check",
                "href" => "laporan",
            ],
            [
                "label" => "Data Baja",
                "icon" => "fa-sync-alt",
                "href" => "data_baja",
            ],
            [
                "label" => "Data Team",
                "icon" => "fa-money-check",
                "href" => "data_team",
            ],
            [
                "label" => "Data Task",
                "icon" => "fa-route",
                "href" => "data_task",
            ],
            [
                "label" => "Data Gaji",
                "icon" => "fa-money-bill-wave",
                "href" => "data_gaji",
            ],
            [
                "label" => "Absensi",
                "icon" => "fa-money-bill-wave",
                "href" => "absensi",
            ],
            [
                "label" => "Tambah Users",
                "icon" => "fa-money-bill-wave",
                "href" => "add_user",
            ],
        ];

        $menuMember = [
            [
                "label" => "Rekap Panen",
                "icon" => "fa-clipboard-list",
                "href" => "rekap_panen",
            ],
            [
                "label" => "Slip Gaji",
                "icon" => "fa-clipboard-list",
                "href" => "slip_gaji",
            ],
            [
                "label" => "Profil",
                "icon" => "fa-user",
                "href" => "profil",
            ],
        ];
        $menuToShow = ($_SESSION['ses_level'] == 'Admin') ? $menuAdmin : $menuMember;

        foreach ($menuToShow as $menu) {
            $isActive = ($page === $menu['href']) ? 'active' : '';
        ?>
            <li class="<?= $isActive ?>">
                <a href="index.php?page=<?= $menu['href'] ?>">
                    <div class="row">
                        <div class='col-12 col-md-2 sidebar-item-icon'>
                            <i class="fas <?= $menu['icon'] ?>"></i>
                        </div>
                        <span class="col-10"><?= $menu['label'] ?></span>
                    </div>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>