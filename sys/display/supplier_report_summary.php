
<!DOCTYPE html>
<html>
   <head>
      <base href="<?php echo $base_url; ?>">
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css_form.php"; ?>
      <style>
        .big,.highlight{font-weight:700}body{background:#f8f9fa;font-family:Kalpurush,SolaimanLipi,Arial,sans-serif}.big{font-size:34px;margin:10px 0}.due{color:#e67e22}.total{color:#3498db}.panel{box-shadow:0 4px 20px rgba(0,0,0,.1);border-radius:10px;margin-bottom:15px}canvas{max-height:320px}.chart-container{position:relative;height:320px}.container{padding-top:30px}.highlight{font-size:18px}.profit{color:green}.loss{color:red}@media print{.no-print{display:none}}.inline-form .form-control { height: 40px; } .input-group { display: flex; }.select2-container .select2-selection--single{height:40px!important;font-size:18px!important;padding:6px 12pximportant}.select2-container--default .select2-selection--single .select2-selection__rendered{line-height:28px!important;font-size:18px!important;color:#333}.select2-container--default .select2-selection--single .select2-selection__arrow{height:38px!important}.select2-results__option{font-size:17px!important;padding:8px 12px!important}
      </style>

<!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

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

        <div class="container">

            <section class="" >

                <div class="">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 ">

                            <div class="form-inline inline-form " role="form">

                                <div class="form-group form-group-lg col-md-4 col-4 ">
                                    <select class="form-control select2 supplier_selecting_id ">
                                        <option value="">মহাজন সিলেক্ট করুন </option>
                                        <?php foreach ($all_suppliers as $info) { ?>
                                            <option value="<?= $info->id; ?>"><?= $info->supplier_name; ?> --- <?= $info->address; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group form-group-lg col-md-4 col-4 ">
                                    <div class="input-group " >
                                        <input type="text" class="form-control get_type_years " placeholder="বছর লিখেন (2025) " inputmode="numeric" value="<?= date('Y'); ?>" >
                                        <span class="input-group-addon" style="border-radius: 0;">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group form-group-lg col-md-2 col-2 ">
                                    <div class="btn btn-lg btn-primary search_btn_s">
                                        <span class="glyphicon glyphicon-search"></span> খুঁজুন
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </section>

            <div class="row assign_supplier_reports" style="margin-top: 20px;"></div>

        </div>

    </div>
    <!-- /.content -->




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
<script src="<?php echo $theme_link; ?>js/incomes.js"></script>
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>

<script>
    $(document).on('click', '.search_btn_s', function () {
        let type_years = parseInt($('.get_type_years').val());

        const isNumber = typeof type_years === 'number' && !isNaN(type_years);

        const isValidYear = isNumber &&
                            Number.isInteger(type_years) &&
                            type_years >= 2022 &&
                            type_years <= 2299;

        let sup_id = $('.supplier_selecting_id option:selected').val();
        if (type_years == '' || !isValidYear) {
            toastr["warning"]("সাপ্লাইয়ার এবং বছর লিখুন।");
        }else {
            $.ajax({
                type: "post",
                url: "suppliers/get_data_for_yearly_report",
                data: {
                    year: type_years,
                    supp_id: sup_id
                },
                dataType: "json",
                success: function (res) {

                    let total_costs = parseFloat(res.supplier_purchase_summary.total_transport_vara) + parseFloat(res.supplier_purchase_summary.total_transport_commission) + parseFloat(res.supplier_purchase_summary.total_ghar_kuli) + parseFloat(res.supplier_purchase_summary.total_driver_advance);
                    let total_purchase = parseFloat(res.supplier_purchase_summary.total_purchase_amount);
                    let total_purchase_with_cost = total_purchase + total_costs;
                    let total_sales_amount = parseInt(res.supplier_purchase_summary.total_sales_amount);
                    let total_profit = (total_sales_amount - total_purchase_with_cost).toFixed(0);

                    if (total_profit < 0) {
                        $('.assign_supplier_reports').html(`
                            <div class="col-md-10 col-md-offset-1">
                                <div class="panel panel-primary">
                                    <div class="panel-heading text-center">
                                        <h4>সাপ্লাইয়ার রিপোর্ট</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <h3 class="col-sm-4"><strong>নাম:</strong> ${res.supplier.supplier_name}</h3>
                                            <h3 class="col-sm-4"><strong>মোবাইল:</strong> ${res.supplier.mobile}</h3>
                                            <h3 class="col-sm-4"><strong>ঠিকানা:</strong> ${res.supplier.address ?? ''}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <h4>মোট ক্রয় (নেট)</h4>
                                                <div class="big total">${formatter.format(total_purchase).getDigitBanglaFromEnglish()} টাকা</div>
                                                <small>সকল খরচ ছাড়া</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="panel panel-success">
                                            <div class="panel-body">
                                                <h4>মোট খরচ</h4>
                                                <div class="big profit">${formatter.format(parseInt(res.supplier_purchase_summary.total_transport_vara) + parseInt(res.supplier_purchase_summary.total_transport_commission) + parseInt(res.supplier_purchase_summary.total_ghar_kuli) + parseInt(res.supplier_purchase_summary.total_driver_advance)).getDigitBanglaFromEnglish()} টাকা</div>
                                                <small>গাড়ী-ভাড়া + গাড়ী-কমিশন + ঘর-কুলী + ড্রাইভার-এডভান্স</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="panel panel-warning">
                                            <div class="panel-body">
                                                <h4>মোট বিক্রয়</h4>
                                                <div class="big due">${formatter.format(total_sales_amount).getDigitBanglaFromEnglish()}  টাকা</div>
                                                <small></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        
                                                <div class="alert alert-danger text-center">
                                                    <h3 class="profit big" style="color: white;">${formatter.format(total_profit).getDigitBanglaFromEnglish()} টাকা</h3>
                                                    <h4 class="profit" style="color: white;">এই সাপ্লাইয়ার থেকে লস</h4>
                                                    <p></p>
                                                </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4>২০২৫ সালে মাস অনুযায়ী ক্রয় (হাজার টাকা)</h4>
                                            </div>
                                            <div class="panel-body chart-container">
                                                <canvas id="monthlyPurchase"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        `);
                    }else {
                        $('.assign_supplier_reports').html(`
                            <div class="col-md-10 col-md-offset-1">
                                <div class="panel panel-primary">
                                    <div class="panel-heading text-center">
                                        <h4>সাপ্লাইয়ার রিপোর্ট</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <h3 class="col-sm-4"><strong>নাম:</strong> ${res.supplier.supplier_name}</h3>
                                            <h3 class="col-sm-4"><strong>মোবাইল:</strong> ${res.supplier.mobile}</h3>
                                            <h3 class="col-sm-4"><strong>ঠিকানা:</strong> ${res.supplier.address ?? ''}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <h4>মোট ক্রয় (নেট)</h4>
                                                <div class="big total">${formatter.format(res.supplier_purchase_summary.total_purchase_amount).getDigitBanglaFromEnglish()} টাকা</div>
                                                <small>সকল খরচ ছাড়া</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="panel panel-success">
                                            <div class="panel-body">
                                                <h4>মোট খরচ</h4>
                                                <div class="big profit">${formatter.format(parseFloat(res.supplier_purchase_summary.total_transport_vara) + parseFloat(res.supplier_purchase_summary.total_transport_commission) + parseFloat(res.supplier_purchase_summary.total_ghar_kuli) + parseFloat(res.supplier_purchase_summary.total_driver_advance)).getDigitBanglaFromEnglish()} টাকা</div>
                                                <small>গাড়ী-ভাড়া + গাড়ী-কমিশন + ঘর-কুলী + ড্রাইভার-এডভান্স</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="panel panel-warning">
                                            <div class="panel-body">
                                                <h4>মোট বিক্রয়</h4>
                                                <div class="big due">${formatter.format(total_sales_amount).getDigitBanglaFromEnglish()}  টাকা</div>
                                                <small></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="panel panel-success">
                                            <div class="panel-body">
                                                <h4 class="profit">এই সাপ্লাইয়ার থেকে লাভ</h4>
                                                <div class="big profit">${formatter.format(total_profit).getDigitBanglaFromEnglish()} টাকা</div>
                                                <small></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4>২০২৫ সালে মাস অনুযায়ী ক্রয় (হাজার টাকা)</h4>
                                            </div>
                                            <div class="panel-body chart-container">
                                                <canvas id="monthlyPurchase"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                    }

                    const purchaseAmount = [];
                    const salesAmount = [];

                    res.supplier_purchase_summary_month_wise.forEach(month_data => {
                        purchaseAmount.push(month_data.total_purchase_amount);
                        salesAmount.push(month_data.total_sales_amount);
                    });
                    // Chart.js code for monthly purchase and sales chart
                    new Chart(document.getElementById('monthlyPurchase'), {
                        type: 'line',
                        data: {
                            labels: ['জানু', 'ফেব্রু', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টে', 'অক্টো', 'নভে', 'ডিসে'],
                            datasets: [
                                {
                                    label: 'মাসিক ক্রয় ',
                                    data: purchaseAmount,
                                    borderColor: '#3498db',
                                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#3498db'
                                },
                                {
                                    label: 'মাসিক বিক্রয় ',
                                    data: salesAmount,
                                    borderColor: '#e74c3c',
                                    backgroundColor: 'rgba(231, 76, 60, 0.2)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#e74c3c'
                                }
                            ]
                        },
                        options: { 
                            responsive: true, 
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { labels: { font: { size: 14 } } }
                            }
                        }
                    });


                }
            });
        }
    });
</script>




</body>
</html>

