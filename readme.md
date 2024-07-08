
## About Ttglad.Softbook
- 一键录入项目，生成自定义后台管理菜单（列表、图表）功能
```json
// 以下json内容可以通过chatGpt生成
{
	"project_title": "大规模数据实时分析与预警系统",
	"project_name": "大规模数据实时分析与预警系统",
	"project_sector": "数据分析",
	"project_author": "测试云计算有限公司",
	"develop_purpose": "本系统旨在实时采集大规模数据，利用分析引擎进行数据分析，并根据预警规则定制实时预警，最终生成实时监控报表，帮助用户及时发现和解决潜在问题。",
	"project_feature": "1. 数据采集配置：配置数据源、采集频率、采集量等；2. 分析引擎管理：管理数据分析模型、算法参数等；3. 预警规则定制：定制预警规则、阈值、触发条件等；4. 实时监控报表：生成实时监控报表，展示数据分析结果。",
	"project_skill": "1. 大数据处理技术：处理大规模数据的存储、处理和分析；2. 实时数据分析：实现对数据的实时分析和处理；3. 预警机制设计：设计有效的预警规则和预警触发机制；4. 数据可视化技术：将分析结果直观展示在监控报表中；5. 分布式架构设计：采用分布式架构处理大规模数据并提高系统性能。",
	"project_data": "1",
	"menus": [
		{
			"name": "数据采集配置",
			"remark": "配置数据源、采集频率、采集量等",
			"childMenus": [
				{
					"name": "数据源配置",
					"fields": "数据源名称|数据类型|数据格式|采集频率|数据量",
					"data_type": "list"
				},
				{
					"name": "采集频率配置",
					"fields": "频率名称|采集时间段|采集时长|触发条件|数据处理方式",
					"data_type": "list"
				}
			]
		},
		{
			"name": "分析引擎管理",
			"remark": "管理数据分析模型、算法参数等",
			"childMenus": [
				{
					"name": "模型管理",
					"fields": "模型名称|算法类型|参数设置|模型状态|创建时间",
					"data_type": "list"
				},
				{
					"name": "参数配置",
					"fields": "参数名称|参数类型|参数取值|参数描述|操作",
					"data_type": "list"
				}
			]
		},
		{
			"name": "预警规则定制",
			"remark": "定制预警规则、阈值、触发条件等",
			"childMenus": [
				{
					"name": "规则定制",
					"fields": "规则名称|规则类型|阈值设置|触发条件|预警方式",
					"data_type": "list"
				},
				{
					"name": "阈值设置",
					"fields": "指标名称|指标类型|阈值范围|适用范围|状态",
					"data_type": "chart-01"
				}
			]
		},
		{
			"name": "实时监控报表",
			"remark": "生成实时监控报表，展示数据分析结果",
			"childMenus": [
				{
					"name": "实时报表生成",
					"fields": "报表名称|报表类型|数据展示|生成时间|查看权限",
					"data_type": "chart-02"
				},
				{
					"name": "监控界面配置",
					"fields": "界面布局|指标展示|自定义配置|界面风格|保存设置",
					"data_type": "chart-03"
				}
			]
		}
	]
}
```
![saveInfo.png](https://raw.githubusercontent.com/ttglad/softbook/master/public/static/demo/saveInfo.png)
- 轻松实现自定义后台管理菜单（列表、图表）功能
![projectList.png](https://raw.githubusercontent.com/ttglad/softbook/master/public/static/demo/projectList.png)
![previewLogin.png](https://raw.githubusercontent.com/ttglad/softbook/master/public/static/demo/previewLogin.png)
![previewList.png](https://raw.githubusercontent.com/ttglad/softbook/master/public/static/demo/previewList.png)
![previewChart-01.png](https://raw.githubusercontent.com/ttglad/softbook/master/public/static/demo/previewChart-01.png)
- bootstrap模版支持，目前已支持以下多模版
  - tabler-horizontal
  - tabler-vertical
  - tabler-overlap
  - connect-plus
  - majestic
  - purple
  - kapella
  - stellar
  - star
  - azia
  - celestial
  - darkpan
- 自动补充初始化列表数据、生成菜单描述（以下内容为系统自动执行日志）
```json
系统为`大规模数据实时分析与预警系统`,菜单为`数据源配置`,该菜单下的字段有(`数据源名称`,`数据类型`,`数据格式`,`采集频率`,`数据量`),请枚举出5条此菜单的测试数据.  
数据源名称|数据类型|数据格式|采集频率|数据量
-----------|----------|----------|------------|----------
User_Behavior|行为日志|Json|5分钟|TB量级
System_Log|系统日志|Json|10分钟|GB量级
Device_Status|设备状态|XML|1小时|MB量级
Network_Traffic|网络流量|CSV|12小时|GB量级
Transaction_Record|交易记录|Protobuf|24小时|TB量级

根据菜单名:数据源配置,包含字段(数据源名称,数据类型,数据格式,采集频率,数据量),生成200字数左右的菜单功能说明.内容贴合菜单及字段说明.
二级菜单:数据源配置,返回的菜单说明为:
此菜单用于配置实时数据源，提供以下字段信息：
数据源名称：自定义数据源的名称。
数据类型：如数值、字符串、布尔值等，用于确定数据的格式。
数据格式：如整数、浮点数、文本等，指定数据的具体格式。
采集频率：数据源采集数据的频率，以秒为单位。
数据量：数据源预计产生的数据量，以每秒记录数为单位。

这些字段为数据源的连接、格式化和采集提供了详细的配置信息。通过恰当配置这些字段，用户可以确保从数据源中提取准确、及时的数据，为后续分析和使用提供可靠的基础。
```
- 自动生成[软件著作权材料](https://raw.githubusercontent.com/ttglad/softbook/master/public/static/demo/project.zip)（申请表、项目说明文档、代码文档）
![projectDoc.png](https://raw.githubusercontent.com/ttglad/softbook/master/public/static/demo/projectDoc.png)

## 体验地址
- 账号可以联系邮箱（tonneylon@gmail.com)

## License

The Ttglad Softbook is open-source software licensed under the [MIT license](https://www.apache.org/licenses/LICENSE-2.0).
