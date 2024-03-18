<div class="row">
    <div class="col-12 col-md-8 offset-md-2 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $business->menu_name }}</h4>
                <canvas id="areaChart" style="height:250px"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="/static/js/jquery.min.js"></script>
<script src="/connectPlus/vendors/chart.js/Chart.min.js"></script>
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

        var areaData = {
            labels: labels,
            datasets: [{
                label: '趋势分析',
                data: dataArray,
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1,
                fill: true, // 3: no fill
            }]
        };

        var areaOptions = {
            plugins: {
                filler: {
                    propagate: true
                }
            }
        }

        if ($("#areaChart").length) {
            var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
            var areaChart = new Chart(areaChartCanvas, {
                type: 'line',
                data: areaData,
                options: areaOptions
            });
        }
    });
</script>
