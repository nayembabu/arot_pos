<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends MY_Controller {
	public function __construct(){
		parent::__construct(); 
		$this->load_global();
		$this->load->model('suppliers_model','suppliers');
		$this->load->model('Reports_model','report');
		$this->load->model('buy_model','buy');
	}
	 
	public function index()
	{
		$this->permission_check('suppliers_view');
		$data=$this->data;  
		$data['page_title']=$this->lang->line('suppliers_list');
		$this->load->view('suppliers-list',$data);
	}
	public function add()
	{
		$this->permission_check('suppliers_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('suppliers');
		$this->load->view('suppliers',$data);
	} 

	public function view_salling_infos_by_trans_puurchase_id_p() 
	{
        $daata['trans_infos'] = $this->buy->get_trans_purchase_info_by_trans_idd($this->input->post('trans_id'));
        $daata['sales_item_infos'] = $this->buy->get_sales_item_info_by_trans_idd($this->input->post('trans_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($daata));
	}

	public function get_purchase_item_by_trans_puurchase_id()
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->buy->get_all_purchase_item_info_by_trans_id($this->input->post('trans_id'))));
	}

	public function view_sells_info_by_puurchase_items_id_p() 
	{
		$daata['sell_infos'] = $this->buy->view_sells_info_by_puurchase_items_id($this->input->post('pur_item_id'));
		$daata['purchase_infos'] = $this->buy->get_purchase_item_by_id($this->input->post('pur_item_id'));
		$this->output->set_content_type('application/json')->set_output(json_encode($daata));
	}

    public function history_check()
    {
		$this->permission_check('suppliers_add'); 
		$data=$this->data;
		$data['page_title']='মহাজনের হিসাব ';
		$data['all_suppliers']=$this->buy->get_all_suppliers(); 
		$this->load->view('suppliers_history_check', $data);
    }

	public function get_purchase_info_by_supp_datetodate()
	{
        $daata['purchase_infos'] = $this->buy->get_purchase_info_by_supp_date_to_date(date('Y-m-d',strtotime($this->input->post('startDate'))), date('Y-m-d',strtotime($this->input->post('endDate'))), $this->input->post('supplierId'));
        $daata['supp_payment_info'] = $this->buy->get_supplier_payments_date_to_date($this->input->post('supplierId'), date('Y-m-d',strtotime($this->input->post('startDate'))), date('Y-m-d',strtotime($this->input->post('endDate'))));
        $daata['supp_info'] = $this->buy->get_supplier_by_id($this->input->post('supplierId'));
        $daata['supp_coms_entry'] = $this->buy->get_cmns_info_by_suppid_date_to_date(date('Y-m-d',strtotime($this->input->post('startDate'))), date('Y-m-d',strtotime($this->input->post('endDate'))), $this->input->post('supplierId'));

		$this->output->set_content_type('application/json')->set_output(json_encode($daata));
	}

	public function newsuppliers(){
		//print_r($_REQUEST);exit();
		$this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->suppliers->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->permission_check('suppliers_edit');
		$data=$this->data;
		$result=$this->suppliers->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('suppliers');
		$this->load->view('suppliers', $data);
	}
	public function update_suppliers(){
		$this->form_validation->set_rules('supplier_name', 'Customer Name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->suppliers->update_suppliers();
			echo $result;
		} else {
			echo "Please Enter suppliers name.";
		}
	}

	public function ajax_list()
	{
		$list = $this->suppliers->get_datatables();
		//print_r($list);exit();
		$data = array();
		$no = $_POST['start'];
		$sl=1;
		foreach ($list as $suppliers) {
			$no++;
			$row = array();
			$row[] = $sl;
			$row[] = $suppliers->supplier_code;
			$row[] = $suppliers->supplier_name.'('.$suppliers->address.')';
			$row[] = $suppliers->mobile;
			$row[] = $suppliers->purchase_due;

					$str2 = '<div class="btn-group" title="View Account"> 

							</div>';

			$row[] = $str2;
			$data[] = $row;
			$sl++;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->suppliers->count_all(),
						"recordsFiltered" => $this->suppliers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('suppliers_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$result=$this->suppliers->update_status($id,$status);
		return $result;
	}

	public function delete_suppliers(){
		$this->permission_check_with_msg('suppliers_delete');
		$id=$this->input->post('q_id');
		return $this->suppliers->delete_suppliers_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('suppliers_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->suppliers->delete_suppliers_from_table($ids);
	}

	public function show_pay_now_modal(){
	    $this->permission_check_with_msg('purchase_payment_add');
	    $supplier_id=$this->input->post('supplier_id');
	    echo $this->suppliers->show_pay_now_modal($supplier_id);
	}
	public function save_payment(){
	    $this->permission_check_with_msg('purchase_payment_add');
	    echo $this->suppliers->save_payment();
	}
	public function show_pay_return_due_modal(){
	    $this->permission_check_with_msg('purchase_return_payment_add');
	    $supplier_id=$this->input->post('supplier_id');
	    echo $this->suppliers->show_pay_return_due_modal($supplier_id);
	}
	public function save_return_due_payment(){
	    $this->permission_check_with_msg('purchase_payment_add');
	    echo $this->suppliers->save_return_due_payment();
	}
	public function delete_opening_balance_entry(){
		$this->permission_check_with_msg('sales_payment_delete');
		$entry_id = $this->input->post('entry_id');
		echo $this->suppliers->delete_opening_balance_entry($entry_id);
	}

	public function getSuppliers($id=''){
		echo $this->suppliers->getSuppliersJson($id);
	}

	public function all_report_history()
	{
		$data=$this->data;
		$data['page_title']='মহাজনের রিপোর্ট ';
		$data['all_suppliers']=$this->buy->get_all_suppliers();
		$this->load->view('supplier_report_summary', $data);
	}

	public function all_report_details()
	{
		$data=$this->data;
		$data['page_title']='মহাজনের রিপোর্ট ';
		$data['all_suppliers']=$this->buy->get_all_suppliers();
		$this->load->view('supplier_report_details', $data);
	}

	public function get_data_for_yearly_report()
	{
		// report
		$supplier_id = $this->input->post('supp_id');
		$select_year = $this->input->post('year');
		$data['supplier']=$this->buy->get_supplier_by_id($supplier_id);
		$data['supplier_purchase_summary']=$this->report->get_purchase_for_this_years($supplier_id, $select_year);
		$data['supplier_purchase_summary_month_wise']=$this->report->get_purchase_for_this_year_month_wise($supplier_id, $select_year);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_data_date_to_date_report()
	{
		$supp_id = $this->input->post('supp_id');
		$start_date = date('Y-m-d', strtotime($this->input->post('type_date_start')));
		$end_datess = date('Y-m-d', strtotime($this->input->post('type_date_end')));
		$data['supplier_info']=$this->buy->get_supplier_by_id($supp_id);
		$data['supplier_report']=$this->buy->get_purchase_info_by_supp_date_to_date($start_date, $end_datess, $supp_id);
		foreach ($data['supplier_report'] as $key => $single_data) {
			$items = $this->buy->get_all_purchase_item_info_by_trans_id($single_data->db_purchase_transports_info_a_idd);
			$data['supplier_report'][$key]->items = $items;
			// $sales_info = $this->buy->get_sales_info_by_trans_idda($single_data->db_purchase_transports_info_a_idd);
			// $data['supplier_report'][$key]->sales_info = $sales_info;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_total_sales_count_by_piid()
	{
		$piid = $this->input->post('pi_id');
		$sales_info = $this->buy->get_total_saless_count_by_piid($piid);
		$this->output->set_content_type('application/json')->set_output(json_encode($sales_info));
	}






}

