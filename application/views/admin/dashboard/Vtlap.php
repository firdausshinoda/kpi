<html>

<div class="box-body">

  <div class="box-header">

    <i class="fa fa-newspaper-o"></i>

    <h3 class="box-title">Daftar Laporan KP Mahasiswa</h3>

  </div>

  <div class="box-body">

    <div class="form-group">

      <table id="example2" class="table table-bordered table-striped" style="width: 100%">

        <thead>

          <tr>

            <th style="width:8%;">No</th>

            <th style="width:10%;">Foto</th>

            <th> Nama Mahasiswa </th>

            <th style="width:20%;">Nama Perusahaan</th>

            <th style="width:20%;">Judul Laporan</th>

            <th style="width:20%;">Dosen Pembimbing</th>

          </tr>

        </thead>

        <tbody>

          <?php $no=0;foreach ($daftar_lap_kp->result() as $daftar): $no++;?>

            <tr>

              <td> <?php echo $no; ?> </td>

              <td>
                <?php if (empty($daftar->foto_mahasiswa)): ?>
                  <img style="width:100%;"src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" class="profile-user-img img-responsive img-circle" alt="User Image">
                  <?php else: ?>
                    <img style="width:100%;" src="<?php echo base_url('assets/document/img/mahasiswa/'.$daftar->foto_mahasiswa); ?>" class="profile-user-img img-responsive img-circle" alt="User Image">
                <?php endif; ?>
              </td>

              <td> <a onclick="dtl_mhs('<?php echo $daftar->id_mahasiswa;?>')" href="javascript:avoid()"><?php echo $daftar->nama_mahasiswa; ?></a> </td>

              <td> <?php echo $daftar->nama_perusahaan; ?> </td>

              <td> <?php echo $daftar->nama_laporan; ?> </td>

              <td>

                <?php foreach (daftar_pembimbing($daftar->id_pembimbing) as $b): ?>

                  <?php echo $b ?>

                <?php endforeach; ?>

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

