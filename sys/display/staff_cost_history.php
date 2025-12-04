<!DOCTYPE html>
<html>

    <head>
        <base href="<?php echo base_url(); ?>" target="">
        <!-- TABLES CSS CODE -->
        <?php include"comman/code_css_form.php"; ?>
            
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

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Filter Form Card -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">স্টাফ খরচ খুঁজুন</h3>
                                </div>
                                <form id="staff-cost-filter-form" class="form-horizontal" >
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="staff_id" class="col-sm-2 control-label">স্টাফ সিলেক্ট করুন</label>
                                            <div class="col-sm-4">
                                                <select name="staff_id" id="staff_id" class="form-control" required>
                                                    <option value="">সিলেক্ট করুন</option>
                                                    <?php if(!empty($all_staff_infos)): ?>
                                                        <?php foreach($all_staff_infos as $staff): ?>
                                                            <option value="<?php echo $staff->db_staff_info_id; ?>">
                                                                <?php echo $staff->staff_namess; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <label for="start_date" class="col-sm-1 control-label">শুরু তারিখ</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="start_date" id="start_date" class="form-control datepicker" required value="<?php echo date('d-m-Y'); ?>">
                                            </div>
                                            <label for="end_date" class="col-sm-1 control-label">শেষ তারিখ</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="end_date" id="end_date" class="form-control datepicker" required value="<?php echo date('d-m-Y'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer text-center">
                                        <button type="button" id="search_btn" class="btn btn-primary">
                                            <i class="fa fa-search"></i> সার্চ
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Results Table Card -->
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">স্টাফ খরচের তালিকা</h3>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="staff-cost-table">
                                            <thead>
                                                <tr>
                                                    <th>ক্রমিক নং</th>
                                                    <th>স্টাফ নাম</th>
                                                    <th>তারিখ</th>
                                                    <th>পরিমাণ (৳)</th>
                                                    <th>নোট</th>
                                                </tr>
                                            </thead>
                                            <tbody class="">
                                                <!-- Data Will be loaded by AJAX -->
                                            </tbody>
                                            <tfoot>
                                                <tr style="font-weight:bold;">
                                                    <td colspan="3" class="text-right">মোট</td>
                                                    <td id="total_amount">0</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.col-md-12 -->
                    </div><!-- /.row -->
                </section>

                <script>
                    $(document).ready(function(){
                        function fetchStaffCosts() {
                            var staff_id = $("#staff_id").val();
                            var start_date = $("#start_date").val();
                            var end_date = $("#end_date").val();

                            if(staff_id == "") {
                                toastr.error("স্টাফ সিলেক্ট করুন");
                                return;
                            }
                            if(start_date == "" || end_date == "") {
                                toastr.error("তারিখ নির্বাচন করুন");
                                return;
                            }

                            $.ajax({
                                url: "payment_types/get_cost_of_staff_hist",
                                type: "POST",
                                dataType: "json",
                                data: {
                                    staff_id: staff_id,
                                    start_date: start_date,
                                    end_date: end_date
                                },
                                success: function(response) {
                                    var tbody = "";
                                    var total = 0;
                                    if(response.cost_of_staffs && response.cost_of_staffs.length > 0) {
                                        $.each(response.cost_of_staffs, function(idx, row){
                                            tbody += "<tr>";
                                            tbody += "<td>" + (idx+1) + "</td>";
                                            tbody += "<td>" + row.staff_namess + "</td>";
                                            tbody += "<td>" + row.staff_cost_dates + "</td>";
                                            tbody += "<td>" + parseFloat(row.staff_cos_amounts).toFixed(2) + "</td>";
                                            tbody += "<td>" + (row.staff_notess ? row.staff_notess : "") + "</td>";
                                            tbody += "</tr>";
                                            total += parseFloat(row.staff_cos_amounts);
                                        });
                                    } else {
                                        tbody = '<tr><td colspan="5" class="text-center text-danger">কোনো তথ্য পাওয়া যায়নি!</td></tr>';
                                    }
                                    toastr.error("কোনো তথ্য পাওয়া যায় নাই");
                                    $("#staff-cost-table tbody").html(tbody);
                                    $("#total_amount").text(total.toFixed(2));
                                },
                                error: function(){
                                    toastr.error("ডাটা লোড করা যায়নি, আবার চেষ্টা করুন");
                                }
                            });
                        }

                        // Search Button Click
                        $("#search_btn").on("click", function(e){
                            e.preventDefault();
                            fetchStaffCosts();
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

