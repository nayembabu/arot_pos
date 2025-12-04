 
$(document).ready(function () {
    $(document).on('click', '.supp_serching_btn_this', function () {
        if ($('.start_datess').val() === '' || $('.ending_dates').val() === '' || $('.supplier_selecting_id option:selected').val() === '') { 
            toastr['warning']('সব তথ্য দেন');
            return false;
         }else {
            
            $.ajax({ 
                type: "POST",
                url: "tax/get_buy_commission_info_by_supp_datetodate",
                data: {
                    startDate:  $('.start_datess').val(),
                    endDate:    $('.ending_dates').val(), 
                    supplierId: $('.supplier_selecting_id option:selected').val()
                },
                beforeSend: function() {
                    $('.spiner_load_activity').css('display', 'block');
                },
                complete: function() {
                    $('.spiner_load_activity').css('display', 'none');
                },
                success: function (rs) { 
                    let html_table_data = '';
                    for (let aa = 0; aa < rs.cmns_info.length; aa++) {  
                        let commission_items_datass = get_commission_items_info(rs.cmns_info[aa].db_purchase_commission_submited_pr_iddd);
                        let commission_items_data = JSON.parse(commission_items_datass);
                        let comm_item_imfo_html_data = '';

                        for (let sa = 0; sa < commission_items_data.cmns_items_info.length; sa++) {
                            comm_item_imfo_html_data += `<div>${(commission_items_data.cmns_items_info[sa].ttl_salessss_bostaass).getDigitBanglaFromEnglish()}বস্তা || ${formatter.format(commission_items_data.cmns_items_info[sa].ttl_weight_bostassssssss).getDigitBanglaFromEnglish()}কেজি×${formatter.format(commission_items_data.cmns_items_info[sa].saling_pricesssssss).getDigitBanglaFromEnglish()} == ৳${formatter.format(commission_items_data.cmns_items_info[sa].ttl_sales_amount_sssssss).getDigitBanglaFromEnglish()} </div>`; 
                        }

                        // ${formatter.format(sales_item_info[i].price_per_kg).getDigitBanglaFromEnglish()

                        html_table_data += `<tr class="">
                                                <td class="text-center" >${formatter.format(aa+1).getDigitBanglaFromEnglish()}</td>
                                                <td ><a target="_blank" href="tax/purchase_comission_receipt_view_fun?pur_cmns_id=${rs.cmns_info[aa].db_purchase_commission_submited_pr_iddd}" class="btn btn-primary btn-sm" ><i class="fa fa-print" ></i></a></td>
                                                <td class="text-center" >${(rs.cmns_info[aa].date_of_commission_save).getDigitBanglaFromEnglish()}</td>
                                                <td class="text-center" >${(rs.cmns_info[aa].pur_date_timsssss).getDigitBanglaFromEnglish()}</td>
                                                <td class="text-center" >${comm_item_imfo_html_data}</td>
                                                <td align="right" >${formatter.format(rs.cmns_info[aa].supp_sabek_amntss).getDigitBanglaFromEnglish()}</td> 
                                                <td align="right" >${formatter.format(rs.cmns_info[aa].amnt_of_this_trans_s).getDigitBanglaFromEnglish()}</td>
                                                <td align="right" >${formatter.format(rs.cmns_info[aa].supp_ekhon_amnts_s).getDigitBanglaFromEnglish()}</td>
                                                <td ></td>
                                            </tr>`;
                    } 
                    $('.sales_infos_data_assigns').html(html_table_data); 
                }
            })

         }
    });
 
    function get_commission_items_info(comm_id) {  
       return $.ajax({
          type: "post",
          url: "tax/get_buy_commission_item_info_by_commission_uniq_id",
          data: {
            comm_id: comm_id
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

})




