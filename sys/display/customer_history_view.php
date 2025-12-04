<!DOCTYPE html>
<html>
<head>
  <base href="<?php echo base_url(); ?>" target="">
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<?php include"modals/supp_report_modals.php"; ?>
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
        <?=$page_title;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Please Enter Valid Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="report-form" >
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              
              <div class="box-body">
        <div class="form-group">
        <label for="from_date" class="col-sm-2 control-label"><?= $this->lang->line('from_date'); ?></label>
                 
          <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datepicker start_datess " id="from_date" name="from_date" value="<?php echo show_date(date('d-m-Y'));?>">
              
            </div>
            <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
          </div>
          <label for="to_date" class="col-sm-2 control-label"><?= $this->lang->line('to_date'); ?></label>
                   <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datepicker ending_dates" id="to_date" name="to_date" value="<?php echo show_date(date('d-m-Y'))?>">
              
            </div>
            <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
          </div>
        
                </div> 
                <div class="form-group">
          <label for="item_id" class="col-sm-2 control-label"><?= $this->lang->line('item_name'); ?></label>

                  <div class="col-sm-3">
                    <select class="form-control select2 customer_selecting_id " id="item_id" name="item_id">
                        <option value="">কাস্টমার সিলেক্ট করুন </option>
                        <?php foreach ($cutomers_info as $info) { ?>
                            <option value="<?= $info->id; ?>"><?= $info->customer_name; ?> --- <?= $info->address; ?></option>
                        <?php } ?>
                    </select>
                    <span id="item_id_msg" style="display:none" class="text-danger"></span>
                  </div>

                  
                  
                </div>
              </div>
              <!-- /.box-body -->
        
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <div class="col-md-3 col-md-offset-3">
                      <button type="button" id="view" class=" btn btn-block btn-success serching_btn_this " title="Save Data">Show</button>
                   </div>
                   <div class="col-sm-3">
                    <a href="<?=base_url('dashboard');?>">
                      <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                    </a>
                   </div>
                </div>
             </div>
             <!-- /.box-footer -->

             
            </form>
          </div>
          <!-- /.box -->
          
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
         
          <div class="box">
            <div class="box-header">
              <h2 class="box-title cust_pre_amnt " style="font-weight: bold; font-size: 30px; font-style: italic; " >বর্তমান বকেয়া</h2><br>
              <h2 class="box-title cust_name " style="font-weight: bold; font-size: 22px; " >কাস্টমার নাম </h2><br>
              <h2 class="box-title cust_mobile " style="font-weight: bold; font-size: 16px; " >কাস্টমার মোবাইল নং </h2><br>
              <h2 class="box-title cust_address "  >কাস্টমার ঠিকানা </h2>
            </div>
            <!-- /.box-header --> 

            <div class="box-body table-responsive no-padding">
              
              <table class="table table-bordered table-hover " id="report-data" >
                <thead>
                  <tr class="bg-blue">
                    <th >#</th>
                    <th >অপশন</th>
                    <th ><?= $this->lang->line('sales_date'); ?></th>
                    <th >বিস্তারিত</th>
                    <th >আগের বকেয়া</th>
                    <th >বিক্রিত পন্যের দাম</th>
                    <th >খরচ</th>
                    <th >জমা</th>
                    <th >বর্তমান বকেয়া</th>
                    <th ></th>
                  </tr>
                </thead>
                <tbody class="sales_infos_data_assigns  " ></tbody>
              </table>



            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
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
<!-- TABLE EXPORT CODE -->
<?php include"comman/code_js_export.php"; ?>


<script src="<?php echo $theme_link; ?>js/report_customer_history.js"></script>

<!-- <script src="<?php echo $theme_link; ?>js/ajaxselect/item_select_ajax.js"></script>   -->
<script>
   //Item Selection Box Search
   function getItemSelectionId() {
     return '#item_id';
   }
   //Item Selection Box Search - END 

    $(document).ready(function () {
        //Item Selection Box Search
        function getItemSelectionId() {
            return '#item_id';
        }
        //Item Selection Box Search - END

        // Handle toggle button click
        $(document).on("click", '.toggle-details', function () {
            var target = $(this).data("target"); // Get the target id
            $(".collapse-content").not(target).slideUp(); // Hide all other sections
            $(target).slideToggle(); // Toggle the clicked section
        });
    });

</script>




<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>
