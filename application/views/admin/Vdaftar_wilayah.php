<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown sidebar-mini fixed">
<div class="wrapper">
    <?php $this->load->view('admin/Vheader') ?>
    <?php $this->load->view('admin/Vsidebar-menu') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Document <small>Daftar Wilayah</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-book"></i> Document</a></li>
                <li class="active">Daftar Wilayah</li>
            </ol>
        </section>

        <section class="content connectedSortable">
            <div class="row">
                <div id="viewdata"></div>
            </div>
        </section>
    </div>
    <?php $this->load->view('style/Vfooter'); ?>
</div>

<?php $this->load->view('style/Vjs'); ?>
<script type="text/javascript">
    document.getElementById('document').setAttribute("class", "active");
    document.getElementById('d_wilayah').setAttribute("class", "active");

    $(function () {
        viewdata('list',0);
    });
    function viewdata(str,id)
    {
        loading_page_start();
        $.ajax({
                type: "GET",
                data: {'page':str,'id':id},
                url: "<?php echo base_url('Admin/daftar_wilayah_data'); ?>"
            }).done(function( data ) {
                loading_page_end();
                $('#viewdata').html(data);
        });
    }
    function hapus(str,str2)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan menghapus wilayah "+str2+"!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    var data = new FormData();
                    data.append('id', str);
                    data.append('wilayah', str2);
                    $.ajax({
                        type: "POST", data: data, processData: false,
                        contentType: false, url: "<?php echo base_url('Admin/input_hapus_wilayah')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");
                                $('#example2').DataTable().ajax.reload();
                            }
                            else if(data==0)
                            {
                                swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");;
                            }
                            else{alert(data);}
                        },
                        error:function(data)
                        {swal("Oops...", "Terjadi kesalahan!!! Coba lagi.", "error");}
                    });
                }, 2000);
            });
    }
    function ubah(str)
    {
        if ($("#wilayah").val() == "") {
            swal("Oops...", "Silahkan wilayah untuk wajib di isi.", "error");
        } else {
            swal({
                    title: "Anda Yakin?",
                    text: "Anda akan mengubah data!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                        var data = new FormData();
                        data.append('id', str);
                        data.append('wilayah', $("#wilayah").val());
                        $.ajax({
                            type: "POST", data: data, processData: false,
                            contentType: false, url: "<?php echo base_url('Admin/input_ubah_wilayah')?>",
                            success: function(data)
                            {
                                if (data==1) {
                                    swal("Sukses", "", "success");
                                    viewdata('list');
                                } else if(data==0) {
                                    swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");;
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
    function simpan()
    {
        if ($("#wilayah").val() == "") {
            swal("Oops...", "Silahkan wilayah untuk wajib di isi.", "error");
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
                        data.append('wilayah', $("#wilayah").val());
                        $.ajax({
                            type: "POST", data: data, processData: false,
                            contentType: false, url: "<?php echo base_url('Admin/input_tambah_wilayah')?>",
                            success: function(data)
                            {
                                if (data==1) {
                                    swal("Sukses", "", "success");
                                    viewdata('list');
                                } else if(data==2) {
                                    swal("Oops...", "File terlalu besar, harus dibawah 1 Mb & harus bertipe JPG, JPEG, dan PNG!", "error");
                                } else if(data==0) {
                                    swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");;
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
</script>
</body>
</html>
