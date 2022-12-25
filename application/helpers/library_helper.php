<?php

function waktu_lalu2($timestamp)
{

	// date_default_timezone_set('Asia/Jakarta');

	$selisih = time() - strtotime($timestamp);
	$detik = $selisih;
	$menit = round($selisih / 60);
	$jam = round($selisih / 3600);
	$hari = round($selisih / 86400);
	$minggu = round($selisih / 604800);
	$bulan = round($selisih / 2419200);
	$tahun = round($selisih / 29030400);
	global $waktu_lalu;
	$waktu_jam = substr($waktu_lalu, 11, 5);
	if ($detik <= 30) {
		$waktu = ' baru saja';
	}
	elseif ($detik <= 60) {
		$waktu = $detik . ' detik yang lalu';
	}
	elseif ($menit <= 60) {
		$waktu = $menit . ' menit yang lalu';
	}
	elseif ($jam <= 24) {
		$waktu = $jam . ' jam yang lalu';
	}
	elseif ($hari <= 1) {
		$waktu = ' kemarin ' . $waktu_jam;
	}
	elseif ($hari <= 7) {
		$waktu = $hari . ' hari yang lalu ' . $waktu_jam;
	}
	elseif ($minggu <= 4) {
		$waktu = $minggu . ' minggu yang lalu ' . $waktu_jam;
	}
	elseif ($bulan <= 12) {
		$waktu = $bulan . ' bulan yang lalu ' . $waktu_jam;
	}
	else {
		$waktu = $tahun . ' tahun yang lalu ' . $waktu_jam;
	}

	// echo $waktu;

	return $waktu;
}

function isi_chat($str, $str2, $str3)
{
	$stmt = "";
	if ($str3 == "dosen") {
		$data = array(
			'id_mahasiswa' => $str,
			'id_dosen' => $str2,
			'stt_r_mhs' => "1"
		);
	}

	if ($str3 == "mahasiswa") {
		$data = array(
			'id_mahasiswa' => $str,
			'id_dosen' => $str2,
			'stt_r_dsn' => "1"
		);
	}

	$ci = & get_instance();
	$ci->load->database();
	$result = $ci->db->select('isi')->order_by('id_bimbingan_online', 'ASC')->limit(0, 1)->get_where('bimbingan_online', $data);
	foreach($result->result() as $a) {
		$isi = $a->isi;
	}

	if (!empty($isi)) {
		$isi2 = substr($isi, 0, 20);
		$data2 = array(
			'id_mahasiswa' => $str,
			'id_dosen' => $str2,
			'send_by' => $str3,
			'stt_chat' => "1"
		);
		$result2 = $ci->db->get_where('bimbingan_online', $data2)->num_rows();
		if ($result2 >= "1") {
			$stmt = $isi2 . " . . . (selengkapnya) <small class='label label-success'>$result2 pesan baru</small>";
		}
		else {
			$stmt = $isi2 . " . . . (selengkapnya)";
		}
	}

	return $stmt;
}

function daftar_kp($id)
{
	$data = array(
		'kp_anggota.id_kp' => $id
	);
	$ci = & get_instance();
	$ci->load->database();
	$result = $ci->db->select('kp_anggota.id_kp_anggota,kp_anggota.id_mahasiswa, mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa')->join('mahasiswa', 'mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')->order_by('kp_anggota.id_kp_anggota', 'DESC')->get_where('kp_anggota', $data);
	$no = 0;
	if ($result->num_rows() > 0){
        foreach($result->result() as $a) {
            $no++;
            $stmt[$no] = "<a onclick='detail_kp(" . $a->id_mahasiswa . ")' href='javascript:void()'>" . $no . ". " . $a->nama_mahasiswa . " (" . $a->id_mahasiswa . ")<a/><br />";
        }
    } else {
	    $stmt[1] = "<center>Tidak ada mahasiswa</center>";
    }
	return $stmt;
}

function daftar_kp_dtl($id)
{
	$data = array(
		'kp_anggota.id_kp' => $id
	);
	$ci = & get_instance();
	$ci->load->database();
	$result = $ci->db->select('kp_anggota.id_kp_anggota,kp_anggota.id_mahasiswa, mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa')->join('mahasiswa', 'mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')->order_by('kp_anggota.id_kp_anggota', 'DESC')->get_where('kp_anggota', $data);
	$no = 0;
	if ($result->num_rows() > 0){
        foreach($result->result() as $a) {
            $no++;
            $stmt[$no] = $a->nama_mahasiswa . " (" . $a->id_mahasiswa . ")";
        }
    } else {
	    $stmt[1] = "<center>Tidak ada mahasiswa</center>";
    }

	return $stmt;
}

function cdate_chat($str, $str2, $str3)
{
	if ($str3 == "dosen") {
		$data = array(
			'id_mahasiswa' => $str,
			'id_dosen' => $str2,
			'stt_r_mhs' => "1"
		);
	}

	if ($str3 == "mahasiswa") {
		$data = array(
			'id_mahasiswa' => $str,
			'id_dosen' => $str2,
			'stt_r_dsn' => "1"
		);
	}

	$ci = & get_instance();
	$ci->load->database();
	$result = $ci->db->select('cdate')->get_where('bimbingan_online', $data);
	foreach($result->result() as $a) {
		$stmt = $a->cdate;
		return $stmt;
	}
}

function daftar_pembimbing($str)
{
	$data = array(
		'pembimbing_dosen.id_pembimbing' => $str
	);
	$ci = & get_instance();
	$ci->load->database();
	$result = $ci->db->select('dosen.nama_dosen,dosen.id_dosen')->join('dosen', 'dosen.id_dosen = pembimbing_dosen.id_dosen')->get_where('pembimbing_dosen', $data);
	$no = 0;
	foreach($result->result() as $c) {
		$no++;
		$stmt[$no] = "<a onclick='dtl_dsn(" . $c->id_dosen . ")' href='javascript:void();'>" . $no . ". " . $c->nama_dosen . "</a><br />";
	}

	return $stmt;
}

function formatBytes($bytes, $precision = 2)
{
	$units = array(
		'KB',
		'MB',
		'GB',
		'TB'
	);
	$bytes = max($bytes, 0);
	$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
	$pow = min($pow, count($units) - 1);
	$bytes/= pow(1024, $pow);
	return round($bytes, $precision) . ' ' . $units[$pow];
}

function tgl($date)
{
	$BulanIndo = array(
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember"
	);
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl = substr($date, 8, 2);
	$result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
	return $result;
}

function substrfile($isi)
{
	$a = substr($isi, 0, 18);
	return $a . "...";
}

function substrgaleri($isi)
{
	$a = substr($isi, 0, 10);
	return $a . "...";
}

function iconlink($str)
{
	if ($str == "Facebook") {
		$stmt = "fa fa-facebook";
	}

	if ($str == "Linked") {
		$stmt = "fa fa-linkedin";
	}

	if ($str == "Twitter") {
		$stmt = "fa fa-twitter";
	}

	if ($str == "YouTube") {
		$stmt = "fa fa-youtube";
	}

	if ($str == "Instagram") {
		$stmt = "fa fa-instagram";
	}

	if ($str == "Skype") {
		$stmt = "fa fa-skype";
	}

	if ($str == "Yahoo") {
		$stmt = "fa fa-yahoo";
	}

	if ($str == "Gmail") {
		$stmt = "fa fa-google";
	}

	return $stmt;
}

function bulan_to_romawi($integer)
{

	// Convert the integer into an integer (just to make sure)

	$integer = intval($integer);
	$result = '';

	// Create a lookup array that contains all of the Roman numerals.

	$lookup = array(
		'M' => 1000,
		'CM' => 900,
		'D' => 500,
		'CD' => 400,
		'C' => 100,
		'XC' => 90,
		'L' => 50,
		'XL' => 40,
		'X' => 10,
		'IX' => 9,
		'V' => 5,
		'IV' => 4,
		'I' => 1
	);
	foreach($lookup as $roman => $value) {

		// Determine the number of matches

		$matches = intval($integer / $value);

		// Add the same number of characters to the string

		$result.= str_repeat($roman, $matches);

		// Set the integer to be the remainder of the integer and the value

		$integer = $integer % $value;
	}

	// The Roman numeral should be built, return it

	return $result;
}

function filepost($str)
{
	$data = array(
		'id_dashboard' => $str
	);
	$ci = & get_instance();
	$ci->load->database();
	$no = 0;
	$result = $ci->db->get_where('dashboard_file', $data);
	if ($result->num_rows() == 0) {
		$stmt = "0";
	}

	if ($result->num_rows() >= 1) {
		foreach($result->result() as $a) {
			$no++;
			if (!empty($a->nama)) {
				$file = substr(strrchr($a->nama, '.') , 1);
				if ($file == "jpg" || $file == "jpeg" || $file == "png" || $file == "JPG" || $file == "JPEG" || $file == "PNG") {
					$icon = "<span class=\"mailbox-attachment-icon has-img\"><img src=\"" . base_url('assets/document/file/dashboard/' . $a->nama) . "\" alt=\"Img\"></span>";
				}
				elseif ($file == "pdf") {
					$icon = "<span class=\"mailbox-attachment-icon\" ><i class=\"fa fa-file-pdf-o\" style=\"width:100%;\"></i></span>";
				}
				elseif ($file == "doc" || $file == "docx") {
					$icon = "<span class=\"mailbox-attachment-icon\" ><i class=\"fa fa-file-word-o\" style=\"width:100%;\"></i></span>";
				}
				elseif ($file == "zip" || $file == "rar") {
					$icon = "<span class=\"mailbox-attachment-icon\" ><i class=\"fa fa-file-archive-o\" style=\"width:100%;\"></i></span>";
				}
				else {
					$icon = "<span class=\"mailbox-attachment-icon\" ><i class=\"fa fa-paperclip\" style=\"width:100%;\"></i></span>";
				}

				if ($file == "jpg" || $file == "jpeg" || $file == "png" || $file == "JPG" || $file == "JPEG" || $file == "PNG") {
					$sizeFile = "";
					$detailFile = "<a class=\"mailbox-attachment-name\" href=\"javascript:void()\" onclick=\"detail_img('" . $a->id_dashboard_file . "')\"><i class=\"fa fa-paperclip\"></i>" . substrfile($a->nama) . "</a>";
				}
				else {
					$sizeFile = formatBytes($a->size);
					$detailFile = "<a class=\"mailbox-attachment-name\" href=\"javascript:void()\"><i class=\"fa fa-paperclip\"></i>" . substrfile($a->nama) . "</a>";
				}

				$stmt[$no] = "<li>
          " . $icon . "
          <div class=\"mailbox-attachment-info\">
            " . $detailFile . "
            <span class=\"mailbox-attachment-size\">" . $sizeFile . " " . $file . "
            <a href=\"javascript:void();\" onclick=\"download_dashboard('$a->nama')\" class=\"btn btn-default btn-xs pull-right\">
              <i class=\"fa fa-cloud-download\"></i>
            </a>
            </span>
          </div>
        </li>";
			}
			else {
			}
		}
	}

	return $stmt;
}
function setJSON($response)
{
    $ci = & get_instance();
    $ci->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
    exit;
}