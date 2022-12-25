<html>
<div class="col-md-12" style="margin-top:1%;">
  <div class="modal-content">
    <?php foreach ($detail_mahasiswa->result() as $detail): ?>
      <div class="modal-header">
        <button type="button" class="close" onclick="tutup()"title="close">&times;</button>
        <div class='user-block'>
          <img class='img-circle' src="<?php echo base_url('assets/document/img/mahasiswa/'.$detail->foto_mahasiswa) ?>" alt='user image'>
          <span class='username'><a href="javascript:avoid();"><?php echo $detail->nama_mahasiswa; ?></a></span>
          <span class='description'><?php echo $detail->id_mahasiswa; ?></span>
        </div>
      </div>
      <div class="modal-body direct-chat direct-chat-primary">
        <div class="row">
          <div class="form-group">
            <div class="col-md-6">
              <div class="box-body pad">
                <div class="form-group">
                  <h5>Agama</h5>
                  <p class="form-control"><?php echo $detail->agama; ?></p>
                </div>
                <div class="form-group">
                  <h5>Jenis Kelamin</h5>
                  <p class="form-control"><?php echo $detail->sex; ?></p>
                </div>
                <div class="form-group">
                  <h5>Tanggal Lahir</h5>
                  <p class="form-control"><?php echo $detail->tgl_lahir."-".$detail->bln_lahir."-".$detail->thn_lahir; ?></p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h5>Email</h5>
                <p class="form-control"><?php echo $detail->email; ?></p>
              </div>
              <div class="form-group">
                <h5>Alamat</h5>
                <p class="form-control"><?php echo $detail->alamat; ?></p>
              </div>
              <div class="form-group">
                <h5>Angkatan</h5>
                <p class="form-control"><?php echo $detail->angkatan; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</html>
