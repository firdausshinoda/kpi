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
                Daftar Pembimbing
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Daftar Pembimbing</li>
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
        document.getElementById('document').setAttribute("class", "active");
        document.getElementById('d_pembimbing').setAttribute("class", "active");
        $.ajax({
                type: "GET",
                url: "<?php echo base_url('Admin/daftar_pembimbing_dosen'); ?>"
            }).done(function( data ) {
                loading_page_end();
                $('#viewdata').html(data);
        });
    }
    function dtl_mhs(str) {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detailmhs'},
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
    function dtl_dsn(str) {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detaildsn'},
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
    function detail(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detailkp'},
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
    function download_srt(str) {
        location.href = "<?php echo base_url('Admin/download_srt_pers')?>"+"/"+str;
    }
    function arsipkan() {
        var data = new FormData();
        var arsip = document.getElementsByName("arsip[]");
        var ttl_arsip = arsip.length;
        var ttl_arsip_check = 0;
        for (var i = 0; i < ttl_arsip; i++) {
            if (arsip[i].checked){
                data.append("id_pembimbing[]", arsip[i].value);
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
                        contentType: false, url: "<?php echo base_url('Admin/daftar_pembimbing_arsipkan')?>",
                        success: function(data)
                        {
                            if (data==1) {
                                swal("Sukses", "", "success");
                                viewdata();
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
