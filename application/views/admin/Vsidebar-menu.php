<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (!empty($s_foto)): ?>
                    <img src="<?= base_url('assets/document/img/admin/'.$s_foto); ?>" class="img-circle" alt="User Image">
                <?php else: ?>
                    <img src="<?= base_url('assets/document/img/style/profile.jpg'); ?>" class="img-circle" alt="User Image">
                <?php endif; ?>
            </div>
            <div class="pull-left info">
                <p><?= $s_nama; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li id="dashboard"><a href="<?= base_url('Admin/Dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li id="profil"><a href="<?= base_url('Admin/Profil');?>"><i class="fa fa-user"></i> <span>Profil</span></a></li>
            <li id="document" class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Document</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="d_pembimbing"><a href="<?= base_url('Admin/Daftar_Pembimbing');?>"><i class="fa fa-file-o"></i> Daftar Pembimbing </a></li>
                    <li id="d_kp"><a href="<?= base_url('Admin/Daftar_KP');?>"><i class="fa fa-file-o"></i> Daftar KP </a></li>
                    <li id="d_dsn"><a href="<?= base_url('Admin/Daftar_Dosen');?>"><i class="fa fa-group"></i> Daftar Dosen </a></li>
                    <li id="d_mhs" ><a href="<?= base_url('Admin/Daftar_Mahasiswa');?>"><i class="fa fa-group"></i> Daftar Mahasiswa </a></li>
                    <li id="d_wilayah" ><a href="<?= base_url('Admin/Daftar_Wilayah');?>"><i class="fa fa-map"></i> Wilayah </a></li>
                    <li id="d_bidang_kerja" ><a href="<?= base_url('Admin/Daftar_Bidang_Kerja');?>"><i class="fa fa-users"></i> Bidang Kerja </a></li>
                </ul>
            </li>
            <li id="arsip" class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Arsip</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="d_arsip_pembimbing"><a href="<?= base_url('Admin/Arsip_Pembimbing');?>"><i class="fa fa-file-o"></i> Arsip Pembimbing </a></li>
                    <li id="d_arsip_kp"><a href="<?= base_url('Admin/Arsip_KP');?>"><i class="fa fa-file-o"></i> Arsip KP </a></li>
                    <li id="d_arsip_dosen"><a href="<?= base_url('Admin/Arsip_Dosen');?>"><i class="fa fa-group"></i> Arsip Dosen </a></li>
                    <li id="d_arsip_mahasiswa"><a href="<?= base_url('Admin/Arsip_Mahasiswa');?>"><i class="fa fa-group"></i> Arsip Mahasiswa </a></li>
                </ul>
            </li>
            <li id="konfirmasi" class="treeview">
                <a href="#">
                    <i class="fa fa-check"></i>
                    <span>Konfirmasi</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="kp"><a href="<?= base_url('Admin/Konfirmasi_KP');?>"><i class="fa fa-check-square-o"></i> KP </a></li>
                    <li id="pembimbing"><a href="<?= base_url('Admin/Konfirmasi_Pembimbing');?>"><i class="fa fa-check-square-o"></i> Pembimbing </a></li>
                    <li id="lap"><a href="<?= base_url('Admin/Konfirmasi_Laporan_KP');?>"><i class="fa fa-check-square-o"></i> Laporan </a></li>
                </ul>
            </li>
            <li id="setelan" class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i>
                    <span>Setelan</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="samp_slid"><a href="<?= base_url('Admin/Sampul_Sliding');?>"><i class="fa fa-picture-o"></i> Sampul Sliding </a></li>
                    <li id="desk_kp"><a href="<?= base_url('Admin/Deskripsi_KP');?>"><i class="fa fa-file-o"></i> Deskripsi KP </a></li>
                    <li id="samp_gal"><a href="<?= base_url('Admin/Sampul_Galeri');?>"><i class="fa fa-picture-o"></i> Sampul Galeri </a></li>
                    <li id="sos_link"><a href="<?= base_url('Admin/Sosial_Link');?>"><i class="fa fa-link"></i> Sosial Link </a></li>
                    <li id="sikp"><a href="<?= base_url('Admin/Surat_Ijin_KP');?>"><i class="fa fa-envelope-o"></i> Surat Ijin KP </a></li>
                </ul>
            </li>
            <li id="laporan" class="treeview">
                <a href="#">
                    <i class="fa fa-list-alt"></i>
                    <span>Laporan</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="d_laporan_grafik"><a href="<?= base_url('Admin/Laporan_Grafik_KP');?>"><i class="fa fa-pie-chart"></i> Laporan Grafik KP</a></li>
                </ul>
            </li>
            <li id="sistem" class="treeview">
                <a href="#">
                    <i class="fa fa-archive"></i>
                    <span>Sistem</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="s_log"><a href="<?= base_url('Admin/Catatan_Aktivitas');?>"><i class="fa fa-file-text-o"></i> Catatan Aktivitas </a></li>
                    <li id="s_dosen"><a href="<?= base_url('Admin/Dosen_Terhapus');?>"><i class="fa fa-trash-o"></i> Dosen Terhapus </a></li>
                    <li id="s_mahasiswa"><a href="<?= base_url('Admin/Mahasiswa_Terhapus');?>"><i class="fa fa-trash-o"></i> Mahasiswa Terhapus </a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
<?php $this->load->view('style/Vloading'); ?>