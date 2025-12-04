<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo base_url(); ?>" target="">
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
 <style>


    .font20 { 
      font-size: 20px; 
    }

    .navss {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: white;
        font-family: 'Arial', sans-serif;
    }
    .navpanel {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        padding: 20px;
    }
    .navpanel-heading {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        background: rgba(255, 255, 255, 0.2);
        padding: 10px;
        border-radius: 10px;
    }
    .custom-tab {
        background: rgba(255, 255, 255, 0.2);
        padding: 12px;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
        transition: all 0.3s ease;
        text-align: center;
    }
    .custom-tab a {
        text-decoration: none;
        color: white;
        display: block;
        padding: 10px 20px;
        border-radius: 5px;
    }
    .custom-tab:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.20);
    }

    .select2-container .select2-selection--single {
        height: 50px !important;
        font-size: 18px !important;
        padding: 10px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 50px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px !important;
    }





    
        .commission_datas_body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .panel {
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }
        .panel-heading {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            padding: 15px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .form-group label {
            font-weight: bold;
            color: #495057;
            margin: 0; 
        }
        .form-control {
            border-radius: 5px;
            box-shadow: inset 0px 3px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ced4da;
            padding: 5px; 
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }
        .btn-primary {
            padding: 12px 30px;
        }
        .btn-success {
            padding: 12px 30px;
            font-size: 35px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }
        .btn-success:hover {
            transform: translateY(-10px);
        }
        .btn-primary, .btn-danger {
            border-radius: 30px;
            font-size: 16px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }
        .btn-primary:hover, .btn-danger:hover {
            transform: translateY(-2px);
        }
        .income-entry {
            /* display: none;  */
        }
        .main_form_count {
            border: 2px solid #e0e0e0; /* সফট গ্রে কালার */
            border-radius: 12px; /* গোলাকার কর্নার */
            padding: 15px;
            background: #fff;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); /* সফট শ্যাডো */
            transition: all 0.3s ease-in-out;
        }
        .remove-entry { 
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #ff4b5c, #d72638);
            color: white;
            box-shadow: 0px 3px 8px rgba(255, 0, 0, 0.3);
            transition: all 0.3s ease-in-out;
        } 
        /* "আরো যোগ করুন" বাটন */
        .add-btn {
            margin-top: 25px;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            color: white;
            box-shadow: 0px 4px 10px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease-in-out;
        }
        .delete-btn-container {
            display: flex;
            justify-content: center; /* হরিজন্টাল সেন্টার */
            align-items: center; /* ভের্টিক্যাল সেন্টার */
            height: 100%; /* পুরো কলামের উচ্চতা */
        }


        .product-card {
            border: none;
            border-radius: 15px; 
            text-align: center;
            background: rgba(255, 255, 255, 0.8);
            width: 200px;
            position: relative;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease-in-out;
            overflow: hidden;
        }
        .product-card:hover {
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-7px);
        }
        .product-card .qty-badge {
            position: absolute;
            top: 8px;
            left: 12px;
            background-color: #ff3b3b;
            color: white;
            padding: 7px 14px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 20px;
        }
        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            transition: transform 0.3s ease-in-out;
        }
        .product-card .product-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-top: 15px;
        }
        .product-card .price {
            font-size: 24px;
            font-weight: bold;
            color: #ff3b3b;
            margin-top: 5px;
        }
        .product-card .info {
            font-size: 14px;
            color: #555;
            margin-top: 8px;
            line-height: 1.6;
        }
        .product-card .decorative-line {
            width: 50px;
            height: 3px;
            background: #ff3b3b;
            margin: 10px auto;
            border-radius: 2px;
        }
        

        
        .salescontainer {
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .sales-summary {
            max-width: 500px;
            padding: 8px;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease-in-out;
        }
        .sales-summary-h2 {
            margin-bottom: 2px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ffeb3b;
        }


        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .custom-table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            background: white;
        }
        .custom-table th, .custom-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .custom-table thead {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        .custom-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .custom-table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .modal_panel {
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
        .modal_panel-footer {
            font-size: 18px;
            background: #007bff;
            color: white;
            padding: 15px;
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .expense-table {
            background: #fdfdfd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.15);
        }
        .expense-table h4 {
            color: #d9534f;
            font-weight: bold;
        }
        .expense-table p {
            font-size: 16px;
            margin: 5px 0;
        }

  </style>
</head>  

<body class="hold-transition skin-blue sidebar-mini"> 
<div class="wrapper">
 
 <?php include"sidebar.php"; ?> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title; ?>
        <small>কমিশন হিসাব</small>
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
              <h3 class="box-title">
                তথ্য পূরণ করুন। 
              </h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            
            
                <div class="box-header">
                    <div class="col-md-7">
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" id="sizing-addon1">পণ্য </span>
                            <select class="form-control select2 cust_select_unq_idds " >
                                <option value="">কাস্টমার সিলেক্ট করুন</option>
                                <?php foreach ($customer_info as $customer) { if ($customer->id != 1) { ?>
                                    <option value="<?php echo $customer->id; ?>"><?php echo $customer->customer_name; ?> --- <?php echo $customer->address; ?></option>
                                <?php } } ?>
                            </select>  
                        </div>
                    </div>
                    <div class="col-md-5 supp_datas_info_assignss "></div>
                </div>


                <section class="content">
                  <div class="box-header row container-fluid "> 
                    <div class="col-md-12 ">
                      <div class="lot_info_assign_nav"></div>
                    </div>

                    <div class="col-md-12 sales_item_show_div " style=""></div>
                    <div class="col-md-12 sales_items_click_infosss " style=""></div>
                    <div class="col-md-12 all_data_infos_cal_assign " style=""></div>

                  </div>
                </section>

                <br><br><br><br><br><br><br><br><br><br><br>

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
<!-- MODAL CODE -->
<?php include"modals/modal_sales_commission_submit.php"; ?>

<script src="<?php echo $theme_link; ?>js/sales_commission_js.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>



 
</body>
</html>
 