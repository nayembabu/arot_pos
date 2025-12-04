

$(document).on('click', '.save_all_exprense_btn', function () {
	
	$.ajax({
		type: "post", 
		url: "expense/newexpenssse",
		data: {
			expense_date: $('.expense_date').val(),
			expense_amt: $('.expense_amt').val(),
			expense_for: $('.expense_for').val()
		},
        beforeSend: function() {
            $('.hide_this_saving_now').html('<h2>সেভ হচ্ছে অপেক্ষা করুন। </h2>');
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
            $('.hide_this_saving_now').html(`
                   <div class="col-md-3 col-md-offset-3">
                      <button type="button" id="save" class=" btn btn-block btn-success save_all_exprense_btn " title="Save Data">Save</button>
                   </div>
                   <div class="col-sm-3">
                    <a href="<?=base_url('dashboard');?>">
                      <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                    </a>
                   </div>`); 
        },
		success: function (ere) { 
            $('.hide_this_saving_now').html(
				`<div class="col-md-3 col-md-offset-3">
				   <button type="button" id="save" class=" btn btn-block btn-success save_all_exprense_btn " title="Save Data">Save</button>
				</div>
				<div class="col-sm-3">
				 <a href="<?=base_url('dashboard');?>">
				   <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
				 </a>
				</div>`
			); 
			 $('.expense_date').val('');
			 $('.expense_amt').val('');
			 $('.expense_for').val('');

			 toastr["success"]("আপনার খরচ এন্ট্রি হয়েছে। ");    

		}
	});

});


$(document).on('change', '.select_supplier_id', function () {
	let supplier_id = $(this).val(); 
	if (supplier_id != '') { 
        get_customer_info_func(supplier_id)
    } else {
		$('.customer_info_assign').html('');
		$('.searching_html_datas').html('');
		$('.customer_pay_history_joma').html('');
		$('.customer_history_khoroc_cut').html('');
    }
});

function get_customer_info_func(supplier_id) {
	$.ajax({
		type: "post",
		url: "expense/get_supplier_info_by_id",
		data: {
			s_id: supplier_id 
		},
		success: function (res) {
			$('.supplier_info_assign').html(
				`<div class="col-md-12 " style="margin: 20px 0;" >
					<div class="col-md-4 " style="margin-top: 20px;" >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">নাম </span>
							<div class="form-control">${res.suppl.supplier_name}</div>
						</div>
					</div>

					<div class="col-md-4 " style="margin-top: 20px;"  >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">ফোন নং </span>
							<div class="form-control">${res.suppl.mobile}</div>
						</div>
					</div>

					<div class="col-md-4 " style="margin-top: 20px;" >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">মোট বকেয়া </span>
							<div class="form-control">${res.suppl.purchase_due}</div>
						</div>
					</div>

					<div class="col-md-10 " style="margin-top: 20px;"  >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">ঠিকানা </span>
							<div class="form-control">${res.suppl.address}</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 " style=""  >
					<div class="col-md-4 " style="margin-top: 20px;"  >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1"> তারিখ </span>
							<input type="text" class="form-control datepicker add_cash_datingss " value="${TodaysformatDate(today)}" placeholder=" তারিখ " >
						</div>
					</div>

					<div class="col-md-4 " style="margin-top: 20px;"  >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">সময় </span>
							<input type="text" class="form-control add_cash_time_ss " placeholder=" সময় " >
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
								<div class="form-control btn btn-lg btn-info cut_amount_from_cash_btn ">টাকা দেন</div>
							</div>
						</center>
					</div>
				</div>`
			);
			$('.searching_html_datas').html(
				`<hr>
				<center><h2>পরে যোগ করে দিবো</h2></center>`
			);
		}
	});
}

		var j = `<div class="col-md-4 " style="margin-top: 20px;"  >
					<div class="input-group input-group-lg">
					<span class="input-group-addon " id="sizing-addon1">তারিখ হইতে </span>
					<input type="text" class="form-control datepicker date_starsss " placeholder=" তারিখ শুরু " >
					</div>
				</div>

				<div class="col-md-4 " style="margin-top: 20px;"  >
					<div class="input-group input-group-lg">
					<span class="input-group-addon " id="sizing-addon1">তারিখ পর্যন্ত </span>
					<input type="text" class="form-control datepicker ending_datess " placeholder=" তারিখ শেষ " >
					</div>
				</div>

				<div class="col-md-4 " style="margin-top: 20px;"  >
					<center>
					<div class="input-group input-group-lg">
						<div class="form-control btn btn-lg btn-block btn-info search_history_btn ">খুজুন</div>
					</div>
					</center>
				</div>
				<div class="col-md-6 supplier_pay_history_joma "></div>
				<div class="col-md-6 supplier_history_khoroc_cut "></div>`;

$(document).on('click', '.cut_amount_from_cash_btn', function () { 
	if ($('.cash_amnt_input_box').val() == '' || $('.add_cash_types_by').val() == '' || $('.add_cash_time_ss').val() == '' || $('.add_cash_datingss').val() == '' || $('.select_supplier_id').val() == '') {
		toastr["error"](" সবগুলো তথ্য পূরণ করতে হবে। ");
	} else {
		$.ajax({
			type: "post",
			url: "expense/cutting_cash_amount_of_supplier_id",
			data: {
				select_date: 	$('.add_cash_datingss').val(),
				time_select: 	$('.add_cash_time_ss').val(),
				types_of: 		$('.add_cash_types_by').val(),
				cash_amount: 	$('.cash_amnt_input_box').val(),
				supp_id: 		$('.select_supplier_id').val(),
			}, 
			beforeSend: function() {
			  $('.spiner_load_activity').css('display', 'block');
			},
			complete: function() {
			  $('.spiner_load_activity').css('display', 'none');
			},
			success: function (rspn) {
				Swal.fire({
					title: "<strong>টাকা প্রদান</strong>",
					icon: "success",
					html: `টাকা জমা সফল হয়েছে,`,
					showConfirmButton: true,
				});
				$('.searching_html_datas').html('');
				$('.customer_pay_history_joma').html('');
				$('.customer_history_khoroc_cut').html('');
				get_customer_info_func($('.select_supplier_id').val())
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


function updateClock() {
    let now = new Date();
    let hours = now.getHours().toString().padStart(2, '0');
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let seconds = now.getSeconds().toString().padStart(2, '0');
    
    let timeString = hours + ':' + minutes + ':' + seconds;
    $('.add_cash_time_ss').val(timeString);
}
    updateClock();
    setInterval(updateClock, 1000);


	let today = new Date();
	
	function TodaysformatDate(date) {
		let year = date.getFullYear();
		let month = String(date.getMonth() + 1).padStart(2, '0');
		let day = String(date.getDate()).padStart(2, '0');    
		return `${day}-${month}-${year}`;
	}









