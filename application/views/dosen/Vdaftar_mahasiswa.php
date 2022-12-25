<!DOCTYPE html>

<html>

  <?php $this->load->view('style/Vhead'); ?>

  <body class="hold-transition skin-brown layout-top-nav fixed" onload="viewdata();">

    <div class="wrapper">

      <?php $this->load->view('dosen/Vheader'); ?>

      <div class="content-wrapper">

        <section class="content-header">

          <h1>

            Daftar Mahasiswa

            <small>Kerja Praktik</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="<?php echo base_url('Dosen');?>"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class="active">Daftar Mahasiswa</li>

          </ol>

        </section>

        <section class="content connectedSortable">

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

      $.ajax(

        {

          type: "GET",

          url: "<?php echo base_url('Dosen/daftar_dosen_membimbing'); ?>"

        }

      ).done(function( data )

      {

        loading_page_end();

        $('#viewdata').html(data);

      });

    }

    function read(str)

    {

      window.location = "<?php echo base_url('Dosen/Daftar_Mahasiswa')?>"+"/"+str;

    }

    </script>

  </body>

</html>

