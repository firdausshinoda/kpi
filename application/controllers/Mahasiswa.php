<?php

class Mahasiswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mmahasiswa');
        $this->load->model('Madmin');
        $this->load->helper('library_helper');
        $this->load->helper('print_sikp_helper');
        if (!isset($this->session->userdata['logged_in_mhs']) == TRUE)
        {
            redirect(base_url());
        }
    }

    public function coba(){
        echo json_encode($this->db->get_where('kp_anggota',array('id_mahasiswa'=>"18090079"))->row());
    }
    public function index()
    {
        $data['s_nim'] = $this->session->userdata('nim');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('mahasiswa/Vmahasiswa',$data);
    }
    public function dashboard()
    {
        $data['lap_fix'] = $this->Mmahasiswa->jml_laporan_fix()->num_rows();
        $data['kp_fix'] = $this->Mmahasiswa->jml_kp_fix()->num_rows();
        $data['daftar_kp_mhs'] = $this->Mmahasiswa->daftar_kp_mhs();
        $data['daftar_lap_mhs'] = $this->Mmahasiswa->daftar_lap_mhs();
        $this->load->view('mahasiswa/dashboard/Vdashboard',$data);
    }
    public function dashboard_data_post()
    {
        $page = filter_var($this->input->get('page'), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        $data['dashboard'] = $this->Mmahasiswa->dashboard($page);
        $data['stt_post'] = $this->Madmin->t_dashboard()->num_rows();
        $this->load->view('mahasiswa/dashboard/Vdashboard_post',$data);
    }
    public function daftar_mahasiswa_dan_laporan_kptb()
    {
        $tabel = $this->input->post('tabel');
        $data_session = array('tabel' => $tabel);
        $this->session->set_userdata($data_session);
    }
    public function Daftar_Mahasiswa_Dan_Laporan_KP()
    {
        $data['tabel'] = $this->session->userdata('tabel');
        $data['s_nim'] = $this->session->userdata('nim');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('mahasiswa/Vkp',$data);
    }
    public function dashboard_tabel_kp()
    {

        $this->load->view('mahasiswa/dashboard/Vkp_index');
    }
    public function dashboard_table_mhs()
    {
        $data['daftar_mahasiswa_kp'] = $this->Mmahasiswa->daftar_mahasiswa_kp();
        $this->load->view('mahasiswa/dashboard/Vtmhs',$data);
    }
    public function dashboard_table_lap()
    {
        $data['daftar_lap_kp'] = $this->Mmahasiswa->daftar_lap_kp();
        $this->load->view('mahasiswa/dashboard/Vtlap',$data);
    }
    public function Agenda()
    {
        $data['s_nim'] = $this->session->userdata('nim');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('mahasiswa/Vagenda',$data);
    }
    public function agenda_index()
    {
        $this->load->view('mahasiswa/agenda/Vagenda_index');
    }
    public function agenda_form()
    {
        $id_mahasiswa = $this->session->userdata('nim');
        $result = $this->Mmahasiswa->cek_id_kp($id_mahasiswa);
        if ($result->num_rows() == 1) {
            foreach ($result->result() as $a)
            {
                $data['create_id_kp'] = $a->create_by;
                $data['stt'] = $a->stt;
                $data['id_kp'] = $a->id_kp;
                $data['id_mahasiswa'] = $a->id_mahasiswa;
            }
            $cik = $data['create_id_kp'];
            $result2 = $this->Mmahasiswa->cek_pembuat_id_kp($cik)->result();
            foreach ($result2 as $b)
            {
                $data['nama_mahasiswa'] = $b->nama_mahasiswa;
            }
            $data['daftar_anggota_kp'] = $this->Mmahasiswa->daftar_anggota_kp($data['id_kp']);
        }
        else {
            $data['id_mahasiswa'] = "";
            $data['nama_mahasiswa'] = "";
            $data['daftar_anggota_kp'] = "";
            $data['stt'] = "3";
            $data['id_kp'] = "";
            $data['create_id_kp'] = "";
        }
        $this->load->view('mahasiswa/agenda/Vagenda_form',$data);
    }
    public function input_baru_idkp()
    {
        $idkp = $this->input->post('idkp');
        $ck = $this->Mmahasiswa->cek_sikp($idkp);
        if ($ck->num_rows() == 0){
            $id = $this->session->userdata('nim');
            $stmt = $this->Mmahasiswa->input_baru_idkp($idkp,$id);
            if($stmt)
            { echo "1"; }
            else { echo "0"; }
        } else {
            echo "2";
        }
    }
    public function input_join_idkp()
    {
        $idkp = $this->input->post('idkp');
        $ck = $this->Mmahasiswa->cek_sikp($idkp);
        if ($ck->num_rows() > 0){
            $id = $this->session->userdata('nim');
            $ck2 = $this->Mmahasiswa->cek_kp_mahasiswa($id)->num_rows();
            if ($ck2 == 0){
                $stmt = $this->Mmahasiswa->input_join_idkp($idkp,$id);
                if($stmt)
                { echo "1"; }
                else { echo "0"; }
            } else {
                echo "2";
            }
        } else {
            echo "3";
        }
    }
    public function input_keluar_idkp()
    {
        $idkp = $this->input->post('idkp');
        $id = $this->session->userdata('nim');
        $stmt = $this->Mmahasiswa->input_keluar_idkp($idkp,$id);
        if($stmt)
        { echo "1"; }
        else { echo "0"; }
    }
    public function input_keluarkan_idkp()
    {
        $idkp = $this->input->post('idkp');
        $nim = $this->input->post('nim');
        $id = $this->session->userdata('nim');
        $stmt = $this->Mmahasiswa->input_keluarkan_idkp($idkp,$nim,$id);
        if($stmt)
        { echo "1"; }
        else { echo "0"; }
    }
    public function input_tambah_idkp()
    {
        $idkp = $this->input->post('idkp');
        $id = $this->session->userdata('nim');
        $nim = $this->input->post('nim');
        $result = $this->Mmahasiswa->cek_nim_mahasiswa($nim)->num_rows();
        $ck = $this->Mmahasiswa->cek_kp_mahasiswa($nim)->num_rows();
        if ($result >= 1) {
            if ($ck == 0 ){
                $stmt = $this->Mmahasiswa->input_tambah_idkp($idkp,$id,$nim);
                if($stmt)
                { echo "1"; }
                else { echo "0"; }
            } else {
                echo "3";
            }
        } else {
            echo "2";
        }
    }
    public function input_hapus_idkp()
    {
        $idkp = $this->input->post('idkp');
        $id = $this->session->userdata('nim');
        $result = $this->Mmahasiswa->cek_sikp($idkp)->result();
        foreach ($result as $a)
        {
            if (!empty($a->nama_file))
            {
                unlink("./assets/document/file/surat_terima_perusahaan/$a->nama_file");
            }
        }
        $stmt = $this->Mmahasiswa->input_hapus_idkp($idkp,$id);
        if($stmt)
        { echo "1"; }
        else { echo "0"; }
    }
    public function agenda_data_perusahaan()
    {
        $id_mahasiswa = $this->session->userdata('nim');
        $data['data'] = $this->Mmahasiswa->data_perusahaan($id_mahasiswa);
        $data['bid_kerja'] = $this->Mmahasiswa->bidang_kerja();
        $data['wilayah'] = $this->Mmahasiswa->wilayah();
        $this->load->view('mahasiswa/agenda/Vagenda_data_perusahaan',$data);
    }
    public function input_dt_pers()
    {
        $nm_pers = $this->input->post('nm_pers');
        $bid_kerja = $this->input->post('bid_kerja');
        $bid_kerja_lainnya = $this->input->post('bid_kerja_lainnya');
        $desk_pers = $this->input->post('desk_pers');
        $wilayah = $this->input->post('wilayah');
        $wilayah_lainnya = $this->input->post('wilayah_lainnya');
        $almt_pers = $this->input->post('almt_pers');
        $id = $this->session->userdata('nim');
        $idkp = $this->input->post('id');

        if ($bid_kerja == "1"){
            $bid_kerja = $this->Mmahasiswa->bidang_kerja_input($bid_kerja_lainnya);
        }
        if ($wilayah == "1"){
            $wilayah = $this->Mmahasiswa->wilayah_input($wilayah_lainnya);
        }

        $data = array('nama_perusahaan'=>$nm_pers,'deskripsi'=>$desk_pers,'alamat'=>$almt_pers,'id_bidang_kerja'=>$bid_kerja,'id_wilayah'=>$wilayah);
        $stmt = $this->Mmahasiswa->input_dt_pers($data,$idkp,$id);
        if ($stmt)
        { echo "1";}
        else
        { echo "0";}
    }
    public function input_dokumen_pers()
    {
        $idkp = $this->input->post('id');
        $nm_file = $this->input->post('nama_file');
        $id = $this->session->userdata('nim');
        $config['upload_path'] = './assets/document/file/surat_terima_perusahaan/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size']	= '1000';
        $config['file_name'] = "Surat-terima-perusahaan-".$idkp;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file'))
        {
            //echo $this->upload->display_errors();
            echo "2";
        }
        else
        {
            if (!empty($nm_file))
            {
                unlink("./assets/document/file/surat_terima_perusahaan/$nm_file");
            }
            $fn = $this->upload->data();
            $b = $this->upload->data('file_size');
            $c = $this->upload->data('file_type');
            $nama = $fn['file_name'];
            $stmt = $this->Mmahasiswa->input_dokumen_pers($nama,$b,$c,$idkp,$id);
            if ($stmt)
            {echo "1";}
            else
            { echo "0"; }
        }
    }
    public function download_dt_pers()
    {
        $nm = $this->uri->segment('3');
        force_download('assets/document/file/surat_terima_perusahaan/'.$nm,NULL);
    }
    public function download_dashboard()
    {
        $nm = $this->uri->segment('3');
        force_download('assets/document/file/dashboard/'.$nm,NULL);
    }
    public function agenda_pembimbing()
    {
        $id_mahasiswa = $this->session->userdata('nim');
        $result = $this->Mmahasiswa->cek_id_kp($id_mahasiswa);
        if ($result->num_rows() == 1) {
            foreach ($result->result() as $a)
            {
                $data['id_kp'] = $a->id_kp;
            }
            $data['ck'] = "1";
            $data['daftar_pembimbing_kp'] = $this->Mmahasiswa->daftar_pembimbing_kp($data['id_kp']);
        }
        else {
            $data['ck'] = "0";
        }
        $this->load->view('mahasiswa/agenda/Vagenda_pembimbing',$data);
    }
    public function agenda_data_kp()
    {
        $id_mahasiswa = $this->session->userdata('nim');
        $data['data_pers'] = $this->Mmahasiswa->data_perusahaan($id_mahasiswa);
        $data['data_idkp'] = $this->Mmahasiswa->cek_id_kp($id_mahasiswa);
        $data['data_kp'] = $this->Mmahasiswa->data_kp($id_mahasiswa);
        $this->load->view('mahasiswa/agenda/Vagenda_data_kp',$data);
    }
    public function input_dokumen_lap_kp()
    {
        $idkp = $this->input->post('idkp');
        $judul = $this->input->post('judul');
        $id_lap = $this->input->post('id_lap');
        $id = $this->session->userdata('nim');
        $nama_mhs = $this->session->userdata('nama');
        $stmt = $this->Mmahasiswa->input_dokumen_lap_kp($judul,$idkp,$id,$id_lap);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function download_sikp()
    {
        $nim = $this->session->userdata('nim');
        $dt_perusahaan = $this->Mmahasiswa->data_perusahaan($nim);
        foreach ($dt_perusahaan->result() as $a)
        {
            $nama_perusahaan = $a->nama_perusahaan;
        }
        $result = $this->Mmahasiswa->cek_id_kp($nim);
        foreach ($result->result() as $a)
        {
            $data['id_kp'] = $a->id_kp;
        }
        $result2 = $this->Mmahasiswa->daftar_anggota_kp($data['id_kp']);
        $no = 0;
        foreach ($result2->result() as $a) {
            $no++;
            $nama_mahasiswa[$no] = $a->nama_mahasiswa;
            $nim_mahasiswa[$no] = $a->id_mahasiswa;
        }
        $result3 = $this->Mmahasiswa->nama_ka_prodi();
        foreach ($result3->result() as $a)
        {
            $ka_prodi = $a->nama_dosen;
            $nipy_ka_prodi = $a->id_dosen;
        }
        $result4 = $this->Mmahasiswa->sikp();
        foreach ($result4->result() as $a)
        {
            $nomor_surat_keluar = $a->nomor_surat_keluar;
            $nomor_surat = $a->nomor_surat;
            $tgl_mulai = $a->tgl_mulai;
            $jml_hari = $a->jml_hari;
            $email = $a->email_d4;
            $tahun_print_teakhir = $a->tahun_print_terakhir;
        }
        $tahun_sekarang = date('Y');
        if ($tahun_sekarang > $tahun_print_teakhir){
            $nomor_surat_keluar = "1";
            $data = array('tahun_print_terakhir'=>$tahun_sekarang,'nomor_surat_keluar'=>"1");
            $this->Mmahasiswa->update_tahun_print_terakhir($data);
        } else{
            $nomor_surat_keluar = $nomor_surat_keluar+1;
            $data = array('nomor_surat_keluar'=>$nomor_surat_keluar);
            $this->Mmahasiswa->update_nomor_surat_keluar($data);
        }

        $jml_nomor_surat_keluar = strlen($nomor_surat_keluar);
        if($jml_nomor_surat_keluar == 1){
            $nomor_surat_keluar = "00".$nomor_surat_keluar;
        } else if ($jml_nomor_surat_keluar == 2){
            $nomor_surat_keluar = "0".$nomor_surat_keluar;
        } else{
            $nomor_surat_keluar = $nomor_surat_keluar;
        }

        $bulan_surat = bulan_to_romawi(date('n'));
        //009.10/TI.PHB/V/2016
        $nomor_surat = $nomor_surat_keluar.".".$nomor_surat."/".$bulan_surat."/".$tahun_sekarang;
        $pdf = new Print_SIKP();
        $pdf->AddPage('P','A4');
        $pdf->judul('Yayasan Pendidikan Harapan Bersama', 'PoliTeknik Harapan Bersama','PROGRAM STUDI D IV TEKNIK INFORMATIKA','Kampus I : Jl. Mataram No. 9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 'Website: informatika.poltektegal.ac.id        E-Mail: '.$email);
        $pdf->garis();
        $pdf->teks2($nomor_surat);
        $pdf->teks3($nama_perusahaan);
        $pdf->isi($nama_perusahaan,$jml_hari,$tgl_mulai);
        $pdf->Ln();
        $pdf->table($nama_mahasiswa,$nim_mahasiswa);
        $pdf->isi2();
        $pdf->Ln();
        $pdf->penutup(date('Y-m-d'),$ka_prodi,$nipy_ka_prodi);
        $pdf->Output('Surat Permohonan Kerja Praktik.pdf','I');
        $result_id = $this->Mmahasiswa->get_id_kp($nim);
        foreach ($result_id->result() as $data) {
            $id_kp = $data->id_kp;
        }
        $data = array('id'=>"ID Mahasiswa ".$nim,'ket'=>"Mencetak surat ijin KP dengan ID KP ".$id_kp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->Mmahasiswa->log_activity($data);
    }
    public function detail_mahasiswa_popup()
    {
        $id_mahasiswa = $this->input->post('id_mahasiswa');
        $data['detail_mahasiswa'] = $this->Mmahasiswa->detail_mahasiswa($id_mahasiswa);
        $this->load->view('mahasiswa/agenda/Vmahasiswa_detail_popup',$data);
    }
    public function detail_dosen_popup()
    {
        $id_dosen = $this->input->post('id_dosen');
        $data['detail_dosen'] = $this->Mmahasiswa->detail_dosen($id_dosen);
        $this->load->view('mahasiswa/agenda/Vdosen_detail_popup',$data);
    }
    public function agenda_kp_harian()
    {
        $id_mahasiswa = $this->session->userdata('nim');
        $data['id'] = $id_mahasiswa;
        $data['data'] = $this->Mmahasiswa->data_kp_harian($id_mahasiswa);
        $data['data_kp'] = $this->Mmahasiswa->data_kp($id_mahasiswa);
        $this->load->view('mahasiswa/agenda/Vagenda_kp_harian',$data);
    }
    public function input_data_kp_harian()
    {
        $id = $this->input->post('id');
        $idkp = $this->input->post('idkp');
        $idpmb = $this->input->post('idpmb');
        $ket = $this->input->post('ket');
        $stmt = $this->Mmahasiswa->input_data_kp_harian($id,$idkp,$idpmb,$ket);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function hapus_kp_harian()
    {
        $id = $this->input->post('id');
        $id_mahasiswa = $this->session->userdata('nim');
        $stmt = $this->Mmahasiswa->hapus_kp_harian($id,$id_mahasiswa);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function agenda_kp_bimbingan()
    {
        $id_mahasiswa = $this->session->userdata('nim');
        $data['data'] = $this->Mmahasiswa->data_kp_bimbingan($id_mahasiswa);
        $data['data_kp'] = $this->Mmahasiswa->data_kp($id_mahasiswa);
        $this->load->view('mahasiswa/agenda/Vagenda_kp_bimbingan',$data);
    }
    public function Bimbingan_Online()
    {
        $data['s_nim'] = $this->session->userdata('nim');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $segment = $this->uri->segment(3);
        if (empty($segment))
        {
            $this->load->view('mahasiswa/Vbimbingan_online',$data);
        }
        elseif (!empty($segment))
        {
            $data['segment'] = $segment;
            $this->load->view('mahasiswa/Vbimbingan_online_chat',$data);
        }
    }
    public function bimbingan_online_index()
    {
        $id = $this->session->userdata('nim');
        $data['daftar'] = $this->Mmahasiswa->daftar_pembimbing_chat($id);
        $this->load->view('mahasiswa/bimbingan_online/Vbimbingan_online',$data);
    }
    public function bimbingan_online_chat()
    {
        $data['iddsn'] = $this->input->post('id');
        $data['nim'] = $this->session->userdata('nim');
        $stmt = $this->Mmahasiswa->cek_chat($data['iddsn'],$data['nim'],"dosen");
        $this->load->view('mahasiswa/bimbingan_online/Vbimbingan_online_chat',$data);
    }
    public function bimbingan_online_chat_index()
    {
        $data['iddsn'] = $this->input->post('id');
        $data['nim'] = $this->session->userdata('nim');
        $data['message'] = $this->Mmahasiswa->data_chat($data['iddsn'],$data['nim'],"mhs");
        $stmt = $this->Mmahasiswa->cek_chat($data['iddsn'],$data['nim'],"dosen");
        $this->load->view('mahasiswa/bimbingan_online/Vchat',$data);
    }
    public function input_chat()
    {
        $n = 20;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        $cf['upload_path'] = './assets/document/file/bimbingan_online/';
        $cf['allowed_types'] = 'pdf|doc|docx|zip|rar|jpg|png|jpeg';
        $cf['max_size']	= '5000';
        $cf['file_name'] = $aKod;
        $this->upload->initialize($cf);
        $id = $this->session->userdata('nim');
        $chat = $this->input->post('isi');
        $j = $this->input->post('i');
        $iddsn = $this->input->post('iddsn');
        if (!$this->upload->do_upload('file'))
        {
            $info = $this->upload->display_errors();
            if ($info == "<p>You did not select a file to upload.</p>")
            {
                $stmt = $this->Mmahasiswa->input_chat($id,$chat,$iddsn,"","","","1","mahasiswa");
                if ($stmt)
                { echo "1"; }
                else
                { echo "0"; }
            }
            else
            { echo "2"; }
        }
        else
        {
            $fn = $this->upload->data();
            $b = $this->upload->data('file_size');
            $c = $this->upload->data('file_type');
            $nama = $fn['file_name'];
            $stmt = $this->Mmahasiswa->input_chat($id,$chat,$iddsn,$c,$b,$nama,"1","mahasiswa");
            if ($stmt)
            { echo "1"; }
            else
            { echo "0"; }
        }
    }
    public function clear_chat()
    {
        $iddsn = $this->input->post('iddsn');
        $nim = $this->session->userdata('nim');
        $stmt = $this->Mmahasiswa->clear_chat($iddsn,$nim,"mahasiswa");
        if ($stmt)
        { echo "1"; }
        else
        { echo "0"; }
    }
    public function download_dk_chat()
    {
        $nm = $this->uri->segment('3');
        force_download('assets/document/file/bimbingan_online/'.$nm,NULL);
    }
    public function Profil()
    {
        $data['s_nim'] = $this->session->userdata('nim');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('mahasiswa/Vprofil',$data);
    }
    public function profil_mhs()
    {
        $id_mahasiswa = $this->session->userdata('nim');
        $result = $this->Mmahasiswa->detail_mahasiswa($id_mahasiswa)->result();
        foreach ($result as $a)
        {
            $data['id_mahasiswa'] = $a->id_mahasiswa;
            $data['foto'] = $a->foto_mahasiswa;
            $data['nama_mahasiswa'] = $a->nama_mahasiswa;
            $data['agama'] = $a->agama;
            $data['no_hp'] = $a->no_hp;
            $data['no_wa'] = $a->no_wa;
            $data['sex'] = $a->sex;
            $data['tgl_lahir'] = $a->tgl_lahir;
            $data['bln_lahir'] = $a->bln_lahir;
            $data['thn_lahir'] = $a->thn_lahir;
            $data['email'] = $a->email;
            $data['alamat'] = $a->alamat;
            $data['golongan_darah'] = $a->golongan_darah;
            $data['angkatan'] = $a->angkatan;
            $data['mdate'] = $a->mdate;
        }
        $this->load->view('mahasiswa/profile/Vprofil',$data);
    }
    public function input_ubah_img()
    {
        $n = 20;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        $config['upload_path'] = './assets/document/img/mahasiswa/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']	= '1000';
        $config['file_name'] = $aKod;
        $this->upload->initialize($config);
        $id = $this->input->post('id');
        $img2 = $this->input->post('img2');
        $id = $this->session->userdata('nim');
        if (!$this->upload->do_upload('img'))
        { echo "2"; }
        else
        {
            if (!empty($img2))
            {
                unlink("./assets/document/img/mahasiswa/$img2");
            }
            $fn = $this->upload->data();
            $nama = $fn['file_name'];
            $image_data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 822;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $stmt = $this->Mmahasiswa->input_ubah_img($nama,$id);
            if ($stmt)
            {
                $data_session = array('foto'=>$nama);
                $this->session->set_userdata($data_session);
                echo "1";
            }
            else
            { echo "0"; }
        }
    }
    public function input_ubah_biodata()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $data = array(
            'nama_mahasiswa'=>$nama,
            'agama'=>$this->input->post('agama'),
            'no_hp'=>$this->input->post('no_hp'),
            'no_wa'=>$this->input->post('no_wa'),
            'sex'=>$this->input->post('sex'),
            'tgl_lahir'=>$this->input->post('tgl'),
            'bln_lahir'=>$this->input->post('bln'),
            'thn_lahir'=>$this->input->post('thn'),
            'email'=>$this->input->post('email'),
            'alamat'=>$this->input->post('alamat'),
            'golongan_darah'=>$this->input->post('gol_drh'),
            'mdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->Mmahasiswa->input_ubah_biodata($id,$data);
        if ($stmt)
        {
            $data_session = array('nama'=>$nama);
            $this->session->set_userdata($data_session);
            echo "1";}
        else
        { echo "0"; }
    }
    public function input_ubah_pass()
    {
        $id = $this->input->post('id');
        $passl = $this->input->post('passl');
        $passwordl = md5($passl);
        $passb = $this->input->post('passb');
        $passwordb = md5($passb);
        $result = $this->Mmahasiswa->detail_mahasiswa($id)->result();
        foreach ($result as $a)
        {
            if ($passwordl == $a->password)
            {
                $stmt = $this->Mmahasiswa->input_ubah_pass($id,$passwordb);
                if ($stmt)
                { echo "1";}
                else
                { echo "0";}
            }
            else
            { echo "2";}
        }
    }
    public function id_kp_generate()
    {
        $n = 10;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        echo $aKod;
    }
    public function modal()
    {
        $data['page'] = $this->input->get('page');
        $id = $this->input->get('id');
        if ($data['page'] == "detailmhs")
        {
            $data['daftar'] = $this->Mmahasiswa->detail_mahasiswa($id);
            $this->load->view('style/Vmodal',$data);
        }
        if ($data['page'] == "detaildsn")
        {
            $data['daftar'] = $this->Mmahasiswa->detail_dosen($id);
            $this->load->view('style/Vmodal',$data);
        }
        if ($data['page'] == "input_kp_harian")
        {
            $data['daftar'] = $this->Mmahasiswa->cek_data_kp_harian($id);
            $this->load->view('style/Vmodal',$data);
        }
        if ($data['page'] == "detail_img")
        {
            $result = $this->Mmahasiswa->detail_img_dashboard($id);
            foreach ($result->result() as $a) {
                $data['file'] = $a->file;
                $data['tipe'] = $a->tipe;
                $data['img'] = "assets/document/file/dashboard/".$a->file;
            }
            $this->load->view('style/Vmodal',$data);
        }
    }
    function logout()
    {
        $id_mahasiswa = $this->session->userdata('nim');
        $stmt = $this->Mmahasiswa->logout_mhs($id_mahasiswa);
        if ($stmt)
        {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }
}
