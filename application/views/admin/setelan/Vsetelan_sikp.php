<html>
<div class="col-md-12">
  <div class="box box-brown">
    <div class="box-header">
      <h3 class="box-title">Surat Ijin KP</h3>
    </div>
    <div class="box-body pad">
      <div class="form-group">
        <h5><b>Nomor Surat Keluar Terakhir Yang Sudah Dicetak</b></h5>
        <input class="form-control" value="<?php echo $nomor_surat_terakhir; ?>" disabled>
      </div>
      <div class="form-group">
        <h5><b>Nomor Surat KP</b></h5>
        <input class="form-control" id="nomor" placeholder="Nomor Surat" value="<?php echo $nomor_surat; ?>">
      </div>
      <div class="form-group">
        <h5><b>Jumlah Hari</b></h5>
        <input class="form-control" id="jumlah" placeholder="Jumlah Hari" value="<?php echo $jml_hari; ?>">
      </div>
      <div class="form-group">
        <h5><b>Tanggal Mulai KP</b></h5>
        <input class="datepicker form-control" id="tgl_mulai" placeholder="Tanggal Mulai" value="<?php echo $tgl_mulai; ?>">
      </div>
      <div class="form-group">
        <h5><b>Email D IV Teknik Informatika</b></h5>
        <input class="form-control" id="email" placeholder="Email D IV Teknik Informatika" value="<?php echo $email_d4; ?>">
      </div>
      <div class="form-group">
        <h5><b>Dirubah terakhir</b> <i class="fa fa-hourglass-2 "></i></h5>
        <h5 class="form-control"><?php echo waktu_lalu2($cdate); ?></h5>
      </div>
    </div>
    <div class="box-footer">
      <div class="pull-right">
        <button type="button" class="btn btn-primary" onclick="simpan('<?php echo $id;?>')" >Simpan</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function ()
{
  $('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    autoclose:true
  });
});
</script>
</html>
