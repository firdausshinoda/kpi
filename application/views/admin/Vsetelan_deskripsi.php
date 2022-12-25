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
            Setelan Deskripsi KP
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Setelan</a></li>
            <li class="active">Deskripsi KP</li>
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
        document.getElementById('setelan').setAttribute("class", "active");
        document.getElementById('desk_kp').setAttribute("class", "active");
        ambil_data();
      }
      function ambil_data() {
        $.ajax(
          {
            type: "GET",
            url: "<?php echo base_url('Admin/setelan_desk_kp'); ?>"
          }
        ).done(function( data )
        {
          loading_page_end();
          $('#viewdata').html(data);
        });
      }
      function simpan(str)
      {
        swal({
          title: "Anda Yakin?",
          text: "Anda akan menyimpan data!",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
          setTimeout(function(){
            var isi = $("#isi").val();
            var data = "isi="+isi+"&id="+str;
            $.ajax({
                type: "POST",
                data: data,
                url: "<?php echo base_url('Admin/input_ubah_deskripsi')?>",
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
    </script>
  </body>
</html>
