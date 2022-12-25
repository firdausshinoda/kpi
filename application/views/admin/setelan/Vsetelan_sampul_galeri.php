<html>
<div class="box box-brown">
  <div class="box-header">
    <h3 class="box-title">Sampul Galeri</h3>
    <button class="pull-right btn btn-default" onclick="tambah()"> Tambah <i class="fa fa-arrow-circle-right"></i></button>
  </div>
  <div class="box-body">
    <div class="row">
      <?php foreach ($data->result() as $a): ?>
        <div class="col-lg-3 col-xs-6">
          <div class="kotak">
            <a href="javascript:void()" class="pull-right fa fa-close" onclick="hapus('<?php echo $a->id_galeri;?>','<?php echo $a->img;?>')" title="Hapus"></a>
            <img src="<?php echo base_url('assets/document/img/gallery/'.$a->img);?>" class="thumb-gallery" style="height:150px;">
            <p class="text-gallery" title="<?php echo $a->nama; ?>"><?php echo substrgaleri($a->nama); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
</html>
