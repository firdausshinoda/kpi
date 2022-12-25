<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown layout-top-nav fixed" onload="viewdata();tab('agenda_form');">
<div class="wrapper">
    <?php $this->load->view('mahasiswa/Vheader'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard
                <small>Kerja Praktik</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Mahasiswa');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
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
    function viewdata()
    {
        $.ajax(
            {
                type: "GET",
                url: "<?php echo base_url('Mahasiswa/agenda_index'); ?>"
            }
        ).done(function( data )
        {
            $('#viewdata').html(data);
        });
    }
    function tab(str)
    {
        loading_page_start();
        var url = "<?php echo base_url('Mahasiswa/') ?>";
        $.ajax(
            {
                type: "GET",
                url: url+"/"+str,
                success:function(data)
                {
                    loading_page_end();
                    $('#formkp').html(data);
                    if (str == 'agenda_form')
                    {
                        document.getElementById("agenda_data_perusahaan").setAttribute("class", "");;
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                    }
                    if (str == 'agenda_data_perusahaan')
                    {
                        document.getElementById("agenda_form").setAttribute("class", "");;
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                    }
                    if (str == 'agenda_pembimbing')
                    {
                        document.getElementById("agenda_form").setAttribute("class", "");;
                        document.getElementById("agenda_data_perusahaan").setAttribute("class", "");
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                    }
                    if (str == 'agenda_data_kp')
                    {
                        document.getElementById("agenda_form").setAttribute("class", "");;
                        document.getElementById("agenda_data_perusahaan").setAttribute("class", "");
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                    }
                    if (str == 'agenda_kp_harian')
                    {
                        document.getElementById("agenda_form").setAttribute("class", "");;
                        document.getElementById("agenda_data_perusahaan").setAttribute("class", "");
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                    }
                    if (str == 'agenda_kp_bimbingan')
                    {
                        document.getElementById("agenda_form").setAttribute("class", "");;
                        document.getElementById("agenda_data_perusahaan").setAttribute("class", "");
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                    }
                    document.getElementById(str).setAttribute("class", "active");
                },
                error:function(data)
                {loading_page_end();swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");}
            });
    }
    function generate()
    {
        loading_page_start();
        $.ajax(
            {
                type: "GET",
                url: "<?php echo base_url('Mahasiswa/id_kp_generate'); ?>"
            }
        ).done(function( data )
        {
            loading_page_end();$('#idkpgenerate').html(data);
        });
    }

    function baru_id()
    {
        var idkp = $("#idkp").val();
        if (idkp == "") {
            swal("Oops...", "Silahkan masukan ID KP terlebih dahulu.", "error");
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
                        var idkp = $("#idkp").val();
                        $.ajax({
                            type: "POST",
                            data: {'idkp':idkp},
                            url: "<?php echo base_url('Mahasiswa/input_baru_idkp')?>",
                            success: function(data)
                            {
                                if (data==1) {
                                    swal("Sukses", "", "success");viewdata();tab('agenda_form');
                                } else if(data==0) {
                                    swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");
                                } else if(data==2) {
                                    swal("Oops...", "ID KP sudah terdaftar.", "error");
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
    function join_id()
    {
        var idkp = $("#idkp").val();
        if (idkp == "") {
            swal("Oops...", "Silahkan masukan ID KP terlebih dahulu.", "error");
        } else {
            swal({
                    title: "Anda Yakin?",
                    text: "Anda akan bergabung dengan ID KP tersebut!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                        $.ajax({
                            type: "POST",
                            data: {'idkp':idkp},
                            url: "<?php echo base_url('Mahasiswa/input_join_idkp')?>",
                            success: function(data)
                            {
                                if (data==1) {
                                    swal("Sukses", "", "success");viewdata();tab('agenda_form');
                                } else if(data==0) {
                                    swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");
                                } else if(data==2) {
                                    swal("Oops...", "NIM anda sudah terdaftar!!!.", "error");
                                } else if (data==3){
                                    swal("Oops...", "ID KP tidak terdaftar", "error");
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
    function keluar_id()
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan keluar dari ID KP tersebut!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    var idkp = $("#idkp").val();
                    $.ajax({
                        type: "POST",
                        data: {'idkp':idkp},
                        url: "<?php echo base_url('Mahasiswa/input_keluar_idkp')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");viewdata();tab('agenda_form');
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
    function keluarkan_id(str,str2)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan mengeluarkan anggota dari ID KP tersebut!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    $.ajax({
                        type: "POST",
                        data: {'nim':str,'idkp':str2},
                        url: "<?php echo base_url('Mahasiswa/input_keluarkan_idkp')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");viewdata();tab('agenda_form');
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
    function tambah_id(str)
    {
        var nim = $("#nim").val();
        if (nim == "") {
            swal("Oops...", "Silahkan masukan NIM terlebih dahulu.", "error");
        } else {
            swal({
                    title: "Anda Yakin?",
                    text: "Anda akan menambah anggota!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                        $.ajax({
                            type: "POST",
                            data: {'nim':nim, 'idkp' : str},
                            url: "<?php echo base_url('Mahasiswa/input_tambah_idkp')?>",
                            success: function(data)
                            {
                                if (data==1){
                                    swal("Sukses", "", "success");viewdata();tab('agenda_form');
                                } else if(data==0) {
                                    swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");
                                } else if(data==2) {
                                    swal("Oops...", "NIM mahasiswa tidak terdaftar!!", "error");
                                }  else if(data==3) {
                                    swal("Oops...", "NIM mahasiswa sudah terdaftar!!", "error");
                                } else{alert(data);}                },
                            error:function(data)
                            {swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");}
                        });
                    }, 2000);
                });
        }
    }
    function hapus_id(str)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan menghapus ID KP!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    $.ajax({
                        type: "POST",
                        data: {'idkp' : str},
                        url: "<?php echo base_url('Mahasiswa/input_hapus_idkp')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");viewdata();tab('agenda_form');
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
                            url: "<?php echo base_url('Mahasiswa/input_dt_pers')?>",
                            success: function(data)
                            {
                                if (data==1)
                                {
                                    swal("Sukses", "", "success");viewdata();tab('agenda_data_perusahaan');
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
                            url: "<?php echo base_url('Mahasiswa/input_dokumen_pers')?>",
                            success: function(data)
                            {
                                if (data==1)
                                {
                                    swal("Sukses", "", "success");tab('agenda_data_perusahaan');
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
    function dtl_mhs(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detailmhs'},
            url: "<?php echo base_url('Mahasiswa/modal'); ?>",
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
    function dtl_dsn(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detaildsn'},
            url: "<?php echo base_url('Mahasiswa/modal'); ?>",
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
    function tambah(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'input_kp_harian'},
            url: "<?php echo base_url('Mahasiswa/modal'); ?>",
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
    function simpan_kp_harian(str,str2,str3)
    {
        var ket = $("#ket").val();
        if (ket == "") {
            kosong();
        } else {
            $('#loading2').show();
            setTimeout(function()
            {
                var data = new FormData();
                data.append('ket', ket);
                data.append('id', str);
                data.append('idkp', str2);
                data.append('idpmb', str3);
                $.ajax({
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    url: "<?php echo base_url('Mahasiswa/input_data_kp_harian')?>",
                    success: function(data)
                    {
                        $('#loading2').hide();
                        if (data==1)
                        {
                            success();
                            $("#ket").val('');
                            tab('agenda_kp_harian');
                        }
                        else if(data==0)
                        {
                            error();
                        }
                        else{alert(data);}
                    },
                    error:function(data)
                    {$('#loading2').hide();errorr();}
                });
            }, 3000);
        }
    }
    function hapus_kp_harian(str)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan menghapus data!",
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
                        url: "<?php echo base_url('Mahasiswa/hapus_kp_harian')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");tab('agenda_kp_harian');
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
    function dtl_dsn(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detaildsn'},
            url: "<?php echo base_url('Mahasiswa/modal'); ?>",
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
    function upload_lap_kp(str,str2)
    {
        var judul = $("#judul").val();
        if (judul == "") {
            swal("Oops...", "Silahkan isi terlebih dahulu.", "error");
        } else {
            swal({
                    title: "Anda Yakin?",
                    text: "Anda akan menyinpan data!",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                        var data = new FormData();
                        data.append('judul', judul);
                        data.append('idkp',str);
                        data.append('id_lap',str2);
                        $.ajax({
                            type: "POST",
                            data: data,
                            processData: false,
                            contentType: false,
                            url: "<?php echo base_url('Mahasiswa/input_dokumen_lap_kp')?>",
                            success: function(data)
                            {
                                if (data==1)
                                {
                                    swal("Sukses", "", "success");tab('agenda_data_kp');
                                }
                                else if(data==2)
                                {
                                    swal("Oops...", "File terlalu besar, harus dibawah 5 Mb & harus bertipe PDF, DOC, dan DOCX!", "error");
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
        location.href = "<?php echo base_url('Mahasiswa/download_dt_pers')?>"+"/"+str;
    }
    function download_sikp()
    {
        window.open("<?php echo base_url('Mahasiswa/download_sikp')?>");
    }
    function success()
    {
        $("#succes").fadeIn("slow");
        setTimeout(
            function()
            {
                $("#succes").fadeOut("slow");
            },2000);
    }

    function error()
    {
        $("#error").fadeIn("slow");
        setTimeout(
            function()
            {
                $("#error").fadeOut("slow");
            },2000);
    }
    function errorr()
    {
        $("#errorr").fadeIn("slow");
        setTimeout(
            function()
            {
                $("#errorr").fadeOut("slow");
            },2000);
    }
</script>
</body>
</html>
