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
                Sistem <small>Mahasiswa Terhapus</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-archive"></i> Sistem</a></li>
                <li class="active">Mahasiswa Terhapus</li>
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
        loading_page_start();
        document.getElementById('sistem').setAttribute("class", "active");
        document.getElementById('s_mahasiswa').setAttribute("class", "active");
        ambil_data();
    }
    function ambil_data() {
        $.ajax(
            {
                type: "GET",
                url: "<?php echo base_url('Admin/sistem_mahasiswa_data'); ?>"
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
</script>
</body>
</html>
