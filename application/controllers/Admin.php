<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
    {
        parent::__construct();
		$this->load->model('WaqafModel');
    }
	public function index()
	{
		$res = $this->WaqafModel->getAllWaQaf();
		$sum = $this->WaqafModel->getSum();
		$goal = $this->WaqafModel->getGoal();
		$topic = $this->WaqafModel->getTopic();
		$this->load->view('admin',array('res'=>$res,'sum'=>$sum,'goal'=>$goal,'topic'=>$topic));
	}
	public function getCashById(){
		$id = $this->input->post('id');
		$res = $this->WaqafModel->getCashById($id);
		$this->__sendJson($res);
	}
	public function merge(){
		$id = $this->input->post('cash_id');
		if($id === 'x') $id = NULL;
		$cash = $this->input->post('cash_amount');
		$data = array('CASH_AMOUNT' => $cash);
		$this->WaqafModel->merge($data,$id);
		redirect('admin');
	}
	public function deleteWaqaf(){
		$id = $this->input->post('id');
		$this->WaqafModel->deleteWaqaf($id);
	}
	public function updateGoal(){
		$goal = $this->input->post('goal_cash');
		$data = array('goal_cash'=>$goal);
		$this->WaqafModel->updateGoal($data);
		redirect('admin');
	}
	public function updateTopic(){
		$d = $this->input->post('detail1');
		$dd = $this->input->post('detail2');
		$ddd = $this->input->post('detail3');
		$data[0]['detail'] = $d;
		$data[1]['detail'] = $dd;
		$data[2]['detail'] = $ddd;
		// print_r($data);
		$this->WaqafModel->updateTopic($data);
		redirect('admin');
	}
	private function __sendJson($item){
		header('Access-Control-Allow-Origin: *');
	    header("Content-Type: application/json");
	    echo json_encode($item);	
	}

}
