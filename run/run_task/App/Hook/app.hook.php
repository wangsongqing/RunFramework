<?php

class Hook {

    //过滤列表
    private $isFilter = array("login", "api", "logout",);

    /**
     * 验证用户是否登录
     * @access public
     * @return mixd
     */
    public function work() {
        $mod = getModule();
        $action = getAction();

        $admin = getAuth('all');
    }

    function Html() {
        $this->com->msg->display("地址错误");
    }

    public function redirect($desc, $url, $scripts = array()) {
        $this->com->msg->show($desc, $url, $scripts);
    }

}

?>