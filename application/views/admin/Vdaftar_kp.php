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
                Daftar KP
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Daftar KP</li>
            </ol>
        </section>

        <section class="content connectedSortable">
            <div class="row">
                <div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
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
        document.getElementById('document').setAttribute("class", "active");
        document.getElementById('d_kp').setAttribute("class", "active");
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Admin/daftar_kp_data'); ?>",
            success: function(data){
                $('#viewdata').html(data);
                loading_page_end();
            },
            error:function(data)
            {$('#viewdata').html(data);swal("Oops...", "Something went wrong! Try again.", "error");}
        })
    }
    function page(str)
    {
        window.location = '<?php echo base_url('Admin/Daftar_KP/')?>'+str;
    }
    function read(str)
    {
        loading_page_end();
        var datas = "id="+str;
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
            {loading_page_end();$('#viewdata').html(data);swal("Oops...", "Something went wrong! Try again.", "error");}
        })
    }
    function hapus_kp(str)
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan menghapus data KP secara permanen!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    var data = new FormData();
                    data.append('id_kp', str);
                    $.ajax({
                        type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        url: "<?php echo base_url('Admin/hapus_kp')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");viewdata();
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
    function detail_kp(str)
    {
        window.location = "<?php echo base_url('Admin/Daftar_KP')?>"+"/"+str;
    }
    function download_srt(str)
    {
        location.href = "<?php echo base_url('Admin/download_srt_pers')?>"+"/"+str;
    }
    function arsipkan() {
        var data = new FormData();
        var arsip = document.getElementsByName("arsip[]");
        var ttl_arsip = arsip.length;
        var ttl_arsip_check = 0;
        for (var i = 0; i < ttl_arsip; i++) {
            if (arsip[i].checked){
                data.append("id_kp[]", arsip[i].value);
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
                        contentType: false, url: "<?php echo base_url('Admin/daftar_kp_arsipkan')?>",
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
