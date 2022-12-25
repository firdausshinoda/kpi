<!DOCTYPE html>
<html>
  <?php $this->load->view('style/Vhead'); ?>
  <body class="hold-transition skin-brown sidebar-mini fixed" onload="viewdata();table('<?php echo $tabel;?>');">
    <div class="wrapper">
      <?php $this->load->view('admin/Vheader') ?>
      <?php $this->load->view('admin/Vsidebar-menu') ?>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Dashboard
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
      document.getElementById('dashboard').setAttribute("class", "active");
      $.ajax(
        {
          type: "GET",
          url: "<?php echo base_url('Admin/dashboard_tabel_kp'); ?>"
        }
      ).done(function( data )
      {
        $('#viewdata').html(data);
      });
    }
    function table(str)
    {
      loading_page_start();
      $.ajax(
        {
          type: "GET",
          url: "<?php echo base_url('Admin/');?>"+"/"+str
        }
      ).done(function( data )
      {
        loading_page_end();
        $('#formtable').html(data);
        if (str == 'dashboard_table_mhs')
        {
          document.getElementById("dashboard_table_lap").setAttribute("class", "");
        }
        if (str == 'dashboard_table_lap')
        {
          document.getElementById("dashboard_table_mhs").setAttribute("class", "");
        }
        document.getElementById(str).setAttribute("class", "active");
      });
    }
    function dtl_mhs(str)
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
    function dtl_dsn(str)
    {
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
    </script>
  </body>
</html>
