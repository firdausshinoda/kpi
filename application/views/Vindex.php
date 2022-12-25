<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Informasi Kerja Praktik Industri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/superslides.css'); ?>">
    <link href="<?php echo base_url('assets/css/slick.css'); ?>" rel="stylesheet">
    <link rel='stylesheet prefetch' href='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/css/jquery.circliful.css'>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/queryLoader.css'); ?>" type="text/css" />
    <link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url('assets/css/jquery.tosrus.all.css'); ?>" />
    <link id="switcher" href="<?php echo base_url('assets/css/themes/default-theme.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/style.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/tambahan/sweetalert.css'); ?>">
    <script src="<?php echo base_url('assets/tambahan/sweetalert.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/timeline.css'); ?>">
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Varela' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/loading.css'); ?>">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/img/favicon.ico">
</head>
<body>
<a class="scrollToTop" href="#"></a>
<header id="header">
    <div class="menu_area">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background:#553b1a;">  <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" style="margin-top:0.3%;padding-top:5px;width:80%;" href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/document/img/style/logo_header_2.png');?>" alt="logo"></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
                        <li><a data-toggle="modal" href="javascript:void()" data-target="#sign" class="pull-right">SIGN IN</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<section id="slider">
    <div class="row">
        <div class="popup modal col-md-12">
            <div id="popup"></div>
        </div>
        <div id="loading" class="loading modal col-md-12">
            <div class="modal-content load" style="padding:25px;">
                <img src="<?php echo base_url('assets/document/img/style/ring-alt.gif');?>" style="height:100%;"><br>
                Please waiting. . .
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="slider_area">
                <div id="slides" class="wow fadeInDown">
                    <ul class="slides-container">
                        <?php foreach ($dashimg->result() as $data): ?>
                            <li>
                                <img src="<?php echo base_url('assets/document/img/sampul_sliding/'.$data->img);?>" alt="img">
                                <div class="slider_caption">
                                    <h2>KERJA PRAKTIK</h2>
                                    <p>D4 Teknik Informatika</p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <nav class="slides-navigation">
                        <a href="#" class="next"></a>
                        <a href="#" class="prev"></a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="aboutUs"><!-- style="background:#fff;"-->
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="aboutus_area wow fadeInLeft">
                <div class="title_area">
                    <h2 class="title_two">KERJA PRAKTIK</h2>
                    <span></span>
                </div>
                <p>
                    <?php echo $deskripsi_kp; ?>
                </p>
            </div>
        </div>
    </div>
</section>

<section id="timeLine"><!-- style="background:#82b1ff;">
    <!--section id="aboutUs" style="background:url('assets/document/img/style/h_bg.png');"-->
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="title_area wow rotateInDownRight">
                <h2 class="title_two" style="color: white">ALUR KERJA PRAKTIK</h2>
                <span style="background: white !important;"></span>
            </div>
            <div class="aboutus_area wow rollIn">
                <div>
                    <ul class="timeline">
                        <li>
                            <div class="timeline-badge">
                                <a><i class="fa fa-circle" id=""></i></a>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Mengajukan Kerja Praktik</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Mahasiswa menanyakan ke tempat Kerja Praktik apakah siap untuk menerima mahasiswa KP.</p>
                                </div>
                                <div class="timeline-footer">
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-badge">
                                <a><i class="fa fa-circle invert" id=""></i></a>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Mendaftar</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Mahasiswa mendaftarkan kelompoknya masimak 4 orang untuk pelaksanaan kerja praktik.</p>
                                </div>
                                <div class="timeline-footer">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge">
                                <a><i class="fa fa-circle" id=""></i></a>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Meminta Surat Pengantar</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Mahasiswa meminta surat pengantar kerja praktik untuk di kirim ke tempat KP.</p>
                                </div>
                                <div class="timeline-footer">
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-badge">
                                <a><i class="fa fa-circle invert" id=""></i></a>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Kerja Praktik</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Mahasiswa melaksanakan kerja praktik</p>
                                </div>
                                <div class="timeline-footer">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge">
                                <a><i class="fa fa-circle" id=""></i></a>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Laporan Kerja Praktik</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Mahasiswa membuat laporan Kerja Praktik sebagai syarat Tugas Akhir.</p>
                                </div>
                                <div class="timeline-footer">
                                </div>
                            </div>
                        </li>
                        <li  class="timeline-inverted">
                            <div class="timeline-badge">
                                <a><i class="fa fa-circle invert" id=""></i></a>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Pengumpulan</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Mahasiswa menyerahkan hasil laporan Kerja Praktik.</p>
                                </div>
                                <div class="timeline-footer primary">
                                </div>
                            </div>
                        </li>
                        <li class="clearfix no-float"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="gallery" style="background:url('assets/document/img/style/h_bg.png');">
    <div class="container">
        <div class="title_area">
            <h2 class="title_two wow fadeInRight">GALERI</h2>
            <span></span>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div id="gallerySLide" class="gallery_area wow pulse">
                    <?php foreach ($galeri->result() as $data): ?>
                        <a href="<?php echo base_url('assets/document/img/gallery/'.$data->img);?>" title="<?php echo $data->nama;?>">
                            <img class="gallery_img" src="<?php echo base_url('assets/document/img/gallery/'.$data->img);?>" alt="img" />
                            <span class="view_btn">View</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<footer id="footer">
    <div class="footer_top">
        <div class="container">
            <div class="col-ld-12  col-md-12 col-sm-12">
                <div class="single_footer_widget">
                    <h3 class="wow slideInRight">Social Links</h3>
                    <ul class="footer_social wow tada">
                        <?php foreach ($sosial_link->result() as $a): ?>
                            <li><a data-toggle="tooltip" data-placement="top" title="<?php echo $a->icon;?>" class="soc_tooltip" href="<?php echo $a->link;?>" target="_blank"><i class="<?php echo iconlink($a->icon);?>"></i></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container">
            <div class="row" style="color:#fff;">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="footer_bootomLeft">
                        <p> Copyright &copy; D4 Teknik Informatika</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="footer_bootomRight">
                        <p>Versi 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="sign">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">SIGN IN</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="box-body" sty>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  id="nim">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Sebagai</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="tipe">
                                        <option value="mahasiswa">Mahasiswa</option>
                                        <option value="dosen">Dosen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 pull-left" style="margin-left:17%;">
                                    <button type="button" onclick="login()" class="btn btn-primary"> Sign In <i class="fa fa-arrow-right"></i></button>
                                </div>
                                <div class="col-sm-2" style="display:none;" id="loading2">
                                    <img style="width:50%;" src="<?php echo base_url('assets/img/loading3.gif'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <p id="kosong" style="padding:1%;display:none;" class="bg-danger">Silahkan isi terlebih dahulu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jQuery-2.1.4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/queryloader2.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/wow.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/slick.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.easing.1.3.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.animate-enhanced.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.superslides.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url('assets/js/jquery.circliful.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.tosrus.min.all.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
<script src="<?php echo base_url('style/front/js/custom.js'); ?>"></script>

<script>
    function login()
    {
        var nim = $('#nim').val();
        var password = $('#password').val();
        if (nim == "" || password == "") {
            kosong();
        } else {
            $('#loading2').show();
            setTimeout(function()
            {
                $('#loading2').show();
                var tipe = $('#tipe').val();
                var url_mhs	 = 'Mahasiswa/';
                var url_dsn	 = 'Dosen/';
                var datas="nim="+nim+"&password="+password+"&tipe="+tipe;
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('Cindex/login'); ?>",
                    data: datas,
                    success: function(data)
                    {
                        //selesai();
                        $('#loading2').hide();
                        if (data==1) {
                            window.location = url_mhs;
                        } else if (data==2) {
                            window.location = url_dsn;
                        } else if (data==0) {
                            swal("Oops...", "Silahkan coba lagi dengan id dan password yang benar!", "error");
                        }
                        else {
                            alert(data);
                        }
                    },
                    error:function(data)
                    {
                        $('#loading2').hide();
                        swal("Oops...", "Terjadi kesalahan! Silahkan coba lagi.", "error");$('#loading').hide();
                    }
                });
            }, 3000);
        }
    }
    function kosong()
    {
        $("#kosong").fadeIn("slow");
        setTimeout(
            function() {
                $("#kosong").fadeOut("slow");
            },2000);
    }

    function tunggu()
    {
        $("#loading").fadeIn("slow");
    }

    function selesai()
    {
        $("#loading").fadeOut("slow");
    }

    function popup()
    {
        $('div.popup').fadeIn('slow');
        $.ajax({
            type:"GET",
            url:"<?php echo base_url('Cindex/popup');?>",
            success:function(data)
            {
                $('#popup').html(data);
            }
        });
    }
    function tutup()
    {
        $('div.popup').fadeOut('slow');
    }
</script>
</body>
</html>

