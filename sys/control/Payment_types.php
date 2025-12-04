<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Payment_types extends MY_Controller { 
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('payment_types_model','payment_types');
		$this->load->model('buy_model','buy');
	}

    public function staff_add_view_file() 
    { 
		$data=$this->data; 
		$data['page_title']='স্টাফ যোগ করুন';
        $this->load->view('staff_view_pages', $data);
    }

    public function staff_saves()
    {
        $this->buy->insert_new_staff_info(
			array(
				"staff_namess" 				=> $this->input->post('staff_name'),
				"staff_mobiless" 			=> $this->input->post('staff_mobile'),
				"staff_addrss" 				=> $this->input->post('staff_address'),
			)
		);
    }

    public function get_all_staff()
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(
                json_encode(
                    $this->buy
                         ->get_staff_infos_data()
                        )
                    );   
    }
	
	public function get_all_staff_info_by_id()
	{
        $this->output
            ->set_content_type('application/json')
            ->set_output(
                json_encode(
                    $this->buy
                         ->get_staff_infos_data_by_id($this->input->post('edit_id'))
                        )
                    );   
	}

	public function update_staff_info()
	{
		$this->buy->update_staff_info_data_by_id(
			array(
				"staff_namess" 				=> $this->input->post('staff_name'),
				"staff_mobiless" 			=> $this->input->post('staff_mobile'),
				"staff_addrss" 				=> $this->input->post('staff_address'),
			), $this->input->post('edit_id')
		);
	}
 
	public function amanot_taken_view_fun()
	{   
		$data=$this->data;
		$data['page_title']='আমানত';
		$this->load->view('amanot_add_view_file', $data);
	}
 
	public function amanot_history_check_s()
	{   
		$data=$this->data;
		$data['page_title']='আমানত বিস্তারিত';
		$this->load->view('amanot_history_view_file', $data);
	}

	public function add(){
		$this->permission_check('payment_types_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('payment_types');
		$this->load->view('payment_types', $data);
	}

	public function add_new_amanot_fun(){
		$this->permission_check('payment_types_add');
		$data=$this->data;
		$data['page_title']= 'নতুন আমানতের ব্যক্তি যোগ';
		$this->load->view('add_new_amanot_view_files', $data);
	}

	public function send_smsto_amanot_persons()
	{
		$data=$this->data;
		$data['page_title']= 'আমানতের sms করুন ';
		$this->load->view('send_sms_to_amanot_view_files', $data);
	}

	public function send_amanot_person_sms_query_by_date()
	{
		$selected_dates = $this->input->post('select_dates');  
        $data['company_info'] = $this->buy->get_company_info(); 
		$data['added_amanot'] = $this->buy->get_amanot_person_sms_query_by_date(date('Y-m-d', strtotime($selected_dates)));
		$data['giving_amanot'] = $this->buy->get_giving_amanot_query_by_date(date('Y-m-d', strtotime($selected_dates)));
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
		
	}

	public function get_amanot_person_full_info_and_amount_by_idd()
	{
		$selected_dates = date('Y-m-d', strtotime($this->input->post('dates')));  
		$previous_day = date('Y-m-d', strtotime($this->input->post('dates') . ' -1 day')); 
		$person_id = $this->input->post('person_id');  

		$data['amanot_person_info'] = $this->buy->get_amanot_person_info_by_id($person_id); 
		$data['ttl_now_taking_amount'] = $this->buy->get_amanot_taking_amount_total($person_id); 
		$data['ttl_now_cutting_amount'] = $this->buy->get_ttl_cutting_amounts($person_id); 

		$data['ttl_prev_taking_amount'] = $this->buy->get_ttl_amanot_taking_amount_by_id_and_date($person_id, '2024-01-01', $previous_day); 
		$data['ttl_prev_cutting_amount'] = $this->buy->get_ttl_amanot_cutting_amount_by_date_and_id($person_id, '2024-01-01', $previous_day); 

		$data['ttl_select_taking_amount'] = $this->buy->get_ttl_amanot_taking_amount_by_id_and_date($person_id, '2024-01-01', $selected_dates); 
		$data['ttl_select_cutting_amount'] = $this->buy->get_ttl_amanot_cutting_amount_by_date_and_id($person_id, '2024-01-01', $selected_dates); 
		$this->output->set_content_type('application/json')->set_output(json_encode($data));  
	}

	public function add_amanot_person_infos()
	{
		$this->buy->insert_amanot_person_info_data(
			array(
				"amanot_person_name_full" 	=> $this->input->post('p_name'),
				"amanot_person_address" 	=> $this->input->post('p_address'),
				"person_mobile_nosss" 		=> $this->input->post('p_mobile'),
				"person_whatsapp_no_set" 	=> $this->input->post('amanot_person_wa_nos'),
				"amanot_imo_number_setss" 	=> $this->input->post('amanot_person_imos_nos'),
				"entr_times" 				=> time(),
			)
		);
	}

	public function edit_amanot_person_info_by_ids()
	{
		$this->buy->edit_amanot_person_info_data_by_idd(
			array(
				"amanot_person_name_full" 	=> $this->input->post('p_name'),
				"amanot_person_address" 	=> $this->input->post('p_address'),
				"person_mobile_nosss" 		=> $this->input->post('p_mobile'),
				"person_whatsapp_no_set" 	=> $this->input->post('amanot_person_wa_nos'),
				"amanot_imo_number_setss" 	=> $this->input->post('amanot_person_imos_nos')
			), $this->input->post('amanot_person_auto_id')
		);
	}

	public function add_amanot_taking_info()
	{
		$person_text = $this->input->post('take_person_name');
		$this->buy->insert_amanot_taking_infos_data(
			array(
				"id_person_unq" 	=> $this->input->post('take_person'),
				"amanot_dates" 		=> date('Y-m-d', strtotime($this->input->post('take_datess'))),
				"amanot_timess" 	=> $this->input->post('take_timess'),
				"amanot_marfot" 	=> $this->input->post('taking_marfot'),
				"taking_amounts" 	=> $this->input->post('take_amount'),
				"cr_datess" 		=> date('Y-m-d'),
				"cr_timings" 		=> time(),
			)
		);
		
		$this->buy->insert_income_payment(
			array(
				"income_date"			=> date('Y-m-d', strtotime($this->input->post('take_datess'))),
				"income_for"			=> "$person_text আমানত টাকা ক্যাশে যোগ হয়েছে (আয়)",
				"income_amount"			=> $this->input->post('take_amount'),
				"c_o_p"					=> 2,
				"create_date"			=> date('Y-m-d'),
				"created_time"			=> time(),
			)
		); 
	}
 
	public function give_amanot_cutting_amount()
	{
		$person_text = $this->input->post('take_person_name');
		$this->buy->insert_amanot_cutting_info_data_give(
			array(
				"id_unq_person" 		=> $this->input->post('take_person'),
				"amanot_give_datess" 	=> date('Y-m-d', strtotime($this->input->post('take_datess'))),
				"amanot_give_timess" 	=> $this->input->post('give_timess'),
				"amanot_marfot_take" 	=> $this->input->post('give_marfot'),
				"giving_amnt" 			=> $this->input->post('give_amount'),
				"entryss_datesss" 		=> date('Y-m-d'),
				"entryss_timesss" 		=> time(),
			)
		);
		
		$this->buy->insert_expense_data(
			array(
				"expense_date"			=> date('Y-m-d', strtotime($this->input->post('take_datess'))),
				"expense_for"			=> "$person_text আমানতের টাকা প্রদান করা হয়েছে",
				"expense_amt"			=> $this->input->post('give_amount'),
				"o_p"					=> 1,
				"created_date"			=> date('Y-m-d'),
				"created_time"			=> time(),
			)
		);
	}

	public function get_amanot_data_by_date_to_date()
	{
        
		$data['amanots_data'] = $this->buy->get_amanot_person_info_by_id($this->input->post('take_person')); 

		$data['ttl_amanot_take_amount'] = $this->buy->get_amanot_taking_amount_total($this->input->post('take_person')); 
		$data['ttl_cut_amanot_taka'] = $this->buy->get_ttl_cutting_amounts($this->input->post('take_person')); 

		$data['taking_data'] = $this->buy->get_amanot_taking_data($this->input->post('take_person'), date('Y-m-d', strtotime($this->input->post('start_dates'))), date('Y-m-d', strtotime($this->input->post('ends_timess')))); 
		$data['giving_data'] = $this->buy->get_amanot_cutting_data_give($this->input->post('take_person'), date('Y-m-d', strtotime($this->input->post('start_dates'))), date('Y-m-d', strtotime($this->input->post('ends_timess'))));

		$this->output->set_content_type('application/json')->set_output(json_encode($data));		
	}

	public function get_amanot_all_person_info()
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->buy->get_all_amanot_person_info()));
	}

	public function get_amanot_person_infos_ssss()
	{
		$data['amanots_data'] = $this->buy->get_amanot_person_info_by_id($this->input->post('amanot_idds')); 

		$data['ttl_amanot_take_amount'] = $this->buy->get_amanot_taking_amount_total($this->input->post('amanot_idds')); 
		$data['ttl_cut_amanot_taka'] = $this->buy->get_ttl_cutting_amounts($this->input->post('amanot_idds')); 

		$this->output->set_content_type('application/json')->set_output(json_encode($data)); 
	}

	public function delete_taking_data_by_id()
	{
		$this->buy->delete_taking_data_by_id($this->input->post('id'));
	}

	public function delete_giving_infos_by_id()
	{
		$this->buy->delete_giving_infos_by_id($this->input->post('id'));
	}

	public function new_payment_type(){

		$this->form_validation->set_rules('payment_type_name', 'Payment Type Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			
			$result=$this->payment_types->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Payment Type Name.";
		}
	}
	public function update($id){
		$this->permission_check('payment_types_edit');
		$data=$this->data;
		$result=$this->payment_types->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('payment_types');
		$this->load->view('payment_types', $data);
	}
	public function update_payment_type(){
		$this->form_validation->set_rules('payment_type_name', 'Payment Type Name', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->payment_types->update_payment_type();
			echo $result;
		} else {
			echo "Please Enter Payment Type Name.";
		}
	}
	public function index(){
		$this->permission_check('payment_types_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('payment_types_list');
		$this->load->view('payment_types_list', $data);
	}

	public function ajax_list()
	{
		$list = $this->payment_types->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $payment_type) {
			$no++;
			$row = array();
			$row[] = $payment_type->payment_type;
			
			 		if($payment_type->status==1){ 
			 			$str= "<span onclick='update_status(".$payment_type->id.",0)' id='span_".$payment_type->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$payment_type->id.",1)' id='span_".$payment_type->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
			         $str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('payment_types_edit'))
											$str2.='<li>
												<a title="Editd Record ?" href="'.base_url('payment_types/update/'.$payment_type->id).'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('payment_types_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_payment_type('.$payment_type->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';			
			$row[] = $str2;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->payment_types->count_all(),
						"recordsFiltered" => $this->payment_types->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('payment_types_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$result=$this->payment_types->update_status($id,$status);
		return $result;
	}
	public function delete_payment_type(){
		$this->permission_check_with_msg('payment_types_delete');
		$id=$this->input->post('q_id');
		$result=$this->payment_types->delete_payment_type($id);
		return $result;
	}

	public function staff_cost_added(){
		$data=$this->data;
		$data['page_title']='স্টাফ খরচ';
		$data['all_staff_infos']=$this->buy->get_staff_infos_data();
		$this->load->view('staff_cost_view_page', $data);
	}

	public function get_cost_of_staffs()
	{
		$start_date = date('Y-m-01');
		$end_date = date('Y-m-d', time());
		$data['cost_of_staffs']=$this->buy->get_cost_of_staffs($start_date, $end_date);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function add_staff_cost_added()
	{
		$last_no_id = $this->buy->add_staff_cost_added(
			array(
				"staff_unq_idd" 		=> $this->input->post('staff_id'),
				"staff_cos_amounts" 	=> $this->input->post('cost_amount'),
				"staff_cost_dates" 		=> date('Y-m-d', strtotime($this->input->post('cost_date'))),
				"staff_notess" 			=> $this->input->post('cost_note'),
				"insert_dates" 			=> date('Y-m-d', time()),
				"insert_timming" 		=> time(),
			) 
		);


		
		$this->buy->insert_expense_data(
			array(
				"expense_date"							=> date('Y-m-d', strtotime($this->input->post('cost_date'))),
				"reference_no"							=> $last_no_id,
				"expense_for"							=> $this->input->post('staff_name').' স্টাফ খরচ ',
				"expense_amt"							=> $this->input->post('cost_amount'),
				"purcssss_idiiddi"						=> $last_no_id,
				"o_p"									=> $last_no_id,
				"created_date"							=> date('Y-m-d'), 
				"created_time"							=> time(),
				"status"								=> 1,
			)
		);

		$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'message' => 'স্টাফ খরচ যোগ করা হয়েছে')));
	}

	public function delete_staff_cost_added()
	{
		$this->buy->delete_staff_cost_added($this->input->post('id'));
		$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => 'success', 'message' => 'স্টাফ খরচ মুছুন করা হয়েছে')));
	}

	public function staff_details_history() 
	{
		$data=$this->data;
		$data['page_title']='স্টাফ খরচ';
		$data['all_staff_infos']=$this->buy->get_staff_infos_data();
		$this->load->view('staff_cost_history', $data);
	}

	public function get_cost_of_staff_hist()
	{
		$staff_id = $this->input->post('staff_id');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$data['cost_of_staffs']=$this->buy->get_cost_of_staff_by_iddd($staff_id, $start_date, $end_date);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}


	






}
