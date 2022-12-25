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
                Sistem <small>Catatan Aktivitas</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-archive"></i> Sistem</a></li>
                <li class="active">Catatan Aktivitas</li>
            </ol>
        </section>

        <section class="content connectedSortable">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-brown">
                        <div class="box-header">
                            <h3 class="box-title">Daftar Catatan Aktivitas</h3>
                        </div>
                        <div class="box-body pad">
                            <div class="form-group">
                                <table id="example2" class="table table-bordered table-striped" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th style="width:5%;">No</th>
                                        <th style="width:30%;">ID</th>
                                        <th>Aktivitas</th>
                                        <th style="width:20%;">Tanggal</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="button" onclick="reset()" class="btn btn-danger col-md-12">Hapus Semua</button>
                            </div>
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
    $(function () {
        document.getElementById('sistem').setAttribute("class", "active");
        document.getElementById('s_log').setAttribute("class", "active");
        var dt_table = $("#example2").DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "pagingType": "simple_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language" : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
            "paging": true,
            "ajax": {
                "url": '<?= base_url('Admin/catatan_aktivitas_data');?>',
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
                        if(value.length >= 3 || e.keyCode === 13) {
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
                {"data": "id"},
                {"data": "ket"},
                {"data": "cdate"},
            ],
        });
    });
    function reset()
    {
        swal({
                title: "Anda Yakin?",
                text: "Anda akan menghapus semua data catata aktivitas!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                setTimeout(function(){
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url('Admin/hapus_catatan_aktivitas')?>",
                        success: function(data)
                        {
                            if (data==1)
                            {
                                swal("Sukses", "", "success");
                                $('#example2').DataTable().ajax.reload();
                            }
                            else if(data==0)
                            {
                                swal("Oops...", "Terjadi kesalahan! Coba lagi.", "error");;
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
