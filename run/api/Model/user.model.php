<?php
 /**
 +---------------------------------------------------------------------------------------------------------------
 * 菜单数据操作
 +---------------------------------------------------------------------------------------------------------------
 */
class userModel extends modelMiddleware{

/**
     * 数据表key
     */
    public $tableKey = 'user';
    public  $cached  = false;

    /**
     * 数据表主键Id名称
     *
     */
    public $pK = 'user_id';

    /**
     * 尽可能的在model里面做一切相关的数据处理
     * @return object
     */
    public static function _model(){
	$model = M('user');
	return $model;
    }
    
    /**
     * 刷新mem缓存
     * @param  $admin_id
     * @access public
     * @return void
     */
    public function user_revision($user_id)
    {
        $sql    = sprintf("select * from %s where `admin_id` = '$user_id'", $this->getTable($this->tableKey,0) );
        $member = $this->getRow($sql);
	if (empty($member)){
	    $this->revisionKey = array("{all:all}");
	}else{
	    extract($member);
	    //为数据查询key
	    $this->revisionKey = array(
		"{all:all}",
		"{user_id:$user_id}",
	    );
	}
	 $this->revision();
    }
 }
?>