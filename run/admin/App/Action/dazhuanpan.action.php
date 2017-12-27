<?php

class dazhuanpanAction extends actionMiddleware {

    public $prizeInfo; //奖品id和所对应的概率

    public function index() {
     
        $this->display('dazhuanpan/index.html');
    }

    public function send_prize() {
        $rand = $this->randPrize($this->getPrize());
        //return $this->praseJson(3, '', '', array('id' => '1', 'name' => '获得ipone手机'));
        return $this->praseJson(5, '', '', array('id' => $rand, 'name' => '获得ipone手机'));
    }

    private function getPrize() {
        $prizeInfo[0]['chance'] = 0.6;//1积分
        $prizeInfo[1]['chance'] = 0.1;//2积分
        $prizeInfo[2]['chance'] = 0.09;//3
        $prizeInfo[3]['chance'] = 0.08;//4
        $prizeInfo[4]['chance'] = 0.06;//5
        $prizeInfo[5]['chance'] = 0.04;//6
        $prizeInfo[6]['chance'] = 0.02;//7
        $prizeInfo[7]['chance'] = 0.01;//8
        return $prizeInfo;
    }

    private function list_sort_by($list, $field, $sortby = 'asc') {
        if (is_array($list)) {
            $refer = $resultSet = array();
            foreach ($list as $i => $data) {
                $refer[$i] = &$data[$field];
            }
            switch ($sortby) {
                case 'asc': // 正向排序
                    asort($refer);
                    break;
                case 'desc': // 逆向排序
                    arsort($refer);
                    break;
                case 'nat': // 自然排序
                    natcasesort($refer);
                    break;
            }
            foreach ($refer as $key => $val) {
                $resultSet[] = &$list[$key];
            }
            return $resultSet;
        }
        return false;
    }
    
        /**
    * 随机礼品
    * 1. 随机发生按概率
    * 2 . 检查数量是否足够
    * 返回 礼品id
    */
    protected function randPrize($prize){
        if(!is_array($prize)){
            return false ;
        } 
        $prize = $this->list_sort_by($prize,'chance','desc');
        //以千分之一为
        $x = 10000 ;
        foreach ($prize as $key=> $value) {
            $prize[$key]['chance'] = $value['chance']*$x ;
        }
        $r = rand(1, $x) ;  // 随机得到结果
        $z = 0 ;
        $y = 0 ;
        foreach ($prize as $key=>$value) {
            $y = $z ;
            $z += $value['chance'] ;
            if($r<=$z && $r > $y){
               return $key ;
               break ;
            }
            $y = 0 ;
        }
    }

}
