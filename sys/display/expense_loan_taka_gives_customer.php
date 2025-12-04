<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo base_url(); ?>" target="">
    <!-- TABLES CSS CODE -->
    <?php include"comman/code_css_form.php"; ?>
    <!-- </copy> -->  
    <style>
        .container {
            max-width: 450px;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.5);
            margin-top: 60px;
            transition: all 0.3s ease-in-out;
        }
        .container:hover {
            box-shadow: 0px 12px 30px rgba(0, 0, 0, 0.7);
        }
        h2 {
            background: #d32f2f;
            color: #ffffff;
            padding: 14px;
            border-radius: 8px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .form-group label {
            font-weight: 600;
            font-size: 16px;
            color: #f5f5f5;
        }
        .form-control {
            border-radius: 8px;
            background: #2e2e2e;
            color: #ffffff;
            border: 1px solid #444;
            padding: 20px;
            font-size: 22px;
        }
        .form-control::placeholder {
            color: #bdbdbd;
        }
        .btn-custom {
            background: linear-gradient(to right, #d32f2f, #b71c1c);
            color: white;
            font-size: 18px;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-custom:hover {
            background: linear-gradient(to right, #b71c1c, #9a0007);
        }
        .select2-container--default .select2-selection--single {
            height: 48px;
            padding: 10px;
            font-size: 20px;
            background:rgb(11, 11, 11);
            color: #ffffff;
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
            খরচ
            <small>Add/Update income</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">ইনকাম</li>
        </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="loan-page-body">

                <div class="container">
                    <div id="response-message"></div>
                    <h2><?= $page_title; ?></h2>
                    <div>
                        <div class="form-group">
                            <label for="mahajan">কাস্টমার নির্বাচন করুন:</label>
                            <select class="form-control select2 customer_iddii_uniqs " id="mahajan" required>
                                <option value="">কাস্টমার নির্বাচন করুন</option>
                                <?php foreach ($cus_s as $cus) { 
                                    if($cus->id == 1) continue;    
                                ?>
                                    <option value="<?= $cus->id; ?>"><?= $cus->customer_name; ?> --- <?= $cus->address; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">লোণের পরিমাণ:</label>
                            <input type="text" class="form-control form-control-lg give_amount_taka " id="amount" placeholder="টাকার পরিমাণ লিখুন" inputmode="numeric" required>
                        </div>
                        <div class="form-group">
                            <label for="method">লোণের মাধ্যম:</label>
                            <textarea class="form-control perpose_of_loans " id="method" rows="3" placeholder="লোণের মাধ্যম লিখুন" required></textarea> 
                        </div>
                        <div class="form-group">
                            <label for="date">লোণের তারিখ:</label>
                            <input type="text" class="form-control datepicker loan_date_provide " id="date" required value="<?= date('d-m-Y'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="time">অটো টাইম:</label>
                            <input type="text" class="form-control loan_timming_provides " id="auto_time" >
                        </div>
                        <button type="submit" class="btn btn-custom saving_cust_provide_loan_btn ">সেভ করুন</button>
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
