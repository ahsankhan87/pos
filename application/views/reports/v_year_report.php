<div class="row">
    <div class="col-sm-12">
      <?php
        if(count($groups))
        {
        ?>
        <div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i><?php echo $main; ?>
				</div>
				<div class="tools hidden-print">
					<a href="javascript:;" class="collapse"></a>
                    <a href="javascript:window.print();" class="print"><i class="fa fa-print"></i></a>
					<a href="#portlet-config" data-toggle="modal" class="config"></a>
					<a href="javascript:;" class="reload"></a>
					<a href="javascript:;" class="remove"></a>
				</div>
			</div>
        <div class="portlet-body flip-scroll">
            
        <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
                <tr>
                    <th><?php echo lang('name'); ?></th>
                    <th><?php echo lang('jan'); ?></th>
                    <th><?php echo lang('feb'); ?></th>
                    <th><?php echo lang('mar'); ?></th>
                    <th><?php echo lang('apr'); ?></th>
                    <th><?php echo lang('may'); ?></th>
                    <th><?php echo lang('jun'); ?></th>
                    <th><?php echo lang('jul'); ?></th>
                    <th><?php echo lang('aug'); ?></th>
                    <th><?php echo lang('sep'); ?></th>
                    <th><?php echo lang('oct'); ?></th>
                    <th><?php echo lang('nov'); ?></th>
                    <th><?php echo lang('dec'); ?></th>
                    <th><?php echo lang('total'); ?></th>
                </tr>
            </thead>
            <tbody>
        <?php
        //FULL CALANDER VARIABLES
        $total_jan_report = 0; $total_apr_report =0; $total_jul_report = 0; $total_oct_report = 0;
        $total_feb_report = 0; $total_may_report = 0; $total_aug_report = 0; $total_nov_report = 0;
        $total_mar_report = 0; $total_jun_report = 0; $total_sep_report = 0; $total_dec_report =0;
        $total =0;
        
        foreach($groups as $key => $list)
        {
            $total =0;
            echo '<tr>';
            $fy_year = date('Y',strtotime(FY_START_DATE));
            
            $total += $jan_report=$this->M_reports->year_report($_SESSION['company_id'],'01',$fy_year,$list['account_code']);
            $total += $feb_report=$this->M_reports->year_report($_SESSION['company_id'],'02',$fy_year,$list['account_code']);
            $total += $mar_report=$this->M_reports->year_report($_SESSION['company_id'],'03',$fy_year,$list['account_code']);
            $total += $apr_report=$this->M_reports->year_report($_SESSION['company_id'],'04',$fy_year,$list['account_code']);
            $total += $may_report=$this->M_reports->year_report($_SESSION['company_id'],'05',$fy_year,$list['account_code']);
            $total += $jun_report=$this->M_reports->year_report($_SESSION['company_id'],'06',$fy_year,$list['account_code']);
            $total += $jul_report=$this->M_reports->year_report($_SESSION['company_id'],'07',$fy_year,$list['account_code']);
            $total += $aug_report=$this->M_reports->year_report($_SESSION['company_id'],'08',$fy_year,$list['account_code']);
            $total += $sep_report=$this->M_reports->year_report($_SESSION['company_id'],'09',$fy_year,$list['account_code']);
            $total += $oct_report=$this->M_reports->year_report($_SESSION['company_id'],'10',$fy_year,$list['account_code']);
            $total += $nov_report=$this->M_reports->year_report($_SESSION['company_id'],'11',$fy_year,$list['account_code']);
            $total += $dec_report=$this->M_reports->year_report($_SESSION['company_id'],'12',$fy_year,$list['account_code']);
            
            echo '<td>'.($langs == 'en' ? $list['title'] : $list['title_ur']).'</td>';
            //$report = $this->M_dashboard->monthlySaleReport($_SESSION["company_id"],$fy_year,$list['name']);
            echo '<td>'.$jan_report. '</td>'; echo '<td>'.$feb_report. '</td>';
            echo '<td>'.$mar_report. '</td>'; echo '<td>'.$apr_report. '</td>';
            echo '<td>'.$may_report. '</td>'; echo '<td>'.$jun_report. '</td>';
            echo '<td>'.$jul_report. '</td>'; echo '<td>'.$aug_report. '</td>';
            echo '<td>'.$sep_report. '</td>'; echo '<td>'.$oct_report. '</td>';
            echo '<td>'.$nov_report. '</td>'; echo '<td>'.$dec_report. '</td>';
            echo '<td><strong>'.$total.'</strong></td>';
            echo '</tr>';
            
            $total_jan_report += abs($jan_report); $total_may_report += abs($may_report); $total_sep_report += abs($sep_report);
            $total_feb_report += abs($feb_report); $total_jun_report += abs($jun_report); $total_oct_report += abs($oct_report);
            $total_mar_report += abs($mar_report); $total_jul_report += abs($jul_report); $total_nov_report += abs($nov_report);
            $total_apr_report += abs($apr_report); $total_aug_report += abs($aug_report); $total_dec_report += abs($dec_report);
            $total += abs($this->M_groups->get_account_balance($_SESSION['company_id'],FY_START_DATE,FY_END_DATE,$list['account_code']));
        }
        echo '<tfoot><tr>';
        echo '<td><strong>'.lang('total').'</strong></td>';
        echo '<td><strong>'.$total_jan_report.'</strong></td>';
        echo '<td><strong>'.$total_feb_report.'</strong></td>';
        echo '<td><strong>'.$total_mar_report.'</strong></td>';
        echo '<td><strong>'.$total_apr_report.'</strong></td>';
        echo '<td><strong>'.$total_may_report.'</strong></td>';
        echo '<td><strong>'.$total_jun_report.'</strong></td>';
        echo '<td><strong>'.$total_jul_report.'</strong></td>';
        echo '<td><strong>'.$total_aug_report.'</strong></td>';
        echo '<td><strong>'.$total_sep_report.'</strong></td>';
        echo '<td><strong>'.$total_oct_report.'</strong></td>';
        echo '<td><strong>'.$total_nov_report.'</strong></td>';
        echo '<td><strong>'.$total_dec_report.'</strong></td>';
        echo '<td><strong>'.$total.'</strong></td>';
        echo '</tr></tfoot>';
        }
        ?>
            </tbody>
            </table>
                </div>
            </div>
        </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
