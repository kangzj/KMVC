<?php include 'header.inc.php';?>
<script type="text/javascript" src="js/fusioncharts/FusionCharts.js"></script>
<?php
foreach ($past_days as $d){
    echo '<a href="panel/report?day='.$d.'">'.$d.'</a> ';    
}?>
</p>
<h1><?=$day?>统计信息</h1>
<?php foreach ($stat as $k1 => $line){?>
<h2><a href="panel/graph?group=<?=$k1?>"><?=AppConfig::$stat_group[$k1]?></a></h2>
<table><tr><td>
<table border='1'><tr><th></th><th>数量</th><th>占比</th></tr>
<?php foreach ($line as $k2 => $row){?>
<tr><td><?=$k2?></td><td><?=$row['value']?></td><td><?=$row['percent']?></td></tr>
<?php }?>
</table>
</td><td>
<div id="chartContainer_<?=$k1?>">FusionCharts XT will load here!</div> 
</td></tr></table>
  
    <script type="text/javascript"><!--         

      var myChart = new FusionCharts( "js/fusioncharts/Pie2D.swf", 
                   "myChartId", "400", "300", "0" );
      myChart.setJSONUrl("data/piechart?day=<?=$day?>&group=<?=$k1?>&owner=weiwei");
      myChart.render("chartContainer_<?=$k1?>");
      
    // -->     
    </script> 
<?php }?>
<h2><a href="panel/graph?group=<?=$stat2[0]['group']?>"><?=AppConfig::$stat_group[$stat2[0]['group']]?></a></h2>
<table border='1'><tr><th>行业</th><th>详情页转化率</th><th>结单转化率</th></tr>
<?php foreach ($stat2 as $k2 => $row){
$pct_arr = explode('&', $row['memo']);
?>
<tr><td><?=$row['key']?></td><td><?=$pct_arr[0]?></td><td><?=$pct_arr[1]?></td></tr>
<?php }?>
</table>
<p>注：详情页点击包括详情页点击、右下角电话点击、左下角地图点击 详情页转化率=详情页点击量/检索量 结单转化率=接单量/详情页点击量 </p>
<p>说明：团购结单量转化率低，需要以后追查原因；团购优惠中没有划分类目，若有需求，后期可以划分.</p>
<?php include 'footer.inc.php';?>