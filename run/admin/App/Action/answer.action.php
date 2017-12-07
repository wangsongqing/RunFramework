<?php

/**
 * 答题小游戏
 * @author Jimmy Wang
 */
class AnswerAction extends actionMiddleware {

    public function index() {
        $answer_top3 = M('answer_attend')->get_answer_top3('1493862047', '1493877204');
        $this->display('answer/answer.index.html', array('answer_top3' => $answer_top3));
    }

    public function start_answer() {
        extract($this->input);
        if ($isPost) {
            $data = M('answer_questions')->choiceQA();
            if (!empty($data)) {
                $returnDate = array();
                //生成哈稀串，并回传给前端
                $hash_string = 'abc';
                setVar('hash' . 1, $hash_string);
                $returnDate['hash_string'] = $hash_string;
                $returnDate['subject_id'] = 1;
                $returnDate['questions'] = $data;
                $this->praseJson(1, 'suss', '', json_encode($returnDate));
            }
        }
        $this->display('answer/answer.ticket.html');
    }

    public function send_result() {
        extract($this->input);
        if ($isPost) {
            $postStr = run_encryption($Poststr);
            $getData = explode('#', $postStr);
            if (count($getData) < 5) {
                $this->praseJson('-1008', $this->_errorMsg['-1008']);
            }
            list($subject_id, $sub_score, $right_num, $err_num, $hash) = $getData;
            //过滤数据
            $subject_id = isset($subject_id) ? intval($subject_id) : 0;
            $right_num = isset($right_num) ? intval($right_num) : 0;//正确数
            $err_num = isset($err_num) ? intval($err_num) : 0;//错误数
            $sub_score = isset($sub_score) ? intval($sub_score) : 0;//总分
            $data['score'] = $right_num*1;
            $answer_top3 = M('answer_attend')->get_answer_top3('1493862047', '1493877204');
            $this->display('answer/answer.result.html',array('result'=>$data,'rank_info'=>$answer_top3));
        }
    }
    
    /**
     * 点击继续考试触发
     * 检测用户是否还可以游戏
     */
    public function ajax_check_canplay(){
        $this->praseJson(1,'继续答题');
    }
    
    /**
     * 我的成绩
     */
    public function my_score(){
        
        $this->display('answer/answer.myscore.html');
    }
    
    public function rank(){
        $answer_top3 = M('answer_attend')->get_answer_top3('1493862047', '1493877204');
        $this->display('answer/answer.rank.html',array('answer_top3'=>$answer_top3));
    }

}
