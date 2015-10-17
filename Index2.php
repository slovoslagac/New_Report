<!doctype html>
<html>
<?php 
require_once('init.php');
$css='css/index_new.css';
$naslov_short="Bookmaking";
$naslov="Bookmaking osnovna strana";


include(join(DIRECTORY_SEPARATOR, array('included', 'main_header.php')));

?>
    <body>
        <div id="container">
            <?php $btn1='index.php';$btn2='Podrska/index.php';$btn3='Teletext/index.php';$btn4='Verif/index.php';
            include(join(DIRECTORY_SEPARATOR, array('included', 'main_menu.php')));?> 
            <div id="function_data">
              <div id='chart_div'></div>  
            </div>
            <?php include(join(DIRECTORY_SEPARATOR, array('included', 'main_footer.php'))); ?>
        </div>
    </body>
</html>


   
   <script type='text/javascript'>  
    google.load('visualization', '1', {packages:['orgchart']});  
    google.setOnLoadCallback(drawChart);  
    function drawChart() {  
     var data = new google.visualization.DataTable();  
     data.addColumn('string', 'Node');  
     data.addColumn('string', 'Parent');  
     data.addRows([  
      ['1', ''],  
      ['1.1', '1'],  
      ['1.2', '1'],  
      ['1.3', '1'],
      ['1.4', '1'],
      ['1.5', '1']
     ]);  
     var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));  
     chart.draw(data);  
    }  
   </script>