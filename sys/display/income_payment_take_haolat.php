<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo base_url(); ?>" target="">
    <!-- TABLES CSS CODE -->
    <?php include"comman/code_css_form.php"; ?>
    <!-- </copy> -->  
    <style>
        body.loan-page-body {
            background-color: #f4f7fc;
            font-family: Arial, sans-serif;
        }
        .loan-wrapper {
            margin-top: 20px;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .loan-header-section {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 22px;
            border-radius: 12px 12px 0 0;
        }
        .loan-input-field {
            border-radius: 8px;
            padding: 14px;
            border: 1px solid #ccc;
            width: 100%;
            font-size: 16px;
        }
        .loan-textarea {
            height: 120px;
            resize: none;
        }
        .loan-submit-button {
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            padding: 14px;
            font-size: 18px;
            width: 100%;
            border: none;
            cursor: pointer;
        }
        .loan-submit-button:hover {
            background-color: #218838;
        }
        .select2-container--default .select2-selection--single {
            height: 48px;
            padding: 10px;
            font-size: 16px;
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
        ইনকাম
        <small>Add/Update income</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ইনকাম</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

                    <div id="response-message"></div>
        <div class="loan-page-body">
            <div class="container loan-wrapper">
                <div class="loan-header-section">
                    <h3>মহাজন থেকে টাকা লোণ</h3>
                </div>
                <div class="panel-body">
                    <div class="loan-form" >
                        <div class="form-group">
                            <label>মহাজন নির্বাচন করুন</label>
                            <select class="loan-input-field select2 customer-selection supp_name_id" name="customer_id" required>
                                <option value="">মহাজন নির্বাচন করুন</option>
                                <?php foreach ($sups as $sup) { ?>
                                    <option value="<?php echo $sup->id; ?>"><?php echo $sup->supplier_name; ?> --- <?php echo $sup->address; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>লোণ পরিমাণ</label>
                            <input type="text" inputmode="numeric" class="loan-input-field loan-amount amnt_loan_s " name="loan_amount" placeholder="টাকার পরিমাণ লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label>লোণের মাধ্যম</label>
                            <textarea class="loan-input-field loan-method loan_perposesss" name="loan_medium" placeholder="লোণের মাধ্যম লিখুন" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>লোণের তারিখ</label>
                            <input type="text" class="datepicker loan-input-field repayment-date dates_of_loans" name="repayment_date" required value="<?php echo date('d-m-Y'); ?>">
                        </div>
                        <div class="form-group">
                            <label>অটো টাইম</label>
                            <input type="text" class="loan-input-field auto-time times_of_fulls" id="auto_time" name="auto_time" readonly>
                        </div>
                        <button class="loan-submit-button">সেভ করুন</button>
                    </div>
                </div>
            </div>
        </div>

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

<script src="<?php echo $theme_link; ?>js/loan.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
