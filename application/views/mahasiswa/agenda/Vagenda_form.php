<html>
<div class="post">
    <form>
        <div class="box-header with-border">
            <div class="col-md-6">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">ID KP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="idkp" placeholder="ID KP" value="<?php if(empty($id_kp)){} else{echo $id_kp;}?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                        if (empty($id_mahasiswa) AND empty($create_id_kp))
                        {
                            ?>
                            <div class="col-md-6">
                                <button type="button" onclick="baru_id()" class="btn btn-primary btn-block">Konfirmasi ID</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" onclick="join_id()" class="btn btn-primary btn-block">Gabung</button>
                            </div>
                            <?php
                        }
                        else
                        {
                            if ($id_mahasiswa == $create_id_kp)
                            {
                                ?>
                                <?php if ($stt !== "1"): ?>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-block" onclick="hapus_id('<?php echo $id_kp;?>')">Hapus ID</button>
                                </div>
                            <?php endif; ?>
                                <?php if ($stt == "1"): ?>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger btn-block" disabled="">Hapus ID</button>
                                </div>
                            <?php endif; ?>
                                <?php
                            }
                            else if($id_mahasiswa !== $create_id_kp)
                            {
                                ?>
                                <div class="col-md-12">
                                    <button type="button" onclick="keluar_id()" class="btn btn-danger btn-block">Keluar</button>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php if (!empty($id_mahasiswa) AND !empty($create_id_kp)): ?>
                <div class="col-md-6">
                    <div class="box box-solid box-brown">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tambah Anggota</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-md-2 control-label">NIM</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="nim" placeholder="NIM">
                                    </div>
                                    <div class="col-md-4">
                                        <?php if ($stt == "1"): ?>
                                            <button type="button" disabled onclick="tambah_id('<?php echo $id_kp;?>')" class="btn btn-default btn-block">Tambah</button>
                                        <?php else: ?>
                                            <button type="button" onclick="tambah_id('<?php echo $id_kp;?>')" class="btn btn-default btn-block">Tambah</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="box-body">
            <div class="box box-widget">
                <div class="box-body">
                    <p>Dibuat oleh <?php echo $nama_mahasiswa; ?></p>
                </div>
            </div>
            <?php if (empty($stt)): ?>
                <div class="callout callout-danger">
                    <h4>ID KP belum dikonfirmasi</h4>
                    <p>Silahkan isi semua data perusahaan dan lampiran surat bahwa telah dikonfirmasi oleh pihak perusahaan untuk dapat di konfirmasi oleh admin.</p>
                </div>
            <?php endif; ?>
            <?php if ($stt== "3"): ?>

            <?php endif; ?>
            <?php if ($stt == "2"): ?>
                <div class="callout callout-warning">
                    <h4>ID KP sedang tahap konfirmasi</h4>
                    <p>Silahkan tunggu beberapa saat sampai admin mengkonfirmasinya.</p>
                </div>
            <?php endif; ?>
            <?php if ($stt == "1"): ?>
                <div class="callout callout-success">
                    <h4>ID KP telah dikonfirmasi</h4>
                    <p>Selamat KP.</p>
                </div>
            <?php endif; ?>
            <?php if (!empty($daftar_anggota_kp)):?>
                <div class="box box-solid box-brown">
                    <div class="box-body">
                        <?php foreach ($daftar_anggota_kp->result() as $daftar): ?>
                            <div class=" box box-widget">
                                <div class='box-body'>
                                    <div class="user-block">
                                        <?php if (empty($daftar->foto_mahasiswa) || !file_exists(base_url('assets/document/img/mahasiswa/'.$daftar->foto_mahasiswa))): ?>
                                            <img class="img-circle img-bordered-sm" src="<?php echo base_url('assets/document/img/style/profile.jpg')?>" alt="user image">
                                        <?php else: ?>
                                            <img class="img-circle img-bordered-sm" src="<?php echo base_url('assets/document/img/mahasiswa/'.$daftar->foto_mahasiswa)?>" alt="user image">
                                        <?php endif; ?>
                                        <span class='username'>
                                          <a onclick="dtl_mhs('<?php echo $daftar->id_mahasiswa;?>')" href="javascript:void()"><?php echo $daftar->nama_mahasiswa; ?></a>
                                          <?php if ($id_mahasiswa == $create_id_kp): ?>
                                              <a href='javascript:void()' title="Hapus" onclick="keluarkan_id('<?php echo $daftar->id_mahasiswa;?>','<?php echo $daftar->id_kp;?>')" class='pull-right btn-box-tool'><i class='fa fa-times'></i></a>
                                          <?php endif; ?>
                                          <p><?php echo $daftar->id_mahasiswa; ?></p>
                                        </span>
                                        <span class='description'>Ditambahkan pada - <?php echo waktu_lalu2($daftar->cdate); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endif;?>
        </div>
</div>
</htML>
