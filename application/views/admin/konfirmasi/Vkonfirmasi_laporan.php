<html>
<div class="col-md-12">
  <div class="box box-brown">
    <div class="box-header">
      <h3 class="box-title">Daftar Konfirmasi Pembimbing</h3>
    </div>
    <div class="box-body">
      <div class="form-group">
        <table id="example2" class="table table-bordered table-striped" style="width: 100%">
          <thead>
            <tr>
              <th style="width:5%;">No</th>
              <th style="width:10%;">Foto</th>
              <th> Nama Mahasiswa </th>
              <th  style="width:20%;">Judul Laporan</th>
              <th style="width:15%;">Pilihan</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=0; foreach ($daftar->result() as $a): $no++; ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td>
                  <?php if (empty($a->foto_mahasiswa)): ?>
                    <img style="width:100%;"src="<?php echo base_url('assets/document/img/style/profile.jpg');?>" class="profile-user-img img-responsive img-circle" alt="Mahasiswa Image">
                    <?php else: ?>
                      <img style="width:100%;"src="<?php echo base_url('assets/document/img/mahasiswa/'.$a->foto_mahasiswa);?>" class="profile-user-img img-responsive img-circle" alt="Mahasiswa Image">
                  <?php endif; ?>
                </td>
                <td><a href="javascript:avoid()" onclick="dtl_mhs('<?php echo $a->id_mahasiswa;?>')"><?php echo $a->nama_mahasiswa." (".$a->id_mahasiswa.")"; ?></a></td>
                <td><?php echo $a->nama_laporan ?></td>
                <td> <button type="button" class="btn btn-default col-md-12" onclick="konfirm('<?php echo $a->id_kp_laporan; ?>','<?php echo $a->id_kp;?>')">Konfirmasi</button></td>
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
