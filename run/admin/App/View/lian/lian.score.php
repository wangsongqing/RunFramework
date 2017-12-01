<div class="outer">
    <div class="inner">
        <div class="hd">
            <?php if(isset($is_floop) && $is_floop==1){ ?>
            <i class="icon icon-1"></i>
            <?php } ?>
            <i class="icon icon-text"></i>
            <span class="text"><?=isset($data['score'])?$data['score']:'0'?></span>
        </div>
        <div class="datas">
            <ul>
                <li>
                    <div class="line"></div>
                    <p><?=isset($data['red_bag'])?$data['red_bag']:'0.00'?></p>现金红包(元)
                </li>

            </ul>
        </div>
    </div>
</div>
<div class="btns">
    <a href="" class="btn-view"></a>
    <a href="javascript:;" class="btn-replay" id="btn_replay"></a>
</div>
