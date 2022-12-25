<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cindex extends CI_Controller
{
	function __construct()
  {
    parent::__construct();
    $this->load->model('Mindex');
		$this->load->helper('library_helper');
		date_default_timezone_set('Asia/Jakarta');
		if (isset($this->session->userdata['logged_in_mhs']) == TRUE)
    {
      redirect(base_url('Mahasiswa'));
    }
		if (isset($this->session->userdata['logged_in_dosen']) == TRUE)
    {
      redirect(base_url('Dosen'));
    }
		if (isset($this->session->userdata['logged_in_admin']) == TRUE)
    {
      redirect(base_url('Admin/Dashboard'));
    }
  }

	public function index()
	{
		$data['dashimg'] = $this->Mindex->dashimg();
		$data['galeri'] = $this->Mindex->galeri();
		$data['sosial_link'] = $this->Mindex->sosial_link();
		$result = $this->Mindex->deskripsi_kp()->result();
		foreach ($result as $a) {
			$data['deskripsi_kp'] = $a->isi;
		}
		$this->load->view('Vindex', $data);
	}
	function popup()
	{
		$this->load->view('Vpopup_login');
	}

	function login()
	{
		$id = $this->input->post('nim');
		$pass = $this->input->post('password');
		$password = md5($pass);
		$tipe = $this->input->post('tipe');
		if ($tipe == "mahasiswa")
		{
			$stmt = $this->Mindex->data_user_mahasiswa($id,$password)->num_rows();
			if($stmt == 1)
			{
				$result = $this->Mindex->data_user_mahasiswa($id,$password)->result();
				foreach ($result as $a)
				{
					$data_session = array('nim' => $a->id_mahasiswa,'nama'=>$a->nama_mahasiswa,'foto'=>$a->foto_mahasiswa,
																'logged_in_mhs' => "TRUE");
					$this->session->set_userdata($data_session);
					$res_mhs = $this->Mindex->login_mhs($a->id_mahasiswa);

					$data_log = array('id'=>"ID Mahasiswa ".$a->id_mahasiswa,'ket'=>"Login",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");;
					$this->Mindex->log_activity($data_log);
				}
				//redirect(base_url("admin"));
				echo "1";
			}
			else{ echo "0"; }
		}
		elseif ($tipe == "dosen")
		{
			$stmt = $this->Mindex->data_user_dosen($id,$password)->num_rows();
			if($stmt == 1)
			{
				$result = $this->Mindex->data_user_dosen($id,$password)->result();
				foreach ($result as $a)
				{
					$data_session = array('niy' => $a->id_dosen,'nama'=>$a->nama_dosen,'foto'=>$a->foto_dosen,'logged_in_dosen' => "TRUE");
					$this->session->set_userdata($data_session);
					$res_mhs = $this->Mindex->login_dsn($a->id_dosen);

					$data_log = array('id'=>"ID Dosen ".$a->id_dosen,'ket'=>"Login",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");;
					$this->Mindex->log_activity($data_log);
				}
				//redirect(base_url("admin"));
				echo "2";
			}
			else{ echo "0"; }
		}
		else{ echo "0"; }
	}
}
