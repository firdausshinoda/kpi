<!DOCTYPE html>

<html>

  <?php $this->load->view('style/Vhead'); ?>

  <body class="hold-transition skin-brown layout-top-nav fixed" onload="viewdata();table('<?php echo $tabel;?>');">

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

          url: "<?php echo base_url('Mahasiswa/dashboard_tabel_kp'); ?>"

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

          url: "<?php echo base_url('Mahasiswa/');?>"+"/"+str

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

    </script>

  </body>

</html>

