<!DOCTYPE html>
<html>
  <?php $this->load->view('style/Vhead'); ?>
  <body class="hold-transition skin-brown layout-top-nav fixed" onload="viewdata();tab('agenda_detail_mahasiswa');">
    <div class="wrapper">
      <?php $this->load->view('dosen/Vheader'); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Daftar Mahasiswa
            <small>Detail Mahasiswa KP</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('Dosen');?>"><i class="fa fa-dashboard"></i> Daftar Mahasiswa</a></li>
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
      $.ajax(
        {
          type: "GET",
          url: "<?php echo base_url('Dosen/agenda_index'); ?>"
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
          url: "<?php echo base_url('Dosen/agenda_index_data');?>",
          success:function(data)
          {
            loading_page_end();
            $('#formkp').html(data);
            if (str == 'agenda_detail_mahasiswa')
            {
              document.getElementById("agenda_data_kp").setAttribute("class", "");
              document.getElementById("agenda_kp_harian").setAttribute("class", "");
              document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
            }
            if (str == 'agenda_data_kp')
            {
              document.getElementById("agenda_detail_mahasiswa").setAttribute("class", "");
              document.getElementById("agenda_kp_harian").setAttribute("class", "");
              document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
            }
            if (str == 'agenda_kp_harian')
            {
              document.getElementById("agenda_data_kp").setAttribute("class", "");
              document.getElementById("agenda_detail_mahasiswa").setAttribute("class", "");
              document.getElementById("agenda_kp_bimbingan").setAttribute("class", "");
            }
            if (str == 'agenda_kp_bimbingan')
            {
              document.getElementById("agenda_data_kp").setAttribute("class", "");
              document.getElementById("agenda_kp_harian").setAttribute("class", "");
              document.getElementById("agenda_detail_mahasiswa").setAttribute("class", "");
            }
            document.getElementById(str).setAttribute("class", "active");
          },
          error:function(data)
          {loading_page_end();swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");}
        });
    }
    function tambah(str)
    {
      loading_page_start();
      $.ajax({
          type: "GET",
          data: {'id' : str, 'page':'input_kp_bimbingan'},
          url: "<?php echo base_url('Dosen/modal'); ?>",
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
    function simpan_kp_bimbingan(str,str2,str3)
    {
      $('#loading2').show();
      setTimeout(function()
      {
        var data = new FormData();
        data.append('ket', $("#ket").val());
        data.append('id', str);
        data.append('idkp', str2);
        data.append('idpmb', str3);
        $.ajax({
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            url: "<?php echo base_url('Dosen/input_data_kp_bimbingan')?>",
            success: function(data)
            {
              $('#loading2').hide();
              if (data==1)
              {
                success();
                $("#ket").val('');
                tab('agenda_kp_bimbingan');
              }
              else if(data==0)
              {
                error();
              }
              else{alert(data);}
            },
            error:function(data)
            {$('#loading2').hide();errorr();}
        });
      }, 3000);
    }
    function hapus_kp_bimbingan(str)
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
          $.ajax({
              type: "POST",
              data: data,
              processData: false,
              contentType: false,
              url: "<?php echo base_url('Dosen/hapus_kp_bimbingan')?>",
              success: function(data)
              {
                if (data==1)
                {
                  swal("Sukses", "", "success");tab('agenda_kp_bimbingan');
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
    function download_dt_pers(str)
    {
      location.href = "<?php echo base_url('Dosen/download_dt_pers')?>"+"/"+str;
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
    </script>
  </body>
</html>
