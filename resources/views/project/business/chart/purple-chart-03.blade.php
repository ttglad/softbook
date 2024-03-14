<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $business->menu_name }}</h4>
                <canvas id="traffic-chart"></canvas>
                <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/jquery.min.js"></script>
<script src="/connectPlus/vendors/chart.js/Chart.min.js"></script>
<script>
    $(function () {
        var length = 3;

        var left = 100;
        var labels = [];
        var dataArray = [];
        var backgroundColor = [];
        var borderColor = [];
        // 遍历过去的12个月（包括本月）并将其添加到数组中
        for (let i = length - 1; i >= 0; i--) {
            // 创建新的日期对象，设置年份为当前年份，月份为i+currentMonth-1（因为JavaScript中月份索引从0开始计算）

            if (i == 0) {
                dataArray.push(left);
            } else {
                var value = getRandomInt(0, left/2);
                dataArray.push(value);
                left = left - value;
            }
            labels.push("指标" + i);

            var r = getRandomInt(1, 255);
            var g = getRandomInt(1, 255);
            var b = getRandomInt(1, 255);
            backgroundColor.push('rgba(' + r + ',' + g + ',' + b + ', 0.8)');
            borderColor.push('rgba(' + r + ',' + g + ',' + b + ', 1)');
        }

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        if ($("#traffic-chart").length) {
            var ctx = document.getElementById('traffic-chart').getContext("2d");
            var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 181);
            gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
            gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
            var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

            var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 50);
            gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
            gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
            var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

            var gradientStrokeGreen = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStrokeGreen.addColorStop(0, 'rgba(6, 185, 157, 1)');
            gradientStrokeGreen.addColorStop(1, 'rgba(132, 217, 210, 1)');
            var gradientLegendGreen = 'linear-gradient(to right, rgba(6, 185, 157, 1), rgba(132, 217, 210, 1))';

            var trafficChartData = {
                datasets: [{
                    data: dataArray,
                    backgroundColor: [
                        gradientStrokeBlue,
                        gradientStrokeGreen,
                        gradientStrokeRed
                    ],
                    hoverBackgroundColor: [
                        gradientStrokeBlue,
                        gradientStrokeGreen,
                        gradientStrokeRed
                    ],
                    borderColor: [
                        gradientStrokeBlue,
                        gradientStrokeGreen,
                        gradientStrokeRed
                    ],
                    legendColor: [
                        gradientLegendBlue,
                        gradientLegendGreen,
                        gradientLegendRed
                    ]
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: labels
            };
            var trafficChartOptions = {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                legend: false,
                legendCallback: function(chart) {
                    var text = [];
                    text.push('<ul>');
                    for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) {
                        text.push('<li><span class="legend-dots" style="background:' +
                            trafficChartData.datasets[0].legendColor[i] +
                            '"></span>');
                        if (trafficChartData.labels[i]) {
                            text.push(trafficChartData.labels[i]);
                        }
                        text.push('<span class="float-right"> : '+trafficChartData.datasets[0].data[i]+"%"+'</span>')
                        text.push('</li>');
                    }
                    text.push('</ul>');
                    return text.join('');
                }
            };
            var trafficChartCanvas = $("#traffic-chart").get(0).getContext("2d");
            var trafficChart = new Chart(trafficChartCanvas, {
                type: 'doughnut',
                data: trafficChartData,
                options: trafficChartOptions
            });
            $("#traffic-chart-legend").html(trafficChart.generateLegend());
        }
    });
</script>
