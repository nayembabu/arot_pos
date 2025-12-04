   

$(document).on('change', '.select_customers_id', function () {
	let customer_id = $(this).val(); 
    if (customer_id != '') {
        get_customer_info_func(customer_id)
    } else {
		$('.customer_info_assign').html('');
		$('.searching_html_datas').html('');
		$('.customer_pay_history_joma').html('');
		$('.customer_history_khoroc_cut').html('');
    }
});

function get_customer_info_func(customer_id) {
	$.ajax({
		type: "post",
		url: "expense/get_sales_by_customer_id",
		data: {
			c_id: customer_id   
		},
		success: function (res) {
			let new_date = new Date();
			let current_date = ('0' + new_date.getDate()).slice(-2) + '-' + ('0' + (new_date.getMonth() + 1)).slice(-2) + '-' + new_date.getFullYear();
			let currnt_time = new Date().toLocaleTimeString(); 

			// if (res.customer.sales_due <= 0) {
			if (1 == 0) {
				$('.customer_info_assign').html(
					`<div class="col-md-12 " style="margin: 20px 0;" >
						<div class="col-md-4 " style="margin-top: 20px;" >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">নাম </span>
								<div class="form-control">${res.customer.customer_name}</div>
							</div>
						</div>
	
						<div class="col-md-4 " style="margin-top: 20px;"  >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">ফোন নং </span>
								<div class="form-control">${res.customer.mobile}</div>
							</div>
						</div>
	
						<div class="col-md-4 " style="margin-top: 20px;" >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">মোট বকেয়া </span>
								<div class="form-control cust_now_sales_duess ">${res.customer.sales_due}</div>
							</div>
						</div>
	
						<div class="col-md-10 " style="margin-top: 20px;"  >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">ঠিকানা </span>
								<div class="form-control">${res.customer.address}</div>
							</div>
						</div>
					</div>
					
					`
				);
			}else {

				$('.customer_info_assign').html(
					`<div class="col-md-12 " style="margin: 20px 0;" >
						<div class="col-md-4 " style="margin-top: 20px;" >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">নাম </span>
								<div class="form-control">${res.customer.customer_name}</div>
							</div>
						</div>

						<div class="col-md-4 " style="margin-top: 20px;"  >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">ফোন নং </span>
								<div class="form-control">${res.customer.mobile}</div>
							</div>
						</div>

						<div class="col-md-4 " style="margin-top: 20px;" >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">মোট বকেয়া </span>
								<div class="form-control cust_now_sales_duess ">${res.customer.sales_due}</div>
							</div>
						</div>

						<div class="col-md-10 " style="margin-top: 20px;"  >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">ঠিকানা </span>
								<div class="form-control">${res.customer.address}</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 " style=""  >
						<div class="col-md-4 " style="margin-top: 20px;"  >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">টাকা প্রদানের তারিখ </span>
								<input type="text" class="form-control datepicker add_cash_datingss " value="${current_date}" placeholder=" তারিখ " >
							</div>
						</div>

						<div class="col-md-4 " style="margin-top: 20px;"  >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">সময় </span>
								<input type="text" class="form-control add_cash_time_ss " value="${currnt_time}" placeholder=" সময় " >
							</div>
						</div>

						<div class="col-md-4 " style="margin-top: 20px;"  >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">প্রদানের মারফত </span>
								<input type="text" class="form-control add_cash_types_by " placeholder=" মারফত " >
							</div>
						</div>

						<div class="col-md-4 " style="margin-top: 20px;"  >
							<div class="input-group input-group-lg">
								<span class="input-group-addon " id="sizing-addon1">টাকার পরিমান </span>
								<input type="text" class="form-control cash_amnt_input_box " inputmode="numeric" placeholder=" টাকা " >
							</div>
						</div>

						<div class="col-md-4 " style="margin-top: 20px;"  >
							<center>
								<div class="input-group input-group-lg">
									<div class="form-control btn btn-lg btn-info add_amount_in_cash_btn ">ক্যাশে জমা করুন</div>
								</div>
							</center>
						</div>
					</div>`
				);
			}

			$('.searching_html_datas').html(
				`<hr>
				<div class="col-md-4 " style="margin-top: 20px;"  >
					<div class="input-group input-group-lg">
					<span class="input-group-addon " id="sizing-addon1">তারিখ হইতে </span>
					<input type="text" class="form-control datepicker date_starsss " value="${current_date}" placeholder=" তারিখ শুরু " >
					</div>
				</div>

				<div class="col-md-4 " style="margin-top: 20px;"  >
					<div class="input-group input-group-lg">
					<span class="input-group-addon " id="sizing-addon1">তারিখ পর্যন্ত </span>
					<input type="text" class="form-control datepicker ending_datess " value="${current_date}" placeholder=" তারিখ শেষ " >
					</div>
				</div>

				<div class="col-md-4 " style="margin-top: 20px;"  >
					<center>
					<div class="input-group input-group-lg">
						<div class="form-control btn btn-lg btn-block btn-info search_history_btn ">খুজুন</div>
					</div>
					</center>
				</div>
				<div class="col-md-6 customer_pay_history_joma "></div>
				<div class="col-md-6 customer_history_khoroc_cut "></div>`
			);
		}
	});
}

// $(document).on('keyup', '.cash_amnt_input_box', function () {
// 	let input_values = parseFloat($(this).val()); 
// 	let cust_ttl_sales_due = parseFloat($('.cust_now_sales_duess').text());
// 	if (input_values > cust_ttl_sales_due) {
// 		$(this).val('');
// 	}
// });

$(document).on('click', '.add_amount_in_cash_btn', function () { 
	if ($('.cash_amnt_input_box').val() == '' || $('.add_cash_types_by').val() == '' || $('.add_cash_time_ss').val() == '' || $('.add_cash_datingss').val() == '' || $('.select_customers_id').val() == '') {
		toastr["error"](" সবগুলো তথ্য পূরণ করতে হবে। ");
	} else {
		$.ajax({
			type: "post",
			url: "expense/adding_cash_amount_of_customer_id",
			data: {
				select_date: 	$('.add_cash_datingss').val(),
				time_select: 	$('.add_cash_time_ss').val(),
				types_of: 		$('.add_cash_types_by').val(),
				cash_amount: 	$('.cash_amnt_input_box').val(),
				cust_id: 		$('.select_customers_id').val(),
			}, 
			beforeSend: function() {
			  $('.spiner_load_activity').css('display', 'block');
			},
			complete: function() {
			  $('.spiner_load_activity').css('display', 'none');
			},
			success: function (rspn) {
				Swal.fire({
					title: "<strong>বিক্রয় সফল</strong>",
					icon: "success",
					html: `টাকা জমা সফল হয়েছে, স্লিপ প্রিন্ট করুন <br> <a onclick="window.open('sales/cash_receipt_view?pay_id=${rspn}','_blank', 'width=800,height=800,left=300,top=300')" style="font-size: 18px; " > প্রিন্ট </a>`,
					showConfirmButton: false,
				});
				$('.searching_html_datas').html('');
				$('.customer_pay_history_joma').html('');
				$('.customer_history_khoroc_cut').html('');
				get_customer_info_func($('.select_customers_id').val())
			}
		});
	}

});

$(document).on('click', '.search_history_btn', function () {
	if ($('.select_customers_id').val() == '' || $('.date_starsss').val() == '' || $('.ending_datess').val() == '') {
		toastr["error"](" সবগুলো তথ্য পূরণ করতে হবে। ");
	} else {
		$.ajax({
			type: "post",
			url: "expense/search_customer_pay_info_date_date",
			data: {
				cust_id: $('.select_customers_id').val(),
				start_dates: $('.date_starsss').val(),
				ending_dates: $('.ending_datess').val()
			},
			beforeSend: function() {
			  $('.spiner_load_activity').css('display', 'block');
			},
			complete: function() {
			  $('.spiner_load_activity').css('display', 'none');
			},
			success: function (rs) {

				let pay_data = '';
				let due_data = '';

				for (let a = 0; a < rs.cust_payments.length; a++) {
					pay_data += `<tr>
									<td>${rs.cust_payments[a].payment_date}</td>
									<td>${rs.cust_payments[a].payment_timing}</td>
									<td>${rs.cust_payments[a].payment_type}</td>
									<td>${rs.cust_payments[a].payment}</td>
								</tr>`
				}
				for (let b = 0; b < rs.cust_dues.length; b++) {
					due_data += `<tr>
									<td>${rs.cust_dues[b].due_sales_dates_times}</td>
									<td>${rs.cust_dues[b].ttl_due_now_ss_sales_ssss}</td>
								</tr>`
				}
				$('.customer_pay_history_joma').html(
					`<table class="table table-bordered table-hover table-responsive">
                      <thead>
                        <tr>
                          <td colspan="5" class="text-center " style="font-size: 20px; font-weight: bold; " >
                            জমার হিসাব 
                          </td>
                        </tr>
                        <tr>
                          <th>তারিখ</th>
                          <th>সময়</th>
                          <th>মারফত</th>
                          <th>টাকার পরিমান</th>
                        </tr>
                      </thead>
                      <tbody class="">${pay_data}</tbody>
                    </table>`
				);
				$('.customer_history_khoroc_cut').html(
					`<table class="table table-bordered table-hover table-responsive">
                      <thead>
                        <tr>
                          <td colspan="5" class="text-center " style="font-size: 20px; font-weight: bold; " >
                            বিক্রির হিসাব 
                          </td>
                        </tr>
                        <tr>
                          <th>তারিখ</th>
                          <th>টাকার পরিমান</th>
                        </tr>
                      </thead>
                      <tbody class="">${due_data}</tbody>
                    </table>`
				);
			}
		});
	}
});



$(document).on('click', '.save_income_btn', function () {
	$.ajax({
		type: "post",
		url: "expense/new_incomes_entry",
		data: {
			income_date: $('.incomes_dates').val(),
			income_amnt: $('.incomes_amounts').val(),
			incomes_for: $('.incomes_for').val()
		},
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
            $('.hide_this_saving_now').html('<h2>সেভ হচ্ছে অপেক্ষা করুন। </h2>');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
            $('.hide_this_saving_now').html(`      
				<div class="col-md-3 col-md-offset-3">
					<button type="button" id="save" class=" btn btn-block btn-success save_income_btn " title="Save Data">Save</button>
				</div>
				<div class="col-sm-3"> 
					<a href="<?=base_url('dashboard');?>">
						<button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
					</a>
				</div>`
			); 
        },
		success: function (sn) {
			$('.incomes_amounts').val('')
			$('.expense_for').val('')
            $('.hide_this_saving_now').html(`      
				<div class="col-md-3 col-md-offset-3">
					<button type="button" id="save" class=" btn btn-block btn-success save_income_btn " title="Save Data">Save</button>
				</div>
				<div class="col-sm-3"> 
					<a href="<?=base_url('dashboard');?>">
						<button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
					</a>
				</div>`
			); 
		}
	});
});



