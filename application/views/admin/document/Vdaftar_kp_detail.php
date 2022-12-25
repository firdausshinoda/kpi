<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown sidebar-mini fixed">
<div class="wrapper">
    <?php $this->load->view('admin/Vheader') ?>
    <?php $this->load->view('admin/Vsidebar-menu') ?>
    <style type="text/css">
        .select2-container--default .select2-selection--single {
            border: 1px solid #f39c12;
        }
        .select2-dropdown {
            border: 1px solid #f39c12;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #f39c12;
        }
    </style>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Detail KP
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?= base_url('Admin');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Detail KP</li>
            </ol>
        </section>

        <section class="content connectedSortable">
            <div class="row">
                <div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_perusahaan" data-toggle="tab">Perusahaan</a></li>
                            <li><a href="#tab_pembimbing" data-toggle="tab">Pembimbing</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_perusahaan">
                                <div class="box-body">
                                    <div class="form-group has-warning">
                                        <label for="inputName" class="control-label">Nama Perusahaan</label>
                                        <div>
                                            <input type="text" class="form-control" id="nm_pers" placeholder="Nama Perusahaan" value="<?= $data->nama_perusahaan;?>">
                                        </div>
                                    </div>
                                    <div class="form-group has-warning">
                                        <label for="inputName" class="control-label">Bidang Kerja</label>
                                        <select class="form-control select2" name="bid_kerja" id="bid_kerja" style="width: 100%;">
                                            <option value="<?= $data->id_bidang_kerja; ?>" selected><?= $data->bidang_kerja; ?></option>
                                            <?php foreach ($bid_kerja->result() as $bk):?>
                                                <option value="<?= $bk->id_bidang_kerja; ?>"><?= $bk->bidang_kerja; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div style="display: none" id="div_bid_kerja_lainnya">
                                            <br><input type="text" class="form-control" id="bid_kerja_lainnya" placeholder="Silahkan diisi lainnya...">
                                        </div>
                                    </div>
                                    <div class="form-group has-warning">
                                        <label for="inputName" class="control-label">Deskripsi Perusahaan</label>
                                        <div>
                                            <textarea rows="5" class="form-control" id="desk_pers" placeholder="Deskripsi Perusahaan"><?= $data->deskripsi;?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group has-warning">
                                        <label for="inputName" class="control-label">Wilayah</label>
                                        <select class="form-control select2" name="wilayah" id="wilayah" style="width: 100%;">
                                            <option value="<?= $data->id_wilayah; ?>" selected><?= $data->wilayah; ?></option>
                                            <?php foreach ($wilayah->result() as $wil):?>
                                                <option value="<?= $wil->id_wilayah; ?>"><?= $wil->wilayah; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div style="display: none" id="div_wilayah_lainnya">
                                            <br><input type="text" class="form-control" id="wilayah_lainnya" placeholder="Silahkan diisi lainnya...">
                                        </div>
                                    </div>
                                    <div class="form-group has-warning">
                                        <label for="inputName" class="control-label">Alamat</label>
                                        <div>
                                            <textarea class="form-control" id="almt_pers" placeholder="Alamat Perusahaan" rows="5"><?= $data->alamat;?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group has-warning">
                                        <label for="inputName" class="control-label">Status Data</label>
                                        <div>
                                            <?php if ($data->stt == 1):?>
                                                <input type="text" disabled class="form-control" value="Sudah Dikonfirmasi Admin">
                                            <?php else: ?>
                                                <input type="text" disabled class="form-control" value="Belum Dikonfirmasi Admin">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" id="btn_simpan_dt_pers" class="btn btn-primary" onclick="simpan_dt_pers('<?= $data->id_kp;?>')">Simpan</button>
                                    </div>
                                    <div class="form-group has-warning">
                                        <label for="inputName" class="control-label">Surat Diterima KP Oleh Perusahaan</label>
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <input id="doc_pers" type="file" name="file" class="btn btn-default"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="btn_dokumen_pers" onclick="dokumen_pers('<?php echo $data->id_kp?>','<?php echo $data->nama_file?>')" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group has-warning">
                                        <div class="attachment-block clearfix">
                                            <div class="attachment-text">
                                                Silahkan unggah file dokumen bertipe PDF maupun DOC/DOCX.
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($data->nama_file)): ?>
                                        <div class="form-group col-md-12">
                                            <label for="inputName" class="control-label">Surat Diterima KP Oleh Perusahaan</label>
                                            <ul class="mailbox-attachments clearfix">
                                                <li>
                                                    <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                    <div class="mailbox-attachment-info">
                                                        <a class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?= substrfile($data->nama_file);?> </a>
                                                        <span class="mailbox-attachment-size">
                                                          <?= formatBytes($data->size);?>
                                                          <a href="javascript:void();" onclick="download_dt_pers('<?= $data->nama_file;?>')" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_pembimbing">
                                <div class="box-body">
                                    <?php if ($pembimbing->num_rows() >= 1): ?>
                                        <?php foreach ($pembimbing->result() as $daftar): ?>
                                            <div class=" box box-widget">
                                                <div class='box-body'>
                                                    <div class="user-block">
                                                        <?php if (empty($daftar->foto_dosen)): ?>
                                                            <img class="img-circle img-bordered-sm" src="<?= base_url('assets/document/img/style/profile.jpg') ?>" alt="user image">
                                                        <?php else: ?>
                                                            <img class="img-circle img-bordered-sm" src="<?= base_url('assets/document/img/dosen/'.$daftar->foto_dosen)?>" alt="user image">
                                                        <?php endif; ?>
                                                        <span class='username'>
                                                          <a onclick="dtl_dsn('<?= $daftar->id_dosen;?>')" href="javascript:avoid()"><?= $daftar->nama_dosen; ?></a>
                                                        </span>
                                                        <span class='description'><?= $daftar->id_dosen; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="callout callout-danger">
                                            <h4>Pembimbing masih kosong</h4>
                                            <p>Silahkan tunggu sampai admin menambahkan pembimbing.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php $this->load->view('style/Vfooter'); ?>
</div>

<?php $this->load->view('style/Vjs'); ?>
<script type="text/javascript">
    document.getElementById('document').setAttribute("class", "active");
    document.getElementById('d_kp').setAttribute("class", "active");

    $(function () {
        $(".select2").select2();
    });

    $('#bid_kerja').change(function(){
        if ($(this).find("option:selected").attr('value') === "1"){ $("#div_bid_kerja_lainnya").show(); }
        else { $("#div_bid_kerja_lainnya").hide(); }
    });
    $('#wilayah').change(function(){
        if ($(this).find("option:selected").attr('value') === "1"){ $("#div_wilayah_lainnya").show(); }
        else { $("#div_wilayah_lainnya").hide(); }
    });

    var bid_kerja = {};
    $("select[name='bid_kerja'] > option").each(function () {
        if(bid_kerja[this.text]) { $(this).remove(); }
        else { bid_kerja[this.text] = this.value; }
    });
    var wilayah = {};
    $("select[name='wilayah'] > option").each(function () {
        if(wilayah[this.text]) { $(this).remove(); }
        else { wilayah[this.text] = this.value; }
    });

    function simpan_dt_pers(str)
    {
        var nm_pers = $("#nm_pers").val();
        var bid_kerja = $("#bid_kerja").val();
        var bid_kerja_lainnya = $("#bid_kerja_lainnya").val();
        var desk_pers = $("#desk_pers").val();
        var wilayah = $("#wilayah").val();
        var wilayah_lainnya = $("#wilayah_lainnya").val();
        var almt_pers = $("#almt_pers").val();
        var stt_bid_kerja = true;
        if (bid_kerja == "1"){
            if (bid_kerja_lainnya == ""){
                stt_bid_kerja = false;
            }
        }
        var stt_wilayah = true;
        if (wilayah == "1"){
            if (wilayah_lainnya == ""){
                stt_wilayah = false;
            }
        }

        if (nm_pers == "" || desk_pers == "" || almt_pers == "" || wilayah == "") {
            swal("Oops...", "Silahkan isi terlebih dahulu.", "error");
        } else if (stt_bid_kerja === false) {
            swal("Oops...", "Silahkan isi terlebih dahulu bidang kerja.", "error");
        }  else if (stt_wilayah === false) {
            swal("Oops...", "Silahkan isi terlebih dahulu wilayah.", "error");
        } else {
            swal({
                    title: "Anda Yakin?",
                    text: "Anda akan menyimpan data!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                        $.ajax({
                            type: "POST",
                            data: {
                                nm_pers:nm_pers,
                                desk_pers:desk_pers,
                                almt_pers:almt_pers,
                                bid_kerja:bid_kerja,
                                bid_kerja_lainnya:bid_kerja_lainnya,
                                wilayah:wilayah,
                                wilayah_lainnya:wilayah_lainnya,
                                id:str
                            },
                            url: "<?php echo base_url('Admin/input_dt_pers')?>",
                            success: function(data)
                            {
                                if (data==1)
                                {
                                    swal("Sukses", "", "success");
                                    location.reload();
                                }
                                else if(data==0)
                                {
                                    swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");
                                }
                                else{alert(data);}
                            },
                            error:function(data)
                            {swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");}
                        });
                    }, 2000);
                });
        }
    }

    function dokumen_pers(str,str2)
    {
        var doc = $("#doc_pers")[0].files[0];
        if (doc == null) {
            swal("Oops...", "Tidak ada file yg dipilih. Silahkan pilih file terlebih dahulu.", "error");
        } else {
            swal({
                    title: "Anda Yakin?",
                    text: "Anda akan menyimpan data!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                        var data = new FormData();
                        data.append('file', doc);
                        data.append('id', str);
                        data.append('nama_file', str2);
                        $.ajax({
                            type: "POST",
                            data: data,
                            processData: false,
                            contentType: false,
                            url: "<?php echo base_url('Admin/input_dokumen_pers')?>",
                            success: function(data)
                            {
                                if (data==1)
                                {
                                    swal("Sukses", "", "success");
                                    location.reload();
                                }
                                else if(data==2)
                                {
                                    swal("Oops...", "File terlalu besar, harus dibawah 1 Mb & harus bertipe PDF, DOC, dan DOCX!", "error");
                                }
                                else if(data==0)
                                {
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
    }

    function download_dt_pers(str)
    {
        location.href = "<?php echo base_url('Admin/download_dt_pers')?>"+"/"+str;
    }

    function dtl_dsn(str)
    {
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detaildsn'},
            url: "<?= base_url('Admin/modal'); ?>",
            success: function(data)
            {
                $("#Modal").html(data);
                $("#Modal").modal('show',{backdrop: 'true'});
            },
            error:function(data)
            {swal("Oops...", "Terjadi kesalahan! Coba lagi!.", "error");}
        });
    }
</script>
</body>
</html>
