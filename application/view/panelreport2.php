<?php include 'header.inc.php';?>
<script type="text/javascript" src="js/fusioncharts/FusionCharts.js"></script>
<?php
foreach ($past_days as $d){
    echo '<a href="panel/report2?day='.$d.'">'.$d.'</a> ';    
}?>
</p>
<h1><?=$day?>统计信息</h1>
<?php foreach ($data_type_3 as $grp => $line){?>
<h2><?=$grp?></h2>
<table><tr><td>
<table border='1'><tr><th></th>
<?php if($grp == '各阶段比例'){?>
<th>后端所占比例</th> <th>连接所占比例</th> <th>请求所占比例</th> <th>响应所占比例</th>
<?php }else if($grp == '各阶段平均值'){?>
<th>后端平均值</th> <th>连接平均值</th> <th>请求平均值</th> <th>响应平均值</th> 
<?php }else if($grp =='重传次数统计'){?>
<th>连接阶段C</th><th>连接阶段S</th><th>请求阶段C</th><th>请求阶段S</th><th>响应阶段C</th><th>响应阶段S</th>
<?php }?> 
</tr>
<?php foreach ($line as $grp => $row){?>
<tr><td><?=$row['key']?></td>
<?php
$tds = explode('&', $row['value']);
foreach ($tds as $td){
?>
<td><?=$td?></td>
<?php }?>
</tr>
<?php }?>
</table>
</td><td>
<div id="chartContainer_<?=substr(md5($grp),0,5)?>"></div> 
</td></tr></table>  
    <script type="text/javascript"><!--        

      //var myChart = new FusionCharts( "js/fusioncharts/Pie2D.swf", 
      //             "myChartId", "400", "300", "0" );
      //myChart.setJSONUrl("data/piechart?day=<?=$day?>&group=<?=$grp?>&owner=minwei");
      //myChart.render("chartContainer_<?=substr(md5($grp),0,5)?>");
      
    // -->     
    </script> 
<?php }?>
<?php foreach ($data_type_1 as $grp => $line){?>
<h2><a href="panel/graph?group=<?=urlencode($grp)?>"><?=$grp?></a></h2>
<table><tr><td>
<table border='1'><tr><th></th>
<th>平均值</th><th>比例</th>
</tr>
<?php foreach ($line as $k2 => $row){?>
<tr><td><?=$row['key']?></td><td><?=$row['value']?></td><td><?=$row['memo']?></td></tr>
<?php }?>
</table>
</td><td>
<div id="chartContainer_<?=substr(md5($grp),0,5)?>">FusionCharts XT will load here!</div>
<script type="text/javascript"><!--        

      var myChart = new FusionCharts( "js/fusioncharts/Pie2D.swf", 
                   "myChartId", "400", "300", "0" );
      myChart.setJSONUrl("data/piechart?day=<?=$day?>&group=<?=$grp?>&owner=minwei");
      myChart.render("chartContainer_<?=substr(md5($grp),0,5)?>");
      
    // -->     
    </script> 
</td></tr></table>
<?php }?>
<?php $filename = '/var/www/html/dv/tcpdump/record_'. $day.'.html'; if(file_exists($filename))echo file_get_contents($filename);?>
<?php include 'footer.inc.php';?>