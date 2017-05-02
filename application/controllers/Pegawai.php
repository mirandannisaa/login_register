<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
		}else{
			redirect('login','refresh');
		}	
	}

	public function index()
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->getJenisHero();
		$this->load->view('jenis_hero',$data);	
	}

	public function datatable()
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->getJenisHero();
		$this->load->view('jenis_hero', $data);
	}

	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');		
		$this->load->model('pegawai_model');
		if($this->form_validation->run()==FALSE){

			$this->load->view('tambah_pegawai_view');

		}else{
						$this->pegawai_model->insertJenisHero();
						$this->load->view('tambah_pegawai_sukses');
        }

		
	}
	
	public function update($id)
	{
		$this->load->helper('url','form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		$this->load->model('pegawai_model');
		$data['pegawai']=$this->pegawai_model->getJenis($id);
		$data2=$this->pegawai_model->getJenis($id);
		if($this->form_validation->run()==FALSE)
		{
			$this->load->view('edit_pegawai_view',$data);
		}
		else
		{
			$this->pegawai_model->UpdateById($id);
			$this->load->view('edit_pegawai_sukses');
		}
	}


	public function delete($id)
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->deleteById($id);
		$data2 = $this->pegawai_model->deleteById($id);
		$nama=$data2[0]->foto;
		$this->load->view('hapus_pegawai_sukses', $data);
	}

}

/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */

 ?>