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
    var length = 40;
    var colorArray = [
        'blue', 'azure', 'indigo', 'purple', 'pink', 'red', 'orange', 'yellow', 'lime', 'green', 'teal', 'cyan',
        'facebook', 'twitter', 'linkedin', 'google', 'youtube', 'vimeo', 'dribbble', 'github', 'instagram', 'pinterest',
        'vk', 'rss', 'flickr', 'bitbucket', 'tabler'];

    // 获取当前日期对象
    var currentDate = new Date();

    // 定义存放月份数组的变量
    var monthsArray = [];
    var monthsData_1 = [];
    var monthsData_2 = [];
    var monthsData_3 = [];

    // 遍历过去的12个月（包括本月）并将其添加到数组中
    for (let i = length - 1; i >= 0; i--) {
        // 创建新的日期对象，设置年份为当前年份，月份为i+currentMonth-1（因为JavaScript中月份索引从0开始计算）
        // var monthObj = new Date(currentDate.getFullYear(), currentDate.getMonth() - i);
        //
        // // 格式化月份字符串，如"2022-05"
        // var formattedMonth = `${String(monthObj.getMonth() + 1).padStart(2, '0')}/${monthObj.getFullYear()}`;

        var date = new Date(currentDate.getTime() - i * 24 * 60 * 60 * 1000);

        // 格式化日期为 "yyyy-mm-dd" 形式
        var formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;


        // 将格式化后的月份字符串添加到数组中
        monthsArray.push(formattedDate);

        monthsData_1.push(getRandomInt(1000, 20000));
        monthsData_2.push(getRandomInt(1000, 20000));
        monthsData_3.push(getRandomInt(1000, 20000));
    }

    var series = [{
        name: "指标一",
        data: monthsData_1
    }, {
        name: "指标二",
        data: monthsData_2
    }, {
        name: "指标三",
        data: monthsData_3
    }];

    function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function generateRandomSubarray(arr) {
        var randomIndex = Math.floor(Math.random() * arr.length); // 获取随机索引
        return arr.slice(0, randomIndex + 1); // 返回包含随机索引及其前面所有元素的子数组
    }


    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-tasks-overview'), {
            chart: {
                type: "line",
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
            fill: {
                opacity: 1,
            },
            stroke: {
                width: 2,
                lineCap: "round",
                curve: "smooth",
            },
            series: generateRandomSubarray(series),
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
                xaxis: {
                    lines: {
                        show: true
                    }
                },
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                },
                type: 'datetime',
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            labels: monthsArray,
            colors: [tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)]), tabler.getColor(colorArray[Math.floor(Math.random() * colorArray.length)])],
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
        })).render();
    });
    // @formatter:on
</script>
