<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown layout-top-nav fixed" onload="viewdata();">
<div class="wrapper">
    <?php $this->load->view('mahasiswa/Vheader'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Profil
                <small>Kerja Praktik</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Mahasiswa');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Profil</li>
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
    function viewdata()
    {
        loading_page_start();
        $.ajax(
            {
                type: "GET",
                url: "<?php echo base_url('Mahasiswa/profil_mhs'); ?>"
            }
        ).done(function( data )
        {
            loading_page_end();
            $('#viewdata').html(data);
        });
    }
    function ubah_img(str,str2)
    {
        var img = $("#img")[0].files[0];
        if (img == null) {
            swal("Oops...", "Silahkan pilih foto terlebih dahulu.", "error");;
        } else {
            swal({
                    title: "Anda Yakin?",
                    text: "Anda akan mengubah foto anda!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                        var data = new FormData();
                        data.append('img', img);
                        data.append('id', str);
                        data.append('img2', str2);
                        $.ajax({
                            type: "POST",
                            data: data,
                            processData: false,
                            contentType: false,
                            url: "<?php echo base_url('Mahasiswa/input_ubah_img')?>",
                            success: function(data)
                            {
                                if (data==1)
                                {
                                    window.location.reload();swal("Sukses", "", "success");
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
    function ubah_biodata(str)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan mengubah biodata anda!",
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
                    data.append('no_hp', $("#no_hp").val());
                    data.append('no_wa', $("#no_wa").val());
                    data.append('sex', $("#sex").val());
                    data.append('tgl', $("#tgl").val());
                    data.append('bln', $("#bln").val());
                    data.append('thn', $("#thn").val());
                    data.append('email', $("#email").val());
                    data.append('alamat', $("#alamat").val());
                    data.append('gol_drh', $("#gol_drh").val());
                    $.ajax({
                        type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        url: "<?php echo base_url('Mahasiswa/input_ubah_biodata')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                btn('2');
                                swal("Sukses", "", "success");viewdata();
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
    function ubah_pass(str)
    {
        var passlama = $("#passlama").val();
        var passbaru = $("#passbaru").val();
        if (passlama == "" || passbaru == "") {
            swal("Oops...", "Silahkan isi terlebih dahulu.", "error");
        } else {
            swal({
                    title: "Anda Yakin?",
                    text: "Anda akan mengubah password anda!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                        var data = new FormData();
                        data.append('id', str);
                        data.append('passl', passlama);
                        data.append('passb', passbaru);
                        $.ajax({
                            type: "POST",
                            data: data,
                            processData: false,
                            contentType: false,
                            url: "<?php echo base_url('Mahasiswa/input_ubah_pass')?>",
                            success: function(data)
                            {
                                if (data==1)
                                {
                                    swal("Sukses", "", "success");viewdata();
                                }
                                if (data==2)
                                {
                                    swal("Oops..", "Password lama anda salah!", "error");
                                }
                                else if(data==0)
                                {
                                    swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");;
                                }
                            },
                            error:function(data)
                            {swal("Oops...", "Terjadi kesalahan!!! Coba lagi.", "error");}
                        });
                    }, 2000);
                });
        }
    }
    function btn(str) {
        loading_page_start();
        if (str == 1) {
            loading_page_end();
            $('#ubah').fadeOut("slow");
            document.getElementById("nama").disabled = false;
            document.getElementById("agama").disabled = false;
            document.getElementById("no_hp").disabled = false;
            document.getElementById("no_wa").disabled = false;
            document.getElementById("sex").disabled = false;
            document.getElementById("tgl").disabled = false;
            document.getElementById("bln").disabled = false;
            document.getElementById("thn").disabled = false;
            document.getElementById("email").disabled = false;
            document.getElementById("alamat").disabled = false;
            document.getElementById("gol_drh").disabled = false;
            $('#simpan').fadeIn("slow");
            $('#batal').fadeIn("slow");
        }
        if (str == 2) {
            loading_page_end();
            $('#simpan').fadeOut("slow");
            $('#batal').fadeOut("slow");
            document.getElementById("nama").disabled = true;
            document.getElementById("agama").disabled = true;
            document.getElementById("no_hp").disabled = true;
            document.getElementById("no_wa").disabled = true;
            document.getElementById("sex").disabled = true;
            document.getElementById("tgl").disabled = true;
            document.getElementById("bln").disabled = true;
            document.getElementById("thn").disabled = true;
            document.getElementById("email").disabled = true;
            document.getElementById("alamat").disabled = true;
            document.getElementById("gol_drh").disabled = true;
            $('#ubah').fadeIn("slow");
        }
    }
</script>
</body>
</html>
