<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown sidebar-mini fixed">
<div class="wrapper">
    <?php $this->load->view('admin/Vheader') ?>
    <?php $this->load->view('admin/Vsidebar-menu') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Arsip Mahasiswa
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Arsip Mahasiswa</li>
            </ol>
        </section>

        <section class="content connectedSortable">
            <div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-brown">
                        <div class="box-header">
                            <h3 class="box-title">Pilihan Data</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <h5><b>Tahun</b></h5>
                                        <select class="form-control" id="tahun" name="tahun">
                                            <option value="semua">Semua</option>
                                            <?php foreach ($tahun as $it_thn):?>
                                                <option value="<?= $it_thn->tahun;?>"><?= $it_thn->tahun;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <h5><b>Aksi</b></h5>
                                        <button type="button" onclick="cari()" class="btn btn-primary btn-block">Cari</button>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <button type="button" onclick="download_arsip('Excel')" class="btn btn-info btn-block"><i class="fa fa-print"></i> Excel</button>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <button type="button" onclick="download_arsip('PDF')" class="btn btn-info btn-block" style="margin-right: 5px"><i class="fa fa-print"></i> PDF</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box box-brown">
                        <div class="box-header">
                            <h3 class="box-title">Arsip Mahasiswa</h3>
                            <button type="button" class="btn btn-warning pull-right" style="margin-right: 5px" onclick="check_all()"><i class="fa fa-check"></i> Cek Semua</button>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <table id="example2" class="table table-bordered table-striped" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th style="width:5%;"></th>
                                        <th style="width:5%;">No</th>
                                        <th style="width:10%;">Foto</th>
                                        <th style="width:20%;">Nama Mahasiswa</th>
                                        <th style="width:20%;">Alamat</th>
                                        <th style="width:10%;">Email</th>
                                        <th style="width:10%;">Angkatan</th>
                                        <th style="width:10%;">Tanggal</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <code>*Ketika menandai tidak boleh perpindah ke halaman selanjutnya.</code><br>
                            <button type="button" onclick="execute_tandai('restore')" class="btn btn-warning pull-right">Kembalikan Yang Ditandai</button>
                            <button type="button" onclick="execute_tandai('delete')" class="btn btn-danger pull-right" style="margin-right: 1%">Hapus Yang Ditandai</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php $this->load->view('style/Vfooter'); ?>
</div>

<?php $this->load->view('style/Vjs'); ?>
<script type="text/javascript">
    document.getElementById('arsip').setAttribute("class", "active");
    document.getElementById('d_arsip_mahasiswa').setAttribute("class", "active");

    $(function () {
        var dt_table = $("#example2").DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "deferRender": true,
            "responsive": true,
            "pagingType": "simple_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
            "paging": true,
            "ajax": {
                "url": '<?= base_url('Admin/arsip_mahasiswa_json');?>',
                "type": "POST",
                "data": function (d) {
                    loading_page_start();
                    d.tahun = $('#tahun').val();
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
                { "render": function ( data, type, row )
                    {
                        return '<center><input type="checkbox" name="tandai[]" value="'+row.id_mahasiswa+'/'+row.nama_mahasiswa+'"></center>';
                    }
                },
                { "data": null,"sortable": false,"className": 'text-center',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { "render": function ( data, type, row )
                    {
                        return '<img style="width:100%;"src="'+row.foto_mahasiswa+'" class="profile-user-img img-responsive img-circle" alt="Mahasiswa Image">';
                    }
                },
                { "render": function ( data, type, row )
                    {
                        return '<a href="javascript:void();" onclick="detail(\''+row.id_mahasiswa+'\');">'+row.nama_mahasiswa+'</a>';
                    }
                },
                {"data": "alamat"},
                {"data": "email"},
                {"data": "angkatan"},
                {"data": "cdate"},
            ],
            "language" : {
                "url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
            },
        });
    });

    function detail(str)
    {
        loading_page_start();
        $.ajax({
            type: "GET",
            data: {'id' : str, 'page':'detailmhs'},
            url: "<?php echo base_url('Admin/modal'); ?>",
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
    function cari() {
        $('#example2').DataTable().ajax.reload();
    }
    function download_arsip(type) {
        window.open("<?= base_url('Admin/arsip_mahasiswa_cetak?type=')?>"+type+"&tahun="+$('#tahun').val(), '_blank');
    }
    function check_all() {
        var arsipkan = document.getElementsByName("tandai[]");
        var jml=arsipkan.length;
        var b=0;
        for (b=0;b<jml;b++) {
            if (arsipkan[b].checked){
                arsipkan[b].checked = false;
            } else {
                arsipkan[b].checked = true;
            }
        }
    }
    function execute_tandai(str) {
        var data = new FormData();
        var tandai = document.getElementsByName("tandai[]");
        var ttl_tandai = tandai.length;
        var ttl_tandai_check = 0;
        for (var i = 0; i < ttl_tandai; i++) {
            if (tandai[i].checked){
                data.append("data_mahasiswa[]", tandai[i].value);
            } else {
                ttl_tandai_check++;
            }
        }

        var pesan='';
        if (str==="restore"){
            pesan = "mengembalikan";
        } else {
            pesan = "menghapus";
        }
        data.append("type", str);

        if (ttl_tandai===ttl_tandai_check){
            swal("Oops...", "Silahkan berikan tanda ceklis jika ingin "+pesan+" data.", "error");
            return false;
        }

        swal({
                title: "Anda Yakin?",
                text: "Anda akan "+pesan+" data!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    $.ajax({
                        type: "POST", data: data, processData: false,
                        contentType: false, url: "<?php echo base_url('Admin/arsip_mahasiswa_proses')?>",
                        success: function(data) {
                            if (data==1) {
                                swal("Sukses", "", "success");
                                cari();
                            } else if (data==0) {
                                swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");
                            }
                            else{alert(data);}
                        },
                        error:function(data)
                        {swal("Oops...", "Terjadi kesalahan!!! Coba lagi.", "error");}
                    });
                }, 2000);
            });
    }
</script>
</body>
</html>
