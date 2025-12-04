get_amanot_person_info();

$(document).on('click', '.amanot_person_info_added', function () { 
    if ($('.amanot_person_name').val() == '' || $('.amanot_person_mobile_no').val() == '' || $('.amanot_person_full_addresss').val() == '' ) {
        toastr["error"]("কোনো তথ্য খালী রাখা যাবে না। "); 
    }else {
        $.ajax({
            type: "post",
            url: "payment_types/add_amanot_person_infos",
            data: {
                p_name: $('.amanot_person_name').val(), 
                p_mobile: $('.amanot_person_mobile_no').val(),
                p_address: $('.amanot_person_full_addresss').val(),
                amanot_person_wa_nos:   $('.amanot_person_imo_sss_numberssss').val(),
                amanot_person_imos_nos: $('.amanot_person_wapp_numbersss').val()
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
            },
            success: function (rp) {
                $('#modal_payments_adding').modal('hide');
                get_amanot_person_info();
                toastr["success"]("ব্যক্তির তথ্য যোগ করা হয়েছে। "); 
            }
        });
    }
});

function get_amanot_person_info() {
    $.ajax({
        type: "post",
        url: "payment_types/get_amanot_all_person_info",
        data: "",
        success: function (r) {
            let sopt = '';
            for (let n = 0; n < r.length; n++) {
                sopt += `<option value="${r[n].amanot_person_info_iddd}">${r[n].amanot_person_name_full}-${r[n].amanot_person_address} - ${r[n].person_mobile_nosss}</option>`;
            }
            $('.selects_person_info').html(`<option value="">ব্যক্তির নাম সিলেক্ট করুন</option>${sopt}`);
        }
    });
} 



function get_amanot_person_info_for_editting() {
    $.ajax({
        type: "post",
        url: "payment_types/get_amanot_all_person_info",
        data: "",
        success: function (r) {
            let sopt = '';
            for (let n = 0; n < r.length; n++) {
                sopt += `<tr>
                            <td>${n+1}</td>
                            <td>${r[n].amanot_person_name_full}</td>
                            <td>${r[n].amanot_person_address}</td>
                            <td>${r[n].person_mobile_nosss}</td>
                            <td>${r[n].person_whatsapp_no_set}</td>
                            <td>${r[n].amanot_imo_number_setss}</td>
                            <td><button class="btn btn-info btn-sm edit_this_row_btn_s_with_iddds " amanot_unq_idddd="${r[n].amanot_person_info_iddd}" data-toggle="modal" data-target="#editAmanotModalss"><i class="fa fa-pencil " ></i> </button></td>
                        </tr>`;
            }
            $('.amanot_full_infos_details').html(sopt);
        }
    });
} 

$(document).on('click', '.edit_this_row_btn_s_with_iddds', function () {
    $.ajax({
        type: "post",
        url: "payment_types/get_amanot_person_infos_ssss",
        data: {
            amanot_idds: $(this).attr('amanot_unq_idddd')
        },
        success: function (ssa) {
            $('.amanot_person_namess').val(ssa.amanots_data.amanot_person_name_full);
            $('.person_addressss').val(ssa.amanots_data.amanot_person_address);
            $('.amanot_person_mobilesss').val(ssa.amanots_data.person_mobile_nosss);
            $('.amanot_person_mobile_WhatsApp_sss').val(ssa.amanots_data.person_whatsapp_no_set);
            $('.amanot_person_imo_mobile').val(ssa.amanots_data.amanot_imo_number_setss);
            $('.edit_full_info_with_id').attr('amanot_aat_idddds', ssa.amanots_data.amanot_person_info_iddd );
        }
    });
});

function TodaysformatDate(date) {
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let day = String(date.getDate()).padStart(2, '0');    
    return `${day}-${month}-${year}`;
}

$(document).on('change', '.selects_person_info', function () { 
    if ($(this).val() == '') {
        toastr["error"]("কোনো তথ্য খালী রাখা যাবে না। "); 
    } else { 

        // উদাহরণ ব্যবহার:
        let today = new Date();

        $.ajax({
            type: "post",
            url: "payment_types/get_amanot_person_infos_ssss", 
            data: {
                amanot_idds: $(this).val() 
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
            },
            success: function (s) {
                let amnt_takasss = 0;
                let amnt_type_text = '';
                let ttl_amanot_take_amount = 0;
                let ttl_cut_amanot_taka = 0;
                if (s.ttl_amanot_take_amount == null) {
                    ttl_amanot_take_amount = 0;
                } else {
                    ttl_amanot_take_amount = s.ttl_amanot_take_amount;
                }
                if (s.ttl_cut_amanot_taka == null) {
                    ttl_cut_amanot_taka = 0;
                } else {
                    ttl_cut_amanot_taka = s.ttl_cut_amanot_taka;
                }
                let amnt_info = parseFloat(ttl_amanot_take_amount) - parseFloat(ttl_cut_amanot_taka); 

                if (amnt_info > 0) {
                    amnt_takasss = parseFloat(ttl_amanot_take_amount) - parseFloat(ttl_cut_amanot_taka);
                    amnt_type_text = 'তিনি পাবেন';
                } else if (amnt_info < 0) {
                    amnt_takasss = parseFloat(ttl_amanot_take_amount) - parseFloat(ttl_cut_amanot_taka);
                    amnt_type_text = 'আপনি পাবেন';
                } else if (amnt_info == 0) {
                    amnt_takasss = parseFloat(ttl_amanot_take_amount) - parseFloat(ttl_cut_amanot_taka);
                    amnt_type_text = 'উনার একাউন্ট শূন্য';
                }

                $('.profile_infos_display').html(
                    `<div class="row" style="margin-top: 15px; " >
                        <div class="col-md-6 col-md-offset-3">
                            <div class="profile-card">
                                <img src="uploads/users/amanot_pro_pic.png" class="profile-img" alt="প্রোফাইল ছবি">
                                <h2 style="color: white; " ><strong>${s.amanots_data.amanot_person_name_full}</strong></h2>
                                <p><strong>ঠিকানা:</strong> ${s.amanots_data.amanot_person_address} </p>
                                <p><strong>ফোন:</strong> ${s.amanots_data.person_mobile_nosss} </p>
                                <h2 style="color: white; " ><strong>মোট জমা:</strong> ${formatter.format(s.ttl_amanot_take_amount).getDigitBanglaFromEnglish()} </h2>
                                <h2 style="color: white; " ><strong>মোট প্রদান:</strong> ${formatter.format(s.ttl_cut_amanot_taka).getDigitBanglaFromEnglish()} </h2>
                                <h2 style="color: white; " >${amnt_type_text}:  ${formatter.format(amnt_takasss).getDigitBanglaFromEnglish()} </h2>
                            </div>
                        </div>
                    </div>`
                );  
                $('.set_details_tab_info').html(
                    `<!-- Nav tabs -->
                    <ul class="nav nav-tabs panel-heading" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">টাকা গ্রহন (জমা)</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">টাকা প্রদান (খরচ)</a></li>
                    </ul>
                    <!-- Nav tabs -->

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">

                            <div class="custom-container">
                                <h2 class="custom-title">আমানতের টাকা গ্রহন (জমা)</h2>
                                <div class="row">
                                    <div class="col-md-6 custom-group">
                                        <label for="name" class="custom-label">তারিখ:</label>
                                        <input type="text" class="custom-input datepicker take_selected_datess" id="name" value="${TodaysformatDate(today)}" placeholder="তারিখ">
                                    </div>
                                    <div class="col-md-6 custom-group">
                                        <label for="email" class="custom-label">সময়:</label>
                                        <input type="text" class="custom-input taking_timess " id="email" value="" placeholder="">
                                    </div>
                                    <div class="col-md-6 custom-group">
                                        <label for="name" class="custom-label">মারফত:</label>
                                        <input type="text" class="custom-input taking_amount_marfots " id="name" value="" placeholder="মারফত">
                                    </div>
                                    <div class="col-md-6 custom-group">
                                        <label for="email" class="custom-label">টাকার পরিমাণ:</label>
                                        <input type="text" class="custom-input taking_amount_tk " id="email" inputmode="numeric" value="" placeholder="টাকার পরিমাণ">
                                    </div>
                                    <button class="custom-btn taking_amnt_btn ">ক্যাশে যোগ করুন</button>
                                </div>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">

                            <div class="custom-container">
                                <h2 class="custom-title">আমানতের টাকা প্রদান (খরচ)</h2>
                                <div class="row">
                                    <div class="col-md-6 custom-group">
                                        <label for="name" class="custom-label">তারিখ:</label>
                                        <input type="text" class="custom-input datepicker cut_selected_datess " id="name" value="${TodaysformatDate(today)}" placeholder="তারিখ">
                                    </div>
                                    <div class="col-md-6 custom-group">
                                        <label for="email" class="custom-label">সময়:</label>
                                        <input type="text" class="custom-input cutting_timess " id="email" value="" placeholder="">
                                    </div>
                                    <div class="col-md-6 custom-group">
                                        <label for="name" class="custom-label">মারফত:</label>
                                        <input type="text" class="custom-input give_amount_marfot_cut " id="name" value="" placeholder="মারফত">
                                    </div>
                                    <div class="col-md-6 custom-group">
                                        <label for="email" class="custom-label">টাকার পরিমাণ:</label>
                                        <input type="text" class="custom-input amount_of_cutting " inputmode="numeric" id="email" value="" placeholder="টাকার পরিমাণ">
                                    </div>
                                    <button class="custom-btn give_amanot_amount_cutting">ক্যাশ থেকে প্রদান</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Tab panes -->`
                );  
            }
        });  

    } 
});

$(document).on('click', '.addedd_new_amanot_person', function () {
    if ($('._new_person_namess').val() == '') {
        toastr["error"]("ব্যক্তির নাম লিখুন। "); 
    }else {

        $.ajax({
            type: "post",
            url: "payment_types/add_amanot_person_infos",
            data: {
                p_name:                 $('._new_person_namess').val(),
                p_address:              $('._new_person_addresss').val(),
                p_mobile:               $('._new_person_phone_nos').val(),
                amanot_person_wa_nos:   $('._new_person_wa_nos').val(),
                amanot_person_imos_nos: $('._new_person_imoss_phone').val()
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
            },
            success: function (srr) {
                toastr["success"](" নতুন আমানত ব্যাক্তি যোগ হয়েছে। ");
                get_amanot_person_info_for_editting(); 
            }
        });

    }
});

$(document).on('click', '.edit_full_info_with_id', function () {
    if ($(this).attr('amanot_aat_idddds') == '') {
        toastr["error"]("সার্ভার সমস্যা, কিছুক্ষণ পরে আবার চেষ্টা করুন।  ");         
    }else {
        $.ajax({
            type: "post",
            url: "payment_types/edit_amanot_person_info_by_ids",
            data: {
                p_name:                 $('.amanot_person_namess').val(),
                p_address:              $('.person_addressss').val(),
                p_mobile:               $('.amanot_person_mobilesss').val(),
                amanot_person_wa_nos:   $('.amanot_person_mobile_WhatsApp_sss').val(),
                amanot_person_imos_nos: $('.amanot_person_imo_mobile').val(),
                amanot_person_auto_id:  $(this).attr('amanot_aat_idddds')
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
            },
            success: function (response) {
                toastr["success"](" আমানত ব্যাক্তি তথ্য এডিট হয়েছে। ");
                get_amanot_person_info_for_editting();
                $('#editAmanotModalss').modal('hide'); 
            }
        });
    }
});

$(document).on('click', '.taking_amnt_btn', function () {
    if ($('.selects_person_info').val() == '') {
        toastr["error"]("ব্যক্তির নাম সিলেক্ট করা হয় নাই। "); 
    } else if ($('.take_selected_datess').val() == '') {
        toastr["error"]("তারিখ সিলেক্ট করা হয় নাই। ");
    } else if ($('.taking_timess').val() == '') {
        toastr["error"]("সময় সিলেক্ট করুন। ");
    } else if ($('.taking_amount_tk').val() == '') {
        toastr["error"]("টাকার পরিমাণ দেন নাই। ");
    } else {
        $.ajax({
            type: "post",
            url: "payment_types/add_amanot_taking_info",
            data: {
                take_person: $('.selects_person_info').val(),
                take_person_name: $(".selects_person_info option:selected").text(),
                take_datess: $('.take_selected_datess').val(),
                take_timess: $('.taking_timess').val(),
                taking_marfot: $('.taking_amount_marfots').val(),
                take_amount: $('.taking_amount_tk').val()
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
            },
            success: function (rpss) {
                toastr["success"]("টাকা ক্যশে জমা হয়েছে। ");
                $('.selects_person_info').val('');
                $('.taking_timess').val('');
                $('.taking_amount_tk').val('');
            }
        });
    }
});

$(document).on('click', '.give_amanot_amount_cutting', function () {
    if ($('.selects_person_info').val() == '') {
        toastr["error"]("ব্যক্তির নাম সিলেক্ট করা হয় নাই। "); 
    } else if ($('.cut_selected_datess').val() == '') {
        toastr["error"]("তারিখ সিলেক্ট করা হয় নাই। ");
    } else if ($('.cutting_timess').val() == '') {
        toastr["error"]("সময় সিলেক্ট করুন। ");
    } else if ($('.amount_of_cutting').val() == '') {
        toastr["error"]("টাকার পরিমাণ দেন নাই। ");
    } else { 
        $.ajax({
            type: "post",
            url: "payment_types/give_amanot_cutting_amount",
            data: {
                take_person: $('.selects_person_info').val(),
                take_person_name: $(".selects_person_info option:selected").text(),
                take_datess: $('.cut_selected_datess').val(),
                give_timess: $('.cutting_timess').val(),
                give_marfot: $('.give_amount_marfot_cut').val(),
                give_amount: $('.amount_of_cutting').val()
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
            },
            success: function (rpss) {
                toastr["success"]("টাকা ক্যশ থেকে খরচ হয়েছে। ");
                $('.selects_person_info').val('');
                $('.cutting_timess').val('');
                $('.amount_of_cutting').val('');
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
    $('.cutting_timess').val(timeString);
    $('.taking_timess').val(timeString);
}
    updateClock();
    setInterval(updateClock, 1000);



$(document).on('click', '.data_searching_btn', function () {
    if ($('.selects_person_info').val() == '') {
        toastr["error"]("ব্যক্তির নাম সিলেক্ট করা হয় নাই। "); 
    } else if ($('.date_starts').val() == '') {
        toastr["error"]("শুরুর তারিখ সিলেক্ট করা হয় নাই। ");
    } else if ($('.ending_datess').val() == '') {
        toastr["error"]("শেষের তারিখ সিলেক্ট করা হয় নাই। ");
    } else {
        searching_amanot_all_data($('.date_starts').val(), $('.ending_datess').val(), $('.selects_person_info').val());
    }
});

function searching_amanot_all_data(start_date, end_date, perosn_id) {

    $.ajax({
        type: "post",
        url: "payment_types/get_amanot_data_by_date_to_date",
        data: {
            take_person: perosn_id,
            start_dates: start_date,
            ends_timess: end_date
        },
        success: function (ss) { 

            let adding_data = '';
            let cutting_data = '';

            for (let a = 0; a < ss.taking_data.length; a++) {
                adding_data += `<tr>
                                    <td>${a+1}</td>
                                    <td>${ss.taking_data[a].amanot_dates}</td>
                                    <td>${ss.taking_data[a].amanot_timess}</td>
                                    <td>${ss?.taking_data[a]?.amanot_marfot && ss.taking_data[a].amanot_marfot || ''}</td>
                                    <td align="right" >${ss.taking_data[a].taking_amounts}</td>
                                    <td><div class="btn btn-danger delete_this_taking " id_attr_s="${ss.taking_data[a].db_amanot_add_idd}" ><i class="fa fa-trash"></i></div></td>
                                </tr>`;
            }

            for (let b = 0; b < ss.giving_data.length; b++) {
                cutting_data += `<tr>
                                    <td>${b+1}</td>
                                    <td>${ss.giving_data[b].amanot_give_datess}</td>
                                    <td>${ss.giving_data[b].amanot_give_timess}</td>
                                    <td>${ss?.giving_data[b]?.amanot_marfot_take && ss.giving_data[b].amanot_marfot_take || ''}</td>
                                    <td align="right" >${ss.giving_data[b].giving_amnt}</td>
                                    <td><div class="btn btn-danger delete_this_giving " id_attr_s="${ss.giving_data[b].db_amanot_giving_id}" ><i class="fa fa-trash"></i></div></td>
                                </tr>`;
            }
            $('.adding_data').html(adding_data);
            $('.cutting_data').html(cutting_data);
        }
    });

}

$(document).on('click', '.delete_this_taking', function () {
    $.ajax({
        type: "post",
        url: "payment_types/delete_taking_data_by_id",
        data: {
            id: $(this).attr('id_attr_s')
        },
        success: function (asp) {
            toastr["success"]("ডিলেট হয়ে গেছে "); 
            searching_amanot_all_data($('.date_starts').val(), $('.ending_datess').val(), $('.selects_person_info').val());
        }
    });
}); 

$(document).on('click', '.delete_this_giving', function () {
    $.ajax({
        type: "post",
        url: "payment_types/delete_giving_infos_by_id",
        data: {
            id: $(this).attr('id_attr_s')
        },
        success: function (psr) {
            toastr["success"]("ডিলেট হয়ে গেছে "); 
            searching_amanot_all_data($('.date_starts').val(), $('.ending_datess').val(), $('.selects_person_info').val());
        }
    });
});





$('.staff_saves_btn').click(function () {
    if ($('.staff_names').val() != '' && $('.staff_mobiles').val() != '' && $('.staff_address').val() != '') {
        $.ajax({
            type: "post",
            url: "payment_types/staff_saves",
            data: {
                staff_name: $('.staff_names').val(),
                staff_mobile: $('.staff_mobiles').val(),
                staff_address: $('.staff_address').val()
            },
            beforeSend: function() {
              $('.spiner_load_activity').css('display', 'block');
                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $('.staff_saves_btn').css('display', 'none');
            },
            success: function (r) {
                $('.staff_names').val('')
                $('.staff_mobiles').val('')
                $('.staff_address').val('')
                get_all_staff_inofsss();
            },
            complete: function() {
              $('.spiner_load_activity').css('display', 'none');
                $(".overlay").remove();
                $('.staff_saves_btn').css('display', 'block');
            }
        });
    } else {
        toastr['error']('সবগুলো তথ্য পূরণ করতেই হবে');
    }
});

function get_all_staff_inofsss() {
    $.ajax({
        type: "post",
        url: "payment_types/get_all_staff",
        data: "",
        beforeSend: function() {
            $('.spiner_load_activity').css('display', 'block');
            $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
            $('.staff_saves_btn').css('display', 'none');
        },
        success: function (rs) {
            // var staffs = JSON.parse(rs);
            let all_staff = '';
            for (let nm = 0; nm < rs.length; nm++) {
                all_staff +=`<tr>
                                <td>${nm+1}</td>
                                <td>${rs[nm].staff_namess}</td>
                                <td>${rs[nm].staff_mobiless}</td>
                                <td>${rs[nm].staff_addrss}</td>
                                <td><div class="btn btn-info btn-xs edit_the_staf_info" edit_id="${rs[nm].db_staff_info_id}"><i class="fa fa-edit"></i></div></td>
                            </tr>`;
                
            }
            $('.display_all_staff_datas').html(all_staff);
        },
        complete: function() {
          $('.spiner_load_activity').css('display', 'none');
            $(".overlay").remove();
            $('.staff_saves_btn').css('display', 'block');
        }
    });
}

$(document).on('click', '.search_this_amanot_historysss_btns', function () {
    if ($('.id_select_person_infos').val() == '' || $('.select_start_date').val() == '' || $('.select_end_datess').val() == '') { 
        toastr["error"]("সকল তথ্য পূরণ করুন। "); 
    } else {
        $.ajax({
            type: "post",
            url: "payment_types/get_amanot_data_by_date_to_date",
            data: {
                take_person: $('.id_select_person_infos').val(),
                start_dates: $('.select_start_date').val(),
                ends_timess: $('.select_end_datess').val()
            },
            beforeSend: function() {
                $('.spiner_load_activity').css('display', 'block');
            },
            complete: function() {
                $('.spiner_load_activity').css('display', 'none');
            },
            success: function (res) {

               let table_tr_assign = '';
               let table_data = []; 
               let i = 0;
               let take_amnt = 0;
               let give_amnt = 0;

                for (i = 0; i < res.taking_data.length; i++) {
                    take_amnt += parseFloat(res.taking_data[i].taking_amounts);
                    table_data.push({
                        serial: i + 1,
                        dates: res.taking_data[i].amanot_dates,
                        times: res.taking_data[i].amanot_timess,
                        marfot: res.taking_data[i].amanot_marfot,
                        jamounts: res.taking_data[i].taking_amounts,
                        kamounts: 0,
                        cr_dates: res.taking_data[i].cr_datess,
                        cr_times: res.taking_data[i].cr_timings,
                    });
                }

                for (let nn = 0; nn < res.giving_data.length; nn++) { 
                    give_amnt += parseFloat(res.giving_data[nn].giving_amnt);
                    table_data.push({
                        serial: i++,
                        dates: res.giving_data[nn].amanot_give_datess,
                        times: res.giving_data[nn].amanot_give_timess,
                        marfot: res.giving_data[nn].amanot_marfot_take,
                        jamounts: 0,
                        kamounts: res.giving_data[nn].giving_amnt,
                        cr_dates: res.giving_data[nn].entryss_datesss,
                        cr_times: res.giving_data[nn].entryss_timesss,
                    });
                }

               // তারিখ এবং times অনুযায়ী ডেটা sort করা 
                table_data.sort((a, b) => {
                    let dateA = new Date(a.dates);
                    let dateB = new Date(b.dates);

                    // প্রথমে তারিখ অনুযায়ী sort
                    if (dateA - dateB !== 0) {
                        return dateA - dateB;
                    }

                    // যদি তারিখ একই হয়, তখন times অনুযায়ী sort                    
                    return a.cr_times && b.cr_times ? a.cr_times.localeCompare(b.cr_times, undefined, { numeric: true }) : 0;
                }); 

                table_data.forEach((data, index) => {
                    table_tr_assign += `<tr>
                                            <td>${index+1}</td>
                                            <td>${data.dates}</td>
                                            <td>${data.times}</td>
                                            <td>${data.marfot}</td>
                                            <td align="right">${formatter.format(data.jamounts).getDigitBanglaFromEnglish()}</td>
                                            <td align="right">${formatter.format(data.kamounts).getDigitBanglaFromEnglish()}</td>
                                            <td></td>
                                        </tr>`;
                })

                
                let amnt_takasss = 0;
                let amnt_type_text = '';
                let ttl_amanot_take_amount = 0;
                let ttl_cut_amanot_taka = 0;
                if (res.ttl_amanot_take_amount == null) {
                    ttl_amanot_take_amount = 0;
                } else {
                    ttl_amanot_take_amount = res.ttl_amanot_take_amount;
                }
                if (res.ttl_cut_amanot_taka == null) {
                    ttl_cut_amanot_taka = 0;
                } else {
                    ttl_cut_amanot_taka = res.ttl_cut_amanot_taka;
                }
                let amnt_info = parseFloat(ttl_amanot_take_amount) - parseFloat(ttl_cut_amanot_taka); 

                if (amnt_info > 0) {
                    amnt_takasss = parseFloat(ttl_amanot_take_amount) - parseFloat(ttl_cut_amanot_taka);
                    amnt_type_text = 'তিনি পাবেন';
                } else if (amnt_info < 0) {
                    amnt_takasss = parseFloat(ttl_amanot_take_amount) - parseFloat(ttl_cut_amanot_taka);
                    amnt_type_text = 'আপনি পাবেন';
                } else if (amnt_info == 0) {
                    amnt_takasss = parseFloat(ttl_amanot_take_amount) - parseFloat(ttl_cut_amanot_taka);
                    amnt_type_text = 'উনার একাউন্ট শূন্য';
                }

                $('.summary_datas_box_set').html(
                    `<div class="col-sm-4">
                        <div class="summary-box bg-total text-center">
                            <div class="summary-title">মোট জমা</div>
                            <div class="summary-amount">${formatter.format(res.ttl_amanot_take_amount).getDigitBanglaFromEnglish()}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="summary-box bg-paid text-center">
                            <div class="summary-title">মোট প্রদান</div>
                            <div class="summary-amount">${formatter.format(res.ttl_cut_amanot_taka).getDigitBanglaFromEnglish()}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="summary-box bg-due text-center">
                            <div class="summary-title">${amnt_type_text}</div>
                            <div class="summary-amount">${formatter.format(amnt_takasss).getDigitBanglaFromEnglish()}</div>
                        </div>
                    </div>`
                );

                $('.amanot_history_date_to_date_details').html(`${table_tr_assign}<tr><td></td><td></td><td></td><td></td><td align="right" style="font-weight: bold;" >${formatter.format(take_amnt).getDigitBanglaFromEnglish()}</td><td align="right" style="font-weight: bold;" >${formatter.format(give_amnt).getDigitBanglaFromEnglish()}</td><td></td></tr>`); 
            }
        });
    }
});







