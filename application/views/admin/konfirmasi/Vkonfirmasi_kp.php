<html>
<div class="col-md-12">
  <div class="box box-brown">
    <div class="box-header">
      <h3 class="box-title">Daftar Konfirmasi KP</h3>
    </div>
    <div class="box-body">
      <div class="form-group">
        <table id="example2" class="table table-bordered table-striped" style="width: 100%">
          <thead>
            <tr>
              <th style="width:5%;">No</th>
              <th style="width:10%;">ID KP</th>
              <th style="width:20%;">Pembuat ID KP</th>
              <th style="width:10%;">Nama Perusahaan</th>
              <th style="width:20%;">Alamat Perusahaan</th>
              <th style="width:10%;">Surat Terima KP</th>
              <th style="width:10%;">Dibuat Pada</th>
              <th style="width:10%;"> Pilihan</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 0; foreach ($daftar_kp->result() as $a): $no++;?>
              <tr>
                <td> <?php echo $no; ?> </td>
                <td> <a href="javascript:avoid()" onclick="detail('<?php echo $a->id_kp;?>')"><?php echo $a->id_kp; ?></a> </td>
                <td> <?php echo $a->nama_mahasiswa." (".$a->id_mahasiswa.")"; ?> </td>
                <td> <?php echo $a->nama_perusahaan; ?> </td>
                <td> <?php echo $a->alamat; ?> </td>
                <td>
                  <?php if (empty($a->nama_file)): ?>
                    <small class="label label-danger">Belum ada</small>
                    <?php else: ?>
                      <small class="label label-success">Telah ada</small>
                  <?php endif; ?>
                </td>
                <td> <?php echo waktu_lalu2($a->cdate); ?> </td>
                <td>
                  <center>
                    <button type="button" class="btn btn-success col-md-12" onclick="konfirm_idkp('<?php echo $a->id_kp;?>')">Konfirmasi</button><br>
                    <button type="button" class="btn btn-danger col-md-12" onclick="hapus_idkp('<?php echo $a->id_kp;?>')">Hapus</button>
                  </center>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function () {
  $("#example2").DataTable({
      "responsive": true,
      "pagingType": "simple_numbers",
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
  });
});
</script>
</html>
