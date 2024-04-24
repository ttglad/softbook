<div class="row">
    <div class="col-12 col-md-10 offset-md-1 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $business->menu_name }}</h4>
                <canvas id="barChart" style="height:160px"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="/vendors/jquery/3.4.1/jquery.min.js"></script>
<script src="/vendors/chart/Chart.min.js"></script>
<script>
    $(function () {
        var length = 18;
        var labels = [];
        var dataArray = [];
        var backgroundColor = [];
        var borderColor = [];

        var currentDate = new Date();
        for (let i = length - 1; i >= 0; i--) {
            // 创建新的日期对象，设置年份为当前年份，月份为i+currentMonth-1（因为JavaScript中月份索引从0开始计算）
            // var monthObj = new Date(currentDate.getFullYear(), currentDate.getMonth() - i);
            //
            // // 格式化月份字符串，如"2022-05"
            // var formattedMonth = `${String(monthObj.getMonth() + 1).padStart(2, '0')}/${monthObj.getFullYear()}`;

            var date = new Date(currentDate.getTime() - i * 24 * 60 * 60 * 1000);

            // 格式化日期为 "yyyy-mm-dd" 形式
            var formattedDate = `${String(date.getMonth() + 1).padStart(2, '0')}/${String(date.getDate()).padStart(2, '0')}`;
            labels.push(formattedDate);

            // 将格式化后的月份字符串添加到数组中
            dataArray.push(getRandomInt(1, 20));
            var r = getRandomInt(1, 255);
            var g = getRandomInt(1, 255);
            var b = getRandomInt(1, 255);
            backgroundColor.push('rgba(' + r + ',' + g + ',' + b + ', 0.2)');
            borderColor.push('rgba(' + r + ',' + g + ',' + b + ', 1)');
        }
        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        var data = {
            labels: labels,
            datasets: [{
                label: '# of Votes',
                data: dataArray,
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1,
                fill: false
            }]
        };

        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }

        };

        if ($("#barChart").length) {
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: data,
                options: options
            });
        }
    });
</script>
