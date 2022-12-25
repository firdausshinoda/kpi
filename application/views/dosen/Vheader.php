<!DOCTYPE html>
<html>
<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <a href="<?php echo base_url('Dosen'); ?>">Dashboard</a>
          </li>
          <li>
            <a href="<?php echo base_url('Dosen/Daftar_Mahasiswa'); ?>">Daftar Mahasiswa</a>
          </li>
          <li>
            <a href="<?php echo base_url('Dosen/Bimbingan_Online'); ?>">Bimbingan Online</a>
          </li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if (empty($s_foto)): ?>
                <img src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" class="user-image" alt="User Image">
                <?php else: ?>
                  <img src="<?php echo base_url('assets/document/img/dosen/'.$s_foto); ?>" class="user-image" alt="User Image">
              <?php endif; ?>
              <span class="hidden-xs"><?php echo $s_nama; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <?php if (empty($s_foto)): ?>
                  <img src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" class="img-circle" alt="User Image">
                  <?php else: ?>
                    <img src="<?php echo base_url('assets/document/img/dosen/'.$s_foto); ?>" class="img-circle" alt="User Image">
                <?php endif; ?>
                <p>
                  <?php echo $s_nama." - ".$s_niy; ?>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('Dosen/Profil');?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('Dosen/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<?php $this->load->view('style/Vloading'); ?>
</html>
