<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $business->menu_name }}</h4>
                    <canvas id="doughnutChart" style="height:250px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/jquery.min.js"></script>
<script src="/connectPlus/vendors/chart.js/Chart.min.js"></script>
<script>
    $(function () {
        var length = 10;

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

        var doughnutPieData = {
            datasets: [{
                data: dataArray,
                backgroundColor: backgroundColor,
                borderColor: borderColor,
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: labels
        };

        var doughnutPieOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            }
        };

        if ($("#doughnutChart").length) {
            var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
            var doughnutChart = new Chart(doughnutChartCanvas, {
                type: 'doughnut',
                data: doughnutPieData,
                options: doughnutPieOptions
            });
        }
    });
</script>
