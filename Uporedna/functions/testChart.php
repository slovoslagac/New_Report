<!doctype html>
<html>
<head>
    <title>Line Chart</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="../js/Chart.js"></script>
</head>
<body>
<div>
    <div>
        <canvas id="canvas" height="600" width="900"></canvas>
    </div>
</div>
<?php include(join(DIRECTORY_SEPARATOR, array('..','JSON', 'current_odd.php')));


?>



<script>

    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    var lineChartData=(<?php echo $php_data ?>);

//    console.log(lineChartData);

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: false
        });
    }
</script>
</body>