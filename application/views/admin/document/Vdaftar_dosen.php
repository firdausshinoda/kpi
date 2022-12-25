<html>
<?php if ($page == "list"): ?>
    <div class="col-md-12">
        <div class="box box-brown">
            <div class="box-header">
                <h3 class="box-title">Daftar Dosen</h3>
                <button type="button" onclick="viewdata('input')"class="btn btn-default pull-right">Tambah</button>
                <button type="button" class="btn btn-warning pull-right" style="margin-right: 5px" onclick="check_all()"><i class="fa fa-check"></i> Cek Semua</button>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <table id="example2" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th style="width:5%;">Arsip</th>
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
                        <?php $no=0;foreach ($daftar->result() as $a): $no++;?>
                            <tr>
                                <td><center><input type="checkbox" name="arsip[]" value="<?= $a->id_dosen."/".$a->nama_dosen; ?>"></center></td>
                                <td> <?php echo $no; ?> </td>
                                <td>
                                    <?php if (empty($a->foto_dosen)): ?>
                                        <img style="width:100%;"src="<?php echo base_url('assets/document/img/style/profile.jpg');?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image">
                                    <?php else: ?>
                                        <img style="width:100%;"src="<?php echo base_url('assets/document/img/dosen/'.$a->foto_dosen);?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image">
                                    <?php endif; ?>
                                </td>
                                <td> <a href="javascript:void()" onclick="detail('<?php echo $a->id_dosen?>')"><?php echo $a->nama_dosen; ?></a></td>
                                <td> <?php echo $a->jabatan; ?> </td>
                                <td> <?php echo $a->alamat; ?> </td>
                                <td> <?php echo $a->email; ?> </td>
                                <td> <?php echo waktu_lalu2($a->cdate); ?> </td>
                                <td>
                                    <center>
                                        <button type="button" onclick="ubah('<?php echo $a->id_dosen;?>')" class="btn btn-info col-md-12">Ubah</button>
                                        <button type="button" onclick="hapus('<?php echo $a->id_dosen;?>','<?php echo $a->nama_dosen;?>')" class="btn btn-danger col-md-12">Hapus</button>
                                    </center>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <code>*Ketika menandai tidak boleh perpindah ke halaman selanjutnya.</code>
                <button type="button" onclick="arsipkan()" class="btn btn-info pull-right">Arsipkan Yang Ditandai</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $("#example2").DataTable({
                responsive: true,
                "pagingType": "simple_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
            } );
        });
        function check_all() {
            var arsipkan = document.getElementsByName("arsip[]");
            var jml=arsipkan.length;
            var b=0;
            for (b=0;b<jml;b++) {
                if (arsipkan[b].checked){
                    arsipkan[b].checked = false;
                } else {
                    arsipkan[b].checked = true;
                }
            }
        }
    </script>
<?php endif; ?>
<?php if ($page == "input"): ?>
    <div class="col-md-12">
        <div class="box box-brown">
            <div class="box-header">
                <h3 class="box-title">Tambah Dosen</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
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
                                    <img src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" id="uploadPreviewsp1" class="thumb-image">
                                </div>
                                <div class="col-md-12">
                                    <input class="col-md-10" id="foto" type="file" name="img" value="Pilih" onchange="PreviewImagesp1();"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <h5><b>NIPY (*)</b></h5>
                                <input class="form-control" id="nipy" placeholder="NIPY wajib diisi dan jangan sampai salah nomor karena akan permanen"></input>
                            </div>
                            <div class="form-group">
                                <h5><b>Nama Dosen (*)</b></h5>
                                <input class="form-control" id="nama" placeholder="Nama Dosen"></input>
                            </div>
                            <div class="form-group">
                                <h5><b>Jabatan Dosen (*)</b></h5>
                                <select class="form-control" id="jabatan">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Ka. Prodi">Ka. Prodi</option>
                                    <option value="Waka. Prodi">Waka. Prodi</option>
                                    <option value="Dosen">Dosen</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Bendahara">Bendahara</option>
                                </select>
                            </div>
                            <h5><b>Agama</b></h5>
                            <select class="form-control" id="agama">
                                <option value="">Pilih</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Budha">Budha</option>
                                <option value="Hindhu">Hindhu</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5><b>Tanggal Lahir</b></h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control" id="tgl" >
                                        <option value="">Tanggal</option>
                                        <?php
                                        for ($i=0; $i<=31; $i++)
                                        {
                                            echo "<option value='$i'>".$i."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="bln" >
                                        <option value="">Bulan</option>
                                        <option value="January">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="thn" >
                                        <option value="">Tahun</option>
                                        <?php
                                        for ($i=date('Y'); $i >=date('Y')-70; $i-=1)
                                        {
                                            echo "<option value='$i'>".$i."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5><b>Jenis Kelamin</b></h5>
                            <select class="form-control" id="sex">
                                <option value="">Jenis Kelamin</option>
                                <option value="Laki - Laki">Laki - Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <h5><b>Email</b></h5>
                            <input type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <h5><b>No HP</b></h5>
                            <input type="text" class="form-control" id="no_hp" placeholder="No HP" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group">
                            <h5><b>No WA</b></h5>
                            <div class="row">
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" disabled placeholder="No WA" value="+62">
                                </div>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" id="no_wa" placeholder="No WA" onkeypress="return isNumberKey(event)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5><b>Alamat</b></h5>
                            <textarea class="form-control" rows="8" cols="80" id="almt" placeholder="Alamat"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-default" onclick="viewdata('list')">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page == "ubah"): ?>
    <?php foreach ($daftar->result() as $a): ?>
        <div class="col-md-12">
            <div class="box box-brown">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubah akun <?php echo $a->nama_dosen; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-brown">
                <div class="box-body box-profile">
                    <form>
                        <script type="text/javascript">
                            function PreviewImagesp() {
                                var oFReader = new FileReader();
                                oFReader.readAsDataURL(document.getElementById("img").files[0]);
                                oFReader.onload = function (oFREvent)
                                {
                                    document.getElementById("uploadPreviewsp").src = oFREvent.target.result;
                                };
                            };
                        </script>
                        <td>
                            <?php if (empty($a->foto_dosen)): ?>
                                <img id="uploadPreviewsp" src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" class="profile-user-img img-responsive img-circle" alt="User profile picture">
                            <?php else: ?>
                                <img id="uploadPreviewsp" src="<?php echo base_url('assets/document/img/dosen/'.$a->foto_dosen)?>" class="profile-user-img img-responsive img-circle" alt="User profile picture">
                            <?php endif; ?>
                        </td>
                        <h3 class="profile-username text-center"><?php echo $a->nama_dosen; ?></h3>
                        <p class="text-muted text-center"><?php echo $a->id_dosen; ?></p>
                        <input style="margin:1%;" id="img" type="file" value="Pilih" onchange="PreviewImagesp();"/>
                        <button type="button" onclick="ubahimg('<?php echo $a->id_dosen;?>','<?php echo $a->nama_dosen;?>','<?php echo $a->foto_dosen;?>')" class="btn btn-primary btn-block"> Simpan Image <i class="fa fa-save"></i></button>
                    </form>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right"><?php echo $a->email; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Jabatan</b> <a class="pull-right"><?php echo $a->jabatan; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Nama</b> <a class="pull-right"><?php echo $a->nama_dosen; ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box box-brown">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubah Password</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputName" class="control-label">Password Baru</label>
                        <input type="text" class="form-control" id="pass" placeholder="Masukan Password Baru">
                    </div>
                    <button type="button" onclick="ubahpass('<?php echo $a->id_dosen;?>','<?php echo $a->nama_dosen;?>')" class="btn btn-primary btn-block"> Simpan password <i class="fa fa-save"></i></button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <form>
                <div class="box box-brown">
                    <div class="box-header with-border">
                        <h3 class="box-title">Biodata</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama" placeholder="Nama" value="<?php echo $a->nama_dosen; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">NIY</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled class="form-control" id="nim" placeholder="NIY" value="<?php echo $a->id_dosen; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Jabatan</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="jabatan">
                                        <option value="<?php echo $a->jabatan;?>"><?php echo $a->jabatan;?></option>
                                        <option value="Ka. Prodi">Ka. Prodi</option>
                                        <option value="Waka. Prodi">Waka. Prodi</option>
                                        <option value="Dosen">Dosen</option>
                                        <option value="Sekretaris">Sekretaris</option>
                                        <option value="Bendahara">Bendahara</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Agama</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="agama">
                                        <option value="<?php echo $a->agama;?>"><?php echo $a->agama;?></option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Hindhu">Hindhu</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="sex">
                                        <option value="<?php echo $a->sex;?>"><?php echo $a->sex;?></option>
                                        <option value="Laki - Laki">Laki - Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tanggal Lahir</label>
                                <div class="col-md-3">
                                    <select class="form-control" id="tgl" >
                                        <option value="<?php echo $a->tgl_lahir;?>"><?php echo $a->tgl_lahir;?></option>
                                        <?php
                                        for ($i=0; $i<=31; $i++)
                                        {
                                            echo "<option value='$i'>".$i."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="bln" >
                                        <option value="<?php echo $a->bln_lahir;?>"><?php echo $a->bln_lahir;?></option>
                                        <option value="January">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="thn" >
                                        <option value="<?php echo $a->thn_lahir;?>"><?php echo $a->thn_lahir;?></option>
                                        <?php
                                        for ($i=date('Y'); $i >=date('Y')-70; $i-=1)
                                        {
                                            echo "<option value='$i'>".$i."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $a->email; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">No HP</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="no_hp" placeholder="No HP" value="<?php echo $a->no_hp; ?>" onkeypress="return isNumberKey(event)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">No WA</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" disabled placeholder="No WA" value="+62">
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="no_wa" placeholder="No WA" value="<?php echo $a->no_wa; ?>" onkeypress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="alamat" placeholder="Alamat" value="<?php echo $a->alamat; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="button" onclick="viewdata('list')" class="btn btn-default">Batal</button>
                            <button type="button" onclick="ubahprofil('<?php echo $a->id_dosen;?>','<?php echo $a->nama_dosen;?>')" class="btn btn-primary"> Save Change <i class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</html>
