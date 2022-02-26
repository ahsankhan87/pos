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

        // $foo = 'Bob khan';              // Assign the value 'Bob' to $foo
        // $bar = &$foo;              // Reference $foo via $bar.
        // $bar = "My name is $bar";  // Alter $bar...
        // echo $bar;
        // echo $foo; 
        // echo '</br>';

        // function foo(&$arg){
        //     $z= $arg;
        //     $arg +=1;
        //     return $z;
        // }
        // $x = 3;
        // $y = foo($x);

        // echo 'x = ' .$x;
        // echo 'y = ' .$y;
        // echo '</br>';

        // $x = 2;

        // function dosome()
        // {
        //     $x = 3;
        // }
        // echo dosome();
        // echo $x;
        // echo '</br>';

        // $x = 0x25;
        // var_dump($x);
        // echo $x;
        ?>
        <p><?php echo anchor('pos/Categories/create', lang('add_new'), 'class="btn btn-success"'); ?>
            &nbsp;&nbsp;<button type="button" class="btn btn-info" onclick="window.history.back();">Back</button></p>

        <?php
        if (count($categories)) {
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
                        <thead class="flip-content">
                            <tr>
                                <th><?php echo lang('id'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('status'); ?></th>
                                <th><?php echo lang('action'); ?></th>
                            </tr>
                        </thead>

                        <tbody class="flip-content">
                            <?php
                            foreach ($categories as $key => $list) {
                                echo '<tr>';
                                echo '<td>' . $list['id'] . '</td>';
                                echo '<td>' . $list['name'] . '</td>';
                                echo '<td>' . $list['status'] . '</td>';

                                echo '<td>';

                            ?>

                                <?php echo anchor('pos/Categories/edit/' . $list['id'], '<i class="fa fa-pencil-square-o fa-fw"></i> |', 'title="Edit"'); ?>
                                <a href="<?php echo site_url('pos/Categories/delete/' . $list['id']) ?>" title="Make Inactive" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash-o fa-fw"></i></a>


                            <?php
                                echo '</td></tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            //echo $this->pagination->create_links();


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