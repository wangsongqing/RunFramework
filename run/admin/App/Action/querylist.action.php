<?php
use QL\QueryList;

/**
 * PHP网络爬虫
 * 通过queryList抓取麦子学院的视频地址
 */
class QueryListAction extends actionMiddleware {

    public function index() {
        require App . '/Util/QueryList/phpQuery.php';
        require App . '/Util/QueryList/QueryList.php';
        $data = QueryList::Query('http://www.maiziedu.com/course/393/', array(
                    'name' => array('.lesson-lists li .fl', 'text'),
                    'link' => array('.lesson-lists li a', 'href'),
                ))->data;
        //打印结果
        foreach ($data as $k => &$v) {
            $v['link'] = 'http://www.maiziedu.com' . $v['link'];
        }

        foreach ($data as $key => $val) {
            $vidio = QueryList::Query($val['link'], array(
                        'link' => array('script:eq(2)', 'text'),
                    ))->data;
            $rule = '/\$lessonUrl = "(.+)"/';
            preg_match_all($rule, $vidio[0]['link'], $res);
            echo $res[1][0] . '<br>';
        }
    }

    /**
     * 要求就是根据关键词（我们数据库有50万个）去这个网址里面采集数据
     * http://www.sogou.com/websearch/xml/xml4union.jsp?query=site:www.liuxue86.com+inurl:/a/+' . $keyword
     */
    public function collect() {
        $q = '养生';
        $q = urlencode(mb_convert_encoding($q, "gb2312", "utf-8"));
        $getCollectData = $this->get_collect($q);
        echo '<pre>';
        print_r($getCollectData);
    }
    
    private function get_collect($q) {
        require App . '/Util/QueryList/phpQuery.php';
        require App . '/Util/QueryList/QueryList.php';
        //获取采集对象url地址
        $hj = QueryList::Query('http://www.sogou.com/websearch/xml/xml4union.jsp?query=site:www.liuxue86.com+inurl:/a/+' . $q, array(
            'showurl' => array('showurl', 'text')
        ));
        
        $retUrls = array();
        foreach ($hj->data as $k => $v) {
            if (strrpos($v['showurl'], '.html') !== false) {
                $retUrls[]['showurl'] = $v['showurl'];
            }
        }

        $searchUrls = $retUrls;
        $hjc = array();
        foreach ($searchUrls as $k => $v) {
            if ($k <= 5) {
                // 获取采集对象
                $ret = QueryList::Query($v['showurl'], array(
                            'title' => array('h1', 'text'),
                            'content' => array('#article-content', 'text')
                ));
                $hjc[] = $ret->data;
            }
        }
        return $hjc;
    }

}
