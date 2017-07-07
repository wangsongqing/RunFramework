<?php require(View.'/layout/admin.header.html');?>
<script src="<?=Resource?>js/user.js"></script>

<main>
    <!-- subnav start -->
    <?php require(View.'/layout/admin.subnav.html');?>
    <!-- subnav end -->

    <section class="content">
        <header class="content-header">编辑redis用户信息</header>

        <fieldset class="form-list-32">
            <h3 class="operate-title-1"><i></i>编辑redis用户信息</h3>
            <form name="editForm" action="<?=Root?>redis/edit/" id="editFormId" method="post" autocomplete="off">
                <ul>
		    <input type="hidden" name="id" value="<?=$data['id']?>">
                    <li><h6>用户名：</h6><aside><input type="text" value="<?=$data['name']?>" name="name" class="tbox30 tbox30-6"/></aside></li>
                    <li><h6>地址：</h6><aside><input name="addr" value="<?=$data['addr']?>" maxlength="11" class="tbox30 tbox30-6" type="text"></aside></li>
		    <li><h6>年龄：</h6><aside><input name="age" value="<?=$data['age']?>" class="tbox30 tbox30-6" type="text" ></aside></li>
                    <li class="agent-subbtn-wrap mt30px">
                        <h6>&nbsp;</h6><aside><input class="btn-2" type="submit" value="提交"></aside>
                    </li>
                </ul>

            </form>
        </fieldset>

    </section>

</main>
<!-- main end -->

<?require(View.'/layout/admin.footer.html');?>
