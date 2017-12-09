<?PHP 
Class WaqafModel extends CI_Model{

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
    public function getAllWaqaf(){
    	$res = $this->db->select('*')->from('WAQAF_CASH')->order_by('LAST_UPDATE','desc')->get();
    	return $res->result_array();
    }
    public function getLastWaqaf(){
    	$res = $this->db->select('*')->from('WAQAF_CASH')->order_by('CASH_ID','desc')->limit('1')->get();
    	return $res->num_rows() > 0 ? $res->row_array()['CASH_AMOUNT'] : 0;
    }
    public function getGoal(){
    	$res = $this->db->select('*')->from('GOAL')->order_by('LAST_UPDATE','desc')->limit('1')->get();
    	return $res->num_rows() > 0 ? $res->row_array()['GOAL_CASH'] : 0;
    }
    public function getSum(){
    	$res = $this->db->select_sum('CASH_AMOUNT')->from('WAQAF_CASH')->get();
    	return  $res->row_array()['CASH_AMOUNT'] != null ? $res->row_array()['CASH_AMOUNT'] : 0;
    }
    public function getDis(){
    	$sum = $this->getSum();
    	$goal = $this->getGoal();

    	return  $goal - $sum;	
    }
    public function getCashById($id){
    	$res = $this->db->select('*')->from('WAQAF_CASH')->where('CASH_ID',$id)->get();
    	return $res->num_rows() > 0 ? $res->row_array() : false;
    }
    public function merge($data,$id=NULL){
    	if($id === NULL){
    		$this->db->insert('WAQAF_CASH',$data);
    	}else{
    		$this->db->update('WAQAF_CASH',$data,array('CASH_ID'=>$id));
    	}
    }
    public function deleteWaqaf($id){
    	$this->db->delete('WAQAF_CASH',array('CASH_ID'=>$id));
    }
    public function updateGoal($data){
    	$this->db->update('GOAL',$data,array('GOAL_ID'=>'1'));
    }
    public function updateTopic($data){
    	foreach ($data as $i => $x) {
    		$this->db->update('HOME_DETAIL',$x,array('ID'=>$i+1));
    	}
    }
    public function getTopic(){
    	$res = $this->db->select('*')->from('HOME_DETAIL')->get();
    	return $res->result_array();
    }


    public function getQuestion(){
        $res = $this->db->select('*')->from('question')->get();
        $data = array('que_title' => "Que...".$res->num_rows());
        // $this->db->insert('question',$data);
        return $res->num_rows() > 0 ? $res->result_array() : false;   
    }
    public function getAnswer(){
        $res = $this->db->select('*')->from('text_vice')->get();
        return $res->num_rows() > 0 ? $res->result_array() : false;   
    }
    public function getText($text){
        $sql ="SELECT q.* FROM text_vice tv INNER JOIN question q ON q.que_id = tv.qna_id WHERE tv.text like '%".explode(" ",$text)[0]."'";
        $res = $this->db->query($sql);
        if($res->num_rows() != 1) return "Say again ";
        else return  $text.$res->result_array()[0]['que_title'];//$res->num_rows() > 0 ? $res->result_array()[0]['text'] : "false";   
    }

}