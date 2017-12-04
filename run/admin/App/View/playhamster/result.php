<div class="board">
    <div class="wrap">
        <div class="amout"><i></i><?= isset($score) ? $score : 0 ?></div>
        <div class="reward">
            <ul>
                <li><p><?php echo 10; ?></p>成长金(元)</li>
                <li><p><?php echo 10; ?></p>现金红包(元)</li>
                <li><p><?php echo 10; ?></p>宝贝豆(个)</li>
            </ul>
        </div>
    </div>
</div>
<div class="wrap">
    <div class="btns" id="overBtns">
        <a href="www.baidu.com" class="btn btn-view" id="btn_view"></a>
        <a href="javascript:;" class="btn btn-replay" id="btn_replay"></a>
    </div>

    <div class="rank" id="rank">
        <? if($rank_info){?>
        <div class="hd">
            <div class="l"><div class="avatar"><img src="<?= $avatar ?>"><br><?= $nick ?></div></div>
        </div>
        <div class="bd">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <?
                foreach($rank_info as $key => $v){
                $k = $key+1;
                ?>
                <tr>
                    <td><i class="<?= $k ?>"></i><?= $v['nick'] ?></td>
                    <td><?= $v['telephone'] ?></td>
                    <td><?= $v['total_score'] ?>分</td>
                </tr>
                <?
                }
                ?>
            </table>
        </div>
        <?}?>
    </div>
</div>