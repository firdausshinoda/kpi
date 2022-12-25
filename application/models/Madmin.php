<?php

class Madmin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }
    function clear_chat_bo()
    {
        $data = array('stt_r_dsn'=>"0",'stt_r_mhs'=>"0");
        $stmt = $this->db->get_where('bimbingan_online',$data);
        return $stmt;
    }
    function clear_chat()
    {
        $stmt = $this->db->where('stt_r_dsn',"0")->where('stt_r_mhs',"0")->delete('bimbingan_online');
        return $stmt;
    }
    function data_user_admin($us,$pass)
    {
        $data = array('username_admin'=>$us,'password'=>$pass);
        $stmt = $this->db->get_where('admin',$data);
        return $stmt;
    }
    function jml_kp_fix()
    {
        $data = array('kp.stt'=>"1");
        $this->db->select('kp.id_kp,kp.stt,kp_anggota.id_kp')->join('kp_anggota','kp.id_kp = kp_anggota.id_kp');
        $stmt = $this->db->get_where('kp',$data);
        return $stmt;
    }
    function jml_laporan_fix()
    {
        $data = array('stt'=>"1");
        $stmt = $this->db->get_where('kp_laporan',$data);
        return $stmt;
    }
    function dashboard($page)
    {
        $limit = 5*$page;
        $data = array('dashboard.deleted_flage'=>"1");
        $stmt = $this->db->order_by('dashboard.id_dashboard','DESC')
            ->limit($limit,0)
            ->get_where('dashboard',$data);
        return $stmt;
    }
    function t_dashboard()
    {
        $data = array('dashboard.deleted_flage'=>"1");
        $stmt = $this->db->get_where('dashboard',$data);
        return $stmt;
    }
    function input_dashboard($isi)
    {
        $data = array('isi'=>$isi,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('dashboard',$data);
        return $this->db->insert_id();
    }
    function input_dashboard_files($id,$nama,$size,$tipe)
    {
        $data = array('id_dashboard'=>$id,'nama'=>$nama,'file'=>$nama,'size'=>$size,'tipe'=>$tipe);
        $stmt = $this->db->insert('dashboard_file',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Mengirim dashboard ",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function cek_dashboard_files($id)
    {
        $data = array('id_dashboard'=>$id);
        $stmt = $this->db->get_where('dashboard_file',$data);
        return $stmt;
    }
    public function hapus_dashboard_files($id)
    {
        $stmt2 = $this->db->where('id_dashboard',$id)->delete('dashboard_file');
        $stmt = $this->db->where('id_dashboard',$id)->delete('dashboard');
        $dt = array('id'=>"Admin ",'ket'=>"Hapus dashboard ",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function daftar_kp_mhs()
    {
        $data = array('kp.stt'=>"1");
        $stmt = $this->db->select('kp.id_kp,kp.stt,kp.cdate,kp.deleted_flage,kp_anggota.id_kp,kp_anggota.id_mahasiswa,
                              mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa,kp_perusahaan.id_kp,
                              kp_perusahaan.nama_perusahaan')
            ->join('kp_anggota','kp_anggota.id_kp = kp.id_kp')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->order_by('kp.cdate','DESC')
            ->limit(15,0)
            ->get_where('kp',$data);
        return $stmt;
    }
    function daftar_lap_mhs()
    {
        $data = array('kp.stt'=>"1",'kp_laporan.stt'=>"1",'kp_laporan.deleted_flage'=>"1");
        $stmt = $this->db->select('kp.id_kp,kp.stt,
                              kp_laporan.id_kp_laporan,kp_laporan.cdate,kp_laporan.deleted_flage,kp_laporan.id_kp,kp_laporan.stt,
                              pembimbing_mahasiswa.id_mahasiswa,pembimbing_mahasiswa.id_kp_laporan,
                              mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa,
                              kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan')
            ->join('kp_laporan','kp_laporan.id_kp = kp.id_kp')
            ->join('pembimbing_mahasiswa','pembimbing_mahasiswa.id_kp_laporan = kp_laporan.id_kp_laporan')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = pembimbing_mahasiswa.id_mahasiswa')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->order_by('kp_laporan.cdate','DESC')
            ->limit(15,0)
            ->get_where('kp',$data);
        return $stmt;
    }
    function detail_admin($niy)
    {
        $data = array('niy'=>$niy);
        $stmt = $this->db->get_where('admin',$data);
        return $stmt;
    }
    function daftar_pembimbing_dosen()
    {
        $stmt = $this->db->select('kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan,
                              pembimbing.id_pembimbing,pembimbing.id_kp,pembimbing.cdate,
                              pembimbing_dosen.id_pembimbing,pembimbing_dosen.id_dosen,pembimbing_dosen.id_pembimbing_dosen,
                              dosen.id_dosen,dosen.nama_dosen,dosen.foto_dosen,
                              pembimbing_mahasiswa.id_pembimbing_mahasiswa,pembimbing_mahasiswa.id_pembimbing,
                              pembimbing_mahasiswa.id_mahasiswa,pembimbing_mahasiswa.id_kp_laporan,
                              kp_laporan.id_kp_laporan,kp_laporan.nama_laporan,kp_laporan.stt,
                              mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa')
            ->join('pembimbing','pembimbing.id_kp = kp_perusahaan.id_kp')
            ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
            ->join('dosen','dosen.id_dosen = pembimbing_dosen.id_dosen')
            ->join('pembimbing_mahasiswa','pembimbing_mahasiswa.id_pembimbing = pembimbing.id_pembimbing')
            ->join('kp_laporan','kp_laporan.id_kp_laporan = pembimbing_mahasiswa.id_kp_laporan')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = pembimbing_mahasiswa.id_mahasiswa')
            ->order_by('pembimbing_dosen.id_pembimbing_dosen','DESC')
            ->where(array('pembimbing_mahasiswa.stt_arsip'=>0,'pembimbing_mahasiswa.deleted_flage'=>1,'pembimbing.deleted_flage'=>1))
            ->get('kp_perusahaan');
        return $stmt;
    }
    function daftar_pembimbing_arsipkan($id_pembimbing_mahasiswa,$mahasiswa,$dosen){
        $stmt = $this->db->where('id_pembimbing_mahasiswa',$id_pembimbing_mahasiswa)->update('pembimbing_mahasiswa',array('stt_arsip'=>1,'mdate'=>date('Y-m-d H:i:s')));
        $dt = array('id'=>"Admin ",'ket'=>"Mengarsipkan pembimbing atas nama mahasiswa ".$mahasiswa." dengan dosen ".$dosen,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function arsip_pembimbing_proses($id_pembimbing_mahasiswa,$mahasiswa,$dosen,$type){
        $pesan='';
        if ($type=="restore"){
            $update = array('stt_arsip'=>0,'mdate'=>date('Y-m-d H:i:s'));
            $pesan = "Mengembalikan";
        } else {
            $update = array('deleted_flage'=>0,'ddate'=>date('Y-m-d H:i:s'));
            $pesan = "Menghapus";
        }
        $stmt = $this->db->where('id_pembimbing_mahasiswa',$id_pembimbing_mahasiswa)->update('pembimbing_mahasiswa',$update);
        $dt = array('id'=>"Admin ",'ket'=>$pesan." pembimbing atas nama mahasiswa ".$mahasiswa." dengan dosen ".$dosen,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function daftar_kp_data()
    {
        $data = array('kp.stt'=>"1",'kp.deleted_flage'=>"1",'kp.stt_arsip'=>0);
        $stmt = $this->db->select('kp.id_kp,kp.cdate,kp.stt,kp.deleted_flage,
                              kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan,
                              kp_perusahaan.alamat')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->order_by('kp.cdate','DESC')
            ->get_where('kp',$data);
        return $stmt;
    }
    function daftar_kp_arsipkan($id_kp){
        $stmt = $this->db->where('id_kp',$id_kp)->update('kp',array('stt_arsip'=>1,'mdate'=>date('Y-m-d H:i:s')));
        $dt = array('id'=>"Admin ",'ket'=>"Mengarsipkan id kp ".$id_kp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function arsip_kp_data($length=NULL,$start,$where,$search)
    {
        $this->db->select('kp.id_kp,kp.cdate,kp.stt,kp.deleted_flage,
                              kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan,
                              kp_perusahaan.alamat');
        if($length != -1 && !empty($length)) {
            $this->db->limit($length,$start);
        }
        if (!empty($search)){
            $this->db->group_start();
            $this->db->like("LOWER(kp.id_kp)", strtolower($search));
            $this->db->or_like("LOWER(kp_perusahaan.nama_perusahaan)", strtolower($search));
            $this->db->or_like("LOWER(kp_perusahaan.alamat)", strtolower($search));
            $this->db->group_end();
        }
        return $this->db->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->order_by('YEAR(kp.cdate)','DESC')
            ->get_where('kp',$where);
    }
    function arsip_kp_tahun($where){
        return $this->db->select('YEAR(cdate) as tahun')
            ->group_by('YEAR(cdate)')
            ->order_by('YEAR(cdate)','DESC')
            ->where($where)
            ->get('kp');
    }
    function arsip_kp_proses($id_kp,$type){
        $pesan='';
        if ($type=="restore"){
            $update = array('stt_arsip'=>0,'mdate'=>date('Y-m-d H:i:s'));
            $pesan = "Mengembalikan";
        } else {
            $update = array('deleted_flage'=>0,'ddate'=>date('Y-m-d H:i:s'));
            $pesan = "Menghapus";
        }
        $stmt = $this->db->where('id_kp',$id_kp)->update('kp',$update);
        $dt = array('id'=>"Admin ",'ket'=>$pesan." KP dengan ID ".$id_kp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function daftar_dosen_data()
    {
        $data = array('deleted_flage'=>1,'stt_arsip'=>0);
        $stmt = $this->db->order_by('cdate','DESC')->get_where('dosen',$data);
        return $stmt;
    }
    function daftar_dosen_arsipkan($id,$dosen){
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',array('stt_arsip'=>1,'mdate'=>date('Y-m-d H:i:s')));
        $dt = array('id'=>"Admin ",'ket'=>"Mengarsipkan nama dosen ".$dosen,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function daftar_mahasiswa_data()
    {
        $data = array('deleted_flage'=>1,'stt_arsip'=>0);
        $stmt = $this->db->order_by('cdate','DESC')->get_where('mahasiswa',$data);
        return $stmt;
    }
    function daftar_mahasiswa_arsipkan($id,$mahasiswa){
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',array('stt_arsip'=>1,'mdate'=>date('Y-m-d H:i:s')));
        $dt = array('id'=>"Admin ",'ket'=>"Mengarsipkan nama mahasiswa ".$mahasiswa,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function konfirmasi_daftar_kp()
    {
        $data = array('kp.stt'=>"0",'kp.deleted_flage'=>"1");
        $stmt = $this->db->select('kp.id_kp,kp.stt,kp.create_by,kp.cdate,
                              kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan,kp_perusahaan.alamat,kp_perusahaan.nama_file,
                              mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->join('mahasiswa','kp.create_by = mahasiswa.id_mahasiswa')
            ->order_by('kp.id_kp','DESC')
            ->get_where('kp',$data);
        return $stmt;
    }
    function cek_sikp($idkp)
    {
        $data = array('id_kp'=>$idkp);
        $stmt = $this->db->get_where('kp_perusahaan',$data);
        return $stmt;
    }
    function input_hapus_idkp($idkp)
    {
        $stmt2 = $this->db->where('id_kp',$idkp)->delete('kp_anggota');
        $stmt3 = $this->db->where('id_kp',$idkp)->delete('kp_perusahaan');
        $stmt = $this->db->where('id_kp',$idkp)->delete('kp');
        $dt = array('id'=>"Admin ",'ket'=>"Menghapus ID KP ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_konfirm_idkp($idkp)
    {
        $data = array('stt'=>"1",'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_kp',$idkp)->update('kp',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Konfirmasi ID KP ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function konfirmasi_pembimbing()
    {
        $data = "pembimbing.id_kp IS NULL";
        $data2 = array('kp.stt' => "1");
        $stmt = $this->db->select('kp.id_kp,kp.create_by,
                              kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan,kp_perusahaan.alamat')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->join('pembimbing','pembimbing.id_kp = kp.id_kp','LEFT')
            ->where($data)
            ->where($data2)
            ->get('kp');
        //->get('kp_anggota');
        return $stmt;
    }
    function input_tambah_dosen($id,$password,$nama,$jabatan,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$img,$no_hp,$no_wa)
    {
        $data = array('id_dosen'=>$id,'nama_dosen'=>$nama,'password'=>$password,'jabatan'=>$jabatan,'agama'=>$agama,'tgl_lahir'=>$tgl,
            'bln_lahir'=>$bln,'thn_lahir'=>$thn,'sex'=>$sex,'email'=>$email,'alamat'=>$alamat,'foto_dosen'=>$img,'no_hp'=>$no_hp,'no_wa'=>$no_wa,
            'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('dosen',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Menambahkan dosen baru ID dosen".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_hapus_dosen($id)
    {
        $data = array('ddate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"0");
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Hapus dosen ID dosen ".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubahimg_dosen($id,$img)
    {
        $data = array('foto_dosen'=>$img);
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Ubah foto dosen ID dosen ".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubahpass_dosen($id,$pass)
    {
        $data = array('password'=>$pass);
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Ubah password dosen ID dosen ".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubahprofil_dosen($id,$nama,$jabatan,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$no_hp,$no_wa)
    {
        $data = array('nama_dosen'=>$nama,'jabatan'=>$jabatan,'agama'=>$agama,'tgl_lahir'=>$tgl,
            'bln_lahir'=>$bln,'thn_lahir'=>$thn,'sex'=>$sex,'email'=>$email,'alamat'=>$alamat,'no_hp'=>$no_hp,'no_wa'=>$no_wa,
            'mdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Mengubah profil dosen ID dosen".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubahimg_mahasiswa($id,$img)
    {
        $data = array('foto_mahasiswa'=>$img);
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Ubah foto dosen ID mahasiswa ".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubahpass_mahasiswa($id,$pass)
    {
        $data = array('password'=>$pass);
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Ubah password dosen ID mahasiswa ".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_hapus_mahasiswa($id)
    {
        $data = array('ddate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"0");
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Hapus dosen ID mahasiswa ".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubahprofil_mahasiswa($id,$nama,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$gol_drh,$angkatan,$no_hp,$no_wa)
    {
        $data = array('nama_mahasiswa'=>$nama,'agama'=>$agama,'tgl_lahir'=>$tgl,
            'bln_lahir'=>$bln,'thn_lahir'=>$thn,'sex'=>$sex,'email'=>$email,'alamat'=>$alamat,'golongan_darah'=>$gol_drh,
            'no_hp'=>$no_hp,'no_wa'=>$no_wa,'angkatan'=>$angkatan,'mdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Mengubah profil dosen ID mahasiswa".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_tambah_mahasiswa($id,$password,$nama,$agama,$tgl,$bln,$thn,$sex,$email,$alamat,$img,$angkatan,$no_hp,$no_wa)
    {
        $data = array('id_mahasiswa'=>$id,'nama_mahasiswa'=>$nama,'password'=>$password,'agama'=>$agama,'tgl_lahir'=>$tgl,
            'bln_lahir'=>$bln,'thn_lahir'=>$thn,'sex'=>$sex,'email'=>$email,'alamat'=>$alamat,'foto_mahasiswa'=>$img,
            'no_hp'=>$no_hp,'no_wa'=>$no_wa,'angkatan'=>$angkatan,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('mahasiswa',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Menambahkan mahasiswa baru ID mahasiswa".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_konfirmasi_pembimbing_pembimbing($id)
    {
        $data = array('id_kp'=>$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('pembimbing',$data);
        return $this->db->insert_id();
    }
    function input_konfirmasi_pembimbing_dosen($iddosen,$idpembimbing)
    {
        $data = array('id_pembimbing'=>$idpembimbing,'id_dosen'=>$iddosen,'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->insert('pembimbing_dosen',$data);
        return $stmt;
    }
    function daftar_anggota_kp($id)
    {
        $data = array('kp_anggota.id_kp'=>$id);
        $stmt = $this->db->select('kp_anggota.id_kp_anggota,kp_anggota.id_mahasiswa, mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')
            ->get_where('kp_anggota',$data);
        return $stmt;
    }
    function input_konfirmasi_pembimbing_lap_kp_mhs($id,$idmhs,$id_pembimbing)
    {
        $data = array('id_kp'=>$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('kp_laporan',$data);
        $id_kp_lap = $this->db->insert_id();
        $data2 = array('id_mahasiswa'=>$idmhs,'id_kp_laporan'=>$id_kp_lap,'id_pembimbing'=>$id_pembimbing,'cdate'=>date('Y-m-d H:i:s'));
        $stmt2 = $this->db->insert('pembimbing_mahasiswa',$data2);
        $data3 = array('stt'=>"1");
        $stmt3 = $this->db->where('id_kp',$id)->update('kp',$data3);
        $dt = array('id'=>"Admin ",'ket'=>"Menambahkan pembimbing ID Dosen = ".$id_pembimbing." ke ID KP = ".$id." ID mahasiswa = ".$idmhs,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt2;
    }
    function konfirmasi_laporan_data()
    {
        $data = array('kp_laporan.stt'=>"0");
        $stmt = $this->db->select('pembimbing_mahasiswa.id_mahasiswa,pembimbing_mahasiswa.id_kp_laporan,
                                mahasiswa.id_mahasiswa,mahasiswa.foto_mahasiswa,mahasiswa.nama_mahasiswa,
                                kp_laporan.id_kp_laporan,kp_laporan.nama_laporan,kp_laporan.id_kp,kp_laporan.cdate')
            ->join('kp_laporan','kp_laporan.id_kp_laporan = pembimbing_mahasiswa.id_kp_laporan')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = pembimbing_mahasiswa.id_mahasiswa')
            ->get_where('pembimbing_mahasiswa',$data);
        return $stmt;
    }
    function input_konfirmasi_lap_kp($idlap,$idkp)
    {
        $data = array('stt'=>"1",'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_kp_laporan',$idlap)->where('id_kp',$idkp)->update('kp_laporan',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Mengkonfirmasi laporan mahasiswa ID Laporan ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function deskripsi_kp()
    {
        $data = array('id_deskripsi_kp'=>"1");
        $stmt = $this->db->get_where('deskripsi_kp',$data);
        return $stmt;
    }
    function input_ubah_deskripsi($id,$isi)
    {
        $data = array('isi'=>$isi,'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_deskripsi_kp',$id)->update('deskripsi_kp',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Mengubah deskripsi kp",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function sampul_sliding()
    {
        $stmt = $this->db->get('dashboard_img');
        return $stmt;
    }
    function input_sampul_sliding($img)
    {
        $data = array('img'=>$img,'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->insert('dashboard_img',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Menambahkan gambar sampul saliding",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function hapus_sampul_sliding($id)
    {
        $stmt = $this->db->where('id_dashboard_img',$id)->delete('dashboard_img');
        $dt = array('id'=>"Admin ",'ket'=>"Menghapus gambar sampul saliding",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function sampul_galeri()
    {
        $stmt = $this->db->get('galeri');
        return $stmt;
    }
    function input_sampul_galeri($img,$nm,$size,$tipe)
    {
        $data = array('img'=>$img,'nama'=>$nm,'size'=>$size,'tipe'=>$tipe,'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->insert('galeri',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Menambahkan gambar galeri",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function hapus_sampul_galeri($id)
    {
        $stmt = $this->db->where('id_galeri',$id)->delete('galeri');
        $dt = array('id'=>"Admin ",'ket'=>"Menghapus gambar galeri",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function sosial_link()
    {
        $stmt = $this->db->get('sosial_link');
        return $stmt;
    }
    function input_sosial_link($link,$icon)
    {
        $data = array('link'=>$link,'icon'=>$icon,'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->insert('sosial_link',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Menambahkan sosial link",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function hapus_sosial_link($id)
    {
        $stmt = $this->db->where('id_sosial_link',$id)->delete('sosial_link');
        $dt = array('id'=>"Admin ",'ket'=>"Menghapus sosial link",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function ubah_sosial_link($link,$icon,$id)
    {
        $data = array('link'=>$link,'icon'=>$icon,'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_sosial_link',$id)->update('sosial_link',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Mengubah sosial link",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_img_admin($nama,$niy)
    {
        $data = array('foto_admin'=>$nama);
        $stmt = $this->db->where('niy',$niy)->update('admin',$data);
        $dt = array('id'=>"Admin",'ket'=>"Merubah foto profil",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_biodata_admin($id,$data)
    {
        $stmt = $this->db->where('id_admin',$id)->update('admin',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Merubah biodata",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_pass_admin($niy,$passb)
    {
        $data = array('password'=>$passb);
        $stmt = $this->db->where('niy',$niy)->update('admin',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Merubah password",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function catatan_aktivitas($length=NULL,$start,$where,$search)
    {
        if($length != -1 && !empty($length)) {
            $this->db->limit($length,$start);
        }
        if (!empty($search)){
            $this->db->group_start();
            $this->db->like("id", $search);
            $this->db->or_like("ket", $search);
            $this->db->group_end();
        }
        return $this->db->order_by('id_log_activity', 'DESC')
            ->where($where)
            ->get('log_activity');
    }
    function hapus_catatan_aktivitas()
    {
        $stmt = $this->db->truncate('log_activity');
        $dt = array('id'=>"Admin ",'ket'=>"Menghapus semua catatn aktivitas",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function sistem_dosen()
    {
        $data = array('deleted_flage'=>"0");
        $stmt = $this->db->order_by('ddate',"DESC")->get_where('dosen',$data);
        return $stmt;
    }
    function dosen_terhapus_proses($id_dosen,$nama_dosen,$type){
        $pesan='';
        if ($type=="restore"){
            $pesan = "Mengaktifkan";
            $stmt = $this->db->where('id_dosen',$id_dosen)->update('dosen',array('deleted_flage'=>1,'mdate'=>date('Y-m-d H:i:s')));
        } else {
            $pesan = "Menghapus";
            $stmt = $this->db->where('id_dosen',$id_dosen)->delete('dosen');
        }
        $dt = array('id'=>"Admin ",'ket'=>$pesan." atas nama dosen ".$nama_dosen,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function sistem_mahasiswa()
    {
        $data = array('deleted_flage'=>"0");
        $stmt = $this->db->order_by('ddate',"DESC")->get_where('mahasiswa',$data);
        return $stmt;
    }
    function mahasiswa_terhapus_proses($id_mahasiswa,$nama_mahasiswa,$type){
        $pesan='';
        if ($type=="restore"){
            $pesan = "Mengaktifkan";
            $stmt = $this->db->where('id_mahasiswa',$id_mahasiswa)->update('mahasiswa',array('deleted_flage'=>1,'mdate'=>date('Y-m-d H:i:s')));
        } else {
            $pesan = "Menghapus";
            $stmt = $this->db->where('id_mahasiswa',$id_mahasiswa)->delete('mahasiswa');
        }
        $dt = array('id'=>"Admin ",'ket'=>$pesan." atas nama mahasiswa ".$nama_mahasiswa." NIM ".$id_mahasiswa,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_sikp($id,$nomor,$jumlah,$tgl_mulai,$email)
    {
        $data = array('nomor_surat'=>$nomor,'jml_hari'=>$jumlah,'tgl_mulai'=>$tgl_mulai,'email_d4'=>$email,'cdate'=>date('Y-m-d H:m:s'));
        $stmt = $this->db->where('id_surat_ijin_kp',$id)->update('surat_ijin_kp',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Mengubah surat ijin KP ".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function get_id_pembimbing($id_kp)
    {
        return $this->db->select('id_pembimbing')->where('id_kp',$id_kp)->get('pembimbing');
    }
    function del_pembimbing_dosen($id_pembimbing)
    {
        return $this->db->where('id_pembimbing',$id_pembimbing)->delete('pembimbing_dosen');
    }
    function get_kp_mahasiswa($id_kp)
    {
        return $this->db->select('id_mahasiswa,id_kp')->where('id_kp',$id_kp)->get('kp_anggota');
    }
    function del_kp_laporan($id_kp)
    {
        return $this->db->where('id_kp',$id_kp)->delete('kp_laporan');
    }
    function get_pembimbing_kp($id_pembimbing)
    {
        return $this->db->select('id_dosen')->where('id_pembimbing',$id_pembimbing)->get('pembimbing_dosen');
    }
    function no_read_chat_bo($id_mahasiswa,$id_dosen)
    {
        $data = array('stt_r_mhs'=>"0");
        return $this->db->where('id_mahasiswa',$id_mahasiswa)->where('id_dosen',$id_dosen)->update('bimbingan_online',$data);
    }
    function del_pembimbing_mahasiswa($id_pembimbing)
    {
        return $this->db->where('id_pembimbing',$id_pembimbing)->delete('pembimbing_mahasiswa');
    }
    function get_kp_perusahaan($id_kp)
    {
        return $this->db->select('nama_file')->where('id_kp',$id_kp)->get('kp_perusahaan');
    }
    function del_kp_perusahaan($id_kp)
    {
        return $this->db->where('id_kp',$id_kp)->delete('kp_perusahaan');
    }
    function del_kp_harian($id_kp)
    {
        return $this->db->where('id_kp',$id_kp)->delete('kp_harian');
    }
    function del_kp_bimbingan($id_kp)
    {
        return $this->db->where('id_kp',$id_kp)->delete('kp_bimbingan');
    }
    function del_kp_anggota($id_kp)
    {
        return $this->db->where('id_kp',$id_kp)->delete('kp_anggota');
    }
    function del_pembimbing($id_kp)
    {
        return $this->db->where('id_kp',$id_kp)->delete('pembimbing');
    }
    function del_kp($id_kp)
    {
        return $this->db->where('id_kp',$id_kp)->delete('kp');
    }
    function lap_grafik_kp_cek_wilayah($where,$cek=FALSE){
        $this->db->select('wilayah.wilayah, kp_perusahaan.*')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->join('wilayah','wilayah.id_wilayah = kp_perusahaan.id_wilayah')
            ->where($where);
        if ($cek){
            $this->db->group_by('wilayah.id_wilayah');
        }
        return $this->db->get('kp');
    }
    function lap_grafik_kp_cek_bidang($where,$cek=FALSE){
        $this->db->select('bidang_kerja.bidang_kerja, kp_perusahaan.*')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->join('bidang_kerja','bidang_kerja.id_bidang_kerja = kp_perusahaan.id_bidang_kerja')
            ->where($where);
        if ($cek){
            $this->db->group_by('bidang_kerja.id_bidang_kerja');
        }
        return $this->db->get('kp');
    }
    function daftar_wilayah($length=NULL,$start,$where,$search)
    {
        if($length != -1 && !empty($length)) {
            $this->db->limit($length,$start);
        }
        if (!empty($search)){
            $this->db->group_start();
            $this->db->like("LOWER(wilayah)", strtolower($search));
            $this->db->group_end();
        }
        return $this->db->order_by('id_wilayah', 'DESC')
            ->where($where)
            ->get('wilayah');
    }
    function input_hapus_wilayah($id,$wilayah)
    {
        $data = array('ddate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"0");
        $stmt = $this->db->where('id_wilayah',$id)->update('wilayah',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Hapus wilayah ".$wilayah,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function wilayah_detail($id){
        return $this->db->get_where('wilayah',array('id_wilayah'=>$id));
    }
    function input_ubah_wilayah($id,$wilayah)
    {
        $data = array('wilayah'=>$wilayah,'mdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_wilayah',$id)->update('wilayah',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Ubah wilayah ".$wilayah,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_tambah_wilayah($wilayah)
    {
        $data = array('wilayah'=>$wilayah,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('wilayah',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Menambahkan wilayah baru ".$wilayah,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function daftar_bidang_kerja($length=NULL,$start,$where,$search)
    {
        if($length != -1 && !empty($length)) {
            $this->db->limit($length,$start);
        }
        if (!empty($search)){
            $this->db->group_start();
            $this->db->like("LOWER(bidang_kerja)", strtolower($search));
            $this->db->group_end();
        }
        return $this->db->order_by('id_bidang_kerja', 'DESC')
            ->where($where)
            ->get('bidang_kerja');
    }
    function input_hapus_bidang_kerja($id,$bidang_kerja)
    {
        $data = array('ddate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"0");
        $stmt = $this->db->where('id_bidang_kerja',$id)->update('bidang_kerja',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Hapus bidang_kerja ".$bidang_kerja,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function bidang_kerja_detail($id){
        return $this->db->get_where('bidang_kerja',array('id_bidang_kerja'=>$id));
    }
    function input_ubah_bidang_kerja($id,$bidang_kerja)
    {
        $data = array('bidang_kerja'=>$bidang_kerja,'mdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_bidang_kerja',$id)->update('bidang_kerja',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Ubah bidang_kerja ".$bidang_kerja,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_tambah_bidang_kerja($bidang_kerja)
    {
        $data = array('bidang_kerja'=>$bidang_kerja,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('bidang_kerja',$data);
        $dt = array('id'=>"Admin ",'ket'=>"Menambahkan bidang_kerja baru ".$bidang_kerja,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function arsip_pembimbing_tahun(){
        return $this->db->select('YEAR(pembimbing.cdate) as tahun')
            ->join('pembimbing_mahasiswa','pembimbing_mahasiswa.id_pembimbing = pembimbing.id_pembimbing')
            ->group_by('YEAR(pembimbing.cdate)')
            ->where(array('pembimbing_mahasiswa.stt_arsip'=>1,'pembimbing.deleted_flage'=>1))
            ->get('pembimbing');
    }

    function arsip_pembimbing_json($length=NULL,$start,$where,$search){
        if($length != -1 && !empty($length)) {
            $this->db->limit($length,$start);
        }
        if (!empty($search)){
            $this->db->group_start();
            $this->db->like("LOWER(dosen.nama_dosen)", strtolower($search));
            $this->db->or_like("LOWER(mahasiswa.nama_mahasiswa)", strtolower($search));
            $this->db->or_like("LOWER(kp_perusahaan.id_kp)", strtolower($search));
            $this->db->or_like("LOWER(kp_perusahaan.nama_perusahaan)", strtolower($search));
            $this->db->group_end();
        }
        $this->db->select('kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan,
                              pembimbing.id_pembimbing,pembimbing.id_kp,pembimbing.cdate,
                              pembimbing_dosen.id_pembimbing,pembimbing_dosen.id_dosen,pembimbing_dosen.id_pembimbing_dosen,
                              dosen.id_dosen,dosen.nama_dosen,dosen.foto_dosen,
                              pembimbing_mahasiswa.id_pembimbing,pembimbing_mahasiswa.id_pembimbing_mahasiswa,
                              pembimbing_mahasiswa.id_mahasiswa,pembimbing_mahasiswa.id_kp_laporan,
                              kp_laporan.id_kp_laporan,kp_laporan.nama_laporan,kp_laporan.stt,
                              mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa')
            ->join('pembimbing','pembimbing.id_kp = kp_perusahaan.id_kp')
            ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
            ->join('dosen','dosen.id_dosen = pembimbing_dosen.id_dosen')
            ->join('pembimbing_mahasiswa','pembimbing_mahasiswa.id_pembimbing = pembimbing.id_pembimbing')
            ->join('kp_laporan','kp_laporan.id_kp_laporan = pembimbing_mahasiswa.id_kp_laporan')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = pembimbing_mahasiswa.id_mahasiswa')
            ->order_by('pembimbing_dosen.id_pembimbing_dosen','DESC');
        return $this->db->get_where('kp_perusahaan',$where);
    }
    function arsip_dosen_tahun(){
        return $this->db->select('YEAR(cdate) as tahun')
            ->group_by('YEAR(cdate)')
            ->where(array('stt_arsip'=>1,'deleted_flage'=>1))
            ->get('dosen');
    }
    function arsip_dosen_json($length=NULL,$start,$where,$search){
        if($length != -1 && !empty($length)) {
            $this->db->limit($length,$start);
        }
        if (!empty($search)){
            $this->db->group_start();
            $this->db->like("LOWER(nama_dosen)", strtolower($search));
            $this->db->or_like("LOWER(id_dosen)", strtolower($search));
            $this->db->or_like("LOWER(alamat)", strtolower($search));
            $this->db->or_like("LOWER(email)", strtolower($search));
            $this->db->or_like("LOWER(jabatan)", strtolower($search));
            $this->db->group_end();
        }
        $this->db->order_by('id_dosen','DESC');
        return $this->db->get_where('dosen',$where);
    }
    function arsip_dosen_proses($id_dosen,$nama_dosen,$type){
        $pesan='';
        if ($type=="restore"){
            $update = array('stt_arsip'=>0,'mdate'=>date('Y-m-d H:i:s'));
            $pesan = "Mengembalikan";
        } else {
            $update = array('deleted_flage'=>0,'ddate'=>date('Y-m-d H:i:s'));
            $pesan = "Menghapus";
        }
        $stmt = $this->db->where('id_dosen',$id_dosen)->update('dosen',$update);
        $dt = array('id'=>"Admin ",'ket'=>$pesan." dosen atas nama dosen ".$nama_dosen,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function arsip_mahasiswa_tahun(){
        return $this->db->select('YEAR(cdate) as tahun')
            ->group_by('YEAR(cdate)')
            ->where(array('stt_arsip'=>1,'deleted_flage'=>1))
            ->get('mahasiswa');
    }
    function arsip_mahasiswa_json($length=NULL,$start,$where,$search){
        if($length != -1 && !empty($length)) {
            $this->db->limit($length,$start);
        }
        if (!empty($search)){
            $this->db->group_start();
            $this->db->like("LOWER(nama_mahasiswa)", strtolower($search));
            $this->db->or_like("LOWER(id_mahasiswa)", strtolower($search));
            $this->db->or_like("LOWER(alamat)", strtolower($search));
            $this->db->or_like("LOWER(email)", strtolower($search));
            $this->db->or_like("LOWER(angkatan)", strtolower($search));
            $this->db->group_end();
        }
        return $this->db->order_by('id_mahasiswa','DESC')->get_where('mahasiswa',$where);
    }
    function arsip_mahasiswa_proses($id_mahasiswa,$nama_mahasiswa,$type){
        $pesan='';
        if ($type=="restore"){
            $update = array('stt_arsip'=>0,'mdate'=>date('Y-m-d H:i:s'));
            $pesan = "Mengembalikan";
        } else {
            $update = array('deleted_flage'=>0,'ddate'=>date('Y-m-d H:i:s'));
            $pesan = "Menghapus";
        }
        $stmt = $this->db->where('id_mahasiswa',$id_mahasiswa)->update('mahasiswa',$update);
        $dt = array('id'=>"Admin ",'ket'=>$pesan." atas nama mahasiswa ".$nama_mahasiswa,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $this->db->insert('log_activity',$dt);
        return $stmt;
    }
}
