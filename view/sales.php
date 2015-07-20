<?php
$title='销售额';
?>
<?php require(FILE_ROOT.'/view/header.php'); ?>

<div id="sales">


</div>

<script type="text/javascript">
//var sales;
$(function(){
	
	/*$.getJSON('index.php?controller=model&model=sales&function=sales&time='+ new Date().getTime(),function(data){
		alert(data);																	   
		//sales=data;				  
	});*/	   
	
	$.ajax({
		url:'index.php?controller=model&model=sales&function=sales&time='+ new Date().getTime(),
		data:'',
		type:'POST',
		async:true,
		beforeSend: function(){
			pop_loading();
		},
		success: function(text){
			pop_loading_close();
			//console.log(text);
			//sales=text;
			sales(text);
		}
	});
	//alert(sales);
	
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});
		   
		   
});


function sales(text){
	//var sales= eval('('+text)+')');
	//var sales=$.parseJSON(text);
	text=text.replace('[','');
	text=text.replace(']','');
	console.log(text);
	
    $('#sales').highcharts({                   //图表展示容器，与div的id保持一致
		chart: {
			type: 'spline',
			animation: Highcharts.svg, // don't animate in old IE
			marginRight: 10,
		},
		title: {
			text: false
		},
        xAxis: {
			type: 'datetime',
			tickPixelInterval: 150
        },
        yAxis: {
            title: {
                text: '元'                  //指定y轴的标题
            },
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
        },
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%Y-%m-%d', this.x) +'<br/>'+
					Highcharts.numberFormat(this.y, 2);
			}
		},
		legend: {
			enabled: false
		},
		exporting: {
			enabled: false
		},
        series: [{                                 //指定数据列
            name: '销售额',                          //数据列名
            /*data: [{x:1,y:10000},{x:2,y:20000},{x:3,y:30000}] */                       //数据
			/*data: (function() {
				// generate an array of random data
				var data = [],
					time = (new Date()).getTime(),
					i;

				for (i = -19; i <= 0; i++) {
					data.push({
						x: time + i * 1000,
						y: 0
					});
				}
				console.log(data);
				return data;
			})()*/
			data:sales
        }]
    });
	
	
}
</script>

<?php require(FILE_ROOT.'/view/footer.php'); ?>