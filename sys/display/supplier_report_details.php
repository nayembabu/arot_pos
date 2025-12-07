
<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $base_url; ?>">
        <!-- TABLES CSS CODE -->
        <?php include"comman/code_css_form.php"; ?>
        <style>
            .loss,.profit,.table th{font-weight:700}.select2-container .select2-selection--single{height:40px!important;font-size:18px!important;padding:6px 12pximportant}.select2-container--default .select2-selection--single .select2-selection__rendered{line-height:28px!important;font-size:18px!important;color:#333}.select2-container--default .select2-selection--single .select2-selection__arrow{height:38px!important}.select2-results__option{font-size:17px!important;padding:8px 12px!important}body{font-family:SolaimanLipi,Kalpurush,Arial,sans-serif;background:#f5f5f5}.panel-primary>.panel-heading{background:#00695c;border-color:#00695c}.table th{background:#e8f5e9}.profit{color:#1b5e20}.loss{color:#b71c1c}.total-row{background:#fff3e0!important;font-size:18px}.clickable{cursor:pointer;color:#00695c}.modal-header{background:#00695c;color:#fff}@media print{.glyphicon-eye-open,.no-print{display:none!important}body{background:#fff}.panel{box-shadow:none;border:1px solid #000}}/*#mainTable tbody tr{border:3px solid #053844ff}#mainTable tbody tr td{border:0.5px solid #000}*/
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
                                                <input type="text" class="form-control get_type_start_date datepicker " placeholder="" value="<?= date('d-m-Y'); ?>" />
                                                <span class="input-group-addon" style="border-radius: 0;">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-lg col-md-4 col-4 ">
                                            <div class="input-group " >
                                                <input type="text" class="form-control get_type_end_date datepicker " placeholder="" value="<?= date('d-m-Y'); ?>" />
                                                <span class="input-group-addon" style="border-radius: 0;">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-lg col-md-4 col-4 ">
                                            <div class="btn btn-lg btn-primary search_btn_s">
                                                <span class="glyphicon glyphicon-search"></span> খুঁজুন
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="container supp_report_html_data_add" style="margin-top:20px;"></div>

                    <!-- বিস্তারিত বিক্রয় মডাল -->
                    <div class="modal fade" id="detailModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" id="modalTitle">বিস্তারিত বিক্রয় হিসাব</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="info">
                                                <tr>
                                                    <th>তারিখ</th>
                                                    <th>ক্রেতার নাম</th>
                                                    <th>বস্তা</th>
                                                    <th>ওজন (কেজি)</th>
                                                    <th>প্রতি কেজি দর</th>
                                                    <th>মোট বিক্রয়</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detailBody"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


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

                let type_date_start = $('.get_type_start_date').val();
                let type_date_end = $('.get_type_end_date').val();

                let sup_id = $('.supplier_selecting_id option:selected').val();
                if (sup_id == '' || type_date_start == '' || type_date_end == '') {
                    toastr["warning"]("সাপ্লাইয়ার এবং তারিখ সিলেক্ট করুন। ");
                }else {
                    $.ajax({
                        type: "post",
                        url: "suppliers/get_data_date_to_date_report",
                        data: {
                            supp_id: sup_id,
                            type_date_start: type_date_start,
                            type_date_end: type_date_end
                        },
                        dataType: "json",
                        beforeSend: function () {
                            $('.spiner_load_activity').css('display', 'block');
                        },
                        complete: function () {
                            $('.spiner_load_activity').css('display', 'none');
                        },
                        success: function (res) {
                            let table_html = '';
                            res.supplier_report.forEach((report, i) => {
                                let item_count = report.items.length;
                                let sales_total_sum = 0
                                report.items.forEach((item_sngl, index) => {
                                    let ttl_purchase_price = Math.round(item_sngl.pur_total_price);
                                    let ttl_other_cost = (parseInt(report.ttl_com_amnt_for_trans || 0)+parseInt(report.ghar_kuli_cost_amnt_for_trans_with_cut || 0)+parseInt(report.driver_advance_amnt_cost || 0)+parseInt(report.supp_commis_items_wsss || 0)-parseInt(report.koifiyat_amount_tk_for_this_trans || 0));
                                    let ttl_trans_cost = parseInt(report.ttl_trans_other_cost);

                                    let total_cost_perrr = ((parseInt(ttl_other_cost) + parseInt(ttl_trans_cost)) / report.ttl_items_bosta_this_trans) * parseInt(item_sngl.purchase_total_bosta);

                                    let total_sales_price = Math.round(JSON.parse(get_sales_items_infos(item_sngl.id)).total_sales_price);
                                    sales_total_sum += Number(total_sales_price);

                                    let prifit_loss = parseInt(total_sales_price) - (parseInt(ttl_purchase_price) + parseInt(total_cost_perrr));
                                    let pft = '+';
                                    let pft_text = 'profit';
                                    if (prifit_loss < 0) {
                                        pft = ' ';
                                        pft_text = 'loss';
                                    }

                                    table_html += `<tr>`;

                                    // শুধু প্রথম item এ rowspan column দেখাবে
                                    if (index === 0) {
                                        table_html += ` <td class="text-center" rowspan="${item_count}" style="vertical-align: middle;">${i+1}</td>
                                                        <td rowspan="${item_count}" style="vertical-align: middle;">${(report.pur_date_timsssss).getDigitBanglaFromEnglish()}</td>
                                                        <td rowspan="${item_count}" style="vertical-align: middle;">${report.trans_port_namess}</td>
                                                        `;
                                    }

                                    // প্রতিটি item এর column
                                    table_html += ` <td class="clickable" onclick="showDetails(${item_sngl.id})" style="cursor: pointer;">
                                                        <span class="glyphicon glyphicon-eye-open clickable" ></span>
                                                        ${item_sngl.ref_lot_no}
                                                    </td>
                                                    <td class="text-center">${(item_sngl.purchase_total_bosta).getDigitBanglaFromEnglish()}</td>
                                                    <td class="text-center">${formatter.format(parseInt(item_sngl.purchase_total_bosta) * parseInt(item_sngl.pur_kg_per_bosta)).getDigitBanglaFromEnglish()}</td>
                                                    <td class="text-right">${formatter.format(Math.round(item_sngl.pur_total_price)).getDigitBanglaFromEnglish()} টাকা</td>`;
                                    if (index === 0) {
                                        table_html += ` <td class="text-right" style="vertical-align: middle;" rowspan="${item_count}">${formatter.format(report.ttl_trans_other_cost).getDigitBanglaFromEnglish()} টাকা</td>
                                                        <td class="text-right" style="vertical-align: middle;" rowspan="${item_count}">${formatter.format(parseInt(report.ttl_com_amnt_for_trans || 0)+parseInt(report.ghar_kuli_cost_amnt_for_trans_with_cut || 0)+parseInt(report.driver_advance_amnt_cost || 0)+parseInt(report.supp_commis_items_wsss || 0)).getDigitBanglaFromEnglish()} টাকা</td>`;
                                    }
                                    table_html += ` <td class="text-right">${formatter.format(total_sales_price).getDigitBanglaFromEnglish()} টাকা</td>
                                                    <td class="text-right ${pft_text} " style="font-size: 18px; ">${pft} ${formatter.format(prifit_loss).getDigitBanglaFromEnglish()}</td>`;
                                    table_html += `</tr>`;

                                    let total_purchase_with_cost = parseInt(ttl_other_cost) + parseInt(ttl_trans_cost) + parseInt(report.total_trans_price);
                                    let total_prift_loss_cals = sales_total_sum - total_purchase_with_cost;
                                    let color_code = '#b0ffd9ff';
                                    if (total_prift_loss_cals < 0) {
                                        color_code = '#ffa7a7ff';
                                    }

                                    if (index === report.items.length - 1) {
                                        table_html += `
                                                    <tr class="" style="background: ${color_code} !important; font-size: 15px; ">
                                                        <td colspan="4" class="text-center"><strong>মোট</strong></td>
                                                        <td class="text-center"><strong>${report.ttl_items_bosta_this_trans.getDigitBanglaFromEnglish()} বস্তা</strong></td>
                                                        <td class="text-right"><strong>${report.ttl_item_kg_trans.getDigitBanglaFromEnglish()} কেজি</strong></td>
                                                        <td class="text-right"><strong>${formatter.format(report.total_trans_price).getDigitBanglaFromEnglish()}</strong></td>
                                                        <td class="text-right"><strong></strong></td>
                                                        <td class="text-right"><strong>${formatter.format(parseInt(ttl_other_cost) + parseInt(ttl_trans_cost)).getDigitBanglaFromEnglish()}</strong></td>
                                                        <td class="text-right"><strong>${formatter.format(sales_total_sum).getDigitBanglaFromEnglish()}</strong></td>
                                                        <td class="text-right" style="font-size:20px;"><strong>${formatter.format(total_prift_loss_cals).getDigitBanglaFromEnglish()}  টাকা </strong></td>
                                                        <td></td>
                                                    </tr>`
                                    }

                                });
                            });

                            $('.supp_report_html_data_add').html(`
                                <div class="panel panel-primary">

                                    <div class="panel-heading text-center" style="padding:20px 10px; background: linear-gradient(90deg, #4facfe, #00f2fe); border-radius:12px; color:#fff; text-align:center; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                                        <h3 style="margin:0; font-size:24px; font-weight:bold;">
                                            মহাজনের বিস্তারিত ক্রয় রিপোর্ট
                                        </h3>
                                    </div>

                                    <div class="panel-body">

                                        <div style=" display:flex; flex-wrap:wrap; gap:20px; justify-content:space-between; ">

                                            <div style=" flex:1; min-width:250px; background:#ffefef; border-left:6px solid #ff4e4e; padding:15px; border-radius:10px; box-shadow:0 3px 8px rgba(0,0,0,0.08); ">
                                                <div style="font-size:16px; font-weight:bold; color:#d80000;">সাপ্লাইয়ারের নাম</div>
                                                <div style="font-size:25px; margin-top:5px; font-weight:bold; color:#333;">
                                                    <span id="supplier_name">${res.supplier_info.supplier_name}</span>
                                                </div>
                                            </div>

                                            <div style="flex:1; min-width:250px; background:#e8ffe8; border-left:6px solid #00c851; padding:15px; border-radius:10px; box-shadow:0 3px 8px rgba(0,0,0,0.08); ">
                                                <div style="font-size:16px; font-weight:bold; color:#007e33;">মোবাইল</div>
                                                <div style="font-size:20px; margin-top:5px; color:#333;">
                                                    <span id="supplier_mobile">${res.supplier_info.mobile.getDigitBanglaFromEnglish()}</span>
                                                </div>
                                            </div>

                                            <div style=" flex:1; min-width:250px; background:#e8f1ff; border-left:6px solid #4285f4; padding:15px; border-radius:10px; box-shadow:0 3px 8px rgba(0,0,0,0.08); ">
                                                <div style="font-size:16px; font-weight:bold; color:#0d47a1;">ঠিকানা</div>
                                                <div style="font-size:20px; margin-top:5px; color:#333;">
                                                    <span id="supplier_address">${res.supplier_info.address || ''}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div style=" padding:15px; text-align:center; background:#fff4e6; border-left:6px solid #ff8800; font-size:17px; border-radius:10px; box-shadow:0 3px 8px rgba(0,0,0,0.08); ">
                                            রিপোর্ট সময়কালঃ
                                            <strong id="date_range" style="font-size:18px; color:#e65c00;">
                                                ${type_date_start.getDigitBanglaFromEnglish()} থেকে ${type_date_end.getDigitBanglaFromEnglish()}
                                            </strong>
                                        </div>

                                        <div class="table-responsive" style="margin-top: 25px; ">
                                            <table class="table table-bordered table-hover" id="mainTable" >
                                                <thead>
                                                    <tr class="success">
                                                        <th class="no-print">নং</th>
                                                        <th>তারিখ</th>
                                                        <th>গাড়ির নাম</th>
                                                        <th>লট</th>
                                                        <th>মোট বস্তা</th>
                                                        <th>মোট ওজন (কেজি)</th>
                                                        <th>ক্রয় মূল্য</th>
                                                        <th>গাড়ী ভাড়া</th>
                                                        <th>মোট খরচ</th>
                                                        <th>বিক্রয় মূল্য</th>
                                                        <th>লাভ/লস</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="">

                                                    ${table_html}

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            `);
                        }
                    });
                }
            });

            function get_sales_items_infos(purchase_item_id) {
                return $.ajax({
                    type: "post",
                    url: "suppliers/get_total_sales_count_by_piid",
                    data: {
                        pi_id: purchase_item_id
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $('.spiner_load_activity').css('display', 'block');
                    },
                    complete: function () {
                        $('.spiner_load_activity').css('display', 'none');
                    },
                    async: false
                }).responseText;
            }

            function showDetails(piid) {

                $.ajax({
                    type: "post",
                    url: "suppliers/view_sells_info_by_puurchase_items_id_p",
                    data: {
                        pur_item_id: piid
                    },
                    dataType: "json",
                    success: function (rs) {
                        let tbody = document.getElementById('detailBody');
                        tbody.innerHTML = '';
                        // ${formatter.format(sales_total_sum).getDigitBanglaFromEnglish()}
                        rs.sell_infos.forEach(s => {
                            let purchase_info = parseFloat(s.purchase_per_kgs_price) * parseFloat(s.ttl_sale_kgs_this_product);
                            let sales_info = parseFloat(s.total_sales_price_cost_sss);
                            let profit_loss = sales_info - purchase_info;
                            let pft_clr = '#b0ffd9ff';
                            if (profit_loss >= 0) {
                                pft_clr = '#d50000';
                            }
                            tbody.innerHTML += `
                                <tr>
                                    <td>${(s.payment_datesss).getDigitBanglaFromEnglish()}</td>
                                    <td>${s.customer_name}</td>
                                    <td class="text-center">${formatter.format(s.sales_qnty_bostas).getDigitBanglaFromEnglish()}</td>
                                    <td class="text-right">${formatter.format(s.ttl_sale_kgs_this_product).getDigitBanglaFromEnglish()}</td>
                                    <td class="text-right">${formatter.format(s.price_per_kg).getDigitBanglaFromEnglish()} - ${formatter.format(s.purchase_per_kgs_price).getDigitBanglaFromEnglish()}</td>
                                    <td class="text-right">${formatter.format(s.total_sales_price_cost_sss).getDigitBanglaFromEnglish()}</td>
                                </tr>`;
                        });
                        $('#detailModal').modal('show');
                    }
                });

            }





        </script>




    </body>
</html>

