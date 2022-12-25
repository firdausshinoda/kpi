<!DOCTYPE html>

<html>

  <?php $this->load->view('style/Vhead'); ?>

  <script>

    var kd = "<?php echo $segment; ?>";

    var auto_refresh = setInterval("chat(kd)",3000);

  </script>

  <body class="hold-transition skin-brown layout-top-nav fixed" onload="viewdata('<?php echo $segment; ?>');">

    <div class="wrapper">

      <?php $this->load->view('mahasiswa/Vheader'); ?>

      <div class="content-wrapper">

        <div id="loading" class="modal col-md-12">

          <div class="modal-content" style="padding:25px;">

            <img src="<?php echo base_url('assets/document/img/style/ring-alt.gif');?>" style="height:100%;"><br>

            Please waiting. . .

          </div>

        </div>

        <section class="content-header">

          <h1>

            Bimbingan Online

            <small>Kerja Praktik</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="<?php echo base_url('Mahasiswa');?>"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class="active">Bimbingan Online</li>

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

    $(document).ready(function(){

      var con = document.getElementById("box_chat");

      con.scrollTop = con.scrollHeight;

    })

    function viewdata(str)

    {

      loading_page_start();

      var datas = "id="+str;

      $.ajax(

        {

          type: "POST",

          data: datas,

          url: "<?php echo base_url('Mahasiswa/bimbingan_online_chat'); ?>"

        }

      ).done(function( data )

      {

        loading_page_end();

        $('#viewdata').html(data);

        chat(str);

      });

    }

    function chat(str)

    {

      var datas = "id="+str;

      $.ajax(

        {

          type: "POST",

          data: datas,

          url: "<?php echo base_url('Mahasiswa/bimbingan_online_chat_index'); ?>"

        }

      ).done(function( data )

      {

        $('#data_chat').html(data);

      });

    }

    function kirim(str,str2)

    {

      var url = "<?php echo base_url('Mahasiswa/input_chat'); ?>";

      var data = new FormData();

      data.append('file', $("#file")[0].files[0]);

      data.append('isi',$("#isi").val());

      data.append('nim',str);

      data.append('iddsn',str2);

  		$('.progress').show();

  		$.ajax({

  			xhr : function() {

  				var xhr = new window.XMLHttpRequest();

  				xhr.upload.addEventListener('progress', function(e){

  					if(e.lengthComputable){

  						console.log('Bytes Loaded : ' + e.loaded);

  						console.log('Total Size : ' + e.total);

  						console.log('Persen : ' + (e.loaded / e.total));



  						var percent = Math.round((e.loaded / e.total) * 100);



  						$('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');

  					}

  				});

  				return xhr;

  			},

  			type : "POST",

  			url : url,

  			data : data,

  			processData : false,

  			contentType : false,

  			success : function(data){

  				$('.progress').hide();

  				if(data == 0)

          {

  					swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");

  				}

          if(data == 2)

          {

  					swal("Oops...", "File terlalu besar, harus dibawah 5 Mb. File harus bertipe PDF, DOC, dan DOCX. Foto harus bertipe JPG & PNG !", "error");

  				}

          if(data == 1)

          {

  					$("#isi").val('');

            $("#preview_file").hide();

            $("#file").val('');

            chat(str2);

  				}

          else {

            alert(data);

          }

  			}

  		});

    }

    function clear_chat(str)

    {

      $("#loading").fadeIn("slow");

      $.ajax({

  			type : "POST",

  			url : "<?php echo base_url('Mahasiswa/clear_chat');?>",

  			data : {'iddsn':str},

  			success : function(data){

  				$("#loading").fadeOut("slow");

  				if(data == 0)

          {

  					swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");

  				}

          if(data == 1)

          {

  					viewdata(kd);

  				}

          else {

            alert(data);

          }

  			}

  		});

    }

    function cls()

    {

      $("#preview_file").hide();

      $("#file").val('');

    }

    function download_dk_chat(str)

    {

      location.href = "<?php echo base_url('Mahasiswa/download_dk_chat')?>"+"/"+str;

    }

    </script>

  </body>

</html>

