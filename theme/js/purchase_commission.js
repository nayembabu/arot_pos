
$(document).on('click', '.add-btn', function () {
    $('.append_contain_boxs').append(
        `<div class="sscontainer-box">
            <div class="row tr_all_input_box ">
                <div class="col-md-2">
                    <label>মোট বস্তা</label>
                    <input type="text" class="form-control ttl_bosta_box " inputmode="numeric" placeholder="মোট বস্তা">
                </div>
                <div class="col-md-3">
                    <label>ওজন:</label>
                    <input type="text" class="form-control ttl_weight_box_ss " inputmode="numeric" placeholder="মোট ওজন">
                </div>
                <div class="col-md-3">
                    <label>দাম</label>
                    <input type="text" class="form-control kg_rate_box_s " inputmode="numeric" placeholder="দাম">
                </div>
                <div class="col-md-3">
                    <label>মোট দাম</label>
                    <input type="text" class="form-control ttl_rates_this_rowss " inputmode="numeric" placeholder="মোট দাম" readonly>
                </div>
                <div class="col-md-1 text-center">
                    <br>
                    <button class="ssdelete-btn"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </div>`
    );
});

$(document).on('click', '.ssdelete-btn', function () {
    $(this).parents('.sscontainer-box').remove();
});


/*
$(document).on('change', '.item_select_unq_idds', function () { 
    $.ajax({
        type: "post", 
        url: "tax/get_commission_item_info_by_item_id",
        data: {
            item_id: $(this).val() 
        },
        success: function (rps) { 
            let dts = '';
            for (let s = 0; s < rps.items_info.length; s++) { 
                dts += `<option value="${rps.items_info[s].sup_id_ass_iddd}">${rps.items_info[s].supplier_name}</option>`;
            }
            $('.supp_datas_info_assignss').html(`
                        <div class="input-group input-group-lg">
                            <select class="form-control supp_selected_unqs_id " >
                                <option value="">মহাজন সিলেক্ট করুন</option>${dts}
                            </select>
                            <span class="input-group-addon btn btn-warning check_commsion_items_info " ><i class="fa fa-check-circle"></i></span>
                        </div>`);
        }
    });
});
*/

$(document).on('change', '.supp_select_unq_idds', function () {
    $.ajax({
        type: "post",
        url: "tax/get_commission_pur_trans_info",
        data: {
            supplier_unq_id: $(this).val()
        },
        beforeSend: function () {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function () {
            $('.spiner_load_activity').css('display', 'none');
        },
        success: function (rp) {
            $('.assign_item_lot_s').html('');
            $('.sales_infos_assign_ing_cls').css('display', 'none');
            $('.append_contain_boxs').html(``);
            if ($.isEmptyObject(rp.products_info)) {
                $('.lot_info_assign_nav').html(``);
            } else {
                let html_data = '';

                for (let k = 0; k < rp.products_info.length; k++) {
                    html_data += `<li class=" click_transport_lot_no" trans_idds="${rp.products_info[k].db_purchase_transports_info_a_idd}" >
                                    <a class="nav-tabslia "data-toggle="tab" href="#home">
                                    ${rp.products_info[k].pur_date_timsssss} ==> ${rp.products_info[k].ttl_item_kg_trans}kg
                                    </a>
                                </li>`;
                }
                $('.lot_info_assign_nav').html(`<ul class=" nav nav-tabs"> ${html_data} </ul>`);
            }
        }
    });
});

$(document).on('click', '.click_transport_lot_no', function () {
    $('.append_contain_boxs').html(``);
    $.ajax({
        type: "post",
        url: "tax/get_commission_transports_info_by_trans_id",
        data: {
            trans_id: $(this).attr('trans_idds')
        },
        success: function (rsp) {
            let html_data = '';
            for (let lm = 0; lm < rsp.pur_items.length; lm++) {
                get_sales_full_infos(rsp.pur_items[lm].id);
                // const element = rsp[lm]; 
                html_data += `<div class="col-md-3 col-sm-4 sales_itemss_boxss" pur_items_unq_auto_iddd="${rsp.pur_items[lm].id}" purchases_idd="${rsp.pur_items[lm].purchase_id}" pur_trans_auto_iddds="${rsp.pur_items[lm].purchase_trans_info_auto_pr_iddds}" items_iiiiid="${rsp.pur_items[lm].item_id}" style="cursor: pointer; margin-top: 10px;">
                                    <div class="product-card">
                                        <span class="qty-badge">Qty: ${rsp.pur_items[lm].purchase_qty}-বস্তা </span>
                                        <img src="uploads/items/${rsp.trans_info.item_image}" alt="Product Image">
                                        <p class="product-name"> ${rsp.pur_items[lm].ref_lot_no} </p>
                                        <div class="decorative-line"></div>
                                        <p class="price">৳ ${rsp.pur_items[lm].price_per_unit} প্রস্তাবিত</p>
                                    </div>
                                </div>`;
            }
            $('.assign_item_lot_s').html(`<div class="tab-content ">
                                            <div id="home" class="tab-pane fade in active">
                                                <div class="row ">
                                                    ${html_data}
                                                </div>
                                            </div>  
                                        </div>` );
            $('.sales_infos_assign_ing_cls').css('display', 'block');
            $('.cost_infos_assignsssss_s').html(`<div class="trans_port_id" trans_id="${rsp.trans_info.db_purchase_transports_info_a_idd}"></div>
                                                <div class="form-group">
                                                    <label for="commission">কমিশন:</label>
                                                    <input type="text" class="form-control ttl_commission_ss_cost " id="commission" value="" inputmode="numeric"  placeholder="মোট কমিশন">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tax">তহুরী:</label>
                                                    <input type="text" class="form-control tahuri_ss_cost " id="tax" value="" inputmode="numeric"  placeholder="তহুরী">
                                                </div>
                                                <div class="form-group">
                                                    <label for="partnerShare">গদী ভাড়া:</label>
                                                    <input type="text" class="form-control godi_vara_ss_cost " id="partnerShare" inputmode="numeric"  value="" placeholder="গদী ভাড়া">
                                                </div>
                                                <div class="form-group">
                                                    <label for="roomRent">ঘর কুলী:</label>
                                                    <input type="text" class="form-control ghar_kuli_ss_cost " id="roomRent" inputmode="numeric"  value="${rsp.trans_info.ttal_ghar_kuli_cost_amnt}" placeholder="ঘর কুলী">
                                                </div>
                                                <div class="form-group">
                                                    <label for="emptyRent">খালী বস্তা:</label>
                                                    <input type="text" class="form-control khali_bosta_ss_cost " id="emptyRent" inputmode="numeric"  value="" placeholder="খালী ভাড়া">
                                                </div>
                                                <div class="form-group">
                                                    <label for="transport">গাড়ী ভাড়া:</label>
                                                    <input type="text" class="form-control trans_vara_ss_cost " id="transport" inputmode="numeric"  value="${rsp.trans_info.ttl_trans_other_cost}" placeholder="গাড়ী ভাড়া">
                                                </div>
                                                <div class="form-group">
                                                    <label for="transport">গাড়ী ভাড়া অগ্রীম:</label>
                                                    <input type="text" class="form-control trans_vara_agrim_ss_cost  " id="transport" inputmode="numeric"  value="${rsp.trans_info.driver_advance_amnt_cost}" placeholder="গাড়ী ভাড়া অগ্রীম">
                                                </div>
                                                <div class="form-group">
                                                    <label for="transport">গাড়ী কমিশন:</label>
                                                    <input type="text" class="form-control trans_commission_ss_cost " id="transport" inputmode="numeric"  value="${rsp.trans_info.ttl_trans_com}" placeholder="গাড়ী কমিশন">
                                                </div>
                                                <div class="form-group">
                                                    <label for="otherCost">অন্যান্য খরচ:</label>
                                                    <input type="text" class="form-control others_ss_cost " inputmode="numeric"  id="otherCost" value="${rsp.trans_info.others_cost_amnt_for_trans}" placeholder="অন্যান্য খরচ">
                                                </div>`
            );
        }
    });
});


function get_sales_full_infos(pur_item_id) {

    $.ajax({
        type: "post",
        url: "tax/get_purchase_item_sales_info",
        data: {
            purchase_item_id: pur_item_id
        },
        success: function (resp) {
            let html_data_sales = '';
            for (let a = 0; a < resp.sales_item_info.length; a++) {
                html_data_sales += `<div class="sscontainer-box">
                                        <div class="row tr_all_input_box" pur_items_unq_auto_iddd="${resp.sales_item_info[a].pur_item_a_priddd}" purchases_idd="${resp.sales_item_info[a].purchase_apr_ids}" pur_trans_auto_iddds="${resp.sales_item_info[a].trans_uniq_primary_id}" items_iiiiid="${resp.sales_item_info[a].item_id}" >
                                            <div class="col-md-2">
                                                <label>মোট বস্তা</label>
                                                <input type="text" class="form-control ttl_bosta_box ${pur_item_id}_lotBostas"  inputmode="numeric"  value="${resp.sales_item_info[a].sales_qnty_bostas}" placeholder="মোট বস্তা">
                                            </div>
                                            <div class="col-md-3">
                                                <label>ওজন:</label>
                                                <input type="text" class="form-control ttl_weight_box_ss ${pur_item_id}_lotWeightss" inputmode="numeric"  value="${resp.sales_item_info[a].ttl_sale_kgs_this_product}" placeholder="মোট ওজন">
                                            </div>
                                            <div class="col-md-3">
                                                <label>দাম</label>
                                                <input type="text" class="form-control kg_rate_box_s ${pur_item_id}_lotRatess" inputmode="numeric"  value="${resp.sales_item_info[a].price_per_kg}" placeholder="দাম">
                                            </div>
                                            <div class="col-md-3">
                                                <label>মোট দাম</label>
                                                <input type="text" class="form-control ttl_rates_this_rowss ${pur_item_id}_lotTotalRatess" inputmode="numeric"  value="${resp.sales_item_info[a].total_sales_price_cost_sss}" placeholder="মোট দাম" readonly >
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <br>
                                                <button class="ssdelete-btn"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>`
            }
            $('.append_contain_boxs').append(`<h3 class="text-center lot_names_assgng " pur_item_id="${pur_item_id}" style="margin-top: 0; " > ${resp.pur_item_info.ref_lot_no} </h3> ${html_data_sales}`);
        }
    });

}

$(document).on('keyup', '.ttl_bosta_box, .ttl_weight_box_ss, .kg_rate_box_s', function () {
    let qnty_bosta = 0;
    let ttl_weight = 0;
    let kg_rate = 0;

    if ($(this).parents('.tr_all_input_box').find('.ttl_bosta_box').val() == '') {
        qnty_bosta = 0;
    } else {
        qnty_bosta = parseFloat($(this).parents('.tr_all_input_box').find('.ttl_bosta_box').val());
    }
    if ($(this).parents('.tr_all_input_box').find('.ttl_weight_box_ss').val() == '') {
        ttl_weight = 0;
    } else {
        ttl_weight = parseFloat($(this).parents('.tr_all_input_box').find('.ttl_weight_box_ss').val());
    }
    if ($(this).parents('.tr_all_input_box').find('.kg_rate_box_s').val() == '') {
        kg_rate = 0;
    } else {
        kg_rate = parseFloat($(this).parents('.tr_all_input_box').find('.kg_rate_box_s').val());
    }

    $(this).parents('.tr_all_input_box').find('.ttl_rates_this_rowss').val(ttl_weight * kg_rate);
});

$(document).on('click', '.commission_checking_ss_btn', function () {

    let sales_htmlaaa = '';
    let ttl_sales_amnt_taka = 0;

    let ttl_commission_ss_cost = '';
    let tahuri_ss_cost = '';
    let godi_vara_ss_cost = '';
    let ghar_kuli_ss_cost = '';
    let khali_bosta_ss_cost = '';
    let trans_vara_ss_cost = '';
    let trans_vara_agrim_ss_cost = '';
    let trans_commission_ss_cost = '';
    let others_ss_cost = '';

    let commission_cost = 0;
    let tahuri_cost = 0;
    let godivara_cost = 0;
    let gharkuli_cost = 0;
    let khalibosta_cost = 0;
    let transvara_cost = 0;
    let transvara_agrim_cost = 0;
    let trans_commission_cost = 0;
    let others_cost = 0;

    let sales_khoroc_ss_cost = 0;

    if ($('.ttl_commission_ss_cost').val() == '' || $('.ttl_commission_ss_cost').val() == 0) {
        ttl_commission_ss_cost = '';
        commission_cost = 0;
    } else {
        ttl_commission_ss_cost = `<p class="expense-item">কমিশন: <span id="expense1">${formatter.format(parseFloat($('.ttl_commission_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`;
        commission_cost = parseFloat($('.ttl_commission_ss_cost').val());
    }
    if ($('.tahuri_ss_cost').val() == '' || $('.tahuri_ss_cost').val() == 0) {
        tahuri_ss_cost = '';
        tahuri_cost = 0;
    } else {
        tahuri_ss_cost = `<p class="expense-item">তহুরী: <span id="expense1">${formatter.format(parseFloat($('.tahuri_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`;
        tahuri_cost = parseFloat($('.tahuri_ss_cost').val());
    }
    if ($('.godi_vara_ss_cost').val() == '' || $('.godi_vara_ss_cost').val() == 0) {
        godi_vara_ss_cost = '';
        godivara_cost = 0;
    } else {
        godi_vara_ss_cost = `<p class="expense-item">গদী ভাড়া: <span id="expense1">${formatter.format(parseFloat($('.godi_vara_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`;
        godivara_cost = parseFloat($('.godi_vara_ss_cost').val());
    }
    if ($('.ghar_kuli_ss_cost').val() == '' || $('.ghar_kuli_ss_cost').val() == 0) {
        ghar_kuli_ss_cost = '';
        gharkuli_cost = 0;
    } else {
        ghar_kuli_ss_cost = `<p class="expense-item">ঘর কুলি: <span id="expense1">${formatter.format(parseFloat($('.ghar_kuli_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`;
        gharkuli_cost = parseFloat($('.ghar_kuli_ss_cost').val());
    }
    if ($('.khali_bosta_ss_cost').val() == '' || $('.khali_bosta_ss_cost').val() == 0) {
        khali_bosta_ss_cost = '';
        khalibosta_cost = 0;
    } else {
        khali_bosta_ss_cost = `<p class="expense-item">খালী বস্তা: <span id="expense1">${formatter.format(parseFloat($('.khali_bosta_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`;
        khalibosta_cost = parseFloat($('.khali_bosta_ss_cost').val());
    }
    if ($('.trans_vara_ss_cost').val() == '' || $('.trans_vara_ss_cost').val() == 0) {
        trans_vara_ss_cost = '';
        transvara_cost = 0;
    } else {
        trans_vara_ss_cost = `<p class="expense-item">গাড়ি ভাড়া: <span id="expense1">${formatter.format(parseFloat($('.trans_vara_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`
        transvara_cost = parseFloat($('.trans_vara_ss_cost').val());
    }
    if ($('.trans_vara_agrim_ss_cost').val() == '' || $('.trans_vara_agrim_ss_cost').val() == 0) {
        trans_vara_agrim_ss_cost = '';
        transvara_agrim_cost = 0;
    } else {
        trans_vara_agrim_ss_cost = `<p class="expense-item">গাড়ি ভাড়া অগ্রীম: <span id="expense1">${formatter.format(parseFloat($('.trans_vara_agrim_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`
        transvara_agrim_cost = parseFloat($('.trans_vara_agrim_ss_cost').val());
    }
    if ($('.trans_commission_ss_cost').val() == '' || $('.trans_commission_ss_cost').val() == 0) {
        trans_commission_ss_cost = '';
        trans_commission_cost = 0;
    } else {
        trans_commission_ss_cost = `<p class="expense-item">গাড়ি কমিশন: <span id="expense1">${formatter.format(parseFloat($('.trans_commission_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`
        trans_commission_cost = parseFloat($('.trans_commission_ss_cost').val());
    }
    if ($('.others_ss_cost').val() == '' || $('.others_ss_cost').val() == 0) {
        others_ss_cost = '';
        others_cost = 0;
    } else {
        others_ss_cost = `<p class="expense-item">অন্যান্য খরচ : <span id="expense1">${formatter.format(parseFloat($('.others_ss_cost').val())).getDigitBanglaFromEnglish()}</span> টাকা</p>`
        others_cost = parseFloat($('.others_ss_cost').val());
    }

    /*
        $('.tr_all_input_box').each(function () {
            let ttl_bosta = parseFloat($(this).find('.ttl_bosta_box').val());
            let ttl_weight = parseFloat($(this).find('.ttl_weight_box_ss').val());
            let kg_rate = parseFloat($(this).find('.kg_rate_box_s').val());
            let ttl_rates = parseFloat($(this).find('.ttl_rates_this_rowss').val());
            ttl_sales_amnt_taka += ttl_rates;
    
            sales_htmlaaa += `<tr>
                                <td>${formatter.format(ttl_bosta).getDigitBanglaFromEnglish()} বস্তা</td>
                                <td>${formatter.format(ttl_weight).getDigitBanglaFromEnglish()} কেজি</td>
                                <td>${formatter.format(kg_rate).getDigitBanglaFromEnglish()} টাকা</td>
                                <td id="total-sale">${formatter.format(ttl_rates).getDigitBanglaFromEnglish()} টাকা</td>
                            </tr>`;
        });
    */
    $('.lot_names_assgng').each(function () {
        let pur_item_idd = $(this).attr('pur_item_id');
        let lot_name = $(this).text().trim();

        let total_bosta = 0;
        let total_weight = 0;
        let ttl_taka_amnt = 0;


        sales_htmlaaa += `<tr class="bg-info text-white ">
                            <td colspan="4">${lot_name}</td>
                        </tr>`;
        $('.' + pur_item_idd + '_lotBostas').each(function (i) {
            let ttl_bosta = parseFloat($(this).val());
            let ttl_weight = parseFloat($('.' + pur_item_idd + '_lotWeightss').eq(i).val());
            let kg_rate = parseFloat($('.' + pur_item_idd + '_lotRatess').eq(i).val());
            let ttl_rates = parseFloat($('.' + pur_item_idd + '_lotTotalRatess').eq(i).val());

            total_bosta += ttl_bosta;
            total_weight += ttl_weight;
            ttl_taka_amnt += ttl_rates;

            ttl_sales_amnt_taka += ttl_rates;
            sales_htmlaaa += `<tr>
                                <td>${formatter.format(ttl_bosta).getDigitBanglaFromEnglish()} বস্তা</td>
                                <td>${formatter.format(ttl_weight).getDigitBanglaFromEnglish()} কেজি</td>
                                <td>${formatter.format(kg_rate).getDigitBanglaFromEnglish()} টাকা</td>
                                <td id="total-sale">${formatter.format(ttl_rates).getDigitBanglaFromEnglish()} টাকা</td>
                            </tr>`;
        });

        sales_htmlaaa += `<tr class="subtotal-row bg-success  ">
                                <td align="center" style="font-size: 18px; font-weight: bold;">${formatter.format(total_bosta).getDigitBanglaFromEnglish()} বস্তা</td>
                                <td align="center" style="font-size: 18px; font-weight: bold;">${formatter.format(total_weight).getDigitBanglaFromEnglish()} কেজি</td>
                                <td align="center" style="font-size: 18px; font-weight: bold;" id="total-sale" colspan="2">${formatter.format(ttl_taka_amnt).getDigitBanglaFromEnglish()} টাকা</td>
                        </tr><tr><td colspan="4"></td></tr>`;

    });

    /*
    
    let html = '';
    
    $('.lot_names_assgng').each(function (i) {
    
        let lotTitle = $(this).attr('pur_item_id'); // বা যেটা তুমি হেডার হিসেবে দেখাতে চাও
    
        html += `<div class="lot-block border p-2 mb-3">
                    <h5>Lot ${i+1} (Item: ${lotTitle})</h5>
                    <ul>`;
    
        $(this).find('.pur_item').each(function () {
            let val = $(this).text().trim(); // যদি div/span হয়
            // যদি input হয় তাহলে: let val = $(this).val();
    
            html += `<li>${val}</li>`;
        });
    
        html += `   </ul>
                 </div>`;
    });
    
    $('#previewArea').html(html);
    
    
    */













    sales_khoroc_ss_cost = commission_cost + tahuri_cost + godivara_cost + gharkuli_cost + khalibosta_cost + transvara_cost + transvara_agrim_cost + trans_commission_cost + others_cost;
    let sorbomot_amount_taka = ttl_sales_amnt_taka - sales_khoroc_ss_cost

    $('.sales_commission_details_assign_ss').html(
        `<div class="col-md-6">
                        <h4 class="text-center">বিক্রয় তথ্য</h4>
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>বস্তা</th>
                                    <th>মোট ওজন</th>
                                    <th>দাম</th>
                                    <th>মোট টাকা</th>
                                </tr>
                            </thead>
                            <tbody class="sale_details_ss">
                                ${sales_htmlaaa}
                                <tr class="total-row">
                                    <td colspan="2" style="font-size: 22px; font-weight: bold;">মোট: </td>
                                    <td id="final-sale" colspan="2" style="font-size: 22px; font-weight: bold;">${formatter.format(ttl_sales_amnt_taka).getDigitBanglaFromEnglish()} টাকা</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="expense-box">
                            <h4>খরচের বিস্তারিত</h4>
                            ${ttl_commission_ss_cost}
                            ${tahuri_ss_cost}
                            ${godi_vara_ss_cost}
                            ${ghar_kuli_ss_cost}
                            ${khali_bosta_ss_cost}
                            ${trans_vara_ss_cost}
                            ${trans_vara_agrim_ss_cost}
                            ${trans_commission_ss_cost}
                            ${others_ss_cost}
                            <p class="costs-total">মোট খরচ: <span id="net-total">${formatter.format(sales_khoroc_ss_cost).getDigitBanglaFromEnglish()}</span> টাকা</p>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <p class="net-total ttl_amount_of_this_tran_s " amnt_s="${sorbomot_amount_taka}" ttl_amnt_of_cost="${sales_khoroc_ss_cost}" ttl_sales_amnts="${ttl_sales_amnt_taka}" >সর্বমোট টাকা: <span id="net-total  ">${formatter.format(sorbomot_amount_taka).getDigitBanglaFromEnglish()}</span> টাকা</p>
                    </div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-success btn_xl save_the_buying_commissionsss_s " >সেভ</button>
                    </div>
                    <br><br><br><br> `);
});

$(document).on('click', '.save_the_buying_commissionsss_s', function () {
    if (confirm("আপনি কি ক্রয় করতে চান ? ")) {
        $.ajax({
            type: "post",
            url: "tax/entry_of_purchasess_comissions_ss",
            data: {
                'pur_items_id[]': $('.tr_all_input_box').map(function () { return $(this).attr('pur_items_unq_auto_iddd'); }).get(),
                'pur_idd[]': $('.tr_all_input_box').map(function () { return $(this).attr('purchases_idd'); }).get(),
                'trans_pur_idd[]': $('.tr_all_input_box').map(function () { return $(this).attr('pur_trans_auto_iddds'); }).get(),
                'ttl_bosta_b[]': $('.ttl_bosta_box').map(function () { return this.value; }).get(),
                'ttl_weights[]': $('.ttl_weight_box_ss').map(function () { return this.value; }).get(),
                'kg_rate_box[]': $('.kg_rate_box_s').map(function () { return this.value; }).get(),
                'ttl_rates_t[]': $('.ttl_rates_this_rowss').map(function () { return this.value; }).get(),
                'supp_ids': $('.supp_select_unq_idds option:selected').val(),
                'transport_id': $('.trans_port_id').attr('trans_id'),
                'commission_cost': $('.ttl_commission_ss_cost').val(),
                'tahuri_cost': $('.tahuri_ss_cost').val(),
                'godi_vara_cost': $('.godi_vara_ss_cost').val(),
                'ghar_kuli_cost': $('.ghar_kuli_ss_cost').val(),
                'khali_bosta_cost': $('.khali_bosta_ss_cost').val(),
                'trans_vara_cost': $('.trans_vara_ss_cost').val(),
                'trans_agrim_cost': $('.trans_vara_agrim_ss_cost').val(),
                'trans_comsn_cost': $('.trans_commission_ss_cost').val(),
                'others_cost': $('.others_ss_cost').val(),
                'ttl_amnt_sss': $('.ttl_amount_of_this_tran_s').attr('amnt_s'),
                'amnt_cost_ss': $('.ttl_amount_of_this_tran_s').attr('ttl_amnt_of_cost'),
                'sales_amnt_s': $('.ttl_amount_of_this_tran_s').attr('ttl_sales_amnts')
            },
            beforeSend: function () {
                $('.spiner_load_activity').css('display', 'block');
            },
            complete: function () {
                $('.spiner_load_activity').css('display', 'none');
            },
            success: function (rqs) {

                if (rqs == 0) {
                    toastr["error"]("ভুল হয়েছে চেক করুন। ");
                } else {
                    $('.supp_datas_info_assignss').html('');
                    $('.lot_info_assign_nav').html('');
                    $('.all_data_infos_cal_assign').html('');

                    $('.assign_item_lot_s').html('');
                    $('.sales_infos_assign_ing_cls').css('display', 'none');
                    $('.append_contain_boxs').html(``);
                    $('.sales_commission_details_assign_ss').html(``);

                    toastr["success"]("আপনার ক্রয় কমিশন সম্পন্ন হয়েছে। ");
                    Swal.fire({
                        title: "<strong>ক্রয় কমিশন</strong>",
                        icon: "success",
                        html: `আপনার ক্রয় কমিশন সম্পন্ন হয়েছে, আপনি স্লিপ প্রিন্ট করে নেন <br> <a class="btn btn-info" onclick="window.open('tax/purchase_comission_receipt_view_fun?pur_cmns_id=${rqs}','_blank', 'width=800,height=800,left=300,top=300')" style="font-size: 18px; " > Print </a>`,
                        showConfirmButton: false,
                    });
                }

            }
        });
    } else {
        return false;
    }
});


