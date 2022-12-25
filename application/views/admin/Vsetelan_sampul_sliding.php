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
            Setelan <small>Sampul Sliding</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench"></i> Setelan</a></li>
            <li class="active">Sampul Sliding</li>
          </ol>
        </section>

        <section class="content connectedSortable">
          <div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
          <div class="row">
            <div class="col-md-12">
              <div id="viewdata"></div>
            </div>
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
        document.getElementById('setelan').setAttribute("class", "active");
        document.getElementById('samp_slid').setAttribute("class", "active");
        ambil_data();
      }
      function ambil_data() {
        $.ajax(
          {
            type: "GET",
            url: "<?php echo base_url('Admin/setelan_sampul_slide'); ?>"
          }
        ).done(function( data )
        {
          loading_page_end();
          $('#viewdata').html(data);
        });
      }
      function tambah()
      {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'page':'smpl_slide'},
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
      function hapus(str,str2)
      {
        swal({
          title: "Anda Yakin?",
          text: "Anda akan menghapus data!",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
          setTimeout(function(){
            var data = new FormData();
            data.append('id', str);
            data.append('img', str2);
            $.ajax({
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                url: "<?php echo base_url('Admin/hapus_sampul_sliding')?>",
                success: function(data)
                {
                  if (data==1)
                  {
                    swal("Sukses", "", "success");ambil_data();
                  }
                  else if(data==0)
                  {
                    swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");;
                  }
                  else{alert(data);}
                },
                error:function(data)
                {swal("Oops...", "Terjadi kesalahan!!! Coba lagi.", "error");}
            });
          }, 2000);
        });
      }
      function simpan()
      {
        $('#loading2').show();
        setTimeout(function(){
          var data = new FormData();
          data.append('img', $("#foto")[0].files[0]);
          $.ajax({
              type: "POST",
              processData: false,
              contentType: false,
              data: data,
              url: "<?php echo base_url('Admin/input_sampul_sliding')?>",
              success: function(data)
              {
                $('#loading2').hide();
                if (data==1)
                {
                  $('#uploadPreviewsp1').attr('src', "<?php echo base_url('assets/document/img/style/gallery.png')?>");
                  success();ambil_data();
                }
                else if(data==2)
                {
                  fileerror();
                }
                else if(data==0)
                {
                  error();
                }
                else{alert(data);}
              },
              error:function(data)
              {errorr();}
          });
        }, 2000);
      }
      function success()
      {
        $("#succes").fadeIn("slow");
        setTimeout(
          function()
          {
            $("#succes").fadeOut("slow");
          },2000);
      }

      function error()
      {
        $("#error").fadeIn("slow");
        setTimeout(
          function()
          {
            $("#error").fadeOut("slow");
          },2000);
      }
      function errorr()
      {
        $("#errorr").fadeIn("slow");
        setTimeout(
          function()
          {
            $("#errorr").fadeOut("slow");
          },2000);
      }
      function fileerror()
      {
        $("#fileerror").fadeIn("slow");
        setTimeout(
          function()
          {
            $("#fileerror").fadeOut("slow");
          },2000);
      }
    </script>
  </body>
</html>
