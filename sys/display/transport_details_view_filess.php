<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo base_url(); ?>" target="">

    <style>
                
        .btn-custom-info {
            background-color: #0073b7;
            color: #fff;
            padding: 14px 28px;
            font-size: 18px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 115, 183, 0.3);
            transition: background-color 0.3s, transform 0.2s;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .btn-custom-info:hover {
            background-color: #005f8a;
            transform: translateY(-2px);
            color: #fff;
        }

        .btn-custom-info:active {
            transform: scale(0.98);
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
        

    </style>

<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
</head>

<body class="hold-transition skin-blue sidebar-mini"> 
<div class="wrapper">
 
 <?php include"sidebar.php"; ?> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $this->lang->line('expense'); ?>
        <small>Add/Update Expense</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>expense"><?= $this->lang->line('expenses_list'); ?></a></li>
        <li class="active"><?= $this->lang->line('expense'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
          <?php include"comman/code_flashdata.php"; ?>
            <!-- ********** ALERT MESSAGE END******* -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Please Select Valid Data</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            
            
                <div class="box-header">
                    <div class="col-md-8  justify-content" >
                        <div class="input-group">
                            <span class="input-group-addon" title="Select Items"><i class="fa fa-user"></i></span>
                            <select class="form-control select2 select_transport_id " id="" name=""  style="width: 100%;">
                                <option value=""> ট্রান্সপোর্ট সিলেক্ট করুন </option>
                                <?php foreach ($trans as $trn) { ?>
                                    <option value="<?php echo $trn->db_transport_id; ?>"><?php echo $trn->trans_port_namess; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div> 


                <div class="box-header row transport_info_assign container-fluid "></div>
                <div class="container" >
                    <div class="box-header row  searching_html_datas " style="margin-top: 20px; "></div>
                </div>


                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
          </div>
          <!-- /.box -->
          
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <?php include"footer.php"; ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_form.php"; ?>

<script src="<?php echo $theme_link; ?>js/transport_expense.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
  