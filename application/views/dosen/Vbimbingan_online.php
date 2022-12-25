<!DOCTYPE html>
<html>
  <?php $this->load->view('style/Vhead'); ?>
  <script type="text/javascript">
    var auto_refresh = setInterval("ambil_data()",5000);
  </script>
  <body class="hold-transition skin-brown layout-top-nav fixed" onload="viewdata();">
    <div class="wrapper">
      <?php $this->load->view('dosen/Vheader'); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Bimbingan Online
            <small>Kerja Praktik</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Bimbingan Online</li>
          </ol>
        </section>
        <section class="content connectedSortable">
          <div class="popup modal col-md-12">
            <div id="komentar"></div>
          </div>
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
      ambil_data();
    }
    function ambil_data(){
      $.ajax(
        {
          type: "GET",
          url: "<?php echo base_url('Dosen/bimbingan_online_index'); ?>"
        }
      ).done(function( data )
      {
        loading_page_end();
        $('#viewdata').html(data);
      });
    }
    function read(str)
    {
      window.location = "<?php echo base_url('Dosen/Bimbingan_Online/')?>"+"/"+str;
    }
    </script>
  </body>
</html>
