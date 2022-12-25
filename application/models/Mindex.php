<?php
class Mindex extends CI_Model
{
  function dashimg()
  {
    $stmt = $this->db->get('dashboard_img');
    return $stmt;
  }
  function galeri()
  {
    $stmt = $this->db->get('galeri');
    return $stmt;
  }
  function deskripsi_kp()
  {
    $stmt = $this->db->get('deskripsi_kp');
    return $stmt;
  }
  function data_user_mahasiswa($id,$password){
    $data = array('id_mahasiswa' => $id,'password' => $password);
		$stmt = $this->db->get_where('mahasiswa',$data);
    return $stmt;
	}
  function data_user_dosen($id,$password){
    $data = array('id_dosen' => $id,'password' => $password);
		$stmt = $this->db->get_where('dosen',$data);
    return $stmt;
	}
  function login_mhs($id)
  {
    $data = array('stt_login_mahasiswa'=>"1");
    $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
    return $stmt;
  }
  function login_dsn($id)
  {
    $data = array('stt_login_dosen'=>"1");
    $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
    return $stmt;
  }
  function sosial_link()
  {
    $stmt = $this->db->get('sosial_link');
    return $stmt;
  }
  function log_activity($data)
  {
    $this->db->insert('log_activity',$data);
  }
}
?>
