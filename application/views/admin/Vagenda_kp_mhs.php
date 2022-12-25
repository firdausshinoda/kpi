<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown sidebar-mini fixed"  onload="viewdata();tab('agenda_detail_mahasiswa');">
<div class="wrapper">
    <?php $this->load->view('admin/Vheader'); ?>
    <?php $this->load->view('admin/Vsidebar-menu') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                KP
                <small>Detail Mahasiswa KP</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Daftar KP</a></li>
                <li class="active">Detail Mahasiswa KP</li>
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
        document.getElementById('document').setAttribute("class", "active");
        document.getElementById('d_kp').setAttribute("class", "active");
        $.ajax(
            {
                type: "GET",
                url: "<?php echo base_url('Admin/agenda_kp_mhs_index'); ?>"
            }
        ).done(function( data )
        {
            $('#viewdata').html(data);
        });
    }
    function tab(str)
    {
        loading_page_start();
        var segment = "<?php echo $segment;?>";
        $.ajax(
            {
                type: "GET",
                data: {'nim':segment,'page':str},
                url: "<?php echo base_url('Admin/agenda_kp_mhs_index_data');?>",
                success:function(data)
                {
                    loading_page_end();
                    $('#formkp').html(data);
                    if (str == 'agenda_detail_mahasiswa')
                    {
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                    }
                    if (str == 'agenda_data_kp')
                    {
                        document.getElementById("agenda_detail_mahasiswa").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                    }
                    if (str == 'agenda_kp_harian')
                    {
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_detail_mahasiswa").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                    }
                    if (str == 'agenda_kp_bimbingan')
                    {
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                        document.getElementById("agenda_detail_mahasiswa").setAttribute("class", "");
                        document.getElementById("agenda_pembimbing").setAttribute("class", "");
                    }
                    if (str == 'agenda_pembimbing')
                    {
                        document.getElementById("agenda_data_kp").setAttribute("class", "");
                        document.getElementById("agenda_kp_harian").setAttribute("class", "");
                        document.getElementById("agenda_detail_mahasiswa").setAttribute("class", "");
                        document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
                    }
                    document.getElementById(str).setAttribute("class", "active");
                },
                error:function(data)
                {loading_page_end();swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");}
            });
    }
    function download_dt_pers(str)
    {
        location.href = "<?php echo base_url('Admin/download_srt_pers')?>"+"/"+str;
    }
    function dtl_dsn(str)
    {
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detaildsn'},
            url: "<?php echo base_url('Admin/modal'); ?>",
            success: function(data)
            {
                //alert(data);
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
