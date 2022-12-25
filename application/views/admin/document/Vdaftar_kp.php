<div class="col-md-12">
    <div class="box box-brown">
        <div class="box-header">
            <h3 class="box-title">Daftar KP</h3>
            <a href="<?= base_url('Admin/data_kp_rekap?type=Excel'); ?>" target="_blank" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Excel</a>
            <a href="<?= base_url('Admin/data_kp_rekap?type=PDF'); ?>" target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px"><i class="fa fa-print"></i> PDF</a>
            <button type="button" class="btn btn-warning pull-right" style="margin-right: 5px" onclick="check_all()"><i class="fa fa-check"></i> Cek Semua</button>
        </div>
        <div class="box-body">
            <div class="form-group">
                <table id="example2" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                    <tr>
                        <th style="width:5%;">Arsip</th>
                        <th style="width:5%;">No</th>
                        <th style="width:10%;"> ID KP</th>
                        <th style="width:15%;"> Nama Perusahaan </th>
                        <th style="width:20%;"> Daftar Mahasiswa </th>
                        <th style="width:20%;"> Alamat Perusahaan</th>
                        <th style="width:15%;"> Ditambahkan Pada </th>
                        <th style="width:15%;"> Pilihan </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0; foreach ($daftar->result() as $a): $no++;?>
                        <tr>
                            <td><center><input type="checkbox" name="arsip[]" value="<?= $a->id_kp; ?>"></center></td>
                            <td> <?php echo $no; ?> </td>
                            <td> <a href="<?= base_url('Admin/Daftar_KP/detailkp?idkp=').$a->id_kp?>"> <?php echo $a->id_kp; ?> </a> </td>
                            <td> <?php echo $a->nama_perusahaan; ?> </td>
                            <td>
                                <?php foreach (daftar_kp($a->id_kp) as $b) {
                                    echo $b;
                                }
                                ?>
                            </td>
                            <td> <?php echo $a->alamat; ?> </td>
                            <td> <?php echo waktu_lalu2($a->cdate); ?> </td>
                            <td>
                                <center>
                                    <button type="button" onclick="hapus_kp('<?php echo $a->id_kp;?>')" class="btn btn-danger col-md-12">Hapus</button>
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