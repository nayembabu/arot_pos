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
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'sales-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                           <input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
                          
                           <div class="box-body">
                              <div class="form-group">
                                 <label for="customer_id" class="col-sm-2 control-label"><?= $this->lang->line('customer_name'); ?><label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                    <div class="input-group">
                                       <select class="form-control select2 customer_uniqs_id" id="customer_id" name="customer_id" style="width: 100%;" >
                                       </select>
                                       <span class="input-group-addon pointer" data-toggle="modal" data-target="#customer-modal" title="New Customer?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                                    </div>
                                    <span id="customer_id_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 <label for="sales_date" class="col-sm-2 control-label"><?= $this->lang->line('sales_date'); ?> <label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                    <div class="input-group date">
                                       <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                       </div>
                                       <input type="text" class="form-control sales_datess pull-right datepicker"  id="sales_date" name="sales_date" readonly value="<?= date('d-m-Y');?>">
                                    </div>
                                    <span id="sales_date_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="sales_status" class="col-sm-2 control-label">বিক্রয়ের ধরণ<label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                       <select class="form-control select2 sales_status_type " id="sales_status" name="sales_status"  style="width: 100%;" >
                                            <option value="1">ডাইরেক্ট</option>
                                            <option value="2">কমিশন</option>
                                       </select> 
                                    <span id="sales_status_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>

                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="box">

                                      <section class="content">
                                        <div class="row">
                                            <div class="col-md-8 " style="margin-bottom: 15px; ">
                                                <label for="sales_date" class="col-sm-2 control-label" style="font-size: 18px;"> ক্রয়ের তারিখ </label>
                                                <div class="col-sm-3 col-md-6 ">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon" style="font-size: 22px;" >
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" style="font-size: 22px;" class="form-control  pull-right datepicker selected_trans_date"  id="sales_date" name="sales_date" readonly value="<?= date('d-m-Y');?>">
                                                    </div>
                                                </div>
                                                <div class="input-group btn btn-primary trans_searching_btn ">খুজুন</div>
                                            </div>
                                          <div class="col-md-12">


                                            <!-- Custom Tabs -->
                                            <div class="nav-tabs-custom nav_assign_ul_data"></div>
                                            
                                            <div>
                                                <div class="tab-content">
                                                  <div class="tab-pane active">
                                                      <div class="row ">
                                                         <div class="col-md-6 col-xs-12 ">
                                                            <div class=" ttl_data_show_rows ">
                                                            </div>
                                                            <div class="pur_item_info_displays"></div>
                                                         </div>
                                                         <div class="col-md-6 col-xs-12 pos_table_addingss ">
                                                            <div class="col-sm-12" style="padding: 0; height: 100%; border: 1px solid rgb(51, 122, 183);"  >
                                                               <table class="table table-condensed table-bordered table-striped table-responsive "  >
                                                                  <thead class="bg-primary">
                                                                     <tr>
                                                                        <th width="19%">আইটেম নাম</th>
                                                                        <th width="17%">পরিমাণ</th>
                                                                        <th width="17%">কেজি</th>
                                                                        <th width="17%">দাম</th>
                                                                        <th width="25%">মোট</th>
                                                                        <th width="5%"><i class="fa fa-close"></i></th>
                                                                     </tr>
                                                                  </thead>
                                                                  <tbody class=" pos_item_adding_tbl " id="pos-form-tbody" style="font-size: 16px; font-weight: bold; ">
                                                                  </tbody>
                                                                  <tfoot>
                                                                     <tr>
                                                                        <td colspan="6" align="center">
                                                                           <div class="btn btn-info btn-xs btn-block check_all_item_calc " style="font-size: 14px; " >হিসাব চেক</div>
                                                                        </td>
                                                                     </tr>
                                                                  </tfoot>
                                                               </table>
                                                            </div>
                                                            <div class="col-sm-12 sales_item_calc_assigns  " ></div>
                                                            
                                                         </div>
                                                      </div>
                                                      <!-- /.row -->
                                                  </div>
                                                  <!-- /.tab-pane -->
                                                  
                                                  
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                            <!-- nav-tabs-custom -->
                                            
                                          </div>
                                          <!-- /.col -->
                                      </div>
                                      <!-- /.row -->
                                    </section>

                                       <div class="submit_btn_selling_sys" style="text-align: center; margin: 50px 0 20px 0; " ></div>

                                    </div>

                                 </div>
                              </div>

                           <?= form_close(); ?>
                           <!-- OK END -->
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

      <script src="<?php echo $theme_link; ?>js/sales.js"></script>  
      <script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js"></script>  


      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html> 
