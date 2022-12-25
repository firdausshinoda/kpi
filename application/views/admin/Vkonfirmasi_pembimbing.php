<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<script>var auto_refresh = setInterval("ambil_data()",10000);</script>
<body class="hold-transition skin-brown sidebar-mini fixed" onload="viewdata();">
<div class="wrapper">
    <?php $this->load->view('admin/Vheader') ?>
    <?php $this->load->view('admin/Vsidebar-menu') ?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Konfirmasi</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Konfirmasi Pembimbing</li>
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
    function viewdata() {
        loading_page_start();
        document.getElementById('konfirmasi').setAttribute("class", "active");
        document.getElementById('pembimbing').setAttribute("class", "active");
        ambil_data();
    }
    function ambil_data() {
        $.ajax({
                type: "GET",
                url: "<?php echo base_url('Admin/konfirmasi_pembimbing_data'); ?>"
            }).done(function( data ) {
            loading_page_end();
            $('#viewdata').html(data);
        });
    }
    function pembimbing(str,str2) {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str,'nm':str2,'page':'tmbhpmb'},
            url: "<?php echo base_url('Admin/modal'); ?>",
            success: function(data) {
                loading_page_end();
                $("#Modal").html(data);
                $("#Modal").modal('show',{backdrop: 'true'});
            },
            error:function(data)
            {loading_page_end();swal("Oops...", "Terjadi kesalahan! Coba lagi!.", "error");}
        });
    }
    function detail_kp(str) {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str,'page':'detailmhs'},
            url: "<?php echo base_url('Admin/modal'); ?>",
            success: function(data) {
                loading_page_end();
                $("#Modal").html(data);
                $("#Modal").modal('show',{backdrop: 'true'});
            },
            error:function(data)
            {loading_page_end();swal("Oops...", "Terjadi kesalahan! Coba lagi!.", "error");}
        });
    }
    function simpan(str) {
        $('#loading2').show();
        setTimeout(function() {
            var pilih = [];
            var i = 0;
            $(".pilih").each(function(index, element) {
                if($(element).val()!=="") {
                    pilih.push({pilih:$(element).val(),})
                    i++;
                }
            });
            $.ajax({
                type: "POST",
                data: {'id':str,'pilih':pilih},
                url: "<?php echo base_url('Admin/input_konfirmasi_pembimbing'); ?>",
                success: function(data) {
                    $('#loading2').hide();
                    if (data==1) {
                        success();ambil_data();
                    } else if (data==0) {
                        error();
                    } else {
                        alert(data);
                    }
                },
                error:function(data) {
                    $('#loading2').hide();
                    errorr();
                }
            });
        }, 3000);
    }
    function download_lap_kp(str) {
        location.href = "<?php echo base_url('Admin/download_lap_kp')?>"+"/"+str;
    }

    function success() {
        $("#succes").fadeIn("slow");
        setTimeout(function() {
                $("#succes").fadeOut("slow");
            },2000);
    }

    function error() {
        $("#error").fadeIn("slow");
        setTimeout(function() {
                $("#error").fadeOut("slow");
            },2000);
    }
    function errorr() {
        $("#errorr").fadeIn("slow");
        setTimeout(function() {
                $("#errorr").fadeOut("slow");
            },2000);
    }
</script>
</body>
</html>

