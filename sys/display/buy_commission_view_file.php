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
            .nav-tabs {
                border-bottom: 3px solid #34495e;
                display: flex;
                justify-content: center;
                background: linear-gradient(to right, #2c3e50, #34495e);
                padding: 10px;
                border-radius: 10px 10px 0 0;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }
            .nav-tabs > li {
                margin: 0 5px;
                border: 0.5px solid rgb(255, 255, 255);
                border-radius: 5px 5px 0 0;
            }
            .nav-tabslia {
                background-color: transparent;
                color: white;
                border-radius: 5px 5px 0 0;
                padding: 12px 20px;
                font-size: 16px;
                transition: all 0.3s ease-in-out;
                position: relative;
                overflow: hidden;
            }
            .nav-tabs > li > a::before {
                content: "";
                position: absolute;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.2);
                top: 0;
                left: -100%;
                transition: left 0.3s ease-in-out;
            }
            .nav-tabs > li > a:hover::before {
                left: 0;
            }
            .nav-tabs > li > a:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            }
            .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
                background: linear-gradient(to right,rgb(1, 2, 4),rgb(0, 21, 41));
                color: white;
                font-weight: bold;
                box-shadow: 0 6px 6px rgba(255, 255, 255, 0.99);
                border-radius: 5px 5px 0 0;
            }
            .tab-content {
                background: linear-gradient(to right, #ecf0f1,rgb(158, 174, 184));
                padding: 5px 0 10px 14px;
                border: 1px solid #ddd;
                border-top: none;
                border-radius: 0 0 10px 10px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                animation: fadeIn 0.5s ease-in-out;
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
            .sscontainer-box {
                background: #fff;
                padding: 30px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .sspanel-heading {
                background: linear-gradient(45deg,rgb(3, 3, 66),rgb(50, 5, 7)) !important;
                color: white !important;
                text-align: center;
                border-radius: 15px 15px 0 0;
                font-size: 25px;
                padding: 20px;
            }
            .ssdelete-btn {
                background: red;
                border: none;
                color: white;
                font-size: 18px;
                border-radius: 50%;
                width: 40px;
                height: 40px;
            }
            .add-btn {
                padding: 20px 25px;
                border-radius: 15px;
                border: none;
                color: white;
                font-weight: bold;
                background: linear-gradient(45deg,rgba(2, 73, 136, 0.76),rgb(2, 22, 23));
                box-shadow: 0px 4px 10px rgba(40, 167, 69, 0.3);
                transition: all 0.3s ease-in-out;
            }
            .text-center {
                text-align: center;
            }
            .expense-panel {
                max-width: 650px;
                border-radius: 12px;
                box-shadow: 0px 5px 12px rgba(0, 0, 0, 0.15);
                background-color: #ffffff;
            }
            .expense-heading {
                background: linear-gradient(45deg,rgb(3, 3, 66),rgb(50, 5, 7)) !important;
                color: white;
                border-radius: 12px 12px 0 0;
                text-align: center;
                padding: 18px;
                font-size: 22px;
                font-weight: bold;
            }
            .form-group label {
                font-weight: bold;
                color: #333;
            }
            .form-control {
                border-radius: 6px;
                border: 1px solid #ccc;
            }
            .btn_xl {
                font-size: 30px;
                padding: 15px 30px;
                border-radius: 50px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
                transition: all 0.3s ease-in-out;
            }
            .btn_xl:hover {
                transform: scale(1.1);
                box-shadow: 0 15px 25px rgba(0, 0, 0, 0.4);
            }
            .select2-container .select2-selection--single {
                height: 50px !important; /* বক্সের উচ্চতা বড় করা */
                font-size: 18px !important; /* ফন্ট সাইজ বড় করা */
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                font-size: 18px !important; /* অপশন টেক্সটের সাইজ */
                line-height: 50px !important; /* লাইন হাইট সেট করা */
            }
            .select2-dropdown .select2-results__option {
                font-size: 18px !important; /* ড্রপডাউন অপশন টেক্সট বড় করা */
                padding: 10px !important; /* প্যাডিং অ্যাড করা */
            }
            .custom-modal .modal-content {
                border-radius: 12px;
                box-shadow: 0px 4px 15px rgba(0,0,0,0.3);
                background: linear-gradient(to right, #ffffff, #f8f9fa);
            }
            .custom-modal .modal-header {
                background-color: #007bff;
                color: white;
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
                text-align: center;
                font-size: 18px;
                font-weight: bold;
            }
            .custom-modal .modal-footer {
                background-color: #f9f9f9;
                border-bottom-left-radius: 12px;
                border-bottom-right-radius: 12px;
            }
            .custom-table th, .custom-table td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: center;
                font-size: 16px;
            }
            .custom-table th {
                background-color: #007bff;
                color: white;
            }
            .total-row {
                font-weight: bold;
                background-color: #e3f2fd;
            }
            .expense-box {
                background: #fff;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                margin-top: 20px;
                text-align: center;
            }
            .expense-box h4 {
                color: #d9534f;
                font-weight: bold;
                border-bottom: 2px solid #d9534f;
                display: inline-block;
                padding-bottom: 5px;
            }
            .expense-item {
                font-size: 16px;
                padding: 8px 0;
                font-weight: bold;
                text-align: left;
            }
            .expense-total {
                font-weight: bold;
                font-size: 18px;
                border-top: 2px solid #ddd;
                padding-top: 10px;
            }
            .costs-total {
                font-size: 24px;
                font-weight: bold;
                color:rgb(95, 11, 11);
                margin-top: 10px;
                border-top: 3px solid rgb(95, 11, 11);
                padding-top: 10px;
            }
            .net-total {
                font-size: 30px;
                font-weight: bold;
                color: #28a745;
                margin-top: 20px;
                border-top: 3px solid #28a745;
                padding-top: 15px;
            }
            #total-sale {
                text-align: right;
            }
            #final-sale {
                text-align: right;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
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
                        ক্রয় কমিশন
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
                                            <span class="input-group-addon" id="sizing-addon1">মহাজন সিলেক্ট করুন </span>
                                            <select class="form-control supp_select_unq_idds select2 " >
                                                <option value="">মহাজন সিলেক্ট করুন</option>
                                                <?php foreach ($suppliers as $supp) { ?>
                                                    <option value="<?php echo $supp->id; ?>"><?php echo $supp->supplier_name; ?> --- <?php echo $supp->address; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <section class="content">
                                    <div class="box-header row container-fluid ">
                                        <div class="col-md-12 ">
                                            <div class="lot_info_assign_nav"> </div>
                                        </div>

                                        <div class="col-md-12 assign_item_lot_s"></div>

                                        <div class="container sales_infos_assign_ing_cls " style="display: none;">
                                            <div class="row" style="margin-top: 20px;">
                                                <div class="col-md-6">
                                                    <div class="panel panel-primary" style="border-radius: 15px; padding: 0 0 20px 0;">
                                                        <div class="sspanel-heading">বিক্রয় তথ্য</div>
                                                        <div class="panel-body append_contain_boxs"></div>
                                                        <div class="text-center add_contain_boxx">
                                                            <button type="button" class="btn btn-primary add-btn">আরো যোগ করুন</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="panel panel-primary expense-panel">
                                                        <div class="panel-heading expense-heading  ">খরচের তথ্য</div>
                                                        <div class="panel-body cost_infos_assignsssss_s"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container text-center btn_center ">
                                                <button class="btn btn-primary btn_xl commission_checking_ss_btn " data-toggle="modal" data-target="#buy_commission_checking_modals" >চেক</button>
                                            </div>
                                        </div>

                                    </div>

                                </section>
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
        <?php include"modals/buy_commission_check_modals.php"; ?>

        <script src="<?php echo $theme_link; ?>js/purchase_commission.js"></script>
        <!-- Make sidebar menu hughlighter/selector -->
        <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>


        <script>

            $(document).ready(function () {
                // Define step details
                const stepCount = 5;
                const stepTitles = [
                    "Personal Information",
                    "Contact Details",
                    "Account Details",
                    "Security Information",
                    "Confirmation"
                ];

                // Generate tabs and content dynamically using loop
                for (let i = 0; i < stepCount; i++) {
                    const stepId = `step${i + 1}`;
                    const isActive = i === 0 ? "active" : "disabled";
                    const isFade = i === 0 ? "in active" : "fade";

                    // Tabs
                    $('#dynamic-tabs').append(`
                        <li class="${isActive}">
                            <a data-toggle="tab" href="#${stepId}">Step ${i + 1}</a>
                        </li>
                    `);

                    // Content
                    $('#dynamic-content').append(`
                        <div id="${stepId}" class="tab-pane ${isFade}">
                            <h3>${stepTitles[i]}</h3>
                            <form>
                                <div class="form-group">
                                    <label for="field-${stepId}">Enter some data:</label>
                                    <input type="text" class="form-control" id="field-${stepId}" placeholder="Enter details">
                                </div>
                                <div class="btn-group btn-block">
                                    ${i > 0 ? `<button type="button" class="btn btn-default" data-prev="step${i}">Back</button>` : ''}
                                    ${i < stepCount - 1 ? `<button type="button" class="btn btn-primary" data-next="step${i + 2}">Next</button>` : `<button type="submit" class="btn btn-success">Submit</button>`}
                                </div>
                            </form>
                        </div>
                    `);
                }

                // Handle Next button clicks
                $(document).on('click', '.btn-primary', function () {
                    const nextStepId = $(this).data('next');

                    // Activate next tab and content
                    const $nextTab = $(`a[href="#${nextStepId}"]`);
                    $nextTab.parent().removeClass('disabled').addClass('active');
                    $(`#${nextStepId}`).addClass('fade in active');

                    // Deactivate current tab
                    const $currentTab = $(this).closest('.tab-pane');
                    $currentTab.removeClass('in active');
                    const $currentNav = $(`a[href="#${$currentTab.attr('id')}"]`).parent();
                    $currentNav.removeClass('active').addClass('disabled');
                });

                // Handle Back button clicks
                $(document).on('click', '.btn-default', function () {
                    const prevStepId = $(this).data('prev');

                    // Activate previous tab and content
                    const $prevTab = $(`a[href="#${prevStepId}"]`);
                    $prevTab.parent().removeClass('disabled').addClass('active');
                    $(`#${prevStepId}`).addClass('fade in active');

                    // Deactivate current tab
                    const $currentTab = $(this).closest('.tab-pane');
                    $currentTab.removeClass('in active');
                    const $currentNav = $(`a[href="#${$currentTab.attr('id')}"]`).parent();
                    $currentNav.removeClass('active').addClass('disabled');
                });
            });
        </script>

    </body>
</html>
