<div class="col-md-12">
    <div class="box box-brown">
        <div class="box-header">
            <h3 class="box-title">Deskripsi KP</h3>
        </div>
        <div class="box-body pad">
            <div class="form-group">
                <h5><b>Deskripsi KP</b></h5>
                <textarea class="form-control" id="isi" rows="10" cols="80" placeholder="Isi"><?php echo $isi; ?></textarea>
            </div>
            <div class="form-group">
                <h5><b>Dirubah terakhir</b> <i class="fa fa-hourglass-2 "></i></h5>
                <h5 class="form-control"><?php echo waktu_lalu2($cdate); ?></h5>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button type="button" class="btn btn-primary" onclick="simpan('<?php echo $id_deskripsi_kp;?>')" >Simpan</button>
            </div>
        </div>
    </div>
</div>