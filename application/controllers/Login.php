<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		//menampilkan halaman login
		$this->load->view('login');
	}

	public function cekLogin()
	{
		//untuk melakukan validasi
		$this->load->helper('url', 'form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username' /*tampilaln di view*/, 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_cekDb');/*cekDb = nama function dibawah*/
		if ($this->form_validation->run()==FALSE)
		{
			$this->load->view('login');

		}else{
			redirect('pegawai','refresh');
		}
	}
	public function cekDb($password)
	{
		//cek ke database
		$this->load->model('user');
		$username = $this->input->post('username');

		$result = $this->user->login($username, $password);

		if ($result) {
			$sess_array = array();

			foreach ($result as $row) {
				$sess_array = array(
					'id'=>$row->id,
					'username'=> $row->username
				);
				$this->session->set_userdata('logged_in',$sess_array);
			}
			return true;
		}else{
			$this->form_validation->set_message('cekDb', "Login Gagal Username dan Password tidak valid");
			return false;
		}
	}
	public function logout()
	{
		//logout
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('login','refresh');
	}

	public function signup()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_cekDbRegister');
		$this->form_validation->set_rules('password', 'Password');
		$this->load->model('user');	
		if($this->form_validation->run()==FALSE){
			$this->load->view('signup');
		}else{
			$this->user->insertUser();
			$this->load->view('signup_sukses');
		}
	}
	public function cekDbRegister()
	{
		$this->load->model('user');
		$username = $this->input->post('username');
		$result = $this->user->cekRegister($username);
		if($result){
			$this->form_validation->set_message('cekDbRegister',"Username Sudah Ada!");
			return false;
		}
		else{
			return true;
		}
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */