<form>
    <style type="text/css">
        .select2-container--default .select2-selection--single {
            border: 1px solid #f39c12;
        }
        .select2-dropdown {
            border: 1px solid #f39c12;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #f39c12;
        }
    </style>
    <div class="box-body">
        <?php if ($data->num_rows() != 0): ?>
            <?php foreach ($data->result() as $a): ?>
            <div class="form-group has-warning">
                <label for="inputName" class="control-label">Nama Perusahaan</label>
                <div>
                    <input type="text" class="form-control" id="nm_pers" placeholder="Nama Perusahaan" value="<?php echo $a->nama_perusahaan;?>">
                </div>
            </div>
            <div class="form-group has-warning">
                <label for="inputName" class="control-label">Bidang Kerja</label>
                <select class="form-control select2" name="bid_kerja" id="bid_kerja" style="width: 100%;">
                    <option value="<?= $a->id_bidang_kerja; ?>" selected><?= $a->bidang_kerja; ?></option>
                    <?php foreach ($bid_kerja->result() as $bk):?>
                        <option value="<?= $bk->id_bidang_kerja; ?>"><?= $bk->bidang_kerja; ?></option>
                    <?php endforeach; ?>
                </select>
                <div style="display: none" id="div_bid_kerja_lainnya">
                    <br><input type="text" class="form-control" id="bid_kerja_lainnya" placeholder="Silahkan diisi lainnya...">
                </div>
            </div>
            <div class="form-group has-warning">
                <label for="inputName" class="control-label">Deskripsi Perusahaan</label>
                <div>
                    <textarea rows="5" class="form-control" id="desk_pers" placeholder="Deskripsi Perusahaan"><?php echo $a->deskripsi;?></textarea>
                </div>
            </div>
            <div class="form-group has-warning">
                <label for="inputName" class="control-label">Wilayah</label>
                <select class="form-control select2" name="wilayah" id="wilayah" style="width: 100%;">
                    <option value="<?= $a->id_wilayah; ?>" selected><?= $a->wilayah; ?></option>
                    <?php foreach ($wilayah->result() as $wil):?>
                        <option value="<?= $wil->id_wilayah; ?>"><?= $wil->wilayah; ?></option>
                    <?php endforeach; ?>
                </select>
                <div style="display: none" id="div_wilayah_lainnya">
                    <br><input type="text" class="form-control" id="wilayah_lainnya" placeholder="Silahkan diisi lainnya...">
                </div>
            </div>
            <div class="form-group has-warning">
                <label for="inputName" class="control-label">Alamat</label>
                <div>
                    <textarea class="form-control" id="almt_pers" placeholder="Alamat Perusahaan" rows="5"><?php echo $a->alamat;?></textarea>
                </div>
            </div>
            <div class="form-group has-warning">
                <label for="inputName" class="control-label">Status Data</label>
                <div>
                    <?php if ($a->stt == 1):?>
                        <input type="text" disabled class="form-control" value="Sudah Dikonfirmasi Admin">
                    <?php else: ?>
                        <input type="text" disabled class="form-control" value="Belum Dikonfirmasi Admin">
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <button type="button" id="btn_simpan_dt_pers" class="btn btn-primary" onclick="simpan_dt_pers('<?php echo $a->id_kp;?>')">Simpan</button>
            </div>
            <div class="form-group has-warning">
                <label for="inputName" class="control-label">Surat Diterima KP Oleh Perusahaan</label>
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-4">
                            <input id="doc_pers" type="file" name="file" class="btn btn-default"/>
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="btn_dokumen_pers" onclick="dokumen_pers('<?php echo $a->id_kp?>','<?php echo $a->nama_file?>')" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group has-warning">
                <div class="attachment-block clearfix">
                    <div class="attachment-text">
                        Silahkan unggah file dokumen bertipe PDF maupun DOC/DOCX.
                    </div>
                </div>
            </div>
        <?php if (!empty($a->nama_file)): ?>
            <div class="form-group col-md-12">
                <ul class="mailbox-attachments clearfix">
                    <li>
                        <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                        <div class="mailbox-attachment-info">
                            <a class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?php echo substrfile($a->nama_file);?> </a>
                            <span class="mailbox-attachment-size">
                                <?php echo formatBytes($a->size);?>
                                <a href="javascript:void()" onclick="download_dt_pers('<?php echo $a->nama_file;?>')" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                              </span>
                        </div>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <?php if ($a->stt == 1):?>
            <script type="text/javascript">
                $("#nm_pers").attr('disabled', true);
                $("#bid_kerja").attr('disabled', true);
                $("#desk_pers").attr('disabled', true);
                $("#wilayah").attr('disabled', true);
                $("#almt_pers").attr('disabled', true);
                $("#btn_simpan_dt_pers").attr('disabled', true);
                $("#doc_pers").attr('disabled', true);
                $("#btn_dokumen_pers").attr('disabled', true);
            </script>
        <?php endif;?>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="callout callout-danger">
                <h4>Data perusahaan masih kosong</h4>
                <p>Silahkan masukan ID KP dan menunggu sampai admin mengkonfirmasi ID KP.</p>
            </div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".select2").select2();
        });

        $('#bid_kerja').change(function(){
            if ($(this).find("option:selected").attr('value') === "1"){ $("#div_bid_kerja_lainnya").show(); }
            else { $("#div_bid_kerja_lainnya").hide(); }
        });
        $('#wilayah').change(function(){
            if ($(this).find("option:selected").attr('value') === "1"){ $("#div_wilayah_lainnya").show(); }
            else { $("#div_wilayah_lainnya").hide(); }
        });

        var bid_kerja = {};
        $("select[name='bid_kerja'] > option").each(function () {
            if(bid_kerja[this.text]) { $(this).remove(); }
            else { bid_kerja[this.text] = this.value; }
        });
        var wilayah = {};
        $("select[name='wilayah'] > option").each(function () {
            if(wilayah[this.text]) { $(this).remove(); }
            else { wilayah[this.text] = this.value; }
        });
    </script>
</form>