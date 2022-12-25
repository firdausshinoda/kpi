<!DOCTYPE html>

<html>

  <?php $this->load->view('style/Vhead'); ?>

  <body class="hold-transition lockscreen">

    <div class="lockscreen-wrapper">

      <div class="lockscreen-logo">

        <a href="<?php echo base_url();?>"><b>Kerja</b>Praktik</a>

      </div>

      <div id="loading" class="modal col-md-12">

        <div class="modal-content" style="padding:25px;">

          <img src="<?php echo base_url('assets/document/img/style/ring-alt.gif');?>" style="height:100%;"><br>

          Please waiting. . .

        </div>

      </div>

      <div class="lockscreen-name">Sign In</div>

      <div class="lockscreen-item">

        <div class="lockscreen-image">

          <img src="<?php echo base_url('assets/document/img/style/avatar5.png');?>" alt="User Image">

        </div>

        <form class="lockscreen-credentials">

          <div class="input-group">

            <input type="text" id="us" class="form-control" placeholder="Username">

            <input type="password" id="pass" class="form-control" placeholder="Password">

            <div class="input-group-btn">

              <button class="btn" type="button" onclick="login()"><i class="fa fa-arrow-right text-muted"></i></button>

            </div>

          </div>

        </form>

      </div>

      <div class="help-block text-center">

        Silahkan sign in terlebih dahulu untuk masuk.

      </div>

      <div class="text-center">

        <a href="javascrip:avoid();">Politeknik Harapan Bersama</a>

      </div>

      <div class="lockscreen-footer text-center">

        Copyright &copy; 2016-2017 <b><a href="<?php echo base_url();?>" class="text-black">Kerja Praktik D4 Teknik Informatika</a></b><br>

        All rights reserved

      </div>

    </div>

    <?php $this->load->view('style/Vjs'); ?>

    <script type="text/javascript">
    $('#us').on("keydown",function(e){
      if (e.keyCode === 13) {
        login();
      }
    });
    $('#pass').on("keydown",function(e){
      if (e.keyCode === 13) {
        login();
      }
    });

    function login()

    {

      tunggu();

      setTimeout(function()

      {

        var us = $('#us').val();

        var pass = $('#pass').val();

        var datas="us="+us+"&pass="+pass;

        $.ajax({

            type: "POST",

            url: "<?php echo base_url('Sistem/login'); ?>",

            data: datas,

            success: function(data)

            {

              if (data==0)

              {

                selesai();

                swal("Oops...", "Try again with username and password valid!", "error");

              }

              else {window.location = data;}

            },

            error:function(data)

            {

              selesai();

              swal("Oops...", "Something went wrong! Try again.", "error");$('#loading').hide();

            }

        });

      }, 3000);

    }



    function tunggu()

    {

      $("#loading").fadeIn("slow");

    }

    function selesai()

    {

      $("#loading").fadeOut("slow");

    }

    </script>

  </body>

</html>

