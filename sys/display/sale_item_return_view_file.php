<!DOCTYPE html>
<html>

<head> 
  <base href="<?php echo base_url(); ?>">
      <!-- FORM CSS CODE -->
   <?php include"comman/code_css_form.php"; ?>
   
   <style type="text/css">
      table.table-bordered > thead > tr > th {
      /* border:1px solid black;*/ 
      text-align: center;
      }
      .table > tbody > tr > td, 
      .table > tbody > tr > th, 
      .table > tfoot > tr > td, 
      .table > tfoot > tr > th, 
      .table > thead > tr > td, 
      .table > thead > tr > th 
      {
      padding-left: 2px;
      padding-right: 2px;  

      }
   </style>
</head>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 
 
 <?php include"sidebar.php"; ?>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- **********************MODALS***************** -->
    <?php include"modals/modal_customer.php"; ?>
    <?php include"modals/modal_pos_sales_item.php"; ?>
    <!-- **********************MODALS END***************** -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
         <h1>
            <?=$page_title;?>
            <small>বিক্রয়</small>
         </h1>
         <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a >বিক্রয়</a></li>
            <li class="active"><?=$page_title;?></li>
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
                     <div class="box box-info " >
                        <!-- style="background: #68deac;" -->
                        
                        <!-- form start -->
                         <!-- OK START -->
                          
                           <div class="box-body">
                              
                              <div class="row">

                                 <div class="col-md-6">
                                    <div class="box">
                                       <div class="input-group input-group-lg">
                                          <span class="input-group-addon" id="sizing-addon1">তারিখ হইতে</span>
                                          <input type="text" class="form-control datepicker date_starts_from " placeholder="তারিখ হইতে" aria-describedby="sizing-addon1">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="box">
                                       <div class="input-group input-group-lg">
                                          <span class="input-group-addon" id="sizing-addon1">তারিখ পর্যন্ত</span>
                                          <input type="text" class="form-control datepicker date_ends_to " placeholder="তারিখ পর্যন্ত" aria-describedby="sizing-addon1" >
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <div class="col-md-6">
                                    <div class="box">
                                       <div class="input-group input-group-lg">
                                          <span class="input-group-addon" id="sizing-addon1">কাস্টমার</span>
                                          <select class="form-control customer_unq_idds select2 " >
                                             <option value="">কাস্টমার সিলেক্ট করুন</option>
                                             <?php foreach ($cutomers_info as $cust) { 
                                                if ($cust->id != 1) {?>
                                                <option value="<?php echo $cust->id; ?>"><?php echo $cust->customer_name; ?> --- <?php echo $cust->address; ?></option>
                                             <?php } } ?>
                                          </select>
                                       </div>
                                    </div>
                                    <input type="text" value="<?php echo uniqid(); ?>" class="php_uniq_id_check" style="display: none;" >
                                 </div>
                                 <div class="col-md-6 mx-auto ">
                                    <center>
                                       <div class="input-group input-group-lg">
                                          <div class="btn btn-primary btn-lg search_details_btns ">খুজুন</div>
                                       </div>
                                    </center>
                                 </div>

                              </div>

                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="box">

                                      <section class="content">
                                          <div class="row">
                                             <div class="col-md-12">

                                                <!-- Custom Tabs -->
                                                <div class="nav-tabs-custom nav_assign_ul_data"></div>

                                                <div class="tab-content">
                                                   <div class="tab-pane active">
                                                      <div class="row ">
                                                         <div class="col-md-6 col-xs-12 ">
                                                            <div class=" ttl_data_show_rows "></div>
                                                         </div>
                                                         <div class="col-md-6 col-xs-12 ">
                                                            <div class="sales_item_info_displays"></div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>

                                             </div>
                                             <!-- /.col -->
                                          </div>
                                          <!-- /.row -->
                                       </section>

                                       <div class="submit_btn_selling_sys" style="text-align: center; margin: 50px 0 20px 0; " ></div>

                                    </div>

                                 </div>
                              </div>
                           </div>

                     </div>
                  </div>
                  <!-- /.box-footer -->

               </div>
               <!-- /.box -->
             </section>
            <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <?php include"footer.php"; ?>
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js_form.php"; ?>

<script src="<?php echo $theme_link; ?>js/modals.js"></script>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
   <script src="<?php echo $theme_link; ?>js/sales_return_cust.js"></script>  
   <!-- Make sidebar menu hughlighter/selector -->
   <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html> 
