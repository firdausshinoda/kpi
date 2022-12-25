<html>

<div class="col-md-12">

  <div class="box">

    <div class="box-header">

      <h3 class="box-title">Daftar Dosen</h3>

    </div>

    <div class="box-body">

      <div class="form-group">

        <table id="example2" class="table table-bordered table-striped" style="width: 100%">

          <thead>

            <tr>

              <th style="width:5%;">No</th>

              <th style="width:10%;">Foto</th>

              <th style="width:20%;">Nama Dosen</th>

              <th style="width:10%;">Jabatan</th>

              <th style="width:20%;">Alamat</th>

              <th style="width:10%;">Email</th>

              <th style="width:10%;">Tanggal</th>

              <th style="width:10%;"> Pilihan</th>

            </tr>

          </thead>

          <tbody>

            <?php $no = 0; foreach ($daftar->result() as $a): $no++; ?>

              <tr>

                <td> <?php echo $no; ?> </td>

                <td> <img style="width:100%;"src="<?php echo base_url('assets/document/img/dosen/'.$a->foto_dosen);?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image"> </td>

                <td> <?php echo $a->nama_dosen; ?> </td>

                <td> <?php echo $a->jabatan; ?> </td>

                <td> <?php echo $a->alamat; ?> </td>

                <td> <?php echo $a->email; ?> </td>

                <td> <?php echo waktu_lalu2($a->cdate); ?> </td>

                <td> <button type="button" class="btn btn-danger col-md-12">Hapus</button></td>

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

