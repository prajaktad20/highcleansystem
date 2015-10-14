  
      <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>Dashboard</li>
            </ul>
            <h4>Dashboard</h4>
          </div>
        </div>
        <!-- media --> 
      </div>
      <!-- pageheader -->
      
       <div class="contentpanel">
        <div class="row">
          <div class="col-md-12">
            <ul class="widgetlist">
              <li>
			  <a class="default" href="<?php echo $this->user_role_base_url; ?>?r=Calendar/default/index"> 
			  <span class="fa  fa-calendar"></span><br>
                Calendars</a></li>
            </ul>
            <div class="row">
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                    <h2>Total 10 Customers Service Quotes Approved</h2>
                  </div>
                </div>
                 <div class="cart"> 
				 
				 <div id="graph_1_container" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
				 
		
                </div>
                <!--<div id="chart1" class="flotChart"></div>-->
              </div>
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                    <h2>Future Projection for Next 6 Months</h2>
                  </div>
                </div>
               <div class="cart"> 
			  <div id="graph_2_container" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
			  <!--  <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/dash_map2.jpg" /> </div> -->
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                    <h2>Top 5 Services for Next 3 Months</h2>
                  </div>
                </div>
                <div class="cart"> 
				  <div id="graph_3_container" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
				<!-- <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/dash_map3.jpg" />-->
				</div>
              </div>
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                    <h2>Project Status Graph</h2>
                  </div>
                </div>
               <div class="cart"> 
			   <div id="graph_4_container" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
			   <!--  <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/dash_map4.jpg" /> -->
			   </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
  

	
<?php		

$graph_1_customer_list = json_encode($graph_1);
 
?>	
	 
<script type="text/javascript">

$(function () {


var graph_1_customer_list = '<?php echo $graph_1_customer_list; ?>';
graph_1_customer_list = JSON.parse(graph_1_customer_list);
var graph_1_customer_data = new Array();

graph_1_customer_list.forEach(function(entry) {
	var value = parseInt(entry.value);
	var test = new Array(entry.name,value);
	graph_1_customer_data.push(test);
});
	
	
    $('#graph_1_container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: false,
        },
		credits: {
			enabled: false
		},
        subtitle: {
            text: false,
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: false,
            },
			
			 labels: {
				formatter: function () {
					return this.value;
				}
			}
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>${point.y:.1f}</b>'
        },
        series: [{
			showInLegend: false,
            name: 'Company',
            data: graph_1_customer_data, 
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                x: 4,
                y: 10,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif',
                    textShadow: '0 0 3px black'
                }
            }
        }]
    });
});


 
 </script>	 
				
		
	
		
<?php		
$graph_2_x_axis = implode("','", $x_axis_2_graph);
$graph_2_y_axis_booked_approved = implode(",", $y_axis_2_graph_booked_approved);
$graph_2_y_axis_not_booked_approved = implode(",", $y_axis_2_graph_not_booked_approved);
 
?>	
	 
<script type="text/javascript">

$(function () {
	
    $('#graph_2_container').highcharts({
        chart: {
            type: 'column'
        },
		credits: {
			enabled: false
		},
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: ['<?php echo $graph_2_x_axis; ?>']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Price ($) ->'
            },
			
			
			 labels: {
				formatter: function () {
					return this.value;
				}
			}
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>${point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Booked-Approved',
            data: [<?php echo $graph_2_y_axis_booked_approved; ?>]

        }, {
            name: 'Booked-NotApproved',
            data: [<?php echo $graph_2_y_axis_not_booked_approved; ?>]

        }]
    });
});
</script>	 
		
		
 
<?php 
$x_axis_3_graph = implode("','", $x_axis_3_graph);
$service_list = $y_axis_3_graph_top_five_services;

?>
	 
<script type="text/javascript">

$(function () {


	
    $('#graph_3_container').highcharts({
        chart: {
            type: 'column'
        },
		credits: {
			enabled: false
		},
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: ['<?php echo $x_axis_3_graph; ?>']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Frequency Of Services -> '
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: 
		[
		
		<?php foreach($service_list as $service) { ?>
		
				{
					name: "<?php echo $service['name']; ?>",
					data: [<?php echo implode(",",$service['data']); ?>]

				},
				
		<?php } ?>		
		
		]
    });
});
</script>	 
		
	  

<script type="text/javascript">
$(function () {

var approve_quote_count = parseInt('<?php echo $approve_quote_count; ?>');
var decline_quote_count =  parseInt('<?php echo $decline_quote_count; ?>');
var pending_quote_count =  parseInt('<?php echo $pending_quote_count; ?>');

    $('#graph_4_container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
       
	   
	   	credits: {
			enabled: false
		},
		
		exporting: {
			enabled: false
		},
		
			title: {
            text: false
        },
		
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Quotes',
            data: [
                ['APPROVED',   approve_quote_count],
                ['DECLINED',       decline_quote_count],
				['PENDING',  pending_quote_count],                
            ]
        }]
    });
});


		</script>


  
	
