<html>
<?php if ($message->num_rows() >= "1"): ?>
    <script type="text/javascript">
        $("#gear").show();
    </script>
<?php endif; ?>
<?php foreach ($message->result() as $chat): ?>
    <?php if ($chat->send_by == "mahasiswa"): ?>
        <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-right"><?php echo $chat->nama_mahasiswa; ?></span>
                <span class="direct-chat-timestamp pull-left"><?php echo waktu_lalu2($chat->cdate); ?></span>
            </div>
            <?php if (empty($chat->foto_mahasiswa)):?>
                <img src="<?php echo base_url('assets/document/img/style/profile.jpg');?>" class="direct-chat-img" alt="message user image">
            <?php else: ?>
                <img src="<?php echo base_url('assets/document/img/mahasiswa/'.$chat->foto_mahasiswa);?>" class="direct-chat-img" alt="message user image">
            <?php endif; ?>
            <div class="direct-chat-text">
                <?php echo $chat->isi; ?>
                <?php if (!empty($chat->nama_file)): ?>
                    <span class="mailbox-attachment-icon" style="width:40%;">
                    <?php $file = substr(strrchr($chat->nama_file,'.'),1); ?>
                    <?php if ($file == "jpg" || $file == "jpeg" || $file == "png" || $file == "JPG" || $file == "JPEG" || $file == "PNG"): ?>
                        <span class="mailbox-attachment-icon has-img"><img src="<?php echo base_url('assets/document/file/bimbingan_online/'.$chat->nama_file);?>" alt="Img"></span>
                    <?php endif; ?>
                    <?php if ($file == "pdf"): ?>
                        <span class="mailbox-attachment-icon" style="width:5%;"><i class="fa fa-file-pdf-o" style="width:100%;"></i></span>
                    <?php endif; ?>
                    <?php if ($file == "doc" || $file == "docx"): ?>
                        <span class="mailbox-attachment-icon" style="width:5%;"><i class="fa fa-file-word-o" style="width:100%;"></i></span>
                    <?php endif; ?>
                    <?php if ($file == "zip" || $file == "rar"): ?>
                        <span class="mailbox-attachment-icon" style="width:5%;"><i class="fa fa-file-archive-o" style="width:100%;"></i></span>
                    <?php endif; ?>
                    </span><?php echo substrfile($chat->nama_file)." - ".formatBytes($chat->size)."  ";?>
                    <a href="javascript:avoid()" title="Unduh" onclick="download_dk_chat('<?php echo $chat->nama_file;?>');"><i class="fa fa-download"></i></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($chat->send_by == "dosen"): ?>
        <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left"><?php echo $chat->nama_dosen; ?></span>
                <span class="direct-chat-timestamp pull-right"><?php echo waktu_lalu2($chat->cdate); ?></span>
            </div>
            <?php if (empty($chat->foto_dosen)):?>
                <img src="<?php echo base_url('assets/document/img/style/profile.jpg');?>" class="direct-chat-img" alt="message user image">
            <?php else: ?>
                <img src="<?php echo base_url('assets/document/img/dosen/'.$chat->foto_dosen);?>" class="direct-chat-img" alt="message user image">
            <?php endif; ?>
            <div class="direct-chat-text">
                <?php echo $chat->isi; ?>
                <?php if (!empty($chat->nama_file)): ?>
                    <span class="mailbox-attachment-icon" style="width:40%;">
                    <?php $file = substr(strrchr($chat->nama_file,'.'),1); ?>
                    <?php if ($file == "jpg" || $file == "jpeg" || $file == "png" || $file == "JPG" || $file == "JPEG" || $file == "PNG"): ?>
                        <span class="mailbox-attachment-icon has-img"><img style="width:100%;" src="<?php echo base_url('assets/document/file/bimbingan_online/'.$chat->nama_file);?>" alt="Img"></span>
                    <?php endif; ?>
                    <?php if ($file == "pdf"): ?>
                        <span class="mailbox-attachment-icon" style="width:5%;"><i class="fa fa-file-pdf-o" style="width:100%;"></i></span>
                    <?php endif; ?>
                    <?php if ($file == "doc" || $file == "docx"): ?>
                        <span class="mailbox-attachment-icon" style="width:5%;"><i class="fa fa-file-word-o" style="width:100%;"></i></span>
                    <?php endif; ?>
                    <?php if ($file == "zip" || $file == "rar"): ?>
                        <span class="mailbox-attachment-icon" style="width:5%;"><i class="fa fa-file-archive-o" style="width:100%;"></i></span>
                    <?php endif; ?>
                    </span><?php echo substrfile($chat->nama_file)." - ".formatBytes($chat->size)."  ";?>
                    <a href="javascript:avoid()" title="Unduh" onclick="download_dk_chat('<?php echo $chat->nama_file;?>');"><i class="fa fa-download"></i></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
<script type="text/javascript">
    document.getElementById("ttl").innerHTML = "<?php echo $message->num_rows();?>";
    var stt = "<?php echo $chat->stt_login_dosen;?>";
    var wkt = "<?php echo waktu_lalu2($chat->ldate_dosen);?>";
    if (stt === "1")
    {
        document.getElementById("stt").innerHTML = "<label data-skin='skin-green' class='btn-success btn-xs'><i class='fa fa-eye'></i></label> Active ";
    }
    else
    {
        document.getElementById("stt").innerHTML = "<a href='javascript:avoid();' data-skin='skin-red' class='btn btn-danger btn-xs'><i class='fa fa-eye'></i></a> Active "+wkt;
    }
</script>
</html>
