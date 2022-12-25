<!DOCTYPE html>

<html>

  <?php $this->load->view('style/Vhead'); ?>

  <script type="text/javascript">

    setInterval("ambildata()",50000);

  </script>

  <body class="hold-transition skin-brown sidebar-mini fixed" onload="viewdata();">

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

        document.getElementById('dashboard').setAttribute("class", "active");

        ambildata();

      }

      function ambildata()

      {

        $.ajax(

          {

            type: "GET",

            url: "<?php echo base_url('Admin/dashboard_data'); ?>"

          }

        ).done(function( data )

        {

          loading_page_end();

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

            url: "<?php echo base_url('Admin/dashboard_data_post'); ?>"

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

      function hapus()

      {

        $("#file_file").val('');

        viewdata();

        post();

      }

      function tabel(str)

      {

        var datas = "tabel="+str;

        $.ajax(

          {

            data: datas,

            type: "POST",

            url: "<?php echo base_url('Admin/daftar_mahasiswa_dan_laporan_kptb'); ?>"

          }).done(function( data )

          {

            window.location = "<?php echo base_url('Admin/Daftar_Mahasiswa_Dan_Laporan_KP');?>"

          });

      }

      function simpan()

      {

        swal({

          title: "Anda Yakin?",

          text: "Anda akan membagikan postingan!",

          type: "info",

          showCancelButton: true,

          closeOnConfirm: false,

          showLoaderOnConfirm: true,

        },

        function(){

          setTimeout(function(){

            var data = new FormData();

            var ins = document.getElementById('file_file').files.length;

            for (var x = 0; x < ins; x++)

            {data.append("userFiles[]", document.getElementById('file_file').files[x]);}

            data.append('isi', $("#isi").val());

            $.ajax({

              type: "POST",

              data: data,

              processData: false,

              contentType: false,

              url: "<?php echo base_url('Admin/input_dashboard'); ?>",

              success: function(data)

              {

                if (data==1)

                {

                  swal("Sukses", "", "success");viewdata();post();

                }

                else if(data==2)

                {

                  swal("Oops...", "File terlalu besar, harus dibawah 1 Mb & harus bertipe JPG, JPEG, dan PNG!", "error");

                }

                else if(data==0)

                {

                  swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");

                }

                else {

                  alert(data);

                }

              },

              error:function(data)

              {swal("Oops...", "Terjadi kesalahan!!! Coba lagi.", "error");}

            });

          }, 2000);

        });

      }

      function delpost(str)

      {

        swal({

          title: "Anda Yakin?",

          text: "Anda akan menghapus file post!",

          type: "warning",

          showCancelButton: true,

          closeOnConfirm: false,

          showLoaderOnConfirm: true,

        },

        function(){

          setTimeout(function(){

            var data = new FormData();

            data.append('id', str);

            $.ajax({

              type: "POST",

              data: data,

              processData: false,

              contentType: false,

              url: "<?php echo base_url('Admin/hapus_dashboard_files'); ?>",

              success: function(data)

              {

                if (data==1)

                {

                  swal("Sukses", "", "success");viewdata();post();

                }

                else if(data==0)

                {

                  swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");

                }

                else {

                  alert(data);

                }

              },

              error:function(data)

              {swal("Oops...", "Terjadi kesalahan!!! Coba lagi.", "error");}

            });

          }, 2000);

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
      function detail_img(str) {
        loading_page_start();
        $.ajax(
          {
            type: "GET",
            data: {'id' : str, 'page':'detail_img'},
            url: "<?php echo base_url('Admin/modal'); ?>",
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

        location.href = "<?php echo base_url('Admin/download_dashboard')?>"+"/"+str;

      }

    </script>

  </body>

</html>

