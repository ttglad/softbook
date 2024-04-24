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
    var length = 18;
    var colorArray = [
        'blue', 'azure', 'indigo', 'purple', 'pink', 'red', 'orange', 'yellow', 'lime', 'green', 'teal', 'cyan',
        'facebook', 'twitter', 'linkedin', 'google', 'youtube', 'vimeo', 'dribbble', 'github', 'instagram', 'pinterest',
        'vk', 'rss', 'flickr', 'bitbucket', 'tabler'];

    // 获取当前日期对象
    var currentDate = new Date();

    // 定义存放月份数组的变量
    var monthsArray = [];
    var monthsData = [];

    // 遍历过去的12个月（包括本月）并将其添加到数组中
    for (let i = length - 1; i >= 0; i--) {
        // 创建新的日期对象，设置年份为当前年份，月份为i+currentMonth-1（因为JavaScript中月份索引从0开始计算）
        var monthObj = new Date(currentDate.getFullYear(), currentDate.getMonth() - i);

        // 格式化月份字符串，如"2022-05"
        var formattedMonth = `${String(monthObj.getMonth() + 1).padStart(2, '0')}/${monthObj.getFullYear()}`;

        // 将格式化后的月份字符串添加到数组中
        monthsArray.push(formattedMonth);

        monthsData.push(getRandomInt(10, 90));
    }

    function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-tasks-overview'), {
            chart: {
                type: "bar",
                fontFamily: 'inherit',
                height: 400,
                parentHeightOffset: 0,
                toolbar: {
                    show: false,
                },
                animations: {
                    enabled: false
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                }
            },
            dataLabels: {
                enabled: false,
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: "value",
                data: monthsData
            }],
            tooltip: {
                theme: 'dark'
            },
            grid: {
                padding: {
                    top: -20,
                    right: 0,
                    left: -4,
                    bottom: -4
                },
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false,
                },
                categories: monthsArray,
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            colors: [tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)])],
            legend: {
                show: false,
            },
        })).render();
    });
    // @formatter:on
</script>
