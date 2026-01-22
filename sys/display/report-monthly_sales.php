
<?php

    // var_dump($monthly_sales);
    // die();


    // echo "<pre>";
    // print_r ($monthly_sales);
    // echo "</pre>";

    // die();

?>



<!DOCTYPE html>
<html>
<head> 
   <base href="<?php echo base_url(); ?>" target="">
   <!-- TABLES CSS CODE -->
   <?php include"comman/code_css_form.php"; ?>
   <!-- </copy> -->

   <style>
        /* Compact table */
        .assign_short_data table {
            font-size: 14px; /* ছোট font */
            width: auto;     /* full width না, content অনুযায়ী */
            max-width: 800px; /* চাইলে width limit দিতে পারো */
        }
        .assign_short_data th, .assign_short_data td {
            padding: 6px 10px; /* compact padding */
            text-align: right;
        }
        .assign_short_data th:first-child, .assign_short_data td:first-child {
            text-align: left; /* মাস column left-align */
        }
        .assign_short_data th, .assign_short_data td {
            white-space: nowrap; /* line break না */
        }
        .assign_short_data .info {
            background-color: #d9edf7; /* light blue header */
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
                        <?=$page_title;?>
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
                        <li class="active"><?=$page_title;?></li>
                    </ol>
                </section>
                <br>
                <div class="center container">
                    <div class="card">
                        <div class=" box box-primary ">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="container">
                                    <div class="col-md-4 p-3 text-center " style="font-size: 30px;" >বিক্রয় রিপোর্ট</div>
                                </div>
                                <div class="col-md-4"></div>
                                <hr>
                            </div>

                            <div class="panel panel-primary">
                                <div class="panel-heading text-center" style="font-size: 22px; font-weight: bold;">ফিল্টার</div>
                                <div class="panel-body">
                                    <div class="form-inline">
                                        <div class="form-group form-group-lg" style="margin-left: 15px;">
                                            <label for="end_date" style="font-size: 18px; font-weight: bold;">এখানে সাল লিখুন </label>
                                            <input type="text" inputmode="numeric" class="form-control form-control-lg typing_yearas " id="end_date" value="<?= date('Y'); ?>" >
                                        </div>
                                        <div class="btn btn-primary btn-lg search_report_btn" style="margin-left: 15px;">রিপোর্ট</div>
                                    </div>
                                </div>
                            </div>

                            <div class="assign_short_data" style="margin: 0 20px 30px 30px; "></div>
                            <div class="assign_search_table_data" style="margin: 20px 20px 30px 30px; "></div>

                        </div>
                    </div>
                </div>

            </section>

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
    <!-- TABLE EXPORT CODE -->
    <?php include"comman/code_js_export.php"; ?>


    <!-- Make sidebar menu hughlighter/selector -->
    <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>


<script>
$(document).on('click', '.search_report_btn', function () {
    let typing_yearas = $('.typing_yearas').val();
    $.ajax({
        type: "POST",
        url: "reports/get_monthly_sales_repots_json",
        data: {
            year: typing_yearas
        },
        dataType: "json",
        success: function (res) {

            let data = res.monthly_sales;

            // Step 1: Month-wise total calculate
            let monthTotals = {};
            let grandTotal = 0;

            $.each(data, function (_, row) {
                let total = parseFloat(row.commission_amount) + parseFloat(row.direct_amount);
                if (!monthTotals[row.sales_month]) {
                    monthTotals[row.sales_month] = 0;
                }
                monthTotals[row.sales_month] += total;
                grandTotal += total;
            });

            // Step 1: Backend থেকে item list auto generate
            let itemsOrder = [];
            $.each(data, function (_, row) {
                if (!itemsOrder.includes(row.item_name)) {
                    itemsOrder.push(row.item_name);
                }
            });

            // Step 2: Dynamic Table Header তৈরি
            let header1 = `<tr class="info"><th rowspan="2">মাস</th>`;
            let header2 = `<tr class="info">`;

            $.each(itemsOrder, function (_, item) {
                header1 += `<th colspan="2">${item}</th>`;
                header2 += `<th>কমিশন</th><th>ডাইরেক্ট</th>`;
            });

            header1 += `<th colspan="2">মোট</th></tr>`;
            header2 += `<th>কমিশন</th><th>ডাইরেক্ট</th></tr>`;

            // Step 3: Month-wise group
            let grouped = {};
            $.each(data, function (_, row) {
                if (!grouped[row.sales_month]) {
                    grouped[row.sales_month] = {};
                }
                grouped[row.sales_month][row.item_name] = {
                    commission: parseFloat(row.commission_amount),
                    direct: parseFloat(row.direct_amount)
                };
            });

            // Step 4: Table start
            let html = `
            <div class="table-responsive">
            <center><h2>বিস্তারিত রিপোর্ট</h2></center>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                ${header1}
                ${header2}
                </thead>
                <tbody>
            `;

            // Step 5: Table body
            $.each(grouped, function (month, items) {

                let monthCommission = 0;
                let monthDirect = 0;

                html += `<tr><td>${bnMonth(month)}</td>`;

                $.each(itemsOrder, function (_, item) {
                    let commission = items[item]?.commission || 0;
                    let direct = items[item]?.direct || 0;

                    monthCommission += commission;
                    monthDirect += direct;

                    html += `<td>${commission.toLocaleString()}</td>`;
                    html += `<td>${direct.toLocaleString()}</td>`;
                });

                html += `<td class="month-total">${monthCommission.toLocaleString()}</td>`;
                html += `<td class="month-total">${monthDirect.toLocaleString()}</td></tr>`;
            });

            html += `</tbody></table></div>`;


            // Step 2: Table start
            let htmlshort = `
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" style="font-size:18px;">
                    <thead>
                        <tr class="info">
                            <th>মাস</th>
                            <th>মোট বিক্রয়</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            // Step 3: Table rows
            $.each(monthTotals, function (month, total) {
                htmlshort += `<tr>
                    <td>${bnMonth(month)}</td>
                    <td>${formatter.format(total.toFixed(0)).getDigitBanglaFromEnglish()}</td>
                    <td></td>
                </tr>`;
            });

            // Step 4: Grand total row
            htmlshort += `<tr class="info">
                        <th>মোট ${typing_yearas} </th>
                        <th>${formatter.format(grandTotal.toFixed(0)).getDigitBanglaFromEnglish()}</th>
                        <th></th>
                    </tr>`;

            htmlshort += `</tbody></table></div>`;

            // Step 5: DOM update
            $('.assign_short_data').html(htmlshort);
            // Step 6: Table DOM এ বসানো
            $('.assign_search_table_data').html(html);
        }
    });
});

// Helper: বাংলা মাস converter
function bnMonth(ym) {
    let m = {
        '01':'জানুয়ারি','02':'ফেব্রুয়ারি','03':'মার্চ','04':'এপ্রিল',
        '05':'মে','06':'জুন','07':'জুলাই','08':'আগস্ট',
        '09':'সেপ্টেম্বর','10':'অক্টোবর','11':'নভেম্বর','12':'ডিসেম্বর'
    };
    let p = ym.split('-');
    return m[p[1]] + ' ' + p[0];
}
</script>







</body>
</html>
