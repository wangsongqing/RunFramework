<?php require(View.'/layout/admin.header.html');?>
<script type="text/javascript" src="<?=Resource?>js/My97DatePicker/WdatePicker.js"></script>

<main>
    <!-- subnav start -->
    <?php require(View.'/layout/admin.subnav.html');?>
    <!-- subnav end -->

    <section class="content">
        <header class="content-header">文件缓存</header>
        <div class="tab-wrap-1">
                <div class="box">
                    <table class="tab-list-1 tab-list-break">
                        <colgroup>
                            <col style="width:auto">
                            <col style="width:auto">
                            <col style="width:auto">
                            <col style="width:auto">
                            <col style="width:auto">
                            <col style="width:auto">
                            <col style="width:auto">
                            <col style="width:auto">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>用户ID</th>
                            <th>名字</th>
                            <th>年龄</th>
                            <th>地址</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($result['record'] as $value) {?>
                        <tr>
                            <td><?=$value['id']?></td>
                            <td><?=isset($value['name']) ? $value['name'] : ''?></td>
                            <td><?=isset($value['age']) ? $value['age'] : ''?></td>
			    <td><?=isset($value['addr']) ? $value['addr'] : ''?></td>
                        </tr>
                        <? }?>
                        </tbody>
                    </table>
                </div>
            </div>
        <nav class="pager-list-1">
            <?=pageBar($result['pageBar'], 4)?>
            <style>
                .pager-list-1 a, .pager-list-1 i {display: inline-block;}
                .pager-list-1 a{margin: 0 2px;text-align: center; width: 30px;color: #666;}
                .pager-list-1 a.on{background-color: #7faf2a;color: #fff;}
                .pager-list-1 a.updown{width: 43px;}
                .pager-list-1 select {border: 1px solid #ddd;color: #333;font-family: Microsoft YaHei;font-size: 12px;padding-left: 5px;height: 30px;}
            </style>
        </nav>

    </section>

</main>
<!-- main end -->

<?php require(View.'/layout/admin.footer.html');?>
