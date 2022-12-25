<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown sidebar-mini fixed" onload="viewdata('list');">
<div class="wrapper">
    <?php $this->load->view('admin/Vheader') ?>
    <?php $this->load->view('admin/Vsidebar-menu') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Daftar Mahasiswa
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Daftar Mahasiswa</li>
            </ol>
        </section>

        <section class="content connectedSortable">
            <div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
            <div class="row">
                <div id="viewdata"></div>
            </div>
        </section>
    </div>
    <?php $this->load->view('style/Vfooter'); ?>
</div>

<?php $this->load->view('style/Vjs'); ?>
<script type="text/javascript">
    function viewdata(str)
    {
        loading_page_start();
        document.getElementById('document').setAttribute("class", "active");
        document.getElementById('d_mhs').setAttribute("class", "active");
        $.ajax(
            {
                type: "GET",
                data:{'page':str},
                url: "<?php echo base_url('Admin/daftar_mahasiswa_data'); ?>"
            }
        ).done(function( data )
        {
            loading_page_end();$('#viewdata').html(data);
        });
    }
    function detail(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detailmhs'},
            url: "<?php echo base_url('Admin/modal'); ?>",
            success: function(data)
            {
                loading_page_end();
                $("#Modal").html(data);
                $("#Modal").modal('show',{backdrop: 'true'});
            },
            error:function(data)
            {loading_page_end();swal("Oops...", "Terjadi kesalahan! Coba lagi!.", "error");}
        });
    }
    function ubah(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'ubah'},
            url: "<?php echo base_url('Admin/daftar_mahasiswa_data'); ?>",
            success: function(data)
            {
                loading_page_end();$("#viewdata").html(data);;
            },
            error:function(data)
            {loading_page_end();swal("Oops...", "Terjadi kesalahan! Coba lagi!.", "error");}
        });
    }
    function simpan()
    {
        if ($("#nim").val() == "" || $("#nama").val() == "") {
            swal("Oops...", "Silahkan lengkapi data yang diberi tanda (*) untuk wajib di isi.", "error");
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
                        data.append('img', $("#foto")[0].files[0]);
                        data.append('id', $("#nim").val());
                        data.append('nama', $("#nama").val());
                        data.append('agama', $("#agama").val());
                        data.append('tgl', $("#tgl").val());
                        data.append('bln', $("#bln").val());
                        data.append('thn', $("#thn").val());
                        data.append('sex', $("#sex").val());
                        data.append('no_hp', $("#no_hp").val());
                        data.append('no_wa', $("#no_wa").val());
                        data.append('email', $("#email").val());
                        data.append('alamat', $("#almt").val());
                        data.append('angkatan', $("#angkatan").val());
                        $.ajax({
                            type: "POST",
                            data: data,
                            processData: false,
                            contentType: false,
                            url: "<?php echo base_url('Admin/input_tambah_mahasiswa')?>",
                            success: function(data)
                            {
                                if (data==1)
                                {
                                    swal("Sukses", "", "success");viewdata('list');
                                }
                                else if(data==2)
                                {
                                    swal("Oops...", "File terlalu besar, harus dibawah 1 Mb & harus bertipe JPG, JPEG, dan PNG!", "error");
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
    }
    function hapus(str,str2)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan menghapus "+str2+"!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    var data = new FormData();
                    data.append('id', str);
                    $.ajax({
                        type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        url: "<?php echo base_url('Admin/input_hapus_mahasiswa')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");viewdata('list');
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
    function ubahimg(str,str2,str3)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan mengganti foto "+str2+"!",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    var data = new FormData();
                    data.append('img', $("#img")[0].files[0]);
                    data.append('id', str);
                    data.append('nama', str2);
                    data.append('nmimg', str3);
                    $.ajax({
                        type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        url: "<?php echo base_url('Admin/input_ubahimg_mahasiswa')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");viewdata('list');
                            }
                            else if(data==2)
                            {
                                swal("Oops...", "File terlalu besar, harus dibawah 1 Mb & harus bertipe JPG, JPEG, dan PNG!", "error");
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
    function ubahpass(str,str2)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan mengganti password "+str2+"!",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    var data = new FormData();
                    data.append('id', str);
                    data.append('pass', $("#pass").val());
                    $.ajax({
                        type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        url: "<?php echo base_url('Admin/input_ubahpass_mahasiswa')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");viewdata('list');
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
    function ubahprofil(str,str2)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan mengubah profil "+str2+"!",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    var data = new FormData();
                    data.append('id', str);
                    data.append('nama', $("#nama").val());
                    data.append('agama', $("#agama").val());
                    data.append('sex', $("#sex").val());
                    data.append('tgl', $("#tgl").val());
                    data.append('bln', $("#bln").val());
                    data.append('thn', $("#thn").val());
                    data.append('email', $("#email").val());
                    data.append('no_hp', $("#no_hp").val());
                    data.append('no_wa', $("#no_wa").val());
                    data.append('alamat', $("#alamat").val());
                    data.append('gol_drh', $("#gol_drh").val());
                    data.append('angkatan', $("#angkatan").val());
                    $.ajax({
                        type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        url: "<?php echo base_url('Admin/input_ubahprofil_mahasiswa')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");viewdata('list');
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
    function arsipkan() {
        var data = new FormData();
        var arsip = document.getElementsByName("arsip[]");
        var ttl_arsip = arsip.length;
        var ttl_arsip_check = 0;
        for (var i = 0; i < ttl_arsip; i++) {
            if (arsip[i].checked){
                data.append("id_mahasiswa[]", arsip[i].value);
            } else {
                ttl_arsip_check++;
            }
        }

        if (ttl_arsip===ttl_arsip_check){
            swal("Oops...", "Silahkan berikan tanda ceklis jika ingin mengarsipkan.", "error");
            return false;
        }

        swal({
                title: "Anda Yakin?",
                text: "Anda akan mengarsipkan data!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    $.ajax({
                        type: "POST", data: data, processData: false,
                        contentType: false, url: "<?php echo base_url('Admin/daftar_mahasiswa_arsipkan')?>",
                        success: function(data) {
                            if (data==1) {
                                swal("Sukses", "", "success");
                                viewdata('list');
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
</body>
</html>
