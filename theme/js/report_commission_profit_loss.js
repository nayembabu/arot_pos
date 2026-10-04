$(document).ready(function () {
    $(document).on('click', '.commission_profit_loss_serching_btn', function () {
        if ($('.commission_start_dates').val() === '' || $('.commission_ending_dates').val() === '') {
            toastr['warning']('তারিখ দিন');
            return false;
        }
        $.ajax({
            type: "POST",
            url: "reports/get_commission_profit_loss_data",
            data: {
                from_date:  $('.commission_start_dates').val(),
                to_date:    $('.commission_ending_dates').val(),
                supplier_id: $('.commission_supplier_selecting_id option:selected').val()
            },
            beforeSend: function() {
                $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
                $('.spiner_load_activity').css('display', 'none');
            },
            success: function (rs) {
                $('.commission_total_lots').html(`${formatter.format(rs.total_lots).getDigitBanglaFromEnglish()} টি`);
                $('.commission_total_price').html(`৳ ${formatter.format(rs.total_price).getDigitBanglaFromEnglish()}`);
                $('.commission_total_sales').html(`৳ ${formatter.format(rs.total_sales).getDigitBanglaFromEnglish()}`);
                $('.commission_net_amounts').html(`৳ ${formatter.format(Math.abs(rs.net)).getDigitBanglaFromEnglish()}`);
                $('.commission_net_status').html(rs.net_status);
            }
        })
    });
})