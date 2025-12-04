<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('expense_model','expense');
		$this->load->model('expense_category_model','category');
		$this->load->model('buy_model','buy');
	}

	public function index()
	{
		$this->permission_check('expense_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expenses_list');
		$this->load->view('expense-list',$data);
	}
 
	public function add()
	{
		$this->permission_check('expense_add');
		$data=$this->data; 
		$data['page_title']=$this->lang->line('expenses');
		$this->load->view('expense',$data);
	} 

	public function other_income_adds()
	{
		$data=$this->data;  
		$data['page_title']='ইনকাম';
		$this->load->view('other_income_adds',$data);		
	}

	public function due_income_payments()
	{ 
		$data=$this->data; 
		$data['cus_s']=$this->buy->get_all_customers(); 
		$data['page_title']='ইনকাম';
		$this->load->view('income_payment_take',$data);		
	}

	public function income_from_supps()
	{
		$data=$this->data; 
		$data['sups']=$this->buy->get_all_suppliers(); 
		$data['page_title']= 'মহাজন থেকে টাকা হাওলাত';
		$this->load->view('income_payment_take_haolat',$data);  		
	}

	public function loan_to_customer()
	{
		$data=$this->data; 
		$data['cus_s']=$this->buy->get_all_customers(); 
		$data['page_title']= 'কাস্টমারকে হাওলাত দেওয়া';
		$this->load->view('expense_loan_taka_gives_customer',$data);  	
	}

	public function paid_payment()
	{
		$data=$this->data; 
		$data['sups']=$this->buy->get_all_suppliers(); 
		$data['page_title']=$this->lang->line('expenses');
		$this->load->view('expense_payment_paid',$data);  
	}

	public function transport_amount_paid()
	{ 
		$data=$this->data; 
		$data['trans']=$this->buy->get_all_transports(); 
		$data['page_title']='ট্রান্সপোর্ট এর খরচ';
		$this->load->view('transport_payment_paid',$data); 
	}

	public function get_supplier_info_by_id()
	{ 
		$supplier_id = $this->input->post('s_id');
		$data['suppl'] = $this->buy->get_supplier_by_id($supplier_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	// expense json data   
	public function get_transport_info_by_id()
	{
		$transprt_id = $this->input->post('transp_id');
		$data['trans'] = $this->buy->get_transports_infos_by_id($transprt_id);
		$data['total_adds_trans'] = $this->buy->get_purchase_transport_info_trans_uniq_iddddd($transprt_id);
		$data['total_cost_trans'] = $this->buy->get_transports_cost_by_id($transprt_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_sales_by_customer_id()
	{
		$customer_id = $this->input->post('c_id');
		$data['customer'] = $this->buy->get_customer_by_id($customer_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
           
	public function get_sales_info_by_sales_id()
	{
		$sales_id = $this->input->post('sales_id');
		$data['sales_info'] = $this->buy->get_sales_info_by_sales_id($sales_id);
		$data['sales_pre_payment_info'] = $this->buy->get_sales_due_info_by_sales_id($sales_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data)); 
	}

	public function get_product_item_by_supplier_id()
	{
		$supplier_id = $this->input->post('s_id');
		$data['suppl'] = $this->buy->get_supplier_by_id($supplier_id);
		$data['pur_item'] = $this->buy->get_supplier_purchase_item_by_id($supplier_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_purchase_item_full_infos_unpaid_amount()
	{
		$purchase_item_id = $this->input->post('p_i_id');
		$data['purchase_item_info'] = $this->buy->get_purchase_item_by_id($purchase_item_id);
		$data['purchase_payments'] = $this->buy->get_purchase_payments_by_purchase_item_id($purchase_item_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function search_customer_pay_info_date_date()
	{
		$data['cust_payments'] = $this->buy->get_customer_payments_date_date(date('Y-m-d', strtotime($this->input->post('start_dates'))), date('Y-m-d', strtotime($this->input->post('ending_dates'))), $this->input->post('cust_id'));
		$data['cust_dues'] = $this->buy->get_customer_due_payments_date_to_date(date('Y-m-d', strtotime($this->input->post('start_dates'))), date('Y-m-d', strtotime($this->input->post('ending_dates'))), $this->input->post('cust_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	// মহাজন থেকে ইনকাম
	public function insert_data_loan_from_supp()
	{
		if (empty($this->input->post('customer_id')) || empty($this->input->post('loan_amount')) || empty($this->input->post('loan_medium')) || empty($this->input->post('repayment_date')) || empty($this->input->post('auto_time'))) {
			echo json_encode([
				"status" => "error",
				"message" => "সব ফিল্ড পূরণ করা বাধ্যতামূলক!"
			]);
			exit;
		}else {
			$supp_info = $this->buy->get_supplier_by_id($this->input->post('customer_id'));

			$this->buy->update_supplier_info_by_id(
				array(
					"purchase_due"			=> (float)$supp_info->purchase_due + (float)$this->input->post('loan_amount'),
				), $this->input->post('customer_id')
			); 

			$this->buy->insert_income_payment(
				array(
					"income_date"					=> date('Y-m-d', strtotime($this->input->post('repayment_date'))),
					"income_for"					=> "$supp_info->supplier_name এর থেকে লোণ নেওয়া হয়েছে", 
					"income_amount"					=> $this->input->post('loan_amount'),
					"c_o_p"							=> 2,
					"custsss_iddss_qqsq"			=> '',
					"suppsss_idd_ssqqqsss_didi"		=> $supp_info->id,
					"create_date"					=> date('Y-m-d'),
					"created_time"					=> time(),
				)
			);

			$this->buy->insert_supplier_due_payment_amt(
				array(
					"ttl_pruchase_dates_times"		=> date('Y-m-d', strtotime($this->input->post('repayment_date'))),
					"supp_com_trans"				=> $this->input->post('customer_id'),
					"amount_of_this_rowsss"			=> $this->input->post('loan_amount'),
					"cr_times_entry"				=> time(),
					"cr_dates_entryss"				=> date('Y-m-d'),
				)
			); 
			echo json_encode([
				"status" => "success",
				"message" => "সংরক্ষণ হয়েছে"
			]);
			exit;
		}
	}
	// মহাজন থেকে ইনকাম

	// কাস্টমারের খরচ দেওয়া
	public function insert_add_loan_to_customer()
	{
		if (empty($this->input->post('customer_id')) || empty($this->input->post('loan_amount')) || empty($this->input->post('loan_perpose')) || empty($this->input->post('loan_date')) || empty($this->input->post('auto_time'))) {
			echo json_encode([
				"status" => "error",
				"message" => "সব ফিল্ড পূরণ করা বাধ্যতামূলক!"
			]);
			exit;
		}else {

			$cust_info = $this->buy->get_customer_by_id($this->input->post('customer_id'));

			$this->buy->update_customer_total_due(
				array(
					"sales_due"			=> (float)$cust_info->sales_due + (float)$this->input->post('loan_amount'),
				), $this->input->post('customer_id')
			); 

			$this->buy->insert_expense_data(
				array(
					"expense_date"			=> date('Y-m-d', strtotime($this->input->post('loan_date'))),
					"category_id"			=> 1,
					"expense_for"			=> "$cust_info->customer_name কে লোন দেওয়া হয়েছে (খরচ)",
					"expense_amt"			=> $this->input->post('loan_amount'),
					"supp_idd_ssqq"			=> '',
					"cust_idds_qqs"			=> $this->input->post('customer_id'),
					"o_p"					=> 2,
					"created_date"			=> date('Y-m-d'),
					"created_time"			=> time(),
				)
			);

			$this->buy->insert_sales_total_amount_s(
				array(
					"due_sales_dates_times"			=> date('Y-m-d', strtotime($this->input->post('loan_date'))),
					"customer_unq_iddds"			=> $this->input->post('customer_id'),
					"sales_paidable_amount_sss"		=> $this->input->post('loan_amount'),
					"sales_paid_amount_ssssssssss"	=> $this->input->post('loan_amount'),
					"types_payable"	                => 1,
					"pays_descriptions"	            => $this->input->post('loan_perpose'),
					"cust_prev_duesss"	            => $cust_info->sales_due,
					"ttl_due_now_ss_sales_ssss"		=> (float)$cust_info->sales_due + (float)$this->input->post('loan_amount'),
					"create_entry_datess"			=> date('Y-m-d'),
					"create_entry_timessstmp"		=> time(),
				)
			);

			echo json_encode([
				"status" => "success",
				"message" => "সংরক্ষণ হয়েছে"
			]);
			exit;
		}
		
	}
	// কাস্টমারের খরচ দেওয়া

	public function insert_transport_dues_func()
	{
		$trans_name = $this->input->post('trans_name');
        $trns_infos = $this->buy->get_transports_infos_by_id($this->input->post('trans_id'));
		$lst_id = $this->buy->insert_transport_duess(
			array(
				"db_transport_pr_unq_id"		=> $this->input->post('trans_id'),
				"trns_prev_amnt_entrr"	        => $trns_infos->trans_now_due_sssss_amnt_ssamnt,
				"db_transport_payment_amount"	=> $this->input->post('give_paymnt'),
				"db_transport_given_datess"		=> date('Y-m-d', strtotime($this->input->post('give_dates'))),
				"db_transport_timmings"			=> $this->input->post('give_times'),
				"db_transport_methods"			=> $this->input->post('give_types'),
				"trns_now_amnt_ssssss_shows"	=> (float)$trns_infos->trans_now_due_sssss_amnt_ssamnt - (float)$this->input->post('give_paymnt'),
				"db_transport_cr_date"			=> date('Y-m-d'),
				"db_transport_cr_timesss"		=> time(),
			)
		);

		$this->buy->update_transport_info_by_trns_id(
			array(
				"trans_now_due_sssss_amnt_ssamnt"		=> (float)$trns_infos->trans_now_due_sssss_amnt_ssamnt - (float)$this->input->post('give_paymnt'),
            ), $this->input->post('trans_id')
		);

		$this->buy->insert_expense_data(
			array(
				"expense_date"			                => date('Y-m-d', strtotime($this->input->post('give_dates'))),
				"category_id"			                => 9,
				"expense_for"			                => "$trans_name এর বকেয়া পরিশোধ (খরচ)",
				"expense_amt"			                => $this->input->post('give_paymnt'),
				"trns_port_auto_iddd"	                => $this->input->post('trans_id'),
				"tbl_transport_payments_id_assgning"	=> $lst_id,
				"o_p"					                => 2,
				"created_date"			                => date('Y-m-d'),
				"created_time"			                => time(),
			)
		);
	}

	public function adding_cash_amount_of_customer_id()
	{
		$customer_info = $this->buy->get_customer_by_id($this->input->post('cust_id'));

		$inserted_cust_pay_id = $this->buy->insert_customer_payments_func(
									array(
										"customer_id"				=> $this->input->post('cust_id'),
										"payment_date"				=> date('Y-m-d', strtotime($this->input->post('select_date'))),
										"payment_timing"			=> $this->input->post('time_select'),
										"payment_type"				=> $this->input->post('types_of'),
										"payment"					=> $this->input->post('cash_amount'),
										"cust_prev_amntss"			=> $customer_info->sales_due,
										"cust_now_due_amntsss"		=> (float)$customer_info->sales_due - (float)$this->input->post('cash_amount'),
										"created_time"				=> time(),
										"created_date"				=> date('Y-m-d'),
									)
								);

		$this->buy->update_customer_total_due(
			array(
				"sales_due"			=> (float)$customer_info->sales_due - (float)$this->input->post('cash_amount'),
			), $this->input->post('cust_id')
		);

		$this->buy->insert_income_payment(
			array(
				"income_date"			=> date('Y-m-d', strtotime($this->input->post('select_date'))),
				"income_for"			=> "$customer_info->customer_name এর টাকা জমা হয়েছে", 
				"income_amount"			=> $this->input->post('cash_amount'),
				"c_o_p"					=> 1,
				"create_date"			=> date('Y-m-d'),
				"created_time"			=> time(),
			)
		);
		echo $inserted_cust_pay_id;
	}

	public function cutting_cash_amount_of_supplier_id()
	{
		$supp_info = $this->buy->get_supplier_by_id($this->input->post('supp_id'));
		
		$inserted_supp_pay_id = $this->buy->insert_tbl_supplyer_payments_datas(
			array(
				"payment_date"				=> date('Y-m-d', strtotime($this->input->post('select_date'))),
				"supplier_id"				=> $this->input->post('supp_id'),
				"payment_type"				=> $this->input->post('types_of'),
				"payment_timess"			=> $this->input->post('time_select'),
				"payment"					=> $this->input->post('cash_amount'),
				"supp_prevs_amnts"			=> $supp_info->purchase_due,
				"supp_now_due_amnt_ssss"	=> (float)$supp_info->purchase_due - (float)$this->input->post('cash_amount'),
				"created_time"				=> time(),
				"created_date"				=> date('Y-m-d'),
			)
		);

		$this->buy->update_supplier_info_by_id(
			array(
				"purchase_due"			=> (float)$supp_info->purchase_due - (float)$this->input->post('cash_amount'),
			), $this->input->post('supp_id')
		); 
		
		$this->buy->insert_expense_data(
			array(
				"expense_date"			=> date('Y-m-d', strtotime($this->input->post('select_date'))),
				"expense_for"			=> "$supp_info->supplier_name এর বকেয়া টাকা পরিশোধ (খরচ)",
				"expense_amt"			=> $this->input->post('cash_amount'),
				"o_p"					=> 1,
				"created_date"			=> date('Y-m-d'),
				"created_time"			=> time(),
			)
		);
		echo $inserted_supp_pay_id;
	}

	public function new_incomes_entry()
	{ 
		$this->buy->insert_income_payment(
			array(
				"income_date"	=> date('Y-m-d', strtotime($this->input->post('income_date'))),
				"income_for"	=> $this->input->post('incomes_for'),
				"income_amount"	=> $this->input->post('income_amnt'),
				"c_o_p"			=> 2,
				"create_date"	=> date('Y-m-d'),
				"created_time"	=> time(),
			)
		);
	}

	/*
	public function paid_sales_pre_due_amount()
	{

		$this->input->post('sales_idds');

		if (empty($this->input->post('ttl_payment_amnt'))) {
			echo 0;
		} else {

			if ($this->input->post('clear_check') == 1) {
				$this->buy->update_sales_tbl(
					array(
						"sell_payment_due"	=> 0,
					), $this->input->post('sales_idds')
				);
			} else {
				$sales_infosss = $this->buy->get_sales_info_by_sales_id($this->input->post('sales_idds'));
				$this->buy->update_sales_tbl(
					array(
						"sell_payment_due"	=> $sales_infosss->sell_payment_due - $this->input->post('ttl_payment_amnt'),
					), $this->input->post('sales_idds')
				);
			}

			$customer_info = $this->buy->get_customer_by_id($this->input->post('customer_id'));

			$insert_sales_payment_id = $this->buy->insert_sales_payments_func(
				array(
					"sales_id"					=> $this->input->post('sales_idds'),
					"refs_lots_nosss"			=> $this->input->post('ref_lot_no'),
					"payments_bosta_qnttt_ss"	=> $this->input->post('bosta_qnty'),
					"payments_kgs_qntttt_ss"	=> $this->input->post('qnty_kgs'),
					"payment_date"				=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"payment"					=> $this->input->post('ttl_payment_amnt'),
					"created_time"				=> time(),
					"created_date"				=> date('Y-m-d'),
					"status"					=> 1,
				)
			);

			$insert_customer_payment_id = $this->buy->insert_customer_payments_func(
				array(
					"salespayment_id"			=> $insert_sales_payment_id,
					"customer_id"				=> $this->input->post('customer_id'),
					"payment_date"				=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"payment"					=> $this->input->post('ttl_payment_amnt'),
					"created_time"				=> time(),
					"created_date"				=> date('Y-m-d'),
					"status"					=> 1,
				)
			);

			$this->buy->insert_income_payment(
				array(
					"income_date"				=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"income_for"				=> "$customer_info->customer_name এর টাকা জমা হয়েছে", 
					"income_amount"				=> $this->input->post('ttl_payment_amnt'),
					"c_o_p"						=> 1,
					"create_date"				=> date('Y-m-d'),
					"created_time"				=> time(),
				)
			);
			echo 1;
		}

	}

	public function paid_previous_due_amount_s()
	{
		if (empty($this->input->post('ttl_payment_amnt'))) {
			echo 0;
		} else {

			if ($this->input->post('clear_check') == 1) {
				$this->buy->update_purchase_items_due(
					array(
						"total_due_payments"	=> 0,
					), $this->input->post('get_pur_item_id')
				);
			} else {
				$purchase_item_infosss = $this->buy->get_purchase_item_info_by_id($this->input->post('get_pur_item_id'));
				$this->buy->update_purchase_items_due(
					array(
						"total_due_payments"	=> $purchase_item_infosss->total_due_payments - $this->input->post('ttl_payment_amnt'),
					), $this->input->post('get_pur_item_id')
				);
			}

			$insert_purchase_payment_id = $this->buy->insert_purchase_payments_func(
				array(
					"purchase_id"			=> $this->input->post('get_pur_id'),
					"items_uniqs_idd"		=> $this->input->post('get_item_id'),
					"purchase_item_s_id"	=> $this->input->post('get_pur_item_id'),
					"supplier_auto_pr_id"	=> $this->input->post('supp_id'),
					"payment_date"			=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"refs_lots_no_s"		=> $this->input->post('ref_lot_no'),
					"payments_bosta_qnt_s"	=> $this->input->post('bosta_qnty'),
					"payments_kgs_qnt"		=> $this->input->post('qnty_kgs'),
					"payment"				=> $this->input->post('ttl_payment_amnt'),
					"created_time"			=> time(),
					"created_date"			=> date('Y-m-d'),
					"status"				=> 1,
				)
			); 

			$insert_supplier_payment_id = $this->buy->insert_supplier_paymentss(
				array(
					"purchasepayment_id"		=> $insert_purchase_payment_id,
					"supplier_id"				=> $this->input->post('supp_id'),
					"pur_chase_a_pri_id"		=> $this->input->post('get_pur_id'),
					"pur_chase_item_s_pri_id"	=> $this->input->post('get_pur_item_id'),
					"payment_date"				=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"payment"					=> $this->input->post('ttl_payment_amnt'),
					"created_time"				=> time(),
					"created_date"				=> date('Y-m-d'),
					"status"					=> 1,
				)
			);   

			$this->buy->insert_expense_data(
				array(
					"expense_date"	=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"reference_no"	=> $this->input->post('ref_lot_no'),
					"expense_for"	=> 'আমদানীকারকের টাকা দেওয়া হয়েছে।',
					"expense_amt"	=> $this->input->post('ttl_payment_amnt'),
					"o_p"			=> 1,
					"created_date"	=> date('Y-m-d'),
					"created_time"	=> time(),
					"status"		=> 1,
				)
			);
			echo 1;
		}
	}
		*/ 
	
	public function newexpenssse(){
		$this->expense->verify_and_save_ex(
			array(
				'expense_for'	=> $this->input->post('expense_for'),
				'expense_amt'	=> $this->input->post('expense_amt'),
				'expense_date'	=> date('Y-m-d', strtotime($this->input->post('expense_date'))),
				'o_p'	=> 2
			)
		);
		// echo $result;
	}
	
	public function newexpense(){
		$this->form_validation->set_rules('expense_date', 'Expense Date', 'trim|required');
		$this->form_validation->set_rules('expense_amt', 'Expense Amount', 'trim|required');
		$this->form_validation->set_rules('expense_for', 'Expense for', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->expense->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->permission_check('expense_edit');
		$data=$this->data;
		$result=$this->expense->get_details($id,$data);
		$data=array_merge($data,$result);
		$this->load->view('expense', $data);
	}
	public function update_expense(){
		$this->form_validation->set_rules('expense_date', 'Expense Date', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('expense_amt', 'Expense Amount', 'trim|required');
		$this->form_validation->set_rules('expense_for', 'Expense for', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->expense->update_expense();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function ajax_list()
	{
		$list = $this->expense->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $expense) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$expense->id.' class="checkbox column_checkbox" >';
			$row[] = show_date($expense->expense_date);
			$row[] = $expense->category_name;
			$row[] = $expense->reference_no;
			$row[] = $expense->expense_for;
			$row[] = app_number_format($expense->expense_amt);
			$row[] = $expense->note;			
			$row[] = ucfirst($expense->created_by);			
				     $str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('expense_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="expense/update/'.$expense->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('expense_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_expense('.$expense->id.')">
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
						"recordsTotal" => $this->expense->count_all(),
						"recordsFiltered" => $this->expense->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('expense_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		return $this->expense->update_status($id,$status);
		
	}
	public function delete_expense(){
		$this->permission_check_with_msg('expense_delete');
		$id=$this->input->post('q_id');
		return $this->expense->delete_expenses_from_table($id);
	}
	public function multi_delete_expense(){
		$this->permission_check_with_msg('expense_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->expense->delete_expenses_from_table($ids);
	}
	
	/* ######################################## EXPENSE END ############################# */





	/* ######################################## EXPENSE CATEGORY START ############################# */
	public function category()
	{	
		$this->permission_check('expense_category_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expense_category_list');
		$this->load->view('expense-category-list',$data);
	}
	public function category_add()
	{
		$this->permission_check('expense_category_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expense_category');
		$this->load->view('expense-category',$data);
	}
	public function newcategory(){
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		

		if ($this->form_validation->run() == TRUE) {
			$this->load->model('expense_category_model');
			$result=$this->expense_category_model->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Category name.";
		}
	}
	public function ajax_list_expense()
	{
		
		$list = $this->category->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $category) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$category->id.' class="checkbox column_checkbox" >';
			$row[] = $category->category_name;
			$row[] = $category->description;

			 		if($category->status==1){ 
			 			$str= "<span onclick='update_status(".$category->id.",0)' id='span_".$category->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$category->id.",1)' id='span_".$category->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					 $str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('expense_category_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="expense_update/'.$category->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('expense_category_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_category('.$category->id.')">
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
						"recordsTotal" => $this->category->count_all(),
						"recordsFiltered" => $this->category->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function expense_update($id){
		$this->permission_check_with_msg('expense_category_edit');
		$data=$this->data;		
		$result=$this->category->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('expense_category');
		$this->load->view('expense-category', $data);
	}
	public function update_category(){
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->category->update_category();
			echo $result;
		} else {
			echo "Please Enter Category name.";
		}
	}

	public function expense_update_status(){
		$this->permission_check_with_msg('expense_category_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		return $this->category->update_status($id,$status);
		
	}
	public function delete_category(){
		$this->permission_check_with_msg('expense_category_delete');
		$id=$this->input->post('q_id');
		return $this->category->delete_categories_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('expense_category_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->category->delete_categories_from_table($ids);
	}
	/* ######################################## EXPENSE CATEGORY END############################# */

}
