<?php

class Mmahasiswa extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        //ALTER TABLE kp_laporan AUTO_INCREMENT = 1
    }
    function nama_ka_prodi()
    {
        $data = array('jabatan'=>"Ka. Prodi");
        return $this->db->get_where('dosen',$data);
    }
    function update_tahun_print_terakhir($data)
    {
        return $this->db->where('id_surat_ijin_kp',"1")->update('surat_ijin_kp',$data);
    }
    function update_nomor_surat_keluar($data)
    {
        return $this->db->where('id_surat_ijin_kp',"1")->update('surat_ijin_kp',$data);
    }
    function add_colum()
    {
        return $this->db->query('ALTER TABLE surat_ijin_kp ADD nomor_surat_keluar INT(5) NOT NULL DEFAULT 0, ADD tahun_print_terakhir INT(4) NOT NULL DEFAULT 2017');
    }
    function sikp()
    {
        $data = array('id_surat_ijin_kp'=>"1");
        return $this->db->get_where('surat_ijin_kp',$data);
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
    function bidang_kerja(){
        return $this->db->order_by('id_bidang_kerja',"DESC")->get_where('bidang_kerja',array('deleted_flage'=>1));
    }
    function bidang_kerja_input($bid_kerja_lainnya){
        $data = array('bidang_kerja'=>$bid_kerja_lainnya,'cdate'=>date('Y-m-d H:i:s'));
        $this->db->insert('bidang_kerja',$data);
        return $this->db->insert_id();
    }
    function wilayah(){
        return $this->db->order_by('id_wilayah',"DESC")->get_where('wilayah',array('deleted_flage'=>1));
    }
    function wilayah_input($wilayah){
        $data = array('wilayah'=>$wilayah,'cdate'=>date('Y-m-d H:i:s'));
        $this->db->insert('wilayah',$data);
        return $this->db->insert_id();
    }
    function data_perusahaan($id_mahasiswa)
    {
        $data = array('id_mahasiswa'=>$id_mahasiswa);
        $this->db->select('kp_anggota.id_kp,kp_anggota.id_mahasiswa,
                        kp_perusahaan.id_kp, kp_perusahaan.nama_perusahaan, kp_perusahaan.deskripsi,
                        kp_perusahaan.alamat, kp_perusahaan.file, kp_perusahaan.nama_file,
                        kp_perusahaan.size, kp_perusahaan.tipe, 
                        bidang_kerja.id_bidang_kerja, bidang_kerja.bidang_kerja,
                        wilayah.id_wilayah, wilayah.wilayah,
                        kp.stt')
            ->join('kp_perusahaan','kp_anggota.id_kp = kp_perusahaan.id_kp')
            ->join('kp','kp.id_kp = kp_perusahaan.id_kp')
            ->join('bidang_kerja','bidang_kerja.id_bidang_kerja = kp_perusahaan.id_bidang_kerja','left')
            ->join('wilayah','wilayah.id_wilayah = kp_perusahaan.id_wilayah','left');
        $stmt = $this->db->get_where('kp_anggota',$data);
        return $stmt;
    }
    function data_kp_harian($id)
    {
        $data = array('id_mahasiswa'=>$id);
        $stmt = $this->db->get_where('kp_harian',$data);
        return $stmt;
    }
    function cek_data_kp_harian($id)
    {
        $data = array('pembimbing_mahasiswa.id_mahasiswa'=>$id);
        $stmt = $this->db->select('pembimbing_mahasiswa.id_mahasiswa,pembimbing_mahasiswa.id_pembimbing,
                                pembimbing.id_pembimbing,pembimbing.id_kp')
            ->join('pembimbing','pembimbing.id_pembimbing = pembimbing_mahasiswa.id_pembimbing')
            ->limit(0,1)->get_where('pembimbing_mahasiswa',$data);
        return $stmt;
    }
    function input_data_kp_harian($id,$idkp,$idpmb,$ket)
    {
        $data = array('id_mahasiswa'=>$id,'id_kp'=>$idkp,'ket'=>$ket,'id_pembimbing'=>$idpmb,'tgl'=>date('Y-m-d'),'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->insert('kp_harian',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Memasukan tugas harian KP, ID KP".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function hapus_kp_harian($id,$idmhs)
    {
        $stmt = $this->db->where('id_kp_harian',$id)->delete('kp_harian');
        $dt = array('id'=>"ID Mahasiswa ".$idmhs,'ket'=>"Hapus tugas harian KP",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function data_kp_bimbingan($id)
    {
        $data = array('kp_bimbingan.id_mahasiswa'=>$id);
        $stmt = $this->db->select('kp_bimbingan.id_kp_bimbingan,kp_bimbingan.id_pembimbing,kp_bimbingan.id_mahasiswa,kp_bimbingan.id_kp,
                                kp_bimbingan.tgl,kp_bimbingan.cdate,kp_bimbingan.ttd_by,kp_bimbingan.ket,dosen.id_dosen,dosen.nama_dosen')
            ->join('dosen','dosen.id_dosen = kp_bimbingan.ttd_by')
            ->get_where('kp_bimbingan',$data);
        return $stmt;
    }
    function cek_id_kp($id_mahasiswa)
    {
        $data = array('kp_anggota.id_mahasiswa'=>$id_mahasiswa,'kp.deleted_flage'=>"1");
        $this->db->select('kp.id_kp,kp.stt,kp.create_by,kp.deleted_flage,kp_anggota.id_mahasiswa,kp_anggota.id_kp,
                        mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa')
            ->join('kp_anggota','kp_anggota.id_kp = kp.id_kp')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa');
        $stmt = $this->db->get_where('kp',$data);
        return $stmt;
    }
    function cek_pembuat_id_kp($id_mahasiswa)
    {
        $data = array('id_mahasiswa'=>$id_mahasiswa);
        $this->db->select('nama_mahasiswa');
        $stmt = $this->db->get_where('mahasiswa',$data);
        return $stmt;
    }
    function daftar_anggota_kp($id_kp)
    {
        $data = array('kp.id_kp'=>$id_kp,'kp.deleted_flage'=>"1");
        $this->db->select('kp.id_kp, kp.deleted_flage, kp_anggota.id_kp, kp_anggota.id_mahasiswa, kp_anggota.cdate,
                        mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa')
            ->join('kp_anggota','kp_anggota.id_kp = kp.id_kp')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa');
        $stmt = $this->db->get_where('kp',$data);
        return $stmt;
    }
    function daftar_pembimbing_kp($id_kp)
    {
        $data = array('pembimbing.id_kp' => $id_kp);
        $this->db->select('pembimbing.id_pembimbing, pembimbing.id_kp, pembimbing_dosen.id_pembimbing,
                        pembimbing_dosen.id_dosen, dosen.id_dosen, dosen.nama_dosen,dosen.foto_dosen')
            ->join('pembimbing_dosen','pembimbing.id_pembimbing = pembimbing_dosen.id_pembimbing')
            ->join('dosen','dosen.id_dosen = pembimbing_dosen.id_dosen');
        $stmt = $this->db->get_where('pembimbing',$data);
        return $stmt;
    }
    function detail_mahasiswa($id_mahasiswa)
    {
        $data = array('id_mahasiswa'=>$id_mahasiswa);
        $stmt = $this->db->get_where('mahasiswa',$data);
        return $stmt;
    }
    function detail_dosen($id_dosen)
    {
        $data = array('id_dosen'=>$id_dosen);
        $stmt = $this->db->get_where('dosen',$data);
        return $stmt;
    }

    function detail_kp($idkp)
    {
        $data = array('kp.id_kp'=>$idkp);
        $stmt = $this->db->select('kp.id_kp,kp.create_by,kp.cdate,kp.stt,
                              kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan,kp_perusahaan.alamat,kp_perusahaan.deskripsi,
                              kp_perusahaan.nama_file,kp_perusahaan.size,kp_perusahaan.tipe,
                              mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa,
                              wilayah.wilayah, wilayah.id_wilayah, 
                              bidang_kerja.bidang_kerja, bidang_kerja.id_bidang_kerja')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = kp.create_by')
            ->join('wilayah','wilayah.id_wilayah = kp_perusahaan.id_wilayah')
            ->join('bidang_kerja','bidang_kerja.id_bidang_kerja = kp_perusahaan.id_bidang_kerja')
            ->get_where('kp',$data);
        return $stmt;
    }
    function data_kp($id_mahasiswa)
    {
        $data = array('pembimbing_mahasiswa.id_mahasiswa'=>$id_mahasiswa);
        $this->db->select('pembimbing_mahasiswa.id_mahasiswa, pembimbing_mahasiswa.id_kp_laporan,
                        kp_laporan.id_kp_laporan,kp_laporan.nama_laporan,kp_laporan.size,kp_laporan.size,
                        kp_laporan.file,kp_laporan.stt,kp_laporan.tipe')
            ->join('kp_laporan','kp_laporan.id_kp_laporan = pembimbing_mahasiswa.id_kp_laporan');
        $stmt = $this->db->get_where('pembimbing_mahasiswa',$data);
        return $stmt;
    }
    function daftar_mahasiswa_kp()
    {
        $data = array('kp.stt'=>"1",'kp.deleted_flage'=>"1");
        $stmt = $this->db->select('kp.id_kp,kp.stt,kp.deleted_flage,
                        kp_anggota.id_kp,kp_anggota.id_mahasiswa,
                        kp_perusahaan.nama_perusahaan,kp_perusahaan.id_kp,kp_perusahaan.alamat,
                        mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa,
                        pembimbing.id_pembimbing,pembimbing.id_kp')
            ->join('kp_anggota','kp_anggota.id_kp = kp.id_kp')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = kp_anggota.id_mahasiswa')
            ->join('pembimbing','pembimbing.id_kp = kp.id_kp')
            ->order_by('kp.cdate','DESC')
            ->get_where('kp',$data);
        return $stmt;
    }
    function daftar_lap_kp()
    {
        $data = array('kp.stt'=>"1",'kp.deleted_flage'=>"1",'kp_laporan.stt'=>"1");
        $stmt = $this->db->select('kp.id_kp,kp.stt,kp.deleted_flage,
                        kp_perusahaan.id_kp, kp_perusahaan.nama_perusahaan,
                        kp_laporan.id_kp, kp_laporan.nama_laporan, kp_laporan.stt, kp_laporan.id_kp_laporan,
                        pembimbing_mahasiswa.id_mahasiswa, pembimbing_mahasiswa.id_kp_laporan,
                        mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa,
                        pembimbing.id_pembimbing, pembimbing.id_kp')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp.id_kp')
            ->join('kp_laporan','kp_laporan.id_kp = kp.id_kp')
            ->join('pembimbing_mahasiswa','pembimbing_mahasiswa.id_kp_laporan = kp_laporan.id_kp_laporan')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = pembimbing_mahasiswa.id_mahasiswa')
            ->join('pembimbing','pembimbing.id_kp = kp.id_kp')
            ->order_by('kp_laporan.cdate','DESC')
            ->get_where('kp',$data);
        return $stmt;
    }
    function data_chat($id,$nim,$stt)
    {
        if ($stt == "mhs")
        {
            $data = array('bimbingan_online.stt_r_mhs'=>"1",'bimbingan_online.id_dosen'=>$id,'bimbingan_online.id_mahasiswa'=>$nim,
                'bimbingan_online.deleted_flage'=>"1");
            $stmt = $this->db->select('bimbingan_online.id_mahasiswa,bimbingan_online.id_dosen,bimbingan_online.send_by,
                          bimbingan_online.isi,bimbingan_online.size, bimbingan_online.tipe,bimbingan_online.id_bimbingan_online,
                          bimbingan_online.nama_file, bimbingan_online.stt_chat, bimbingan_online.cdate,
                          dosen.id_dosen,dosen.nama_dosen,dosen.foto_dosen,dosen.stt_login_dosen,dosen.ldate_dosen,
                          mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa,mahasiswa.stt_login_mahasiswa,
                          mahasiswa.ldate_mahasiswa')
                ->join('mahasiswa','mahasiswa.id_mahasiswa = bimbingan_online.id_mahasiswa')
                ->join('dosen','dosen.id_dosen = bimbingan_online.id_dosen')
                ->order_by('bimbingan_online.id_bimbingan_online','DESC')
                ->get_where('bimbingan_online',$data);
        }
        elseif ($stt == "dsn")
        {
            $data = array('bimbingan_online.stt_r_dsn'=>"1",'bimbingan_online.id_dosen'=>$id,'bimbingan_online.id_mahasiswa'=>$nim,
                'bimbingan_online.deleted_flage'=>"1");
            $stmt = $this->db->select('bimbingan_online.id_mahasiswa,bimbingan_online.id_dosen,bimbingan_online.send_by,
                          bimbingan_online.isi,bimbingan_online.size, bimbingan_online.tipe,bimbingan_online.id_bimbingan_online,
                          bimbingan_online.nama_file, bimbingan_online.stt_chat, bimbingan_online.cdate,
                          dosen.id_dosen,dosen.nama_dosen,dosen.foto_dosen,dosen.stt_login_dosen,dosen.ldate_dosen,
                          mahasiswa.id_mahasiswa, mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa,mahasiswa.stt_login_mahasiswa,
                          mahasiswa.ldate_mahasiswa')
                ->join('mahasiswa','mahasiswa.id_mahasiswa = bimbingan_online.id_mahasiswa')
                ->join('dosen','dosen.id_dosen = bimbingan_online.id_dosen')
                ->order_by('bimbingan_online.id_bimbingan_online','DESC')
                ->get_where('bimbingan_online',$data);
        }
        return $stmt;
    }
    function cek_chat($iddsn,$nim,$stt)
    {
        $data = array('stt_chat'=>"0");
        $stmt = $this->db->where('id_dosen',$iddsn)->where('id_mahasiswa',$nim)->where('send_by',$stt)
            ->update('bimbingan_online',$data);
        return $stmt;
    }
    public function input_chat($nim,$chat,$iddsn,$tipe,$size,$file,$stt,$by)
    {
        $data = array('id_mahasiswa'=>$nim,'isi'=>$chat,'id_dosen'=>$iddsn,'tipe'=>$tipe,'size'=>$size,'nama_file'=>$file,'stt_chat'=>$stt,'send_by'=>$by,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('bimbingan_online',$data);
        if ($by == "mahasiswa") {
            $dt = array('id'=>"ID Mahasiswa ".$nim,'ket'=>"Input chat dengan ID Dosen ".$iddsn,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
            $stt = $this->db->insert('log_activity',$dt);
        }
        else {
            $dt = array('id'=>"ID Dosen ".$iddsn,'ket'=>"Input chat dengan ID Mahasiswa ".$nim,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
            $stt = $this->db->insert('log_activity',$dt);
        }
        return $stmt;
    }
    function daftar_pembimbing_chat($id)
    {
        $data = array('pembimbing_mahasiswa.id_mahasiswa'=>$id);
        $stmt = $this->db->select('pembimbing.id_kp,pembimbing.id_pembimbing,
                        pembimbing_dosen.id_pembimbing,pembimbing_dosen.id_dosen,
                        pembimbing_mahasiswa.id_pembimbing, pembimbing_mahasiswa.id_mahasiswa,
                        dosen.id_dosen,dosen.nama_dosen,dosen.foto_dosen')
            ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
            ->join('pembimbing_mahasiswa','pembimbing_mahasiswa.id_pembimbing = pembimbing.id_pembimbing')
            ->join('dosen','dosen.id_dosen = pembimbing_dosen.id_dosen')
            ->get_where('pembimbing',$data);
        return $stmt;
    }
    function daftar_membimbing_chat($id)
    {
        $data = array('pembimbing_dosen.id_dosen'=>$id);
        $stmt = $this->db->select('pembimbing.id_kp,pembimbing.id_pembimbing,
                        pembimbing_dosen.id_pembimbing,pembimbing_dosen.id_dosen,
                        pembimbing_mahasiswa.id_pembimbing, pembimbing_mahasiswa.id_mahasiswa,pembimbing_mahasiswa.id_kp_laporan,
                        mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa,
                        kp_laporan.id_kp_laporan,kp_laporan.nama_laporan,kp_laporan.stt')
            ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
            ->join('pembimbing_mahasiswa','pembimbing_mahasiswa.id_pembimbing = pembimbing.id_pembimbing')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = pembimbing_mahasiswa.id_mahasiswa')
            ->join('kp_laporan','kp_laporan.id_kp_laporan = pembimbing_mahasiswa.id_kp_laporan')
            ->order_by('pembimbing_mahasiswa.id_pembimbing_mahasiswa','DESC')
            ->get_where('pembimbing',$data);
        return $stmt;
    }
    function clear_chat($iddsn,$nim,$stt)
    {
        if ($stt == "mahasiswa")
        {
            $data = array('stt_r_mhs'=>"0");
        }
        if ($stt == "dosen")
        {
            $data = array('stt_r_dsn'=>"0");
        }
        $stmt = $this->db->where('id_dosen',$iddsn)->where('id_mahasiswa',$nim)->update('bimbingan_online',$data);
        return $stmt;
    }
    function daftar_dosen_membimbing($id)
    {
        $data = array('pembimbing_dosen.id_dosen'=>$id);
        $stmt = $this->db->select('pembimbing.id_kp,pembimbing.id_pembimbing,
                        pembimbing_dosen.id_pembimbing,pembimbing_dosen.id_dosen,
                        pembimbing_mahasiswa.id_pembimbing, pembimbing_mahasiswa.id_mahasiswa,pembimbing_mahasiswa.id_kp_laporan,
                        mahasiswa.id_mahasiswa,mahasiswa.nama_mahasiswa,mahasiswa.foto_mahasiswa,
                        kp_laporan.id_kp_laporan,kp_laporan.nama_laporan,kp_laporan.stt,
                        kp_perusahaan.id_kp,kp_perusahaan.nama_perusahaan')
            ->join('pembimbing_dosen','pembimbing_dosen.id_pembimbing = pembimbing.id_pembimbing')
            ->join('pembimbing_mahasiswa','pembimbing_mahasiswa.id_pembimbing = pembimbing.id_pembimbing')
            ->join('mahasiswa','mahasiswa.id_mahasiswa = pembimbing_mahasiswa.id_mahasiswa')
            ->join('kp_laporan','kp_laporan.id_kp_laporan = pembimbing_mahasiswa.id_kp_laporan')
            ->join('kp_perusahaan','kp_perusahaan.id_kp = kp_laporan.id_kp')
            ->order_by('pembimbing_mahasiswa.id_pembimbing_mahasiswa','DESC')
            ->get_where('pembimbing',$data);
        return $stmt;
    }

    function input_baru_idkp($idkp,$id)
    {
        $data = array('id_kp'=>$idkp,'create_by'=>$id,'stt'=>"0",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stmt = $this->db->insert('kp',$data);
        $data2 = array('id_kp'=>$idkp,'id_mahasiswa'=>$id,'cdate'=>date('Y-m-d H:i:s'));
        $stmt2 = $this->db->insert('kp_anggota',$data2);
        $data3 = array('id_kp'=>$idkp);
        $stmt3 = $this->db->insert('kp_perusahaan',$data3);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Menambahkan ID KP baru ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt3;
    }
    function input_join_idkp($idkp,$id)
    {
        $data = array('id_kp'=>$idkp,'id_mahasiswa'=>$id,'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->insert('kp_anggota',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Bergabung dengan ID KP ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_keluar_idkp($idkp,$id)
    {
        $stmt = $this->db->where('id_kp',$idkp)->where('id_mahasiswa',$id)->delete('kp_anggota');
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Keluar dari ID KP ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_keluarkan_idkp($idkp,$nim,$id)
    {
        $stmt = $this->db->where('id_kp',$idkp)->where('id_mahasiswa',$nim)->delete('kp_anggota');
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Mengeluarkan anggota dari ID KP ".$nim,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    public function cek_nim_mahasiswa($nim)
    {
        $data = array('id_mahasiswa'=>$nim);
        return $this->db->get_where('mahasiswa',$data);
    }
    public function cek_kp_mahasiswa($nim){
        return $this->db->join('kp','kp.id_kp = kp.id_kp')
            ->where(array('kp_anggota.id_mahasiswa'=>$nim,'kp.deleted_flage'=>1))
            ->get('kp_anggota');
    }
    function input_tambah_idkp($idkp,$id,$nim)
    {
        $data = array('id_kp'=>$idkp,'id_mahasiswa'=>$nim,'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->insert('kp_anggota',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Menambahkan anggota ke ID KP ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function cek_sikp($idkp)
    {
        $data = array('id_kp'=>$idkp);
        $stmt = $this->db->get_where('kp_perusahaan',$data);
        return $stmt;
    }
    function input_hapus_idkp($idkp,$id)
    {
        $stmt2 = $this->db->where('id_kp',$idkp)->delete('kp_anggota');
        $stmt3 = $this->db->where('id_kp',$idkp)->delete('kp_perusahaan');
        $stmt = $this->db->where('id_kp',$idkp)->delete('kp');
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Menghapus ID KP ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_dt_pers($data,$idkp,$id)
    {
        $stmt = $this->db->where('id_kp',$idkp)->update('kp_perusahaan',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Memasukan data perusahaan",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_dokumen_pers($nama,$size,$tipe,$idkp,$id)
    {
        $data = array('nama_file'=>$nama,'size'=>$size,'tipe'=>$tipe);
        $stmt = $this->db->where('id_kp',$idkp)->update('kp_perusahaan',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Memasukan data dokumen perusahaan ID KP ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_dokumen_lap_kp($judul,$idkp,$id,$id_lap)
    {
        $data = array('nama_laporan'=>$judul,'stt'=>"0",'cdate'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_kp_laporan',$id_lap)->where('id_kp',$idkp)->update('kp_laporan',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Unggah data laporan KP, ID KP ".$idkp,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_img($nama,$id)
    {
        $data = array('foto_mahasiswa'=>$nama);
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Merubah foto",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_biodata($id,$data)
    {
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Merubah biodata",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_pass($id,$passb)
    {
        $data = array('password'=>$passb);
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Merubah password",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_img_dosen($nama,$id)
    {
        $data = array('foto_dosen'=>$nama);
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
        $dt = array('id'=>"ID Dosen ".$id,'ket'=>"Merubah foto",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_biodata_dosen($id,$data)
    {
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
        $dt = array('id'=>"ID Dosen ".$id,'ket'=>"Merubah biodata",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_ubah_pass_dosen($id,$passb)
    {
        $data = array('password'=>$passb);
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
        $dt = array('id'=>"ID Dosen ".$id,'ket'=>"Merubah password",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function input_data_kp_bimbingan($id,$idkp,$idpmb,$ket,$iddsn)
    {
        $data = array('id_mahasiswa'=>$id,'id_kp'=>$idkp,'ket'=>$ket,'id_pembimbing'=>$idpmb,'ttd_by'=>$iddsn,
            'tgl'=>date('Y-m-d'),'cdate'=>date('Y-m-d H:i:s'),);
        $stmt = $this->db->insert('kp_bimbingan',$data);
        $dt = array('id'=>"ID Dosen ".$iddsn,'ket'=>"Memasukan catatan bimbingan ID Mahasiswa".$id,'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function hapus_kp_bimbingan($id,$iddsn)
    {
        $stmt = $this->db->where('id_kp_bimbingan',$id)->delete('kp_bimbingan');
        $dt = array('id'=>"ID Dosen ".$iddsn,'ket'=>"Hapus bimbingan KP",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function logout_mhs($id)
    {
        $data = array('stt_login_mahasiswa'=>"0",'ldate_mahasiswa'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_mahasiswa',$id)->update('mahasiswa',$data);
        $dt = array('id'=>"ID Mahasiswa ".$id,'ket'=>"Logout ",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function logout_dsn($id)
    {
        $data = array('stt_login_dosen'=>"0",'ldate_dosen'=>date('Y-m-d H:i:s'));
        $stmt = $this->db->where('id_dosen',$id)->update('dosen',$data);
        $dt = array('id'=>"ID Dosen ".$id,'ket'=>"Logout ",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stmt;
    }
    function logout_adm($id)
    {
        $dt = array('id'=>"Admin ",'ket'=>"Logout ",'cdate'=>date('Y-m-d H:i:s'),'deleted_flage'=>"1");
        $stt = $this->db->insert('log_activity',$dt);
        return $stt;
    }
    function detail_img_dashboard($id)
    {
        return $this->db->where('id_dashboard_file',$id)->get('dashboard_file');
    }
    function get_id_kp($id)
    {
        return $this->db->select('id_kp')->where('id_mahasiswa',$id)->get('kp_anggota');
    }
    function log_activity($data)
    {
        return $this->db->insert('log_activity',$data);
    }
}
