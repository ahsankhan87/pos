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

        <div class="portlet">

            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><?php echo $main; ?>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>

            <div class="portlet-body flip-scroll">

                <table class="table table-striped table-condensed  table-bordered flip-content" id="getAllLogs">
                    <thead class="flip-content">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>User</th>
                            <th>Module</th>
                            <th>Message</th>
                            <th>Host IP</th>

                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.col-sm-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->