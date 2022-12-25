<html>
<div class="col-md-12">
  <div class="box box-brown">
    <div class="box-header">
      <h3 class="box-title">Daftar Pembimbing</h3>
      <div class="box-tools pull-right">
        <span data-toggle="tooltip" title="4 Total Messages" class="badge bg-info"><?php echo $daftar->num_rows(); ?></span>
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table id="example2" class="table table-bordered table-striped" style="width: 100%">
        <thead>
          <tr>
            <th style="width:5%;">No</th>
            <th style="width:10%;">Foto</th>
            <th style="width:20%;"> Dosen Pembimbing </th>
            <th> Pesan </th>
            <th style="width:20%;">Waktu</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=0;foreach ($daftar->result() as $data): $no++; ?>
            <?php $str = array('id_mahasiswa'=>$data->id_mahasiswa); ?>
            <tr>
              <td> <?php echo $no; ?> </td>
              <td>
                <?php if (empty($data->foto_dosen)): ?>
                  <img style="width:100%;"src="<?php echo base_url('assets/document/img/style/profile.jpg');?>" class="profile-user-img img-responsive img-circle" alt="User Image">
                  <?php else: ?>
                    <img style="width:100%;"src="<?php echo base_url('assets/document/img/dosen/'.$data->foto_dosen);?>" class="profile-user-img img-responsive img-circle" alt="User Image">
                <?php endif; ?>
              </td>
              <td> <a href="javascript:avoid();" onclick="read('<?php echo $data->id_dosen;?>')"> <?php echo $data->nama_dosen; ?></a> </td>
              <td> <?php echo isi_chat($data->id_mahasiswa,$data->id_dosen,"dosen"); ?> </td>
              <td>
                <?php
                  $cdate = cdate_chat($data->id_mahasiswa,$data->id_dosen,"dosen");
                  if (empty($cdate)) {
                    echo "";
                  }
                  else {
                    echo waktu_lalu2($cdate);
                  }
                ?>
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
