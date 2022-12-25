<html>
<div class="box box-brown">
  <div class="box-header">
    <h3 class="box-title">Sampul Sliding</h3>
    <button class="pull-right btn btn-default" onclick="tambah()"> Tambah <i class="fa fa-arrow-circle-right"></i></button>
  </div>
  <div class="box-body">
    <div class="row">
      <?php foreach ($data->result() as $a): ?>
        <div class="col-lg-3 col-xs-6">
          <div class="kotak">
            <a href="javascript:void()" class="pull-right fa fa-close" onclick="hapus('<?php echo $a->id_dashboard_img;?>','<?php echo $a->img;?>')" title="Hapus"></a>
            <img src="<?php echo base_url('assets/document/img/sampul_sliding/'.$a->img);?>" class="thumb-gallery" style="height:150px;">
            <p class="text-gallery"><?php echo substrgaleri($a->img); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
</html>
