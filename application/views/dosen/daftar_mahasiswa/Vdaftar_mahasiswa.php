<html>
<div class="col-md-12">
  <div class="box box-brown">
    <div class="box-header">
      <h3 class="box-title">Daftar Mahasiswa</h3>
      <div class="box-tools pull-right">
        <span data-toggle="tooltip" title="<?php echo $daftar->num_rows(); ?> Total Pesan" class="badge bg-info"><?php echo $daftar->num_rows(); ?></span>
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table id="example2" class="table table-bordered table-striped" style="width: 100%">
        <thead>
          <tr>
            <th style="width:5%;">No</th>
            <th style="width:10%;">Foto</th>
            <th style="width:20%;"> Nama Mahasiswa </th>
            <th style="width:25%;"> Nama Laporan </th>
            <th style="width:25%;"> Nama Perusahaan </th>
            <th style="width:15%;"> Informasi </th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 0;foreach ($daftar->result() as $data): $no++;?>
            <tr>
              <td> <?php echo $no; ?></td>
              <td> <img style="width:100%;"src="<?php echo base_url('assets/document/img/mahasiswa/'.$data->foto_mahasiswa);?>" class="profile-user-img img-responsive img-circle" alt="User Image"> </td>
              <td> <a onclick="read('<?php echo $data->id_mahasiswa;?>')" href="javascript:avoid()"><?php echo $data->nama_mahasiswa; ?></a> </td>
              <td> <?php echo $data->nama_laporan; ?> </td>
              <td> <?php echo $data->nama_perusahaan; ?> </td>
              <td>
                <center>
                  <?php if ($data->stt == 1): ?>
                    <span class="label label-success col-md-12"><h6>Laporan Selesai</h6></span><br><br>
                    <?php else: ?>
                      <span class="label label-danger col-md-12"> Laporan Belum Selesai</span>
                  <?php endif; ?>
                </center>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
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
