<?php
    $CI =& get_instance();
    $CI->load->model('buy_model');
?>

<!DOCTYPE html>
<html>
   <head>
        <base href="<?php echo base_url(); ?>" target=""> 
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
                  <?=$page_title;?>
                  <small></small>  
               </h1>
               <ol class="breadcrumb"> 
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active"><?=$page_title;?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="">
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
                        <div class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;">
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <div class="box-body">
                                <div class="form-group">
                                    <label for="from_date" class="col-sm-2 control-label">তারিখ</label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker searching_input_dates_val " id="from_date" name="from_date" value="<?php echo show_date(date('d-m-Y'));?>" >
                                        </div>
                                        <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                    
                                    <div class="col-md-3 col-md-offset-3">
                                        <button type="button" id="view" class=" btn btn-block btn-success search_amanot_person_datasss " title="Save Data">Show</button>
                                    </div>
                                </div>
                            </div>                              
                        </div>
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
                           <h2 class="box-title " style="position: absolute; font-size: 24px;; top: 50%; left: 50%; transform: translate(-50%, -50%);"><span class="date_assgn" ></span> তারিখের আমানতের তালিকা</h2>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                           <table class="table table-bordered table-hover " id="report-data" >
                              <thead>
                                 <tr class="bg-blue">
                                    <th align="center">#</th>
                                    <th >অপশন</th>
                                    <th >ব্যাক্তি</th>
                                    <th >পূর্বের হিসাব</th>
                                    <th >আজকের হিসাব</th>
                                    <th >মারফত</th>
                                    <th >বর্তমান মোট হিসাব</th> 
                                 </tr>
                              </thead>
                              <tbody id="tbodyid" class="amanots_info_assign_htmls"></tbody>
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
      
      <script src="<?php echo $theme_link; ?>js/sms.js"></script>
      <script src="<?php echo $theme_link; ?>js/report-sales.js"></script>
      <script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js"></script>  
      <script>
         //Customer Selection Box Search
         function getCustomerSelectionId() {
           return '#customer_id';
         }
         //Customer Selection Box Search - END
      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>
