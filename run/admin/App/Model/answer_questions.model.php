<?php

class answer_questionsModel extends modelMiddleware {

    public $tableKey = 'answer_questions'; //数据表key
    public $cached = true; //是否读取缓存
    public $pK = 'id'; //数据表主键Id名称

    /**
     * 数据操作模型
     * @return object
     */

    public static function _model() {
        $model = M('answer_questions');
        return $model;
    }

    public function choiceQA(){
        $_rule['exact']['subject_id'] = 1;
        $rule['exact']['option'] = 0;
        $_rule['limit'] = 5;
        $answer_subject = self::_model()->findTop($_rule);
        $answer_subject_key = array_rand($answer_subject,5);
        //重组数据
        $ArrNew = array();
        if(!empty($answer_subject_key) && is_array($answer_subject_key)){
            foreach($answer_subject_key as $v)
            {
                $ArrNew[$v] = $answer_subject[$v];
            }
        }else{
            $ArrNew[$answer_subject_key] = $answer_subject[$answer_subject_key];
        }
        
        $answer = array();
        foreach ($ArrNew as $key=>$val){
            //打乱答案
            $question = $this->randAnswer($val);
            if(!is_array($question)) continue;
            $answer[$key]['answer'] = $question['answer'];
            $answer[$key]['right_answer'] = $question['right_answer'];
            $answer[$key]['id']         = $val['id'];
            $answer[$key]['subject_id'] = $val['subject_id'];
            $answer[$key]['topic']      = $val['topic'];
        }
        shuffle($answer);//打乱题目
        return $answer;
    }
    
    //随机打乱答案
    private function randAnswer($question){
        //统计题目个数
        $answerNum = strlen($question['right_answer']);
        if($answerNum>4 || $answerNum<2) return -1;
        $showQuestion = array();
        for ($i=0;$i<$answerNum;$i++){
            $showQuestion[$i][] = $question['answer'.($i+1)];
            $showQuestion[$i][] = $question['right_answer'][$i];
            unset($question['answer'.($i+1)]);
        }
        $question['right_answer'] = '';
        shuffle($showQuestion);
        foreach ($showQuestion as $v){
            $question['answer'][] = $v[0];
            $question['right_answer'] .= $v[1];
        }
        return $question;
    }

}
