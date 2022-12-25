<?php

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Madmin');
        $this->load->model('Mmahasiswa');
        $this->load->helper('library_helper');
        if (!isset($this->session->userdata['logged_in_admin']) == TRUE)
        {
            redirect(base_url());
        }
    }
    public function index()
    {
        redirect(base_url('Admin/Dashboard'));
    }
	public function coba(){
		$stmt = $this->db->query("DELETE FROM kp_anggota WHERE id_kp = '' AND YEAR(cdate) = '2020'");
		if ($stmt){
			echo 1;
		} else {
			echo 0;
		}
	}
	public function backup_db(){
        $this->load->dbutil();

        $prefs = array(
            'format' => "zip",
            'filename' => "backup_dp_".date('Y-m-d--H:i:s').".sql"
        );

        $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip'; // file name
        $save  = 'assets/' . $db_name; // dir name backup output destination

        $this->load->helper('file');
        if (write_file($save, $this->dbutil->backup($prefs))){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function Dashboard()
    {
        $result = $this->Madmin->clear_chat_bo();
        foreach ($result->result() as $a)
        {
            if (!empty($a->nama_file))
            {
                unlink("./assets/document/file/bimbingan_online/$a->nama_file");
            }
        }
        $result2 = $this->Madmin->clear_chat();
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vdashboard',$data);
    }
    public function dashboard_data()
    {
        $data['s_foto'] = $this->session->userdata('foto');
        $data['lap_fix'] = $this->Madmin->jml_laporan_fix()->num_rows();
        $data['kp_fix'] = $this->Madmin->jml_kp_fix()->num_rows();
        $data['daftar_kp_mhs'] = $this->Madmin->daftar_kp_mhs();
        $data['daftar_lap_mhs'] = $this->Madmin->daftar_lap_mhs();
        $this->load->view('admin/dashboard/Vdashboard',$data);
    }
    public function dashboard_data_post()
    {
        $page = filter_var($this->input->get('page'), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        $data['dashboard'] = $this->Madmin->dashboard($page);
        $data['stt_post'] = $this->Madmin->t_dashboard()->num_rows();
        $this->load->view('admin/dashboard/Vdashboard_post',$data);
    }
    public function input_dashboard()
    {
        $isi = $this->input->post('isi');
        if (!empty($_FILES['userFiles']['name']))
        {
            $id = $this->Madmin->input_dashboard($isi);
            $n = 20;
            $filesCount = count($_FILES['userFiles']['name']);
            for($i = 0; $i < $filesCount; $i++)
            {
                $aKod = NULL;
                $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
                for ($j=0;$j<$n;$j++)
                {
                    $acakAngka = rand(1, strlen($kode));
                    $aKod .= substr($kode, $acakAngka, 1);
                }
                $_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

                $uploadPath = './assets/document/file/dashboard/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = '*';
                $config['file_name'] = $aKod;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $nama = $fileData['file_name'];
                    $size = $fileData['file_size'];
                    $tipe = $fileData['file_type'];
                    if ($tipe == "image/jpeg" || $tipe == "image/png" || $tipe == "image/jpg") {
                        $image_data = $this->upload->data();
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $image_data['full_path'];
                        $config['maintain_ratio'] = TRUE;
                        $config['width'] = 822;
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    $stmt = $this->Madmin->input_dashboard_files($id,$nama,$size,$tipe);
                    //echo $nama."-".$size."-".$tipe;
                }
            }
            if ($stmt)
            { echo "1"; }
            else
            { echo "0"; }
        }
        else {
            $stmt = $this->Madmin->input_dashboard($isi);
            if ($stmt)
            { echo "1"; }
            else
            { echo "0"; }
        }
    }
    public function hapus_dashboard_files()
    {
        $id = $this->input->post('id');
        $result = $this->Madmin->cek_dashboard_files($id);
        if ($result->num_rows() >= 1)
        {
            foreach ($result->result() as $a)
            {
                unlink("./assets/document/file/dashboard/$a->nama");
            }
        }
        $stmt = $this->Madmin->hapus_dashboard_files($id);
        if ($stmt)
        { echo "1"; }
        else
        { echo "0"; }
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
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vkp',$data);
    }
    public function dashboard_tabel_kp()
    {

        $this->load->view('dosen/dashboard/Vkp_index');
    }
    public function dashboard_table_mhs()
    {
        $data['daftar_mahasiswa_kp'] = $this->Mmahasiswa->daftar_mahasiswa_kp();
        $this->load->view('admin/dashboard/Vtmhs',$data);
    }
    public function dashboard_table_lap()
    {
        $data['daftar_lap_kp'] = $this->Mmahasiswa->daftar_lap_kp();
        $this->load->view('admin/dashboard/Vtlap',$data);
    }
    public function Profil()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vprofil',$data);
    }
    public function profil_admin()
    {
        $niy = $this->session->userdata('niy');
        $result = $this->Madmin->detail_admin($niy)->result();
        foreach ($result as $a)
        {
            $data['id_admin'] = $a->id_admin;
            $data['niy'] = $a->niy;
            $data['foto'] = $a->foto_admin;
            $data['nama_admin'] = $a->nama_admin;
            $data['username_admin'] = $a->username_admin;
            $data['jabatan'] = $a->jabatan;
            $data['agama'] = $a->agama;
            $data['sex'] = $a->sex;
            $data['tgl_lahir'] = $a->tgl_lahir;
            $data['bln_lahir'] = $a->bln_lahir;
            $data['thn_lahir'] = $a->thn_lahir;
            $data['email'] = $a->email;
            $data['alamat'] = $a->alamat;
            $data['golongan_darah'] = $a->golongan_darah;
            $data['mdate'] = $a->mdate;
        }
        $this->load->view('admin/profil/Vprofil',$data);
    }
    public function Daftar_Pembimbing()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vdaftar_pembimbing',$data);
    }
    public function daftar_pembimbing_dosen()
    {
        $data['daftar'] = $this->Madmin->daftar_pembimbing_dosen();
        $this->load->view('admin/document/Vdaftar_pembimbing_dosen',$data);
    }
    public function daftar_pembimbing_arsipkan(){
        $id_pembimbing = $this->input->post('id_pembimbing');
        for ($i=0; $i < count($id_pembimbing); $i++) {
            list($id_pembimbing_mahasiswa, $mahasiswa, $dosen) = explode('/', $id_pembimbing[$i]);
            $stmt = $this->Madmin->daftar_pembimbing_arsipkan($id_pembimbing_mahasiswa,$mahasiswa,$dosen);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function Daftar_Dosen()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vdaftar_dosen',$data);
    }
    public function daftar_dosen_data()
    {
        $data['page'] = $this->input->get('page');
        if ($data['page'] == "list")
        {
            $data['daftar'] = $this->Madmin->daftar_dosen_data();
        }
        if ($data['page'] == "ubah")
        {
            $id = $this->input->get('id');
            $data['daftar'] = $this->Mmahasiswa->detail_dosen($id);
        }
        $this->load->view('admin/document/Vdaftar_dosen',$data);
    }
    public function daftar_dosen_arsipkan(){
        $id_dosen = $this->input->post('id_dosen');
        for ($i=0; $i < count($id_dosen); $i++) {
            list($id, $dosen) = explode('/', $id_dosen[$i]);
            $stmt = $this->Madmin->daftar_dosen_arsipkan($id,$dosen);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function input_tambah_dosen()
    {
        $n = 20;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $jabatan = $this->input->post('jabatan');
        $agama = $this->input->post('agama');
        $tgl = $this->input->post('tgl');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $sex = $this->input->post('sex');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $no_wa = $this->input->post('no_wa');
        $alamat = $this->input->post('alamat');
        $password = md5($id);
        $img = null;
        if (empty($_FILES['img']['name'])){
            $stmt = $this->Madmin->input_tambah_dosen($id,$password,$nama,$jabatan,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$img,$no_hp,$no_wa);
            if ($stmt)
            {echo "1";}
            else
            { echo "0"; }
        } else {
            $config['upload_path'] = './assets/document/img/dosen/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']	= '1000';
            $config['file_name'] = $id."-".$aKod;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('img'))
            {
                //echo $this->upload->display_errors();
                echo "2";
            }
            else
            {
                $fn = $this->upload->data();
                $img = $fn['file_name'];
                $image_data = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $image_data['full_path'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 822;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $stmt = $this->Madmin->input_tambah_dosen($id,$password,$nama,$jabatan,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$img);
                if ($stmt)
                {echo "1";}
                else
                { echo "0"; }
            }
        }
    }
    public function input_hapus_dosen()
    {
        $id = $this->input->post('id');
        $stmt = $this->Madmin->input_hapus_dosen($id);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function input_ubahimg_dosen()
    {
        $n = 20;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $nmimg = $this->input->post('nmimg');
        $config['upload_path'] = './assets/document/img/dosen/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']	= '1000';
        $config['file_name'] = $id."-".$aKod;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('img'))
        {
            // $this->upload->display_errors();
            echo "2";
        }
        else
        {
            if (!empty($nmimg))
            {
                unlink("./assets/document/img/dosen/$nmimg");
            }
            $fn = $this->upload->data();
            $img = $fn['file_name'];
            $image_data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 822;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $stmt = $this->Madmin->input_ubahimg_dosen($id,$img);
            if ($stmt)
            {echo "1";}
            else
            { echo "3"; }
        }
    }
    public function input_ubahpass_dosen()
    {
        $id = $this->input->post('id');
        $pass = $this->input->post('pass');
        $password = md5($pass);
        $stmt = $this->Madmin->input_ubahpass_dosen($id,$password);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function input_ubahprofil_dosen()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $jabatan = $this->input->post('jabatan');
        $agama = $this->input->post('agama');
        $tgl = $this->input->post('tgl');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $sex = $this->input->post('sex');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $no_wa = $this->input->post('no_wa');
        $alamat = $this->input->post('alamat');
        $stmt = $this->Madmin->input_ubahprofil_dosen($id,$nama,$jabatan,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$no_hp,$no_wa);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function Daftar_Mahasiswa()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vdaftar_mahasiswa',$data);
    }
    public function daftar_mahasiswa_data()
    {
        $data['page'] = $this->input->get('page');
        if ($data['page'] == "list")
        {
            $data['daftar'] = $this->Madmin->daftar_mahasiswa_data();
        }
        if ($data['page'] == "ubah")
        {
            $id = $this->input->get('id');
            $data['daftar'] = $this->Mmahasiswa->detail_mahasiswa($id);
        }
        $this->load->view('admin/document/Vdaftar_mahasiswa',$data);
    }
    public function daftar_mahasiswa_arsipkan(){
        $id_mahasiswa = $this->input->post('id_mahasiswa');
        for ($i=0; $i < count($id_mahasiswa); $i++) {
            list($id, $mahasiswa) = explode('/', $id_mahasiswa[$i]);
            $stmt = $this->Madmin->daftar_mahasiswa_arsipkan($id,$mahasiswa);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function input_tambah_mahasiswa()
    {
        $n = 20;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $agama = $this->input->post('agama');
        $tgl = $this->input->post('tgl');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $sex = $this->input->post('sex');
        $no_hp = $this->input->post('no_hp');
        $no_wa = $this->input->post('no_wa');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $angkatan = $this->input->post('angkatan');
        $password = md5($id);
        $img = null;
        if (empty($_FILES['img']['name']))
        {
            $stmt = $this->Madmin->input_tambah_mahasiswa($id,$password,$nama,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$img,$angkatan,$no_hp,$no_wa);
            if ($stmt)
            {echo "1";}
            else
            { echo "0"; }
        } else {
            $config['upload_path'] = './assets/document/img/mahasiswa/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']	= '1000';
            $config['file_name'] = $id."-".$aKod;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('img'))
            {
                //echo $this->upload->display_errors();
                echo "2";
            }
            else
            {
                $fn = $this->upload->data();
                $img = $fn['file_name'];
                $image_data = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = $image_data['full_path'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 822;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $stmt = $this->Madmin->input_tambah_mahasiswa($id,$password,$nama,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$img,$angkatan,$no_hp,$no_wa);
                if ($stmt)
                {echo "1";}
                else
                { echo "0"; }
            }
        }
    }
    public function input_hapus_mahasiswa()
    {
        $id = $this->input->post('id');
        $stmt = $this->Madmin->input_hapus_mahasiswa($id);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function input_ubahimg_mahasiswa()
    {
        $n = 20;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $nmimg = $this->input->post('nmimg');
        $config['upload_path'] = './assets/document/img/mahasiswa/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']	= '1000';
        $config['file_name'] = $id."-".$aKod;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('img'))
        {
            // $this->upload->display_errors();
            echo "2";
        }
        else
        {
            if (!empty($nmimg))
            {
                unlink("./assets/document/img/mahasiswa/$nmimg");
            }
            $fn = $this->upload->data();
            $img = $fn['file_name'];
            $image_data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 822;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $stmt = $this->Madmin->input_ubahimg_mahasiswa($id,$img);
            if ($stmt)
            {echo "1";}
            else
            { echo "0"; }
        }
    }
    public function input_ubahpass_mahasiswa()
    {
        $id = $this->input->post('id');
        $pass = $this->input->post('pass');
        $password = md5($pass);
        $stmt = $this->Madmin->input_ubahpass_mahasiswa($id,$password);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function input_ubahprofil_mahasiswa()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $agama = $this->input->post('agama');
        $tgl = $this->input->post('tgl');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $sex = $this->input->post('sex');
        $no_hp = $this->input->post('no_hp');
        $no_wa = $this->input->post('no_wa');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $gol_drh = $this->input->post('gol_drh');
        $angkatan = $this->input->post('angkatan');
        $stmt = $this->Madmin->input_ubahprofil_mahasiswa($id,$nama,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$gol_drh,$angkatan,$no_hp,$no_wa);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function Daftar_Wilayah()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vdaftar_wilayah',$data);
    }
    public function daftar_wilayah_data(){
        $data['page'] = $this->input->get('page');
        if ($data['page']=="edit"){
            $data['data'] = $this->Madmin->wilayah_detail($this->input->get('id'))->row();
        }
        $this->load->view('admin/document/Vdaftar_wilayah',$data);
    }
    public function daftar_wilayah_json(){
        $post = $this->input->post();
        $where['deleted_flage']     = "1";
        $result = array();
        $length         = $post['length'];
        $start          = $post['start'];
        $search         = $post['search']['value'];
        $stmt_1 = $this->Madmin->daftar_wilayah($length,$start,$where,$search)->result();
        $stmt_2 = $this->Madmin->daftar_wilayah(NULL,NULL,$where,$search)->num_rows();
        foreach ($stmt_1 as $item){
            array_push($result,
                array(
                    'id_wilayah'=>$item->id_wilayah,
                    'wilayah'=>$item->wilayah,
                    'cdate'=>waktu_lalu2($item->cdate)
                )
            );
        }
        $response = array('draw'    => $post['draw'],
            'recordsTotal'          => $stmt_2,
            'recordsFiltered'       => $stmt_2,
            'data'                  => $result);
        setJSON($response);
    }
    public function input_hapus_wilayah()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $wilayah = $post['wilayah'];
        $stmt = $this->Madmin->input_hapus_wilayah($id,$wilayah);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function input_ubah_wilayah(){
        $post = $this->input->post();
        $id = $post['id'];
        $wilayah = $post['wilayah'];
        $stmt = $this->Madmin->input_ubah_wilayah($id,$wilayah);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function input_tambah_wilayah()
    {
        $wilayah = $this->input->post('wilayah');
        $stmt = $this->Madmin->input_tambah_wilayah($wilayah);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function Daftar_Bidang_Kerja()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vdaftar_bidang_kerja',$data);
    }
    public function daftar_bidang_kerja_data(){
        $data['page'] = $this->input->get('page');
        if ($data['page']=="edit"){
            $data['data'] = $this->Madmin->bidang_kerja_detail($this->input->get('id'))->row();
        }
        $this->load->view('admin/document/Vdaftar_bidang_kerja',$data);
    }
    public function daftar_bidang_kerja_json(){
        $post = $this->input->post();
        $where['deleted_flage']     = "1";
        $result = array();
        $length         = $post['length'];
        $start          = $post['start'];
        $search         = $post['search']['value'];
        $stmt_1 = $this->Madmin->daftar_bidang_kerja($length,$start,$where,$search)->result();
        $stmt_2 = $this->Madmin->daftar_bidang_kerja(NULL,NULL,$where,$search)->num_rows();
        foreach ($stmt_1 as $item){
            array_push($result,
                array(
                    'id_bidang_kerja'=>$item->id_bidang_kerja,
                    'bidang_kerja'=>$item->bidang_kerja,
                    'cdate'=>waktu_lalu2($item->cdate)
                )
            );
        }
        $response = array('draw'    => $post['draw'],
            'recordsTotal'          => $stmt_2,
            'recordsFiltered'       => $stmt_2,
            'data'                  => $result);
        setJSON($response);
    }
    public function input_hapus_bidang_kerja()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $bidang_kerja = $post['bidang_kerja'];
        $stmt = $this->Madmin->input_hapus_bidang_kerja($id,$bidang_kerja);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function input_ubah_bidang_kerja(){
        $post = $this->input->post();
        $id = $post['id'];
        $bidang_kerja = $post['bidang_kerja'];
        $stmt = $this->Madmin->input_ubah_bidang_kerja($id,$bidang_kerja);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function input_tambah_bidang_kerja()
    {
        $bidang_kerja = $this->input->post('bidang_kerja');
        $stmt = $this->Madmin->input_tambah_bidang_kerja($bidang_kerja);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function Konfirmasi_KP()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vkonfirmasi_kp',$data);
    }
    public function konfirmasi_daftar_kp()
    {
        $data['daftar_kp'] = $this->Madmin->konfirmasi_daftar_kp();
        $this->load->view('admin/konfirmasi/Vkonfirmasi_kp',$data);
    }
    public function input_hapus_idkp()
    {
        $idkp = $this->input->post('idkp');
        $result = $this->Madmin->cek_sikp($idkp)->result();
        foreach ($result as $a)
        {
            if (!empty($a->nama_file))
            {
                unlink("./assets/document/file/surat_terima_perusahaan/$a->nama_file");
            }
        }
        $stmt = $this->Madmin->input_hapus_idkp($idkp);
        if($stmt)
        { echo "1"; }
        else { echo "0"; }
    }
    public function input_konfirm_idkp()
    {
        $idkp = $this->input->post('idkp');
        $stmt = $this->Madmin->input_konfirm_idkp($idkp);
        if($stmt)
        { echo "1"; }
        else { echo "0"; }
    }
    public function Konfirmasi_Pembimbing()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vkonfirmasi_pembimbing',$data);
    }
    public function konfirmasi_pembimbing_data()
    {
        $data['daftar'] = $this->Madmin->konfirmasi_pembimbing();
        $this->load->view('admin/konfirmasi/Vkonfirmasi_pembimbing',$data);
    }
    public function input_konfirmasi_pembimbing()
    {
        $id = $this->input->post('id');
        $pilih = $this->input->post('pilih');
        $id_pembimbing = $this->Madmin->input_konfirmasi_pembimbing_pembimbing($id);
        foreach ($pilih as $a)
        {
            if ($a['pilih'] != "0")
            {
                $iddosen = $a['pilih'];
                $stmt = $this->Madmin->input_konfirmasi_pembimbing_dosen($iddosen,$id_pembimbing);
            }
        }
        if ($stmt)
        {
            $result = $this->Madmin->daftar_anggota_kp($id);
            foreach ($result->result() as $b)
            {
                $idmhs = $b->id_mahasiswa;
                $stmt2 = $this->Madmin->input_konfirmasi_pembimbing_lap_kp_mhs($id,$idmhs,$id_pembimbing);
            }
            if ($stmt2)
            {   echo "1"; }
            else
            { echo "0"; }
        }
        else
        { echo "0"; }
    }
    public function download_srt_pers()
    {
        $nm = $this->uri->segment('3');
        force_download('assets/document/file/surat_terima_perusahaan/'.$nm,NULL);
    }
    public function download_dashboard()
    {
        $nm = $this->uri->segment('3');
        force_download('assets/document/file/dashboard/'.$nm,NULL);
    }
    public function Konfirmasi_Laporan_KP()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vkonfirmasi_laporan',$data);
    }
    public function konfirmasi_laporan_data()
    {
        $data['daftar'] = $this->Madmin->konfirmasi_laporan_data();
        $this->load->view('admin/konfirmasi/Vkonfirmasi_laporan',$data);
    }
    public function input_konfirmasi_lap_kp()
    {
        $idlap = $this->input->post('idlap');
        $idkp = $this->input->post('idkp');
        $stmt = $this->Madmin->input_konfirmasi_lap_kp($idlap,$idkp);
        if ($stmt)
        { echo "1"; }
        else
        { echo "0"; }
    }
    public function Deskripsi_KP()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vsetelan_deskripsi',$data);
    }
    public function setelan_desk_kp()
    {
        $result = $this->Madmin->deskripsi_kp();
        $data['isi'] = "";
        $data['cdate'] = "";
        $data['id_deskripsi_kp'] = "";
        foreach ($result->result() as $a) {
            $data['isi'] = $a->isi;
            $data['cdate'] = $a->cdate;
            $data['id_deskripsi_kp'] = $a->id_deskripsi_kp;
        }
        $this->load->view('admin/setelan/Vsetelan_desk_kp',$data);
    }
    public function input_ubah_deskripsi()
    {
        $id = $this->input->post('id');
        $isi = $this->input->post('isi');
        $stmt = $this->Madmin->input_ubah_deskripsi($id,$isi);
        if ($stmt)
        { echo "1"; }
        else
        { echo "0"; }
    }
    public function Surat_Ijin_KP()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vsetelan_sikp',$data);
    }
    public function setelan_sikp()
    {
        $result = $this->Mmahasiswa->sikp()->result();
        $data['nomor_surat'] = "";
        $data['tgl_mulai'] = "";
        $data['jml_hari'] = "";
        $data['email_d4'] = "";
        $data['cdate'] = "";
        $data['id'] = "";
        foreach ($result as $a) {
            $data['nomor_surat'] = $a->nomor_surat;
            $data['tgl_mulai'] = $a->tgl_mulai;
            $data['jml_hari'] = $a->jml_hari;
            $data['email_d4'] = $a->email_d4;
            $data['cdate'] = $a->cdate;
            $data['id'] = $a->id_surat_ijin_kp;
            $nomor_surat_keluar = $a->nomor_surat_keluar;
            $jml_nomor_surat_keluar = strlen($nomor_surat_keluar);
            if($jml_nomor_surat_keluar == 1){
                $nomor_surat_keluar = "00".$nomor_surat_keluar;
            } else if ($jml_nomor_surat_keluar == 2){
                $nomor_surat_keluar = "0".$nomor_surat_keluar;
            } else{
                $nomor_surat_keluar = $nomor_surat_keluar;
            }
            $data['nomor_surat_terakhir'] = $nomor_surat_keluar;
        }
        $this->load->view('admin/setelan/Vsetelan_sikp',$data);
    }
    public function input_ubah_sikp()
    {
        $id = $this->input->post('id');
        $nomor = $this->input->post('nomor');
        $jumlah = $this->input->post('jumlah');
        $tgl_mulai = $this->input->post('tgl_mulai');
        $email = $this->input->post('email');
        $stmt = $this->Madmin->input_ubah_sikp($id,$nomor,$jumlah,$tgl_mulai,$email);
        if ($stmt)
        { echo "1"; }
        else
        { echo "0"; }
    }
    public function Sampul_Sliding()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vsetelan_sampul_sliding',$data);
    }
    public function setelan_sampul_slide()
    {
        $data['data'] = $this->Madmin->sampul_sliding();
        $this->load->view('admin/setelan/Vsetelan_sampul_sliding',$data);
    }
    public function input_sampul_sliding()
    {
        $n = 20;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        $config['upload_path'] = './assets/document/img/sampul_sliding/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']	= '5000';
        $config['file_name'] = $aKod;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('img'))
        {
            // $this->upload->display_errors();
            echo "2";
        }
        else
        {
            $fn = $this->upload->data();
            $img = $fn['file_name'];
            $image_data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 822;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $stmt = $this->Madmin->input_sampul_sliding($img);
            if ($stmt)
            {echo "1";}
            else
            { echo "0"; }
        }
    }
    public function hapus_sampul_sliding()
    {
        $id = $this->input->post('id');
        $img = $this->input->post('img');
        if (!empty($img))
        {
            unlink("./assets/document/img/sampul_sliding/$img");
        }
        $stmt = $this->Madmin->hapus_sampul_sliding($id);
        if($stmt)
        { echo "1"; }
        else { echo "0"; }
    }
    public function Sampul_Galeri()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vsetelan_sampul_galeri',$data);
    }
    public function setelan_sampul_galeri()
    {
        $data['data'] = $this->Madmin->sampul_galeri();
        $this->load->view('admin/setelan/Vsetelan_sampul_galeri',$data);
    }
    public function input_sampul_galeri()
    {
        $n = 20;
        $aKod = NULL;
        $kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
        for ($i=0;$i<$n;$i++)
        {
            $acakAngka = rand(1, strlen($kode));
            $aKod .= substr($kode, $acakAngka, 1);
        }
        $config['upload_path'] = './assets/document/img/gallery/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']	= '5000';
        $config['file_name'] = $aKod;
        $nama = $this->input->post('nama');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('img'))
        {
            //echo $this->upload->display_errors();
            echo "2";
        }
        else
        {
            $fn = $this->upload->data();
            $img = $fn['file_name'];
            $size = $fn['file_size'];
            $tipe = $fn['file_type'];
            $image_data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 822;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $stmt = $this->Madmin->input_sampul_galeri($img,$nama,$size,$tipe);
            if ($stmt)
            {echo "1";}
            else
            { echo "0"; }
        }
    }
    public function hapus_sampul_galeri()
    {
        $id = $this->input->post('id');
        $img = $this->input->post('img');
        if (!empty($img))
        {
            unlink("./assets/document/img/gallery/$img");
        }
        $stmt = $this->Madmin->hapus_sampul_galeri($id);
        if($stmt)
        { echo "1"; }
        else { echo "0"; }
    }
    public function Sosial_Link()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vsetelan_sosial_link',$data);
    }
    public function setelan_sosial_link()
    {
        $data['data'] = $this->Madmin->sosial_link();
        $this->load->view('admin/setelan/Vsetelan_sosial_link',$data);
    }
    public function input_sosial_link()
    {
        $link = $this->input->post('link');
        $icon = $this->input->post('icon');
        $stmt = $this->Madmin->input_sosial_link($link,$icon);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function ubah_sosial_link()
    {
        $link = $this->input->post('link');
        $icon = $this->input->post('icon');
        $id = $this->input->post('id');
        $stmt = $this->Madmin->ubah_sosial_link($link,$icon,$id);
        if ($stmt)
        {echo "1";}
        else
        { echo "0"; }
    }
    public function hapus_sosial_link()
    {
        $id = $this->input->post('id');
        $stmt = $this->Madmin->hapus_sosial_link($id);
        if($stmt)
        { echo "1"; }
        else { echo "0"; }
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
        $config['upload_path'] = './assets/document/img/admin/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']	= '1000';
        $config['file_name'] = $aKod;
        $this->upload->initialize($config);
        $id = $this->input->post('id');
        $img2 = $this->input->post('img2');
        if (!$this->upload->do_upload('img'))
        { echo "2"; }
        else
        {
            if (!empty($img2))
            {
                unlink("./assets/document/img/admin/$img2");
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
            $stmt = $this->Madmin->input_ubah_img_admin($nama,$id);
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
    public function input_ubah_biodata_admin()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $niy = $this->input->post('niy');
        $data = array(
            'nama_admin'=>$nama,
            'niy'=>$niy,
            'jabatan'=>$this->input->post('jabatan'),
            'username_admin'=>$this->input->post('username'),
            'agama'=>$this->input->post('agama'),
            'sex'=>$this->input->post('sex'),
            'tgl_lahir'=>$this->input->post('tgl'),
            'bln_lahir'=>$this->input->post('bln'),
            'thn_lahir'=>$this->input->post('thn'),
            'email'=>$this->input->post('email'),
            'alamat'=>$this->input->post('alamat'),
            'mdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->Madmin->input_ubah_biodata_admin($id,$data);
        if ($stmt)
        {
            $data_session = array('nama'=>$nama,'niy'=>$niy);
            $this->session->set_userdata($data_session);
            echo "1";}
        else
        { echo "0"; }
    }
    public function input_ubah_pass_admin()
    {
        $niy = $this->input->post('niy');
        $passl = $this->input->post('passl');
        $passwordl = md5($passl);
        $passb = $this->input->post('passb');
        $passwordb = md5($passb);
        $result = $this->Madmin->detail_admin($niy)->result();
        foreach ($result as $a)
        {
            if ($passwordl == $a->password)
            {
                $stmt = $this->Madmin->input_ubah_pass_admin($niy,$passwordb);
                if ($stmt)
                { echo "1";}
                else
                { echo "0";}
            }
            else
            { echo "2";}
        }
    }
    public function Catatan_Aktivitas()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vsistem_catatan_aktivitas',$data);
    }
    public function catatan_aktivitas_data()
    {
        $post = $this->input->post();
        $where['deleted_flage']     = "1";
        $result = array();
        $length         = $post['length'];
        $start          = $post['start'];
        $search         = $post['search']['value'];
        $stmt_1 = $this->Madmin->catatan_aktivitas($length,$start,$where,$search)->result();
        $stmt_2 = $this->Madmin->catatan_aktivitas(NULL,NULL,$where,$search)->num_rows();
        foreach ($stmt_1 as $item){
            array_push($result,
                array(
                    'id'=>$item->id,
                    'ket'=>$item->ket,
                    'cdate'=>waktu_lalu2($item->cdate)
                )
            );
        }
        $response = array('draw'    => $post['draw'],
            'recordsTotal'          => $stmt_2,
            'recordsFiltered'       => $stmt_2,
            'data'                  => $result);
        setJSON($response);
    }
    public function hapus_catatan_aktivitas()
    {
        $stmt = $this->Madmin->hapus_catatan_aktivitas();
        if ($stmt)
        { echo "1";}
        else
        { echo "0";}
    }
    public function Dosen_Terhapus()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vsistem_dosen',$data);
    }
    public function sistem_dosen_data()
    {
        $data['data'] = $this->Madmin->sistem_dosen();
        $this->load->view('admin/sistem/Vsistem_dosen',$data);
    }
    public function sistem_aktif_dosen()
    {
        $id = $this->input->post('id');
        $stmt = $this->Madmin->sistem_aktif_dosen($id);
        if ($stmt)
        { echo "1";}
        else
        { echo "0";}
    }
    public function sistem_hapus_dosen()
    {
        $id = $this->input->post('id');
        $img = $this->input->post('img');
        if (!empty($img))
        {
            unlink("./assets/document/img/dosen/$img");
        }
        $stmt = $this->Madmin->sistem_hapus_dosen($id);
        if ($stmt)
        { echo "1";}
        else
        { echo "0";}
    }
    public function dosen_terhapus_proses(){
        $data_dosen = $this->input->post('data_dosen');
        $type = $this->input->post('type');
        for ($i=0; $i < count($data_dosen); $i++) {
            list($id_dosen, $nama_dosen, $foto_dosen) = explode('/', $data_dosen[$i]);
            if ($type=="delete"){
                if (!empty($foto_dosen) || $foto_dosen != "0") {
                    unlink("./assets/document/img/dosen/$foto_dosen");
                }
            }
            $stmt = $this->Madmin->dosen_terhapus_proses($id_dosen,$nama_dosen,$type);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function Mahasiswa_Terhapus()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $this->load->view('admin/Vsistem_mahasiswa',$data);
    }
    public function sistem_mahasiswa_data()
    {
        $data['data'] = $this->Madmin->sistem_mahasiswa();
        $this->load->view('admin/sistem/Vsistem_mahasiswa',$data);
    }
    public function mahasiswa_terhapus_proses(){
        $data_mahasiswa = $this->input->post('data_mahasiswa');
        $type = $this->input->post('type');
        for ($i=0; $i < count($data_mahasiswa); $i++) {
            list($id_mahasiswa, $nama_mahasiswa, $foto_mahasiswa) = explode('/', $data_mahasiswa[$i]);
            if ($type=="delete"){
                if (!empty($foto_mahasiswa) || $foto_mahasiswa != "0") {
                    unlink("./assets/document/img/mahasiswa/$foto_mahasiswa");
                }
            }
            $stmt = $this->Madmin->mahasiswa_terhapus_proses($id_mahasiswa,$nama_mahasiswa,$type);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
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
        elseif ($data['page'] == "detaildsn")
        {
            $data['daftar'] = $this->Mmahasiswa->detail_dosen($id);
            $this->load->view('style/Vmodal',$data);
        }
        elseif ($data['page'] == "detailkp")
        {
            $data['daftar'] = $this->Mmahasiswa->detail_kp($id);
            $this->load->view('style/Vmodal',$data);
        }
        elseif ($data['page'] == "tmbhpmb")
        {
            $data['nm'] = $this->input->get('nm');
            $data['id'] = $id;
            $data['daftar'] = $this->Madmin->daftar_dosen_data();
            $this->load->view('style/Vmodal',$data);
        }
        elseif ($data['page'] == "ubah_sosial_link")
        {
            $data['id'] = $this->input->get('id');
            $data['icon'] = $this->input->get('icon');
            $data['link'] = $this->input->get('link');
            $this->load->view('style/Vmodal',$data);
        }
        elseif ($data['page'] == "detail_img")
        {
            $result = $this->Mmahasiswa->detail_img_dashboard($id);
            foreach ($result->result() as $a) {
                $data['file'] = $a->file;
                $data['tipe'] = $a->tipe;
                $data['img'] = "assets/document/file/dashboard/".$a->file;
            }
            $this->load->view('style/Vmodal',$data);
        }
        else
        {
            $this->load->view('style/Vmodal',$data);
        }
    }
    function logout()
    {
        $id = $this->session->userdata('id');
        $stmt = $this->Mmahasiswa->logout_adm($id);
        if ($stmt)
        {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }
    public function Daftar_KP()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $segment = $this->uri->segment(3);
        if (empty($segment)) {
            $this->load->view('admin/Vdaftar_kp',$data);
        } else if (!empty($segment)) {
            if ($segment=="detailkp"){
                $idkp = $this->input->get('idkp');
                $data['data']       = $this->Mmahasiswa->detail_kp($idkp)->row();
                $data['pembimbing'] = $this->Mmahasiswa->daftar_pembimbing_kp($idkp);
                $data['bid_kerja'] = $this->Mmahasiswa->bidang_kerja();
                $data['wilayah'] = $this->Mmahasiswa->wilayah();
                $this->load->view('admin/document/Vdaftar_kp_detail',$data);
            } else {
                $data['segment'] = $segment;
                $this->load->view('admin/Vagenda_kp_mhs',$data);
            }
        }
    }
    public function daftar_kp_data()
    {
        $data['daftar'] = $this->Madmin->daftar_kp_data();
        $this->load->view('admin/document/Vdaftar_kp',$data);
    }
    public function hapus_kp()
    {
        $data_pembimbing = array();
        $id_pembimbing = null;
        $id_kp_laporan = null;
        $id_kp = $this->input->post('id_kp');
        $result = $this->Madmin->get_id_pembimbing($id_kp);
        foreach ($result->result() as $a) {
            $id_pembimbing = $a->id_pembimbing;
        }
        $result2 = $this->Madmin->get_kp_mahasiswa($id_kp);
        foreach ($result2->result() as $a) {
            $id_mahasiswa = $a->id_mahasiswa;
            $result4 = $this->Madmin->get_pembimbing_kp($id_pembimbing);
            foreach ($result4->result() as $c) {
                $this->Madmin->no_read_chat_bo($id_mahasiswa,$c->id_dosen);
            }
            $this->Madmin->del_pembimbing_dosen($id_pembimbing);
            $this->Madmin->del_pembimbing_mahasiswa($id_pembimbing);
        }
        $this->Madmin->del_kp_laporan($id_kp);
        $result5 = $this->Madmin->get_kp_perusahaan($id_kp);
        foreach ($result5->result() as $a) {
            if (!empty($a->nama_file))
            {
                unlink("./assets/document/file/surat_terima_perusahaan/$a->nama_file");
            }
        }
        $this->Madmin->del_kp_perusahaan($id_kp);
        $this->Madmin->del_kp_harian($id_kp);
        $this->Madmin->del_kp_bimbingan($id_kp);
        $this->Madmin->del_kp_anggota($id_kp);
        $this->Madmin->del_pembimbing($id_kp);
        $stmt = $this->Madmin->del_kp($id_kp);
        if ($stmt) {
            echo "1";
        } else {
            echo "0";
        }
    }
    public function daftar_kp_arsipkan(){
        $id_kp = $this->input->post('id_kp');
        for ($i=0; $i < count($id_kp); $i++) {
            $stmt = $this->Madmin->daftar_kp_arsipkan($id_kp[$i]);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function agenda_kp_mhs_index()
    {
        $this->load->view('admin/document/Vagenda_kp_mhs_index');
    }
    public function agenda_kp_mhs_index_data()
    {
        $data['nim'] = $this->input->get('nim');
        $data['page'] = $this->input->get('page');
        if ($data['page'] == "agenda_detail_mahasiswa")
        {
            $data['daftar'] = $this->Mmahasiswa->detail_mahasiswa($data['nim']);
        }
        elseif ($data['page'] == "agenda_kp_harian")
        {
            $data['data'] = $this->Mmahasiswa->data_kp_harian($data['nim']);
            $data['data_kp'] = $this->Mmahasiswa->data_kp($data['nim']);
        }
        elseif ($data['page'] == "agenda_kp_bimbingan")
        {
            $data['data'] = $this->Mmahasiswa->data_kp_bimbingan($data['nim']);
            $data['data_kp'] = $this->Mmahasiswa->data_kp($data['nim']);
        }
        elseif ($data['page'] == "agenda_data_kp")
        {
            $data['data'] = $this->Mmahasiswa->data_perusahaan($data['nim']);
            $data['data_kp'] = $this->Mmahasiswa->data_kp($data['nim']);
        }
        elseif ($data['page'] == "agenda_pembimbing")
        {
            $result = $this->Mmahasiswa->cek_id_kp($data['nim']);
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
        }
        $this->load->view('admin/document/Vagenda_kp_mhs_index_data',$data);
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
        $idkp = $this->input->post('id');

        if ($bid_kerja == "1"){
            $bid_kerja = $this->Mmahasiswa->bidang_kerja_input($bid_kerja_lainnya);
        }
        if ($wilayah == "1"){
            $wilayah = $this->Mmahasiswa->wilayah_input($wilayah_lainnya);
        }

        $data = array('nama_perusahaan'=>$nm_pers,'deskripsi'=>$desk_pers,'alamat'=>$almt_pers,'id_bidang_kerja'=>$bid_kerja,'id_wilayah'=>$wilayah);
        $stmt = $this->Mmahasiswa->input_dt_pers($data,$idkp,"(Perubahan dari Admin)");
        if ($stmt)
        { echo "1";}
        else
        { echo "0";}
    }

    public function input_dokumen_pers()
    {
        $idkp = $this->input->post('id');
        $nm_file = $this->input->post('nama_file');
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
            $stmt = $this->Mmahasiswa->input_dokumen_pers($nama,$b,$c,$idkp,"(Perubahan dari Admin)");
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

    public function data_kp_rekap()
    {
        $type = $this->input->get('type');
        if ($type=="PDF"){
            $result4 = $this->Mmahasiswa->sikp();
            foreach ($result4->result() as $a)
            {
                $email = $a->email_d4;
            }

            $this->load->helper('print_data_kp_helper');
            $pdf = new Print_DATA_KP();
            $pdf->AddPage('L','A4');
            $pdf->SetAutoPageBreak(false);
            $pdf->AliasNbPages();
            $pdf->judul('Yayasan Pendidikan Harapan Bersama', 'PoliTeknik Harapan Bersama','PROGRAM STUDI D IV TEKNIK INFORMATIKA','Kampus I : Jl. Mataram No. 9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 'Website: informatika.poltektegal.ac.id        E-Mail: '.$email);
            $pdf->garis();
            $pdf->teks2();
            $pdf->table();
            $pdf->Output("Data Mahasiswa Kerja Praktik Tahun ".date('Y').".pdf","I");
        } elseif ($type=="Excel"){
            $this->load->library('Excel_generator');

            $excel = new PHPExcel();
            $excel->getProperties()->setCreator('My Notes Code')
                ->setLastModifiedBy('My Notes Code')
                ->setTitle("Data Mahasiswa KP")
                ->setSubject("Data Mahasiswa KP")
                ->setDescription("Data Mahasiswa KP")
                ->setKeywords("Data Mahasiswa KP");

            // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
            $style_col = array(  'font' => array('bold' => true), // Set font nya jadi bold
                'alignment' => array(    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = array(
                'alignment' => array(    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA MAHASISWA KP"); // Set kolom A1 dengan tulisan "DATA SISWA"
            $excel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai F1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

            // Buat header tabel nya pada baris ke 3
            $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B3', "Wilayah");
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "Bidang Kerja");
            $excel->setActiveSheetIndex(0)->setCellValue('D3', "Nama Perusahaan");
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "Alamat");
            $excel->setActiveSheetIndex(0)->setCellValue('F3', "Tim Mahasiswa");
            $excel->setActiveSheetIndex(0)->setCellValue('G3', "No HP");
            $excel->setActiveSheetIndex(0)->setCellValue('H3', "No WA");
            $excel->setActiveSheetIndex(0)->setCellValue('I3', "Dosen Pembimbing");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);

            // Set height baris ke 1, 2 dan 3
            $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4

            $wilayah = $this->db->select('wilayah.wilayah, bidang_kerja.bidang_kerja, 
                    kp.id_kp, kp_perusahaan.nama_perusahaan, kp_perusahaan.alamat')
                ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
                ->join('wilayah','wilayah.id_wilayah = kp_perusahaan.id_wilayah')
                ->join('bidang_kerja','bidang_kerja.id_bidang_kerja = kp_perusahaan.id_bidang_kerja')
                ->order_by('wilayah.id_wilayah')
                ->get_where("kp",array('kp.deleted_flage'=>1,'kp.stt_arsip'=>0,'kp.stt'=>"1"));

            $now = 1;

            $data = array();
            $no_wil = 1;
            foreach ($wilayah->result() as $it_wil){
                $tim_dosen = '';
                $dt_dosen = $this->db->select('dosen.*')
                    ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
                    ->join('dosen','dosen.id_dosen = pembimbing_dosen.id_dosen')
                    ->get_where('pembimbing',array('pembimbing.id_kp'=>$it_wil->id_kp,'pembimbing.deleted_flage'=>1))->result();
                foreach ($dt_dosen as $it_d){
                    $tim_dosen .= $it_d->nama_dosen;
                }

                $dt_mhs = $this->db->select('mahasiswa.*')
                    ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')
                    ->get_where('kp_anggota',array('kp_anggota.id_kp'=>$it_wil->id_kp))->result();
                $no_m = 0;
                foreach ($dt_mhs as $itm_mhs){
                    if ($no_m == 0){
                        $data[$no_wil]['no'] = $now;
                        $data[$no_wil]['wilayah'] = $it_wil->wilayah;
                        $data[$no_wil]['bidang_kerja'] = $it_wil->bidang_kerja;
                        $data[$no_wil]['nama_perusahaan'] = $it_wil->nama_perusahaan;
                        $data[$no_wil]['alamat'] = $it_wil->alamat;
                        $data[$no_wil]['tim'] = $itm_mhs->nama_mahasiswa." - ".$itm_mhs->id_mahasiswa;
                        $data[$no_wil]['hp'] = $itm_mhs->no_hp;
                        $data[$no_wil]['wa'] = $itm_mhs->no_wa;
                        $data[$no_wil]['dosen'] = $tim_dosen;
                        $now++;
                    } else {
                        $data[$no_wil]['no'] = "";
                        $data[$no_wil]['wilayah'] = "";
                        $data[$no_wil]['bidang_kerja'] = "";
                        $data[$no_wil]['nama_perusahaan'] = "";
                        $data[$no_wil]['alamat'] = "";
                        $data[$no_wil]['tim'] = $itm_mhs->nama_mahasiswa." - ".$itm_mhs->id_mahasiswa;
                        $data[$no_wil]['hp'] = $itm_mhs->no_hp;
                        $data[$no_wil]['wa'] = $itm_mhs->no_wa;
                        $data[$no_wil]['dosen'] = "";
                    }
                    $no_m++;
                    $no_wil++;
                }
            }

            foreach($data as $item){
                // Ambil semua data dari hasil eksekusi $sql
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $item['no']);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $item['wilayah']);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $item['bidang_kerja']);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $item['nama_perusahaan']);
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $item['alamat']);
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $item['tim']);
                $excel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$numrow, $item['hp'], PHPExcel_Cell_DataType::TYPE_STRING);
                $excel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$numrow, $item['wa'], PHPExcel_Cell_DataType::TYPE_STRING);
                $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $item['dosen']);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

                $no++;// Tambah 1 setiap kali looping
                $numrow++;// Tambah 1 setiap kali looping
            }

            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(100);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(50);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet(0)->setTitle("Data Mahasiswa KP");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Mahasiswa KP.xlsx"');

            // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
    }

    public function Arsip_KP()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $segment = $this->uri->segment(3);
        if (empty($segment)) {
            $data['tahun'] = $this->Madmin->arsip_kp_tahun(array('stt_arsip='=>1,'deleted_flage'=>1))->result();
            $this->load->view('admin/Varsip_kp',$data);
        }
        else if (!empty($segment)) {
            $data['segment'] = $segment;
            $this->load->view('admin/Varsip_agenda_kp_mhs',$data);
        }
    }

    public function arsip_kp_data(){
        $post = $this->input->post();
        $where['kp.deleted_flage']     = "1";
        $where['kp.stt'] = "1";
        $where['kp.stt_arsip'] = "1";
        $where['kp.deleted_flage'] = "1";

        if ($post['tahun'] != "semua"){
            $where['YEAR(kp.cdate)'] = $post['tahun'];
        }

        $result = array();
        $length         = $post['length'];
        $start          = $post['start'];
        $search         = $post['search']['value'];
        $stmt_1 = $this->Madmin->arsip_kp_data($length,$start,$where,$search)->result();
        $stmt_2 = $this->Madmin->arsip_kp_data(NULL,NULL,$where,$search)->num_rows();
        foreach ($stmt_1 as $item){
            $tim_mhs = '';
            foreach (daftar_kp($item->id_kp) as $b){
                $tim_mhs .= $b;
            }
            array_push($result,
                array(
                    'id_kp'=>$item->id_kp,
                    'nama_perusahaan'=>$item->nama_perusahaan,
                    'tim_mahasiswa'=>$tim_mhs,
                    'alamat'=>$item->alamat,
                    'cdate'=>waktu_lalu2($item->cdate)
                )
            );
        }
        $response = array('draw'    => $post['draw'],
            'recordsTotal'          => $stmt_2,
            'recordsFiltered'       => $stmt_2,
            'data'                  => $result);
        setJSON($response);
    }

    public function arsip_kp_rekap()
    {
        $type = $this->input->get('type');
        $tahun = $this->input->get('tahun');
        if ($type=="PDF"){
            $result4 = $this->Mmahasiswa->sikp();
            foreach ($result4->result() as $a)
            {
                $email = $a->email_d4;
            }

            $this->load->helper('print_arsip_kp_helper');
            $pdf = new Print_ARSIP_KP();
            $pdf->AddPage('L','A4');
            $pdf->SetAutoPageBreak(false);
            $pdf->AliasNbPages();
            $pdf->judul('Yayasan Pendidikan Harapan Bersama', 'PoliTeknik Harapan Bersama','PROGRAM STUDI D IV TEKNIK INFORMATIKA','Kampus I : Jl. Mataram No. 9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 'Website: informatika.poltektegal.ac.id        E-Mail: '.$email);
            $pdf->garis();
            $pdf->teks2();
            $pdf->table($tahun);
            $pdf->Output("Arsip Mahasiswa Kerja Praktik.pdf","I");
        } elseif ($type=="Excel"){
            $this->load->library('Excel_generator');

            $excel = new PHPExcel();
            $excel->getProperties()->setCreator('My Notes Code')
                ->setLastModifiedBy('My Notes Code')
                ->setTitle("Arsip Mahasiswa KP")
                ->setSubject("Arsip Mahasiswa KP")
                ->setDescription("Arsip Mahasiswa KP")
                ->setKeywords("Arsip Mahasiswa KP");

            // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
            $style_col = array(  'font' => array('bold' => true), // Set font nya jadi bold
                'alignment' => array(    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = array(
                'alignment' => array(    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            $excel->setActiveSheetIndex(0)->setCellValue('A1', "ARSIP MAHASISWA KP"); // Set kolom A1 dengan tulisan "DATA SISWA"
            $excel->getActiveSheet()->mergeCells('A1:J1'); // Set Merge Cell pada kolom A1 sampai F1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

            // Buat header tabel nya pada baris ke 3
            $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B3', "Tahun");
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "Wilayah");
            $excel->setActiveSheetIndex(0)->setCellValue('D3', "Bidang Kerja");
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "Nama Perusahaan");
            $excel->setActiveSheetIndex(0)->setCellValue('F3', "Alamat");
            $excel->setActiveSheetIndex(0)->setCellValue('G3', "Tim Mahasiswa");
            $excel->setActiveSheetIndex(0)->setCellValue('H3', "No HP");
            $excel->setActiveSheetIndex(0)->setCellValue('I3', "No WA");
            $excel->setActiveSheetIndex(0)->setCellValue('J3', "Dosen Pembimbing");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);

            // Set height baris ke 1, 2 dan 3
            $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4

            $where_wil['kp.deleted_flage'] = 1;
            if ($tahun!="semua"){
                $where_wil['YEAR(kp.cdate)']    = $tahun;
            }
            $where_wil['stt_arsip']         = 1;
            $wilayah = $this->db->select('wilayah.wilayah, bidang_kerja.bidang_kerja, 
                    kp.id_kp, kp_perusahaan.nama_perusahaan, kp_perusahaan.alamat, YEAR(kp.cdate) as tahun')
                ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
                ->join('wilayah','wilayah.id_wilayah = kp_perusahaan.id_wilayah')
                ->join('bidang_kerja','bidang_kerja.id_bidang_kerja = kp_perusahaan.id_bidang_kerja')
                ->order_by('YEAR(kp.cdate)','DESC')
                ->order_by('wilayah.wilayah','DESC')
                ->get_where("kp",$where_wil);

            $now = 1;

            $data = array();
            $no_wil = 1;
            foreach ($wilayah->result() as $it_wil){
                $tim_dosen = '';
                $dt_dosen = $this->db->select('dosen.*')
                    ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
                    ->join('dosen','dosen.id_dosen = pembimbing_dosen.id_dosen')
                    ->get_where('pembimbing',array('pembimbing.id_kp'=>$it_wil->id_kp,'pembimbing.deleted_flage'=>1))->result();
                foreach ($dt_dosen as $it_d){
                    $tim_dosen .= $it_d->nama_dosen;
                }

                $dt_mhs = $this->db->select('mahasiswa.*')
                    ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')
                    ->get_where('kp_anggota',array('kp_anggota.id_kp'=>$it_wil->id_kp))->result();
                $no_m = 0;
                foreach ($dt_mhs as $itm_mhs){
                    if ($no_m == 0){
                        $data[$no_wil]['no'] = $now;
                        $data[$no_wil]['tahun'] = $it_wil->tahun;
                        $data[$no_wil]['wilayah'] = $it_wil->wilayah;
                        $data[$no_wil]['bidang_kerja'] = $it_wil->bidang_kerja;
                        $data[$no_wil]['nama_perusahaan'] = $it_wil->nama_perusahaan;
                        $data[$no_wil]['alamat'] = $it_wil->alamat;
                        $data[$no_wil]['tim'] = $itm_mhs->nama_mahasiswa." - ".$itm_mhs->id_mahasiswa;
                        $data[$no_wil]['hp'] = $itm_mhs->no_hp;
                        $data[$no_wil]['wa'] = $itm_mhs->no_wa;
                        $data[$no_wil]['dosen'] = $tim_dosen;
                        $now++;
                    } else {
                        $data[$no_wil]['no'] = "";
                        $data[$no_wil]['tahun'] = "";
                        $data[$no_wil]['wilayah'] = "";
                        $data[$no_wil]['bidang_kerja'] = "";
                        $data[$no_wil]['nama_perusahaan'] = "";
                        $data[$no_wil]['alamat'] = "";
                        $data[$no_wil]['tim'] = $itm_mhs->nama_mahasiswa." - ".$itm_mhs->id_mahasiswa;
                        $data[$no_wil]['hp'] = $itm_mhs->no_hp;
                        $data[$no_wil]['wa'] = $itm_mhs->no_wa;
                        $data[$no_wil]['dosen'] = "";
                    }
                    $no_m++;
                    $no_wil++;
                }
            }

            foreach($data as $item){
                // Ambil semua data dari hasil eksekusi $sql
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $item['no']);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $item['tahun']);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $item['wilayah']);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $item['bidang_kerja']);
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $item['nama_perusahaan']);
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $item['alamat']);
                $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $item['tim']);
                $excel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$numrow, $item['hp'], PHPExcel_Cell_DataType::TYPE_STRING);
                $excel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$numrow, $item['wa'], PHPExcel_Cell_DataType::TYPE_STRING);
                $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $item['dosen']);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

                $no++;// Tambah 1 setiap kali looping
                $numrow++;// Tambah 1 setiap kali looping
            }

            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(100);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth(50);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet(0)->setTitle("Arsip Mahasiswa KP");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Arsip Mahasiswa KP.xlsx"');

            // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
    }
    public function arsip_kp_proses(){
        $id_kp = $this->input->post('id_kp');
        $type = $this->input->post('type');
        for ($i=0; $i < count($id_kp); $i++) {
            $stmt = $this->Madmin->arsip_kp_proses($id_kp[$i],$type);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function Arsip_Pembimbing()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $data['tahun'] = $this->Madmin->arsip_pembimbing_tahun()->result();
        $this->load->view('admin/Varsip_pembimbing',$data);
    }

    public function arsip_pembimbing_json(){
        $post = $this->input->post();
        $where['pembimbing_mahasiswa.stt_arsip'] = 1;
        $where['pembimbing_mahasiswa.deleted_flage'] = 1;
        $where['pembimbing.deleted_flage'] = 1;

        if ($post['tahun'] != "semua"){
            $where['YEAR(pembimbing.cdate)'] = $post['tahun'];
        }

        $result = array();
        $length         = $post['length'];
        $start          = $post['start'];
        $search         = $post['search']['value'];
        $stmt_1 = $this->Madmin->arsip_pembimbing_json($length,$start,$where,$search)->result();
        $stmt_2 = $this->Madmin->arsip_pembimbing_json(NULL,NULL,$where,$search)->num_rows();
        foreach ($stmt_1 as $item){
            $default = base_url('assets/document/img/style/profile.jpg');
            if (empty($item->foto_dosen)){
                $ft_dosen = $default;
            } else {
                $ft_dosen = base_url('assets/document/img/dosen/'.$item->foto_dosen);
            }
            if (empty($item->foto_mahasiswa)){
                $ft_mahasiswa = $default;
            } else {
                $ft_mahasiswa = base_url('assets/document/img/mahasiswa/'.$item->foto_mahasiswa);
            }

            array_push($result,
                array(
                    'foto_dosen'=>$ft_dosen,
                    'foto_mahasiswa'=>$ft_mahasiswa,
                    'id_dosen'=>$item->id_dosen,
                    'nama_dosen'=>$item->nama_dosen,
                    'id_pembimbing_mahasiswa'=>$item->id_pembimbing_mahasiswa,
                    'id_mahasiswa'=>$item->id_mahasiswa,
                    'nama_mahasiswa'=>$item->nama_mahasiswa,
                    'nama_perusahaan'=>$item->nama_perusahaan,
                    'id_kp'=>$item->id_kp,
                    'nama_laporan'=>$item->nama_laporan,
                    'stt'=>$item->stt,
                    'cdate'=>waktu_lalu2($item->cdate)
                )
            );
        }
        $response = array('draw'    => $post['draw'],
            'recordsTotal'          => $stmt_2,
            'recordsFiltered'       => $stmt_2,
            'data'                  => $result);
        setJSON($response);
    }

    public function arsip_pembimbing_cetak()
    {
        $type = $this->input->get('type');
        $tahun = $this->input->get('tahun');
        if ($type == "PDF") {
            $result4 = $this->Mmahasiswa->sikp();
            foreach ($result4->result() as $a) {
                $email = $a->email_d4;
            }

            $where['pembimbing_mahasiswa.stt_arsip'] = 1;
            if ($tahun != "semua"){
                $where['YEAR(pembimbing.cdate)'] = $tahun;
            }
            $data = $this->Madmin->arsip_pembimbing_json(-1,NULL,$where,NULL);

            $this->load->helper('print_arsip_pembimbing_helper');
            $pdf = new Print_ARSIP_Pembimbing();
            $pdf->AddPage('L', 'A4');
            $pdf->SetAutoPageBreak(false);
            $pdf->AliasNbPages();
            $pdf->judul('Yayasan Pendidikan Harapan Bersama', 'PoliTeknik Harapan Bersama', 'PROGRAM STUDI D IV TEKNIK INFORMATIKA', 'Kampus I : Jl. Mataram No. 9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 'Website: informatika.poltektegal.ac.id        E-Mail: ' . $email);
            $pdf->garis();
            $pdf->teks2($tahun);
            $pdf->table($data);
            $pdf->Output("Arsip Pembimbing Kerja Praktik.pdf", "I");
        }  elseif ($type=="Excel"){
            $this->load->library('Excel_generator');

            $excel = new PHPExcel();
            $excel->getProperties()->setCreator('My Notes Code')
                ->setLastModifiedBy('My Notes Code')
                ->setTitle("Arsip Pembimbing KP")
                ->setSubject("Arsip Pembimbing KP")
                ->setDescription("Arsip Pembimbing KP")
                ->setKeywords("Arsip Pembimbing KP");

            // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
            $style_col = array(  'font' => array('bold' => true), // Set font nya jadi bold
                'alignment' => array(    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = array(
                'alignment' => array(    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            $excel->setActiveSheetIndex(0)->setCellValue('A1', "ARSIP PEMBIMBING KP"); // Set kolom A1 dengan tulisan "DATA SISWA"
            $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai F1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

            // Buat header tabel nya pada baris ke 3
            $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Dosen");
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama Mahasiswa");
            $excel->setActiveSheetIndex(0)->setCellValue('D3', "Nama Perusahaan");
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "ID KP");
            $excel->setActiveSheetIndex(0)->setCellValue('F3', "Nama Laporan");
            $excel->setActiveSheetIndex(0)->setCellValue('G3', "Status Laporan");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);

            // Set height baris ke 1, 2 dan 3
            $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4

            $where['pembimbing_mahasiswa.stt_arsip'] = 1;
            if ($tahun != "semua"){
                $where['YEAR(pembimbing.cdate)'] = $tahun;
            }
            $data = $this->Madmin->arsip_pembimbing_json(-1,0,$where,NULL)->result();

            foreach($data as $item){
                if ($item->stt==1){
                    $stt_lap = "Laporan Selesai";
                } else {
                    $stt_lap = "Laporan Belum Selesai";
                }

                // Ambil semua data dari hasil eksekusi $sql
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $item->nama_dosen);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $item->nama_mahasiswa);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $item->nama_perusahaan);
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $item->id_kp);
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $item->nama_laporan);
                $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $stt_lap);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

                $no++;// Tambah 1 setiap kali looping
                $numrow++;// Tambah 1 setiap kali looping
            }

            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(45);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet(0)->setTitle("Arsip Pembimbing KP");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Arsip Pembimbing KP.xlsx"');

            // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
    }
    public function arsip_pembimbing_proses(){
        $id_pembimbing = $this->input->post('id_pembimbing');
        $type = $this->input->post('type');
        for ($i=0; $i < count($id_pembimbing); $i++) {
            list($id_pembimbing_mahasiswa, $mahasiswa, $dosen) = explode('/', $id_pembimbing[$i]);
            $stmt = $this->Madmin->arsip_pembimbing_proses($id_pembimbing_mahasiswa,$mahasiswa,$dosen,$type);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function Arsip_Dosen()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $data['tahun'] = $this->Madmin->arsip_dosen_tahun()->result();
        $this->load->view('admin/Varsip_dosen',$data);
    }

    public function arsip_dosen_json(){
        $post = $this->input->post();
        $where['stt_arsip'] = 1;
        $where['deleted_flage'] = 1;

        if ($post['tahun'] != "semua"){
            $where['YEAR(cdate)'] = $post['tahun'];
        }

        $result = array();
        $length         = $post['length'];
        $start          = $post['start'];
        $search         = $post['search']['value'];
        $stmt_1 = $this->Madmin->arsip_dosen_json($length,$start,$where,$search)->result();
        $stmt_2 = $this->Madmin->arsip_dosen_json(NULL,NULL,$where,$search)->num_rows();
        foreach ($stmt_1 as $item){
            $default = base_url('assets/document/img/style/profile.jpg');
            if (empty($item->foto_dosen)){
                $ft_dosen = $default;
            } else {
                $ft_dosen = base_url('assets/document/img/dosen/'.$item->foto_dosen);
            }

            array_push($result,
                array(
                    'foto_dosen'=>$ft_dosen,
                    'id_dosen'=>$item->id_dosen,
                    'nama_dosen'=>$item->nama_dosen,
                    'jabatan'=>$item->jabatan,
                    'alamat'=>$item->alamat,
                    'email'=>$item->email,
                    'cdate'=>waktu_lalu2($item->cdate)
                )
            );
        }
        $response = array('draw'    => $post['draw'],
            'recordsTotal'          => $stmt_2,
            'recordsFiltered'       => $stmt_2,
            'data'                  => $result);
        setJSON($response);
    }

    public function arsip_dosen_cetak()
    {
        $type = $this->input->get('type');
        $tahun = $this->input->get('tahun');
        if ($type == "PDF") {
            $result4 = $this->Mmahasiswa->sikp();
            foreach ($result4->result() as $a) {
                $email = $a->email_d4;
            }

            $where['stt_arsip'] = 1;
            if ($tahun != "semua"){
                $where['YEAR(cdate)'] = $tahun;
            }
            $data = $this->Madmin->arsip_dosen_json(-1,NULL,$where,NULL);

            $this->load->helper('print_arsip_dosen_helper');
            $pdf = new Print_ARSIP_Dosen();
            $pdf->AddPage('L', 'A4');
            $pdf->SetAutoPageBreak(false);
            $pdf->AliasNbPages();
            $pdf->judul('Yayasan Pendidikan Harapan Bersama', 'PoliTeknik Harapan Bersama', 'PROGRAM STUDI D IV TEKNIK INFORMATIKA', 'Kampus I : Jl. Mataram No. 9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 'Website: informatika.poltektegal.ac.id        E-Mail: ' . $email);
            $pdf->garis();
            $pdf->teks2($tahun);
            $pdf->table($data);
            $pdf->Output("Arsip Dosen ".$tahun.".pdf", "I");
        }  elseif ($type=="Excel"){
            $this->load->library('Excel_generator');

            $excel = new PHPExcel();
            $excel->getProperties()->setCreator('My Notes Code')
                ->setLastModifiedBy('My Notes Code')
                ->setTitle("Arsip Dosen")
                ->setSubject("Arsip Dosen")
                ->setDescription("Arsip Dosen")
                ->setKeywords("Arsip Dosen");

            // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
            $style_col = array(  'font' => array('bold' => true), // Set font nya jadi bold
                'alignment' => array(    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = array(
                'alignment' => array(    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            $excel->setActiveSheetIndex(0)->setCellValue('A1', "ARSIP DOSEN"); // Set kolom A1 dengan tulisan "DATA SISWA"
            $excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai F1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

            // Buat header tabel nya pada baris ke 3
            $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIP Dosen");
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama Dosen");
            $excel->setActiveSheetIndex(0)->setCellValue('D3', "Jabatan");
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "Email");
            $excel->setActiveSheetIndex(0)->setCellValue('F3', "Alamat");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

            // Set height baris ke 1, 2 dan 3
            $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4

            $where['stt_arsip'] = 1;
            if ($tahun != "semua"){
                $where['YEAR(cdate)'] = $tahun;
            }
            $data = $this->Madmin->arsip_dosen_json(-1,NULL,$where,NULL)->result();

            foreach($data as $item){
                // Ambil semua data dari hasil eksekusi $sql
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $item->id_dosen);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $item->nama_dosen);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $item->jabatan);
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $item->email);
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $item->alamat);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

                $no++;// Tambah 1 setiap kali looping
                $numrow++;// Tambah 1 setiap kali looping
            }

            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(45);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet(0)->setTitle("Arsip Dosen");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Arsip Dosen.xlsx"');

            // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
    }
    public function arsip_dosen_proses(){
        $data_dosen = $this->input->post('data_dosen');
        $type = $this->input->post('type');
        for ($i=0; $i < count($data_dosen); $i++) {
            list($id_dosen, $nama_dosen) = explode('/', $data_dosen[$i]);
            $stmt = $this->Madmin->arsip_dosen_proses($id_dosen,$nama_dosen,$type);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function Arsip_Mahasiswa()
    {
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $data['tahun'] = $this->Madmin->arsip_mahasiswa_tahun()->result();
        $this->load->view('admin/Varsip_mahasiswa',$data);
    }

    public function arsip_mahasiswa_json(){
        $post = $this->input->post();
        $where['stt_arsip'] = 1;
        $where['deleted_flage'] = 1;

        if ($post['tahun'] != "semua"){
            $where['YEAR(cdate)'] = $post['tahun'];
        }

        $result = array();
        $length         = $post['length'];
        $start          = $post['start'];
        $search         = $post['search']['value'];
        $stmt_1 = $this->Madmin->arsip_mahasiswa_json($length,$start,$where,$search)->result();
        $stmt_2 = $this->Madmin->arsip_mahasiswa_json(NULL,NULL,$where,$search)->num_rows();
        foreach ($stmt_1 as $item){
            $default = base_url('assets/document/img/style/profile.jpg');
            if (empty($item->foto_mahasiswa)){
                $ft_mahasiswa = $default;
            } else {
                $ft_mahasiswa = base_url('assets/document/img/mahasiswa/'.$item->foto_mahasiswa);
            }

            array_push($result,
                array(
                    'foto_mahasiswa'=>$ft_mahasiswa,
                    'id_mahasiswa'=>$item->id_mahasiswa,
                    'nama_mahasiswa'=>$item->nama_mahasiswa,
                    'angkatan'=>$item->angkatan,
                    'alamat'=>$item->alamat,
                    'email'=>$item->email,
                    'cdate'=>waktu_lalu2($item->cdate)
                )
            );
        }
        $response = array('draw'    => $post['draw'],
            'recordsTotal'          => $stmt_2,
            'recordsFiltered'       => $stmt_2,
            'data'                  => $result);
        setJSON($response);
    }

    public function arsip_mahasiswa_cetak()
    {
        $type = $this->input->get('type');
        $tahun = $this->input->get('tahun');
        if ($type == "PDF") {
            $result4 = $this->Mmahasiswa->sikp();
            foreach ($result4->result() as $a) {
                $email = $a->email_d4;
            }

            $where['stt_arsip'] = 1;

            if ($tahun != "semua"){
                $where['YEAR(cdate)'] = $tahun;
            }
            $data = $this->Madmin->arsip_mahasiswa_json(-1,NULL,$where,NULL);

            $this->load->helper('print_arsip_mahasiswa_helper');
            $pdf = new Print_ARSIP_Mahasiswa();
            $pdf->AddPage('L', 'A4');
            $pdf->SetAutoPageBreak(false);
            $pdf->AliasNbPages();
            $pdf->judul('Yayasan Pendidikan Harapan Bersama', 'PoliTeknik Harapan Bersama', 'PROGRAM STUDI D IV TEKNIK INFORMATIKA', 'Kampus I : Jl. Mataram No. 9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353', 'Website: informatika.poltektegal.ac.id        E-Mail: ' . $email);
            $pdf->garis();
            $pdf->teks2($tahun);
            $pdf->table($data);
            $pdf->Output("Arsip Mahasiswa ".$tahun.".pdf", "I");
        }  elseif ($type=="Excel"){
            $this->load->library('Excel_generator');

            $excel = new PHPExcel();
            $excel->getProperties()->setCreator('My Notes Code')
                ->setLastModifiedBy('My Notes Code')
                ->setTitle("Arsip Mahasiswa")
                ->setSubject("Arsip Mahasiswa")
                ->setDescription("Arsip Mahasiswa")
                ->setKeywords("Arsip Mahasiswa");

            // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
            $style_col = array(  'font' => array('bold' => true), // Set font nya jadi bold
                'alignment' => array(    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = array(
                'alignment' => array(    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                )
            );

            $excel->setActiveSheetIndex(0)->setCellValue('A1', "ARSIP DOSEN"); // Set kolom A1 dengan tulisan "DATA SISWA"
            $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai F1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

            // Buat header tabel nya pada baris ke 3
            $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIM");
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama Mahasiswa");
            $excel->setActiveSheetIndex(0)->setCellValue('D3', "Jenis Kelamin");
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "Email");
            $excel->setActiveSheetIndex(0)->setCellValue('F3', "Alamat");
            $excel->setActiveSheetIndex(0)->setCellValue('G3', "Angkatan");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);

            // Set height baris ke 1, 2 dan 3
            $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
            $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4

            $where['stt_arsip'] = 1;

            if ($tahun != "semua"){
                $where['YEAR(cdate)'] = $tahun;
            }
            $data = $this->Madmin->arsip_mahasiswa_json(-1,NULL,$where,NULL)->result();

            foreach($data as $item){
                // Ambil semua data dari hasil eksekusi $sql
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $item->id_mahasiswa);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $item->nama_mahasiswa);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $item->sex);
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $item->email);
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $item->alamat);
                $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $item->angkatan);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

                $no++;// Tambah 1 setiap kali looping
                $numrow++;// Tambah 1 setiap kali looping
            }

            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet(0)->setTitle("Arsip Mahasiswa");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Arsip Mahasiswa.xlsx"');

            // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
    }
    public function arsip_mahasiswa_proses(){
        $data_mahasiswa = $this->input->post('data_mahasiswa');
        $type = $this->input->post('type');
        for ($i=0; $i < count($data_mahasiswa); $i++) {
            list($id_mahasiswa, $nama_mahasiswa) = explode('/', $data_mahasiswa[$i]);
            $stmt = $this->Madmin->arsip_mahasiswa_proses($id_mahasiswa,$nama_mahasiswa,$type);
        }
        if ($stmt){
            echo 1;
        } else {
            echo 0;
        }
    }
    public function Laporan_Grafik_KP(){
        $data['s_niy'] = $this->session->userdata('niy');
        $data['s_nama'] = $this->session->userdata('nama');
        $data['s_foto'] = $this->session->userdata('foto');
        $data['tahun'] = $this->Madmin->arsip_kp_tahun(array('deleted_flage'=>1))->result();
        $this->load->view('admin/Vlaporan_grafik_kp',$data);
    }

    public function laporan_grafik_kp_data(){
        $tahun = $this->input->get('tahun');
        $where_wilayah['kp.deleted_flage'] = 1;
        $where_bidang['kp.deleted_flage'] = 1;
        if ($tahun!="semua"){
            $where_wilayah['YEAR(kp.cdate)'] = $tahun;
            $where_bidang['YEAR(kp.cdate)'] = $tahun;
        }

        $grafik_wilayah = array();
        $stmt = $this->Madmin->lap_grafik_kp_cek_wilayah($where_wilayah,TRUE);
        foreach ($stmt->result() as $item) {
            $where_wilayah['kp_perusahaan.id_wilayah'] = $item->id_wilayah;
            $ttl = $this->Madmin->lap_grafik_kp_cek_wilayah($where_wilayah)->num_rows();
            array_push($grafik_wilayah,array("wilayah"=>$item->wilayah,"jumlah"=>$ttl));
        }

        $grafik_bidang = array();
        $stmt2 = $this->Madmin->lap_grafik_kp_cek_bidang($where_bidang,TRUE);
        foreach ($stmt2->result() as $item) {
            $where_bidang['kp_perusahaan.id_bidang_kerja'] = $item->id_bidang_kerja;
            $ttl = $this->Madmin->lap_grafik_kp_cek_bidang($where_bidang)->num_rows();
            array_push($grafik_bidang,array("bidang_kerja"=>$item->bidang_kerja,"jumlah"=>$ttl));
        }



        setJSON(array('grafik_wilayah'=>$grafik_wilayah,'grafik_bidang'=>$grafik_bidang));
    }

    // public function cek_mhs(){
    // 	$stmt = $this->db->get_where('kp_anggota',array('id_mahasiswa' => '18090061'));
    // 	if ($stmt) {
    // 		echo $stmt->num_rows();
    // 	} else {
    // 		echo "error";
    // 	}
    	
    // }

    //  public function backup_db(){
    //     $this->load->dbutil();

    //     $prefs = array(
    //         'format' => "zip",
    //         'filename' => "backup_dp_".date('Y-m-d--H:i:s').".sql"
    //     );

    //     $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip'; // file name
    //     $save  = 'assets/' . $db_name; // dir name backup output destination

    //     $this->load->helper('file');
    //     if (write_file($save, $this->dbutil->backup($prefs))){
    //         echo 1;
    //     } else {
    //         echo 0;
    //     }
    // }
}
