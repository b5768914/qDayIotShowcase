<html>
<head>

<script src="jquery-3.3.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>

var chart1;
Highcharts.theme = {
    colors: ['#FFFFFF', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', 
             '#FF9655', '#FFF263', '#6AF9C4'],
    chart: {
        backgroundColor: 'rgba(255, 255, 255, 0.0)'
    },
    title: {
        style: {
            color: '#FFFFFF',
            font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
        }
    },
    subtitle: {
        style: {
            color: '#FFFFFF',
            font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
        }
    },

    legend: {
        itemStyle: {
            font: '9pt Trebuchet MS, Verdana, sans-serif',
            color: 'white'
        },
        itemHoverStyle:{
            color: 'white'
        }   
    }
};
// Apply the theme
Highcharts.setOptions(Highcharts.theme);

$(function() {
    chart1 = Highcharts.chart('container', {
        chart: {
            type: 'spline',
            events: {
                load: function() {
                    chart1 = this; // `this` is the reference to the chart
                    requestStatsData();
                }
            }
        },
        title: {
            text: 'rotor oscillation'
        },
        xAxis: {
            type: 'datetime',
            //tickPixelInterval: 150,
            //maxZoom: 20 * 1000
        },
        yAxis: {
            //minPadding: 0.2,
            //maxPadding: 0.2,
            min: 0,
        	max: 2.2,
        	startOnTick: false,
        	endOnTick: false,
            title: {
                text: 'Value',
                margin: 80
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true,
            valueSuffix: '' //was '°C'
        },

        legend: {
        },
        series: [{
            name: 'AverageMotion',
            data: [],
            zIndex: 1,
            marker: {
                fillColor: 'white',
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[0]
            }
        }]
    });        
});

function requestStatsData() {
    $.ajax({
        url: "getTableStoreEntities.php?entity=stats"
    }).then(function(data) {
        var obj = jQuery.parseJSON(data);
        //var serverDate = obj.Timestamp;
        var serverDate = new Date(obj.Timestamp);
        var nowDate = new Date();
        nowDate.setHours(nowDate.getHours()); //was initially getHours() -2
        var dateDif = serverDate.getTime() - nowDate.getTime();
        var Seconds_from_T1_to_T2 = dateDif / 1000;
        var secondsDif = Math.abs(Seconds_from_T1_to_T2);
        
        if(secondsDif<2){
            var series = chart1.series[0];
            var shift = series.data.length > 120;
            var chartDataDate = new Date().getTime();
            chart1.series[0].addPoint([chartDataDate,parseFloat(obj.rtsensorvalue)],true,shift);
            $('#sensorValue').html("serverDate: "+serverDate.toString()+"<BR>Value: "+obj.rtsensorvalue+"<BR>");
        }


    });
    requestDeviceState();
    requestDeviceError()
    setTimeout(requestStatsData, 1000); 
}

function requestDeviceState(){
    $.ajax({
        url: "getTableStoreEntities.php?entity=status"
    }).then(function(data) {
        var obj = jQuery.parseJSON(data);
        //var serverDate = obj.Timestamp;
        var serverDate = new Date(obj.Timestamp);
        var nowDate = new Date();
        nowDate.setHours(nowDate.getHours()); //was initially getHours() -2
        var dateDif = serverDate.getTime() - nowDate.getTime();
        var Seconds_from_T1_to_T2 = dateDif / 1000;
        var secondsDif = Math.abs(Seconds_from_T1_to_T2);
        
        if(secondsDif<2){
            $('#motorState').html("<center>"+obj.status+"</center>");
            if(obj.status == "running"){
                $('#motorState').css("background-color", "#00FF00");
            }
            else{
                $('#motorState').css("background-color", "#FF0000");
            }
        }


    });
}

function requestDeviceError(){
    $.ajax({
        url: "getTableStoreEntities.php?entity=errors"
    }).then(function(data) {
        var obj = jQuery.parseJSON(data);
        //var serverDate = obj.Timestamp;
        if(obj.value == "error"){
            var serverDate = new Date(obj.Timestamp);
            var nowDate = new Date();
            nowDate.setHours(nowDate.getHours()); //was initially getHours() -2
            var dateDif = serverDate.getTime() - nowDate.getTime();
            var Seconds_from_T1_to_T2 = dateDif / 1000;
            var secondsDif = Math.abs(Seconds_from_T1_to_T2);
            
            if(secondsDif<2){
                $('#errorState').html("<center>ERROR</center>");
                $('#errorState').css("background-color", "#FF0000");
                
            }
        }
        else {
            $('#errorState').css("background-color", "grey");
            $('#motorState').html("<center>no error</center>");
        }

    });
}


</script>
</head>
<body bgcolor="#023E84" text="#FFFFFF">
<BR>
    <p align="right">
	&nbsp;<img src="qDayLogo.png"><BR>
	
<table width="100%" border="0">
    <tr height="25px">
        <td width="10px"></td>
        <td width="25%" bgcolor="grey" id="motorState"><center>standby</center></td>
        <td width="25%" bgcolor="grey" id="errorState"><center>no error</center></td>
        <td width="*"></td>
    </tr>
</table>
 <!--   
	<span style="color:#2E9AFE">
	<i>
    IoT ShowCase&nbsp;&nbsp;
	</i>
	</span>
	</p>

    -->

    <BR>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<BR>
<BR>
<b>Debugging Info</b>
<div id="sensorValue"></div>
<div id="debugging"> v.0.14</div>

<script>









</script>

</body>
</html>