<!DOCTYPE html>
<html>

<head>
    <!-- TABLES CSS CODE -->
    <?php include"comman/code_css_datatable.php"; ?>
    <?php include"modals/modal_customer.php"; ?>

    <style>
        
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            font-size: 30px;
            color: #333;
            font-weight: bold;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .form-input, .form-select, .form-textarea {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 15px;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #ff6a00;
            box-shadow: 0 0 12px rgba(255, 106, 0, 0.5);
            outline: none;
        }

        .form-textarea {
            resize: vertical;
        }

        .submit-btn {
            background-color: #ff6a00;
            border-color: #ee0979;
            color: #fff;
            font-weight: bold;
            padding: 12px 20px;
            width: 100%;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 5px 15px rgba(255, 106, 0, 0.2);
        }

        .submit-btn:hover {
            background-color: #ee0979;
            border-color: #d7005f;
            box-shadow: 0px 5px 20px rgba(255, 106, 0, 0.3);
        }

        .form-control {
            font-size: 16px;
        }

        .form-group input, .form-group select {
            background-color: #f9f9f9;
        }

        .form-group input:focus, .form-group select:focus {
            background-color: #fff;
        }
        
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  
  <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?> 
        <small>View/Search Customers</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
        
      </ol>
    </section>

    <div class="pay_now_modal">
    </div>
    <div class="pay_return_due_modal">
    </div>
    
    <!-- Main content -->
    <?= form_open('#', array('class' => '', 'id' => 'table_form')); ?>
    <input type="hidden" id='base_url' value="<?=$base_url;?>">
    <section class="content">
      <div class="row">
         <!-- ********** ALERT MESSAGE START******* -->
        <?php include"comman/code_flashdata.php"; ?>
        <!-- ********** ALERT MESSAGE END******* -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$page_title;?></h3>
              <?php if($CI->permissions('customers_add')) { ?>
              <div class="box-tools">
                <a class="btn btn-block btn-info" href="<?php echo $base_url; ?>customers/add">
                <i class="fa fa-plus"></i> <?= $this->lang->line('new_customer'); ?></a>
              </div>
              <?php } ?>
            </div>



            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped" width="100%">
                <thead class="bg-primary ">
                <tr>
                  <th>নং</th>
                  <th>কাস্টমার নাম</th>
                  <th>মোবাইল</th>
                  <th>ঠিকানা</th>
                  <th>বকেয়া টাকা</th> 
                  <th>অপশন</th> 
                </tr>
                </thead>
                <tbody class=" bg-gray assign_customer_data">
				
                </tbody>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
     <?= form_close();?>
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
<?php include"comman/code_js_datatable.php"; ?>
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true
    });
</script>

<script src="<?php echo $theme_link; ?>js/customers.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>

</body>
</html>
