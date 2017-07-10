<?php

  $rule['exact']['user_id'] = 1;
  $rule['exact']['source']  = 2;
  $rule['other'] = 'ptype != 0 AND ptype != 4';
  $rule['order'] = array('user_id'=>'ASC');
  //$rule 相当于 where ( user_id='1' AND source='2' ) AND ( ptype != 0 AND ptype != 4 ) order by user_id ASC
  
  $rule['in']['user_id'] = array('1','3','5');
  //$rule 相当于 where ( user_id in (1,3,5) )
  
  $rule['like'] = array('name'=>'wsq');
  //$rule 相当于 where ( name like '%wsq%')
  
  $rule['scope'] = array('age' => array('18', '30'));
  //$rule 相当于 where ( age >= 18 AND age <= 30 )