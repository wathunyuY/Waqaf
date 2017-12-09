<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends CI_Controller {

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
		$this->load->view('show',array('res'=>$this->getData(1) , 'topic' => $this->WaqafModel->getTopic()));
	}
	public function getData($flag = NULL){
		$res = array(
		'last' => $this->WaqafModel->getLastWaqaf(),
		'sum' => $this->WaqafModel->getSum(),
		'dis' => $this->WaqafModel->getDis(),
		'all' => $this->WaqafModel->getGoal());
		if($flag === NULL)
			$this->__sendJson($res);
		else
			return $res;
	}
	private function __sendJson($item){
		header('Access-Control-Allow-Origin: *');
	    header("Content-Type: application/json");
	    echo json_encode($item);	
	}
	public 	function getInitSpeechTest(){
		$q = $this->WaqafModel->getQuestion();
		$a = $this->WaqafModel->getAnswer();
		$res = array('question' => $q , 'answer' => $a);
		$this->__sendJson($res);
	}
	public function answerOf(){
		$text = $_POST['text'];
		$res = $this->WaqafModel->getText($text);
		$this->__sendJson($res);	
	}

}
