$(document).on('click', '.search_details_btns', function () {
     
    $('.sales_item_info_displays').html('');
    $('.ttl_data_show_rows').html('');
    if ($('.date_starts_from').val() == '' || $('.date_ends_to').val() == '' || $('.customer_unq_idds').val() == '') {
      toastr["error"]("সকল তথ্য ফিলআপ করুন। "); 
    }else {
        $.ajax({
            type: "post",
            url: "sales/get_sales_info_date_to_date",
            data: {
                startDate:  $('.date_starts_from').val(),
                endsDate:   $('.date_ends_to').val(), 
                custID:     $('.customer_unq_idds').val()
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
            },
            success: function (rs) {
                let sales_dt = '';
                for (let l = 0; l < rs.length; l++) {
                    sales_dt += `<li style="border-right: 3px solid white; padding-right: 10px; border-bottom: 2px solid white;  " >
                                    <a class="clickable_sales_data" href="#tab_1" data-toggle="tab" sales_id="${rs[l].id}" >${rs[l].sales_date} - <span  >${rs[l].ttl_sales_prices}/-</span></a>
                                </li>`;
                }
                $('.nav_assign_ul_data').html(`<ul class="nav nav-tabs bg-gray text-bold font-italic">${sales_dt}</ul>`); 
            }
        });
    }
});

$(document).on('click', '.clickable_sales_data', function () { 
    
    $('.sales_item_info_displays').html('')
    $.ajax({
        type: "post",
        url: "sales/get_sales_item_by_sales_id",
        data: {
            sales_id: $(this).attr('sales_id')
        },
        success: function (rn) {
            let item_html = '';
            for (let b = 0; b < rn.length; b++) {
                item_html += `<div class="col-md-3 col-xs-6 " title="" style="padding-left:5px;padding-right:5px;" >
                                <div class="box box-default sales_item_info_box " sales_items_id="${rn[b].id}" pur_items_uniq_id="${rn[b].pur_item_a_priddd}" id="div_1" style="max-height: 150px;min-height: 150px;cursor: pointer;background-color:#c8c8c8; border: 2px solid black; ">
                                <span class="label label-danger push-right" style="font-weight: bold;font-family: sans-serif;" >
                                    Qty: ${rn[b].sales_qnty_bostas}-${rn[b].unit_name} 
                                </span>
                                <div class="box-body box-profile">
                                    <center>
                                        <img class=" img-responsive item_image" style="border: 1px solid gray;" src="theme/images/no_image.png" alt="Item picture">
                                    </center>
                                    <lable class="text-center search_item" style="font-weight: bold; font-family: sans-serif; " id="item_0">
                                        ${rn[b].ref_lot_no} <br>   
                                        <span class="" style="font-family: sans-serif; ">
                                            ৳ <span class="rate_per_kg_clss ">${rn[b].price_per_kg}</span>
                                        </span>
                                    </lable>
                                </div>
                                </div>
                            </div>`;
            }
            $('.ttl_data_show_rows').html(item_html);
        }
    });
});

$(document).on('click', '.sales_item_info_box', function () {
    let sales_items_id = $(this).attr('sales_items_id');
    let pur_items_id = $(this).attr('pur_items_uniq_id');
    $.ajax({
        type: "post",
        url: "sales/get_sales_item_by_sales_item_id",
        data: {
            sales_items_id: sales_items_id,
            pur_item_id: pur_items_id
        },
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
        success: function (se) { 
            $('.sales_item_info_displays').html(
                `<table class="table table-lg table-condensed table-bordered table-striped table-responsive " >
                    <tr>
                        <td>বিক্রয়ের পরিমাণ</td>
                        <td><span class="" >${se.sales_qnty_bostas}</span></td>
                    </tr>
                    <tr>
                        <td>বিক্রিত দাম</td>
                        <td><span>${se.price_per_kg}</span> টাকা</td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-md-4 ">
                        <label for="mallll1">রিটার্ণ পরিমান </label>
                        <input type="text" id="mallll1" class="form-control ttl_qnty_return_items " inputmode="numeric" value="" placeholder="কতো বস্তা">
                    </div>
                    <div class="col-md-4 ">
                        <label for="pon2">মোট ওজন </label>
                        <input type="text" id="pon2" class="form-control return_total_weight " inputmode="numeric" value="" placeholder="মোট ওজন">
                    </div>
                    <div class="col-md-4 ">
                        <label for="pon2">অন্যান্য খরচ </label>
                        <input type="text" id="pon2" class="form-control return_other_cost " inputmode="numeric" value="" placeholder="খরচের পরিমাণ">
                    </div>
                </div>
                <center>
                    <div class="btn btn-info mx-auto sales_items_return_btn " sales_items_uniq_attrs="${se.id}" pur_item_id_attrs="${se.pur_item_a_priddd}" style="margin-top: 5px;">রিটার্ণ করুন</div>
                </center>`
            );
        }
    });
});

$(document).on('click', '.sales_items_return_btn', function () { 
    if(confirm("রিটার্ণ করতে আগ্রহী?")){
        $.ajax({
            type: "post",
            url: "sales/insert_return_sales_items",
            data: {
                sales_item_ids: $(this).attr('sales_items_uniq_attrs'),
                pur_item_ids:   $(this).attr('pur_item_id_attrs'),
                return_qnty:    $('.ttl_qnty_return_items').val(),
                return_weight:  $('.return_total_weight').val(),
                return_cost:    $('.return_other_cost').val()
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
            },
            success: function (r) {
                toastr["success"]("রিটার্ন সাকসেস, পন্য স্টকে জমা হয়েছে। ");
                $('.date_starts_from').val('')
                $('.date_ends_to').val('') 
                $('.customer_unq_idds').val('')
                $('.nav_assign_ul_data').html('');
                $('.ttl_data_show_rows').html('');
                $('.sales_item_info_displays').html('');
            }
        });
    }else{
        return false;
    }
});


