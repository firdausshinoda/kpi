<html>
<form>
  <div class="box-body">
    <div class=" box box-solid box-brown">
      <div class='box-body'>
        <?php if ($ck != 0): ?>
          <?php if ($daftar_pembimbing_kp->num_rows() >= 1): ?>
            <?php foreach ($daftar_pembimbing_kp->result() as $daftar): ?>
              <div class=" box box-widget">
                <div class='box-body'>
                  <div class="user-block">
                    <?php if (empty($daftar->foto_dosen)): ?>
                      <img class="img-circle img-bordered-sm" src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" alt="user image">
                      <?php else: ?>
                        <img class="img-circle img-bordered-sm" src="<?php echo base_url('assets/document/img/dosen/'.$daftar->foto_dosen)?>" alt="user image">
                    <?php endif; ?>
                    <span class='username'>
                      <a onclick="dtl_dsn('<?php echo $daftar->id_dosen;?>')" href="javascript:avoid()"><?php echo $daftar->nama_dosen; ?></a>
                    </span>
                    <span class='description'><?php echo $daftar->id_dosen; ?></span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="callout callout-danger">
              <h4>Pembimbing masih kosong</h4>
              <p>Silahkan tunggu sampai admin menambahkan pembimbing.</p>
            </div>
          <?php endif; ?>
        <?php else: ?>
          <div class="callout callout-danger">
            <h4>Pembimbing masih kosong</h4>
            <p>Silahkan masukan ID KP.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</form>
</htML>
