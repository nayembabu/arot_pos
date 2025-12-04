$(document).ready(function() {
            
    $('.customer-selection').select2({
        width: '100%',
        dropdownAutoWidth: true,
        allowClear: true
    });
    
    function updateTime() {
        var currentDateTime = new Date().toLocaleTimeString('en-US', {   hour12: true  });
        $('#auto_time').val(currentDateTime);
    }
    
    updateTime();
    setInterval(updateTime, 1000);

    $(document).on("click", '.loan-submit-button', function(event) {
        event.preventDefault();
        $.ajax({
            url: "expense/insert_data_loan_from_supp",
            type: "POST",
            data: {
                customer_id:    $(".supp_name_id").val(),
                loan_amount:    $(".amnt_loan_s").val(),
                loan_medium:    $(".loan_perposesss").val(),
                repayment_date: $(".dates_of_loans").val(),
                auto_time:      $(".times_of_fulls").val()
            },
            success: function(res) {        
                var response = JSON.parse(res);
                if (response.status === "error") {
                    $("#response-message").html('<div class="alert alert-danger">' + response.message + '</div>');
                } else {
                    $("#response-message").html('<div class="alert alert-success">' + response.message + '</div>');
                    $(".supp_name_id, .amnt_loan_s, .loan_perposesss").val("");
                }
            },
            error: function() {
                $("#response-message").html('<div class="alert alert-danger">সার্ভারে সমস্যা হয়েছে, আবার চেষ্টা করুন!</div>');
            }
        });
    }); 

    $(document).on('click', '.saving_cust_provide_loan_btn', function () {
        $.ajax({
            url: "expense/insert_add_loan_to_customer",
            type: "POST",
            data: {
                customer_id:    $(".customer_iddii_uniqs").val(),
                loan_amount:    $(".give_amount_taka").val(),
                loan_perpose:   $(".perpose_of_loans").val(),
                loan_date:      $(".loan_date_provide").val(),
                auto_time:      $(".loan_timming_provides").val()
            },
            success: function(res) {        
                var response = JSON.parse(res);
                if (response.status === "error") {
                    $("#response-message").html('<div class="alert alert-danger">' + response.message + '</div>');
                    toastr["error"](response.message);
                } else {
                    $("#response-message").html('<div class="alert alert-success">' + response.message + '</div>');
                    $(".customer_iddii_uniqs, .give_amount_taka, .perpose_of_loans").val("");
                    toastr["success"](response.message);
                }
            },
            error: function() {
                $("#response-message").html('<div class="alert alert-danger">সার্ভারে সমস্যা হয়েছে, আবার চেষ্টা করুন!</div>');
            }
        });
    });














});


