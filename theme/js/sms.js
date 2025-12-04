 
$(document).on('click', '.search_sale_report', function () {
	let select_dates = $('.searching_input_dates_val').val();
  
	if (select_dates == '') {
	  toastr["warning"]("তারিখ সিলেক্ট করুন।"); 
	}else{
        $.ajax({
            type: "post",
            url: "reports/send_cust_sms_query_by_date", 
            data: {
                select_dates: select_dates
            },
            beforeSend: function() {
                $('.spiner_load_activity').css('display', 'block');
            }, 
            complete: function() {
                $('.spiner_load_activity').css('display', 'none');
            },
            success: function (r) {
                $('.date_assgn').html(select_dates.getDigitBanglaFromEnglish());

                let sales_data = '';
                let payment_data = '';
                let table_tr_assign = '';
                let table_data = [];
                let la = 0;

                for (la = 0; la < r.sales_date_date.length; la++) {
                    
                    let pre_textps = '';
                    let now_textps = '';
                    
                    if (parseFloat(r.sales_date_date[la].cus_previous_amount_ttl) < 0) {
                        pre_textps = 'পূর্বের জমা';
                    }else {
                        pre_textps = 'পূর্বের বাকি';
                    }
                    if (parseFloat(r.sales_date_date[la].cus_ttl_due_s_now) < 0) {
                        now_textps = 'বর্তমান জমা';
                    }else {
                        now_textps = 'বর্তমান বাকি';
                    }

                    let sales_item_data = get_sales_item_infos_by_sales_id(r.sales_date_date[la].id);
                    let sales_item_info = JSON.parse(sales_item_data);
                    let el = '';
                    let sales_lebar_cost_sss = 0;
                    let sales_ghat_vara_cost = 0;
                    if (r.sales_date_date[la].sales_lebar_cost_sss == '') {
                        sales_lebar_cost_sss = 0;
                    } else {
                        sales_lebar_cost_sss = parseFloat(r.sales_date_date[la].sales_lebar_cost_sss);
                    }
                    if (r.sales_date_date[la].sales_ghat_vara_cost == '') {
                        sales_ghat_vara_cost = 0;
                    } else {
                        sales_ghat_vara_cost = parseFloat(r.sales_date_date[la].sales_ghat_vara_cost);
                    }
                    for (let ind = 0; ind < sales_item_info.length; ind++) {
                        el += `${sales_item_info[ind].ref_lot_no}-${(sales_item_info[ind].sales_qnty_bostas).getDigitBanglaFromEnglish()}/${(sales_item_info[ind].ttl_sale_kgs_this_product).getDigitBanglaFromEnglish()}×${(sales_item_info[ind].price_per_kg).getDigitBanglaFromEnglish()}`; 
                    }
                    let todays_sales = parseFloat(r.sales_date_date[la].ttl_sales_prices) + parseFloat(r.sales_date_date[la].sales_lebar_cost_sss) + parseFloat(r.sales_date_date[la].sales_ghat_vara_cost); 
                    
                    let ttl_cost = sales_lebar_cost_sss + sales_ghat_vara_cost;
                    let messeg = `${r.company_info.company_name}%0A%0Aবিস্তারিত: ${(r.sales_date_date[la].sales_date).getDigitBanglaFromEnglish()} %0A${el}%0Aমোট খরচ=${ttl_cost.toString().getDigitBanglaFromEnglish()}%0Aআজকের ক্রয়=${(r.sales_date_date[la].ttl_sales_prices).getDigitBanglaFromEnglish()}%0A${pre_textps}=${(r.sales_date_date[la].cus_previous_amount_ttl).getDigitBanglaFromEnglish()}%0Aজমা=${(r.sales_date_date[la].sales_paid_able_amnt).getDigitBanglaFromEnglish()}%0A${now_textps}=${(r.sales_date_date[la].cus_ttl_due_s_now).getDigitBanglaFromEnglish()}`

                    table_data.push({
                        serial: la + 1,
                        date: r.sales_date_date[la].sales_date,
                        times: r.sales_date_date[la].created_time,
                        view: `<a href="sms:${r.sales_date_date[la].mobile}?body=${messeg}" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px; color: black; " ><i  class="fa fa-envelope"></i></a> 
                                                    <a href="intent://send?phone=88${r.sales_date_date[la].whatsApp_number}&text=${messeg}#Intent;scheme=whatsapp;package=com.whatsapp;action=android.intent.action.VIEW;end;" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px;  color: black; " ><i  class="fa fa-whatsapp"></i></a>`,
                        cust_info: `${r.sales_date_date[la].customer_name} - ${r.sales_date_date[la].address}`,
                        pre_amnt: formatter.format(r.sales_date_date[la].cus_previous_amount_ttl).getDigitBanglaFromEnglish(),
                        sales_details: el,
                        sales_price: formatter.format(r.sales_date_date[la].ttl_sales_prices).getDigitBanglaFromEnglish(),
                        pai_amnt: formatter.format(r.sales_date_date[la].paid_amount).getDigitBanglaFromEnglish(),
                        due_now: formatter.format(r.sales_date_date[la].cus_ttl_due_s_now).getDigitBanglaFromEnglish()
                    });   
                }

                for (let de = 0; de < r.sales_payments.length; de++) {  
                    
                    let pre_textp = '';
                    let now_textp = '';
                    if (parseFloat(r.sales_payments[de].cust_prev_amntss) < 0) {
                        pre_textp = 'পূর্বের জমা';
                    }else {
                        pre_textp = 'পূর্বের বাকি';
                    }
                    if (parseFloat(r.sales_payments[de].cust_now_due_amntsss) < 0) {
                        now_textp = 'বর্তমান জমা';
                    }else {
                        now_textp = 'বর্তমান বাকি';
                    }

                    let p_messeg = `${r.company_info.company_name}%0A${(r.sales_payments[de].payment_date).getDigitBanglaFromEnglish()}%0A${pre_textp}=${(r.sales_payments[de].cust_prev_amntss).getDigitBanglaFromEnglish()}%0Aজমা=${(r.sales_payments[de].payment).getDigitBanglaFromEnglish()}%0A${now_textp}=${(r.sales_payments[de].cust_now_due_amntsss).getDigitBanglaFromEnglish()}`
                    table_data.push({
                        serial: la++,
                        date: r.sales_payments[de].payment_date,
                        times: r.sales_payments[de].created_time,
                        view: `<a href="sms:${r.sales_payments[de].mobile}?body=${p_messeg}" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px; color: black; " ><i  class="fa fa-envelope"></i></a> 
                                                    <a href="intent://send?phone=88${r.sales_payments[de].whatsApp_number}&text=${p_messeg}#Intent;scheme=whatsapp;package=com.whatsapp;action=android.intent.action.VIEW;end;" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px;  color: black; " ><i  class="fa fa-whatsapp"></i></a> `,
                        cust_info: `${r.sales_payments[de].customer_name} - ${r.sales_payments[de].address}`,
                        pre_amnt: formatter.format(r.sales_payments[de].cust_prev_amntss).getDigitBanglaFromEnglish(),
                        sales_details: r.sales_payments[de].payment_type,
                        sales_price: '',
                        pai_amnt: formatter.format(r.sales_payments[de].payment).getDigitBanglaFromEnglish(),
                        due_now: formatter.format(r.sales_payments[de].cust_now_due_amntsss).getDigitBanglaFromEnglish()
                    });  
                    
                }

                for (let des = 0; des < r.cust_buys.length; des++) {  

                    let pre_texts = '';
                    let now_texts = '';

                    if (parseFloat(r.cust_buys[des].supp_pre_amtssss) < 0) {
                        pre_texts = 'পূর্বের জমা';
                    }else { 
                        pre_texts = 'পূর্বের বাকি';
                    }
                    if (parseFloat(r.cust_buys[des].supp_now_due_amnt_ssssss) < 0) {
                        now_texts = 'বর্তমান জমা';
                    }else {
                        now_texts = 'বর্তমান বাকি';
                    }

                    let p_messeg = `${r.company_info.company_name}%0A${(r.cust_buys[des].pur_date_timsssss).getDigitBanglaFromEnglish()}%0Aবিস্তারিতঃ%0A  ${(r.cust_buys[des].lot_trns_ref_nop_s)}||${(r.cust_buys[des].ttl_item_kg_trans)}কেজি||${(r.cust_buys[des].total_trans_price).getDigitBanglaFromEnglish()} টাকা%0A${pre_texts}=${(r.cust_buys[des].supp_pre_amtssss).getDigitBanglaFromEnglish()}%0A${now_texts}=${(r.cust_buys[des].supp_now_due_amnt_ssssss).getDigitBanglaFromEnglish()}` 

                    table_data.push({
                        serial: la++,
                        date: r.cust_buys[des].pur_date_timsssss,
                        times: r.cust_buys[des].now_timess,
                        view: `<a href="sms:${r.cust_buys[des].mobile}?body=${p_messeg}" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px; color: black; " ><i  class="fa fa-envelope"></i></a> 
                                                    <a href="intent://send?phone=88${r.cust_buys[des].whatsApp_number}&text=${p_messeg}#Intent;scheme=whatsapp;package=com.whatsapp;action=android.intent.action.VIEW;end;" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px;  color: black; " ><i  class="fa fa-whatsapp"></i></a> `,
                        cust_info: `${r.cust_buys[des].customer_name} - ${r.cust_buys[des].address}`,
                        pre_amnt: formatter.format(r.cust_buys[des].supp_pre_amtssss).getDigitBanglaFromEnglish(),
                        sales_details: 'কাস্টমার থেকে ক্রয়',
                        sales_price: '',
                        pai_amnt: formatter.format(r.cust_buys[des].unpaid_amount_this_trans_tk).getDigitBanglaFromEnglish(),
                        due_now: formatter.format(r.cust_buys[des].supp_now_due_amnt_ssssss).getDigitBanglaFromEnglish()
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
                    table_tr_assign += `<tr >
                                            <td class="text-center vertical-middle">${index + 1}</td>
                                            <td class="text-center vertical-middle" >${data.view}</td>
                                            <td class="text-center vertical-middle">${data.cust_info}</td>
                                            <td class="text-center vertical-middle">${data.pre_amnt}</td>
                                            <td >${data.sales_details}</td>
                                            <td class="text-center vertical-middle">${data.sales_price}</td>
                                            <td class="text-center vertical-middle">${data.pai_amnt}</td>
                                            <td class="text-center vertical-middle">${data.due_now}</td>
                                        </tr>`;
                });
                $('.sales_datas_assgn_htmls').html(table_tr_assign);
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
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
        async: false
    }).responseText;
}




$(document).on('click', '.search_amanot_person_datasss', function () { 
    $('.date_assgn').html($('.searching_input_dates_val').val().getDigitBanglaFromEnglish());

    if ($('.searching_input_dates_val').val() == '') {
        toastr["warning"]("তারিখ সিলেক্ট করুন।");
    }else {
        $.ajax({
            type: "post",
            url: "payment_types/send_amanot_person_sms_query_by_date",
            data: {
                select_dates: $('.searching_input_dates_val').val(),
            },
            beforeSend: function() {
                $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
                $('.spiner_load_activity').css('display', 'none');
            },
            // dataType: "dataType",
            success: function (res) {  

                // added_amanot
                // giving_amanot

                let table_tr_assign = '';
                let table_data = [];
                let srl = 0;

                for (srl = 0; srl < res.added_amanot.length; srl++) { 
                    
                    let amanot_person_infos = get_amanot_person_full_info_by_idd(res.added_amanot[srl].id_person_unq, $('.searching_input_dates_val').val());
                    let amanot_person_info = JSON.parse(amanot_person_infos); 

                    // amanot_person_info?.ttl_prev_taking_amount ?? 0

                    let prev_ttl_amnt = parseFloat(amanot_person_info?.ttl_prev_taking_amount ?? 0) - parseFloat(amanot_person_info?.ttl_prev_cutting_amount ?? 0); 
                    let select_ttl_amnt = parseFloat(amanot_person_info?.ttl_select_taking_amount ?? 0) - parseFloat(amanot_person_info?.ttl_select_cutting_amount ?? 0); 

                    let p_messeg = `${res.company_info.company_name}%0Aতারিখঃ${(res.added_amanot[srl].amanot_dates).getDigitBanglaFromEnglish()}%0Aআজকের জমা=${(res.added_amanot[srl].taking_amounts).getDigitBanglaFromEnglish()}%0Aবর্তমান হিসাব=${(select_ttl_amnt).toString().getDigitBanglaFromEnglish()}%0A%0A বিস্তারিতঃ ${res.added_amanot[srl].amanot_marfot}`;  

                    table_data.push({
                        serial: srl + 1,
                        date: res.added_amanot[srl].amanot_dates,
                        times: res.added_amanot[srl].cr_timings,
                        person: amanot_person_info.amanot_person_info.amanot_person_name_full,
                        view: `<a href="sms:${amanot_person_info.amanot_person_info.person_mobile_nosss}?body=${p_messeg}" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px; color: black; " ><i  class="fa fa-envelope"></i></a> 
                                                    <a href="intent://send?phone=88${amanot_person_info.amanot_person_info.person_whatsapp_no_set}&text=${p_messeg}#Intent;scheme=whatsapp;package=com.whatsapp;action=android.intent.action.VIEW;end;" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px;  color: black; " ><i  class="fa fa-whatsapp"></i></a> `,
                        pre_amnt: formatter.format(prev_ttl_amnt).toString().getDigitBanglaFromEnglish(),
                        pai_amnt: formatter.format(res.added_amanot[srl].taking_amounts).getDigitBanglaFromEnglish(),
                        marfot: res.added_amanot[srl].amanot_marfot,
                        due_now: formatter.format(select_ttl_amnt).toString().getDigitBanglaFromEnglish()
                    });
                    
                }

                for (let de = 0; de < res.giving_amanot.length; de++) {    
                    let amanot_person_infos = get_amanot_person_full_info_by_idd(res.giving_amanot[de].id_unq_person, $('.searching_input_dates_val').val());
                    let amanot_person_info = JSON.parse(amanot_person_infos); 

                    let prev_ttl_amnt = parseFloat(amanot_person_info?.ttl_prev_taking_amount ?? 0) - parseFloat(amanot_person_info?.ttl_prev_cutting_amount ?? 0); 
                    let select_ttl_amnt = parseFloat(amanot_person_info?.ttl_select_taking_amount ?? 0) - parseFloat(amanot_person_info?.ttl_select_cutting_amount ?? 0);

                    let p_messeg = `${res.company_info.company_name}%0Aতারিখঃ${(res.giving_amanot[de].amanot_give_datess).getDigitBanglaFromEnglish()}%0Aআজকের খরচ=${(res.giving_amanot[de].giving_amnt).getDigitBanglaFromEnglish()}%0Aবর্তমান হিসাব=${(select_ttl_amnt).toString().getDigitBanglaFromEnglish()}%0A%0A বিস্তারিতঃ ${res.giving_amanot[de].amanot_marfot_take}`;  

                    table_data.push({ 
                        serial: srl++,
                        date: res.giving_amanot[de].amanot_give_datess,
                        times: res.giving_amanot[de].entryss_timesss,
                        person: amanot_person_info.amanot_person_info.amanot_person_name_full,
                        view: `<a href="sms:${amanot_person_info.amanot_person_info.person_mobile_nosss}?body=${p_messeg}" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px; color: black; " ><i  class="fa fa-envelope"></i></a> 
                                                    <a href="intent://send?phone=88${amanot_person_info.amanot_person_info.person_whatsapp_no_set}&text=${p_messeg}#Intent;scheme=whatsapp;package=com.whatsapp;action=android.intent.action.VIEW;end;" rel="noopener noreferrer" style="margin-left: 10px; font-size: 20px;  color: black; " ><i  class="fa fa-whatsapp"></i></a> `,
                        pre_amnt: formatter.format(prev_ttl_amnt).toString().getDigitBanglaFromEnglish(),
                        pai_amnt: formatter.format(res.giving_amanot[de].giving_amnt).getDigitBanglaFromEnglish(),
                        marfot: res.giving_amanot[de].amanot_marfot_take,
                        due_now: formatter.format(select_ttl_amnt).toString().getDigitBanglaFromEnglish()
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
                    table_tr_assign += `<tr >
                                            <td class="text-center vertical-middle">${index + 1}</td>
                                            <td class="text-center vertical-middle" >${data.view}</td>
                                            <td class="text-center vertical-middle">${data.person}</td>
                                            <td class="text-center vertical-middle">${data.pre_amnt}</td>
                                            <td >${data.pai_amnt}</td>
                                            <td class="text-center vertical-middle">${data.marfot}</td>
                                            <td class="text-center vertical-middle">${data.due_now}</td> 
                                        </tr>`;
                });
                $('.amanots_info_assign_htmls').html(table_tr_assign);  
            }
        });


    }

});

function get_amanot_person_full_info_by_idd(amanot_id, dates) { 
    return $.ajax({
        type: "post",
        url: "payment_types/get_amanot_person_full_info_and_amount_by_idd",
        data: {
            person_id: amanot_id,
            dates: dates
        },
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
        async: false
    }).responseText;
}












