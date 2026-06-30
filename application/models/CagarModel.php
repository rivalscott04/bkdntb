<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CagarModel extends CI_Model{
	public function __construct(){
		parent :: __construct();	
	}
	
	public function getDataSekolah()
	{
		$thn= date('Y');
		$sql = "SELECT * from sidikjari.sekolah";
		$query = $this->db->query($sql);
	 	return $query->result_array();
	}

	public function getDataDetailById($id)
	{
		$sql = "SELECT a.*,b.id_sekolah,b.nm_kepsek,b.longlat,b.jml_kelas_baik, b.jml_kelas_rr,b.jml_kelas_rs,b.jml_kelas_rb,
		 b.jml_lab_ipa, b.jml_lab_ips,b.jml_lab_kimia,b.jml_lab_fisika,b.jml_lab_bio,b.jml_lab_bahasa,b.jml_lab_komp,
		 b.ruang_kepsek, b.ruang_guru,b.ruang_tu,b.jml_perpus,b.jml_uks,b.wc_guru,b.wc_siswa,
		 b.jml_siswa1_l, b.jml_siswa1_p,b.jml_siswa2_l,b.jml_siswa2_p,b.jml_siswa3_l,b.jml_siswa3_p,
		 b.jml_guru,b.jml_guru_tt,b.jml_tu,b.sk_ppid,b.link_video,b.kuota_ppdb  

		from sma a JOIN sidikjari.sekolah b ON a.npsn=b.npsn where a.npsn=?";
		$query = $this->db->query($sql,array($id));
	 	return $query->row();
	}

	public function getDataBencanaById($id)
	{
		$sql = "SELECT a.*,b.npsn FROM sidikjari.kebencanaan a JOIN sidikjari.sekolah b ON a.id_sekolah=b.id_sekolah  where b.npsn=? 
		ORDER by a.tgl_input desc limit 1";
		$query = $this->db->query($sql,array($id));
	 	return $query->row();
	}

	public function getDataPascabencanaById($id)
	{
		$data_bencana = $this->getDataBencanaById($id);
		$id_bencana = (isset($data_bencana)?$data_bencana->id_bencana:'-');

		$sql = "SELECT * FROM sidikjari.pascabencana WHERE id_bencana=?";
		$query = $this->db->query($sql,array($id_bencana));
	 	return $query->result_array();
	}

	public function getDataKelasTerdampak($id)
	{
		$data_bencana = $this->getDataBencanaById($id);
		$id_bencana = (isset($data_bencana)?$data_bencana->id_bencana:'-');

		$sql = "SELECT * FROM sidikjari.kebencanaan_kelas WHERE id_bencana=?";
		$query = $this->db->query($sql,array($id_bencana));
	 	return $query->result_array();
	}

	public function getDataLabTerdampak($id)
	{
		$data_bencana = $this->getDataBencanaById($id);
		$id_bencana = (isset($data_bencana)?$data_bencana->id_bencana:'-');

		$sql = "SELECT * FROM sidikjari.kebencanaan_lab WHERE id_bencana=?";
		$query = $this->db->query($sql,array($id_bencana));
	 	return $query->result_array();
	}	

	public function getDataRuangTerdampak($id)
	{
		$data_bencana = $this->getDataBencanaById($id);
		$id_bencana = (isset($data_bencana)?$data_bencana->id_bencana:'-');

		$sql = "SELECT * FROM sidikjari.kebencanaan_ruanglain WHERE id_bencana=?";
		$query = $this->db->query($sql,array($id_bencana));
	 	return $query->result_array();
	}

	public function getDataSiswaTerdampak($id)
	{
		$data_bencana = $this->getDataBencanaById($id);
		$id_bencana = (isset($data_bencana)?$data_bencana->id_bencana:'-');

		$sql = "SELECT * FROM sidikjari.kebencanaan_siswa WHERE id_bencana=?";
		$query = $this->db->query($sql,array($id_bencana));
	 	return $query->result_array();
	}

	public function getDataGuruTerdampak($id)
	{
		$data_bencana = $this->getDataBencanaById($id);
		$id_bencana = (isset($data_bencana)?$data_bencana->id_bencana:'-');

		$sql = "SELECT * FROM sidikjari.kebencanaan_guru WHERE id_bencana=?";
		$query = $this->db->query($sql,array($id_bencana));
	 	return $query->result_array();
	}		

	public function getDataArea()
	{
		$sql = "SELECT z.*,w.area from sidikjari.zonasi z join sidikjari.wilayah w ON w.id_wilayah = z.id_wilayah";
		$query = $this->db->query($sql);
	 	return $query->result_array();
	}

	public function getDataSKPPID($id)
	{
		return $this->db->query("SELECT 'sk_ppid' folder,sk_ppid file FROM sidikjari.sekolah where id_sekolah=?",array($id))->row();
	}	

	public function getDataAreaById($id)
	{
		$sql = "SELECT z.*,w.area,w.nm_wilayah from sidikjari.zonasi z join sidikjari.sekolah s ON z.id_sekolah=s.id_sekolah join sidikjari.wilayah w ON w.id_wilayah = z.id_wilayah WHERE s.npsn=?";
		$query = $this->db->query($sql,array($id));
	 	return $query->result_array();
	}	
	public function getDataSekolahByJenjang($jenjang){
		$sql = "SELECT * from sidikjari.sekolah where jenjang=?";
		if($jenjang=="All")
			$sql = "SELECT * from sidikjari.sekolah";

		$query = $this->db->query($sql,array($jenjang));
	 	return $query->result_array();
	}	
	
	public function getDataSekolahById($id){
		$sql = "SELECT * from sidikjari.sekolah where id_sekolah=?";
		$query = $this->db->query($sql,array($id));
	 	return $query->row();
	}

}

?>