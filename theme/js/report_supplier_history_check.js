


$(document).ready(function () {

   $(document).on('click', '.supp_serching_btn_this', function () {
      if ($('.start_datess').val() === '' || $('.ending_dates').val() === '' || $('.supplier_selecting_id option:selected').val() === '') {
         toastr['warning']('সব তথ্য দেন');
         return false;
      } else {
         $.ajax({
            type: "POST",
            url: "suppliers/get_purchase_info_by_supp_datetodate",
            data: {
               startDate: $('.start_datess').val(),
               endDate: $('.ending_dates').val(),
               supplierId: $('.supplier_selecting_id option:selected').val()
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
               let lm = 0;
               $('.cust_pre_amnt').html(formatter.format(rs.supp_info.purchase_due).getDigitBanglaFromEnglish());
               $('.cust_name').html(rs.supp_info.supplier_name);
               $('.cust_mobile').html(rs.supp_info.mobile.getDigitBanglaFromEnglish());
               $('.cust_address').html(rs.supp_info.address);

               // প্রথম লুপ থেকে ডেটা সংগ্রহ
               for (lm = 0; lm < rs.purchase_infos.length; lm++) {
                  let td_assignment_data = '';
                  let supp_commis_items_wsss;
                  if (rs.purchase_infos[lm].supp_commis_items_wsss == null || rs.purchase_infos[lm].supp_commis_items_wsss == '') {
                     supp_commis_items_wsss = 0;
                  } else {
                     supp_commis_items_wsss = rs.purchase_infos[lm].supp_commis_items_wsss;
                  }
                  let purchase_item_info = JSON.parse(get_purchase_product_info(rs.purchase_infos[lm].db_purchase_transports_info_a_idd));

                  for (let nu = 0; nu < purchase_item_info.length; nu++) {
                     td_assignment_data += ` <div class="custom-item purchase_items_details " data-toggle="modal" data-target="#supp_cust_repor_modal" pur_item_id_attr="${purchase_item_info[nu].id}" >
                                                <h4>${purchase_item_info[nu].ref_lot_no}</h4>
                                                <small>ক্রয় পরিমাণ: ${purchase_item_info[nu].purchase_qty.getDigitBanglaFromEnglish()} বস্তা</small><br>
                                                <small> ওজন ${(parseFloat(purchase_item_info[nu].ttl_purchase_kg_sss).toFixed(1)).getDigitBanglaFromEnglish()} কেজি </small>
                                             </div>`;
                  }

                  //  total_price______formatter.format(parseFloat(rs.purchase_infos[lm].unpaid_amount_this_trans_tk) + parseFloat(supp_commis_items_wsss)).getDigitBanglaFromEnglish()

                  if (rs.purchase_infos[lm].pur_status_buy_change == '2' && rs.purchase_infos[lm].pur_comsn_complete_check == '1') {
                     table_data.push({
                        serial: lm + 1,
                        view: `<a data-toggle="modal" data-target="#supp_cust_repor_modal" class="btn btn-sm btn-primary view_selling_infos " id_attr="${rs.purchase_infos[lm].db_purchase_transports_info_a_idd}" >View</a>`,
                        date: rs.purchase_infos[lm].pur_date_timsssss,
                        details: td_assignment_data,
                        prev_amnt: formatter.format(parseFloat(rs.purchase_infos[lm].supp_pre_amtssss)).getDigitBanglaFromEnglish(),
                        total_price: formatter.format(parseFloat(rs.purchase_infos[lm].unpaid_amount_this_trans_tk)).getDigitBanglaFromEnglish(),
                        paid: '০',
                        now_due: formatter.format(parseFloat(rs.purchase_infos[lm].supp_now_due_amnt_ssssss)).getDigitBanglaFromEnglish(),
                        times: rs.purchase_infos[lm].now_timess,
                        coms: 1,
                        comp: 1,
                        coms_date: rs.purchase_infos[lm].date_of_commission_save
                     });
                  } else if (rs.purchase_infos[lm].pur_status_buy_change == '2' && rs.purchase_infos[lm].pur_comsn_complete_check == '0') {
                     table_data.push({
                        serial: lm + 1,
                        view: `<a data-toggle="modal" data-target="#supp_cust_repor_modal" class="btn btn-sm btn-primary view_selling_infos " id_attr="${rs.purchase_infos[lm].db_purchase_transports_info_a_idd}" >View</a>`,
                        date: rs.purchase_infos[lm].pur_date_timsssss,
                        details: td_assignment_data,
                        prev_amnt: formatter.format(parseFloat(rs.purchase_infos[lm].supp_pre_amtssss)).getDigitBanglaFromEnglish(),
                        total_price: formatter.format(parseFloat(rs.purchase_infos[lm].unpaid_amount_this_trans_tk)).getDigitBanglaFromEnglish(),
                        paid: '০',
                        now_due: formatter.format(parseFloat(rs.purchase_infos[lm].supp_now_due_amnt_ssssss)).getDigitBanglaFromEnglish(),
                        times: rs.purchase_infos[lm].now_timess,
                        coms: 1,
                        comp: 0,
                        coms_date: '--'
                     });
                  } else {
                     table_data.push({
                        serial: lm + 1,
                        view: `<a data-toggle="modal" data-target="#supp_cust_repor_modal" class="btn btn-sm btn-primary view_selling_infos " id_attr="${rs.purchase_infos[lm].db_purchase_transports_info_a_idd}" >View</a>`,
                        date: rs.purchase_infos[lm].pur_date_timsssss,
                        details: td_assignment_data,
                        prev_amnt: formatter.format(parseFloat(rs.purchase_infos[lm].supp_pre_amtssss)).getDigitBanglaFromEnglish(),
                        total_price: formatter.format(parseFloat(rs.purchase_infos[lm].unpaid_amount_this_trans_tk)).getDigitBanglaFromEnglish(),
                        paid: '০',
                        now_due: formatter.format(parseFloat(rs.purchase_infos[lm].supp_now_due_amnt_ssssss)).getDigitBanglaFromEnglish(),
                        times: rs.purchase_infos[lm].now_timess,
                        coms: 0,
                        comp: 0,
                        coms_date: '--'
                     });
                  }
               }

               // দ্বিতীয় লুপ থেকে ডেটা সংগ্রহ
               for (let tv = 0; tv < rs.supp_payment_info.length; tv++) {
                  if (rs.supp_payment_info[tv].payment != 0) {
                     table_data.push({
                        serial: lm++,
                        view: 'জমা দিয়েছেন',
                        date: rs.supp_payment_info[tv].payment_date,
                        details: `<div class="custom-item" ><h4>${rs.supp_payment_info[tv].payment_type}</h4></div>`,
                        prev_amnt: formatter.format(rs.supp_payment_info[tv].supp_prevs_amnts).getDigitBanglaFromEnglish(),
                        total_price: '০',
                        paid: formatter.format(rs.supp_payment_info[tv].payment).getDigitBanglaFromEnglish(),
                        now_due: formatter.format(rs.supp_payment_info[tv].supp_now_due_amnt_ssss).getDigitBanglaFromEnglish(),
                        times: rs.supp_payment_info[tv].created_time,
                        coms: 0,
                        comp: 0,
                        coms_date: '--'
                     });
                  }
               }
               for (let vlf = 0; vlf < rs.supp_coms_entry.length; vlf++) {
                  table_data.push({
                     serial: lm++,
                     view: 'কমিশন জমা দিয়েছেন',
                     date: rs.supp_coms_entry[vlf].date_of_commission_save,
                     details: `<div class="custom-item" ><h4>00</h4></div>`,
                     prev_amnt: formatter.format(rs.supp_coms_entry[vlf].supp_sabek_amntss).getDigitBanglaFromEnglish(),
                     total_price: formatter.format(rs.supp_coms_entry[vlf].amnt_of_this_trans_s).getDigitBanglaFromEnglish(),
                     paid: '০',
                     now_due: formatter.format(rs.supp_coms_entry[vlf].supp_ekhon_amnts_s).getDigitBanglaFromEnglish(),
                     times: rs.supp_coms_entry[vlf].timess_of_commission_save,
                     coms: 2,
                     comp: 2,
                     coms_date: '--'
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
                  return a.times.localeCompare(b.times, undefined, { numeric: true });
               });

               // টেবিল পুনরায় তৈরি করা এবং সঠিক সিরিয়াল সেট করা 
               table_data.forEach((data, index) => {
                  if (data.coms == 1 && data.comp == 1) {
                     table_tr_assign += `<tr class="bg-success text-white" >
                                             <td class="text-center vertical-middle">${index + 1}</td>
                                             <td class="text-center vertical-middle" >কমিশন পন্য - এন্ট্রিঃ ${data.coms_date}<br>${data.view}</td>
                                             <td class="text-center vertical-middle">${data.date}</td>
                                             <td >${data.details}</td>
                                             <td class="text-center vertical-middle">কমিশন এন্ট্রি হয়েছে</td>
                                             <td class="text-center vertical-middle">${data.total_price}</td>
                                             <td class="text-center vertical-middle">${data.paid}</td>
                                             <td class="text-center vertical-middle"></td>
                                             <td class="text-center vertical-middle">${data.times}</td>
                                          </tr>`;
                  } else if (data.coms == 1 && data.comp == 0) {
                     table_tr_assign += `<tr class="bg-info text-white" >
                                             <td class="text-center vertical-middle">${index + 1}</td>
                                             <td class="text-center vertical-middle" >কমিশন পন্য এন্ট্রি হয় নাই <br>${data.view}</td>
                                             <td class="text-center vertical-middle">${data.date}</td>
                                             <td >${data.details}</td>
                                             <td class="text-center vertical-middle">কমিশন এন্ট্রি হয় নাই</td>
                                             <td class="text-center vertical-middle">${data.total_price}</td>
                                             <td class="text-center vertical-middle">${data.paid}</td>
                                             <td class="text-center vertical-middle"></td>
                                             <td class="text-center vertical-middle">${data.times}</td>
                                          </tr>`;
                  } else if (data.coms == 2 && data.comp == 2) {
                     table_tr_assign += `<tr class="bg-primary" >
                                             <td class="text-center vertical-middle">${index + 1}</td>
                                             <td class="text-center vertical-middle" >কমিশন পন্য <br>${data.view}</td>
                                             <td class="text-center vertical-middle">${data.date}</td>
                                             <td >${data.details}</td>
                                             <td class="text-center vertical-middle">কমিশন<br>${data.prev_amnt}</td>
                                             <td class="text-center vertical-middle">${data.total_price}</td>
                                             <td class="text-center vertical-middle">${data.paid}</td>
                                             <td class="text-center vertical-middle">${data.now_due}</td>
                                             <td class="text-center vertical-middle">${data.times}</td>
                                          </tr>`;
                  } else {
                     table_tr_assign += `<tr >
                                          <td class="text-center vertical-middle">${index + 1}</td>
                                          <td class="text-center vertical-middle" >${data.view}</td>
                                          <td class="text-center vertical-middle">${data.date}</td>
                                          <td >${data.details}</td>
                                          <td class="text-center vertical-middle">${data.prev_amnt}</td>
                                          <td class="text-center vertical-middle">${data.total_price}</td>
                                          <td class="text-center vertical-middle">${data.paid}</td>
                                          <td class="text-center vertical-middle">${data.now_due}</td>
                                          <td class="text-center vertical-middle">${data.times}</td>
                                       </tr>`;
                  }
               });

               // টেবিলে HTML আপডেট করা
               $('.sales_infos_data_assigns').html(table_tr_assign);

            }
         });
      }
   });

   function get_purchase_product_info(trans_id) {
      return $.ajax({
         type: "post",
         url: "suppliers/get_purchase_item_by_trans_puurchase_id",
         data: {
            trans_id: trans_id
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
            $('.supp_name_ss').html(`${rpn.trans_infos.supplier_name} <span class="supp_addrs_ss" style="font-size: 18px;">${rpn?.trans_infos?.address && rpn.trans_infos.address || ''}</span>`);
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

   //  <li style="padding: 5px;">প্রতি কেজির কেনা দাম ${rpn.sales_item_infos[klm].price_per_unit} টাকা</li>
   $(document).on('click', '.purchase_items_details', function () {
      $.ajax({
         type: "post",
         url: "suppliers/view_sells_info_by_puurchase_items_id_p",
         data: {
            pur_item_id: $(this).attr('pur_item_id_attr')
         },
         beforeSend: function () {
            $('.spiner_load_activity').css('display', 'block');
         },
         complete: function () {
            $('.spiner_load_activity').css('display', 'none');
         },
         success: function (rrp) {
            let ttlpur_weight = parseFloat(rrp.purchase_infos.ttl_item_kg_trans);

            let ttl_pur_costs = parseFloat(rrp.purchase_infos.ttl_trans_other_cost ? rrp.purchase_infos.ttl_trans_other_cost : 0) + parseFloat(rrp.purchase_infos.ttl_trans_com ? rrp.purchase_infos.ttl_trans_com : 0) + parseFloat(rrp.purchase_infos.ttal_ghar_kuli_cost_amnt ? rrp.purchase_infos.ttal_ghar_kuli_cost_amnt : 0) + parseFloat(rrp.purchase_infos.driver_advance_amnt_cost ? rrp.purchase_infos.driver_advance_amnt_cost : 0) + parseFloat(rrp.purchase_infos.supp_commis_items_wsss ? rrp.purchase_infos.supp_commis_items_wsss : 0) + parseFloat(rrp.purchase_infos.others_cost_amnt_for_trans ? rrp.purchase_infos.others_cost_amnt_for_trans : 0);

            let costs_persss_kg = parseFloat(ttl_pur_costs) / parseFloat(ttlpur_weight);
            let price_per_kgssss = parseFloat(rrp.purchase_infos.price_per_unit) + parseFloat(costs_persss_kg);

            console.log(ttl_pur_costs);
            console.log(costs_persss_kg);
            console.log(rrp.purchase_infos.price_per_unit);
            console.log(price_per_kgssss);
            console.log(ttlpur_weight);


            let salling_items_assign_arry = '';
            $('.supp_name_ss').html(`${rrp.purchase_infos.supplier_name} <span class="supp_addrs_ss" style="font-size: 18px;">${rrp?.purchase_infos?.address && rrp.purchase_infos.address || ''}</span>`);
            $('.pur_datesss').html(rrp.purchase_infos.purchase_item_dates);
            $('.lot_namess').html(rrp.purchase_infos.ref_lot_no);
            $('.details_of_lotsss').html(`কেনা হয়েছে ${rrp.purchase_infos.purchase_total_bosta.getDigitBanglaFromEnglish()} বস্তা। <br> 
            মোট ওজন ${(parseFloat(rrp.purchase_infos.ttl_purchase_kg_sss).toFixed(1)).getDigitBanglaFromEnglish()} কেজি<br> বর্তমান স্টক ${rrp.purchase_infos.due_sells_bosta_ss.getDigitBanglaFromEnglish()} বস্তা <br>
            দামঃ-  ${formatter.format(price_per_kgssss).getDigitBanglaFromEnglish()} টাকা`);

            let date_bosta_qnty = '';

            for (let knu = 0; knu < rrp.sell_infos.length; knu++) {

               // if (filterdate == rrp.sell_infos[knu].payment_datesss) {
               date_bosta_qnty += parseFloat(rrp.sell_infos[knu].sales_qnty_bostas);
               salling_items_assign_arry += `<li style="padding: 15px; background: white; margin-bottom: 10px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; cursor: pointer; " class="toggle-details " data-target="#customer${knu}Details"  >
                     <span>
                        <strong>${rrp.sell_infos[knu].payment_datesss}</strong>
                     </span>
                     <span>
                     <strong>${rrp.sell_infos[knu].customer_name}</strong> (<small>${rrp.sell_infos[knu].address}</small>)
                     </span>
                     <span>
                        <strong></strong>
                     </span>
                     <span>
                        ${(rrp.sell_infos[knu].sales_qnty_bostas).getDigitBanglaFromEnglish()} বস্তা
                     </span> 
                  </li>
                  <!-- Collapsible Content for Customer F -->
                  <div id="customer${knu}Details" class="collapse-content" style="padding: 10px; background: #f8f9fa; margin-bottom: 10px; border-radius: 10px; display: none;">
                     <ul style="list-style: none; padding: 0;">
                           <li style="padding: 5px;"></li>
                           <li style="padding: 5px;">${(rrp.sell_infos[knu].sales_qnty_bostas).getDigitBanglaFromEnglish()} বস্তা</li>
                           <li style="padding: 5px;">মোট ${(rrp.sell_infos[knu].ttl_sale_kgs_this_product).getDigitBanglaFromEnglish()} কেজি</li>
                           <li style="padding: 5px;">১ বস্তায় ${(rrp.sell_infos[knu].sales_kgs_perbosta).getDigitBanglaFromEnglish()} কেজি</li>
                           <li style="padding: 5px;">প্রতি কেজির বিক্রয় দাম ${formatter.format(rrp.sell_infos[knu].price_per_kg).getDigitBanglaFromEnglish()} টাকা</li>
                     </ul>
                  </div>`;
            }
            $('.customer_list_html_assign').html(salling_items_assign_arry);
         }
      });
   });


});
