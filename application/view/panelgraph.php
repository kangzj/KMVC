<?php include 'header.inc.php';?>
<h4><a href="javascript:history.go(-1);">返回</a></h4>
<script type="text/javascript" src="js/fusioncharts/FusionCharts.js"></script>
<div id="chartContainer">FusionCharts XT will load here!</div>          
    <script type="text/javascript"><!--         

      var myChart = new FusionCharts( "js/fusioncharts/ZoomLine.swf", 
                   "myChartId", "800", "600", "0" );
      myChart.setJSONUrl("data/recentdays?days=<?=$days?>&group=<?=$group?>");
      myChart.render("chartContainer");      
    // -->     
    </script> 
<?php if($group !='transrate'){?>
    <div id="chartContainer_percent">FusionCharts XT will load here!</div>          
    <script type="text/javascript"><!--         

      var myChart = new FusionCharts( "js/fusioncharts/StackedArea2D.swf", 
                   "myChartId", "800", "600", "0" );
      myChart.setJSONUrl("data/recentdays?days=<?=$days?>&group=<?=$group?>&type=percent");
      myChart.render("chartContainer_percent");      
    // -->     
    </script> 
<?php }?>  
<?php include 'footer.inc.php';?>