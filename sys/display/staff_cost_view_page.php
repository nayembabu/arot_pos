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
                
                .table-staff-cost thead th {
                    background: linear-gradient(to right,#28a745,#39c7b6,#2196f3) !important;
                    color: #fff !important;
                    border-bottom: 2px solid #18b2c4;
                    font-weight: bold;
                    font-size: 18px !important;
                }

                .table-staff-cost tbody tr {
                    font-size: 17px;
                    background: #e3f9f7;
                    transition: background 0.2s;
                }
                .table-staff-cost tbody tr:nth-child(odd) {
                    background: #daf2ff;
                }
                .table-staff-cost tbody tr:hover {
                    background: #c4f0c5 !important;
                }

                .table-staff-cost td, .table-staff-cost th {
                    vertical-align: middle !important;
                }

                .btn-big-action {
                    font-size: 18px !important;
                    padding: 10px 24px !important;
                    border-radius: 8px !important;
                    min-width: 44px;
                }
                .btn-danger.btn-big-action {
                    background: linear-gradient(to right,#ef5350,#ffd54f) !important;
                    color: #fff !important;
                    border: none;
                }
                .btn-danger.btn-big-action:hover {
                    background: #d32f2f !important;
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


                    
                <!-- Collapsible Staff Cost Form Section -->
                <div class="form-section mb-4">
                    <button class="btn btn-save btn-lg " type="button" data-toggle="collapse" data-target="#staffCostFormCollapse" aria-expanded="false" aria-controls="staffCostFormCollapse" id="addNewCostBtn" style="margin-bottom:20px; font-size:20px; padding: 16px 15px;">
                        <i class="fa fa-plus-circle"></i> খরচ যোগ করুন
                    </button>
                    <div class="collapse" id="staffCostFormCollapse">
                        <form id="staffCostForm" autocomplete="off">
                            <div class="form-group">
                                <label for="staff_name">স্টাফের নাম <span style="color:red">*</span></label>
                                <select class="form-control input-lg" id="staff_name" name="staff_name" required style="font-size:18px;">
                                    <option value="">স্টাফের নাম নির্বাচন করুন</option>
                                    <?php foreach($all_staff_infos as $staff_info): ?>
                                        <option value="<?php echo $staff_info->db_staff_info_id; ?>"><?php echo $staff_info->staff_namess; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cost_amount">খরচের পরিমাণ (Amount) <span style="color:red">*</span></label>
                                <input type="number" class="form-control input-lg" id="cost_amount" name="cost_amount" required placeholder="পরিমাণ লিখুন" style="font-size:18px;">
                            </div>
                            <div class="form-group">
                                <label for="cost_date">তারিখ <span style="color:red">*</span></label>
                                <input type="text" class="form-control input-lg datepicker" id="cost_date" name="cost_date" required style="font-size:18px;" value="<?php echo date('d-m-Y'); ?>" autocomplete="off" placeholder="তারিখ নির্বাচন করুন">
                            </div>
                            <div class="form-group">
                                <label for="cost_note">খরচের নোট</label>
                                <input type="text" class="form-control input-lg" id="cost_note" name="cost_note" placeholder="বর্ণনা (ঐচ্ছিক)" style="font-size:18px;">
                            </div>
                            <button type="submit" class="btn btn-save btn-lg btn-block" style="font-size:20px; padding: 14px 0; margin-bottom: 10px;">
                                <i class="fa fa-save"></i> সংরক্ষণ করুন
                            </button>
                            <button type="button" class="btn btn-close btn-lg btn-block" data-toggle="collapse" data-target="#staffCostFormCollapse" aria-expanded="true" aria-controls="staffCostFormCollapse" style="font-size:20px; padding: 14px 0;">
                                <i class="fa fa-times"></i> বন্ধ করুন
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Table of Staff Costs -->
                <div class="table-container">
                    <h4>স্টাফ খরচের তালিকা (Staff Cost List)</h4>
                    <table class="table table-bordered table-striped table-staff-cost" id="staff-cost-table" style="background: #fafdff; border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr style="background: linear-gradient(to right,#13b2ff,#64e9dc); color: #fff; font-size:18px;">
                                <th>নং</th>
                                <th>স্টাফের নাম</th>
                                <th>অ্যাকশন</th>
                                <th>পরিমাণ</th>
                                <th>তারিখ</th>
                                <th>খরচের নোট</th>
                            </tr>
                        </thead>
                        <tbody id="staff-cost-table-body">
                            <!-- JS will populate this -->
                        </tbody>
                    </table>
                </div>


                <!-- jQuery is required for Bootstrap's Collapse, assumed present -->
                <script>
                    // Collapse form on add button click (if open), or open if closed (handled by Bootstrap).
                    // AJAX submission for demo; replace with real backend endpoint.
                    $(document).ready(function(){
                        // Load cost list on page load
                        loadStaffCostList();

                        // Submit form
                        $("#staffCostForm").on("submit", function(e){
                            e.preventDefault();

                            var formData = {
                                staff_id: $("#staff_name option:selected").val(),
                                staff_name: $("#staff_name option:selected").text(),
                                cost_amount: $("#cost_amount").val(),
                                cost_date: $("#cost_date").val(),
                                cost_note: $("#cost_note").val()
                            };

                            $.ajax({
                                url: "payment_types/add_staff_cost_added", // Replace with actual URL
                                method: "POST",
                                data: formData,
                                dataType: "json",
                                success: function(res){
                                    if(res.status === "success" || res.success) {
                                        $("#staffCostForm")[0].reset();
                                        $('#staffCostFormCollapse').collapse('hide');
                                        loadStaffCostList();
                                    } else {
                                        alert("কিছু ভুল হয়েছে! আবার চেষ্টা করুন।");
                                    }
                                },
                                error: function(){
                                    alert("Error while saving!");
                                }
                            });
                        });

                        // Example function: load list via AJAX
                        function loadStaffCostList() {
                            $.ajax({
                                url: "payment_types/get_cost_of_staffs", // Replace with actual URL
                                method: "POST",
                                dataType: "json",
                                success: function(data){
                                    var tbody = $("#staff-cost-table tbody");
                                    tbody.empty();
                                    if(data.cost_of_staffs.length){
                                        $.each(data.cost_of_staffs,function(i,cost){
                                            tbody.append(
                                                `<tr>
                                                    <td>${i+1}</td>
                                                    <td>${cost.staff_namess}</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs delete-cost-btn" data-id="${cost.db_staff_cost_add_idd}" title="মুছুন" style="font-size: 18px !important; border-radius: 8px !important; min-width: 44px;" >
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                    <td><span style="background:linear-gradient(to right, #43cea2 0%, #185a9d 100%);color:#fff;padding:2px 12px;border-radius:20px;display:inline-block;font-weight:bold;">${formatter.format(cost.staff_cos_amounts).getDigitBanglaFromEnglish()}</span></td>
                                                    <td>${cost.staff_cost_dates}</td>
                                                    <td>${cost.staff_notess ? cost.staff_notess : ''}</td>
                                                </tr>`
                                            );
                                        });
                                    } else {
                                        tbody.append("<tr><td colspan='6' style='text-align:center; background:#ffe6e6; color:#dc3545;font-size:18px;'>কোন ডাটা পাওয়া যায়নি</td></tr>");
                                    }
                                }
                            });
                        }

                        // Delete button handler
                        $("#staff-cost-table").on("click", ".delete-cost-btn", function(){
                            if(!confirm("আপনি কি নিশ্চিত?")) return;
                            var id = $(this).data("id");
                            $.ajax({
                                url: "payment_types/delete_staff_cost_added", // Replace with actual URL
                                method: "POST",
                                data: { 
                                    id: id 
                                },
                                success: function(res){
                                    loadStaffCostList();
                                }
                            });
                        });

                    });
                </script>














                
            </div>
            <!-- /.content-wrapper -->
            <?php include"footer.php"; ?>

            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <!-- SOUND CODE -->
        <?php include"comman/code_js_sound.php"; ?>
        <!-- TABLES CODE -->
        <?php include"comman/code_js_form.php"; ?>

        <script src="<?php echo $theme_link; ?>js/payment.js"></script>

        <!-- Make sidebar menu hughlighter/selector -->
        <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    </body>
</html>

