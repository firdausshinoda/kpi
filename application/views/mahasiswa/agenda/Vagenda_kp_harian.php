<html>
<form>
  <div class="box-body">
    <div class="box box-solid box-brown">
      <div class="box-header">
        <label for="inputName" class="control-label">Tugas Harian Kerja Praktik</label>
      </div>
      <div class="box-body">
        <?php if ($data_kp->num_rows() >= 1): ?>
          <div class="form-group col-md-12">
            <div class="pull-right">
              <button type="button" onclick="tambah('<?php echo $id; ?>')" class="btn btn-default">Tambah</button>
            </div>
          </div>
          <div class="form-group">
            <table id="example2" class="table table-bordered table-striped" style="width: 100%">
              <thead>
                <tr>
                  <th style="width:5%;">No</th>
                  <th style="width:15%;">Tanggal</th>
                  <th>Tugas</th>
                  <th style="width:15%;">Waktu</th>
                  <th style="width:10%;"> Pilihan</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 0; foreach ($data->result() as $a): $no++;?>
                  <tr>
                    <td> <?php echo $no; ?> </td>
                    <td> <?php echo tgl($a->tgl); ?> </td>
                    <td> <?php echo $a->ket; ?> </td>
                    <td> <?php echo waktu_lalu2($a->cdate); ?> </td>
                    <td>
                      <center>
                        <button type="button" class="btn btn-danger col-md-12" onclick="hapus_kp_harian('<?php echo $a->id_kp_harian;?>')">Hapus</button>
                      </center>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php else: ?>
            <div class="callout callout-danger">
              <h4>Pembimbing masih kosong</h4>
              <p>Silahkan tunggu sampai admin menambahkan pembimbing untuk dapat mengisi tugas harian KP.</p>
            </div>
        <?php endif; ?>
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
</form>
</htML>
