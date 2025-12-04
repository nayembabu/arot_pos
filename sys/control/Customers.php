<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller { 
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('customers_model','customers');
		$this->load->model('buy_model','buy');
	} 

	public function get_cash_paid_by_dates() {
		$datas['customer_payments'] = $this->buy
										->get_customer_paid_amnt_by_cust_id_date_date(
											date('Y-m-d', strtotime($this->input->post('start_date'))), 
											date('Y-m-d', strtotime($this->input->post('end_date'))), 
											$this->input->post('customer_id')
										);

		$this->output 
			->set_content_type('application/json')
			->set_output(
				json_encode(
						$datas
					)
				);
	}

	public function searching_customer_history_date_date()
	{ 
		$datas['haolat_info'] = $this->buy
										->get_haolat_info_by_cust_id_date_to_date(
											date('Y-m-d', strtotime($this->input->post('start_date'))), 
											date('Y-m-d', strtotime($this->input->post('end_date'))), 
											$this->input->post('customer_id')
										);   
		$datas['sales_info'] = $this->buy
										->get_sales_info_by_cust_id_date_date(
											date('Y-m-d', strtotime($this->input->post('start_date'))), 
											date('Y-m-d', strtotime($this->input->post('end_date'))), 
											$this->input->post('customer_id')
										);   
		$datas['customer_payments'] = $this->buy
										->get_customer_paid_amnt_by_cust_id_date_date(
											date('Y-m-d', strtotime($this->input->post('start_date'))), 
											date('Y-m-d', strtotime($this->input->post('end_date'))), 
											$this->input->post('customer_id')
										);  
		$datas['parchase_info'] = $this->buy
										->get_parchase_cust_by_cust_id_and_date_to_date(
											date('Y-m-d', strtotime($this->input->post('start_date'))), 
											date('Y-m-d', strtotime($this->input->post('end_date'))), 
											$this->input->post('customer_id')
										);  
        $datas['commission_entry_info'] = $this->buy
										->get_date_to_date_commission_info_by_customer_id(
											date('Y-m-d', strtotime($this->input->post('start_date'))), 
											date('Y-m-d', strtotime($this->input->post('end_date'))), 
											$this->input->post('customer_id')
										);          
        $datas['customer_info'] = $this->buy->get_customer_by_id($this->input->post('customer_id')); 
		$this->output->set_content_type('application/json')->set_output(json_encode($datas)); 
	}     

    public function get_sales_commission_item_info_by_coms_id()
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($this->buy->get_sales_commission_item_info_by_coms_idss($this->input->post('commission_id'))));
    }

    public function get_customer_by_cus_id()
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($this->buy->get_customer_by_cus_id($this->input->post('customer_id'))));
    }

    public function get_all_purchase_item_info_by_trans_id()
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($this->buy->get_all_purchase_item_info_by_trans_id($this->input->post('pur_trans_id'))));
    }

    public function update_customer_due()
    {
        $this->buy->update_customer_total_due(
            array(
                'opening_balance'   => $this->input->post('customer_prev_due'),
                'sales_due'         => $this->input->post('customer_prev_due')
            ), 
            $this->input->post('customer_id') 
        );
    }

    public function update_customer_basic_infos_with_numbers()
    {
        $this->buy->update_customer_total_due(
            array(
                'customer_name'   => $this->input->post('name'),
                'mobile'   => $this->input->post('phone'),
                'address'   => $this->input->post('address'),
                'whatsApp_number'   => $this->input->post('wanumber'),
                'imo_numbersss'   => $this->input->post('imo_nos'),
            ), 
            $this->input->post('customer_id') 
        );
    }

	public function cus_history_checks()
	{
		$this->permission_check('customers_add');
		$data=$this->data;
		$data['page_title']= 'কাস্টমার বিস্তারিত';
        $data['cutomers_info'] = $this->buy->get_all_customers();
		$this->load->view('customer_history_view',$data);		
	}

	public function index()
	{ 
		$this->permission_check('customers_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('customers_list');
		$this->load->view('customers-view',$data);
	} 

	public function add()
	{
		$this->permission_check('customers_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('customers');
		$this->load->view('customers',$data);
	}

	public function newcustomers(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->customers->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	
	public function update($id){
		$this->permission_check('customers_edit');
		$data=$this->data;
		$result=$this->customers->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('customers');
		$this->load->view('customers', $data);
	}
	public function update_customers(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {			
			$result=$this->customers->update_customers();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function show_total_customer_paid_amount($customer_id){
		return $this->db->select("coalesce(sum(paid_amount),0) as tot")->where("customer_id",$customer_id)->get("db_sales")->row()->tot;
	}
	public function ajax_list()
	{
		$list = $this->customers->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
        $sl = 1;
		foreach ($list as $customers) {
			$no++;
			$row = array();

			$row[] = $sl;
			$row[] = $customers->customer_name;
			$row[] = $customers->mobile;
			$row[] = $customers->address;
			$row[] = $customers->sales_due;

			'<a style="cursor:pointer" class="btn btn-danger btn-o" title="Delete Record ?" onclick="delete_customers('.$customers->id.')">
				<i class="fa fa-fw fa-trash text-white"></i>ডিলিট
			</a>';

			$str2 = '<div class="btn-group" title="View Account">
                        
                    </div>';

			$row[] = $str2;

			$data[] = $row;
            $sl++;
        }

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customers->count_all(),
						"recordsFiltered" => $this->customers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('customers_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$result=$this->customers->update_status($id,$status);
		return $result;
	}
	
	public function delete_customers(){
		$this->permission_check_with_msg('customers_delete');
		$id=$this->input->post('q_id');
		return $this->customers->delete_customers_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('customers_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->customers->delete_customers_from_table($ids);
	}
	public function show_pay_now_modal(){
		$this->permission_check_with_msg('sales_payment_add');
		$customer_id=$this->input->post('customer_id');
		echo $this->customers->show_pay_now_modal($customer_id);
	}
	public function save_payment(){
		$this->permission_check_with_msg('sales_payment_add');
		echo $this->customers->save_payment();
	}
	public function show_pay_return_due_modal(){
		$this->permission_check_with_msg('sales_return_payment_add');
		$customer_id=$this->input->post('customer_id');
		echo $this->customers->show_pay_return_due_modal($customer_id);
	}
	public function save_return_due_payment(){
		$this->permission_check_with_msg('sales_payment_add');
		echo $this->customers->save_return_due_payment();
	}
	public function delete_opening_balance_entry(){
		$this->permission_check_with_msg('sales_payment_delete');
		$entry_id = $this->input->post('entry_id');
		echo $this->customers->delete_opening_balance_entry($entry_id);
	}
	public function getCustomers($id=''){
		echo $this->customers->getCustomersJson($id);
	}

}
