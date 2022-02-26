<div class="row">
    <div class="col-sm-12">
        <?php
        if ($this->session->flashdata('message')) {
            echo "<div class='alert alert-success fade in'>";
            echo $this->session->flashdata('message');
            echo '</div>';
        }
        if ($this->session->flashdata('error')) {
            echo "<div class='alert alert-danger fade in'>";
            echo $this->session->flashdata('error');
            echo '</div>';
        }
        ?>
        <p><?php echo anchor('setting/C_fyear/create', 'Create New Financial Year', 'class="btn btn-success"'); ?></p>
    
        <?php

        if (count($Fyear)) {
        ?>
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i><span id="print_title"><?php echo $main; ?></span>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#portlet-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="portlet-body flip-scroll">

                    <table class="table table-striped table-condensed table-bordered flip-content" id="sample_1">
                        <thead>
                            <tr valign='top'>
                                <th>ID</th>
                                <th>FY Start Date</th>
                                <th>FY End Date</th>
                                <th>Financial Year</th>
                                <th>Status</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($Fyear as $key => $list) {
                                echo '<tr valign="top">';
                                echo '<td>' . $list['id'] . '</td>';
                                echo '<td>' . $list['fy_start_date'] . '</td>';
                                echo '<td >' . $list['fy_end_date'] . '</td>';
                                echo '<td >' . $list['fy_year'] . '</td>';
                                echo '<td >' . $list['status'] . '</td>';

                                echo '<td>' . anchor('setting/C_fyear/edit/' . $list['id'], 'Edit') . ' | ';
                                //echo  anchor('accounts/C_fyear/activateFY/'.$list['id'],' Activate'). '</td>';
                                echo '<a href="' . site_url('setting/C_fyear/activateFY/' . $list['id']) . '" onclick="return confirm(\'Are you sure you want to activate?\');">Activate</a></td>';
                                // echo '<td></td>';
                                echo '</tr>';
                            }
                            echo '</tbody></table>';

                            ?>
                </div>
                <!-- /.portlet body -->
            </div>
            <!-- /.portlet -->
        <?php
        }
        ?>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->