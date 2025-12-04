$(document).on('click', '.new_customer_save_btn', function () {
    $.ajax({
        type: 'POST',
        url: 'pos/newcustomer',
        data: {
          name:     $(".cus_name").val(),
          mobile:   $(".cus_mobile_no").val(),
          address:  $(".cus_addrs").val(),
          due:      $(".cus_previous_due").val(),
        },
        beforeSend: function() {
            $('.spiner_load_activity').css('display', 'block');
            $('.saving_btn_sho_hide').css('display', 'none');
        },
        complete: function() {
            $('.spiner_load_activity').css('display', 'none');
            $('.saving_btn_sho_hide').css('display', 'block'); 
        },
        success: function(data){
            get_all_customers();
            $('.saving_btn_sho_hide').css('display', 'block');
          $(".cus_name").val(''),
          $(".cus_mobile_no").val(''),
          $(".cus_addrs").val(''),
          $(".cus_previous_due").val('').
          toastr["success"]("New Customer Added!!");
          success.play();
        }
    })
});
 
get_all_customers();

function get_all_customers() { 
    $.ajax({
        type: "post",
        url: "sales/get_all_customer_json_data",
        data: "",
        dataType: "json",
        beforeSend: function() {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
            $('.spiner_load_activity').css('display', 'none');
        },
        success: function (r) {
            let customer_data = '';
            for (let nl = 0; nl < r.length; nl++) {
                customer_data += `
                  <tr>
                    <td>${nl+1}</td>
                    <td>${r[nl].customer_name}</td>
                    <td>${r[nl].mobile}</td>
                    <td>${r[nl].address}</td>
                    <td style="text-align: right;" >${r[nl].sales_due}</td> 
                    <td>
                        <div class="btn btn-sm btn-primary customer_previous_change_modal " customer_id_attrs="${r[nl].id}" data-toggle="modal" data-target="#customer_previous_paidable_amount"  ><i class="fa fa-dollar " title="কাস্টমারের বকেয়া পরিবর্তন করুন। " ></i></div>
                        <div class="btn btn-sm btn-info edit_customer_info_ss " customer_id_attrs="${r[nl].id}" data-toggle="modal" data-target="#customer_all_info_edit_s"  ><i class="fa fa-edit " title="কাস্টমারের এডিট করুন। " ></i></div>
                    </td> 
                  </tr>`
            }
            $('.assign_customer_data').html(customer_data);

            $('#example2').DataTable({
                destroy: true, // পুরোনো টেবিলকে পুনরায় রিসেট করে
                paging: true, // পেজিনেশন চালু
                searching: true, // সার্চ বার চালু
                ordering: true, // সোর্টিং চালু
            });

        }
    });
}

$(document).on('click', '.customer_previous_change_modal', function () {
    let customer_id = $(this).attr('customer_id_attrs');
    $.ajax({
        type: 'POST',
        url: 'customers/get_customer_by_cus_id',
        data: {
            customer_id: customer_id
        },
        beforeSend: function() {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
            $('.spiner_load_activity').css('display', 'none');
        },
        success: function (data) {
            $('.customer_prev_html_assign').html(`
                <div class="form-group">
                    <input type="text" class="form-control input-lg cust_on_prev_change_boxss " cust_iddd="${data.id}" id="largeInput" value="${data.sales_due}" placeholder=" কাস্টমারের সাবেক ">
                </div>
            `);
        }
    });
});

$(document).on('click', '.update_customer_prevss', function () {
    let customer_id = $('.cust_on_prev_change_boxss').attr('cust_iddd');
    let customer_prev_due = $('.cust_on_prev_change_boxss').val();

    $.ajax({
        type: "post",
        url: "customers/update_customer_due",
        data: {
            customer_id: customer_id,
            customer_prev_due: customer_prev_due
        },
        beforeSend: function() {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
            $('.spiner_load_activity').css('display', 'none');
        },
        success: function (rs) {
            toastr["success"]("কাস্টমারের বকেয়া পরিবর্তন হয়েছে!!");
            success.play();
            $('#customer_previous_paidable_amount').modal('hide');
            location.reload();
        }
    });
});

$(document).on('click', '.edit_customer_info_ss', function () {
    let customer_id = $(this).attr('customer_id_attrs');
    $.ajax({
        type: 'POST',
        url: 'customers/get_customer_by_cus_id',
        data: {
            customer_id: customer_id
        },
        beforeSend: function() {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
            $('.spiner_load_activity').css('display', 'none');
        },
        success: function (data) {
            $('.customer_full_info_html_assign').html(`
                                
                <div class="form-group">
                    <label for="customerName" class="form-label">কাস্টমারের নাম:</label>
                    <input type="text" class="form-input form-control input-lg " cust_iddd="${data.id}" value="${data.customer_name}"  id="customerName" name="customerName" required>
                </div>
                
                <div class="form-group">
                    <label for="customerPhone" class="form-label">মোবাইল নাম্বার:</label>
                    <input type="text" class="form-input form-control input-lg " inputmode="numeric"  id="customerPhone" name="customerPhone" value="${data.mobile}" required>
                </div>
                
                <div class="form-group">
                    <label for="customerAddress" class="form-label">ঠিকানা:</label>
                    <textarea class="form-textarea form-control input-lg " id="customerAddress" name="customerAddress"  rows="4" required>${data.address}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="customerPhone" class="form-label">WhatsApp নাম্বার:</label>
                    <input type="text" class="form-input form-control input-lg " id="customerWAPhoneNumber" inputmode="numeric"  value="${data.whatsApp_number}" name="customerWAPhoneNumber" required>
                </div>

                <div class="form-group">
                    <label for="customerPhone" class="form-label">IMO নাম্বার:</label>
                    <input type="text" class="form-input form-control input-lg " inputmode="numeric"  id="customerIMONumber" value="${data.imo_numbersss}" name="customerIMONumber" required>
                </div>

            `);
        }
    });
});


$(document).on('click', '.update_customer_all_info_sss', function () {

    $.ajax({
        type: "post",
        url: "customers/update_customer_basic_infos_with_numbers",
        data: {
            customer_id:$('#customerName').attr('cust_iddd'),
            name:       $('#customerName').val(),
            phone:      $('#customerPhone').val(),
            address:    $('#customerAddress').val(),
            wanumber:   $('#customerWAPhoneNumber').val(),
            imo_nos:    $('#customerIMONumber').val(),
        },
        beforeSend: function() {
            $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
            $('.spiner_load_activity').css('display', 'none');
        },
        success: function (rs) {
            get_all_customers();
            toastr["success"]("কাস্টমারের সকল তথ্য পরিবর্তন হয়েছে!!");
            success.play();
            $('.customer_full_info_html_assign').html('');
            $('#customer_all_info_edit_s').modal('hide');
        }
    });
});



