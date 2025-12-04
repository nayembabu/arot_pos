 

              <div class="modal fade " id="customer-modal" tabindex='-1'>
                <?= form_open('#', array('class' => '', 'id' => 'customer-form')); ?>
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header header-custom">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title text-center"><?= $this->lang->line('add_customer'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="customer_name"><?= $this->lang->line('customer_name'); ?>*</label>
                                <span id="customer_name_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control cus_name" id="customer_name" name="customer_name" placeholder="কাস্টমারের নাম" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="mobile"><?= $this->lang->line('mobile'); ?></label>
                                <span id="mobile_msg" class="text-danger text-right pull-right"></span>
                                <input type="tel"  class="form-control no_special_char_no_space cus_mobile_no " id="mobile" name="mobile" placeholder="মোবাইল নং"  >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="opening_balance"><?= $this->lang->line('previous_due'); ?></label>
                                <span id="opening_balance_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control cus_previous_due" id="opening_balance" name="opening_balance" placeholder="" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="address"><?= $this->lang->line('address'); ?></label>
                                <span id="address_msg" class="text-danger text-right pull-right"></span>
                                <textarea type="text" rows="3" class="form-control cus_addrs" id="address" name="address" placeholder="পুরো ঠিকানা টাইপ করেন। " ></textarea>
                              </div>
                            </div>
                          </div>

                        </div>
                       
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary add_customer">Save</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
               <?= form_close();?>
              </div>
              <!-- /.modal -->






              

<!-- Modal Structure -->
<div id="customer_previous_paidable_amount" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content" style="border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
            <!-- Modal Header -->
            <div class="modal-header" style="background: linear-gradient(135deg,rgb(76, 84, 175),rgb(37, 50, 110)); color: white; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                <h2 class="modal-title text-center supp_name_ss">কাস্টমারের সাবেক পরিবর্তন</h2>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 20px; background-color: #f7f9fc;  animation: fadeIn 2s;">
            <p style="font-size: 20px;"><strong class="lot_namess"></strong></p>
            <p class="details_of_lotsss" style="font-size: 16px; margin: -20px 0 20px 0;" ></p>
            <p style="font-size: 18px;"><strong> কাস্টমারের সাবেক  </strong></p>
                <div id="accordion">
                    <!-- Customer F -->
                    <div class="customer_prev_html_assign " ></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="background: #f1f1f1; text-align: center; padding: 15px;">
                <button type="button" class="btn btn-success update_customer_prevss " style="background: linear-gradient(135deg,rgb(22, 27, 81),rgb(45, 13, 148)); color: white; border-radius: 30px; padding: 10px 20px;">SAVE</button>
            </div>
        </div>
    </div>
</div>





<!-- Modal Structure -->
<div id="customer_all_info_edit_s" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content" style="border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
            <!-- Modal Header -->
            <div class="modal-header" style="background: linear-gradient(135deg,rgb(65, 32, 72),rgb(61, 41, 59)); color: white; padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button> 
                <h2 class="modal-title text-center form-header">কাস্টমারের তথ্য পরিবর্তন</h2>
            </div>

            <!-- Modal Body -->
            <div class="modal-body " style="padding: 20px; background-color: #f7f9fc;  animation: fadeIn 2s;">
              <div id="accordion ">
                  <!-- Customer F -->
                  <div class="customer_full_info_html_assign form-container " ></div>
              </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="background: #f1f1f1; text-align: center; padding: 15px;">
                <button type="button" class="btn btn-success submit-btn update_customer_all_info_sss " style="background: linear-gradient(135deg,rgb(92, 11, 92),rgb(35, 3, 26)); color: white; border-radius: 30px; padding: 10px 20px;">SAVE</button>
            </div>
        </div>
    </div>
</div>



