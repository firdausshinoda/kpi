<?php
define('FPDF_FONTPATH',APPPATH .'plugins/font/');
require(APPPATH .'plugins/fpdf.php');
class Print_ARSIP_Dosen extends FPDF
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
    function teks2($tahun)
    {
        $this->Cell(15);
        $this->cell(0,8,"",0,1);
        $this->Cell(5);
        $this->cell(0,8,"Perihal            : Arsip Dosen Tahun ".ucfirst($tahun),0,1);
    }
    function table($data)
    {
        $this->Ln(5);

        if ($data->num_rows() == 0){
            echo "Belum ada data";
        }

        $this->checkBreak(100);
        $this->Ln(1);

        $h = 13;
        $this->SetFillColor(200,200,200);
        $left = 20;
        $this->SetFont('Times','B','12');
        $this->SetX($left); $this->Cell(10, $h, 'No', 1, 0, 'C',true);
        $this->SetX($left += 10); $this->Cell(30, $h, 'NIP Dosen', 1, 0, 'C',true);
        $this->SetX($left += 30); $this->Cell(70, $h, 'Nama Dosen', 1, 0, 'C',true);
        $this->SetX($left += 70); $this->Cell(40, $h, 'Jabatan', 1, 0, 'C',true);
        $this->SetX($left += 40); $this->Cell(60, $h, 'Email', 1, 0, 'C',true);
        $this->SetX($left += 60); $this->Cell(60, $h, 'Alamat', 1, 1, 'C',true);

        $no=1;
        foreach ($data->result() as $item) {
            $this->SetWidths(array(10,30,70,40,60,60));
            $this->SetAligns(array('C','C','C','C','C','C'));
            $this->SetFont('Times','','12');
            $this->SetFillColor(255);
            $this->Row(
                array(
                    $no,
                    $item->id_dosen,
                    $item->nama_dosen,
                    $item->jabatan,
                    $item->email,
                    $item->alamat
                ));
            $no++;
        }
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