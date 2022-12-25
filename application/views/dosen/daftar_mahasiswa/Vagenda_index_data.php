<html>
<?php if ($page == "agenda_detail_mahasiswa"): ?>
  <div class="box-body">
    <?php foreach ($daftar->result() as $a): ?>
      <div class="row">
        <div class="form-group">
          <div class="col-md-2">
            <?php
            if (empty($a->foto_mahasiswa))
            { ?><img src="<?php echo base_url('assets/document/img/style/profile/jpg')?>" class="profile-user-img img-responsive img-circle" alt="User profile picture"><?php }
            else
            { ?><img src="<?php echo base_url('assets/document/img/mahasiswa/'.$a->foto_mahasiswa)?>" class="thumb-image" alt="User"><?php }
            ?>
          </div>
          <div class="col-md-10">
            <div class="box-body pad">
              <div class="form-group">
                <h5><b>Nama</b></h5>
                <h5 class="form-control"><?php echo $a->nama_mahasiswa;?></h5>
              </div>
              <div class="form-group">
                <h5><b>NIM</b></h5>
                <h5 class="form-control"><?php echo $a->id_mahasiswa;?></h5>
              </div>
              <div class="form-group">
                <h5><b>Agama</b></h5>
                <h5 class="form-control"><?php echo $a->agama;?></h5>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <h5><b>Jenis Kelamin</b></h5>
              <h5 class="form-control"><?php echo $a->sex;?></h5>
            </div>
            <div class="form-group">
              <h5><b>Tanggal Lahir</b></h5>
              <h5 class="form-control"><?php echo $a->tgl_lahir." ".$a->bln_lahir." ".$a->thn_lahir;?></h5>
            </div>
            <div class="form-group">
              <h5><b>Email</b></h5>
              <h5 class="form-control"><?php echo $a->email;?></h5>
            </div>
            <div class="form-group">
              <h5><b>Alamat</b></h5>
              <h5 class="form-control"><?php echo $a->alamat;?></h5>
            </div>
            <div class="form-group">
              <h5><b>Golongan Darah</b></h5>
              <h5 class="form-control"><?php echo $a->golongan_darah;?></h5>
            </div>
            <div class="form-group">
              <h5><b>Angkatan</b></h5>
              <h5 class="form-control"><?php echo $a->angkatan;?></h5>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php if ($page == "agenda_kp_bimbingan"): ?>
  <div class="box-body">
    <div class="box box-solid box-brown">
      <div class="box-header">
        <label for="inputName" class="control-label">Bimbingan Kerja Praktik</label>
      </div>
      <div class="box-body">
        <?php if ($data_kp->num_rows() >= 1): ?>
          <div class="form-group col-md-12">
            <div class="pull-right">
              <button type="button" onclick="tambah('<?php echo $nim; ?>')" class="btn btn-default">Tambah</button>
            </div>
          </div>
          <div class="form-group">
            <table id="example2" class="table table-bordered table-striped" style="width: 100%">
              <thead>
                <tr>
                  <th style="width:5%;">No</th>
                  <th style="width:15%;">Tanggal</th>
                  <th>Keteranan</th>
                  <th style="width:20%;">TTD Oleh</th>
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
                    <td> <?php echo $a->nama_dosen; ?> </td>
                    <td> <?php echo waktu_lalu2($a->cdate); ?> </td>
                    <td>
                      <center>
                        <button type="button" class="btn btn-danger col-md-12" onclick="hapus_kp_bimbingan('<?php echo $a->id_kp_bimbingan;?>')">Hapus</button>
                      </center>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php else: ?>
            <div class="callout callout-danger">
              <h4>ID KP anda belum di konfirmasi</h4>
              <p>Silahkan lengkapi data terlebih dahulu sampai nanti dikonfirmasi admin untuk mengupload laporan KP.</p>
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
<?php endif; ?>
<?php if ($page == "agenda_kp_harian"): ?>
  <div class="box-body">
    <div class="box box-solid box-brown">
      <div class="box-header">
        <label for="inputName" class="control-label">Tugas Harian Kerja Praktik Mahasiswa</label>
      </div>
      <div class="box-body">
        <?php if ($data_kp->num_rows() >= 1): ?>
          <div class="form-group">
            <table id="example2" class="table table-bordered table-striped" style="width: 100%">
              <thead>
                <tr>
                  <th style="width:5%;">No</th>
                  <th style="width:15%;">Tanggal</th>
                  <th>Tugas</th>
                  <th style="width:15%;">Waktu</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 0; foreach ($data->result() as $a): $no++;?>
                  <tr>
                    <td> <?php echo $no; ?> </td>
                    <td> <?php echo tgl($a->tgl); ?> </td>
                    <td> <?php echo $a->ket; ?> </td>
                    <td> <?php echo waktu_lalu2($a->cdate); ?> </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php else: ?>
            <div class="callout callout-danger">
              <h4>ID KP di konfirmasi</h4>
              <p>Mahasiswa belum melengkapi form data KP.</p>
            </div>
        <?php endif; ?>
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
  </div>
<?php endif; ?>
<?php if ($page == "agenda_data_kp"): ?>
  <div class="bod-body">
    <div class="row">
      <div class="col-md-6">
        <div class="box-body">
          <div class="box box-solid box-brown">
            <div class="box-header">
              <label for="inputName" class="control-label">Data Perusahaan</label>
            </div>
            <div class="box-body">
              <?php if ($data->num_rows() != 0): ?>
                <?php foreach ($data->result() as $a): ?>
                  <div class="form-group has-warning">
                    <label for="inputName" class="control-label">Nama Perusahaan</label>
                    <div>
                      <h5 class="form-control" id="nm_pers" ><?php echo $a->nama_perusahaan;?></h5>
                    </div>
                  </div>
                  <div class="form-group has-warning">
                    <label for="inputName" class="control-label">Deskripsi Perusahaan</label>
                    <div>
                      <h5 class="form-control" ><?php echo $a->deskripsi;?></h5>
                    </div>
                  </div>
                  <div class="form-group has-warning">
                    <label for="inputName" class="control-label">Alamat</label>
                    <div>
                      <h5 class="form-control"><?php echo $a->alamat;?></h5>
                    </div>
                  </div>
                  <?php if (!empty($a->nama_file)): ?>
                    <div class="form-group col-md-12">
                      <label for="inputName" class="control-label">Surat Diterima KP Oleh Perusahaan</label>
                      <ul class="mailbox-attachments clearfix">
                        <li>
                          <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                          <div class="mailbox-attachment-info">
                            <a class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?php echo substrfile($a->nama_file);?> </a>
                            <span class="mailbox-attachment-size">
                              <?php echo formatBytes($a->size);?>
                              <a href="javascript:avoid()" onclick="download_dt_pers('<?php echo $a->nama_file;?>')" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </span>
                          </div>
                        </li>
                      </ul>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box-body">
          <?php if ($data_kp->num_rows() >= 1): ?>
            <?php foreach ($data_kp->result() as $a): ?>
              <div class="box box-solid box-brown">
                <div class="box-header">
                  <label for="inputName" class="control-label">Laporan Kerja Praktik</label>
                </div>
                <div class="box-body">
                  <?php if (empty($a->nama_laporan)): ?>
                    <div class="callout callout-danger">
                      <h4>Laporan KP belum dikonfirmasi</h4>
                      <p>Mahasiswa belum upload hasil laporan untuk dapat di konfirmasi oleh admin.</p>
                    </div>
                  <?php endif; ?>
                  <?php if ($a->stt == "0"): ?>
                    <div class="callout callout-warning">
                      <h4>Laporan KP sedang tahap konfirmasi</h4>
                      <p>Menunggu sampai admin mengkonfirmasinya.</p>
                    </div>
                  <?php endif; ?>
                  <?php if ($a->stt == "1"): ?>
                    <div class="callout callout-success">
                      <h4>Laporan KP telah dikonfirmasi</h4>
                      <p>Sukses.</p>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($a->nama_laporan)): ?>
                    <div class="form-group">
                      <ul class="mailbox-attachments clearfix">
                        <li>
                          <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                          <div class="mailbox-attachment-info">
                            <a class="mailbox-attachment-name" title="<?php echo $a->nama_laporan;?>"><i class="fa fa-paperclip"></i> <?php echo substrfile($a->nama_laporan); ?> </a>
                          </div>
                        </li>
                      </ul>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
            <?php else: ?>
              <div class="callout callout-danger">
                <h4>ID KP anda belum di konfirmasi</h4>
                <p>Mahasiswa belum melengkapi form KP.</p>
              </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
</html>
