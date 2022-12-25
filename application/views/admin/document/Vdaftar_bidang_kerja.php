<?php if ($page=="list"):?>
    <div class="col-md-12">
        <div class="box box-brown">
            <div class="box-header">
                <h3 class="box-title">Daftar Bidang Kerja</h3>
                <button type="button" class="btn btn-default pull-right" onclick="viewdata('new')">Tambah</button>
            </div>
            <div class="box-body pad">
                <div class="form-group">
                    <table id="example2" class="table table-bordered table-striped" style="width: 100%">
                        <thead>
                        <tr>
                            <th style="width:10%;">No</th>
                            <th>Bidang Kerja</th>
                            <th>Tanggal</th>
                            <th style="width:20%;">Pilihan</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function () {
        var dt_table = $("#example2").DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "pagingType": "simple_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
            "paging": true,
            "ajax": {
                "url": '<?= base_url('Admin/daftar_bidang_kerja_json');?>',
                "type": "POST",
                "data": function (d) {
                    loading_page_start();

                },
                "dataFilter": function(response){
                    loading_page_end();
                    return response
                },
            },
            initComplete: function() {
                var $searchInput = $('div.dataTables_filter input');
                var dataTableFilterTimeout;
                var dataTableFilterWait = 2000;
                $searchInput.unbind();
                $searchInput.bind('keyup', function(e) {
                    var value = this.value;
                    window.clearTimeout(dataTableFilterTimeout);
                    dataTableFilterTimeout = setTimeout(function(){
                        if(value.length >= 2 || e.keyCode === 13) {
                            dt_table.search(value).draw();
                        }
                        if(value === "") {
                            dt_table.search("").draw();
                        }
                    },dataTableFilterWait);
                });
            },
            "columns": [
                { "data": null,"sortable": false,"className": 'text-center',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {"data": "bidang_kerja"},
                {"data": "cdate"},
                { "render": function ( data, type, row )
                    {
                        return '<button type="button" onclick="viewdata(\'edit\',\''+row.id_bidang_kerja+'\')" class="btn btn-info col-md-12">Ubah</button>' +
                            '<button type="button" onclick="hapus(\''+row.id_bidang_kerja+'\',\''+row.bidang_kerja+'\')" class="btn btn-danger col-md-12">Hapus</button>'
                    }
                },
            ],
            "language" : {
                "url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
            },
        });
    });
</script>
<?php elseif ($page=="edit"):?>
    <div class="col-md-12">
        <div class="box box-brown">
            <div class="box-header">
                <h3 class="box-title">Data Bidang Kerja</h3>
            </div>
            <div class="box-body pad">
                <div class="form-group">
                    <h5><b>Wilayah</b></h5>
                    <input type="text" class="form-control" id="bidang_kerja" placeholder="Bidang Kerja" value="<?= $data->bidang_kerja; ?>"/>
                </div>
                <div class="form-group">
                    <h5><b>Dirubah terakhir</b> <i class="fa fa-hourglass-2 "></i></h5>
                    <h5 class="form-control">
                        <?php if (!empty($data->mdate)):?>
                            <?= waktu_lalu2($data->mdate); ?>
                        <?php endif;?>
                    </h5>
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" onclick="ubah('<?= $data->id_bidang_kerja;?>')" >Simpan</button>
                </div>
            </div>
        </div>
    </div>
<?php elseif ($page=="new"):?>
    <div class="col-md-12">
        <div class="box box-brown">
            <div class="box-header">
                <h3 class="box-title">Tambah Bidang Kerja</h3>
            </div>
            <div class="box-body pad">
                <div class="form-group">
                    <h5><b>Bidang Kerja</b></h5>
                    <input type="text" class="form-control" id="bidang_kerja" placeholder="Bidang Kerja"/>
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" onclick="simpan()" >Simpan</button>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
