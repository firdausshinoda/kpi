<html>
<?php if ($page == "detail_img"): ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Detail Gambar</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <center><img src="<?php echo base_url($img)?>" class="thumb-image"></center>
                        </div>
                        <div class="form-group">
                            <h4><b>Keterangan Gambar</b></h4>
                            <h6><?php echo $file; ?></h6>
                            <h6><?php echo $tipe; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page == "detailmhs"): ?>
    <style type="text/css">
        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
            background-color: unset;
            opacity: 1;
        }
        .form-control[disabled], fieldset[disabled] .form-control {
            cursor: unset;
        }
    </style>
    <!--div class="modal-dialog"-->
    <div style="padding:5%;">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Detail Mahasiswa</b></h4>
            </div>
            <div class="modal-body">
                <?php foreach ($daftar->result() as $a): ?>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <?php if (empty($a->foto_mahasiswa)): ?>
                                    <img src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" class="profile-user-img img-responsive img-circle" alt="User profile picture">
                                <?php else: ?>
                                    <img src="<?php echo base_url('assets/document/img/mahasiswa/'.$a->foto_mahasiswa)?>" class="thumb-image" alt="User">
                                <?php endif; ?>
                            </div><!-- /.col -->
                            <div class="col-md-9">
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
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <h5><b>No HP</b></h5>
                                            <h5 class="form-control"><?php echo $a->no_hp;?></h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <h5><b>No WA</b></h5>
                                            <?php if (empty($a->no_wa)):?>
                                                <h5 class="form-control"><?php echo $a->no_wa;?></h5>
                                            <?php else:?>
                                                <div class="input-group margin">
                                                    <input type="text" class="form-control" value="+62<?php echo $a->no_wa;?>" disabled>
                                                    <span class="input-group-btn">
                                                        <a href="https://api.whatsapp.com/send?phone=62<?= $a->no_wa;?>&text=K%20P" class="btn btn-success btn-flat" type="button"><i class="fa fa-whatsapp"></i></a>
                                                    </span>
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
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
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page == "detaildsn"): ?>
    <div style="padding:5%;">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Detail Dosen</b></h4>
            </div>
            <div class="modal-body">
                <?php foreach ($daftar->result() as $a): ?>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <?php if (empty($a->foto_dosen)): ?>
                                    <img src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" class="profile-user-img img-responsive img-circle" alt="User profile picture">
                                <?php else: ?>
                                    <img src="<?php echo base_url('assets/document/img/dosen/'.$a->foto_dosen)?>" class="thumb-image" alt="User">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-9">
                                <div class="box-body pad">
                                    <div class="form-group">
                                        <h5><b>Nama</b></h5>
                                        <h5 class="form-control"><?php echo $a->nama_dosen;?></h5>
                                    </div>
                                    <div class="form-group">
                                        <h5><b>NIPY</b></h5>
                                        <h5 class="form-control"><?php echo $a->id_dosen;?></h5>
                                    </div>
                                    <div class="form-group">
                                        <h5><b>Jabatan</b></h5>
                                        <h5 class="form-control"><?php echo $a->jabatan;?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <h5><b>No HP</b></h5>
                                            <h5 class="form-control"><?php echo $a->no_hp;?></h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <h5><b>No WA</b></h5>
                                            <?php if (empty($a->no_wa)):?>
                                                <h5 class="form-control"><?php echo $a->no_wa;?></h5>
                                            <?php else:?>
                                                <div class="input-group margin">
                                                    <input type="text" class="form-control" value="+62<?php echo $a->no_wa;?>" disabled>
                                                    <span class="input-group-btn">
                                                        <a href="https://api.whatsapp.com/send?phone=62<?= $a->no_wa;?>&text=K%20P" class="btn btn-success btn-flat" type="button"><i class="fa fa-whatsapp"></i></a>
                                                    </span>
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5><b>Agama</b></h5>
                                    <h5 class="form-control"><?php echo $a->agama;?></h5>
                                </div>
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
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page == "detailkp"): ?>
    <style type="text/css">
        .form-control[disabled], fieldset[disabled] .form-control {
            cursor: unset;
        }
        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
            background-color: unset;
            opacity: 1;
        }
    </style>
    <div style="padding:5%;">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Detail KP</b></h4>
            </div>
            <div class="modal-body">
                <?php foreach ($daftar->result() as $a): ?>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h5><b>ID KP</b></h5>
                                    <h5 class="form-control"><?php echo $a->id_kp;?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Nama Pembuat ID</b></h5>
                                    <h5 class="form-control"><?php echo $a->nama_mahasiswa;?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Nama Perusahaan</b></h5>
                                    <h5 class="form-control"><?php echo $a->nama_perusahaan;?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Bidang Kerja</b></h5>
                                    <h5 class="form-control"><?php echo $a->bidang_kerja;?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Wilayah</b></h5>
                                    <h5 class="form-control"><?php echo $a->wilayah;?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Deskripsi Perusahaan</b></h5>
                                    <textarea class="form-control" rows="10" disabled><?php echo $a->deskripsi;?></textarea>
                                </div>
                                <div class="form-group">
                                    <h5><b>Alamat Perusahaan</b></h5>
                                    <textarea class="form-control" rows="5" disabled><?php echo $a->alamat;?></textarea>
                                </div>
                                <div class="form-group">
                                    <h5><b>Mahasiswa</b></h5>
                                    <?php foreach (daftar_kp_dtl($a->id_kp) as $b) {
                                        echo "<h5 class='form-control'>".$b."</h5>";
                                    }?>
                                </div>
                                <div class="form-group">
                                    <h5><b>File</b></h5>
                                    <?php if (empty($a->nama_file)): ?>
                                        <div class="callout callout-info">
                                            <h4>Surat Pengantar Ijin KP</h4>
                                            <p>Belum terdapat file tersebut.</p>
                                        </div>
                                    <?php else: ?>
                                        <ul class="mailbox-attachments clearfix">
                                            <li>
                                                <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                <div class="mailbox-attachment-info">
                                                    <a class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Surat Terima Perusahaan </a>
                                                    <span class="mailbox-attachment-size">
                                                      <?php echo formatBytes($a->size)." Tipe ".$a->tipe; ?>
                                                      <a href="javascript:avoid()" onclick="download_srt('<?php echo $a->nama_file;?>')" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                                    </span>
                                                </div>
                                            </li>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page == "tmbhpmb"): ?>
    <div style="padding:5%;" class="col-md-12">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Pilih Pembimbing</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h5><b>ID KP</b></h5>
                                <h5 class="form-control"><?php echo $id;?></h5>
                            </div>
                            <div class="form-group">
                                <h5><b>Nama Perusahaan</b></h5>
                                <h5 class="form-control"><?php echo $nm;?></h5>
                            </div>
                            <div class="form-group">
                                <h5><b>Mahasiswa</b></h5>
                                <?php foreach (daftar_kp_dtl($id) as $b) {
                                    echo "<h5 class='form-control'>".$b."</h5>";
                                }?>
                            </div>
                            <div class="form-group">
                                <h5><b>Daftar Dosen</b></h5>
                                <table id="example3" class="table table-bordered table-striped" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th style="width:5%;">No</th>
                                        <th style="width:10%;">Foto</th>
                                        <th>Nama Dosen</th>
                                        <th style="width:10%;"> Pilihan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=0;foreach ($daftar->result() as $a): $no++;?>
                                        <tr>
                                            <td> <?php echo $no; ?> </td>
                                            <td>
                                                <?php if (empty($a->foto_dosen)): ?>
                                                    <img style="width:100%;"src="<?php echo base_url('assets/document/img/style/profile.jpg');?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image">
                                                <?php else: ?>
                                                    <img style="width:100%;"src="<?php echo base_url('assets/document/img/dosen/'.$a->foto_dosen);?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image">
                                                <?php endif; ?>
                                            </td>
                                            <td> <?php echo $a->nama_dosen; ?></td>
                                            <td>
                                                <select class="pilih form-control" name="pilih[]">
                                                    <option value="0">--</option>
                                                    <option value="<?php echo $a->id_dosen;?>">Pilih</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group has-warning">
                                <div class="col-sm-3 " style="display:none" id="loading2">
                                    <label for="inputWarning"><b>Tunggu sebentar!! </b></label><img style="width:20%;" src="<?php echo base_url('assets/img/loading3.gif'); ?>">
                                </div>
                                <div class="col-md-12">
                                    <p id="succes" style="padding:1%;display:none;" class="bg-success">Sukses</p>
                                    <p id="error" style="padding:1%;display:none;" class="bg-danger">Gagal!! Silahkan ulangi kembali.</p>
                                    <p id="errorr" style="padding:1%;display:none;" class="bg-danger">Gagal terkoneksi!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpan('<?php echo $id;?>')">Simpan</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $("#example3").DataTable({
                "responsive": true,
                "pagingType": "simple_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
            });
        });
    </script>
<?php endif; ?>
<?php if ($page == "input_kp_harian"): ?>
    <div style="padding:5%;" class="col-md-12">
        <?php foreach ($daftar->result() as $a): ?>
            <div class="modal-content">
                <div class="modal-header bg-gray-active">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title" id="myModalLabel"><b>Silahkan masukan tugas hari ini.</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h5><b>ID KP</b></h5>
                                    <h5 class="form-control"><?php echo $a->id_kp;?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Tanggal</b></h5>
                                    <h5 class="form-control"><?php echo tgl(date('Y-m-d'));?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Masukan Tugas Harian.</b></h5>
                                    <textarea class="form-control" rows="8" id="ket" placeholder="Masuakan tugas harian..."></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 " style="display:none;" id="loading2">
                                        <label for="inputWarning"><b>Tunggu sebentar!! </b></label><img style="width:10%;" src="<?php echo base_url('assets/img/loading3.gif'); ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <p id="succes" style="padding:1%;display:none;" class="bg-success">Sukses</p>
                                        <p id="error" style="padding:1%;display:none;" class="bg-danger">Gagal!! Silahkan ulangi kembali.</p>
                                        <p id="errorr" style="padding:1%;display:none;" class="bg-danger">Gagal terkoneksi!</p>
                                        <p id="kosong" style="padding:1%;display:none;" class="bg-danger">Silahkan isi terlebih dahulu.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-gray-active">
                    <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_kp_harian('<?php echo $a->id_mahasiswa;?>','<?php echo $a->id_kp;?>','<?php echo $a->id_pembimbing;?>')">Simpan</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if ($page == "input_kp_bimbingan"): ?>
    <div style="padding:5%;" class="col-md-12">
        <?php foreach ($daftar->result() as $a): ?>
            <div class="modal-content">
                <div class="modal-header bg-gray-active">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title" id="myModalLabel"><b>Silahkan masukan catatan bimbingan.</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h5><b>ID KP</b></h5>
                                    <h5 class="form-control"><?php echo $a->id_kp;?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Tanggal</b></h5>
                                    <h5 class="form-control"><?php echo tgl(date('Y-m-d'));?></h5>
                                </div>
                                <div class="form-group">
                                    <h5><b>Masukan Catatan.</b></h5>
                                    <textarea class="form-control" rows="8" id="ket" placeholder="Masukan catatan bimbingan..."></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 " style="display:none;" id="loading2">
                                        <label for="inputWarning"><b>Tunggu sebentar!! </b></label><img style="width:10%;" src="<?php echo base_url('assets/img/loading3.gif'); ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <p id="succes" style="padding:1%;display:none;" class="bg-success">Sukses</p>
                                        <p id="error" style="padding:1%;display:none;" class="bg-danger">Gagal!! Silahkan ulangi kembali.</p>
                                        <p id="errorr" style="padding:1%;display:none;" class="bg-danger">Gagal terkoneksi!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-gray-active">
                    <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_kp_bimbingan('<?php echo $a->id_mahasiswa;?>','<?php echo $a->id_kp;?>','<?php echo $a->id_pembimbing;?>')">Simpan</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if ($page == "smpl_slide"): ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Tambah Gambar Sampul</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <script type="text/javascript">
                            function PreviewImagesp1() {
                                var oFReader = new FileReader();
                                oFReader.readAsDataURL(document.getElementById("foto").files[0]);
                                oFReader.onload = function (oFREvent)
                                {
                                    document.getElementById("uploadPreviewsp1").src = oFREvent.target.result;
                                };
                            };
                        </script>
                        <div class="uploadimage2">
                            <center><img src="<?php echo base_url('assets/document/img/style/gallery.png')?>" id="uploadPreviewsp1" class="thumb-image" style="width:40%;"></center>
                        </div>
                        <center><input id="foto" type="file" class="btn btn-default" value="Pilih" onchange="PreviewImagesp1();"/></center>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 " style="display:none" id="loading2">
                            <label for="inputWarning"><b>Tunggu sebentar!! </b></label><img style="width:10%;" src="<?php echo base_url('assets/img/loading3.gif'); ?>">
                        </div>
                        <div class="col-md-12">
                            <p id="succes" style="padding:1%;display:none;" class="bg-success">Sukses</p>
                            <p id="error" style="padding:1%;display:none;" class="bg-danger">Gagal!! Silahkan ulangi kembali.</p>
                            <p id="fileerror" style="padding:1%;display:none;" class="bg-danger">Gagal!! Ukuran gambar harus dibawah 5 Mb dan bertipe jpe dan png.</p>
                            <p id="errorr" style="padding:1%;display:none;" class="bg-danger">Gagal terkoneksi!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page == "smpl_galeri"): ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Tambah Gambar Galeri</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <script type="text/javascript">
                                function PreviewImagesp1() {
                                    var oFReader = new FileReader();
                                    oFReader.readAsDataURL(document.getElementById("foto").files[0]);
                                    oFReader.onload = function (oFREvent)
                                    {
                                        document.getElementById("uploadPreviewsp1").src = oFREvent.target.result;
                                    };
                                };
                            </script>
                            <div class="uploadimage2">
                                <center><img src="<?php echo base_url('assets/document/img/style/gallery.png')?>" id="uploadPreviewsp1" class="thumb-image" style="width:40%;"></center>
                            </div>
                            <center><input id="foto" type="file" class="btn btn-default" value="Pilih" onchange="PreviewImagesp1();"/></center>
                        </div>
                        <div class="form-group">
                            <h5>Keterangan galeri</h5>
                            <input type="text" class="form-control" id="nama">
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 " style="display:none" id="loading2">
                                <label for="inputWarning"><b>Tunggu sebentar!! </b></label><img style="width:10%;" src="<?php echo base_url('assets/img/loading3.gif'); ?>">
                            </div>
                            <div class="col-md-12">
                                <p id="succes" style="padding:1%;display:none;" class="bg-success">Sukses</p>
                                <p id="error" style="padding:1%;display:none;" class="bg-danger">Gagal!! Silahkan ulangi kembali.</p>
                                <p id="fileerror" style="padding:1%;display:none;" class="bg-danger">Gagal!! Ukuran gambar harus dibawah 5 Mb dan bertipe jpe dan png.</p>
                                <p id="errorr" style="padding:1%;display:none;" class="bg-danger">Gagal terkoneksi!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page == "input_sosial_link"): ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Tambah Sosial Link</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Link Sosial Media</h5>
                            <input type="text" class="form-control" id="link" placeholder="Silahkan isi URL dengan lengkap dengan." value="http://">
                        </div>
                        <div class="form-group">
                            <h5>Jenis</h5>
                            <select class="form-control" id="icon">
                                <option>--</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Linked">Linked</option>
                                <option value="Twitter">Twitter</option>
                                <option value="YouTube">YouTube</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Skype">Skype</option>
                                <option value="Yahoo">Yahoo</option>
                                <option value="Gmail">Gmail</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 " style="display:none" id="loading2">
                                <label for="inputWarning"><b>Tunggu sebentar!! </b></label><img style="width:10%;" src="<?php echo base_url('assets/img/loading3.gif'); ?>">
                            </div>
                            <div class="col-md-12">
                                <p id="succes" style="padding:1%;display:none;" class="bg-success">Sukses</p>
                                <p id="error" style="padding:1%;display:none;" class="bg-danger">Gagal!! Silahkan ulangi kembali.</p>
                                <p id="fileerror" style="padding:1%;display:none;" class="bg-danger">Gagal!! Ukuran gambar harus dibawah 5 Mb dan bertipe jpe dan png.</p>
                                <p id="errorr" style="padding:1%;display:none;" class="bg-danger">Gagal terkoneksi!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page == "ubah_sosial_link"): ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray-active">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title" id="myModalLabel"><b>Ubah Sosial Link</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Link Sosial Media</h5>
                            <input type="text" class="form-control" id="link" value="<?php echo $link;?>">
                        </div>
                        <div class="form-group">
                            <h5>Jenis</h5>
                            <select class="form-control" id="icon">
                                <option value="<?php echo $icon;?>"><?php echo $icon;?></option>
                                <option value="Facebook">Facebook</option>
                                <option value="Linked">Linked</option>
                                <option value="Twitter">Twitter</option>
                                <option value="YouTube">YouTube</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Skype">Skype</option>
                                <option value="Yahoo">Yahoo</option>
                                <option value="Gmail">Gmail</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 " style="display:none" id="loading2">
                                <label for="inputWarning"><b>Tunggu sebentar!! </b></label><img style="width:10%;" src="<?php echo base_url('assets/img/loading3.gif'); ?>">
                            </div>
                            <div class="col-md-12">
                                <p id="succes" style="padding:1%;display:none;" class="bg-success">Sukses</p>
                                <p id="error" style="padding:1%;display:none;" class="bg-danger">Gagal!! Silahkan ulangi kembali.</p>
                                <p id="fileerror" style="padding:1%;display:none;" class="bg-danger">Gagal!! Ukuran gambar harus dibawah 5 Mb dan bertipe jpe dan png.</p>
                                <p id="errorr" style="padding:1%;display:none;" class="bg-danger">Gagal terkoneksi!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-gray-active">
                <button type="reset" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpan_ubah('<?php echo $id;?>')">Simpan</button>
            </div>
        </div>
    </div>
<?php endif; ?>
</html>
