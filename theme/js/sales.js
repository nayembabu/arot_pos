

$(document).on('change', '.customer_uniqs_id', function () {
  if (parseInt($(this).val()) === 1) {
    $(".normal_customaer_info").stop().css({
      position: "relative",
      opacity: 0,
      left: "-50px",
      transform: "scale(0.8)"
    }).show().animate({
      left: "0px",
      opacity: 1,
      transform: "scale(1)"
    }, {
      duration: 1000,
      step: function (now, fx) {
        $(this).css("transform", "scale(" + (0.8 + 0.2 * now) + ")");
      },
      complete: function () {
        $(this).effect("bounce", { times: 3, distance: 20 }, 500);
      }
    });
  } else {
    $(".normal_customaer_info").stop().animate({
      left: "50px",
      opacity: 0,
      transform: "scale(0.8)"
    }, {
      duration: 1000,
      step: function (now, fx) {
        $(this).css("transform", "scale(" + (1 - 0.2 * now) + ")");
      },
      complete: function () {
        $(this).hide();
      }
    });
  }
});



$(document).on('click', '.trans_searching_btn', function () {

  $.ajax({
    type: "post",
    url: 'sales/get_purchase_transport_info_by_date_for_sales_rasta',
    data: {
      select_dates: $('.selected_trans_date').val()
    },
    beforeSend: function () {
      $('.spiner_load_activity').css('display', 'block');
    },
    complete: function () {
      $('.spiner_load_activity').css('display', 'none');
    },
    success: function (rs) {
      if (rs == 0) {
        $('.nav_assign_ul_data').html(`<ul class="nav nav-tabs bg-gray text-bold font-italic">এই লটে রাস্তায় বিক্রি নেই</ul>`);
      } else {
        let html_data = '';
        for (let n = 0; n < rs.transport_info.length; n++) {
          if (rs.transport_info[n].ttl_due_bosta_this_trans != 0) {
            if (rs.transport_info[n].sup_id_ass_iddd) {
              html_data += `<li style="border-right: 3px solid white; padding-right: 10px;  " >
                              <a class="clickable_get_ref_datas_sales_rasta" href="#tab_1" data-toggle="tab" trans_ids="${rs.transport_info[n].transport_i_a_iiiiidd}" pur_trans_id_attr="${rs.transport_info[n].db_purchase_transports_info_a_idd}">M-${rs.transport_info[n].supplier_name} - ${rs.transport_info[n].lot_trns_ref_nop_s}</a>
                            </li>`;
            } else if (rs.transport_info[n].custmr_id_uniqs) {
              html_data += `<li style="border-right: 3px solid white; padding-right: 10px;  " >
                              <a class="clickable_get_ref_datas_sales_rasta" href="#tab_1" data-toggle="tab" trans_ids="${rs.transport_info[n].transport_i_a_iiiiidd}" pur_trans_id_attr="${rs.transport_info[n].db_purchase_transports_info_a_idd}">C-${rs.transport_info[n].customer_name} - ${rs.transport_info[n].lot_trns_ref_nop_s}</a>
                            </li>`;
            } else {
              html_data += '';
            }
          } else if (rs.transport_info[n].ttl_due_bosta_this_trans == 0) {
            html_data += `<li style="border-right: 3px solid white; padding-right: 10px;  " >
                            <a class="" href="#tab_1" data-toggle="tab" >${rs.transport_info[n].lot_trns_ref_nop_s}--বিক্রি শেষ স্টক 0</a>
                          </li>`;
          }
        }
        $('.nav_assign_ul_data').html(`<ul class="nav nav-tabs bg-gray text-bold font-italic">${html_data}</ul>`);
      }
    }
  });
});



$(document).on('change', '.selected_products_item', function () {
  let product_id = $(this).val();
  $.ajax({
    type: "post",
    url: 'sales/get_due_purchase_transport_infos',
    data: {
      pr_id: product_id
    },
    success: function (rs) {
      $('.ttl_data_show_rows').html('');
      $('.ref_lots_nos_s').val('');
      $('.pur_item_info_displays').html('');
      $('.submit_btn_selling_sys').html('');
      let html_data = '';
      for (let n = 0; n < rs.transport_info.length; n++) {
        if (rs.transport_info[n].sup_id_ass_iddd) {
          html_data += `<li style="border-right: 3px solid white; padding-right: 10px;  " >
                          <a class="clickable_get_ref_datas" href="#tab_1" data-toggle="tab" trans_ids="${rs.transport_info[n].transport_i_a_iiiiidd}" pur_trans_id_attr="${rs.transport_info[n].db_purchase_transports_info_a_idd}">M-${rs.transport_info[n].supplier_name} - ${rs.transport_info[n].lot_trns_ref_nop_s}</a>
                        </li>`;
        } else if (rs.transport_info[n].custmr_id_uniqs) {
          html_data += `<li style="border-right: 3px solid white; padding-right: 10px;  " >
                          <a class="clickable_get_ref_datas" href="#tab_1" data-toggle="tab" trans_ids="${rs.transport_info[n].transport_i_a_iiiiidd}" pur_trans_id_attr="${rs.transport_info[n].db_purchase_transports_info_a_idd}">C-${rs.transport_info[n].customer_name} - ${rs.transport_info[n].lot_trns_ref_nop_s}</a>
                        </li>`;
        } else {
          html_data += '';
        }
      }
      $('.nav_assign_ul_data').html(`<ul class="nav nav-tabs bg-gray text-bold font-italic">${html_data}</ul>`);
    }
  });
});



$(document).on('click', '.clickable_get_ref_datas_sales_rasta', function () {
  let transport_id = $(this).attr('trans_ids');
  let this_click_pur_trans_attr_id = $(this).attr('pur_trans_id_attr');
  $.ajax({
    type: "post",
    url: "sales/get_items_details_by_purchase_item_id",
    data: {
      pt_id: this_click_pur_trans_attr_id
    },
    success: function (rs) {
      $('.pur_item_info_displays').html(``);

      let items_lists = '';
      let ttl_trans_other_cost;
      let driver_advance_amnt_cost;
      let others_cost_amnt_for_trans;
      let ttl_items_bosta_this_trans;
      let trans_com_per_bosta;
      let ghar_kuli_rates_per_bosta;
      let pur_supp_commission;

      // transport_info.item_image 

      if ($.isNumeric(rs.transport_info.ttl_trans_other_cost)) {
        ttl_trans_other_cost = parseFloat(rs.transport_info.ttl_trans_other_cost);
      } else {
        ttl_trans_other_cost = 0;
      }

      if ($.isNumeric(rs.transport_info.driver_advance_amnt_cost)) {
        driver_advance_amnt_cost = parseFloat(rs.transport_info.driver_advance_amnt_cost);
      } else {
        driver_advance_amnt_cost = 0;
      }

      if ($.isNumeric(rs.transport_info.others_cost_amnt_for_trans)) {
        others_cost_amnt_for_trans = parseFloat(rs.transport_info.others_cost_amnt_for_trans);
      } else {
        others_cost_amnt_for_trans = 0;
      }

      if ($.isNumeric(rs.transport_info.ttl_items_bosta_this_trans)) {
        ttl_items_bosta_this_trans = parseFloat(rs.transport_info.ttl_items_bosta_this_trans);
      } else {
        ttl_items_bosta_this_trans = 0;
      }

      if ($.isNumeric(rs.transport_info.trans_com_per_bosta)) {
        trans_com_per_bosta = parseFloat(rs.transport_info.trans_com_per_bosta);
      } else {
        trans_com_per_bosta = 0;
      }

      if ($.isNumeric(rs.transport_info.ghar_kuli_rates_per_bosta)) {
        ghar_kuli_rates_per_bosta = parseFloat(rs.transport_info.ghar_kuli_rates_per_bosta);
      } else {
        ghar_kuli_rates_per_bosta = 0;
      }

      if ($.isNumeric(rs.transport_info.supp_commis_items_wsss)) {
        pur_supp_commission = parseFloat(rs.transport_info.supp_commis_items_wsss);
      } else {
        pur_supp_commission = 0;
      }

      let trans_cost_figures = ttl_trans_other_cost + driver_advance_amnt_cost + others_cost_amnt_for_trans + pur_supp_commission;
      let trans_cost_per_item_wise = trans_cost_figures / ttl_items_bosta_this_trans;
      let cost_per_bosta = trans_com_per_bosta + ghar_kuli_rates_per_bosta + trans_cost_per_item_wise;

      let item_imagess = rs.product_info.item_image ? `uploads/items/${rs.product_info.item_image}` : 'theme/images/no_image.png';


      for (let n = 0; n < rs.purchase_item_infos.length; n++) {
        let pur_kg_per_bosta;
        let price_per_unit;

        if ($.isNumeric(rs.purchase_item_infos[n].pur_kg_per_bosta)) {
          pur_kg_per_bosta = parseFloat(rs.purchase_item_infos[n].pur_kg_per_bosta);
        } else {
          pur_kg_per_bosta = 0;
        }

        if ($.isNumeric(rs.purchase_item_infos[n].price_per_unit)) {
          price_per_unit = parseFloat(rs.purchase_item_infos[n].price_per_unit)
        } else {
          price_per_unit = 0;
        }

        let rates_per_bosta = (price_per_unit * pur_kg_per_bosta) + cost_per_bosta;
        let rates_per_kgs = (trans_cost_per_item_wise / pur_kg_per_bosta) + price_per_unit;

        items_lists += `<div class="col-md-3 col-xs-6 " title="" style="padding-left:5px;padding-right:5px;" >
                            <div class="box box-default pur_item_box_sales_rasta " pur_trans_auto_iddd="${rs.purchase_item_infos[n].purchase_trans_info_auto_pr_iddds}" pur_items_uniq_id="${rs.purchase_item_infos[n].id}" id="div_1" style="max-height: 150px;min-height: 150px;cursor: pointer;background-color:#c8c8c8; border: 2px solid black; ">
                              <span class="label label-danger push-right" style="font-weight: bold;font-family: sans-serif;" >
                                Qty: ${rs.purchase_item_infos[n].due_sells_bosta_ss}-${rs.product_info.unit_name} 
                              </span>
                              <div class="box-body box-profile">
                                  <center>
                                    <img class=" img-responsive item_image" style="border: 1px solid gray; max-height: 75px; width: 115px; " src="${item_imagess}" alt="Item picture">
                                  </center>
                                  <lable class="text-center search_item" style="font-weight: bold; font-family: sans-serif; " id="item_0">
                                    ${rs.purchase_item_infos[n].ref_lot_no} <br>   
                                    <span class="" style="font-family: sans-serif; ">
                                        ৳ <span class="rate_per_kg_clss ">${rates_per_kgs.toFixed(2)}</span>
                                    </span>
                                  </lable>
                              </div>
                            </div>
                        </div>`
      }

      $('.ref_lots_nos_s').val(``);
      $('.ttl_data_show_rows').html(items_lists);
      $('.submit_btn_selling_sys').html('');


    }
  });
});

// sasdasdasd
$(document).on('click', '.pur_item_box_sales_rasta', function () {
  $.ajax({
    type: "post",
    url: "sales/get_purchases_all_info_for_sales_item",
    data: {
      pur_item_id: $(this).attr('pur_items_uniq_id'),
      pur_tran_id: $(this).attr('pur_trans_auto_iddd')
    },
    success: function (rs) {

      let pur_kg_per_bosta;
      let price_per_unit;

      let ttl_trans_com;
      let ttl_item_kg_trans;
      let ttal_ghar_kuli_cost_amnt;

      let items_lists = '';
      let ttl_trans_other_cost;
      let driver_advance_amnt_cost;
      let others_cost_amnt_for_trans;
      let ttl_items_bosta_this_trans;
      let trans_com_per_bosta;
      let ghar_kuli_rates_per_bosta;
      let pur_supp_commission;


      //   let ttl_costttttts = ttl_trans_other_cost + ttl_trans_com + ttal_ghar_kuli_cost_amnt + driver_advance_amnt_cost + supp_commis_items_wsss + others_cost_amnt_for_trans + total_trans_price - koifiyat_amount_tk_for_this_trans

      if ($.isNumeric(rs.transport_info.ttl_trans_com)) {
        ttl_trans_com = parseFloat(rs.transport_info.ttl_trans_com);
      } else {
        ttl_trans_com = 0;
      }

      if ($.isNumeric(rs.transport_info.ttal_ghar_kuli_cost_amnt)) {
        ttal_ghar_kuli_cost_amnt = parseFloat(rs.transport_info.ttal_ghar_kuli_cost_amnt);
      } else {
        ttal_ghar_kuli_cost_amnt = 0;
      }

      if ($.isNumeric(rs.transport_info.ttl_item_kg_trans)) {
        ttl_item_kg_trans = parseFloat(rs.transport_info.ttl_item_kg_trans);
      } else {
        ttl_item_kg_trans = 0;
      }


      if ($.isNumeric(rs.transport_info.ttl_trans_other_cost)) {
        ttl_trans_other_cost = parseFloat(rs.transport_info.ttl_trans_other_cost);
      } else {
        ttl_trans_other_cost = 0;
      }
      if ($.isNumeric(rs.transport_info.driver_advance_amnt_cost)) {
        driver_advance_amnt_cost = parseFloat(rs.transport_info.driver_advance_amnt_cost);
      } else {
        driver_advance_amnt_cost = 0;
      }
      if ($.isNumeric(rs.transport_info.others_cost_amnt_for_trans)) {
        others_cost_amnt_for_trans = parseFloat(rs.transport_info.others_cost_amnt_for_trans);
      } else {
        others_cost_amnt_for_trans = 0;
      }
      if ($.isNumeric(rs.transport_info.ttl_items_bosta_this_trans)) {
        ttl_items_bosta_this_trans = parseFloat(rs.transport_info.ttl_items_bosta_this_trans);
      } else {
        ttl_items_bosta_this_trans = 0;
      }
      if ($.isNumeric(rs.transport_info.trans_com_per_bosta)) {
        trans_com_per_bosta = parseFloat(rs.transport_info.trans_com_per_bosta);
      } else {
        trans_com_per_bosta = 0;
      }
      if ($.isNumeric(rs.transport_info.ghar_kuli_rates_per_bosta)) {
        ghar_kuli_rates_per_bosta = parseFloat(rs.transport_info.ghar_kuli_rates_per_bosta);
      } else {
        ghar_kuli_rates_per_bosta = 0;
      }
      if ($.isNumeric(rs.pur_item_info.pur_kg_per_bosta)) {
        pur_kg_per_bosta = parseFloat(rs.pur_item_info.pur_kg_per_bosta);
      } else {
        pur_kg_per_bosta = 0;
      }
      if ($.isNumeric(rs.pur_item_info.price_per_unit)) {
        price_per_unit = parseFloat(rs.pur_item_info.price_per_unit);
      } else {
        price_per_unit = 0;
      }


      if ($.isNumeric(rs.transport_info.supp_commis_items_wsss)) {
        pur_supp_commission = parseFloat(rs.transport_info.supp_commis_items_wsss);
      } else {
        pur_supp_commission = 0;
      }

      let trans_cost_figures = ttl_trans_other_cost + driver_advance_amnt_cost + others_cost_amnt_for_trans + pur_supp_commission;
      let ttl_trans_costss_ss = ttl_trans_other_cost + driver_advance_amnt_cost + others_cost_amnt_for_trans + pur_supp_commission;
      let trans_cost_per_item_wise = trans_cost_figures / ttl_items_bosta_this_trans;
      let cost_per_bosta = trans_com_per_bosta + ghar_kuli_rates_per_bosta + trans_cost_per_item_wise;

      let ttl_costss_all = trans_cost_figures;
      let costs_per_kg_all = ttl_costss_all / parseFloat(rs.transport_info.ttl_item_kg_trans);

      let ttl_cost_per_kg = (cost_per_bosta / pur_kg_per_bosta);


      $('.ref_lots_nos_s').val(rs.pur_item_info.lot_trns_ref_nop_s);
      $('.pur_item_info_displays').html(`<table class="table table-condensed table-bordered table-striped table-responsive " >
                      <tr>
                          <td>পন্যের নাম</td>
                          <td class=" product_lot_ref_namess " >${rs.pur_item_info.ref_lot_no}</td>
                      </tr>
                      <tr>
                          <td>স্টকে আছে</td>
                          <td><span class="ttl_stock_s" >${rs.pur_item_info.due_sells_bosta_ss}</span> ${rs.pur_item_info.unit_name}</td>
                      </tr>
                      <tr>
                          <td>প্রতি কেজির কেনা দাম</td>
                          <td><span>${price_per_unit}</span> টাকা</td>
                      </tr>
                      <tr>
                          <td>কেজি প্রতি খরচ</td>
                          <td><span>${costs_per_kg_all.toFixed(2)}</span> টাকা</td>
                      </tr>
                      <tr>
                          <td>প্রতি কেজির মোট দাম</td>
                          <td><span class="sell_rate_per_kg " >${(price_per_unit + costs_per_kg_all).toFixed(4)}</span> টাকা</td>
                      </tr>
                      <tr>
                          <td>মোট কেজি ছিলো</td>
                          <td>${rs.pur_item_info.ttl_purchase_kg_sss} কেজি</td>
                      </tr>
                      <tr>
                          <td>১ ${rs.pur_item_info.unit_name}তে ছিলো</td>
                          <td><span class="buy_per_kgss">${rs.pur_item_info.pur_kg_per_bosta}</span> কেজি</td>
                      </tr>
                    </table>
                    <div class="row">
                      <div class="col-md-4 "> 
                          <label for="mallll1">পন্যের পরিমান </label>
                          <input type="text" id="mallll1" class="form-control ttl_qnty_items " inputmode="numeric"  value="" placeholder="কতো বস্তা">
                          <label for="mallll1" class="stock_in_bosta_valid" style="font-weight: normal; " > </label>
                      </div>
                      <div class="col-md-4 ">
                          <label for="pon2">মোট কেজি </label>
                          <input type="text" id="pon2" class="form-control kgs_per_bosta_qnt " inputmode="numeric"  value="" placeholder="মোট কেজির পরিমাণ">
                          <label for="pon2" class="kgs_per_bostass_valid" style="font-weight: normal; " > </label>
                      </div>
                      <div class="col-md-4 ">
                          <label for="rattt">পন্যের দাম</label>
                          <input type="text" id="rattt" placeholder="পন্যের রেট" inputmode="numeric"  class="form-control item_unit_rate_per_kg " value="">
                          <label for="rattt" class="item_unit_rate_per_kgs_valid" style="font-weight: normal; " ></label>
                      </div>
                    </div>
                    <center>
                      <div class="btn btn-info mx-auto add_item_in_pos_tbl " pur_trans_attr_i_get="${rs.transport_info.db_purchase_transports_info_a_idd}" items_iddd_ss="${rs.transport_info.products_items_at_ididii}" pur_item_id_attrs="${rs.pur_item_info.id}" style="margin-top: 5px;">যোগ করুন</div>
                    </center>`);
    }
  });
});

// sdasdadasd



$(document).on('click', '.clickable_get_ref_datas', function () {
  let transport_id = $(this).attr('trans_ids');
  let this_click_pur_trans_attr_id = $(this).attr('pur_trans_id_attr');
  $.ajax({
    type: "post",
    url: "sales/get_items_details_by_purchase_item_id",
    data: {
      pt_id: this_click_pur_trans_attr_id
    },
    success: function (rs) {
      $('.pur_item_info_displays').html('');

      let ttl_trans_com;
      let ttl_item_kg_trans;
      let ttal_ghar_kuli_cost_amnt;

      let items_lists = '';
      let ttl_trans_other_cost;
      let driver_advance_amnt_cost;
      let others_cost_amnt_for_trans;
      let ttl_items_bosta_this_trans;
      let trans_com_per_bosta;
      let ghar_kuli_rates_per_bosta;
      let pur_supp_commission;


      //   let ttl_costttttts = ttl_trans_other_cost + ttl_trans_com + ttal_ghar_kuli_cost_amnt + driver_advance_amnt_cost + supp_commis_items_wsss + others_cost_amnt_for_trans + total_trans_price - koifiyat_amount_tk_for_this_trans

      if ($.isNumeric(rs.transport_info.ttl_trans_com)) {
        ttl_trans_com = parseFloat(rs.transport_info.ttl_trans_com);
      } else {
        ttl_trans_com = 0;
      }

      if ($.isNumeric(rs.transport_info.ttal_ghar_kuli_cost_amnt)) {
        ttal_ghar_kuli_cost_amnt = parseFloat(rs.transport_info.ttal_ghar_kuli_cost_amnt);
      } else {
        ttal_ghar_kuli_cost_amnt = 0;
      }

      if ($.isNumeric(rs.transport_info.ttl_item_kg_trans)) {
        ttl_item_kg_trans = parseFloat(rs.transport_info.ttl_item_kg_trans);
      } else {
        ttl_item_kg_trans = 0;
      }


      if ($.isNumeric(rs.transport_info.ttl_trans_other_cost)) {
        ttl_trans_other_cost = parseFloat(rs.transport_info.ttl_trans_other_cost);
      } else {
        ttl_trans_other_cost = 0;
      }

      if ($.isNumeric(rs.transport_info.driver_advance_amnt_cost)) {
        driver_advance_amnt_cost = parseFloat(rs.transport_info.driver_advance_amnt_cost);
      } else {
        driver_advance_amnt_cost = 0;
      }

      if ($.isNumeric(rs.transport_info.others_cost_amnt_for_trans)) {
        others_cost_amnt_for_trans = parseFloat(rs.transport_info.others_cost_amnt_for_trans);
      } else {
        others_cost_amnt_for_trans = 0;
      }

      if ($.isNumeric(rs.transport_info.ttl_items_bosta_this_trans)) {
        ttl_items_bosta_this_trans = parseFloat(rs.transport_info.ttl_items_bosta_this_trans);
      } else {
        ttl_items_bosta_this_trans = 0;
      }

      if ($.isNumeric(rs.transport_info.trans_com_per_bosta)) {
        trans_com_per_bosta = parseFloat(rs.transport_info.trans_com_per_bosta);
      } else {
        trans_com_per_bosta = 0;
      }

      if ($.isNumeric(rs.transport_info.ghar_kuli_rates_per_bosta)) {
        ghar_kuli_rates_per_bosta = parseFloat(rs.transport_info.ghar_kuli_rates_per_bosta);
      } else {
        ghar_kuli_rates_per_bosta = 0;
      }

      if ($.isNumeric(rs.transport_info.supp_commis_items_wsss)) {
        pur_supp_commission = parseFloat(rs.transport_info.supp_commis_items_wsss);
      } else {
        pur_supp_commission = 0;
      }
      //   ttl_trans_com
      // ttl_item_kg_trans


      let trans_cost_figures = ttl_trans_other_cost + driver_advance_amnt_cost + others_cost_amnt_for_trans + pur_supp_commission;
      let ttl_trans_costss_ss = ttl_trans_other_cost + driver_advance_amnt_cost + others_cost_amnt_for_trans + pur_supp_commission;
      let trans_cost_per_item_wise = trans_cost_figures / ttl_items_bosta_this_trans;
      let cost_per_bosta = trans_com_per_bosta + ghar_kuli_rates_per_bosta + trans_cost_per_item_wise;

      let ttl_costss_all = trans_cost_figures + ttal_ghar_kuli_cost_amnt + ttl_trans_com;
      let costs_per_kg_all = ttl_costss_all / parseFloat(rs.transport_info.ttl_item_kg_trans);


      let item_imagess = rs.product_info.item_image ? `uploads/items/${rs.product_info.item_image}` : 'theme/images/no_image.png';

      for (let n = 0; n < rs.purchase_item_infos.length; n++) {
        let pur_kg_per_bosta;
        let price_per_unit;

        if ($.isNumeric(rs.purchase_item_infos[n].pur_kg_per_bosta)) {
          pur_kg_per_bosta = parseFloat(rs.purchase_item_infos[n].pur_kg_per_bosta);
        } else {
          pur_kg_per_bosta = 0;
        }

        if ($.isNumeric(rs.purchase_item_infos[n].price_per_unit)) {
          price_per_unit = parseFloat(rs.purchase_item_infos[n].price_per_unit)
        } else {
          price_per_unit = 0;
        }

        let rates_per_bosta = (price_per_unit * pur_kg_per_bosta) + cost_per_bosta;
        let rates_per_kgs = costs_per_kg_all + price_per_unit;

        items_lists += `<div class="col-md-3 col-xs-6 " title="" style="padding-left:5px;padding-right:5px;" >
                            <div class="box box-default pur_item_box " pur_trans_auto_iddd="${rs.purchase_item_infos[n].purchase_trans_info_auto_pr_iddds}" pur_items_uniq_id="${rs.purchase_item_infos[n].id}" id="div_1" style="max-height: 150px;min-height: 150px;cursor: pointer;background-color:#c8c8c8; border: 2px solid black; ">
                              <span class="label label-danger push-right" style="font-weight: bold;font-family: sans-serif;" >
                                Qty: ${rs.purchase_item_infos[n].due_sells_bosta_ss}-${rs.product_info.unit_name} 
                              </span>
                              <div class="box-body box-profile">
                                  <center>
                                    <img class=" img-responsive item_image" style="border: 1px solid gray; max-height: 75px; width: 115px; " src="${item_imagess}" alt="Item picture">
                                  </center>
                                  <lable class="text-center search_item" style="font-weight: bold; font-family: sans-serif; " id="item_0">
                                    ${rs.purchase_item_infos[n].ref_lot_no} <br>   
                                    <span class="" style="font-family: sans-serif; ">
                                        ৳ <span class="rate_per_kg_clss ">${rates_per_kgs.toFixed(2)}</span>
                                    </span>
                                  </lable>
                              </div>
                            </div>
                        </div>`;
      }
      $('.ref_lots_nos_s').val(``);
      $('.ttl_data_show_rows').html(items_lists);
      $('.submit_btn_selling_sys').html('');
    }
  });
});

$(document).on('click', '.pur_item_box', function () {
  $.ajax({
    type: "post",
    url: "sales/get_purchases_all_info_for_sales_item",
    data: {
      pur_item_id: $(this).attr('pur_items_uniq_id'),
      pur_tran_id: $(this).attr('pur_trans_auto_iddd')
    },
    success: function (rs) {

      let pur_kg_per_bosta;
      let price_per_unit;

      let ttl_trans_com;
      let ttl_item_kg_trans;
      let ttal_ghar_kuli_cost_amnt;

      let items_lists = '';
      let ttl_trans_other_cost;
      let driver_advance_amnt_cost;
      let others_cost_amnt_for_trans;
      let ttl_items_bosta_this_trans;
      let trans_com_per_bosta;
      let ghar_kuli_rates_per_bosta;
      let pur_supp_commission;


      //   let ttl_costttttts = ttl_trans_other_cost + ttl_trans_com + ttal_ghar_kuli_cost_amnt + driver_advance_amnt_cost + supp_commis_items_wsss + others_cost_amnt_for_trans + total_trans_price - koifiyat_amount_tk_for_this_trans

      if ($.isNumeric(rs.transport_info.ttl_trans_com)) {
        ttl_trans_com = parseFloat(rs.transport_info.ttl_trans_com);
      } else {
        ttl_trans_com = 0;
      }

      if ($.isNumeric(rs.transport_info.ttal_ghar_kuli_cost_amnt)) {
        ttal_ghar_kuli_cost_amnt = parseFloat(rs.transport_info.ttal_ghar_kuli_cost_amnt);
      } else {
        ttal_ghar_kuli_cost_amnt = 0;
      }

      if ($.isNumeric(rs.transport_info.ttl_item_kg_trans)) {
        ttl_item_kg_trans = parseFloat(rs.transport_info.ttl_item_kg_trans);
      } else {
        ttl_item_kg_trans = 0;
      }


      if ($.isNumeric(rs.transport_info.ttl_trans_other_cost)) {
        ttl_trans_other_cost = parseFloat(rs.transport_info.ttl_trans_other_cost);
      } else {
        ttl_trans_other_cost = 0;
      }
      if ($.isNumeric(rs.transport_info.driver_advance_amnt_cost)) {
        driver_advance_amnt_cost = parseFloat(rs.transport_info.driver_advance_amnt_cost);
      } else {
        driver_advance_amnt_cost = 0;
      }
      if ($.isNumeric(rs.transport_info.others_cost_amnt_for_trans)) {
        others_cost_amnt_for_trans = parseFloat(rs.transport_info.others_cost_amnt_for_trans);
      } else {
        others_cost_amnt_for_trans = 0;
      }
      if ($.isNumeric(rs.transport_info.ttl_items_bosta_this_trans)) {
        ttl_items_bosta_this_trans = parseFloat(rs.transport_info.ttl_items_bosta_this_trans);
      } else {
        ttl_items_bosta_this_trans = 0;
      }
      if ($.isNumeric(rs.transport_info.trans_com_per_bosta)) {
        trans_com_per_bosta = parseFloat(rs.transport_info.trans_com_per_bosta);
      } else {
        trans_com_per_bosta = 0;
      }
      if ($.isNumeric(rs.transport_info.ghar_kuli_rates_per_bosta)) {
        ghar_kuli_rates_per_bosta = parseFloat(rs.transport_info.ghar_kuli_rates_per_bosta);
      } else {
        ghar_kuli_rates_per_bosta = 0;
      }
      if ($.isNumeric(rs.pur_item_info.pur_kg_per_bosta)) {
        pur_kg_per_bosta = parseFloat(rs.pur_item_info.pur_kg_per_bosta);
      } else {
        pur_kg_per_bosta = 0;
      }
      if ($.isNumeric(rs.pur_item_info.price_per_unit)) {
        price_per_unit = parseFloat(rs.pur_item_info.price_per_unit);
      } else {
        price_per_unit = 0;
      }


      if ($.isNumeric(rs.transport_info.supp_commis_items_wsss)) {
        pur_supp_commission = parseFloat(rs.transport_info.supp_commis_items_wsss);
      } else {
        pur_supp_commission = 0;
      }
      //   ttl_trans_com
      // ttl_item_kg_trans


      let trans_cost_figures = ttl_trans_other_cost + driver_advance_amnt_cost + others_cost_amnt_for_trans + pur_supp_commission;
      let ttl_trans_costss_ss = ttl_trans_other_cost + driver_advance_amnt_cost + others_cost_amnt_for_trans + pur_supp_commission;
      let trans_cost_per_item_wise = trans_cost_figures / ttl_items_bosta_this_trans;
      let cost_per_bosta = trans_com_per_bosta + ghar_kuli_rates_per_bosta + trans_cost_per_item_wise;

      let ttl_costss_all = trans_cost_figures + ttal_ghar_kuli_cost_amnt + ttl_trans_com;
      let costs_per_kg_all = ttl_costss_all / parseFloat(rs.transport_info.ttl_item_kg_trans);
      let ttl_cost_per_kg = (cost_per_bosta / pur_kg_per_bosta);

      $('.ref_lots_nos_s').val(rs.pur_item_info.lot_trns_ref_nop_s);
      $('.pur_item_info_displays').html(`<table class="table table-condensed table-bordered table-striped table-responsive " >
                        <tr>
                            <td>পন্যের নাম</td>
                            <td class=" product_lot_ref_namess " >${rs.pur_item_info.ref_lot_no}</td>
                        </tr>
                        <tr>
                            <td>স্টকে আছে</td>
                            <td><span class="ttl_stock_s" >${rs.pur_item_info.due_sells_bosta_ss}</span> ${rs.pur_item_info.unit_name}</td>
                        </tr>
                        <tr>
                            <td>প্রতি কেজির কেনা দাম</td>
                            <td><span>${price_per_unit}</span> টাকা</td>
                        </tr>
                        <tr>
                            <td>কেজি প্রতি খরচ</td>
                            <td><span>${costs_per_kg_all.toFixed(2)}</span> টাকা</td>
                        </tr>
                        <tr>
                            <td>প্রতি কেজির মোট দাম</td>
                            <td><span class="sell_rate_per_kg " >${(price_per_unit + costs_per_kg_all).toFixed(4)}</span> টাকা</td>
                        </tr>
                        <tr>
                            <td>মোট কেজি ছিলো</td>
                            <td>${rs.pur_item_info.ttl_purchase_kg_sss} কেজি</td>
                        </tr>
                        <tr>
                            <td>১ ${rs.pur_item_info.unit_name}তে ছিলো</td>
                            <td><span class="buy_per_kgss">${rs.pur_item_info.pur_kg_per_bosta}</span> কেজি</td>
                        </tr>
                      </table>
                      <div class="row">
                        <div class="col-md-4 "> 
                            <label for="mallll1">পন্যের পরিমান </label>
                            <input type="text" id="mallll1" class="form-control ttl_qnty_items " inputmode="numeric"  value="" placeholder="কতো বস্তা">
                            <label for="mallll1" class="stock_in_bosta_valid" style="font-weight: normal; " > </label>
                        </div>
                        <div class="col-md-4 ">
                            <label for="pon2">মোট কেজি </label>
                            <input type="text" id="pon2" class="form-control kgs_per_bosta_qnt " inputmode="numeric"  value="" placeholder="মোট কেজির পরিমাণ">
                            <label for="pon2" class="kgs_per_bostass_valid" style="font-weight: normal; " > </label>
                        </div>
                        <div class="col-md-4 ">
                            <label for="rattt">পন্যের দাম</label>
                            <input type="text" id="rattt" placeholder="পন্যের রেট" inputmode="numeric" class="form-control item_unit_rate_per_kg " value="">
                            <label for="rattt" class="item_unit_rate_per_kgs_valid" style="font-weight: normal; " ></label>
                        </div>
                      </div>
                      <center>
                        <div class="btn btn-info mx-auto add_item_in_pos_tbl " pur_trans_attr_i_get="${rs.transport_info.db_purchase_transports_info_a_idd}" items_iddd_ss="${rs.transport_info.products_items_at_ididii}" pur_item_id_attrs="${rs.pur_item_info.id}" style="margin-top: 5px;">যোগ করুন</div>
                      </center>`);
    }
  });
});


$(document).on('click', '.add_item_in_pos_tbl', function () {
  let id = $(this).attr('pur_item_id_attrs');
  let items_idss = $(this).attr('items_iddd_ss');
  let trans_id = $(this).attr('pur_trans_attr_i_get');
  let prodct_name = $('.product_lot_ref_namess').html();
  let kg_per_bst = $('.kgs_per_bosta_qnt').val();
  let qnty_s_bosta = $('.ttl_qnty_items').val();
  let rate_per_kg = $('.item_unit_rate_per_kg').val();
  let sell_rate_per_kg = $('.sell_rate_per_kg').html();
  if (kg_per_bst != '' || kg_per_bst != 0 || qnty_s_bosta != '' || qnty_s_bosta != 0 || rate_per_kg != '' || rate_per_kg != 0) {
    if ($('.add_items_id_' + id)[0]) {
      toastr["warning"]("এই পন্যটি আগে যুক্ত করা আছে, চেক করুন।");
    } else {
      let ttl_prices = parseFloat(kg_per_bst) * parseFloat(rate_per_kg);
      $('.pos_item_adding_tbl').append(`<tr id="row_0" class="add_items_id_${id} items_table_row " items_unq_id_attr="${id}" items_trans_id_attr="${trans_id}" salling_rates="${sell_rate_per_kg}" items_uniq_iddd="${items_idss}" style="border-bottom: 2px dotted rgb(51, 122, 183);">
                        <td id="">
                          <a class="pointer" id="" style="color: black; ">
                              ${prodct_name}
                          </a> 
                        </td>
                        <td id="td_0_2">
                          <input name="item_discount_0" type="text" class="form-control no-padding min_width text-center ttl_bosta_qnty_ss "  inputmode="numeric" onkeydown="return false;" onkeypress="return false;" value="${qnty_s_bosta}" >
                        </td>
                        <td id="">
                          <input name="item_discount_0" title="এক বস্তাতে কতো কেজি" type="text" class="form-control no-padding min_width text-center ttl_sell_kgs_this_product kgs_per_bosta_qntssss " inputmode="numeric" onkeydown="return false;" onkeypress="return false;" value="${kg_per_bst}" >
                        </td>
                        <td id="td_0_3" class="text-right">
                          <input id="sales_price_0" name="sales_price_0" type="text" class="form-control no-padding min_width text-center rates_per_kgsss " inputmode="numeric"  onkeydown="return false;" onkeypress="return false;"  value="${rate_per_kg}">
                        </td>
                        <td id="td_0_11" class="">
                          <input  name="td_data_0_11" type="text" class="form-control ttl_item_pricess_thiss no-padding min_width text-center ttls_saless_prices " inputmode="numeric"  onkeydown="return false;" onkeypress="return false;"    value="${ttl_prices}">
                        </td>
                        <td class="pointer " id="td_0_5">
                          <a class="fa fa-fw fa-trash-o text-red delete_this_item_from_pos " style=" font-size: 20px; margin-top: 5px; " title="Delete Item?"></a>
                        </td>
                      </tr>`);
      $('.pur_item_info_displays').html('');
    }
  }

  $('.item_unit_rate_per_kg').val('');
  $('.kgs_per_bosta_qnt').val('');
  $('.ttl_qnty_items').val('');

});


$(document).on('click', '.delete_this_item_from_pos', function () {
  $(this).parents('.items_table_row').remove();
});

$(document).on('click', '.check_all_item_calc', function () {

  let sum_total = 0;
  $('.ttl_item_pricess_thiss').each(function () {
    let ttl_pricess = $(this).val();
    if ($.isNumeric(ttl_pricess)) {
      sum_total += parseFloat(ttl_pricess);
    }
  });

  let cus_uniqs_idssss = $('.customer_uniqs_id').val();

  if (cus_uniqs_idssss === null || cus_uniqs_idssss === '') {
    toastr["error"]("কাস্টমার সিলেক্ট করুন। ");
    $('.sales_item_calc_assigns').html('');
  } else {

    $.ajax({
      type: "post",
      url: "sales/get_purchases_customer_infos_by_id",
      data: {
        cus_idd: cus_uniqs_idssss
      },
      success: function (rs) {

        $('.sales_item_calc_assigns').html(
          `<table class="table table-bordered table-striped table-responsive " style="font-size: 17px;" >
            <tr>
                <td>মালের দাম</td>
                <td class="  " >
                  <input type="text" name="" class="form-control ttl_item_priceses "  readonly="readonly"  style="text-align: right; font-size: 18px; font-weight: bold; " inputmode="numeric"  value="${sum_total}">
                </td>
            </tr>
            <tr>
                <td>লেবার খরচ</td>
                <td class="  " >
                  <input type="text" name="" class="form-control lebar_cost_plus " inputmode="numeric"  style="text-align: right; " value="">
                </td>
            </tr>
            <tr>
                <td>ঘাট/ভাড়া খরচ</td>
                <td class="  " >
                  <input type="text" name="" class="form-control ghat_vara_cost_plus " inputmode="numeric"  style="text-align: right; " value="">
                </td>
            </tr>
            <tr>
                <td>বিক্রয় মারফত</td>
                <td class="  " >
                  <textarea cols="60" rows="2" class="form-control sales_item_carring_system " ></textarea>
                </td>
            </tr>
            <tr>
                <td>কৈফিয়ত</td>
                <td class="  " >
                  <input type="text" name="" class="form-control discount_cost_minus " inputmode="numeric"  style="text-align: right; " value="">
                </td>
            </tr>
            <tr>
                <td>সাবেক</td>
                <td class="  " >
                  <input type="text" name="" class="form-control previous_due_of_customers " inputmode="numeric"   style="text-align: right; " value="${rs.sales_due}">
                </td>
            </tr>
            <tr>
                <td>মোট টাকা </td>
                <td class="  " >
                  <input type="text" name="" class="form-control ttl_customer_amountss " readonly style="text-align: right; font-size: 18px; font-weight: bold;  " inputmode="numeric"  value="${sum_total + parseFloat(rs.sales_due)}">
                </td>
            </tr>
            <tr>
                <td>জমা</td>
                <td class="  " >
                  <input type="text" name="" class="form-control paid_this_sales_amountss " inputmode="numeric"  style="text-align: right; " value="">
                </td>
            </tr>
            <tr>
                <td>বকেয়া</td>
                <td class="  " >
                  <input type="text" name="" class="form-control due_of_customer_sales_amountss " readonly="readonly" style="text-align: right; font-size: 18px; font-weight: bold;  " inputmode="numeric"  value="${sum_total + parseFloat(rs.sales_due)}">
                </td>
            </tr>
          </table>
          <center class=" " >
            <div class="btn btn-lg btn-primary items_sell_btn " style="font-size: 24px; " >বিক্রয় করুন</div>
          </center>`
        );
      }
    });

  }
});

$(document).on('change', '.customer_uniqs_id', function () {
  $('.sales_item_calc_assigns').html('');
});

$(document).on('keyup', '.lebar_cost_plus, .ghat_vara_cost_plus, .discount_cost_minus, .previous_due_of_customers, .paid_this_sales_amountss', function () {

  let ttl_item_sales_price;
  let lebar_cost;
  let ghat_vara_cost;
  let discount_cost;
  let previous_customer_due;
  let ttl_customer_amount;
  let paid_amount;
  let due_amounts;

  if ($.isNumeric($('.ttl_item_priceses').val())) {
    ttl_item_sales_price = parseFloat($('.ttl_item_priceses').val());
  } else {
    ttl_item_sales_price = 0;
  }

  if ($.isNumeric($('.lebar_cost_plus').val())) {
    lebar_cost = parseFloat($('.lebar_cost_plus').val());
  } else {
    lebar_cost = 0;
  }

  if ($.isNumeric($('.ghat_vara_cost_plus').val())) {
    ghat_vara_cost = parseFloat($('.ghat_vara_cost_plus').val());
  } else {
    ghat_vara_cost = 0;
  }

  if ($.isNumeric($('.discount_cost_minus').val())) {
    discount_cost = parseFloat($('.discount_cost_minus').val());
  } else {
    discount_cost = 0;
  }

  if ($.isNumeric($('.previous_due_of_customers').val())) {
    previous_customer_due = parseFloat($('.previous_due_of_customers').val());
  } else {
    previous_customer_due = 0;
  }

  if ($.isNumeric($('.ttl_customer_amountss').val())) {
    ttl_customer_amount = parseFloat($('.ttl_customer_amountss').val());
  } else {
    ttl_customer_amount = 0;
  }

  if ($.isNumeric($('.paid_this_sales_amountss').val())) {
    paid_amount = parseFloat($('.paid_this_sales_amountss').val());
  } else {
    paid_amount = 0;
  }

  if ($.isNumeric($('.due_of_customer_sales_amountss').val())) {
    due_amounts = parseFloat($('.due_of_customer_sales_amountss').val());
  } else {
    due_amounts = 0;
  }

  $('.ttl_customer_amountss').val((ttl_item_sales_price + lebar_cost + ghat_vara_cost + previous_customer_due) - discount_cost);
  $('.due_of_customer_sales_amountss').val((ttl_item_sales_price + lebar_cost + ghat_vara_cost + previous_customer_due) - (paid_amount + discount_cost));

});

$(document).on('click', '.items_sell_btn', function () {

  if ($('.customer_uniqs_id option:selected').val() == 1) {
    if (parseInt($('.due_of_customer_sales_amountss').val()) > 0) {
      Swal.fire({
        title: "<strong>বিক্রয় বকেয়া হবে না</strong>",
        icon: "error",
        html: `সাধারণ কাস্টমারের ক্ষেত্রে বকেয়া রাখা যাবে না।`,
        showConfirmButton: false,
      });
    } else {

      if (confirm("আপনি কি বিক্রয় করতে চান? ")) {

        $.ajax({
          type: "post",
          url: "sales/sales_this_product_qnty",
          data: {
            'ttl_qnty[]': $('.ttl_bosta_qnty_ss').map(function () { return this.value; }).get(),
            'tt_kg_sales[]': $('.ttl_sell_kgs_this_product').map(function () { return this.value; }).get(),
            'rate_per_kg[]': $('.rates_per_kgsss').map(function () { return this.value; }).get(),
            'ttl_sale_price[]': $('.ttls_saless_prices').map(function () { return this.value; }).get(),
            'item_unq_ids[]': $('.items_table_row').map(function () { return $(this).attr("items_uniq_iddd"); }).toArray(),
            'item_uniq_id[]': $('.items_table_row').map(function () { return $(this).attr("items_unq_id_attr"); }).toArray(),
            'trans_uniq_id[]': $('.items_table_row').map(function () { return $(this).attr("items_trans_id_attr"); }).toArray(),
            'salling_rates[]': $('.items_table_row').map(function () { return $(this).attr("salling_rates"); }).toArray(),
            'cus_uniq': $('.customer_uniqs_id option:selected').val(),
            'sale_date': $('.sales_datess').val(),
            'sale_type': $('.sales_status_type option:selected').val(),
            'trans_ref_no': $('.ref_lots_nos_s').val(),
            'items_uniq': $('.selected_products_item option:selected').val(),
            'ttl_item_price': $('.ttl_item_priceses').val(),
            'lebar_cost': $('.lebar_cost_plus').val(),
            'ghat_vara': $('.ghat_vara_cost_plus').val(),
            'discount_s': $('.discount_cost_minus').val(),
            'cus_prev_amnt': $('.previous_due_of_customers').val(),
            'ttl_cus_amount': $('.ttl_customer_amountss').val(),
            'paid_amount_ss': $('.paid_this_sales_amountss').val(),
            'due_cus_amount': $('.due_of_customer_sales_amountss').val(),
            'carring_system': $('.sales_item_carring_system').val(),
            'n_cust_name': $('.normal_cust_namess').val(),
            'n_cust_mobile': $('.normanl_cust_mobile_no_s').val(),
            'n_cust_address': $('.normal_customer_full_address').val(),
          },
          beforeSend: function () {
            $('.spiner_load_activity').css('display', 'block');
          },
          complete: function () {
            $('.spiner_load_activity').css('display', 'none');
          },
          success: function (rs) {

            if (parseInt(rs) == 0) {
              toastr["error"]("আপনার কোথাও ভুল হচ্ছে, চেক করুন। ");
            } else {
              $('.ttl_data_show_rows').html('');
              $('.nav_assign_ul_data').html('');
              $('.pur_item_info_displays').html('');
              $('.pos_item_adding_tbl').html('');
              $('.sales_item_calc_assigns').html('');
              $('.submit_btn_selling_sys').html('');
              $('.normal_cust_namess').val('');
              $('.normanl_cust_mobile_no_s').val('');
              $('.normal_customer_full_address').val('');
              toastr["success"]("আপনার বিক্রয় সফল হয়েছে। ");
              Swal.fire({
                title: "<strong>বিক্রয় সফল</strong>",
                icon: "success",
                html: `আপনার বিক্রয় সফল হয়েছে, আপনি এখন স্লিপ প্রিন্ট করে নেন <br> <a class="btn btn-info" onclick="window.open('sales/sales_receipt_view_fun?sales_id=${rs}','_blank', 'width=800,height=800,left=300,top=300')" style="font-size: 18px; " > <i class="fa fa-print" ></i> Print </a>`,
                showConfirmButton: false,
              });
              sell.play();
            }
          }
        });

      } else {
        return false;
      }
    }
  } else {

    if (confirm("আপনি কি বিক্রয় করতে চান? ")) {

      $.ajax({
        type: "post",
        url: "sales/sales_this_product_qnty",
        data: {
          'ttl_qnty[]': $('.ttl_bosta_qnty_ss').map(function () { return this.value; }).get(),
          'tt_kg_sales[]': $('.ttl_sell_kgs_this_product').map(function () { return this.value; }).get(),
          'rate_per_kg[]': $('.rates_per_kgsss').map(function () { return this.value; }).get(),
          'ttl_sale_price[]': $('.ttls_saless_prices').map(function () { return this.value; }).get(),
          'item_unq_ids[]': $('.items_table_row').map(function () { return $(this).attr("items_uniq_iddd"); }).toArray(),
          'item_uniq_id[]': $('.items_table_row').map(function () { return $(this).attr("items_unq_id_attr"); }).toArray(),
          'trans_uniq_id[]': $('.items_table_row').map(function () { return $(this).attr("items_trans_id_attr"); }).toArray(),
          'salling_rates[]': $('.items_table_row').map(function () { return $(this).attr("salling_rates"); }).toArray(),
          'cus_uniq': $('.customer_uniqs_id option:selected').val(),
          'sale_date': $('.sales_datess').val(),
          'sale_type': $('.sales_status_type option:selected').val(),
          'trans_ref_no': $('.ref_lots_nos_s').val(),
          'items_uniq': $('.selected_products_item option:selected').val(),
          'ttl_item_price': $('.ttl_item_priceses').val(),
          'lebar_cost': $('.lebar_cost_plus').val(),
          'ghat_vara': $('.ghat_vara_cost_plus').val(),
          'discount_s': $('.discount_cost_minus').val(),
          'cus_prev_amnt': $('.previous_due_of_customers').val(),
          'ttl_cus_amount': $('.ttl_customer_amountss').val(),
          'paid_amount_ss': $('.paid_this_sales_amountss').val(),
          'due_cus_amount': $('.due_of_customer_sales_amountss').val(),
          'carring_system': $('.sales_item_carring_system').val(),
        },
        beforeSend: function () {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function () {
          $('.spiner_load_activity').css('display', 'none');
        },
        success: function (rs) {

          if (parseInt(rs) == 0) {
            toastr["error"]("আপনার কোথাও ভুল হচ্ছে, চেক করুন। ");
          } else {
            $('.ttl_data_show_rows').html('');
            $('.nav_assign_ul_data').html('');
            $('.pur_item_info_displays').html('');
            $('.pos_item_adding_tbl').html('');
            $('.sales_item_calc_assigns').html('');
            $('.submit_btn_selling_sys').html('');
            toastr["success"]("আপনার বিক্রয় সফল হয়েছে। ");

            Swal.fire({
              title: "<strong>বিক্রয় সফল</strong>",
              icon: "success",
              html: `আপনার বিক্রয় সফল হয়েছে, আপনি এখন স্লিপ প্রিন্ট করে নেন <br> <a class="btn btn-info" onclick="window.open('sales/sales_receipt_view_fun?sales_id=${rs}','_blank', 'width=800,height=800,left=300,top=300')" style="font-size: 18px; " > <i class="fa fa-print" ></i> Print </a>`,
              showConfirmButton: false,
            });
            sell.play();
          }
        }
      });

    }
  }
});




$(document).on('change', '.select_selling_type', function () {
  let type_of_sell = $(this).val();
  if (type_of_sell == 1) {
    $('.set_selling_html_formate').html(
      `<div class="input-group">
            <span class="input-group-addon font20" id="basic-addon1">পরিমাণ</span>
            <input type="text" class="form-control font20 buying_quantity_bosta selling_qnt_bosta_s " placeholder="পরিমাণ" inputmode="numeric"  style="text-align: right; "   >
            <span class="input-group-addon font20">বস্তা</span>
        </div>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">প্রতি কেজির দাম </span>
            <input type="text" class="form-control font20 prices_per_kgs selling_price_per_kg_ss " placeholder="পরিমাণ" inputmode="numeric"  style="text-align: right; "   >
            <span class="input-group-addon font20">টাকা</span>
        </div>
        <span class="input-group-addon validation_for_lav_loss " ></span>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">এক বস্তাতে কতো কেজি</span>
            <input type="text" class="form-control font20 qnty_per_bosta selling_qnt_per_kg_ss " placeholder="পরিমাণ" inputmode="numeric"  style="text-align: right; "    >
            <span class="input-group-addon font20">কেজি</span>
        </div>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">প্রতি বস্তার দাম </span>
            <input type="text" inputmode="numeric"  class="form-control font20 prices_per_bostas  " placeholder="পরিমাণ" style="text-align: right; "   >
            <span class="input-group-addon font20">টাকা</span>
        </div>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">কৈফিয়ত </span>
            <input type="text" inputmode="numeric"  class="form-control font20 sell_discount_price " placeholder="পরিমাণ" style="text-align: right; "   >
            <span class="input-group-addon font20">টাকা</span>
        </div>
        <div class="input-group " style="margin-top: 10px; font-size: 25px; font-weight: bold; width: 100%; ">
          <div style="float: left;"> টোটাল </div>
          <div style="float: right;">
            <span class="total_price_of_sell">0.00 </span>
          </div>
        </div>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">জমা দিছে </span>
            <input type="text" class="form-control font20 sell_joma_dan " inputmode="numeric"  placeholder="পরিমাণ" style="text-align: right; "   >
            <span class="input-group-addon font20">টাকা</span>
        </div>
        <div class="input-group " style="margin-top: 10px; font-size: 20px; width: 100%; ">
          <div style="float: left;"> বকেয়া </div>
          <div style="float: right;">
            <span class="due_of_total_sell">0.00</span>
          </div>
        </div>
        <div class="input-group otirikto_lav_hoice " style="margin-top: 10px; font-size: 20px; width: 100%; ">
        </div>`
    );
    $('.submit_btn_selling_sys').html(`<div class="btn btn-success btn-lg selling_this_btn " style="font-size: 40px; font-weight: bold; " > বিক্রয় করুন </div>`);
  } else if (type_of_sell == 2) {
    $('.set_selling_html_formate').html(
      `<div class="input-group">
            <span class="input-group-addon font20" id="basic-addon1">পরিমাণ</span>
            <input type="text" class="form-control font20 buying_quantity_bosta selling_qnt_bosta_s " placeholder="পরিমাণ" inputmode="numeric"  style="text-align: right; "   >
            <span class="input-group-addon font20">বস্তা</span>
        </div>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">প্রতি কেজির প্রস্তাবিত দাম </span>
            <input type="text" class="form-control font20 prices_per_kgs selling_price_per_kg_ss" placeholder="পরিমাণ" inputmode="numeric"  style="text-align: right; "   >
            <span class="input-group-addon font20">টাকা</span>
        </div>
        <span class="input-group-addon validation_for_lav_loss " ></span>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">এক বস্তাতে কতো কেজি</span>
            <input type="text" class="form-control font20 qnty_per_bosta selling_qnt_per_kg_ss"  inputmode="numeric" placeholder="পরিমাণ" style="text-align: right; "    >
            <span class="input-group-addon font20">কেজি</span>
        </div>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">প্রতি বস্তার প্রস্তাবিত দাম</span>
            <input type="text" class="form-control font20 prices_per_bostas " inputmode="numeric"  placeholder="পরিমাণ" style="text-align: right; " >
            <span class="input-group-addon font20">টাকা</span>
        </div>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">কৈফিয়ত </span>
            <input type="text" class="form-control font20 sell_discount_price " inputmode="numeric"  placeholder="পরিমাণ" style="text-align: right; "   >
            <span class="input-group-addon font20">টাকা</span>
        </div>
        <div class="input-group " style="margin-top: 10px; font-size: 25px; font-weight: bold; width: 100%; ">
          <div style="float: left;"> টোটাল </div>
          <div style="float: right;">
            <span class="total_price_of_sell">0.00 </span>
          </div>
        </div>
        <div class="input-group " style="margin-top: 10px; ">
            <span class="input-group-addon font20" id="basic-addon1">জমা দিছে </span>
            <input type="text" class="form-control font20 sell_joma_dan " inputmode="numeric"  placeholder="পরিমাণ" style="text-align: right; "   >
            <span class="input-group-addon font20">টাকা</span>
        </div>
        <div class="input-group " style="margin-top: 10px; font-size: 20px; width: 100%; ">
          <div style="float: left;"> বকেয়া </div>
          <div style="float: right;">
            <span class="due_of_total_sell">0.00</span>
          </div>
        </div>
        <div class="input-group otirikto_lav_hoice " style="margin-top: 10px; font-size: 20px; width: 100%; ">
        </div>`
    );
    $('.submit_btn_selling_sys').html(`<div class="btn btn-success btn-lg selling_this_btn " style="font-size: 40px; font-weight: bold; " > বিক্রয় করুন </div>`);
  } else {
    $('.set_selling_html_formate').html('');
    $('.submit_btn_selling_sys').html('');
  }
});

$(document).on('keyup', '.qnty_per_bosta, .buying_quantity_bosta, .prices_per_kgs', function () {
  let sell_quantity_bosta = $('.buying_quantity_bosta').val();
  let kg_per_bosta = $('.qnty_per_bosta').val();
  let prices_per_kgs = $('.prices_per_kgs').val();
  if ($.isNumeric(sell_quantity_bosta)) {
    sell_quantity_bosta = parseFloat($('.buying_quantity_bosta').val());
  } else {
    sell_quantity_bosta = 0;
  }
  if ($.isNumeric(kg_per_bosta)) {
    kg_per_bosta = parseFloat($('.qnty_per_bosta').val());
  } else {
    kg_per_bosta = 0;
  }
  if ($.isNumeric(prices_per_kgs)) {
    prices_per_kgs = parseFloat($('.prices_per_kgs').val());
  } else {
    prices_per_kgs = 0;
  }

  let price_per_bosta = kg_per_bosta * prices_per_kgs;
  let total_price_of_sell = price_per_bosta * sell_quantity_bosta;

  $('.prices_per_bostas').val(price_per_bosta);
  $('.total_price_of_sell').html(total_price_of_sell);
  $('.due_of_total_sell').html(total_price_of_sell);
  $('.sell_joma_dan').val(0);
});

$(document).on('keyup', '.sell_joma_dan, .sell_discount_price', function () {
  let total_discount_price = $('.sell_discount_price').val();
  let sell_joma_dan = $('.sell_joma_dan').val();
  let total_price = $('.total_price_of_sell').html();
  if ($.isNumeric(total_discount_price)) {
    total_discount_price = parseFloat($('.sell_discount_price').val());
  } else {
    total_discount_price = 0;
  }
  if ($.isNumeric(sell_joma_dan)) {
    sell_joma_dan = parseFloat($('.sell_joma_dan').val());
  } else {
    sell_joma_dan = 0;
  }
  if ($.isNumeric(total_price)) {
    total_price = parseFloat($('.total_price_of_sell').html());
  } else {
    total_price = 0;
  }

  let due_of_total_sell = total_price - sell_joma_dan - total_discount_price;
  if (due_of_total_sell < 0) {
    $('.due_of_total_sell').html(0);
    // $('.sell_joma_dan').val(0);
    // $('.otirikto_lav_hoice').html(
    //     `<div style="float: left; color: red;"> অতিরিক্ত নিচ্ছেন </div>
    //     <div style="float: right; color: red; ">
    //       <span class="">${sell_joma_dan - total_price}</span>
    //     </div>`
    // );
  } else {
    $('.due_of_total_sell').html(due_of_total_sell);
    $('.otirikto_lav_hoice').html('');
  }
});




/*
$(document).on('click', '.selling_this_btn', function () { 
  if(confirm("আপনি কি বিক্রয় করতে আগ্রহী ? ")) {
    $.ajax({
      type: "post",
      url: "sales/sales_this_product_qnty",
      data: {
        product_ids:        $('.selected_products_item').val(),
        purchase_item_id:   $('.clickable_item_selected').attr('purchase_item_idss'),
        selling_type_1_2:   $('.select_selling_type').val(),
        selling_poriman:    $('.selling_qnt_bosta_s').val(),
        price_per_kg:       $('.selling_price_per_kg_ss').val(),
        qnt_kgs_per_bosta:  $('.selling_qnt_per_kg_ss').val(),
        prices_per_bosta:   $('.prices_per_bostas').val(),
        total_price_s:      $('.total_price_of_sell').html(),
        sell_jomass:        $('.sell_joma_dan').val(),
        sell_discount:      $('.sell_discount_price').val(),
        sell_due:           $('.due_of_total_sell').html(),
        customer_id:        $('.customer_uniqs_id').val(),
        sell_date:          $('.sales_datess').val(),
        reflot_no:          $('.ref_lots_nos_s').val(),
        purchase_auto_id:   $('.clickable_item_selected').attr('purchase_a_ids'),
      },
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
      success: function (rsp) {
        if (rsp == 1) {
          toastr["danger"]("আপনার কোথাও ভুল হচ্ছে, চেক করুন। "); 
        } else {
          $('.ttl_data_show_rows').html('');
          $('.set_selling_html_formate').html('');
          $('.submit_btn_selling_sys').html('');
          toastr["success"]("আপনার বিক্রয় সফল হয়েছে। ");
        }
        sell.play();
      }
    });
  }
});
*/

$(document).on('keyup', '.selling_qnt_bosta_s', function () {
  let sell_quantity = parseInt($(this).val());
  let total_due_qnty = parseInt($('.obosistho_malamal').html());
  if (sell_quantity > total_due_qnty) {
    alert('ভুল, এতো পরিমাণ পণ্য নেই।');
    $(this).val('');
  }
});

$(document).on('keyup', '.item_unit_rate_per_kg ', function () {
  let sales_prices_per_kg = parseFloat($(this).val());
  let purchase_price = parseFloat($('.sell_rate_per_kg').html());
  console.log(sales_prices_per_kg - purchase_price);
  if (0 > (sales_prices_per_kg - purchase_price)) {
    $('.validation_for_lav_loss').html(`<span style="color: red; "> আপনি লসে বিক্রি করতেছেন? </span>`);
    $('.item_unit_rate_per_kgs_valid').html(`<span style="color: red; "> আপনি ${parseFloat(purchase_price - sales_prices_per_kg)} টাকা লসে বিক্রি করতেছেন? </span>`);
    $('.item_unit_rate_per_kg').css('background-color', '#f5adadff');
  } else {
    $('.validation_for_lav_loss').html(`<span style="color: green; "> আপনি ${parseFloat(sales_prices_per_kg - purchase_price).toFixed(3)} টাকা লাভে বিক্রি করতেছেন। </span>`);
    $('.item_unit_rate_per_kgs_valid').html(`<span style="color: green; "> আপনি ${parseFloat(sales_prices_per_kg - purchase_price).toFixed(3)} টাকা লাভে বিক্রি করতেছেন। </span>`);
    $('.item_unit_rate_per_kg').css('background-color', '#dff5e4ff');
  }
});





//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent, target) {

  if (kevent.keyCode == 13) {
    $("#" + target).focus();
  }

}


$('#save,#update').on("click", function (e) {
  var this_id = this.id;

  var base_url = $("#base_url").val().trim();

  //Initially flag set true
  var flag = true;

  function check_field(id) {

    if (!$("#" + id).val().trim()) //Also check Others????
    {

      $('#' + id + '_msg').fadeIn(200).show().html('Required Field').addClass('required');
      // $('#'+id).css({'background-color' : '#E8E2E9'});
      flag = false;
    }
    else {
      $('#' + id + '_msg').fadeOut(200).hide();
      //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
    }
  }


  //Validate Input box or selection box should not be blank or empty
  check_field("customer_id");
  check_field("sales_date");
  check_field("sales_status");
  //check_field("warehouse_id");
  /*if(!isNaN($("#amount").val().trim()) && parseFloat($("#amount").val().trim())==0){
        toastr["error"]("You have entered Payment Amount! <br>Please Select Payment Type!");
        return;
    }*/
  if (flag == false) {
    toastr["error"]("You have missed Something to Fillup!");
    return;
  }

  //Atleast one record must be added in sales table 
  var rowcount = document.getElementById("hidden_rowcount").value;
  var flag1 = false;
  for (var n = 1; n <= rowcount; n++) {
    if ($("#td_data_" + n + "_3").val() != null && $("#td_data_" + n + "_3").val() != '') {
      flag1 = true;
    }
  }

  if (flag1 == false) {
    toastr["warning"]("Please Select Item!!");
    $("#item_search").focus();
    return;
  }
  //end

  if (this_id == 'save' && $("#customer_id").val().trim() == 1) {
    if (parseFloat($("#total_amt").text()) != parseFloat($("#amount").val())) {
      $("#amount").focus();
      toastr["warning"]("Walk-in Customer Should Pay Complete Amount!!");
      return;
    }
    if ($("#payment_type").val() == '') {
      toastr["warning"]("Please Select Payment Type!!");
      return;
    }
  }

  var tot_subtotal_amt = $("#subtotal_amt").text();
  var other_charges_amt = $("#other_charges_amt").text();//other_charges include tax calcualated amount
  var tot_discount_to_all_amt = $("#discount_to_all_amt").text();
  var tot_round_off_amt = $("#round_off_amt").text();
  var tot_total_amt = $("#total_amt").text();



  //if(confirm("Do You Wants to Save Record ?")){
  e.preventDefault();
  data = new FormData($('#sales-form')[0]);//form name
  /*Check XSS Code*/
  if (!xss_validation(data)) { return false; }

  $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  $("#" + this_id).attr('disabled', true);  //Enable Save or Update button
  $.ajax({
    type: 'POST',
    url: base_url + 'sales/sales_save_and_update?command=' + this_id + '&rowcount=' + rowcount + '&tot_subtotal_amt=' + tot_subtotal_amt + '&tot_discount_to_all_amt=' + tot_discount_to_all_amt + '&tot_round_off_amt=' + tot_round_off_amt + '&tot_total_amt=' + tot_total_amt + "&other_charges_amt=" + other_charges_amt,
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    success: function (result) {
      // alert(result);return;
      result = result.split("<<<###>>>");
      if (result[0] == "success") {
        location.href = base_url + "sales/invoice/" + result[1];
      }
      else if (result[0] == "failed") {
        toastr['error']("Sorry! Failed to save Record.Try again");
      }
      else {
        alert(result);
      }
      $("#" + this_id).attr('disabled', false);  //Enable Save or Update button
      $(".overlay").remove();

    }
  });
  //}

});


$('#item_search').keypress(function (e) {
  var key = e.which;
  // the enter key code
  if (key == 13) {
    $("#item_search").autocomplete('search');
  }
});

$("#item_search").bind("paste", function (e) {
  $("#item_search").autocomplete('search');
});
$("#item_search").autocomplete({
  source: function (data, cb) {
    $.ajax({
      autoFocus: true,
      url: $("#base_url").val() + 'items/get_json_items_details',
      method: 'GET',
      dataType: 'json',
      /*showHintOnFocus: true,
autoSelect: true, 
 
selectInitial :true,*/

      data: {
        name: data.term,
        /*warehouse_id:$("#warehouse_id").val().trim(),*/
      },
      success: function (res) {
        //console.log(res);
        var result;
        result = [
          {
            //label: 'No Records Found '+data.term,
            label: 'No Records Found ',
            value: ''
          }
        ];

        if (res.length) {
          result = $.map(res, function (el) {
            return {
              label: el.item_code + '--[Qty:' + el.stock + '] --' + el.label,
              value: '',
              id: el.id,
              item_name: el.value,
              stock: el.stock,
              // mobile: el.mobile,
              //customer_dob: el.customer_dob,
              //address: el.address,
            };
          });
        }

        cb(result);
      }
    });
  },
  response: function (e, ui) {
    if (ui.content.length == 1) {
      $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
      $(this).autocomplete("close");
    }
    //console.log(ui.content[0].id);
  },
  //loader start
  search: function (e, ui) {
  },
  select: function (e, ui) {

    //$("#mobile").val(ui.item.mobile)
    //$("#item_search").val(ui.item.value);
    //$("#customer_dob").val(ui.item.customer_dob)
    //$("#address").val(ui.item.address)
    //alert("id="+ui.item.id);

    if (typeof ui.content != 'undefined') {
      console.log("Autoselected first");
      if (isNaN(ui.content[0].id)) {
        return;
      }
      var stock = ui.content[0].stock;
      var item_id = ui.content[0].id;
    }
    else {
      console.log("manual Selected");
      var stock = ui.item.stock;
      var item_id = ui.item.id;
    }
    if (parseFloat(stock) <= 0) {
      toastr["warning"](stock + " Items in Stock!!");
      failed.currentTime = 0;
      failed.play();
      return false;
    }
    if (restrict_quantity(item_id)) {
      return_row_with_data(item_id);
    }
    $("#item_search").val('');

  },
  //loader end
});

function return_row_with_data(item_id) {
  $("#item_search").addClass('ui-autocomplete-loader-center');
  var base_url = $("#base_url").val().trim();
  var rowcount = $("#hidden_rowcount").val();
  $.post(base_url + "sales/return_row_with_data/" + rowcount + "/" + item_id, {}, function (result) {
    //alert(result);
    $('#sales_table tbody').append(result);
    $("#hidden_rowcount").val(parseFloat(rowcount) + 1);
    success.currentTime = 0;
    success.play();
    enable_or_disable_item_discount();
    $("#item_search").removeClass('ui-autocomplete-loader-center');
  });
}
//INCREMENT ITEM
function increment_qty(rowcount) {

  var flag = restrict_quantity($("#tr_item_id_" + rowcount).val().trim());
  if (!flag) { return false; }

  var item_qty = $("#td_data_" + rowcount + "_3").val();
  var available_qty = $("#tr_available_qty_" + rowcount + "_13").val();
  if (parseFloat(item_qty) < parseFloat(available_qty)) {

    new_item_qty = parseFloat(item_qty) + 1;

    if (parseFloat(new_item_qty) > parseFloat(available_qty)) {
      new_item_qty = available_qty;
    }

    $("#td_data_" + rowcount + "_3").val(new_item_qty);
  }
  calculate_tax(rowcount);
}
//DECREMENT ITEM
function decrement_qty(rowcount) {
  var item_qty = $("#td_data_" + rowcount + "_3").val();

  if (item_qty < 1) {
    $("#td_data_" + rowcount + "_3").val((item_qty).toFixed(2));
    toastr["warning"]("Minimum Stock!");
    return;
  }

  if (item_qty <= 1) {
    $("#td_data_" + rowcount + "_3").val(1);
    toastr["warning"]("Minimum Stock!");
    return;
  }
  $("#td_data_" + rowcount + "_3").val((parseFloat(item_qty) - 1).toFixed(2));
  calculate_tax(rowcount);
}

function update_paid_payment_total() {
  var rowcount = $("#paid_amt_tot").attr("data-rowcount");
  var tot = 0;
  for (i = 1; i < rowcount; i++) {
    if (document.getElementById("paid_amt_" + i)) {
      tot += parseFloat($("#paid_amt_" + i).html());
    }
  }
  $("#paid_amt_tot").html(tot.toFixed(2));
}
function delete_payment(payment_id) {
  if (confirm("Do You Wants to Delete Record ?")) {
    var base_url = $("#base_url").val().trim();
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post(base_url + "sales/delete_payment", { payment_id: payment_id }, function (result) {
      //alert(result);return;
      result = result.trim();
      if (result == "success") {
        toastr["success"]("Record Deleted Successfully!");
        $("#payment_row_" + payment_id).remove();
        success.currentTime = 0;
        success.play();
      }
      else if (result == "failed") {
        toastr["error"]("Failed to Delete .Try again!");
        failed.currentTime = 0;
        failed.play();
      }
      else {
        toastr["error"](result);
        failed.currentTime = 0;
        failed.play();
      }
      $(".overlay").remove();
      update_paid_payment_total();
    });
  }//end confirmation   
}

//Delete Record start
function delete_sales(q_id) {

  if (confirm("Do You Wants to Delete Record ?")) {
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post("sales/delete_sales", { q_id: q_id }, function (result) {
      //alert(result);return;
      if (result == "success") {
        toastr["success"]("Record Deleted Successfully!");
        $('#example2').DataTable().ajax.reload();
      }
      else if (result == "failed") {
        toastr["error"]("Failed to Delete .Try again!");
      }
      else {
        toastr["error"](result);
      }
      $(".overlay").remove();
      return false;
    });
  }//end confirmation
}
//Delete Record end
function multi_delete() {
  //var base_url=$("#base_url").val().trim();
  var this_id = this.id;

  if (confirm("Are you sure ?")) {
    data = new FormData($('#table_form')[0]);//form name
    /*Check XSS Code*/
    if (!xss_validation(data)) { return false; }

    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $("#" + this_id).attr('disabled', true);  //Enable Save or Update button
    $.ajax({
      type: 'POST',
      url: 'sales/multi_delete',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        result = result.trim();
        //alert(result);return;
        if (result == "success") {
          toastr["success"]("Record Deleted Successfully!");
          success.currentTime = 0;
          success.play();
          $('#example2').DataTable().ajax.reload();
          $(".delete_btn").hide();
          $(".group_check").prop("checked", false).iCheck('update');
        }
        else if (result == "failed") {
          toastr["error"]("Sorry! Failed to save Record.Try again!");
          failed.currentTime = 0;
          failed.play();
        }
        else {
          toastr["error"](result);
          failed.currentTime = 0;
          failed.play();
        }
        $("#" + this_id).attr('disabled', false);  //Enable Save or Update button
        $(".overlay").remove();
      }
    });
  }
  //e.preventDefault
}

function pay_now(sales_id) {
  $.post('sales/show_pay_now_modal', { sales_id: sales_id }, function (result) {
    $(".pay_now_modal").html('').html(result);
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true
    });
    $('#pay_now').modal('toggle');

  });
}
function view_payments(sales_id) {
  $.post('sales/view_payments_modal', { sales_id: sales_id }, function (result) {
    $(".view_payments_modal").html('').html(result);
    $('#view_payments_modal').modal('toggle');
  });
}

function save_payment(sales_id) {
  var base_url = $("#base_url").val().trim();

  //Initially flag set true
  var flag = true;

  function check_field(id) {

    if (!$("#" + id).val().trim()) //Also check Others????
    {

      $('#' + id + '_msg').fadeIn(200).show().html('Required Field').addClass('required');
      // $('#'+id).css({'background-color' : '#E8E2E9'});
      flag = false;
    }
    else {
      $('#' + id + '_msg').fadeOut(200).hide();
      //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
    }
  }


  //Validate Input box or selection box should not be blank or empty
  check_field("amount");
  check_field("payment_date");


  var payment_date = $("#payment_date").val().trim();
  var amount = $("#amount").val().trim();
  var payment_type = $("#payment_type").val().trim();
  var payment_note = $("#payment_note").val().trim();

  if (amount == 0) {
    toastr["error"]("Please Enter Valid Amount!");
    return false;
  }

  if (amount > parseFloat($("#due_amount_temp").html().trim())) {
    toastr["error"]("Entered Amount Should not be Greater than Due Amount!");
    return false;
  }

  $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  $(".payment_save").attr('disabled', true);  //Enable Save or Update button
  $.post('sales/save_payment', { sales_id: sales_id, payment_type: payment_type, amount: amount, payment_date: payment_date, payment_note: payment_note }, function (result) {
    result = result.trim();
    //alert(result);return;
    if (result == "success") {
      $('#pay_now').modal('toggle');
      toastr["success"]("Payment Recorded Successfully!");
      success.currentTime = 0;
      success.play();
      $('#example2').DataTable().ajax.reload();
    }
    else if (result == "failed") {
      toastr["error"]("Sorry! Failed to save Record.Try again!");
      failed.currentTime = 0;
      failed.play();
    }
    else {
      toastr["error"](result);
      failed.currentTime = 0;
      failed.play();
    }
    $(".payment_save").attr('disabled', false);  //Enable Save or Update button
    $(".overlay").remove();
  });
}

function delete_sales_payment(payment_id) {
  if (confirm("Do You Wants to Delete Record ?")) {
    var base_url = $("#base_url").val().trim();
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post(base_url + "sales/delete_payment", { payment_id: payment_id }, function (result) {
      //alert(result);return;
      result = result.trim();
      if (result == "success") {
        $('#view_payments_modal').modal('toggle');
        toastr["success"]("Record Deleted Successfully!");
        success.currentTime = 0;
        success.play();
        $('#example2').DataTable().ajax.reload();
      }
      else if (result == "failed") {
        toastr["error"]("Failed to Delete .Try again!");
        failed.currentTime = 0;
        failed.play();
      }
      else {
        toastr["error"](result);
        failed.currentTime = 0;
        failed.play();
      }
      $(".overlay").remove();
    });
  }//end confirmation   
}

function restrict_quantity(item_id) {
  var rowcount = $("#hidden_rowcount").val();
  var available_qty = 0;
  var count_item_qty = 0;
  var selected_item_id = 0;
  for (i = 1; i <= rowcount; i++) {
    if (document.getElementById("tr_item_id_" + i)) {
      selected_item_id = $("#tr_item_id_" + i).val().trim();
      if (parseFloat(item_id) == parseFloat(selected_item_id)) {
        available_qty = parseFloat($("#tr_available_qty_" + i + "_13").val().trim());
        count_item_qty += parseFloat($("#td_data_" + i + "_3").val().trim());
      }
    }
  }//end for
  if (available_qty != 0 && count_item_qty >= available_qty) {
    toastr["warning"]("Only " + available_qty + " Items in Stock!!");
    failed.currentTime = 0;
    failed.play();
    return false;
  }
  return true;
}

/*$("#warehouse_id").on("change",function(event) {
  $('#sales_table tbody').html('');
  final_total();
  if($("#warehouse_id").val().trim()!=''){
    $("#item_search").attr({ disabled: false,});
  }
  else{
   $("#item_search").attr({ disabled: true,}); 
  }
});*/














//Customer Selection Box Search
function getCustomerSelectionId() {
  return '#customer_id';
}

$(document).ready(function () {

  var customer_id = "<?= (!empty($customer_id)) ? $customer_id : '';  ?>";

  autoLoadFirstCustomer(customer_id);

});
//Customer Selection Box Search - END

//Initialize Select2 Elements
$(".select2").select2();
//Date picker
$('.datepicker').datepicker({
  autoclose: true,
  format: 'dd-mm-yyyy',
  todayHighlight: true
});




/* function update_price(row_id,item_cost){
 
  var sales_price=$("#sales_price_"+row_id).val().trim();
  if(sales_price!='' || sales_price==0) {sales_price = parseFloat(sales_price); }

 
  var item_price=parseFloat($("#tr_sales_price_temp_"+row_id).val().trim());

  if(sales_price<item_cost){
 
    $("#sales_price_"+row_id).parent().addClass('has-error');
  }else{
    $("#sales_price_"+row_id).parent().removeClass('has-error');
  }

  make_subtotal($("#tr_item_id_"+row_id).val(),row_id);
}*/

/*function set_to_original(i,purchase_price) {
            var sales_price=parseFloat($("#td_data_"+i+"_10").val().trim());
  if(sales_price!='' || sales_price==0) {sales_price = parseFloat(sales_price); }

            var item_price=parseFloat($("#tr_purchase_price_"+i).val().trim());

  if(sales_price<purchase_price){
    toastr["success"]("Default Price Set "+item_price);
    $("#td_data_"+i+"_10").parent().removeClass('has-error');
    $("#td_data_"+i+"_10").val(item_price);
  }
  calculate_tax(i);
}*/

/* ---------- CALCULATE TAX -------------*/
function calculate_tax(i) { //i=Row
  set_tax_value(i);

  //Find the Tax type and Tax amount
  var tax_type = $("#tr_tax_type_" + i).val();
  var tax_amount = $("#td_data_" + i + "_11").val();

  var qty = $("#td_data_" + i + "_3").val().trim();
  var sales_price = parseFloat($("#td_data_" + i + "_10").val().trim());
  $("#td_data_" + i + "_4").val(sales_price);
  /*Discounr*/
  var discount_amt = $("#td_data_" + i + "_8").val().trim();
  discount_amt = (isNaN(parseFloat(discount_amt))) ? 0 : parseFloat(discount_amt);

  var amt = parseFloat(qty) * sales_price;//Taxable

  var total_amt = amt - discount_amt;
  total_amt = (tax_type == 'Inclusive') ? total_amt : parseFloat(total_amt) + parseFloat(tax_amount);

  //Set Unit cost
  $("#td_data_" + i + "_9").val('').val(total_amt.toFixed(2));

  final_total();
}

/* ---------- CALCULATE GST END -------------*/


/* ---------- Final Description of amount ------------*/
function final_total() {


  var rowcount = $("#hidden_rowcount").val();
  var subtotal = parseFloat(0);

  var other_charges_per_amt = parseFloat(0);
  var other_charges_total_amt = 0;
  var taxable = 0;
  if ($("#other_charges_input").val() != null && $("#other_charges_input").val() != '') {

    other_charges_tax_id = $('option:selected', '#other_charges_tax_id').attr('data-tax');
    other_charges_input = $("#other_charges_input").val();
    if (other_charges_tax_id > 0) {

      other_charges_per_amt = (other_charges_tax_id * other_charges_input) / 100;
    }

    taxable = parseFloat(other_charges_per_amt) + parseFloat(other_charges_input);//Other charges input
    other_charges_total_amt = parseFloat(other_charges_per_amt) + parseFloat(other_charges_input);
  }
  else {
    //$("#other_charges_amt").html('0.00');
  }


  var tax_amt = 0;
  var actual_taxable = 0;
  var total_quantity = 0;

  for (i = 1; i <= rowcount; i++) {

    if (document.getElementById("td_data_" + i + "_3")) {
      //customer_id must exist
      if ($("#td_data_" + i + "_3").val() != null && $("#td_data_" + i + "_3").val() != '') {
        actual_taxable = actual_taxable + + +(parseFloat($("#td_data_" + i + "_13").val()).toFixed(2) * parseFloat($("#td_data_" + i + "_3").val()));
        subtotal = subtotal + + +parseFloat($("#td_data_" + i + "_9").val()).toFixed(2);
        if ($("#td_data_" + i + "_7").val() >= 0) {
          tax_amt = tax_amt + + +$("#td_data_" + i + "_7").val();
        }
        total_quantity += parseFloat($("#td_data_" + i + "_3").val().trim());
      }

    }//if end
  }//for end


  //Show total Sales Quantitys
  $(".total_quantity").html(total_quantity);

  //Apply Output on screen
  //subtotal
  if ((subtotal != null || subtotal != '') && (subtotal != 0)) {

    //subtotal
    $("#subtotal_amt").html(subtotal.toFixed(2));

    //other charges total amount
    $("#other_charges_amt").html(parseFloat(other_charges_total_amt).toFixed(2));

    //other charges total amount


    taxable = taxable + subtotal;

    //discount_to_all_amt
    // if($("#discount_to_all_input").val()!=null && $("#discount_to_all_input").val()!=''){
    var discount_input = parseFloat($("#discount_to_all_input").val());
    discount_input = isNaN(discount_input) ? 0 : discount_input;
    var discount = 0;
    if (discount_input > 0) {
      var discount_type = $("#discount_to_all_type").val();
      if (discount_type == 'in_fixed') {
        taxable -= discount_input;
        discount = discount_input;
        //Minus
      }
      else if (discount_type == 'in_percentage') {
        discount = (taxable * discount_input) / 100;
        taxable -= discount;

      }
    }
    else {
      //discount += $("#")
    }
    discount = parseFloat(discount).toFixed(2);

    $("#discount_to_all_amt").html(discount);
    $("#hidden_discount_to_all_amt").val(discount);
    //}
    //subtotal_round=Math.round(taxable);
    subtotal_round = round_off(taxable);//round_off() method custom defined
    subtotal_diff = subtotal_round - taxable;

    $("#round_off_amt").html(parseFloat(subtotal_diff).toFixed(2));
    $("#total_amt").html(parseFloat(subtotal_round).toFixed(2));
    if (save_operation()) {
      $("#amount").val(parseFloat(subtotal_round).toFixed(2));
    }
    $("#hidden_total_amt").val(parseFloat(subtotal_round).toFixed(2));
  }
  else {
    $("#subtotal_amt").html('0.00');
    $("#tax_amt").html('0.00');
    $("#round_off_amt").html('0.00');
    $("#total_amt").html('0.00');
    $("#amount").val('0.00');
    $("#hidden_total_amt").html('0.00');
    $("#discount_to_all_amt").html('0.00');
    $("#hidden_discount_to_all_amt").html('0.00');
    $("#subtotal_amt").html('0.00');
    $("#other_charges_amt").html('0.00');
    $("#amount").val('0.00');
  }

  // adjust_payments();
  //alert("final_total() end");
}
/* ---------- Final Description of amount end ------------*/

function removerow(id) {//id=Rowid

  $("#row_" + id).remove();
  final_total();
  failed.currentTime = 0;
  failed.play();
}



function enable_or_disable_item_discount() {
  /*var discount_input=parseFloat($("#discount_to_all_input").val());
  discount_input = isNaN(discount_input) ? 0 : discount_input;
  if(discount_input>0){
    $(".item_discount").attr({
      'readonly': true,
      'style': 'border-color:red;cursor:no-drop',
    });
  }
  else{
    $(".item_discount").attr({
      'readonly': false,
      'style': '',
    });
  }*/

  var rowcount = $("#hidden_rowcount").val();
  for (k = 1; k <= rowcount; k++) {
    if (document.getElementById("tr_item_id_" + k)) {
      calculate_tax(k);
    }//if end
  }//for end

  //final_total();
}

//Sale Items Modal Operations Start
function show_sales_item_modal(row_id) {
  $('#sales_item').modal('toggle');
  $("#popup_tax_id").select2();

  //Find the item details
  var item_name = $("#td_data_" + row_id + "_1").html();
  var tax_type = $("#tr_tax_type_" + row_id).val();
  var tax_id = $("#tr_tax_id_" + row_id).val();
  var description = $("#description_" + row_id).val();

  /*Discount*/
  var item_discount_input = $("#item_discount_input_" + row_id).val();
  var item_discount_type = $("#item_discount_type_" + row_id).val();

  //Set to Popup
  $("#item_discount_input").val(item_discount_input);
  $("#item_discount_type").val(item_discount_type).select2();

  $("#popup_item_name").html(item_name);
  $("#popup_tax_type").val(tax_type).select2();
  $("#popup_tax_id").val(tax_id).select2();
  $("#popup_description").val(description);
  $("#popup_row_id").val(row_id);
}

function set_info() {
  var row_id = $("#popup_row_id").val();
  var tax_type = $("#popup_tax_type").val();
  var tax_id = $("#popup_tax_id").val();
  var description = $("#popup_description").val();
  var tax_name = ($('option:selected', "#popup_tax_id").attr('data-tax-value'));
  var tax = parseFloat($('option:selected', "#popup_tax_id").attr('data-tax'));

  /*Discounr*/
  var item_discount_input = $("#item_discount_input").val();
  var item_discount_type = $("#item_discount_type").val();

  //Set it into row 
  $("#item_discount_input_" + row_id).val(item_discount_input);
  $("#item_discount_type_" + row_id).val(item_discount_type);

  $("#tr_tax_type_" + row_id).val(tax_type);
  $("#tr_tax_id_" + row_id).val(tax_id);
  $("#tr_tax_value_" + row_id).val(tax);//%
  $("#description_" + row_id).val(description);
  $("#td_data_" + row_id + "_12").html(tax_name);

  calculate_tax(row_id);
  $('#sales_item').modal('toggle');
}
function set_tax_value(row_id) {
  //get the sales price of the item
  var tax_type = $("#tr_tax_type_" + row_id).val();
  var tax = $("#tr_tax_value_" + row_id).val(); //%
  var qty = $("#td_data_" + row_id + "_3").val().trim();
  qty = (isNaN(qty)) ? 0 : qty;
  var sales_price = parseFloat($("#td_data_" + row_id + "_10").val());
  sales_price = (isNaN(sales_price)) ? 0 : sales_price;
  sales_price = sales_price * qty;

  /*Discount*/
  var item_discount_type = $("#item_discount_type_" + row_id).val();
  var item_discount_input = parseFloat($("#item_discount_input_" + row_id).val());
  item_discount_input = (isNaN(item_discount_input)) ? 0 : item_discount_input;

  //Calculate discount      
  var discount_amt = (item_discount_type == 'Percentage') ? ((sales_price) * item_discount_input) / 100 : (item_discount_input * qty);

  sales_price -= parseFloat(discount_amt);

  var tax_amount = (tax_type == 'Inclusive') ? calculate_inclusive(sales_price, tax) : calculate_exclusive(sales_price, tax);

  $("#td_data_" + row_id + "_8").val(discount_amt);

  $("#td_data_" + row_id + "_11").val(tax_amount);
}
//Sale Items Modal Operations End


function item_qty_input(i) {

  var item_qty = $("#td_data_" + i + "_3").val();
  var available_qty = $("#tr_available_qty_" + i + "_13").val();
  if (parseFloat(item_qty) > parseFloat(available_qty)) {
    $("#td_data_" + i + "_3").val(available_qty);
    toastr["warning"]("Oops! You have only " + available_qty + " items in Stock");
  }
  calculate_tax(i);
}




$(document).on('keyup', '.ttl_qnty_items, .ttl_bosta_qnty_ss', function () {
  let ttl_stock_products = parseFloat($('.ttl_stock_s').text());
  let typing_values = parseFloat($(this).val());
  if (typing_values > ttl_stock_products) {
    toastr["warning"]("আপনি এতো পরিমাণ পণ্য নেই। ");
    $(this).val(ttl_stock_products);
  }
});


$(document).on('keyup', '.ttl_qnty_items, .kgs_per_bosta_qnt', function () {
  let buy_per_kgss = parseFloat($('.buy_per_kgss').html());
  let ttl_stock_products = parseFloat($('.ttl_qnty_items').val());
  let ttl_weight_types = parseFloat($('.kgs_per_bosta_qnt').val());
  let weight_per_bosta = parseFloat(ttl_weight_types / ttl_stock_products);
  if (weight_per_bosta < buy_per_kgss) {
    $('.kgs_per_bostass_valid').html(`<span style="color:red"> প্রতি বস্তায় ${weight_per_bosta} কেজি </span>`);
  }else{
    $('.kgs_per_bostass_valid').html(`<span style="color:green"> প্রতি বস্তায় ${weight_per_bosta} কেজি </span>`);
  }
});




