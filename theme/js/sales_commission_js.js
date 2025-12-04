


var sales_commission_form_data = `
                <div class="row main_form_count " >
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>মোট বস্তা</label>
                            <input type="text" inputmode="numeric" class="form-control ttl_sales_bostas_box " placeholder="মোট বস্তা">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>ওজন:</label>
                            <input type="text" inputmode="numeric" class="form-control ttl_weight_ss_boxsss " placeholder="মোট ওজন">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>দাম</label>
                            <input type="text" class="form-control rates_per_kgsss_boxss " inputmode="numeric" placeholder="১ কেজির দাম">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>মোট দাম</label>
                            <input type="text" class="form-control ttl_rates_box_ssss " readonly="readonly" inputmode="numeric" placeholder="মোট দাম">
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <label>ডিলেট</label>
                        <div class="delete-btn-container">
                            <button type="button" class="btn btn-danger btn-block remove-entry"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>`;

$(document).on('click', '.add_data_form_btn', function () {
    $('.main_form_add_container').append(sales_commission_form_data);
})

$(document).on('click', '.remove-entry', function () {
    $(this).parents('.main_form_count').remove();
});


$(document).on('change', '.cust_select_unq_idds', function () { 
    $.ajax({
        type: "post",
        url: "tax/get_sales_commission_item_info_by_cust_id",
        data: {
            cust_id: $(this).val() 
        },
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
        success: function (rp) {
            let html_data = '';
            for (let k = 0; k < rp.salrs_info.length; k++) {            
                html_data +=`<li class="custom-tab">
                                <a class=" clickable_get_lot_ref_data " href="#tab_1" data-toggle="tab" sales_id_attr="${rp.salrs_info[k].id}">
                                    ${rp.salrs_info[k].sales_date.getDigitBanglaFromEnglish()} ==> কেজি ${rp.salrs_info[k].ttl_sales_kgss.getDigitBanglaFromEnglish()}
                                </a>
                            </li>`;
            }
            $('.lot_info_assign_nav').html(`<div class="navpanel navpanel-body"><ul class="nav navss nav-tabs text-bold font-italic">${html_data}</ul></div>`); 
            $('.sales_item_show_div').html(''); 
            $('.all_data_infos_cal_assign').html(''); 
            $('.sales_items_click_infosss').html(''); 
        }
    });
});


$(document).on('click', '.clickable_get_lot_ref_data', function () { 
    $.ajax({
        type: "post",
        url: "tax/get_sales_commission_item_info_by_sales_id",
        data: {
            sales_id: $(this).attr('sales_id_attr'),
        },
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
        success: function (pn) {     

            let items_lists = '';
            for (let k = 0; k < pn.sales_item_info.length; k++) {   
                let item_imagess = '';  
                if (pn.sales_item_info[k].item_image == null) {
                    item_imagess = 'theme/images/no_image.png';
                }else {
                    item_imagess = `uploads/items/${pn.sales_item_info[k].item_image}`;
                }
                // cust_select_unq_idds
                items_lists += `<div class="col-md-3 col-sm-4 sales_itemss_boxss" item_ids="${pn.sales_item_info[k].item_id}" sales_pr_qut_iddd="${pn.sales_item_info[k].sales_id}" sales_items_uniq_id="${pn.sales_item_info[k].id}" pur_items_unq_auto_iddd="${pn.sales_item_info[k].pur_item_a_priddd}" purchases_idd="${pn.sales_item_info[k].purchase_id}" pur_trans_auto_iddds="${pn.sales_item_info[k].purchase_trans_info_auto_pr_iddds}" style="cursor: pointer; margin-top: 10px;" >
                                    <div class="product-card">
                                        <span class="qty-badge">Qty: ${pn.sales_item_info[k].sales_qnty_bostas}-${pn.sales_item_info[k].unit_name} </span>
                                        <img src="${item_imagess}" alt="Product Image">
                                        <p class="product-name">${pn.sales_item_info[k].ref_lot_no}</p>
                                        <div class="decorative-line"></div>
                                        <p class="price">৳ ${pn.sales_item_info[k].price_per_kg} প্রস্তাবিত</p>
                                    </div>
                                </div>`;   
            }
            $('.sales_item_show_div').html(`<div class="row">${items_lists}</div>`); 
            $('.all_data_infos_cal_assign').html(''); 
            $('.sales_items_click_infosss').html(''); 
        }
    });
}); 

$(document).on('click', '.sales_itemss_boxss', function () {
    let item_id = $(this).attr('item_ids');
    let sales_id = $(this).attr('sales_pr_qut_iddd');
    let sales_item_id = $(this).attr('sales_items_uniq_id');
    let pur_item_id = $(this).attr('pur_items_unq_auto_iddd');
    let purchase_id = $(this).attr('purchases_idd');
    let pur_tran_id = $(this).attr('pur_trans_auto_iddds');
    $.ajax({
        type: "post",
        url: "tax/get_full_sales_item_info_by_sales_item_id",
        data: {
            sales_item_id: $(this).attr('sales_items_uniq_id')
        },
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
        success: function (rsnn) { 

            let sales_return_info_ss = '';

            if (!$.trim(rsnn.sales_return_info)) {
            }else {
                let ttl_weight = 0;
                let ttl_bosta = 0;
                let ttl_sale_return_dates = '';
                
                for (let lmn = 0; lmn < rsnn.sales_return_info.length; lmn++) { 
                    ttl_weight += parseFloat(rsnn.sales_return_info[lmn].return_ttl_weight_s);
                    ttl_bosta += parseFloat(rsnn.sales_return_info[lmn].return_qty);
                    ttl_sale_return_dates = rsnn.sales_return_info[lmn].ttl_sale_return_dates;
                }

                sales_return_info_ss = `<div class="sales-summary col-6 col-md-6" style="margin-top: 10px; ">
                                            <h2 class="sales-summary-h2">পন্য ফেরতের তথ্য</h2>
                                            <div class="summary-item">
                                                <span class="summary-title">রিটার্ণের তারিখ:</span> <span id="saleDate">${ttl_sale_return_dates}</span> 
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-title">পরিমান:</span> <span id="totalBosta" class="return_bosta_sss">${ttl_bosta}</span> বস্তা
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-title">মোট ওজন</span> <span id="totalWeight">${ttl_weight} কেজি</span>
                                            </div>
                                        </div>`;

            }

            $('.sales_items_click_infosss').html(
                `<div class="salescontainer row ">
                    <div class="sales-summary col-6 col-md-6" style="margin-top: 10px; ">
                        <h2 class="sales-summary-h2">বিক্রয়ের তথ্য </h2>
                        <div class="summary-item">
                            <span class="summary-title">বিক্রয়ের তারিখ:</span> <span id="saleDate">${rsnn.sales_item_info.sales_date}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-title">পরিমান:</span> <span id="totalBosta" class="total_sales_ing_bostass " >${rsnn.sales_item_info.sales_qnty_bostas}</span> বস্তা
                        </div>
                        <div class="summary-item">
                            <span class="summary-title">মোট ওজন</span> <span id="totalWeight" class="total_sales_weightss" >${rsnn.sales_item_info.ttl_sale_kgs_this_product}</span> কেজি 
                        </div>
                        <div class="summary-item">
                            <span class="summary-title">দাম (প্রস্তাবিত):</span> <span id="perKgPrice">${rsnn.sales_item_info.price_per_kg} টাকা</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-title">পন্যের কেনা দাম:</span> <span id="avgBuyPrice">${rsnn.sales_item_info.purchase_per_kgs_price} টাকা</span>
                        </div>
                    </div>
                    ${sales_return_info_ss}
                </div>`
            );
            $('.all_data_infos_cal_assign').html(
                `<div class="commission_datas_body" style="margin-top: 10px; ">
                    <div class="com_container ">
                        <h2 class="text-center text-primary">বিক্রয় কমিশনের বিবরণ</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">বিক্রয় তথ্য</div>
                                    <div class="panel-body">
                                        <form id="income-form">
                                            <div id="income-entries" class="main_form_add_container">

                                                <div class="row main_form_count " >
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>মোট বস্তা</label>
                                                            <input type="text" inputmode="numeric" class="form-control ttl_sales_bostas_box " placeholder="মোট বস্তা">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>ওজন:</label>
                                                            <input type="text" inputmode="numeric" class="form-control ttl_weight_ss_boxsss " placeholder="মোট ওজন">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>দাম</label>
                                                            <input type="text" class="form-control rates_per_kgsss_boxss " inputmode="numeric" placeholder="১ কেজির দাম">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>মোট দাম</label>
                                                            <input type="text" class="form-control ttl_rates_box_ssss " readonly="readonly" inputmode="numeric" placeholder="মোট দাম">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <label>ডিলেট</label>
                                                        <div class="delete-btn-container">
                                                            <button type="button" class="btn btn-danger btn-block remove-entry this_deleted_this_section_sss "><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class=" text-center ">
                                                <button type="button" class=" text-center btn btn-primary add-btn add_data_form_btn " id="add-income">আরো যোগ করুন</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">খরচের তথ্য</div>
                                    <div class="panel-body">
                                        <form>
                                            <div class="form-group">
                                                <label>কমিশন:</label>
                                                <input type="text" inputmode="numeric" class="form-control ttl_commsn_cost_get " placeholder="মোট কমিশন">
                                            </div>
                                            <div class="form-group">
                                                <label>তহুরী:</label>
                                                <input type="text" inputmode="numeric" class="form-control tohuri_cost_gettingss " placeholder="তহুরী">
                                            </div>
                                            <div class="form-group">
                                                <label>গদী খরচ:</label>
                                                <input type="text" inputmode="numeric" class="form-control godi_cost_get_box " placeholder="গদী খরচ">
                                            </div>
                                            <div class="form-group">
                                                <label>ঘর কুলী:</label>
                                                <input type="text" inputmode="numeric" class="form-control ghar_kuli_cost_cost_box " placeholder="ঘর কুলী">
                                            </div>
                                            <div class="form-group">
                                                <label>খালী বস্তা:</label>
                                                <input type="text" inputmode="numeric" class="form-control khali_bosta_set_cost_box " placeholder="খালী বস্তা">
                                            </div>
                                            <div class="form-group">
                                                <label>বাছানী:</label>
                                                <input type="text" inputmode="numeric" class="form-control bachani_cost_get_box " placeholder="বাছানী">
                                            </div>
                                            <div class="form-group">
                                                <label>অন্যান্য খরচ:</label>
                                                <input type="text" inputmode="numeric" class="form-control other_cost_box_get_data " placeholder="অন্যান্য খরচ">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success submit_form_btn submit_send_datas_btn " item_ids="${item_id}" sales_pr_qut_iddd="${sales_id}" sales_items_uniq_id="${sales_item_id}" pur_items_unq_auto_iddd="${pur_item_id}" purchases_idd="${purchase_id}" pur_trans_auto_iddds="${pur_tran_id}" >চেক</button>
                        </div>
                    </div>
                </div>`
            );
        }
    });
});

$(document).on('keyup', '.ttl_sales_bostas_box, .ttl_weight_ss_boxsss, .rates_per_kgsss_boxss', function () {
    let ttl_sales_bostas_box = '';
    let ttl_weight_ss_boxsss = '';
    let rates_per_kgsss_boxss = '';

    if ($(this).parents('.main_form_count').find('.ttl_sales_bostas_box').val() == '') {
        ttl_sales_bostas_box = 0;
    } else {
        ttl_sales_bostas_box = parseFloat($(this).parents('.main_form_count').find('.ttl_sales_bostas_box').val());
    }

    if ($(this).parents('.main_form_count').find('.ttl_weight_ss_boxsss').val() == '') {
        ttl_weight_ss_boxsss = 0;
    } else {
        ttl_weight_ss_boxsss = parseFloat($(this).parents('.main_form_count').find('.ttl_weight_ss_boxsss').val());
    }

    if ($(this).parents('.main_form_count').find('.rates_per_kgsss_boxss').val() == '') {
        rates_per_kgsss_boxss = 0;
    } else {
        rates_per_kgsss_boxss = parseFloat($(this).parents('.main_form_count').find('.rates_per_kgsss_boxss').val());
    }
    let ttl_rates_box_ssss = ttl_weight_ss_boxsss * rates_per_kgsss_boxss;
    $(this).parents('.main_form_count').find('.ttl_rates_box_ssss').val(ttl_rates_box_ssss);
});

$(document).on('click', '.submit_form_btn', function () {

    let ttl_sales_bostas_box = 0;
    let ttl_weight_ss_boxsss = 0;
    let rates_per_kgsss_boxss = 0;
    let ttl_rates_box_ssss = 0;

    let ttl_commsn_cost_get = 0;
    let tohuri_cost_gettingss = 0;
    let godi_cost_get_box = 0;
    let ghar_kuli_cost_cost_box = 0;
    let khali_bosta_set_cost_box = 0;
    let bachani_cost_get_box = 0;
    let other_cost_box_get_data = 0;

    let table_row_tr = '';
    let total_incom_amountssss = 0;

    if ($('.ttl_sales_bostas_box').val() == '') {
        ttl_sales_bostas_box = 0;
    }else {
        ttl_sales_bostas_box = parseFloat($('.ttl_sales_bostas_box').val());
    }
    if ($('.ttl_weight_ss_boxsss').val() == '') {
        ttl_weight_ss_boxsss = 0;
    }else {
        ttl_weight_ss_boxsss = parseFloat($('.ttl_weight_ss_boxsss').val());
    }
    if ($('.rates_per_kgsss_boxss').val() == '') {
        rates_per_kgsss_boxss = 0;
    }else {
        rates_per_kgsss_boxss = parseFloat($('.rates_per_kgsss_boxss').val());
    }
    if ($('.ttl_rates_box_ssss').val() == '') {
        ttl_rates_box_ssss = 0;
    }else {
        ttl_rates_box_ssss = parseFloat($('.ttl_rates_box_ssss').val());
    }
    if ($('.ttl_commsn_cost_get').val() == '') {
        ttl_commsn_cost_get = 0;
    }else {
        ttl_commsn_cost_get = parseFloat($('.ttl_commsn_cost_get').val());
    }
    if ($('.tohuri_cost_gettingss').val() == '') {
        tohuri_cost_gettingss = 0;
    }else {
        tohuri_cost_gettingss = parseFloat($('.tohuri_cost_gettingss').val());
    }
    if ($('.godi_cost_get_box').val() == '') {
        godi_cost_get_box = 0;
    }else {
        godi_cost_get_box = parseFloat($('.godi_cost_get_box').val());
    }
    if ($('.ghar_kuli_cost_cost_box').val() == '') {
        ghar_kuli_cost_cost_box = 0;
    }else {
        ghar_kuli_cost_cost_box = parseFloat($('.ghar_kuli_cost_cost_box').val());
    }
    if ($('.khali_bosta_set_cost_box').val() == '') {
        khali_bosta_set_cost_box = 0;
    }else {
        khali_bosta_set_cost_box = parseFloat($('.khali_bosta_set_cost_box').val());
    }
    if ($('.bachani_cost_get_box').val() == '') {
        bachani_cost_get_box = 0;
    }else {
        bachani_cost_get_box = parseFloat($('.bachani_cost_get_box').val());
    }
    if ($('.other_cost_box_get_data').val() == '') {
        other_cost_box_get_data = 0;
    }else {
        other_cost_box_get_data = parseFloat($('.other_cost_box_get_data').val());
    }

    let total_costing_amount_get = ttl_commsn_cost_get + tohuri_cost_gettingss + godi_cost_get_box + ghar_kuli_cost_cost_box + khali_bosta_set_cost_box + bachani_cost_get_box + other_cost_box_get_data;

    
    $(".main_form_count").each(function () {
        let totalBosta = $(this).find(".ttl_sales_bostas_box").val();
        let totalWeight = $(this).find(".ttl_weight_ss_boxsss").val();
        let ratePerKg = $(this).find(".rates_per_kgsss_boxss").val();
        let totalRate = $(this).find(".ttl_rates_box_ssss").val();

        total_incom_amountssss += parseFloat(totalRate);
        
        // Append data to table
        table_row_tr += `<tr>
                            <td>${formatter.format(totalBosta).getDigitBanglaFromEnglish()} বস্তা</td>
                            <td>${formatter.format(totalWeight).getDigitBanglaFromEnglish()} কেজি</td>
                            <td>${formatter.format(ratePerKg).getDigitBanglaFromEnglish()} টাকা</td>
                            <td>${formatter.format(totalRate).getDigitBanglaFromEnglish()} টাকা</td>
                        </tr>`;
    });

    $('.set_full_datas').html(
        `<div class="modal_panel panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>বস্তা</th>
                                    <th>মোট ওজন</th>
                                    <th>দাম</th>
                                    <th>মোট টাকা</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${table_row_tr}
                                <tr>
                                    <td colspan="3"><strong>মোট:</strong></td>
                                    <td><strong><span class="ttl_sales_this_incomes " >${formatter.format(total_incom_amountssss).getDigitBanglaFromEnglish()}</span> টাকা</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 expense-table">
                        <h4>খরচের বিস্তারিত</h4>
                        <p><strong>কমিশন:</strong> ${formatter.format(ttl_commsn_cost_get).getDigitBanglaFromEnglish()} টাকা</p>
                        <p><strong>তহুরী খরচ:</strong> ${formatter.format(tohuri_cost_gettingss).getDigitBanglaFromEnglish()} টাকা</p>
                        <p><strong>গদী খরচ:</strong> ${formatter.format(godi_cost_get_box).getDigitBanglaFromEnglish()} টাকা</p>
                        <p><strong>ঘরকুলি খরচ:</strong> ${formatter.format(ghar_kuli_cost_cost_box).getDigitBanglaFromEnglish()} টাকা</p>
                        <p><strong>খালী বস্তা খরচ:</strong> ${formatter.format(khali_bosta_set_cost_box).getDigitBanglaFromEnglish()} টাকা</p>
                        <p><strong>বাছানী খরচ:</strong> ${formatter.format(bachani_cost_get_box).getDigitBanglaFromEnglish()} টাকা</p>
                        <p><strong>অন্যান্য খরচ:</strong> ${formatter.format(other_cost_box_get_data).getDigitBanglaFromEnglish()} টাকা</p>
                        <hr>
                        <p><strong>মোট খরচ:</strong> ${formatter.format(total_costing_amount_get).getDigitBanglaFromEnglish()} টাকা</p>
                    </div>
                </div>
            </div>
            <div class="modal_panel-footer panel-footer text-center">
                <strong>সর্বমোট টাকা: <span class="ttl_amnt_of_customers" ttlss_amntss="${total_incom_amountssss - total_costing_amount_get}" >${formatter.format(total_incom_amountssss - total_costing_amount_get).getDigitBanglaFromEnglish()}</span> টাকা</strong>
            </div>
        </div>`
    ); 
    $('#modal_sales_commission_calculate').modal('show'); 
});

$(document).on('click', '.add_sales_commission_entry_ssssssa', function () { 

    $.ajax({
        type: "post",
        url: "tax/add_sales_commission_insert_entry",
        data: { 
            'sales_bostas[]':       $('.ttl_sales_bostas_box').map(function(){ return this.value; }).get(),
            'ttl_weight_s[]':       $('.ttl_weight_ss_boxsss').map(function(){ return this.value; }).get(),
            'rate_per_kgs[]':       $('.rates_per_kgsss_boxss').map(function(){ return this.value; }).get(),
            'ttl_rate_set[]':       $('.ttl_rates_box_ssss').map(function(){ return this.value; }).get(),
            'cust_ids':             $('.cust_select_unq_idds option:selected').val(),
            'items_id':             $('.submit_send_datas_btn').attr('item_ids'),
            'sales_id':             $('.submit_send_datas_btn').attr('sales_pr_qut_iddd'),
            'sales_item_id':        $('.submit_send_datas_btn').attr('sales_items_uniq_id'),
            'pur_item_id':          $('.submit_send_datas_btn').attr('pur_items_unq_auto_iddd'),
            'pur_id':               $('.submit_send_datas_btn').attr('purchases_idd'),
            'pur_trans_id':         $('.submit_send_datas_btn').attr('pur_trans_auto_iddds'),
            'commission_cost':      $('.ttl_commsn_cost_get').val(),
            'tohuri_cost':          $('.tohuri_cost_gettingss').val(),
            'godi_cost':            $('.godi_cost_get_box').val(),
            'ghar_kuli_cost':       $('.ghar_kuli_cost_cost_box').val(),
            'khali_bosta_cost':     $('.khali_bosta_set_cost_box').val(),
            'bachani_cost':         $('.bachani_cost_get_box').val(),
            'pthers_cost':          $('.other_cost_box_get_data').val(),
            'ttl_cust_amnt':        $('.ttl_amnt_of_customers').attr('ttlss_amntss'),
        },
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
        success: function (resp) {
            if (resp == 0) {
                toastr.error('দুঃখিত, কিছু ভুল হয়েছে, পুনরায় সবকিছু করুন');
                $('#modal_sales_commission_calculate').modal('hide'); 
            }else {
                $('.set_full_datas').html();
                $('.sales_item_show_div').html(``); 
                $('.all_data_infos_cal_assign').html(''); 
                $('.sales_items_click_infosss').html(''); 
                $('.lot_info_assign_nav').html(``); 
                toastr.success('সফলভাবে সেভ হয়েছে');
                $('#modal_sales_commission_calculate').modal('hide');  

              Swal.fire({
                title: "<strong>বিক্রয় কমিশন যোগ হয়েছে</strong>",
                icon: "success",
                html: `আপনার বিক্রয় কমিশন সফলভাবে যোগ হয়েছে, আপনি এখন স্লিপটা প্রিন্ট করে নেন <br> <a onclick="window.open('tax/sales_commission_receipt_view?sales_commission_id=${resp}','_blank', 'width=800,height=800,left=300,top=300')" style="font-size: 18px; " > Print </a>`,
                showConfirmButton: false,
              });

            }
        }
    });

});
