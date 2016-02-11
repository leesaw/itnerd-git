<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

function __construct()
{
     parent::__construct();
     $this->load->model('tp_item_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
    
function manage()
{   
    $sql = "br_enable = 1";
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}
    
    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}
    
    $data['title'] = "NGG| Nerd";
    $this->load->view('TP/item/allitem_view',$data);
}
    
function additem()
{
	$this->load->helper(array('form'));
	
    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}
    
    $sql = "br_enable = 1";
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}
	
	$data['title'] = "NGG| Nerd - Add Product";
	$this->load->view('TP/item/additem_view',$data);
}

function refcode_is_exist($id)
{
    
    if($this->id_validate($id)>0)
    {
		$this->form_validation->set_message('refcode_is_exist', 'รหัสสินค้านี้มีอยู่ในระบบแล้ว');
        return FALSE;
    }
    else {
        return TRUE;
    }
}

function id_validate($id)
{
    $this->db->where('it_refcode', $this->input->post('refcode'));
    $query = $this->db->get('tp_item');
    return $query->num_rows();
}
	
function barcode_is_exist($id)
{
    
    if($this->barcode_validate($id)>0)
    {
		$this->form_validation->set_message('barcode_is_exist', 'รหัสสินค้านี้มีอยู่ในระบบแล้ว');
        return FALSE;
    }
    else {
        return TRUE;
    }
}

function barcode_validate()
{
    $this->db->where('it_code', $this->input->post('itcode'));
    $query = $this->db->get('tp_item');
    return $query->num_rows();
}

function is_money($str)
{
	return (bool) preg_match('/^[\-+]?[0-9]+[\.,][0-9]+$/', $str);
}

function save()
{
    $this->form_validation->set_rules('refcode', 'refcode', 'trim|xss_clean|required|callback_refcode_is_exist');
    $this->form_validation->set_rules('itcode', 'itcode', 'trim|xss_clean|required|callback_itcode_is_exist');
    $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
    $this->form_validation->set_rules('model', 'model', 'trim|xss_clean|required');
    $this->form_validation->set_rules('cost', 'cost', 'trim|xss_clean|required|call_is_money');
    $this->form_validation->set_rules('srp', 'srp', 'trim|xss_clean|required|call_is_money');
    $this->form_validation->set_rules('minstock', 'minstock', 'trim|xss_clean|required|numeric');
    $this->form_validation->set_rules('uom', 'uom', 'trim|xss_clean|required');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
    $this->form_validation->set_error_delimiters('<code>', '</code>');

    if($this->form_validation->run() == TRUE) {
        $refcode= ($this->input->post('refcode'));
        $itcode= ($this->input->post('itcode'));
        $name= ($this->input->post('name'));
        $catid= ($this->input->post('catid'));
        $brandid= ($this->input->post('brandid'));
        $uom= ($this->input->post('uom'));
        $model= ($this->input->post('model'));
        $minstock= ($this->input->post('minstock'));
        $cost= str_replace(",", "", ($this->input->post('cost')));
        $srp= str_replace(",", "", ($this->input->post('srp')));
        $short= ($this->input->post('short'));
        $long= ($this->input->post('long'));

        $product = array(
            'it_refcode' => $refcode,
            'it_code' => $itcode,
            'it_name' => $name,
            'it_category_id' => $catid,
            'it_brand_id' => $brandid,
            'it_uom' => $uom,
            'it_model' => $model,
            'it_srp' => $srp,
            'it_cost_baht' => $cost,
            'it_short_description' => $short,
            'it_long_description' => $long,
            'it_min_stock' => $minstock
        );

        $result = $this->tp_item_model->addItem($product);
        if ($result) 
            $this->session->set_flashdata('showresult', 'success');
        else
            $this->session->set_flashdata('showresult', 'fail');
        redirect(current_url());
    }

    $sql = "itc_enable = 1";
	$query = $this->tp_item_model->getItemCategory($sql);
	if($query){
		$data['cat_array'] =  $query;
	}else{
		$data['cat_array'] = array();
	}
    
    $sql = "br_enable = 1";
    $query = $this->tp_item_model->getBrand($sql);
	if($query){
		$data['brand_array'] =  $query;
	}else{
		$data['brand_array'] = array();
	}

    $data['title'] = "NGG| Nerd - Add Product";
	$this->load->view('TP/item/additem_view',$data);
}
    
public function ajaxViewAllItem()
{
    $this->load->library('Datatables');
    $this->datatables
    ->select("it_code, it_refcode, it_name, br_name, it_model, it_srp, itc_name, it_id")
    ->from('tp_item')
    ->join('tp_item_category', 'it_category_id = itc_id','left')		
    ->join('tp_brand', 'it_brand_id = br_id','left')
    ->where('it_enable',1)

    ->edit_column("it_id",'<div class="tooltip-demo">
<a href="'.site_url("item/viewproduct/$1").'" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
<a href="'.site_url("item/editproduct/$1").'" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
</div>',"it_id");
    echo $this->datatables->generate(); 
}
    
function viewproduct()
{
    $id = $this->uri->segment(3);
    $sql = "where it_id = '".$id."'";
    $query = $this->tp_item_model->getItem($sql);
    if($query){
        $data['product_array'] =  $query;
    }

    $data['title'] = "NGG| Nerd - View Product";
    $this->load->view('TP/item/viewitem_view',$data);
}    


function viewSelectedCat() {
    $catid = $this->uri->segment(3);

    $query = $this->category->getCat();
    if($query){
        $data['cat_array'] =  $query;
    }else{
        $data['cat_array'] = array();
    }

    if (isset($catid)) {
        $query = $this->product->getOneCat($catid);
        if($query){
            $data['product_array'] =  $query;
        }else{
            $data['product_array'] = array();
        }
    }else{
        $data['product_array'] = array();
    }
    $data['page'] = 1;
    $data['title'] = "Pradit and Friends - Product Management";
    $this->load->view('product_view',$data);
}
	

	
	
	
	function delete()
	{
		
		$id = $this->uri->segment(3);
		$result = $this->product->delProduct($id);
		
		redirect('manageproduct', 'refresh');
	}
	
	
	
	function viewproduct_iframe()
	{
		$id = $this->uri->segment(3);
		$query = $this->product->getOneProduct($id);
		if($query){
			$data['product_array'] =  $query;
		}
		
		$data['title'] = "Pradit and Friends - View Product";
		$this->load->view('viewproduct_view_iframe',$data);
	}
	
	function editproduct()
	{
		$this->load->helper(array('form'));

		
		$data['title'] = "Pradit and Friends - Edit Product";
		
		$id = $this->uri->segment(3);
		$query = $this->product->getOneProduct($id);
		if($query){
			$data['product_array'] =  $query;
		}
		
		$query = $this->category->getCat();
		if($query){
			$data['cat_array'] =  $query;
		}else{
			$data['cat_array'] = array();
		}
		
		$data['id'] = $id;
		$this->load->view('editproduct_view',$data);

	}
	
	function update()
	{
		
		//$this->form_validation->set_rules('standardid', 'standardid', 'trim|xss_clean|required|callback_id_is_exist');
		$this->form_validation->set_rules('supplierid', 'supplierid', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('barcode', 'barcode', 'trim|xss_clean|required|callback_barcode_is_exist');
		$this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('unit', 'unit', 'trim|xss_clean|required');
		$this->form_validation->set_rules('cost', 'cost', 'trim|xss_clean|required|call_is_money');
		$this->form_validation->set_rules('pricenovat', 'pricenovat', 'trim|xss_clean|required|call_is_money');
		$this->form_validation->set_rules('pricevat', 'pricevat', 'trim|xss_clean|required|call_is_money');
		$this->form_validation->set_rules('lowestprice', 'lowestprice', 'trim|xss_clean|required|call_is_money');
		//$this->form_validation->set_rules('pricediscount', 'pricediscount', 'trim|xss_clean|required|call_is_money');
		$this->form_validation->set_rules('detail', 'detail', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		$id= ($this->input->post('id'));
		
		if($this->form_validation->run() == TRUE) {
			$supplierid= ($this->input->post('supplierid'));
			$name= ($this->input->post('name'));
			$categoryid= ($this->input->post('categoryid'));
			$unit= ($this->input->post('unit'));
			$cost= str_replace(",", "", ($this->input->post('cost')));
			$pricenovat= str_replace(",", "", ($this->input->post('pricenovat')));
			$pricevat= str_replace(",", "", ($this->input->post('pricevat')));
			//$pricediscount= str_replace(",", "", ($this->input->post('pricediscount')));
			$detail= ($this->input->post('detail'));
			// add new column 05072014
			$lowestprice = str_replace(",", "", ($this->input->post('lowestprice')));
			$shelf = ($this->input->post('shelf'));
			
			//$barcodeid= ($this->input->post('barcode'));

			$product = array(
				'id' => $id,
				'supplierID' => $supplierid,
				//'barcode' => $barcodeid,
				'name' => $name,
				'categoryID' => $categoryid,
				'unit' => $unit,
				'costPrice' => $cost,
				'priceNoVAT' => $pricenovat,
				'priceVAT' => $pricevat,
				//'priceDiscount' => $pricediscount,
				'detail' => $detail,
				'lowestprice' => $lowestprice,
				'shelf' => $shelf
			);

			$result = $this->product->editProduct($product);
			if ($result) 
				$this->session->set_flashdata('showresult', 'success');
			else
				$this->session->set_flashdata('showresult', 'fail');
				
			$this->session->set_flashdata('id', $categoryid);
			redirect(current_url());
		}
			$query = $this->product->getOneProduct($id);
			if($query){
				$data['product_array'] =  $query;
			}
			
			$query = $this->category->getCat();
			if($query){
				$data['cat_array'] =  $query;
			}else{
				$data['cat_array'] = array();
			}
			
			$data['title'] = "Pradit and Friends - Edit Product";
			
			$this->load->view('editproduct_view',$data);
	}
	
     function barcode() 
     {
		$barcodeid = $this->uri->segment(3);
		$this->load->library('my_barcode');
        $this->my_barcode->save_path = "barcode/";
 
        $this->my_barcode->getBarcodePNGPath($barcodeid,'C128',2,120);
		$data['barcodepath'] = base_url()."/barcode/".$barcodeid.".png";
		$data['barcodeid'] = $barcodeid;
		$data['title'] = "Pradit and Friends - Barcode printing";
		$this->load->view('barcode_view',$data);
     } 
	 
	
    function jquerybarcode() 
    {
        $id = $this->uri->segment(3);
        $query = $this->product->getOneProduct($id);
		if($query){
			$data['product_array'] =  $query;
		}
		//$data['barcodeid'] = $this->uri->segment(3);
		//$data['pname'] = $this->uri->segment(4);
		//$data['price'] = $this->uri->segment(5);
		$data['id'] = $id;
		$data['title'] = "Pradit and Friends - Barcode printing";
		$this->load->view('barcode_view',$data);
    } 
    
    function printbarcode() 
    {
        $id = $this->uri->segment(3);
        $copy = $this->uri->segment(4);
        $query = $this->product->getOneProduct($id);
		if($query){
			foreach($query as $loop){
                $data['bc'] = $loop->barcode;
                $data['name'] = $loop->pname;
                $data['price'] = $loop->priceVAT;
            }
		}
		//$data['barcodeid'] = $this->uri->segment(3);
		//$data['pname'] = $this->uri->segment(4);
		//$data['price'] = $this->uri->segment(5);
        
		$data['id'] = $id;
        $data['copy'] = $copy;
		$data['title'] = "Pradit and Friends - Barcode printing";
		$this->load->view('printbarcode',$data);
    } 
    
}
?>