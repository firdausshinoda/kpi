<html>
<div class="col-md-12">
    <div class="box box-brown">
        <div class="box-header">
            <h3 class="box-title">Daftar Dosen Terhapus</h3>
            <button type="button" class="btn btn-warning pull-right" style="margin-right: 5px" onclick="check_all()"><i class="fa fa-check"></i> Cek Semua</button>
        </div>
        <div class="box-body">
            <div class="form-group">
                <table id="example2" class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                    <tr>
                        <th style="width:5%;"></th>
                        <th style="width:5%;">No</th>
                        <th style="width:10%;">Foto</th>
                        <th style="width:20%;">Nama Dosen</th>
                        <th style="width:10%;">Jabatan</th>
                        <th style="width:20%;">Alamat</th>
                        <th style="width:10%;">Email</th>
                        <th style="width:10%;">Tanggal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0;foreach ($data->result() as $a): $no++;?>
                        <tr>
                            <td>
                                <?php if (empty($a->foto_dosen)): ?>
                                    <center><input type="checkbox" name="tandai[]" value="<?= $a->id_dosen."/".$a->nama_dosen."/0"; ?>"></center>
                                <?php else: ?>
                                    <center><input type="checkbox" name="tandai[]" value="<?= $a->id_dosen."/".$a->nama_dosen."/".$a->foto_dosen; ?>"></center>
                                <?php endif; ?>
                            </td>
                            <td> <?= $no; ?> </td>
                            <td>
                                <?php if (empty($a->foto_dosen)): ?>
                                    <img style="width:100%;"src="<?= base_url('assets/document/img/style/profile.jpg');?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image">
                                <?php else: ?>
                                    <img style="width:100%;"src="<?= base_url('assets/document/img/dosen/'.$a->foto_dosen);?>" class="profile-user-img img-responsive img-circle" alt="Dosen Image">
                                <?php endif; ?>
                            </td>
                            <td> <a href="javascript:avoid()" onclick="detail('<?= $a->id_dosen?>')"><?= $a->nama_dosen; ?></a></td>
                            <td> <?= $a->jabatan; ?> </td>
                            <td> <?= $a->alamat; ?> </td>
                            <td> <?= $a->email; ?> </td>
                            <td> <?= waktu_lalu2($a->ddate); ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <code>*Ketika menandai tidak boleh perpindah ke halaman selanjutnya.</code><br>
            <button type="button" onclick="execute_tandai('restore')" class="btn btn-warning pull-right">Aktifkan Kembali Yang Ditandai</button>
            <button type="button" onclick="execute_tandai('delete')" class="btn btn-danger pull-right" style="margin-right: 1%">Hapus Permanen Yang Ditandai</button>
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
    function check_all() {
        var arsipkan = document.getElementsByName("tandai[]");
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
    function execute_tandai(str) {
        var data = new FormData();
        var tandai = document.getElementsByName("tandai[]");
        var ttl_tandai = tandai.length;
        var ttl_tandai_check = 0;
        for (var i = 0; i < ttl_tandai; i++) {
            if (tandai[i].checked){
                data.append("data_dosen[]", tandai[i].value);
            } else {
                ttl_tandai_check++;
            }
        }

        var pesan='';
        if (str==="restore"){
            pesan = "aktifkan";
        } else {
            pesan = "hapus permanen";
        }
        data.append("type", str);

        if (ttl_tandai===ttl_tandai_check){
            swal("Oops...", "Silahkan berikan tanda ceklis jika ingin "+pesan+" data.", "error");
            return false;
        }

        swal({
                title: "Anda Yakin?",
                text: "Anda akan "+pesan+" data!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    $.ajax({
                        type: "POST", data: data, processData: false,
                        contentType: false, url: "<?php echo base_url('Admin/dosen_terhapus_proses')?>",
                        success: function(data) {
                            if (data==1) {
                                swal("Sukses", "", "success");
                                ambil_data();
                            } else if (data==0) {
                                swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");
                            }
                            else{alert(data);}
                        },
                        error:function(data)
                        {swal("Oops...", "Terjadi kesalahan!!! Coba lagi.", "error");}
                    });
                }, 2000);
            });
    }
</script>
</html>
