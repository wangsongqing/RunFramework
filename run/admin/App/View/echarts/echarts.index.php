<?php require(View.'/layout/admin.header.html');?>
<script src="<?=Resource?>js/echarts.js"></script>

<main>
    <!-- subnav start -->
    <?php require(View.'/layout/admin.subnav.html');?>
    <!-- subnav end -->

    <section class="content">
        <header class="content-header">管理员登陆次数统计</header>

        <fieldset class="form-list-32">
           <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
	<div id="main" style="width: 600px;height:400px;margin-left:100px;"></div>
        </fieldset>

    </section>

</main>
<!-- main end -->

<?require(View.'/layout/admin.footer.html');?>
<script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '管理员登陆次数统计'
            },
            tooltip: {},
	    itemStyle:{
		normal: {
		    color: '#ccc', //设置颜色
		}
	    },
            legend: {
                data:['管理员登陆次数']
            },
            xAxis: {
                data: <?=json_encode($name)?>
            },
            yAxis: {},
            series: [{
                name: '管理员登陆次数',
                type: 'bar',
                data: <?=json_encode($num)?>
            }
	    ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>