
$(document).on('click', '.view_sales_reports', function () {
  
    var from_date=document.getElementById("from_date").value.trim();
    var to_date=document.getElementById("to_date").value.trim();

  	if(from_date == "")
        { 
            toastr["warning"]("তারিখ সিলেক্ট করুন।");
            document.getElementById("from_date").focus();
            return;
        } 
  	 
  	 if(to_date == "") 
        {
            toastr["warning"]("তারিখ সিলেক্ট করুন।");
            document.getElementById("to_date").focus();
            return;
        }

          $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          $.post("reports/show_sales_report",{from_date:from_date,to_date:to_date},function(result){
            //alert(result);
            let sales_data = '';
            let sales_item_data = ''
            for (let n = 0; n < result.length; n++) { 

              
              let sales_item_data = get_sales_item_infos_by_sales_id(result[n].id);
              let sales_item_info = JSON.parse(sales_item_data);
              let sales_item_calc_assigns = '';
                  
              for (let i = 0; i < sales_item_info.length; i++) {
                  sales_item_calc_assigns += `<p>${sales_item_info[i].ref_lot_no} - ${formatter.format(sales_item_info[i].price_per_kg).getDigitBanglaFromEnglish()}/- - ${formatter.format(sales_item_info[i].sales_qnty_bostas).getDigitBanglaFromEnglish()}${sales_item_info[i].unit_name}</p>`;
              }


              sales_data += `
                    <tr>
                      <td align="center" > ${n+1} </td>
                      <td ><a class="btn btn-sm btn-info" href="sales/sales_receipt_view_fun?sales_id=${result[n].id}" target="_blank" ><i class="fa fa-print"></i></a><a class="btn btn-sm btn-primary" style="margin-left: 5px; " ><i class="fa fa-edit"></i></a>  </td>
                      <td align="center" > ${result[n].customer_name} </td>
                      <td align="center" > ${sales_item_calc_assigns} </td>
                      <td align="right" > ${result[n].ttl_sales_prices} </td>
                      <td align="center" > ${result[n].sales_date} </td>
                    </tr>
                  `;
            }
            setTimeout(function() {
              $(".sales_data_assing").html(sales_data);
              $(".overlay").remove();
            }, 0);
           }); 
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
