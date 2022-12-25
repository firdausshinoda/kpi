<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown sidebar-mini fixed" onload="viewdata();">
<div class="wrapper">
    <?php $this->load->view('admin/Vheader') ?>
    <?php $this->load->view('admin/Vsidebar-menu') ?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Konfirmasi
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Konfirmasi KP</li>
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
    setInterval("ambil_data()",30000);
    function viewdata()
    {
        loading_page_start();
        document.getElementById('konfirmasi').setAttribute("class", "active");
        document.getElementById('kp').setAttribute("class", "active");
        ambil_data();
    }
    function ambil_data() {
        $.ajax(
            {
                type: "GET",
                url: "<?php echo base_url('Admin/konfirmasi_daftar_kp'); ?>"
            }
        ).done(function( data )
        {
            loading_page_end();
            $('#viewdata').html(data);
        });
    }

    function detail(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detailkp'},
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

    function download_srt(str)
    {
        location.href = "<?php echo base_url('Admin/download_srt_pers')?>"+"/"+str;
    }

    function hapus_idkp(str)
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
                        url: "<?php echo base_url('Admin/input_hapus_idkp')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");ambil_data();
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

    function konfirm_idkp(str)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan mengkonfirmasi ID KP!",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    $.ajax({
                        type: "POST",
                        data: {'idkp' : str},
                        url: "<?php echo base_url('Admin/input_konfirm_idkp')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");ambil_data();
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
</script>
</body>
</html>

