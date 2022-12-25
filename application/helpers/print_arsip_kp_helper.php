<?php
define('FPDF_FONTPATH',APPPATH .'plugins/font/');
require(APPPATH .'plugins/fpdf.php');
class Print_ARSIP_KP extends FPDF
{
    function __construct()
    {
        parent::__construct();
        $ci =& get_instance();
        if (!isset($ci->session->userdata['logged_in_admin']) == TRUE)
        {
            redirect(base_url());
        }
    }
    function judul($teks1, $teks2, $teks3, $teks4, $teks5)
    {
        $this->image('assets/document/img/style/logo_poltek4.jpg',40,13,30,30);

        $this->Cell(10);
        $this->SetFont('Times','B','14');
        $this->Cell(0,8,$teks1,0,1,'C');
        $this->Cell(10);
        $this->SetFont('Times','B','18');
        $this->Cell(0,8,$teks2,0,1,'C');
        $this->Cell(10);
        $this->SetFont('Times','B','18');
        $this->Cell(0,10,$teks3,0,1,'C');
        $this->Cell(10);
        $this->SetFont('Times','','12');
        $this->Cell(0,4,$teks4,0,1,'C');
        $this->Cell(10);
        $this->Cell(0,10,$teks5,0,1,'C');
    }

    function garis()
    {
        $this->SetLineWidth(1);
        $this->Line(10,51,290,51);
        $this->SetLineWidth(0);
        $this->Line(10,50,290,50);
    }
    function teks2()
    {
        $this->Cell(15);
        $this->cell(0,8,"",0,1);
        $this->Cell(5);
        $this->cell(0,8,"Perihal            : Arsip Mahasiswa Kerja Praktik Tahun",0,1);
    }
    function table($tahun)
    {
        $this->Ln(5);
        $CI =& get_instance();
        $where_tahun=array();
        if ($tahun!="semua"){
            $where_tahun['YEAR(cdate)'] = $tahun;
        }
        $where_tahun['stt_arsip'] = 1;
        $tahun = $CI->db->select('YEAR(cdate) as tahun')->order_by('YEAR(cdate)','DESC')
            ->group_by('YEAR(cdate)')->get_where('kp',$where_tahun);

        $now = 1;
        if ($tahun->num_rows() == 0){
            echo "Belum ada data";
        }

        foreach ($tahun->result() as $it_tahun) {
            $this->checkBreak(100);
            $this->Ln(1);
            $this->Cell(5);
            $this->SetFont('Times','B','12');
            $this->cell(0,8,$now.". Tahun ".$it_tahun->tahun,0,1);

            $h = 13;
            $this->SetFillColor(200,200,200);
            $left = 20;
            $this->SetFont('Times','B','12');
            $this->SetX($left); $this->Cell(10, $h, 'No', 1, 0, 'C',true);
            $this->SetX($left += 10); $this->Cell(35, $h, 'ID KP', 1, 0, 'C',true);
            $this->SetX($left += 35); $this->Cell(45, $h, 'Nama Perusahaan', 1, 0, 'C',true);
            $this->SetX($left += 45); $this->Cell(60, $h, 'Alamat', 1, 0, 'C',true);
            $this->SetX($left += 60); $this->Cell(60, $h, 'Tim Mahasiswa', 1, 0, 'C',true);
            $this->SetX($left += 60); $this->Cell(60, $h, 'Dosen Pembimbing', 1, 1, 'C',true);

            $this->SetWidths(array(10,35,45,60,60,60));
            $this->SetAligns(array('C','C','C','C','L','L'));
            $noc = 1;
            $this->SetFillColor(255);

            $wilayah = $CI->db->select('wilayah.wilayah,kp.id_kp, kp_perusahaan.nama_perusahaan, kp_perusahaan.alamat')
                ->join('kp_perusahaan','kp_perusahaan.id_wilayah = wilayah.id_wilayah')
                ->join('kp','kp.id_kp = kp_perusahaan.id_kp')
                ->group_by('wilayah.id_wilayah')
                ->get_where("wilayah",array('kp.stt_arsip'=>1,'kp.deleted_flage'=>1,'YEAR(kp.cdate)'=>$it_tahun->tahun));
            foreach ($wilayah->result() as $it_data){
                $tim_mhs = '';
                $dt_mhs = $CI->db->select('mahasiswa.*')
                    ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')
                    ->get_where('kp_anggota',array('kp_anggota.id_kp'=>$it_data->id_kp))->result();
                $no_m = 1;
                foreach ($dt_mhs as $itm_mhs){
                    if ($no_m>1){
                        $tim_mhs .= "-----------------------------------------\n";
                    }
                    $tim_mhs .= $itm_mhs->nama_mahasiswa."\n".$itm_mhs->id_mahasiswa."\n";
                    if (!empty($itm_mhs->no_hp)){
                        $tim_mhs .= $itm_mhs->no_hp." (HP)\n";
                    }
                    if (!empty($itm_mhs->no_wa)){
                        $tim_mhs .= $itm_mhs->no_wa." (WA)\n";
                    }
                    $no_m++;
                }

                $tim_dosen = '';
                $dt_dosen = $CI->db->select('dosen.*')
                    ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
                    ->join('dosen','dosen.id_dosen = pembimbing_dosen.id_dosen')
                    ->get_where('pembimbing',array('pembimbing.id_kp'=>$it_data->id_kp,'pembimbing.deleted_flage'=>1))->result();
                foreach ($dt_dosen as $it_d){
                    $tim_dosen .= $it_d->nama_dosen;
                }

                $this->SetFont('Times','','12');
                $this->Row(
                    array(
                        $noc,
                        $it_data->id_kp,
                        $it_data->nama_perusahaan,
                        $it_data->alamat,
                        $tim_mhs,
                        $tim_dosen
                    ));
                $noc++;
            }

            $now++;
        }

//        $wilayah = $CI->db->select('wilayah.*')
//            ->join('kp_perusahaan','kp_perusahaan.id_wilayah = wilayah.id_wilayah')
//            ->join('kp','kp.id_kp = kp_perusahaan.id_kp')
//            ->group_by('wilayah.id_wilayah')
//            ->get_where("wilayah",array('kp.deleted_flage'=>1));
//
//        $now = 1;
//        foreach ($wilayah->result() as $it_wil) {
//            $this->checkBreak(100);
//            $this->Cell(5);
//            $this->SetFont('Times','B','12');
//            $this->cell(0,8,$now.". Wilayah ".$it_wil->wilayah,0,1);
//            $now++;
//
//            $h = 13;
//
//            $this->SetFillColor(200,200,200);
//            $left = 20;
//            $this->SetFont('Times','B','12');
//            $this->SetX($left); $this->Cell(10, $h, 'No', 1, 0, 'C',true);
//            $this->SetX($left += 10); $this->Cell(35, $h, 'ID KP', 1, 0, 'C',true);
//            $this->SetX($left += 35); $this->Cell(45, $h, 'Nama Perusahaan', 1, 0, 'C',true);
//            $this->SetX($left += 45); $this->Cell(60, $h, 'Alamat', 1, 0, 'C',true);
//            $this->SetX($left += 60); $this->Cell(60, $h, 'Tim Mahasiswa', 1, 0, 'C',true);
//            $this->SetX($left += 60); $this->Cell(60, $h, 'Dosen Pembimbing', 1, 1, 'C',true);
//
//            $this->SetWidths(array(10,35,45,60,60,60));
//            $this->SetAligns(array('C','C','C','C','L','L'));
//            $noc = 1;
//            $this->SetFillColor(255);
//
//            $data = $CI->db->select('kp.id_kp, kp_perusahaan.nama_perusahaan, kp_perusahaan.alamat')
//                ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
//                ->get_where('kp',array('kp.deleted_flage'=>1,'kp_perusahaan.id_wilayah'=>$it_wil->id_wilayah))->result();
//
//            foreach ($data as $item) {
//                $tim_mhs = '';
//                $dt_mhs = $CI->db->select('mahasiswa.*')
//                    ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')
//                    ->get_where('kp_anggota',array('kp_anggota.id_kp'=>$item->id_kp))->result();
//                $no_m = 1;
//                foreach ($dt_mhs as $itm_mhs){
//                    if ($no_m>1){
//                        $tim_mhs .= "-----------------------------------------\n";
//                    }
//                    $tim_mhs .= $itm_mhs->nama_mahasiswa."\n".$itm_mhs->id_mahasiswa."\n";
//                    if (!empty($itm_mhs->no_hp)){
//                        $tim_mhs .= $itm_mhs->no_hp." (HP)\n";
//                    }
//                    if (!empty($itm_mhs->no_wa)){
//                        $tim_mhs .= $itm_mhs->no_wa." (WA)\n";
//                    }
//                    $no_m++;
//                }
//
//                $tim_dosen = '';
//                $dt_dosen = $CI->db->select('dosen.*')
//                    ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
//                    ->join('dosen','dosen.id_dosen = pembimbing_dosen.id_dosen')
//                    ->get_where('pembimbing',array('pembimbing.id_kp'=>$item->id_kp,'pembimbing.deleted_flage'=>1))->result();
//                foreach ($dt_dosen as $it_d){
//                    $tim_dosen .= $it_d->nama_dosen;
//                }
//
//                $this->SetFont('Times','','12');
//                $this->Row(
//                    array(
//                        $noc,
//                        $item->id_kp,
//                        $item->nama_perusahaan,
//                        $item->alamat,
//                        $tim_mhs,
//                        $tim_dosen
//                    ));
//                $noc++;
//            }
//        }
    }

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=7*$nb;

        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        $this->checkBreak(155);
        $this->Cell(10);

        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {

            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,7,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function checkBreak($h){
        if ($this->GetY() >= $h){
            $this->AddPage($this->CurOrientation);
        }
    }
}