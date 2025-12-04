   

$(document).on('change', '.select_transport_id', function () {
	let trans_id = $(this).val(); 
	if (trans_id != '') { 
        get_trans_id_info_func(trans_id)
    } else {
		$('.transport_info_assign').html('');
		$('.searching_html_datas').html('');

		$('.customer_pay_history_joma').html('');
		$('.customer_history_khoroc_cut').html('');
    }
});
 
function get_trans_id_info_func(trans_id) {
    $.ajax({
        type: "post",
        url: "expense/get_transport_info_by_id",
        data: {
            transp_id: trans_id
        },
        beforeSend: function() {
          $('.spiner_load_activity').css('display', 'block');
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
        },
        success: function (res) {  
		
			let adding_commission_data = 0;
			let adding_vara_data = 0;
			let cost_data_count = 0;

			for (let l = 0; l < res.total_adds_trans.length; l++) {
				let adding_commission_datass = 0;
				let adding_vara_datasss = 0;

				if (res.total_adds_trans[l].ttl_trans_other_cost == '' || res.total_adds_trans[l].ttl_trans_other_cost == null) {
					adding_commission_datass = 0;
				} else {
					adding_commission_datass = res.total_adds_trans[l].ttl_trans_other_cost;
				}

				if (res.total_adds_trans[l].ttl_com_amnt_for_trans == '' || res.total_adds_trans[l].ttl_com_amnt_for_trans == null) {
					adding_vara_datasss = 0;
				} else {
					adding_vara_datasss = res.total_adds_trans[l].ttl_com_amnt_for_trans;
				}
				adding_commission_data += parseFloat(adding_commission_datass);
				adding_vara_data += parseFloat(adding_vara_datasss);
			}

			for (let f = 0; f < res.total_cost_trans.length; f++) {
				cost_data_count += parseFloat(res.total_cost_trans[f].db_transport_payment_amount);
			}

			let bokeya_taka = (adding_commission_data + adding_vara_data) - cost_data_count;

			$('.transport_info_assign').html(
				`<div class="col-md-12 " style="margin: 20px 0;" >
					<div class="col-md-4 " style="margin-top: 20px;" >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">নাম </span>
							<div class="form-control">${res.trans.trans_port_namess}</div>
						</div>
					</div>

					<div class="col-md-4 " style="margin-top: 20px;"  >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">ফোন নং </span>
							<div class="form-control">${res.trans.trans_phone}</div>
						</div>
					</div>

					<div class="col-md-4 " style="margin-top: 20px;" >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">মোট বকেয়া </span>
							<div class="form-control">${res.trans.trans_now_due_sssss_amnt_ssamnt}</div> 
						</div>
					</div>

					<div class="col-md-10 " style="margin-top: 20px;"  >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">ঠিকানা </span>
							<div class="form-control">${res.trans.trans_addrs}</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 " style=""  >
					<div class="col-md-4 " style="margin-top: 20px;"  >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">টাকা দেওয়ার তারিখ </span>
							<input type="text" class="form-control datepicker add_cash_datingss " value="${getFormattedDate()}" placeholder=" তারিখ " >
						</div>
					</div>

					<div class="col-md-4 " style="margin-top: 20px;"  >
						<div class="input-group input-group-lg">
							<span class="input-group-addon " id="sizing-addon1">সময় </span>
							<input type="text" class="form-control add_cash_time_ss set_run_times " placeholder=" সময় " >
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
							<input type="text" class="form-control cash_amnt_input_box "  inputmode="numeric"  placeholder=" টাকা " >
						</div>
					</div>

					<div class="col-md-4 " style="margin-top: 20px;"  >
						<center>
							<div class="input-group input-group-lg">
								<div class="form-control btn cut_amount_from_cash_btn btn-info btn-custom-info ">টাকা দেন</div>
							</div>
						</center>
					</div>
				</div>`
			);
			$('.searching_html_datas').html(
				`<hr>
				<div class="row">
					<div class="col-md-8 col-md-offset-2 search-container">
						<h2 class="text-center">🔍 তারিখ থেকে তারিখ পর্যন্ত সার্চ করুন</h2>
						<div class="form-inline text-center">
							<div class="form-group">
								<label for="from_date">শুরুর তারিখ:</label>
								<input type="text" class="form-control datepicker date_of_starts " id="from_date" value="${getFormattedDate()}" name="from_date">
							</div>
							<div class="form-group">
								<label for="to_date">শেষ তারিখ:</label>
								<input type="text" class="form-control datepicker end_of_the_datess " value="${getFormattedDate()}" id="to_date" name="to_date">
							</div>
							<button type="submit" class="btn btn-custom searching_history_datas ">🔍 সার্চ করুন</button>
						</div>
					</div>
				</div>
                <div class="assign_html_data_history " style="margin-top: 30px; "></div>`
			);
        }
    });
}


$(document).on('click', '.cut_amount_from_cash_btn', function () {
	
	if ($('.select_transport_id').val() == '' || $('.add_cash_datingss').val() == '' || $('.add_cash_time_ss').val() == '' || $('.add_cash_types_by').val() == '' || $('.cash_amnt_input_box').val() == '') {
		toastr["error"]('');
	} else {
		
		$.ajax({
			type: "post",
			url: "expense/insert_transport_dues_func",
			data: {
				trans_id: 		$('.select_transport_id').val(),
				trans_name: 	$('.select_transport_id option:selected').text(),
				give_dates: 	$('.add_cash_datingss').val(),
				give_times: 	$('.add_cash_time_ss').val(),
				give_types: 	$('.add_cash_types_by').val(),
				give_paymnt: 	$('.cash_amnt_input_box').val(),
			},
			beforeSend: function() {
			  $('.spiner_load_activity').css('display', 'block');
			},
			complete: function() {
			  $('.spiner_load_activity').css('display', 'none');
			},
			success: function (rspp) {
				get_trans_id_info_func($('.select_transport_id').val())
				$('.transport_info_assign').html('');
				$('.searching_html_datas').html('');
				$('.customer_pay_history_joma').html('');
				$('.customer_history_khoroc_cut').html('');
				toastr["success"]('ট্রান্সপোর্ট এর টাকা প্রদান করা হয়েছে। ');
			}
		}); 
	}
});

$(document).on('click', '.searching_history_datas', function () { 
	if ($('.date_of_starts').val() == '' || $('.end_of_the_datess').val() == '') {
		toastr["error"]('তারিখ নির্ধারণ করুন');
	} else {
		$.ajax({
			type: "post",
			url: "tax/get_transport_infos_by_date_to_date",
			data: {
				from_date: $('.date_of_starts').val(),
				to_date: $('.end_of_the_datess').val(),
				tr_idx: $('.select_transport_id').val()
			},
			beforeSend: function() {
			  $('.spiner_load_activity').css('display', 'block');
			},
			complete: function() {
			  $('.spiner_load_activity').css('display', 'none');
			},
			success: function (re) {
				let table_tr_assign = '';
				let table_data = [];
				let tm = 0;
				let n = 0;

				for (n = 0; n < re.transport_infos.length; n++) {
                    table_data.push({
						serial: n + 1,
						date: re.transport_infos[n].pur_date_timsssss,
						supp_name: re.transport_infos[n].supplier_name,
						ttl_bosta: formatter.format(re.transport_infos[n].ttl_items_bosta_this_trans).getDigitBanglaFromEnglish(),
						rasta: formatter.format(re.transport_infos[n].prodct_sell_bosta_in_road).getDigitBanglaFromEnglish(),
						prev_amnt: formatter.format(re.transport_infos[n].trans_port_prev_amntss).getDigitBanglaFromEnglish(),
						trns_vara: formatter.format(re.transport_infos[n].trans_vara_cost).getDigitBanglaFromEnglish(),
						trns_comms: formatter.format(re.transport_infos[n].trans_comission_give).getDigitBanglaFromEnglish(),
						driver_advns: formatter.format(re.transport_infos[n].driver_advance_amnt_cost).getDigitBanglaFromEnglish(),
						now_amnt_s: formatter.format(re.transport_infos[n].due_trans_port_amnts_sss_now).getDigitBanglaFromEnglish(),
					 });
				}

				for (let m = 0; m < re.trns_give_amont.length; m++) {
                    table_data.push({
						serial: n++,
						date: re.trns_give_amont[m].db_transport_given_datess,
						supp_name: '----',
						ttl_bosta: '----',
						rasta: '----',
						prev_amnt: formatter.format(re.trns_give_amont[m].trns_prev_amnt_entrr).getDigitBanglaFromEnglish(),
						trns_vara: '----',
						trns_comms: re.trns_give_amont[m].db_transport_methods,
						driver_advns: 'জমা---- '+formatter.format(re.trns_give_amont[m].db_transport_payment_amount).getDigitBanglaFromEnglish(),
						now_amnt_s: formatter.format(re.trns_give_amont[m].trns_now_amnt_ssssss_shows).getDigitBanglaFromEnglish(),
					});
				}

               // তারিখ অনুযায়ী ডেটা sort করা
			   table_data.sort((a, b) => {
					let dateA = new Date(a.date);
					let dateB = new Date(b.date);

					// প্রথমে তারিখ অনুযায়ী sort
					if (dateA - dateB !== 0) {
						return dateA - dateB;
					}
				}); 

				// তারিখ অনুযায়ী ডেটা sort করা
				table_data.sort((a, b) => new Date(a.date) - new Date(b.date));
			
				// টেবিল পুনরায় তৈরি করা এবং সঠিক সিরিয়াল সেট করা
				table_data.forEach((data, index) => { 
					table_tr_assign += `<tr >
											<td class="text-center vertical-middle">${index + 1}</td>
											<td class="text-center vertical-middle" >${data.date}</td>
											<td class="text-center vertical-middle" >${data.supp_name}</td>
											<td class="text-center vertical-middle" >${data.ttl_bosta}</td>
											<td class="text-center vertical-middle" >${data.rasta}</td>
											<td class="text-right " style="text-align: right; " >${data.prev_amnt}</td>
											<td class="text-right " style="text-align: right; " >${data.trns_vara}</td>
											<td class="text-right " style="text-align: right; " >${data.trns_comms}</td>
											<td class="text-right " style="text-align: right; " >${data.driver_advns}</td>
											<td class="text-right " style="text-align: right; " >${data.now_amnt_s}</td>
										</tr>`;
				});




				$('.assign_html_data_history').html(
					`<div class="table-container">
						<h2 class="text-center">🔍 সার্চের ফলাফল</h2>
        				<div class="table-responsive"> 
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>তারিখ</th>
										<th>মহাজনের নাম</th>
										<th>মোট বস্তা</th>
										<th>রাস্তায় নামছে</th>
										<th>পূর্বের বকেয়া</th>
										<th>ট্রান্সপোর্ট ভাড়া</th>
										<th>ট্রান্সপোর্ট কমিশন</th>
										<th>ড্রাইভার এডভান্স</th>
										<th>বর্তমান বকেয়া</th>
									</tr>
								</thead>
								<tbody>
									${table_tr_assign}
								</tbody>
							</table>
						</div>
					</div>`
				);
			}
		});
	}
});

setInterval(() => {
	$('.set_run_times').val(moment().format('hh:mm:ss A'));
}, 1000);

function getFormattedDate() {
	let today = new Date();
	let day = today.getDate().toString().padStart(2, '0'); // Ensures 2-digit day
	let month = (today.getMonth() + 1).toString().padStart(2, '0'); // Month starts from 0
	let year = today.getFullYear();

	return `${day}-${month}-${year}`;
}