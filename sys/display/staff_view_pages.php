<!DOCTYPE html>
<html>

    <head>
        <base href="<?php echo base_url(); ?>" target="">
        <!-- TABLES CSS CODE -->
        <?php include"comman/code_css_form.php"; ?>
            <style>
                body {
                    font-family: 'Poppins', Arial, sans-serif;
                    background: linear-gradient(to bottom, #f7f9fc, #e3f2fd);
                }
                .header {
                    background: linear-gradient(to right, #00796b, #009688);
                    color: #ffffff;
                    padding: 20px;
                    border-radius: 8px;
                    text-align: center;
                    margin-bottom: 20px;
                }
                .header h4 {
                    margin: 0;
                    font-size: 24px;
                    font-weight: bold;
                }
                .header p {
                    margin: 5px 0 0;
                }
                .form-section {
                    background-color: #ffffff;
                    padding: 25px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    margin-bottom: 20px;
                }
                .form-section label {
                    font-weight: bold;
                }
                .form-section button {
                    margin-top: 15px;
                    border-radius: 20px;
                    transition: 0.3s ease-in-out;
                }
                .btn-save {
                    background: linear-gradient(to right, #4caf50, #66bb6a);
                    color: #fff;
                }
                .btn-save:hover {
                    background: #388e3c;
                }
                .btn-close {
                    background: linear-gradient(to right, #ff9800, #ffb74d);
                    color: #fff;
                }
                .btn-close:hover {
                    background: #f57c00;
                }
                .table-container {
                    background-color: #ffffff;
                    padding: 25px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .table-container h4 {
                    font-weight: bold;
                    margin-bottom: 20px;
                    color: #00796b;
                }
                .table {
                    margin: 0 auto;
                    width: 100%;
                    border-collapse: collapse;
                }
                .table thead th {
                    background: linear-gradient(to right, #00796b, #009688);
                    color: #ffffff;
                    text-align: center;
                }
                .table tbody tr:hover {
                    background-color: #e0f2f1;
                    cursor: pointer;
                }
                .table tbody td {
                    text-align: center;
                }
            </style>



    <!-- </copy> -->  
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

        <?php include"sidebar.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- **********************MODALS***************** -->
            <?php include"modals/modal_amanot.php"; ?>
            <!-- **********************MODALS END***************** -->

            <!-- Content Header (Page header) -->
            <section class="content-header">
            <h1>
                <?= $page_title; ?>
                <small>Add Records</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
            </section>
                <!-- Form Section -->
                <div class="form-section staff_add_form">
                    <h4 class="header">নতুন স্টাফ যোগ করুন</h4>
                    
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label for="customer-name">স্টাফের নাম <span class="text-danger">*</span></label>
                                <input type="text" class="form-control staff_names" id="customer-name" placeholder="কাস্টমার নাম">
                            </div>
                            <div class="form-group">
                                <label for="account-type">স্টাফের মোবাইল</label>
                                <input type="text" class="form-control staff_mobiles" id="account-type" placeholder="মোবাইল">
                            </div>
                            <div class="form-group">
                                <label for="address">স্টাফের ঠিকানা</label>
                                <textarea class="form-control staff_address " id="address" rows="3" placeholder="ঠিকানা"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-save btn-lg staff_saves_btn ">সেইভ করুন</button> 
                    </div>
                    
                </div>

                <!-- Table Section -->
                <div class="table-container text-center">
                    <h4>স্টাফের তালিকা</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>সিরিয়াল নং</th>
                                <th>স্টাফের নাম</th>
                                <th>স্টাফের মোবাইল</th>
                                <th>স্টাফের ঠিকানা</th>
                                <th>এডিট</th>
                            </tr>
                        </thead>
                        <tbody class="display_all_staff_datas " ></tbody>
                    </table>
                </div>
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

        <script src="<?php echo $theme_link; ?>js/payment.js"></script>

        <script>
            
        get_all_staff_inofsss();
        $(function(){
            $("#accordion").accordion();
        });

        $(document).on('click', '.edit_the_staf_info', function () {
            let edit_id = $(this).attr("edit_id");
            $.ajax({
                type: "post",
                url: "payment_types/get_all_staff_info_by_id",
                data: {
                    edit_id: edit_id
                },
                dataType: "json",
                success: function (res) {
                    $('.staff_add_form').html(`
                        <h4 class="header">স্টাফ তথ্য আপডেট করুন</h4>
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label for="customer-name">স্টাফের নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control staff_names" id="customer-name" placeholder="কাস্টমার নাম" value="${res.staff_namess}">
                                </div>
                                <div class="form-group">
                                    <label for="account-type">স্টাফের মোবাইল</label>
                                    <input type="text" class="form-control staff_mobiles" id="account-type" placeholder="মোবাইল" value="${res.staff_mobiless}">
                                </div>
                                <div class="form-group">
                                    <label for="address">স্টাফের ঠিকানা</label>
                                    <textarea class="form-control staff_address " id="address" rows="3" placeholder="ঠিকানা" > ${res.staff_addrss} </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-save btn-lg update_staff_save_btn " edit_id="${res.db_staff_info_id}" >আপডেট করুন</button> 
                        </div>
                    `);
                }
            });
        });

        $(document).on('click', '.update_staff_save_btn', function () {
            if ($('.staff_names').val() == "") {
                toastr["warning"]("স্টাফের নাম দিন!", "Warning!");
                $('.staff_names').focus();
                return;
            }else {
                $.ajax({
                    type: "post",
                    url: "payment_types/update_staff_info",
                    data: {
                        staff_name: $('.staff_names').val(),
                        staff_mobile: $('.staff_mobiles').val(),
                        staff_address: $('.staff_address').val(),
                        edit_id: $(this).attr('edit_id')
                    },
                    success: function (res) {
                            toastr["success"]("স্টাফ তথ্য সফলভাবে আপডেট হয়েছে!", "Success!");
                            get_all_staff_inofsss();
                            // Reset form
                            $('.staff_add_form').html(`
                                <h4 class="header">নতুন স্টাফ যোগ করুন</h4>                            
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="customer-name">স্টাফের নাম <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control staff_names" id="customer-name" placeholder="কাস্টমার নাম">
                                        </div>
                                        <div class="form-group">
                                            <label for="account-type">স্টাফের মোবাইল</label>
                                            <input type="text" class="form-control staff_mobiles" id="account-type" placeholder="মোবাইল">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">স্টাফের ঠিকানা</label>
                                            <textarea class="form-control staff_address " id="address" rows="3" placeholder="ঠিকানা"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-save btn-lg staff_saves_btn ">সেইভ করুন</button> 
                                </div>
                            `);
                    }
                });
            }

        });
        </script>

        <!-- Make sidebar menu hughlighter/selector -->
        <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    </body>
</html>

