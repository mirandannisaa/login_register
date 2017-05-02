<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anak extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pegawai_Model');
	}

	public function index($idPegawai)
	{
		
		$this->load->model('pegawai_model');
		$data["anak_list"] = $this->pegawai_model->getHeroByJenis($idPegawai);
		$this->load->view('anak',$data);	
	
	}
	public function create($idPegawai)
	{
		// idPegawai = 1
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->load->model('pegawai_model');	
		if($this->form_validation->run()==FALSE){
			$this->load->view('tambah_anak_view');
		}else{
				$config['upload_path']          = './assets/uploads/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 1000000000;
                $config['max_width']            = 10240;
                $config['max_height']           = 7680;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
						$this->load->view('tambah_anak_view',$error);
                }
                else
                {
						$this->pegawai_model->insertHero($idPegawai);
						$this->load->view('tambah_anak_sukses');
                }
			
		}
	}
	public function update($id)
	{
		$this->load->helper('url','form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		//$this->form_validation->set_rules('Nip','nip','trim|required');
		//$this->form_validation->set_rules('Tanggal','tanggal','trim|required');
		//$this->form_validation->set_rules('Alamat','alamat','trim|required');

		$this->load->model('pegawai_model');
		$data['anak']=$this->pegawai_model->getHero($id);
		$data2=$this->pegawai_model->getHero($id);
		$nama = $data2[0]->foto;
		if($this->form_validation->run()==FALSE)
		{
			$this->load->view('edit_anak_view',$data);
		}
		else
		{
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '1000';
			$config['max_width']  = '10240';
			$config['max_height']  = '7680';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload()){
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('edit_anak_view',$error);
			}
		

			else
		{
			$image_data = $this->upload->data();
			unlink('assets/uploads/'.$nama);
			$this->pegawai_model->UpdateHeroById($id);
			$this->load->view('edit_anak_sukses');
		}

	}
}

	public function delete($id)
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->deleteById($id);
		$data2 = $this->pegawai_model->deleteById($id);
		$nama=$data2[0]->foto;
		//@unlink('assets/uploads/'.$nama);
		//$this->load->helper("url");
		//delete(base_url("assets/uploads/".$nama));

		$this->load->view('delete_anak_sukses',$data);	
	}
}

/* End of file Anak.php */
/* Location: ./application/controllers/Anak.php */
 ?>