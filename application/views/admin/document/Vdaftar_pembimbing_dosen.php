<html>
<div class="col-md-12">
    <div class="box box-brown">
        <div class="box-header">
            <h3 class="box-title">Daftar Pembimbing</h3>
            <button type="button" class="btn btn-warning pull-right" style="margin-right: 5px" onclick="check_all()"><i class="fa fa-check"></i> Cek Semua</button>
        </div>
        <div class="box-body">
            <div class="form-group">
                <table id="example2" class="table table-bordered table-striped" style="width:100%;">
                    <thead>
                    <tr>
                        <th style="width:5%;">Arsip</th>
                        <th style="width:5%;">No</th>
                        <th style="width:10%;">Foto</th>
                        <th style="width:10%;">Nama Dosen</th>
                        <th style="width:10%;">Foto</th>
                        <th style="width:10%;">Nama Mahasiswa</th>
                        <th style="width:10%;">Nama Perusahaan</th>
                        <th style="width:10%;">ID KP</th>
                        <th style="width:15%;">Nama Laporan</th>
                        <th style="width:10%;">Setatus Lap.</th>
                        <th style="width:10%;"> Tanggal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 0; foreach ($daftar->result() as $a): $no++;?>
                        <tr>
                            <td><center><input type="checkbox" name="arsip[]" value="<?= $a->id_pembimbing_mahasiswa."/".$a->nama_mahasiswa."/".$a->nama_dosen; ?>"></center></td>
                            <td> <?php echo $no; ?> </td>
                            <td>
                                <?php if (empty($a->foto_dosen)):?>
                                    <img style="width:100%;"src="<?php echo base_url('assets/document/img/style/profile.jpg');?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image">
                                <?php else: ?>
                                    <img style="width:100%;"src="<?php echo base_url('assets/document/img/dosen/'.$a->foto_dosen);?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image">
                                <?php endif;?>
                            </td>
                            <td> <a href="javascript:void();" onclick="dtl_dsn('<?php echo $a->id_dosen;?>');"><?php echo $a->nama_dosen; ?></a> </td>
                            <td>
                                <?php if (empty($a->foto_mahasiswa)):?>
                                    <img style="width:100%;"src="<?php echo base_url('assets/document/img/style/profile.jpg');?>" class="profile-user-img img-responsive img-circle" alt="Mahasiswa Image">
                                <?php else: ?>
                                    <img style="width:100%;"src="<?php echo base_url('assets/document/img/mahasiswa/'.$a->foto_mahasiswa);?>" class="profile-user-img img-responsive img-circle" alt="Mahasiswa Image">
                                <?php endif;?>
                            </td>
                            <td> <a href="javascript:void();" onclick="dtl_mhs('<?php echo $a->id_mahasiswa;?>');"><?php echo $a->nama_mahasiswa; ?></a> </td>
                            <td> <?php echo $a->nama_perusahaan; ?> </td>
                            <td> <a href="javascript:void();" onclick="detail('<?php echo $a->id_kp;?>');"><?php echo $a->id_kp; ?></a> </td>
                            <td> <?php echo $a->nama_laporan; ?> </td>
                            <td>
                                <?php if ($a->stt == 1): ?>
                                    <button type="button" class="btn btn-success col-md-12">Laporan Selesai</button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-danger col-md-12"> Laporan Belum Selesai</button>
                                <?php endif; ?>
                            </td>
                            <td> <?php echo waktu_lalu2($a->cdate); ?> </td>
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
        });
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
</html>
