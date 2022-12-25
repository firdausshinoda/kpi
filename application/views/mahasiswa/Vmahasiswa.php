<!DOCTYPE html>

<html>

  <?php $this->load->view('style/Vhead'); ?>

  <script type="text/javascript">

    setInterval("ambildata()",50000);

  </script>

  <body class="hold-transition skin-brown layout-top-nav fixed" onload="viewdata();">

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

    var page = 1;

    var track_page = 1;

    var total_post;

    var loading  = false;

    var stt_post = 5;

    $(window).scroll(function() {

      if($(window).scrollTop() + $(window).height() >= $(document).height()) {

          track_page++;

          if (stt_post < total_post) {

            stt_post=stt_post+5;

            if(loading == false){

                loading = true;

                $('#loading-info').fadeIn('slow');

                post(page);

            }

          }

      }

    });



    function viewdata()

    {

      loading_page_start();

      ambildata();

    }

    function ambildata()

    {

      $.ajax(

        {

          type: "GET",

          url: "<?php echo base_url('Mahasiswa/dashboard'); ?>"

        }

      ).done(function( data )

      {

        $('#viewdata').html(data);

        post(page);

      });

    }

    function post(page)

    {

      $.ajax(

        {

          type: "GET",

          data: {page:page},

          url: "<?php echo base_url('Mahasiswa/dashboard_data_post'); ?>"

        }

      ).done(function( data )

      {

        loading = false;

        $('#loading-info').fadeOut('slow');

        loading_page_end();

        tmbh();

        $('#post').html(data);

      });

    }

    function tmbh() {

      page=page+1;

    }

    function tabel(str)

    {

      var datas = "tabel="+str;

      $.ajax(

        {

          data: datas,

          type: "POST",

          url: "<?php echo base_url('Mahasiswa/daftar_mahasiswa_dan_laporan_kptb'); ?>"

        }).done(function( data )

        {

          window.location = "<?php echo base_url('Mahasiswa/Daftar_Mahasiswa_Dan_Laporan_KP');?>"

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

          {

            loading_page_end();swal("Oops...", "Terjadi kesalahan! Coba lagi!.", "error");}

      });

    }
    function detail_img(str) {
      loading_page_start();
      $.ajax(
        {
          type: "GET",
          data: {'id' : str, 'page':'detail_img'},
          url: "<?php echo base_url('Mahasiswa/modal'); ?>",
          success: function(data){
            loading_page_end();
            $("#Modal").html(data);
            $("#Modal").modal('show',{backdrop: 'true'});
          },
          error:function(data)
          {loading_page_end();swal("Oops...", "Terjadi kesalahan!!! Coba lagi.", "error");}
        });
    }

    function download_dashboard(str)

    {

      location.href = "<?php echo base_url('Mahasiswa/download_dashboard')?>"+"/"+str;

    }

    </script>

  </body>

</html>

