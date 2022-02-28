<!-- BEGIN OVERVIEW STATISTIC BARS-->
<div class="row stats-overview-cont">
	<div class="col-md-2 col-sm-4">
		<div class="stats-overview stat-block">
			<!--
            <div class="display stat bad huge">
				<span class="line-chart" style="display: inline;"><span style="display: none;"><span style="display: none;"><span style="display: none;">
				2,6,8,11, 14, 11, 12, 13, 15, 12, 9, 5, 11, 12, 15, 9,3 </span><canvas width="50" height="20"></canvas></span><canvas width="50" height="20"></canvas></span><canvas width="40" height="20"></canvas></span>
				<div class="percent">
					 +6%
				</div>
			</div>
            -->
            
			<div class="details">
				<div class="title">
					 <?php echo lang('daily_sales'); ?>
					 GIT Checking another
				</div>
				<div class="numbers">
					 <?php echo '<small>'.$_SESSION['home_currency_symbol'].'</small>'.round($today_sale,3); ?>
				</div>
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">
					<span class="sr-only">
					16% Complete </span>
					</span>
				</div>
			</div>
		</div>
	</div>
    <?php //echo md5('123'); ?>
	<div class="col-md-2 col-sm-4">
		<div class="stats-overview stat-block">
			<!--
            <div class="display stat good huge">
				<span class="bar-chart" style="display: inline;"><span style="display: none;"><span style="display: none;"><span style="display: none;">
				1,4,9,12, 10, 11, 12, 15, 12, 11, 9, 12, 15, 19, 14, 13, 15 </span><canvas width="50" height="20"></canvas></span><canvas width="50" height="20"></canvas></span><canvas width="40" height="20"></canvas></span>
				<div class="percent">
					 +86%
				</div>
			</div>
            -->
			<div class="details">
				<div class="title">
					 <?php echo lang('monthly_sales'); ?>
				</div>
				<div class="numbers">
					 <?php echo '<small>'.$_SESSION['home_currency_symbol'].'</small>'.round($cur_month,3); ?>
				</div>
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-warning" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100">
					<span class="sr-only">
					56% Complete </span>
					</span>
				</div>
			</div>
		</div>
	</div>
    <div class="col-md-2 col-sm-4">
		<div class="stats-overview stat-block">
			<!--
            <div class="display stat ok huge">
				<span class="line-chart" style="display: inline;"><span style="display: none;"><span style="display: none;"><span style="display: none;">
				5, 6, 7, 11, 14, 10, 15, 19, 15, 2 </span><canvas width="50" height="20"></canvas></span><canvas width="50" height="20"></canvas></span><canvas width="40" height="20"></canvas></span>
				<div class="percent">
					 +66%
				</div>
			</div>
            -->
            
			<div class="details">
				<div class="title">
					 <?php echo lang('expenses'); ?>
				</div>
				<div class="numbers">
					 <?php echo '<small>'.$_SESSION['home_currency_symbol'].'</small>'.round($total_expenses,2); ?>
                     
				</div>
			</div>
			<div class="progress">
				<span style="width: <?php echo round($total_expenses,2); ?>%;" class="progress-bar progress-bar-info" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">
				<span class="sr-only">
				66% Complete </span>
				</span>
			</div>
            
		</div>
	</div>
	<div class="col-md-2 col-sm-4">
		<div class="stats-overview stat-block">
            <!--
			<div class="display stat ok huge">
				<span class="line-chart" style="display: inline;"><span style="display: none;"><span style="display: none;"><span style="display: none;">
				2,6,8,12, 11, 15, 16, 17, 14, 12, 10, 8, 10, 2, 4, 12, 19 </span><canvas width="50" height="20"></canvas></span><canvas width="50" height="20"></canvas></span><canvas width="40" height="20"></canvas></span>
				<div class="percent">
					 +72%
				</div>
			</div>
            -->
			<div class="details">
				<div class="title">
					<?php echo lang('income'); ?>
				</div>
				<div class="numbers">
					 <?php echo '<small>'.$_SESSION['home_currency_symbol'].'</small>'.round(-$net_income,2); ?>
				</div>
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-danger" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100">
					<span class="sr-only">
					72% Complete </span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2 col-sm-4">
		<div class="stats-overview stat-block">
			<!--
            <div class="display stat bad huge">
				<span class="line-chart" style="display: inline;"><span style="display: none;"><span style="display: none;"><span style="display: none;">
				1,7,9,11, 14, 12, 6, 7, 4, 2, 9, 8, 11, 12, 14, 12, 10 </span><canvas width="50" height="20"></canvas></span><canvas width="50" height="20"></canvas></span><canvas width="40" height="20"></canvas></span>
				<div class="percent">
					 +15%
				</div>
			</div>
            -->
			<div class="details">
				<div class="title">
					 <?php echo lang('stock'); ?>
				</div>
				<div class="numbers">
					 <?php echo '<small>'.$_SESSION['home_currency_symbol'].'</small>'.round($totalStock,2); ?>
				</div>
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-success" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
					<span class="sr-only">
					15% Complete </span>
					</span>
				</div>
			</div>
		</div>
	</div>
    
	<div class="col-md-2 col-sm-4">
		<div class="stats-overview stat-block">
			<!--
            <div class="display stat good huge">
				<span class="line-chart" style="display: inline;"><span style="display: none;"><span style="display: none;"><span style="display: none;">
				2,6,8,12, 11, 15, 16, 11, 16, 11, 10, 3, 7, 8, 12, 19 </span><canvas width="50" height="20"></canvas></span><canvas width="50" height="20"></canvas></span><canvas width="40" height="20"></canvas></span>
				<div class="percent">
					 +16%
				</div>
			</div>
            -->
			<div class="details">
				<div class="title">
					<?php echo lang('cashonhand'); ?>
				</div>
				<div class="numbers">
				<?php echo '<small>'.$_SESSION['home_currency_symbol'].'</small>'.round($cash_hand,2); ?>
				</div>
				<div class="progress">
					<span style="width: 100%;" class="progress-bar progress-bar-warning" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">
					<span class="sr-only">
					16% Complete </span>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END OVERVIEW STATISTIC BARS-->
<div class="clearfix">
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
		<!-- BEGIN PORTLET-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart"></i><?php echo lang('monthly_sales'); ?>
				</div>
				<!--
                <div class="actions">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default btn-sm active">
						<input type="radio" name="options" class="toggle">New </label>
						<label class="btn btn-default btn-sm">
						<input type="radio" name="options" class="toggle">Returning </label>
					</div>
				</div>
                -->
			</div>
			<div class="portlet-body">
            <?php 
                //Chart for Best 10 Sold products
                $top10_products = array();//$this->M_dashboard->top10_selled_products();
            
                $product =""; //for chart
                $qty = ""; //for chart
                 //var_dump($monthlySaleReport);
                foreach($top10_products as $values):
                    
                    $product .= '"'.$values['product'] . ' '. $values['size'].'",';
                    $qty .= abs($values['qty']).',';
                        
                endforeach;
                
                //convert into JSON for Chart
                $product = '['.$product.']';
                $qty = '['.$qty.']';
                ///////////////////////////////////////
                
                //get total monthly unit price of sold items i.e total monthly sale for the chart
                $month =""; //for chart
                $price = ""; //for chart
                 //var_dump($monthlySaleReport);
                foreach($monthly_sale as $values):
                    
                    $month .= '"'.$values['month'].'",';
                    $price .= abs($values['amount']).',';
                        
                endforeach;
                
                //convert into JSON for Chart
                $month = '['.$month.']';
                $price = '['.$price.']';
                ///////////////////////////////////////
                    
                    //for expense
                    //////////////////
                    $exp_balance = '';
                    $title = '';
                    if(@$expenses)
                    {
                         foreach($expenses as $exp_val):  //Expenses 
                        //$dr_total = $this->M_ledgers->get_dr_total($exp_val['id']);
                        //$cr_total = $this->M_ledgers->get_cr_total($exp_val ['id']);
                        
                        //$expense_chart .= '{value:"'.$exp_val['balance'].'", color:"'.$exp_color[$count].'", highlight:"'.$exp_color_hover[$count].'", label:"'.$exp_val['title'].'"},';
                        
                        $title .= '"'.$exp_val['title'].'",';
                        $exp_balance .= abs($exp_val['balance']).',';
                   
                            //$count ++;
                           endforeach;
                    }
                     
                    //convert into JSON for Chart
                    $title = '['.$title.']';
                    $exp_balance = '['.$exp_balance.']';
                    $exp_color = array('#F7464A','#46BFBD','#FDB45C','#949FB1','#4D5360','#4080bf','#6699cc','#009933','#ace600','#ff9900');
                    $exp_color_hover = array('#FF5A5E','#5AD3D1','#FFC870','#A8B3C5','#616774','#6699cc','#bbff99','#00cc44','#c6ff1a','#ffad33');
                        
                ?>
				<div id="site_statistics_loading" style="display: none;">
					<img src="<?php echo base_url(); ?>assets/img/loading.gif" alt="loading">
				</div>
				<div id="site_statistics_content" class="display-none" style="display: block;">
					<div>
                    <canvas id="canvas"></canvas>
                </div>
                <script>
                    ////////////////////////////////////
                    ////TOP 10 Sold PRODUCTS CHART
                    var product = <?php echo $product; ?>;
                    var qty = <?php echo $qty; ?>;
                      var ProductData = {
                        labels: product,
                        datasets: [{
                            label:'Quantity Sold',
                            //fillColor: "rgba(120,220,220,0.5)",
                            //strokeColor: "rgba(140,220,220,0.8)",
                            //highlightFill: "rgba(120,220,220,0.75)",
                            //highlightStroke: "rgba(140,220,220,1)",
                            data: qty,
                            backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]

                    };
                    
                    ////////////////////////////////////
                    ////MONTHLY SALES CHART
                    var months = <?php echo $month; ?>;
                    var price = <?php echo $price; ?>;
                      var barChartData = {
                        labels: months,
                        datasets: [{
                            label:'Monthly Sales',
                            //fillColor: "rgba(120,220,220,0.5)",
                            //strokeColor: "rgba(140,220,220,0.8)",
                            //highlightFill: "rgba(120,220,220,0.75)",
                            //highlightStroke: "rgba(140,220,220,1)",
                            data: price,
                            backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]

                    };
                    
                    ///////////////////////////
                    //EXPENSE CHART
                    var title = <?php echo $title; ?>;
                    var exp_balance = <?php echo $exp_balance; ?>;
                    var ExpenseData = {
                        labels: title,
                        datasets: [{
                            data: exp_balance,
                            backgroundColor: <?php echo json_encode($exp_color); ?>,
                            borderColor: <?php echo json_encode($exp_color_hover); ?>,
                            borderWidth: 1
                        }]

                    };
                    window.onload = function() {
                        
                        //Product sale
                        var ctx2 = document.getElementById("canvas-products").getContext("2d");
                        var myBarChart = new Chart(ctx2, {
                        type: 'horizontalBar',
                        data: ProductData,
                        //options: options
                        });
                        ////
                        
                        //Monthly sale
                        var ctx = document.getElementById("canvas").getContext("2d");
                        var myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: barChartData,
                        //options: options
                        });
                        ////
                        
                        //for expenses myDoughnut chart
                        var ctx1 = document.getElementById("chart-area").getContext("2d");
				        var myDoughnutChart = new Chart(ctx1, {
                        type: 'doughnut',
                        data: ExpenseData,
                        //options: options
                        });
                    }
                </script>
                </div>
			</div>
		</div>
		<!-- END PORTLET-->
	</div>
    <div class="col-md-6 col-sm-12">
		<!-- BEGIN PORTLET-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart"></i><?php echo lang('total') .' '.lang('expenses'); ?>
				</div>
				<!--
                <div class="actions">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default btn-sm active">
						<input type="radio" name="options" class="toggle">New </label>
						<label class="btn btn-default btn-sm">
						<input type="radio" name="options" class="toggle">Returning </label>
					</div>
				</div>
                -->
			</div>
			<div class="portlet-body">
				<div id="site_statistics_loading" style="display: none;">
					<img src="<?php echo base_url(); ?>assets/img/loading.gif" alt="loading">
				</div>
				<div id="site_statistics_content" class="display-none" style="display: block;">
                <style>
                    #canvas-holder{width:100%;}                    
                    /* #expense_chart tr{  } */
                </style>
				    
                <div id="canvas-holder" class="center-block">
        			<canvas id="chart-area" ></canvas>
        		</div>
                
                        
                </div>
			</div>
		</div>
		<!-- END PORTLET-->
	</div>
</div>
<div class="clearfix">

<div class="row">
<div class="col-md-6 col-sm-12">
		<!-- BEGIN PORTLET-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart"></i><?php echo lang('best_selling_products'); ?>
				</div>
				<!--
                <div class="actions">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default btn-sm active">
						<input type="radio" name="options" class="toggle">New </label>
						<label class="btn btn-default btn-sm">
						<input type="radio" name="options" class="toggle">Returning </label>
					</div>
				</div>
                -->
			</div>
			<div class="portlet-body">
				<div id="site_statistics_loading" style="display: none;">
					<img src="<?php echo base_url(); ?>assets/img/loading.gif" alt="loading">
				</div>
				<div id="site_statistics_content" class="display-none" style="display: block;">
					<div>
                    <canvas id="canvas-products"></canvas>
                </div>
			</div>
		</div>
		<!-- END PORTLET-->
	</div>
</div>

<!-- BEGIN PORTLET
<div class="col-md-6 col-sm-12">

    <div class="portlet calendar">
    	<div class="portlet-title">
    		<div class="caption">
    			<i class="fa fa-calendar"></i>Event Calendar
    		</div>
    	</div>
    	<div class="portlet-body">
    		<div id="calendar" class="fc fc-ltr"></div>
    		</div>
	</div>
    
</div>
-->
</div>