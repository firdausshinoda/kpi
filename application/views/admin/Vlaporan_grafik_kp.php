<!DOCTYPE html>
<html>
<?php $this->load->view('style/Vhead'); ?>
<body class="hold-transition skin-brown sidebar-mini fixed" onload="viewdata('list');">
<div class="wrapper">
    <?php $this->load->view('admin/Vheader') ?>
    <?php $this->load->view('admin/Vsidebar-menu') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Laporan Grafik KP
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('Admin');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Laporan Grafik KP</li>
            </ol>
        </section>

        <section class="content connectedSortable">
            <div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-brown">
                        <div class="box-header with-border">
                            <h3 class="box-title">Laporan Grafik KP</h3>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="box box-brown">
                        <div class="box-header with-border">
                            <h3 class="box-title">Grafik Berdasarkan Wilayah</h3>
                        </div>
                        <div class="box-body">
                            <div class="card-content">
                                <div id="chartdiv" style="width: 100%;height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="box box-brown">
                        <div class="box-header with-border">
                            <h3 class="box-title">Grafik Berdasarkan Bidang Kerja</h3>
                        </div>
                        <div class="box-body">
                            <div class="card-content">
                                <div id="chartdiv2" style="width: 100%;height: 500px;"></div>
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
    document.getElementById('laporan').setAttribute("class", "active");
    document.getElementById('d_laporan_grafik').setAttribute("class", "active");
    $(document).ready(function(){
       cari();
    });

    function cari() {
        var tahun = $('#tahun').val();
        loading_page_start();
        $.ajax({
            type: "GET",
            data: { tahun : tahun},
            url: "<?= base_url('Admin/laporan_grafik_kp_data'); ?>",
            success: function(data)
            {
                loading_page_end();
                setGrafikWilayah(data.grafik_wilayah);
                setGrafikBidang(data.grafik_bidang);
            },
            error:function(data){
                loading_page_end();
                swal("Oops...", "Terjadi kesalahan! Coba lagi!.", "error");
            }
        });
    }

    function setGrafikWilayah(data) {
        AmCharts.makeChart( "chartdiv", {
            "type": "pie",
            "theme": "none",
            "titles": [ {
                "text": "Grafik Berdasarkan Wilayah",
                "size": 16
            } ],
            "dataProvider": data,
            "valueField": "jumlah",
            "titleField": "wilayah",
            "startEffect": "elastic",
            "startDuration": 2,
            "labelRadius": 15,
            "innerRadius": "50%",
            "depth3D": 20,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 15,
            "export": {
                "enabled": true
            }
        } );
    }

    function setGrafikBidang(data) {
        AmCharts.makeChart( "chartdiv2", {
            "type": "pie",
            "theme": "none",
            "titles": [ {
                "text": "Grafik Berdasarkan Bidang Kerja",
                "size": 16
            } ],
            "dataProvider": data,
            "valueField": "jumlah",
            "titleField": "bidang_kerja",
            "startEffect": "elastic",
            "startDuration": 2,
            "labelRadius": 15,
            "innerRadius": "50%",
            "depth3D": 20,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 15,
            "export": {
                "enabled": true
            }
        } );
    }
</script>
</body>
</html>
