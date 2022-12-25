<?php

class Sistem extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Madmin');
    $this->load->model('Mindex');
  }
  public function index()
  {
    $this->load->view('admin/Vlogin');
  }
  public function login()
  {
    $us = $this->input->post('us');
		$pass = $this->input->post('pass');
    $password = md5($pass);
    $stmt = $this->Madmin->data_user_admin($us,$password)->num_rows();
    if($stmt == 1)
    {
      $result = $this->Madmin->data_user_admin($us,$password)->result();
      foreach ($result as $a)
      {
        $data_session = array('id_admin'=>$a->id_admin,'niy' => $a->niy,'nama'=>$a->nama_admin,'foto'=>$a->foto_admin,'logged_in_admin' => "TRUE");
        $this->session->set_userdata($data_session);

        $data_log = array('id'=>"Admin",'ket'=>"Login",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->Mindex->log_activity($data_log);
      }
      //redirect(base_url("admin"));
      echo "Admin/Dashboard";
    }
    else{ echo "0"; }
  }
}

?>
