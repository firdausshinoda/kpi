<html>
<div class="col-md-12">
  <div class="box box-brown-chat box-solid direct-chat direct-chat-info">
    <div class="box-header">
      <h3 class="box-title"><p id="stt"></p></h3>
      <div class="box-tools pull-right">
        <span data-toggle="tooltip" title="Total pesan" class="badge bg-aqua" data-original-title="Pesan"><p id="ttl"></p></span>
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        <button id="gear" class="btn btn-box-tool" data-toggle="dropdown" style="display:none"><i class="fa fa-gear"></i></button>
        <ul class="dropdown-menu pull-right" role="menu">
          <li><a href="javascript:avoid();" onclick="clear_chat('<?php echo $nim;?>');"><i class="fa fa-trash"></i>Bersihkan isi chat</a></li>
        </ul>
      </div>
    </div>
    <div class="box-body">
      <div class="direct-chat-messages" id="box_chat">
        <div id="data_chat"></div>
      </div>
    </div>
    <div class="box-footer">
      <form method="post">
        <div>
          <div class="form-group">
            <div style="border: 1px solid #553b1a;">
              <textarea style="border:none;overlow:hidden;" placeholder="Tulis Pesan ..." class="form-control" id="isi" rows="3"></textarea>
              <div style="display:none;" id="preview_file">
                <ul class="mailbox-attachments clearfix" style="margin-left:1%;">
                  <li>
                    <a href='javascript:avoid()' title="Hapus" onclick="cls();" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                    <div id="tp"></div>
                    <div class="mailbox-attachment-info">
                      <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i><p id="name_file"></p></a>
                      <span class="mailbox-attachment-size"><p id="size_file"></p>
                      </span>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="progress progress-striped active" style="display:none;margin-left:2%;margin-right:2%;">
      					<div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
      						<span class="sr-only">0%</span>
      					</div>
      				</div>
            </div>
            <div class="margin pull-right">
              <div class="btn-group">
                <div class="btn btn-default">
                  <div class="fileUpload">
                      <input class="upload" title="Silahkan upload max 1 file." type="file" id="file" onchange="preview_file(event);" multiple><i class="fa fa-paperclip"></i></input>
                  </div>
                </div>
              </div>
              <div class="btn-group">
                <button type="button" value="Kirim" class="btn btn-primary" onclick="kirim('<?php echo $nim;?>','<?php echo $iddsn;?>')">Kirim</button>
              </div>
            </div>
            <script type="text/javascript">
            var preview_file = function(event)
            {
              $("#preview_file").show();
              var input = event.target;
              var input2 = document.getElementById("file").files[0];
              var reader = new FileReader();
              reader.onload = function(){
                var dataUrl = reader.result;
                var src = document.getElementById("name_file").innerHTML = input2.name;
                var nBytes = input2.size;
                var sOutput = nBytes + " bytes";
                for (var aMultiples = ["K", "M", "G", "T", "P", "E", "Z", "Y"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
                  sOutput = nApprox.toFixed(3) +" "+ aMultiples[nMultiple];
                }
                document.getElementById("size_file").innerHTML = sOutput;
                var nama_file = input2.name;
                var tipe = nama_file.split('.').pop();
                if (tipe === "pdf")
                {
                  if (nBytes >= "5000000")
                  {file_besar();}
                  else
                  {
                    document.getElementById("tp").innerHTML = "<span class='mailbox-attachment-icon'><i class='fa fa-file-pdf-o'></i></span>";
                  }
                }
                else if (tipe === "doc" || tipe === "docx")
                {
                  if (nBytes >= "5000000")
                  {file_besar();}
                  else
                  {
                    document.getElementById("tp").innerHTML = "<span class='mailbox-attachment-icon'><i class='fa fa-file-word-o'></i></span>";
                  }
                }
                else if (tipe === "zip" || tipe === "rar")
                {
                  if (nBytes >= "5000000")
                  {file_besar();}
                  else {
                    document.getElementById("tp").innerHTML = "<span class='mailbox-attachment-icon'><i class='fa fa-file-archive-o'></i></span>";
                  }
                }
                else if (tipe === "png" || tipe === "jpeg" || tipe === "jpg"  || tipe === "JPEG" || tipe === "JPG")
                {
                  if (nBytes >= "5000000")
                  {file_besar();}
                  else
                  {
                    document.getElementById("tp").innerHTML = "<span class='mailbox-attachment-icon has-img'><img src='"+dataUrl+"' alt='Attachment'></span>";
                  }
                }
                else {
                  swal("Oops...", "File harus bertipe PDF, DOC, DOCX, JPG, PNG, RAR, & ZIP ukuran file harus dibawah 5 Mb", "error");
                  $("#preview_file").hide();
                  $("#file").val('');
                }
              }
              reader.readAsDataURL(input.files[0]);
            }
            function file_besar()
            {
              swal("Oops...", "Ukuran file terlalu besar, harus dibawah 5 Mb", "error");
              $("#preview_file").hide();
              $("#file").val('');
            }
            </script>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</html>
