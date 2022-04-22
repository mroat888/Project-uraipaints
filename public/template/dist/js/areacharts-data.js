/*Dashboard Init*/

"use strict";
/*****E-Charts function start*****/
var echartsConfig = function() {
    if( $('#e_chart_3_dashboard').length > 0 ){
		var e_chart_3_dashboard = echarts.init(document.getElementById('e_chart_3_dashboard'));
		var option3 = {
			tooltip: {
				show: true,
				trigger: 'axis',
				backgroundColor: '#fff',
				borderRadius:6,
				padding:6,
				axisPointer:{
					lineStyle:{
						width:0,
					}
				},
				textStyle: {
					color: '#324148',
					fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"',
					fontSize: 12
				}
			},
			xAxis: {
				type: 'category',
				boundaryGap: false,
				data: ['Monm', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
				axisLine: {
					show:false
				},
				axisTick: {
					show:false
				},
				axisLabel: {
					textStyle: {
						color: '#5e7d8a'
					}
				}
			},
			yAxis: {
				type: 'value',
				axisLine: {
					show:false
				},
				axisTick: {
					show:false
				},
				axisLabel: {
					textStyle: {
						color: '#5e7d8a'
					}
				},
				splitLine: {
					lineStyle: {
						color: '#eaecec',
					}
				}
			},
			grid: {
				top: '3%',
				left: '3%',
				right: '3%',
				bottom: '3%',
				containLabel: true
			},
			series: [
				{
					data: [820, 932, 901, 934, 1290, 1330, 1320],
					type: 'line',
					symbolSize: 6,
					itemStyle: {
						color: '#22af47',
					},
					lineStyle: {
						color: '#22af47',
						width:2,
					},
					areaStyle: {
						color: '#22af47',
					},
				}
			]
		};
		e_chart_3_dashboard.setOption(option3);
		e_chart_3_dashboard.resize();
	}
	// if( $('#e_chart_3_dashboard').length > 0 ){
	// 	var e_chart_3_dashboard = echarts.init(document.getElementById('e_chart_3_dashboard'));
	// 	var option3 = {
	// 		tooltip: {
	// 			show: true,
	// 			trigger: 'axis',
	// 			backgroundColor: '#fff',
	// 			borderRadius:6,
	// 			padding:6,
	// 			axisPointer:{
	// 				lineStyle:{
	// 					width:0,
	// 				}
	// 			},
	// 			textStyle: {
	// 				color: '#324148',
	// 				fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"',
	// 				fontSize: 12
	// 			}
	// 		},
	// 		xAxis: {
	// 			type: 'category',
	// 			boundaryGap: false,
	// 			data: ['Monm', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
	// 			axisLine: {
	// 				show:false
	// 			},
	// 			axisTick: {
	// 				show:false
	// 			},
	// 			axisLabel: {
	// 				textStyle: {
	// 					color: '#5e7d8a'
	// 				}
	// 			}
	// 		},
	// 		yAxis: {
	// 			type: 'value',
	// 			axisLine: {
	// 				show:false
	// 			},
	// 			axisTick: {
	// 				show:false
	// 			},
	// 			axisLabel: {
	// 				textStyle: {
	// 					color: '#5e7d8a'
	// 				}
	// 			},
	// 			splitLine: {
	// 				lineStyle: {
	// 					color: '#eaecec',
	// 				}
	// 			}
	// 		},
	// 		grid: {
	// 			top: '3%',
	// 			left: '3%',
	// 			right: '3%',
	// 			bottom: '3%',
	// 			containLabel: true
	// 		},
	// 		series: [
	// 			{
	// 				data: [820, 932, 901, 934, 1290, 1330, 1320],
	// 				type: 'line',
	// 				symbolSize: 6,
	// 				itemStyle: {
	// 					color: '#22af47',
	// 				},
	// 				lineStyle: {
	// 					color: '#22af47',
	// 					width:2,
	// 				},
	// 				areaStyle: {
	// 					color: '#22af47',
	// 				},
	// 			}
	// 		]
	// 	};
	// 	e_chart_3_dashboard.setOption(option3);
	// 	e_chart_3_dashboard.resize();
	// }

    // $cc = "";

	if( $('#e_chart_6_dashboard').length > 0 ){
		var e_chart_6_dashboard = echarts.init(document.getElementById('e_chart_6_dashboard'));
		var option6 = {
			tooltip: {
				show: true,
				trigger: 'axis',
				backgroundColor: '#fff',
				borderRadius:6,
				padding:6,
				axisPointer:{
					lineStyle:{
						width:0,
					}
				},
				textStyle: {
					color: '#324148',
					fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"',
					fontSize: 12
				}
			},
			xAxis: {
				type: 'category',
				boundaryGap: false,
				data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
				axisLine: {
					show:false
				},
				axisTick: {
					show:false
				},
				axisLabel: {
					textStyle: {
						color: '#5e7d8a'
					}
				}
			},
			yAxis: {
				type: 'value',
				axisLine: {
					show:false
				},
				axisTick: {
					show:false
				},
				axisLabel: {
					textStyle: {
						color: '#5e7d8a'
					}
				},
				splitLine: {
					lineStyle: {
						color: '#eaecec',
					}
				}
			},
			grid: {
				top: '3%',
				left: '3%',
				right: '3%',
				bottom: '3%',
				containLabel: true
			},
			series: [
				{
					data:[120, 132, 101, 134, 90, 230, 210],
					type: 'line',
					stack: 'a',
					symbolSize: 6,
					itemStyle: {
						color: '#22af47',
					},
					lineStyle: {
						color: '#22af47',
						width:2,
					},
					// areaStyle: {
					// 	color: '#22af47',
					// },
				},
				{
					data: [220, 182, 191, 234, 290, 330, 310],
					type: 'line',
					stack: 'a',
					symbolSize: 6,
					itemStyle: {
						color: '#3fb95f',
					},
					lineStyle: {
						color: '#3fb95f',
						width:2,
					},
					// areaStyle: {
					// 	color: '#3fb95f',
					// },
				}
			]
		};
		e_chart_6_dashboard.setOption(option6);
		e_chart_6_dashboard.resize();
	}
	if( $('#e_chart_7').length > 0 ){
		var e_chart_7 = echarts.init(document.getElementById('e_chart_7'));
		var option7 = {
			tooltip: {
				show: true,
				trigger: 'axis',
				backgroundColor: '#fff',
				borderRadius:6,
				padding:6,
				axisPointer:{
					lineStyle:{
						width:0,
					}
				},
				textStyle: {
					color: '#324148',
					fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"',
					fontSize: 12
				}
			},
			xAxis: {
				type: 'category',
				boundaryGap: false,
				data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
				axisLine: {
					show:false
				},
				axisTick: {
					show:false
				},
				axisLabel: {
					textStyle: {
						color: '#5e7d8a'
					}
				}
			},
			yAxis: {
				type: 'value',
				axisLine: {
					show:false
				},
				axisTick: {
					show:false
				},
				axisLabel: {
					textStyle: {
						color: '#5e7d8a'
					}
				},
				splitLine: {
					lineStyle: {
						color: '#eaecec',
					}
				}
			},
			grid: {
				top: '3%',
				left: '3%',
				right: '3%',
				bottom: '3%',
				containLabel: true
			},
			series: [
				{
					data: [820, 932, 901, 934, 1290, 1330, 1320],
					type: 'line',
					symbolSize: 6,
					lineStyle: {
						color: '#22af47',
						width:2,
					},
					itemStyle: {
						color: '#22af47',
					},
					areaStyle: {
						normal: {
							color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
								offset: 0,
								color: '#22af47'
							}, {
								offset: 1,
								color: '#90d7a3'
							}])
						}
					},
				}
			]
		};
		e_chart_7.setOption(option7);
		e_chart_7.resize();
	}
}
/*****Resize function start*****/
var echartResize;
$(window).on("resize", function () {
	/*E-Chart Resize*/
	clearTimeout(echartResize);
	echartResize = setTimeout(echartsConfig, 200);
}).resize();
/*****Resize function end*****/

/*****Function Call start*****/
echartsConfig();
/*****Function Call end*****/
