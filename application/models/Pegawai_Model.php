<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_Model extends CI_Model {

		public function __construct()
		{
			parent::__construct();
			//Do your magic here
		}	

		public function getJenisHero()
		{
			$this->db->select("id, keterangan");
			$query = $this->db->get('jenis_hero');
			return $query->result();
		}

		public function getJenis($id)
		{
			$this->db->where('id',$id);
			$query = $this->db->get('jenis_hero');
			return $query->result();
		}

		public function getHero($id)
		{
			$this->db->where('id',$id);
			$query = $this->db->get('hero');
			return $query->result();
		}
		
		public function getHeroByJenis($idPegawai)
		{
			$this->db->select("jenis_hero.id as idJenis,jenis_hero.keterangan as keterangan, hero.id as id, hero.nama as nama,DATE_FORMAT(hero.tanggal_lahir,'%d-%m-%Y') as tanggal_lahir, hero.foto as foto");
			$this->db->where('fk_jenis', $idPegawai);	
			$this->db->join('jenis_hero', 'jenis_hero.id = hero.fk_jenis', 'left');	
			$query = $this->db->get('hero');
			return $query->result();
		}


		public function insertJenisHero()
		{
			$object = array('keterangan' => $this->input->post('keterangan'));
			$this->db->insert('jenis_hero', $object);
		}

		public function insertHero($idPegawai)
		{
			$object = array(
				'nama' => $this->input->post('nama'), 
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'foto' =>$this->upload->data('file_name'),
				'fk_jenis'=> $idPegawai
				);
			$this->db->insert('hero', $object);
		}
		
		public function updateById($id)
		{
			$data = array
			(
				'keterangan' =>$this->input->post('keterangan')

			);
			$this->db->where('id',$id);
			$this->db->update('jenis_hero',$data);
		}

		public function updateHeroById($id)
		{
			$data = array
			(
				'nama' => $this->input->post('nama'), 
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'foto' =>$this->upload->data('file_name')
			);
			$this->db->where('id',$id);
			$this->db->update('hero',$data);
		}

		public function deleteById($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('hero');
       		$this->db->where('id', $id);
			$this->db->delete('jenis_hero');
			

			$this->db->where('id',$id);
		    $query = $this->db->get('hero');
		    $row = $query->row();

    		unlink("assets/uploads/$row->foto");
			$this->db->delete('hero', array('id' => $id));
		}

		
}

/* End of file Pegawai_Model.php */
/* Location: ./application/models/Pegawai_Model.php */
 ?>