<html>
<div class="col-md-12">
  <div class="box box-brown">
    <div class="box-header">
      <h3 class="box-title">Daftar Sosial Link</h3>
      <button type="button" onclick="tambah()"class="btn btn-default pull-right">Tambah</button>
    </div>
    <div class="box-body pad">
      <div class="form-group">
        <table id="example2" class="table table-bordered table-striped" style="width: 100%">
          <thead>
            <tr>
              <th style="width:5%;">No</th>
              <th style="width:30%;">Link</th>
              <th style="width:30%;">Jenis</th>
              <th style="width:20%;">Tanggal</th>
              <th style="width:10%;"> Pilihan</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=0;foreach ($data->result() as $a): $no++;?>
              <tr>
                <td> <?php echo $no; ?> </td>
                <td> <?php echo $a->link; ?> </td>
                <td> <?php echo $a->icon; ?> </td>
                <td> <?php echo waktu_lalu2($a->cdate); ?> </td>
                <td>
                  <center>
                    <button type="button" onclick="ubah('<?php echo $a->id_sosial_link;?>','<?php echo $a->icon;?>','<?php echo $a->link;?>')" class="btn btn-info col-md-12">Ubah</button>
                    <button type="button" onclick="hapus('<?php echo $a->id_sosial_link;?>')" class="btn btn-danger col-md-12">Hapus</button>
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
