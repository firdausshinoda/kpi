<html>
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
        <?php if (!empty($foto)): ?>
          <img id="uploadPreviewsp" src="<?php echo base_url('assets/document/img/admin/'.$foto)?>" class="profile-user-img img-responsive img-circle" alt="User profile picture">
          <?php else: ?>
            <img id="uploadPreviewsp" src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" class="profile-user-img img-responsive img-circle" alt="User profile picture">
        <?php endif; ?>
        <h3 class="profile-username text-center"><?php echo $nama_admin; ?></h3>
        <p class="text-muted text-center"><?php echo $niy; ?></p>
        <input style="margin:1%;" id="img" class="btn btn-default" type="file" value="Pilih" onchange="PreviewImagesp();"/>
        <button type="button" onclick="ubah_img('<?php echo $niy;?>','<?php echo $foto;?>')" class="btn btn-primary btn-block"> Simpan Image <i class="fa fa-save"></i></button>
      </form>
      <ul class="list-group list-group-unbordered">
        <li class="list-group-item">
          <b>Email</b> <a class="pull-right"><?php echo $email; ?></a>
        </li>
        <li class="list-group-item">
          <b>Jabatan</b> <a class="pull-right"><?php echo $jabatan; ?></a>
        </li>
        <li class="list-group-item">
          <b>Nama</b> <a class="pull-right"><?php echo $nama_admin; ?></a>
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
        <label for="inputName" class="control-label">Password Lama</label>
        <input type="password" class="form-control" id="passlama" placeholder="Masukan Password Lama">
      </div>
      <div class="form-group">
        <label for="inputName" class="control-label">Password Baru</label>
        <input type="password" class="form-control" id="passbaru" placeholder="Masukan Password Baru">
      </div>
      <button type="button" onclick="ubah_pass('<?php echo $niy;?>')" class="btn btn-primary btn-block"> Simpan password <i class="fa fa-save"></i></button>
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
              <input type="text" class="form-control" id="nama" placeholder="Nama" disabled value="<?php echo $nama_admin; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Username Admin</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="username" placeholder="Username Admin" disabled value="<?php echo $username_admin; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">NIPY</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="niy" placeholder="NIPY" disabled value="<?php echo $niy; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Jabatan</label>
            <div class="col-sm-10">
              <select class="form-control" id="jabatan" disabled>
                <option value="<?php echo $jabatan;?>"><?php echo $jabatan;?></option>
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
              <select class="form-control" id="agama" disabled>
                <option value="<?php echo $agama;?>"><?php echo $agama;?></option>
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
              <select class="form-control" id="sex" disabled>
                <option value="<?php echo $sex;?>"><?php echo $sex;?></option>
                <option value="Laki - Laki">Laki - Laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Tanggal Lahir</label>
            <div class="col-md-3">
              <select class="form-control" id="tgl" disabled>
                <option value="<?php echo $tgl_lahir;?>"><?php echo $tgl_lahir;?></option>
                <?php
                for ($i=0; $i<=31; $i++)
                {
                  echo "<option value='$i'>".$i."</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <select class="form-control" id="bln" disabled>
                <option value="<?php echo $bln_lahir;?>"><?php echo $bln_lahir;?></option>
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
              <select class="form-control" id="thn" disabled>
                <option value="<?php echo $thn_lahir;?>"><?php echo $thn_lahir;?></option>
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
              <input type="email" class="form-control" id="email" placeholder="Email" disabled value="<?php echo $email; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Alamat</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="alamat" placeholder="Alamat" disabled value="<?php echo $alamat; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
	      <?php if ($mdate != ""): ?>
		<h5><i class="fa fa-hourglass-2"></i> Dirubah terakhir pada <?php echo waktu_lalu2($mdate); ?></h5>
	      <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-warning" id="ubah" onclick="btn('1')">Ubah</button>
          <button type="button" class="btn btn-default" id="batal" onclick="btn('2')" style="display:none;">Batal</button>
          <button type="button" onclick="ubah_biodata('<?php echo $id_admin;?>')" style="display:none;" id="simpan" class="btn btn-primary"> Save Change <i class="fa fa-arrow-right"></i></button>
        </div>
      </div>
    </div>
  </form>
</div>
</html>
