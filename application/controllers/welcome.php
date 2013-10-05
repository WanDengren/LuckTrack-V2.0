<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct(){
        parent::__construct();
    }

	public function index()
	{/*
		//从POST过来的signed_request中提取oauth2信息
		if(!empty($_REQUEST["signed_request"])){
			$o = new $this->Saetoauthv2();
			$o->init($this->config->item('WB_AKEY'), $this->config->item('WB_SKEY'));
			$data = $o->parseSignedRequest($_REQUEST["signed_request"]);

			if($data == '-2'){
				 die('签名错误!');
			}else{
				$data = array('oauth2' => $data);
				$this->session->set_userdata($data);
			}
		}

		//判断用户是否授权
		$oauth2 = $this->session->userdata('oauth2');
		if (empty($oauth2)) {
			//include "auth.php";
			exit;
		}else{
			$c = new $this->Saetclientv2();
			$c->init($this->config->item('WB_AKEY'),
						$this->config->item('WB_SKEY'),
						$oauth2['oauth_token'],
						'');
		} 

		$data['oauth2'] = $oauth2;
		*/
		$data=FALSE;
		$this->load->view('home', $data);
	}

	public function user(){
		$oauth2 = $this->session->userdata('oauth2');
		echo $this->Saeapi->place_user_timeline($oauth2['user_id'], 50, NULL);
	}

	public function nearby(){

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */