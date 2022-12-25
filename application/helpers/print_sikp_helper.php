<?php
define('FPDF_FONTPATH',APPPATH .'plugins/font/');
require(APPPATH .'plugins/fpdf.php');
class Print_SIKP extends FPDF
{
  function __construct()
  {
    parent::__construct();
    $ci =& get_instance();
    if (!isset($ci->session->userdata['logged_in_mhs']) == TRUE)
    {
      redirect(base_url());
    }
  }
  function judul($teks1, $teks2, $teks3, $teks4, $teks5)
  {
    $this->image('assets/document/img/style/logo_poltek4.jpg',13,13,30,30);

    $this->Cell(35);
    $this->SetFont('Times','B','14');
    $this->Cell(0,8,$teks1,0,1,'C');
    $this->Cell(35);
    $this->SetFont('Times','B','18');
    $this->Cell(0,8,$teks2,0,1,'C');
    $this->Cell(35);
    $this->SetFont('Times','B','18');
    $this->Cell(0,10,$teks3,0,1,'C');
    $this->Cell(35);
    $this->SetFont('Times','','12');
    $this->Cell(0,4,$teks4,0,1,'C');
    $this->Cell(35);
    $this->Cell(0,10,$teks5,0,1,'C');
  }

  function garis()
  {
    $this->SetLineWidth(1);
    $this->Line(10,51,200,51);
    $this->SetLineWidth(0);
    $this->Line(10,50,200,50);
  }
  function teks2($nomor_surat)
  {
    $this->Cell(15);
    $this->cell(0,8,"",0,1);
    $this->Cell(15);
    $this->setFont('times','',12);
    $this->cell(0,8,"Nomor            : $nomor_surat",0,1);
    $this->Cell(15);
    $this->cell(0,8,"Lampiran        : - ",0,1);
    $this->Cell(15);
    $this->cell(0,8,"Perihal            : Surat Ijin Kerja Praktik Industri",0,1);
  }
  function teks3($nama_perusahaan)
  {
    $this->Cell(15);
    $this->cell(0,8,"",0,1);
    $this->Cell(15);
    $this->setFont('times','',12);
    $this->cell(0,8,"Kepada Yth.",0,1);
    $this->Cell(15);
    $this->cell(0,8,$nama_perusahaan,0,1);
  }
  function isi($nama_perusahaan,$jml_hari,$tgl_mulai)
  {
    $this->Cell(15);
    $this->cell(0,8,"",0,1);
    $this->Cell(15);
    $this->SetFont('times','','12');
    $this->SetMargins(25,0,25);
    $this->write(8,"            Dengan hormat kami sampaikan, sehubungan dengan salah satu mata  kuliah  pada kurikulum di Program Studi D IV-Teknik Informatika Politeknik Harapan Bersama  Tegal, maka  bersama  ini kami mohon ijin Kerja Praktik bagi  mahasiswa kami  di instansi  yang Bapak/Ibu pimpin yaitu di ".$nama_perusahaan.", minimum ".$jml_hari." hari kerja mulai ".tgl($tgl_mulai).".");
  }
  function table($nama_mahasiswa,$nim_mahasiswa)
  {
    $this->cell(0,1,"",0,1);
    $this->Cell(3);
    $this->Cell(20,7,"No",1,0,'C');
    $this->Cell(90,7,"Nama",1,0,'C');
    $this->Cell(40,7,"NIM",1,0,'C');
    $this->Ln();

    $no=0;
    foreach ($nama_mahasiswa as $a)
    {
      $no++;
      $this->Cell(3);
      $this->Cell(20,7,$no,1,0,'C');
      $this->Cell(90,7,$a,1,0,'L');
      $this->Cell(40,7,$nim_mahasiswa[$no],1,0,'C');
      $this->Ln();
    }
  }
  function isi2()
  {
    $this->Cell(15);
    $this->cell(0,1,"",0,1);
    $this->Cell(15);
    $this->SetFont('times','','12');
    $this->SetMargins(25,0,25);
    $this->write(8,"Demikian  permohonan ini,  atas perhatian dan  kerjasamanya  kami  sampaikan  terimakasih.");
  }
  function penutup($tgl,$ka_prodi,$nipy_ka_prodi)
  {
    $this->cell(0,8,"",0,1);
    $this->Cell(90);
    $this->setFont('times','',12);
    $this->cell(0,6,tgl($tgl),0,1);

    $this->Cell(90);
    $this->setFont('times','',12);
    $this->cell(0,6,"Ka. Prodi D IV Teknik Informatika",0,1);

    $this->Cell(90);
    $this->setFont('times','',12);
    $this->cell(0,6,"Politeknik Harapan Bersama",0,1);

    $this->cell(0,15,"",0,1);

    $this->Cell(90);
    $this->setFont('times','BU',12);
    $this->cell(0,6,$ka_prodi,0,1);

    $this->Cell(90);
    $this->setFont('times','',12);
    $this->cell(0,6,"NIPY. ".$nipy_ka_prodi,0,1);
  }
}
?>
