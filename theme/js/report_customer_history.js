

$(document).on('click', '.serching_btn_this', function () {

    if ($('.start_datess').val() == '' || $('.ending_dates').val() == '' || $('.customer_selecting_id').val() == '') {
        toastr["error"]("সব তথ্য সিলেক্ট করুন। ");
    } else {
        $.ajax({
            type: "post",
            url: "customers/searching_customer_history_date_date",
            data: {
                start_date: $('.start_datess').val(),
                end_date: $('.ending_dates').val(),
                customer_id: $('.customer_selecting_id').val()
            },
            beforeSend: function () {
                $('.spiner_load_activity').css('display', 'block');
            },
            complete: function () {
                $('.spiner_load_activity').css('display', 'none');
            },
            success: function (rs) {
                let table_tr_assign = '';
                let table_data = [];
                let tm = 0;

                // let cust_payment = get_cash_paid_by_date_to_date($('.start_datess').val(), $('.ending_dates').val(), $('.customer_selecting_id').val());
                // let cust_payments_list_json = JSON.parse(cust_payment);
                // let cust_payments_list = cust_payments_list_json.customer_payments; 
                let n = 0;

                for (n = 0; n < rs.sales_info.length; n++) {
                    let sales_item_data = get_sales_item_infos_by_sales_id(rs.sales_info[n].id);
                    let sales_item_info = JSON.parse(sales_item_data);
                    let sales_item_calc_assigns = '';

                    for (let i = 0; i < sales_item_info.length; i++) {
                        sales_item_calc_assigns += `<p>${sales_item_info[i].ref_lot_no} - ${formatter.format(sales_item_info[i].price_per_kg).getDigitBanglaFromEnglish()}/- - ${formatter.format(sales_item_info[i].sales_qnty_bostas).getDigitBanglaFromEnglish()}${sales_item_info[i].unit_name} -- ${formatter.format(sales_item_info[i].ttl_sale_kgs_this_product).getDigitBanglaFromEnglish()}কেজি</p>`;
                    }

                    table_data.push({
                        serial: n + 1,
                        view: `<a class="btn btn-sm btn-info" href="sales/sales_receipt_view_fun?sales_id=${rs.sales_info[n].id}" target="_blank" ><i class="fa fa-print"></i></a>`,
                        date: rs.sales_info[n].sales_date,
                        details: sales_item_calc_assigns,
                        pre_amnt: formatter.format(rs.sales_info[n].cus_previous_amount_ttl).getDigitBanglaFromEnglish(),
                        total_sales_price: formatter.format(rs.sales_info[n].ttl_sales_prices).getDigitBanglaFromEnglish(),
                        laber_costs: rs.sales_info[n].sales_lebar_cost_sss ? `লেবার খরচ ` + formatter.format(rs.sales_info[n].sales_lebar_cost_sss).getDigitBanglaFromEnglish() : '',
                        ghat_vara_costs: rs.sales_info[n].sales_ghat_vara_cost ? `ঘাট খরচ ` + formatter.format(rs.sales_info[n].sales_ghat_vara_cost).getDigitBanglaFromEnglish() : '',
                        sales_discount: rs.sales_info[n].sales_ttl_dis_countss ? `ডিসকাউন্ট ` + formatter.format(rs.sales_info[n].sales_ttl_dis_countss).getDigitBanglaFromEnglish() : '',
                        pai_amnt: formatter.format(rs.sales_info[n].paid_amount).getDigitBanglaFromEnglish(),
                        due_now: formatter.format(rs.sales_info[n].cus_ttl_due_s_now).getDigitBanglaFromEnglish(),
                        times: rs.sales_info[n].created_time,
                        sales_status: rs.sales_info[n].sales_status,
                        sales_comission_check_this: rs.sales_info[n].sales_comission_check_this,
                        typess_ss: 'sales'
                    });
                }

                for (let mn = 0; mn < rs.customer_payments.length; mn++) {
                    table_data.push({
                        serial: n++,
                        view: `জমা হয়েছে`,
                        date: rs.customer_payments[mn].payment_date,
                        details: rs.customer_payments[mn].payment_type,
                        pre_amnt: formatter.format(rs.customer_payments[mn].cust_prev_amntss).getDigitBanglaFromEnglish(),
                        total_sales_price: '০',
                        laber_costs: '',
                        ghat_vara_costs: '',
                        sales_discount: '',
                        pai_amnt: formatter.format(rs.customer_payments[mn].payment).getDigitBanglaFromEnglish(),
                        due_now: formatter.format(rs.customer_payments[mn].cust_now_due_amntsss).getDigitBanglaFromEnglish(),
                        times: rs.customer_payments[mn].created_time,
                        sales_status: '',
                        sales_comission_check_this: '',
                        typess_ss: 'cus_pay'
                    });
                }

                for (let mn = 0; mn < rs.haolat_info.length; mn++) {
                    if (rs.haolat_info[mn].types_payable == 1) {
                        table_data.push({
                            serial: n++,
                            view: `হাওলাত`,
                            date: rs.haolat_info[mn].due_sales_dates_times,
                            details: `হাওলাত দেওয়া হয়েছে`,
                            pre_amnt: formatter.format(rs.haolat_info[mn].cust_prev_duesss).getDigitBanglaFromEnglish(),
                            total_sales_price: '০',
                            laber_costs: '',
                            ghat_vara_costs: '',
                            sales_discount: '',
                            pai_amnt: formatter.format(rs.haolat_info[mn].sales_paidable_amount_sss).getDigitBanglaFromEnglish(),
                            due_now: formatter.format(rs.haolat_info[mn].ttl_due_now_ss_sales_ssss).getDigitBanglaFromEnglish(),
                            times: rs.haolat_info[mn].create_entry_timessstmp,
                            sales_status: '',
                            sales_comission_check_this: '',
                            typess_ss: 'haolat'
                        });
                    } else if (rs.haolat_info[mn].types_payable == 3) {
                        table_data.push({
                            serial: n++,
                            view: `সাবেক`,
                            date: rs.haolat_info[mn].due_sales_dates_times,
                            details: rs.haolat_info[mn].pays_descriptions + ' - ' + formatter.format(rs.haolat_info[mn].sales_paidable_amount_sss).getDigitBanglaFromEnglish(),
                            pre_amnt: formatter.format(rs.haolat_info[mn].cust_prev_duesss).getDigitBanglaFromEnglish(),
                            total_sales_price: formatter.format(rs.haolat_info[mn].sales_paidable_amount_sss).getDigitBanglaFromEnglish(),
                            laber_costs: '',
                            ghat_vara_costs: '',
                            sales_discount: '',
                            pai_amnt: '',
                            due_now: formatter.format(rs.haolat_info[mn].ttl_due_now_ss_sales_ssss).getDigitBanglaFromEnglish(),
                            times: rs.haolat_info[mn].create_entry_timessstmp,
                            sales_status: '',
                            sales_comission_check_this: '',
                            typess_ss: 'haolat'
                        });
                    }
                }

                for (let ias = 0; ias < rs.parchase_info.length; ias++) {
                    let purchase_item_data = get_purchase_item_info_by_purchase_trans_id(rs.parchase_info[ias].db_purchase_transports_info_a_idd);
                    let purchase_item_info = JSON.parse(purchase_item_data);

                    let purchase_item_calc_assigns = '';
                    for (let i = 0; i < purchase_item_info.length; i++) {
                        purchase_item_calc_assigns += `<p>${purchase_item_info[i].ref_lot_no} - ${formatter.format(purchase_item_info[i].price_per_unit).getDigitBanglaFromEnglish()}/- - ${formatter.format(purchase_item_info[i].purchase_total_bosta).getDigitBanglaFromEnglish()}${purchase_item_info[i].unit_name}</p>`;
                    }
                    table_data.push({
                        serial: n++,
                        view: `<a data-toggle="modal" data-target="#supp_cust_repor_modal" class="btn btn-sm btn-danger view_selling_infos " id_attr="${rs.parchase_info[ias].db_purchase_transports_info_a_idd}" >ক্রয়</a>`,
                        date: rs.parchase_info[ias].pur_date_timsssss,
                        details: purchase_item_calc_assigns,
                        pre_amnt: formatter.format(rs.parchase_info[ias].supp_pre_amtssss).getDigitBanglaFromEnglish(),
                        total_sales_price: '০',
                        laber_costs: '',
                        ghat_vara_costs: '',
                        sales_discount: '',
                        pai_amnt: formatter.format(rs.parchase_info[ias].total_trans_price).getDigitBanglaFromEnglish(),
                        due_now: formatter.format(rs.parchase_info[ias].supp_now_due_amnt_ssssss).getDigitBanglaFromEnglish(),
                        times: rs.parchase_info[ias].now_timess,
                        sales_status: '',
                        sales_comission_check_this: '',
                        typess_ss: 'pur_info'
                    });
                }

                for (let asias = 0; asias < rs.commission_entry_info.length; asias++) {
                    let commission_item_data = get_commission_item_info_by_commission_entry_id(rs.commission_entry_info[asias].sales_commission_submited_info_iddd);
                    let commission_item_info = JSON.parse(commission_item_data);

                    let commission_item_calc_assigns = '';
                    for (let i = 0; i < commission_item_info.length; i++) {
                        commission_item_calc_assigns += `<p class="">${commission_item_info[i].ref_lot_no} - ${formatter.format(commission_item_info[i].saling_prices_sssss_per_kgsss).getDigitBanglaFromEnglish()}/- - ${formatter.format(commission_item_info[i].ttl_sales_bosta_asaaaa).getDigitBanglaFromEnglish()}${commission_item_info[i].unit_name} - ${formatter.format(commission_item_info[i].ttl_sales_weight_kgs_aaa).getDigitBanglaFromEnglish()}কেজি</p>`;
                    }
                    table_data.push({
                        serial: n++,
                        view: `<a class="btn btn-sm btn-info" href="sales/sales_receipt_view_fun?sales_id=${rs.commission_entry_info[asias].sales_unqqq_idd_autosss}" target="_blank" ><i class="fa fa-print"></i></a><a class="btn btn-sm btn-warning" href="tax/sales_commission_receipt_view?sales_commission_id=${rs.commission_entry_info[asias].sales_commission_submited_info_iddd}" target="_blank" ><i class="fa fa-print"></i></a>`,
                        date: rs.commission_entry_info[asias].cr_dating_setsss,
                        details: `বিক্রির তারিখঃ <b>${rs.commission_entry_info[asias].sales_date}</b> <br>${commission_item_calc_assigns}`,
                        pre_amnt: formatter.format(rs.commission_entry_info[asias].cust_previous_amount_addss).getDigitBanglaFromEnglish(),
                        total_sales_price: formatter.format(rs.commission_entry_info[asias].ttl_amount_of_sales_taka).getDigitBanglaFromEnglish(),
                        laber_costs: rs.commission_entry_info[asias].ghar_kuli_cost_saaas ? `লেবার খরচ ` + formatter.format(rs.commission_entry_info[asias].ghar_kuli_cost_saaas).getDigitBanglaFromEnglish() : '',
                        ghat_vara_costs: rs.commission_entry_info[asias].sales_comsn_cost_amountssss ? `কমিশন ` + formatter.format(rs.commission_entry_info[asias].sales_comsn_cost_amountssss).getDigitBanglaFromEnglish() : '',
                        sales_discount: '',
                        pai_amnt: '0',
                        due_now: formatter.format(rs.commission_entry_info[asias].cust_now_amount_after_commission_entryss).getDigitBanglaFromEnglish(),
                        times: rs.commission_entry_info[asias].cr_timessss,
                        sales_status: '',
                        sales_comission_check_this: 4,
                        typess_ss: 'com_entry'
                    });
                }


                // তারিখ এবং times অনুযায়ী ডেটা sort করা
                table_data.sort((a, b) => {
                    let dateA = new Date(a.date);
                    let dateB = new Date(b.date);

                    // প্রথমে তারিখ অনুযায়ী sort
                    if (dateA - dateB !== 0) {
                        return dateA - dateB;
                    }
                    // যদি তারিখ একই হয়, তখন times অনুযায়ী sort
                    // যদি time null বা undefined হয়, তাহলে আগে চেক করুন
                    // return (a.times === null ? "" : a.times).localeCompare(b.times === null ? "" : b.times, undefined, { numeric: true });
                    return a.times && b.times ? a.times.localeCompare(b.times, undefined, { numeric: true }) : 0;

                });
                // তারিখ অনুযায়ী ডেটা sort করা
                table_data.sort((a, b) => new Date(a.date) - new Date(b.date));


                // টেবিল পুনরায় তৈরি করা এবং সঠিক সিরিয়াল সেট করা
                table_data.forEach((data, index) => {
                    if (data.sales_status == 2 && data.sales_comission_check_this == 0) {
                        table_tr_assign += `<tr class="bg-success">
                                                <td class="text-center vertical-middle">${index + 1}</td>
                                                <td class="text-center vertical-middle" >${data.view}</td>
                                                <td class="text-center vertical-middle">${data.date}</td>
                                                <td >${data.details}</td>
                                                <td class="text-center vertical-middle"></td>
                                                <td class="text-center vertical-middle">প্রস্তাবিতঃ- ${data.total_sales_price}</td>
                                                <td class="text-center vertical-middle">${data.laber_costs} <br> ${data.ghat_vara_costs} <br> ${data.sales_discount} </td>
                                                <td class="text-center vertical-middle">${data.pai_amnt}</td>
                                                <td class="text-center vertical-middle"></td>
                                                <td class="text-center vertical-middle"></td>
                                            </tr>`;
                    } else if (data.sales_status == 2 && data.sales_comission_check_this == 1) {
                        table_tr_assign += `<tr class="">
                                                <td class="text-center vertical-middle">${index + 1}</td>
                                                <td class="text-center vertical-middle" >${data.view}</td>
                                                <td class="text-center vertical-middle">${data.date}</td>
                                                <td >${data.details}</td>
                                                <td class="text-center vertical-middle"><b>এন্ট্রি </b></td>
                                                <td class="text-center vertical-middle"><b> হয়েছে</b></td>
                                                <td class="text-center vertical-middle">-</td>
                                                <td class="text-center vertical-middle">-</td>
                                                <td class="text-center vertical-middle"></td>
                                                <td class="text-center vertical-middle"></td>
                                            </tr>`;
                    } else {
                        table_tr_assign += `<tr >
                                                <td class="text-center vertical-middle">${index + 1}</td>
                                                <td class="text-center vertical-middle" >${data.view}</td>
                                                <td class="text-center vertical-middle">${data.date}</td>
                                                <td >${data.details}</td>
                                                <td class="text-center vertical-middle">${data.pre_amnt}</td>
                                                <td class="text-center vertical-middle">${data.total_sales_price}</td>
                                                <td class="text-center vertical-middle">${data.laber_costs} <br> ${data.ghat_vara_costs} <br> ${data.sales_discount} </td>
                                                <td class="text-center vertical-middle">${data.pai_amnt}</td>
                                                <td class="text-center vertical-middle">${data.due_now}</td>
                                                <td class="text-center vertical-middle"></td>
                                            </tr>`;
                    }
                });


                $('.sales_infos_data_assigns').html(table_tr_assign);
                $('.cust_pre_amnt').html(formatter.format(rs.customer_info.sales_due).getDigitBanglaFromEnglish());
                $('.cust_name').html(rs.customer_info.customer_name);
                $('.cust_mobile').html(rs.customer_info.mobile);
                $('.cust_address').html(rs.customer_info.address);
            }
        });
    }
});

function get_sales_item_infos_by_sales_id(sales_id) {
    return $.ajax({
        type: "post",
        url: "sales/get_sales_item_by_sales_id",
        data: {
            sales_id: sales_id
        },
        beforeSend: function () {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function () {
            $('.spiner_load_activity').css('display', 'none');
        },
        async: false
    }).responseText;
}

function get_cash_paid_by_date_to_date(st_date, ed_dates, custID) {
    return $.ajax({
        type: "post",
        url: "customers/get_cash_paid_by_dates",
        data: {
            start_date: st_date,
            end_date: ed_dates,
            customer_id: custID
        },
        beforeSend: function () {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function () {
            $('.spiner_load_activity').css('display', 'none');
        },
        async: false
    }).responseText;
}

function get_commission_item_info_by_commission_entry_id(commission_id) {
    return $.ajax({
        type: "post",
        url: "customers/get_sales_commission_item_info_by_coms_id",
        data: {
            commission_id: commission_id
        },
        beforeSend: function () {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function () {
            $('.spiner_load_activity').css('display', 'none');
        },
        async: false
    }).responseText;
}

function get_purchase_item_info_by_purchase_trans_id(pur_id) {
    return $.ajax({
        type: "post",
        url: "customers/get_all_purchase_item_info_by_trans_id",
        data: {
            pur_trans_id: pur_id
        },
        beforeSend: function () {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function () {
            $('.spiner_load_activity').css('display', 'none');
        },
        async: false
    }).responseText;
}

$(document).on('click', '.view_selling_infos', function () {
    $.ajax({
        type: "post",
        url: "suppliers/view_salling_infos_by_trans_puurchase_id_p",
        data: {
            trans_id: $(this).attr('id_attr')
        },
        beforeSend: function () {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function () {
            $('.spiner_load_activity').css('display', 'none');
        },
        success: function (rpn) {
            let salling_items_assign_arry = '';
            $('.supp_name_ss').html(`${rpn.trans_infos.customer_name} <span class="supp_addrs_ss" style="font-size: 18px;">${rpn?.trans_infos?.address && rpn.trans_infos.address || ''}</span>`);
            $('.pur_datesss').html(rpn.trans_infos.pur_date_timsssss);

            for (let klm = 0; klm < rpn.sales_item_infos.length; klm++) {
                salling_items_assign_arry += `<li style="padding: 15px; background: white; margin-bottom: 10px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; cursor: pointer; " class="toggle-details " data-target="#customer${klm}Details"  >
                            <span>
                                <strong>${rpn.sales_item_infos[klm].payment_datesss}</strong>
                            </span>
                            <span>
                            <strong>${rpn.sales_item_infos[klm].customer_name}</strong> (<small>${rpn.sales_item_infos[klm].address}</small>)
                            </span>
                            <span>
                                <strong>${rpn.sales_item_infos[klm].ref_lot_no}</strong>
                            </span>
                            <span>
                                ${rpn.sales_item_infos[klm].sales_qnty_bostas.getDigitBanglaFromEnglish()} বস্তা
                            </span> 
                        </li>
                        <!-- Collapsible Content for Customer F -->
                    <div id="customer${klm}Details" class="collapse-content" style="padding: 10px; background: #f8f9fa; margin-bottom: 10px; border-radius: 10px; display: none;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 5px;">${rpn.sales_item_infos[klm].ref_lot_no}</li>
                            <li style="padding: 5px;">${rpn.sales_item_infos[klm].sales_qnty_bostas.getDigitBanglaFromEnglish()} বস্তা</li>

                            <li style="padding: 5px;">মোট ${formatter.format(rpn.sales_item_infos[klm].ttl_sale_kgs_this_product).getDigitBanglaFromEnglish()} কেজি</li> 

                            <li style="padding: 5px;">১ বস্তায় ${formatter.format(rpn.sales_item_infos[klm].sales_kgs_perbosta).getDigitBanglaFromEnglish()} কেজি</li>
                            <li style="padding: 5px;">প্রতি কেজির বিক্রয় দাম ${formatter.format(rpn.sales_item_infos[klm].price_per_kg).getDigitBanglaFromEnglish()} টাকা</li>
                        </ul>
                    </div>`;
            }
            $('.customer_list_html_assign').html(salling_items_assign_arry);
        }
    });
});









