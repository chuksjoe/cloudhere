$(function() {
    $.ajax({

        url: 'http://localhost/chart_data2.php',
        type: 'GET',
        success: function(data) {
            chartData = data;
            var chartProperties = {
                "caption": "CloudHere users Uploaded files chart",
                "xAxisName": "Users",
                "yAxisName": "Total number of files uploaded",
                "rotatevalues": "1",
                "theme": "zune"
            };

            apiChart = new FusionCharts({
                type: 'column2d',
                renderAt: 'total-num-of-files',
                width: '250',
                height: '350',
                dataFormat: 'json',
                dataSource: {
                    "chart": chartProperties,
                    "data": chartData
                }
            });
            apiChart.render();
        }
    });
});