<?php
class Dosen extends CI_Controller

{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mmahasiswa');
		$this->load->model('Madmin');
		$this->load->helper('library_helper');
		if (!isset($this->session->userdata['logged_in_dosen']) == TRUE) {
			redirect(base_url());
		}
	}

	function index()
	{
		$data['s_niy'] = $this->session->userdata('niy');
		$data['s_nama'] = $this->session->userdata('nama');
		$data['s_foto'] = $this->session->userdata('foto');
		$this->load->view('dosen/Vdosen', $data);
	}

	public

	function dashboard()
	{
		$data['lap_fix'] = $this->Mmahasiswa->jml_laporan_fix()->num_rows();
		$data['kp_fix'] = $this->Mmahasiswa->jml_kp_fix()->num_rows();
		$data['daftar_kp_mhs'] = $this->Mmahasiswa->daftar_kp_mhs();
		$data['daftar_lap_mhs'] = $this->Mmahasiswa->daftar_lap_mhs();
		$this->load->view('dosen/dashboard/Vdashboard', $data);
	}

	public

	function dashboard_data_post()
	{
		$page = filter_var($this->input->get('page') , FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$data['dashboard'] = $this->Mmahasiswa->dashboard($page);
		$data['stt_post'] = $this->Madmin->t_dashboard()->num_rows();
		$this->load->view('dosen/dashboard/Vdashboard_post', $data);
	}

	public

	function daftar_mahasiswa_dan_laporan_kptb()
	{
		$tabel = $this->input->post('tabel');
		$data_session = array(
			'tabel' => $tabel
		);
		$this->session->set_userdata($data_session);
	}

	public

	function Daftar_Mahasiswa_Dan_Laporan_KP()
	{
		$data['tabel'] = $this->session->userdata('tabel');
		$data['s_niy'] = $this->session->userdata('niy');
		$data['s_nama'] = $this->session->userdata('nama');
		$data['s_foto'] = $this->session->userdata('foto');
		$this->load->view('dosen/Vkp', $data);
	}

	public

	function dashboard_tabel_kp()
	{
		$this->load->view('dosen/dashboard/Vkp_index');
	}

	public

	function dashboard_table_mhs()
	{
		$data['daftar_mahasiswa_kp'] = $this->Mmahasiswa->daftar_mahasiswa_kp();
		$this->load->view('dosen/dashboard/Vtmhs', $data);
	}

	public

	function dashboard_table_lap()
	{
		$data['daftar_lap_kp'] = $this->Mmahasiswa->daftar_lap_kp();
		$this->load->view('dosen/dashboard/Vtlap', $data);
	}

	public

	function Bimbingan_Online()
	{
		$data['s_niy'] = $this->session->userdata('niy');
		$data['s_nama'] = $this->session->userdata('nama');
		$data['s_foto'] = $this->session->userdata('foto');
		$segment = $this->uri->segment(3);
		if (empty($segment)) {
			$this->load->view('dosen/Vbimbingan_online', $data);
		}
		elseif (!empty($segment)) {
			$data['segment'] = $segment;
			$this->load->view('dosen/Vbimbingan_online_chat', $data);
		}
	}

	public

	function bimbingan_online_index()
	{
		$id = $this->session->userdata('niy');
		$data['daftar'] = $this->Mmahasiswa->daftar_membimbing_chat($id);
		$this->load->view('dosen/bimbingan_online/Vbimbingan_online', $data);
	}

	public

	function bimbingan_online_chat()
	{
		$data['iddsn'] = $this->session->userdata('niy');
		$data['nim'] = $this->input->post('id');
		$stmt = $this->Mmahasiswa->cek_chat($data['iddsn'], $data['nim'], "dsn");
		$this->load->view('dosen/bimbingan_online/Vbimbingan_online_chat', $data);
	}

	public

	function bimbingan_online_chat_index()
	{
		$data['iddsn'] = $this->session->userdata('niy');
		$data['nim'] = $this->input->post('id');
		$data['message'] = $this->Mmahasiswa->data_chat($data['iddsn'], $data['nim'], "dsn");
		$stmt = $this->Mmahasiswa->cek_chat($data['iddsn'], $data['nim'], "mahasiswa");
		$this->load->view('dosen/bimbingan_online/Vchat', $data);
	}

	public

	function input_chat()
	{
		$n = 20;
		$aKod = NULL;
		$kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
		for ($i = 0; $i < $n; $i++) {
			$acakAngka = rand(1, strlen($kode));
			$aKod.= substr($kode, $acakAngka, 1);
		}

		$cf['upload_path'] = './assets/document/file/bimbingan_online/';
		$cf['allowed_types'] = 'pdf|doc|docx|zip|rar|jpg|png|jpeg';
		$cf['max_size'] = '5000';
		$cf['file_name'] = $aKod;
		$this->upload->initialize($cf);
		$nim = $this->input->post('nim');
		$chat = $this->input->post('isi');
		$j = $this->input->post('i');
		$iddsn = $this->input->post('iddsn');
		if (!$this->upload->do_upload('file')) {
			$info = $this->upload->display_errors();
			if ($info == "<p>You did not select a file to upload.</p>") {
				$stmt = $this->Mmahasiswa->input_chat($nim, $chat, $iddsn, "", "", "", "1", "dosen");
				if ($stmt) {
					echo "1";
				}
				else {
					echo "0";
				}
			}
			else {
				echo "2";
			}
		}
		else {
			$fn = $this->upload->data();
			$b = $this->upload->data('file_size');
			$c = $this->upload->data('file_type');
			$nama = $fn['file_name'];
			$stmt = $this->Mmahasiswa->input_chat($nim, $chat, $iddsn, $c, $b, $nama, "1", "dosen");
			if ($stmt) {
				echo "1";
			}
			else {
				echo "0";
			}
		}
	}

	public

	function clear_chat()
	{
		$nim = $this->input->post('nim');
		$iddsn = $this->session->userdata('niy');
		$stmt = $this->Mmahasiswa->clear_chat($iddsn, $nim, "dosen");
		if ($stmt) {
			echo "1";
		}
		else {
			echo "0";
		}
	}

	public

	function download_dk_chat()
	{
		$nm = $this->uri->segment('3');
		force_download('assets/document/file/bimbingan_online/' . $nm, NULL);
	}

	public

	function download_dashboard()
	{
		$nm = $this->uri->segment('3');
		force_download('assets/document/file/dashboard/' . $nm, NULL);
	}

	public

	function Profil()
	{
		$data['s_niy'] = $this->session->userdata('niy');
		$data['s_nama'] = $this->session->userdata('nama');
		$data['s_foto'] = $this->session->userdata('foto');
		$this->load->view('dosen/Vprofil', $data);
	}

	public

	function profil_dsn()
	{
		$id_dosen = $this->session->userdata('niy');
		$result = $this->Mmahasiswa->detail_dosen($id_dosen)->result();
		foreach($result as $a) {
			$data['id_dosen'] = $a->id_dosen;
			$data['foto'] = $a->foto_dosen;
			$data['nama_dosen'] = $a->nama_dosen;
			$data['jabatan'] = $a->jabatan;
			$data['agama'] = $a->agama;
			$data['sex'] = $a->sex;
			$data['tgl_lahir'] = $a->tgl_lahir;
			$data['bln_lahir'] = $a->bln_lahir;
			$data['thn_lahir'] = $a->thn_lahir;
			$data['email'] = $a->email;
			$data['no_hp'] = $a->no_hp;
			$data['no_wa'] = $a->no_wa;
			$data['alamat'] = $a->alamat;
			$data['golongan_darah'] = $a->golongan_darah;
			$data['mdate'] = $a->mdate;
		}

		$this->load->view('dosen/profile/Vprofil', $data);
	}

	public

	function input_ubah_img()
	{
		$n = 20;
		$aKod = NULL;
		$kode = "ACBDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_#?~";
		for ($i = 0; $i < $n; $i++) {
			$acakAngka = rand(1, strlen($kode));
			$aKod.= substr($kode, $acakAngka, 1);
		}

		$config['upload_path'] = './assets/document/img/dosen/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = '1000';
		$config['file_name'] = $aKod;
		$this->upload->initialize($config);
		$id = $this->input->post('id');
		$img2 = $this->input->post('img2');
		if (!$this->upload->do_upload('img')) {
			echo "2";
		}
		else {
			if (!empty($img2)) {
				unlink("./assets/document/img/dosen/$img2");
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
			$stmt = $this->Mmahasiswa->input_ubah_img_dosen($nama, $id);
			if ($stmt) {
				$data_session = array(
					'foto' => $nama
				);
				$this->session->set_userdata($data_session);
				echo "1";
			}
			else {
				echo "0";
			}
		}
	}

	public

	function input_ubah_biodata_dosen()
	{
		$id = $this->input->post('id');
		$nama = $this->input->post('nama');
		$data = array(
			'nama_dosen' => $nama,
			'jabatan' => $this->input->post('jabatan') ,
			'agama' => $this->input->post('agama') ,
			'sex' => $this->input->post('sex') ,
			'tgl_lahir' => $this->input->post('tgl') ,
			'bln_lahir' => $this->input->post('bln') ,
			'thn_lahir' => $this->input->post('thn') ,
			'email' => $this->input->post('email') ,
			'no_hp' => $this->input->post('no_hp') ,
			'no_wa' => $this->input->post('no_wa') ,
			'alamat' => $this->input->post('alamat') ,
			'golongan_darah' => $this->input->post('gol_drh') ,
			'mdate' => date('Y-m-d H:i:s')
		);
		$stmt = $this->Mmahasiswa->input_ubah_biodata_dosen($id, $data);
		if ($stmt) {
			$data_session = array(
				'nama' => $nama
			);
			$this->session->set_userdata($data_session);
			echo "1";
		}
		else {
			echo "0";
		}
	}

	public

	function input_ubah_pass_dosen()
	{
		$id = $this->input->post('id');
		$passl = $this->input->post('passl');
		$passwordl = md5($passl);
		$passb = $this->input->post('passb');
		$passwordb = md5($passb);
		$result = $this->Mmahasiswa->detail_dosen($id)->result();
		foreach($result as $a) {
			if ($passwordl == $a->password) {
				$stmt = $this->Mmahasiswa->input_ubah_pass_dosen($id, $passwordb);
				if ($stmt) {
					echo "1";
				}
				else {
					echo "0";
				}
			}
			else {
				echo "2";
			}
		}
	}

	function Daftar_Mahasiswa()
	{
		$data['s_niy'] = $this->session->userdata('niy');
		$data['s_nama'] = $this->session->userdata('nama');
		$data['s_foto'] = $this->session->userdata('foto');
		$segment = $this->uri->segment(3);
		if (empty($segment)) {
			$this->load->view('dosen/Vdaftar_mahasiswa', $data);
		}
		elseif (!empty($segment)) {
			$data['segment'] = $segment;
			$this->load->view('dosen/Vagenda_kp_mhs', $data);
		}
	}

	public

	function daftar_dosen_membimbing()
	{
		$id_dosen = $this->session->userdata('niy');
		$data['daftar'] = $this->Mmahasiswa->daftar_dosen_membimbing($id_dosen);
		$this->load->view('dosen/daftar_mahasiswa/Vdaftar_mahasiswa', $data);
	}

	public

	function agenda_index()
	{
		$this->load->view('dosen/daftar_mahasiswa/Vagenda_index');
	}

	public

	function agenda_index_data()
	{
		$data['nim'] = $this->input->get('nim');
		$data['page'] = $this->input->get('page');
		if ($data['page'] == "agenda_detail_mahasiswa") {
			$data['daftar'] = $this->Mmahasiswa->detail_mahasiswa($data['nim']);
		}
		elseif ($data['page'] == "agenda_kp_harian") {
			$data['data'] = $this->Mmahasiswa->data_kp_harian($data['nim']);
			$data['data_kp'] = $this->Mmahasiswa->data_kp($data['nim']);
		}
		elseif ($data['page'] == "agenda_kp_bimbingan") {
			$data['data'] = $this->Mmahasiswa->data_kp_bimbingan($data['nim']);
			$data['data_kp'] = $this->Mmahasiswa->data_kp($data['nim']);
		}
		elseif ($data['page'] == "agenda_data_kp") {
			$data['data'] = $this->Mmahasiswa->data_perusahaan($data['nim']);
			$data['data_kp'] = $this->Mmahasiswa->data_kp($data['nim']);
		}

		$this->load->view('dosen/daftar_mahasiswa/Vagenda_index_data', $data);
	}

	public

	function download_dt_pers()
	{
		$nm = $this->uri->segment('3');
		force_download('assets/document/file/surat_terima_perusahaan/' . $nm, NULL);
	}

	public

	function input_data_kp_bimbingan()
	{
		$id = $this->input->post('id');
		$idkp = $this->input->post('idkp');
		$idpmb = $this->input->post('idpmb');
		$ket = $this->input->post('ket');
		$iddsn = $this->session->userdata('niy');
		$stmt = $this->Mmahasiswa->input_data_kp_bimbingan($id, $idkp, $idpmb, $ket, $iddsn);
		if ($stmt) {
			echo "1";
		}
		else {
			echo "0";
		}
	}

	public

	function hapus_kp_bimbingan()
	{
		$id = $this->input->post('id');
		$id_dosen = $this->session->userdata('niy');
		$stmt = $this->Mmahasiswa->hapus_kp_bimbingan($id, $id_dosen);
		if ($stmt) {
			echo "1";
		}
		else {
			echo "0";
		}
	}

	public

	function modal()
	{
		$data['page'] = $this->input->get('page');
		$id = $this->input->get('id');
		if ($data['page'] == "detailmhs") {
			$data['daftar'] = $this->Mmahasiswa->detail_mahasiswa($id);
			$this->load->view('style/Vmodal', $data);
		}

		if ($data['page'] == "detaildsn") {
			$data['daftar'] = $this->Mmahasiswa->detail_dosen($id);
			$this->load->view('style/Vmodal', $data);
		}

		if ($data['page'] == "input_kp_harian") {
			$data['daftar'] = $this->Mmahasiswa->cek_data_kp_harian($id);
			$this->load->view('style/Vmodal', $data);
		}

		if ($data['page'] == "input_kp_bimbingan") {
			$data['daftar'] = $this->Mmahasiswa->cek_data_kp_harian($id);
			$this->load->view('style/Vmodal', $data);
		}

		if ($data['page'] == "detail_img") {
			$result = $this->Mmahasiswa->detail_img_dashboard($id);
			foreach($result->result() as $a) {
				$data['file'] = $a->file;
				$data['tipe'] = $a->tipe;
				$data['img'] = "assets/document/file/dashboard/" . $a->file;
			}

			$this->load->view('style/Vmodal', $data);
		}
	}

	function logout()
	{
		$id_dosen = $this->session->userdata('niy');
		$stmt = $this->Mmahasiswa->logout_dsn($id_dosen);
		if ($stmt) {
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
}

?>