<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $business->menu_name }}</h3>
            </div>
            <div class="card-body">
                <div id="chart-tasks-overview"></div>
            </div>
        </div>
    </div>
</div>
<script src="/vendors/apexcharts/apexcharts.min.js" defer></script>
<script>
    var length = 10;
    var colorArray = [
        'blue', 'azure', 'indigo', 'purple', 'pink', 'red', 'orange', 'yellow', 'lime', 'green', 'teal', 'cyan',
        'facebook', 'twitter', 'linkedin', 'google', 'youtube', 'vimeo', 'dribbble', 'github', 'instagram', 'pinterest',
        'vk', 'rss', 'flickr', 'bitbucket', 'tabler'];

    // 获取当前日期对象
    var currentDate = new Date();

    // 定义存放月份数组的变量
    var monthsData = [];
    var labels = [];
    var series = [];
    var colors = [];

    var left = 100;
    // 遍历过去的12个月（包括本月）并将其添加到数组中
    for (let i = length - 1; i >= 0; i--) {
        // 创建新的日期对象，设置年份为当前年份，月份为i+currentMonth-1（因为JavaScript中月份索引从0开始计算）

        if (i == 0) {
            monthsData.push(left);
        } else {
            var value = getRandomInt(0, left/2);
            monthsData.push(value);
            left = left - value;
        }
        labels.push("指标" + i);
        // colors.push(tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]));
    }

    function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-tasks-overview'), {
            chart: {
                type: "donut",
                fontFamily: 'inherit',
                height: 400,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: false
                },
            },
            fill: {
                opacity: 1,
            },
            series: monthsData,
            labels: labels,
            tooltip: {
                theme: 'dark'
            },
            grid: {
                strokeDashArray: 4,
            },
            colors: [tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]),tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]),tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)])],
            legend: {
                show: true,
                position: 'bottom',
                offsetY: 12,
                markers: {
                    width: 10,
                    height: 10,
                    radius: 100,
                },
                itemMargin: {
                    horizontal: 8,
                    vertical: 8
                },
            },
            tooltip: {
                fillSeriesColor: false
            },
        })).render();
    });
    // @formatter:on
</script>
