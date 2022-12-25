<html>
<form>
    <div class="box-body">
        <div class="box box-solid box-brown">
            <div class="box-header">
                <label for="inputName" class="control-label">Surat Pegantar Ijin Kerja Praktik</label>
            </div>
            <div class="box-body">
                <?php if ($data_idkp->num_rows() == 1 AND $data_pers->num_rows() == 1): ?>
                    <?php foreach ($data_pers->result() as $z): ?>
                        <?php if (!empty($z->nama_perusahaan)): ?>
                            <div class="callout callout-success">
                                <h4>Surat Pengantar Ijin KP</h4>
                                <p>Silahkan unduh untuk mengajukan ke tempat magang.</p>
                            </div>
                            <div class="form-group">
                                <ul class="mailbox-attachments clearfix">
                                    <li>
                                        <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                        <div class="mailbox-attachment-info">
                                            <a class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Surat Permohonan Ijin kerja Praktik </a>
                                            <span class="mailbox-attachment-size">
                                                <?php echo formatBytes("108")." PDF"; ?>
                                                <a href="javascript:avoid()" onclick="download_sikp()" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <div class="callout callout-warning">
                                <h4>Surat Pengantar Ijin KP</h4>
                                <p>Silahkan isi dengan lengkap data perusahaan seperti nama, deskripsi, dan alamat perusahaan.</p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="callout callout-warning">
                        <h4>Surat Pengantar Ijin KP</h4>
                        <p>Silahkan isi dengan lengkap data perusahaan seperti nama, deskripsi, alamat perusahaan dan form KP.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($data_kp->num_rows() == 1): ?>
            <?php foreach ($data_kp->result() as $a): ?>
                <div class="box box-solid box-brown">
                    <div class="box-header">
                        <label for="inputName" class="control-label">Laporan Kerja Praktik</label>
                    </div>
                    <div class="box-body">
                        <?php if (empty($a->nama_laporan)): ?>
                            <div class="callout callout-danger">
                                <h4>Laporan KP belum dikonfirmasi</h4>
                                <p>Silahkan isi judul laporan dan menunjukan surat bimbingan KP untuk dapat di konfirmasi oleh admin.</p>
                            </div>
                        <?php endif; ?>
                        <?php if ($a->stt == "0"): ?>
                            <div class="callout callout-warning">
                                <h4>Laporan KP sedang tahap konfirmasi</h4>
                                <p>Silahkan tunggu dan menunjukan surat bimbingan KP ke admin untuk dikonfirmasi.</p>
                            </div>
                        <?php endif; ?>
                        <?php if ($a->stt == "1"): ?>
                            <div class="callout callout-success">
                                <h4>Laporan KP telah dikonfirmasi</h4>
                                <p>Sukses.</p>
                            </div>
                        <?php endif; ?>
                        <div class="form-group has-warning">
                            <label for="inputName" class="control-label">Judul Laporan Kerja Praktik</label>
                            <div class="row">
                                <?php foreach ($data_idkp->result() as $b): ?>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div>
                                                <textarea class="form-control" rows="2" cols="80" id="judul" placeholder="Judul Laporan"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?php if ($a->stt == "1"): ?>
                                                        <button type="button" disabled class="btn btn-primary col-md-12" onclick="upload_lap_kp('<?php echo $b->id_kp; ?>','<?php echo $a->id_kp_laporan;?>')">Simpan</button>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-primary col-md-12" onclick="upload_lap_kp('<?php echo $b->id_kp; ?>','<?php echo $a->id_kp_laporan;?>')">Simpan</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
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
                <h4>Pembimbing masih kosong</h4>
                <p>Silahkan tunggu sampai admin menambahkan pembimbing untuk dapat mengunggah laporan KP.</p>
            </div>
        <?php endif; ?>
    </div>
</form>
</htML>
