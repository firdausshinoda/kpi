<html>
<section class="col-lg-6 connectedSortable">
  <div class="box box-widget">
    <div class='box-body'>
      <p>Info.</p>
    </div>
  </div>
  <div id="post"></div>
  <div id="loading-info" style="display:none;"><center><img src="<?php echo base_url('assets/document/img/style/ring-alt.gif');?>" style="width:10%;"/></center></div>
</section>
<section class="col-lg-6 connectedSortable">
  <div class="box box-widget">
    <div class='box-body'>
      <p>Daftar mahasiswa yang telah dikonfirmasi untuk KP dan menyelesaikan laporan KP.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 col-xs-6">
      <div class="small-box bg-brown">
        <div class="inner">
          <h3><?php echo $kp_fix; ?></h3>
          <p>Daftar Mahasiswa Kerja Praktik.</p>
        </div>
        <div class="icon">
          <i class="ion ion-user"></i>
        </div>
        <a onclick="tabel('dashboard_table_mhs');" href="javascript:avoid();" class="small-box-footer">
          <li class="fa fa-arrow-circle-right"></li>
        </a>
      </div>
    </div>
    <div class="col-lg-6 col-xs-6">
      <div class="small-box bg-brown">
        <div class="inner">
          <h3><?php echo $lap_fix; ?></h3>
          <p>Daftar Laporan Kerja Praktik.</p>
        </div>
        <div class="icon">
          <i class="ion ion-user"></i>
        </div>
        <a onclick="tabel('dashboard_table_lap');" href="javascript:avoid();" class="small-box-footer">
          <li class="fa fa-arrow-circle-right"></li>
        </a>
      </div>
    </div>
  </div>
  <div class="box box-brown-chat direct-chat direct-chat-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Mahasiwa KP</h3>
    </div>
    <div class="box-body">
      <div class="direct-chat-messages">
        <?php foreach ($daftar_kp_mhs->result() as $dkm): ?>
          <div class="direct-chat-msg btn-default">
            <div class='box-header with-border'>
              <div class='user-block'>
                <?php if (empty($dkm->foto_mahasiswa)): ?>
                  <img class='img-circle' src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" alt='user image'>
                  <?php else: ?>
                    <img class='img-circle' src="<?php echo base_url('assets/document/img/mahasiswa/'.$dkm->foto_mahasiswa)?>" alt='user image'>
                <?php endif; ?>
                <span class='username'><a href="javascript:avoid();" onclick="dtl_mhs('<?php echo $dkm->id_mahasiswa;?>')"><?php echo $dkm->nama_mahasiswa; ?></a></span>
                <span class="username"><?php echo $dkm->nama_perusahaan; ?></span>
                <span class='description pull-right'><?php echo waktu_lalu2($dkm->cdate); ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>

  <div class="box box-brown-chat direct-chat direct-chat-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Laporan KP Mahasiswa</h3>
    </div>
    <div class="box-body">
      <div class="direct-chat-messages">
        <?php foreach ($daftar_lap_mhs->result() as $dlm): ?>
          <div class="direct-chat-msg btn-default">
            <div class='box-header with-border'>
              <div class='user-block'>
                <?php if (empty($dlm->foto_mahasiswa)): ?>
                  <img class='img-circle' src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" alt='user image'>
                  <?php else: ?>
                    <img class='img-circle' src="<?php echo base_url('assets/document/img/mahasiswa/'.$dlm->foto_mahasiswa)?>" alt='user image'>
                <?php endif; ?>
                <span class='username'><a href="javascript:avoid();" onclick="dtl_mhs('<?php echo $dlm->id_mahasiswa;?>')"><?php echo $dlm->nama_mahasiswa; ?></a></span>
                <span class="username"><?php echo $dlm->nama_perusahaan; ?></span>
                <span class='description pull-right'><?php echo waktu_lalu2($dlm->cdate); ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
</section>
</html>
