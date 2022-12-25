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
              <th style="width:10%;">ID KP</th>
              <th> Nama Mahasiswa </th>
              <th  style="width:20%;">Nama Perusahaan</th>
              <th style="width:20%;">Alamat Perusahaan</th>
              <th style="width:15%;">Pilihan</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 0; foreach ($daftar->result() as $a): $no++;?>
              <tr>
                <td> <?php echo $no; ?> </td>
                <td> <?php echo $a->id_kp; ?></td>
                <td>
                  <?php foreach (daftar_kp($a->id_kp) as $b): ?>
                    <?php echo $b; ?>
                  <?php endforeach; ?>
                </td>
                <td> <?php echo $a->nama_perusahaan; ?> </td>
                <td> <?php echo $a->alamat; ?> </td>
                <td> <button type="button" class="btn btn-default col-md-12" onclick="pembimbing('<?php echo $a->id_kp;?>','<?php echo $a->nama_perusahaan;?>')">Pilih Pembimbing</button></td>
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
