
$(document).ready(function () { 

    $(document).on( 'click', '.cust_serching_btn_this_reports', function () { 
        if ($('.start_datess').val() == '' || $('.ending_dates').val() == '' || $('.customer_selecting_id option:selected').val() == '') {  
            toastr['warning']('সব তথ্য দেন');
            return false;
        }else { 
            $.ajax({
                url: 'tax/get_report_full_sell_commission_history',
                type: 'POST',
                data: {
                    start_date: $('.start_datess').val(),
                    ends_dates: $('.ending_dates').val(),
                    cust_idsss: $('.customer_selecting_id option:selected').val()
                },
                beforeSend: function() { 
                    $('.spiner_load_activity').css('display', 'block');
                },
                complete: function() { 
                    $('.spiner_load_activity').css('display', 'none');
                },
                success: function (data) { 
                    let html_table_data = '';

                    $('.cust_name').html(data.cust_info.customer_name);
                    $('.cust_address').html(data.cust_info.customer_address);
                    $('.cust_mobile').html(data.cust_info.customer_mobile);
                    $('.cust_pre_amnt').html(formatter.format(data.cust_info.sales_due).getDigitBanglaFromEnglish());

                    for (let aa = 0; aa < data.cmns_info.length; aa++) {  
                        let commission_items_datass = get_sells_commission_items_info(data.cmns_info[aa].sales_commission_submited_info_iddd);
                        let commission_items_data = JSON.parse(commission_items_datass);

                        console.log(commission_items_datass);
                        let comm_item_imfo_html_data = '';
                        commission_items_data = [commission_items_data];
                        
                        for (let sa = 0; sa < commission_items_data.length; sa++) {
                            comm_item_imfo_html_data += `<div>${commission_items_data[sa].ttl_sales_bosta_asaaaa.toString().getDigitBanglaFromEnglish()} বস্তা || ${formatter.format(commission_items_data[sa].ttl_sales_weight_kgs_aaa).toString().getDigitBanglaFromEnglish()} কেজি × ${formatter.format(commission_items_data[sa].saling_prices_sssss_per_kgsss).toString().getDigitBanglaFromEnglish()} == ৳${formatter.format(commission_items_data[sa].ttl_sales_sss_amounts_sss).toString().getDigitBanglaFromEnglish()}</div>`; 
                        } 

                        html_table_data += `<tr class="">
                                                <td class="text-center" >${formatter.format(aa+1).getDigitBanglaFromEnglish()}</td>
                                                <td ><a target="_blank" href="tax/sales_commission_receipt_view?sales_commission_id=${data.cmns_info[aa].sales_commission_submited_info_iddd}" class="btn btn-primary btn-sm" ><i class="fa fa-print" ></i></a></td>
                                                <td class="text-center" >${(data.cmns_info[aa].cr_dating_setsss).getDigitBanglaFromEnglish()}</td>
                                                <td class="text-center" >${(data.cmns_info[aa].sales_date).getDigitBanglaFromEnglish()}</td>
                                                <td class="text-center" >${comm_item_imfo_html_data}</td>
                                                <td align="right" >${formatter.format(data.cmns_info[aa].cust_previous_amount_addss).getDigitBanglaFromEnglish()}</td> 
                                                <td align="right" >${formatter.format(data.cmns_info[aa].ttl_amount_of_sales_taka).getDigitBanglaFromEnglish()}</td>
                                                <td align="right" >${formatter.format(data.cmns_info[aa].cust_now_amount_after_commission_entryss).getDigitBanglaFromEnglish()}</td>
                                                <td ></td>
                                            </tr>`; 
                    } 
                    $('.sales_infos_data_assigns').html(html_table_data); 

                },
                error: function (error) {
                    // Handle any errors that occur during the request
                    console.error(error);
                }
            });
        } 
    }); 

    function get_sells_commission_items_info(comm_id) {   
        return $.ajax({
            type: "post",
            url: "tax/get_sales_commission_item_info_by_coms_id",
            data: { 
                sales_comm_id: comm_id 
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

});