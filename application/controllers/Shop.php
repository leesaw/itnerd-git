<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

function __construct()
{
    parent::__construct();
    $this->load->model('tp_shop_model','',TRUE);
    $this->load->model('tp_warehouse_model','',TRUE);
    $this->load->library('form_validation');
    if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');

    if ($this->session->userdata('sessrolex') == 0) {
        $this->no_rolex = "br_id != 888";
        $this->shop_rolex = "sh_id != 888";
    }else{
        $this->no_rolex = "br_id = 888";
        $this->shop_rolex = "sh_id = 888";
    }
}

function index()
{

}

function shname_is_exist($id)
{

    if($this->id_validate($id)>0)
    {
		$this->form_validation->set_message('shname_is_exist', 'ชื่อคลังสินค้านี้มีอยู่ในระบบแล้ว');
        return FALSE;
    }
    else {
        return TRUE;
    }
}

function id_validate($where)
{
    $this->db->where('sh_name', $this->input->post('shname'));
    $query = $this->db->get('tp_shop');
    return $query->num_rows();
}

function manage()
{
    $sql = "";
    $data['shop_array'] = $this->tp_shop_model->getShop($sql);

    $data['title'] = "Nerd - Shop";
    $this->load->view('TP/shop/manage_view',$data);
}

function add_new_shop()
{
    $sql = "wh_enable = 1";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $sql = "";
    $data['group_array'] = $this->tp_shop_model->getShopGroup($sql);

    $sql = "";
    $data['category_array'] = $this->tp_shop_model->getShopCategory($sql);

    $sql = "sn_enable = 1";
    $data['channel_array'] = $this->tp_shop_model->getShopChannel($sql);


    $data['title'] = "Nerd - New Shop";
    $this->load->view('TP/shop/add_new_shop_view',$data);
}

function new_shop_save()
{
    $this->form_validation->set_rules('shname', 'shname', 'trim|xss_clean|required|callback_shname_is_exist');
    $this->form_validation->set_rules('shcode', 'shcode', 'trim|xss_clean|required');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_error_delimiters('<code>', '</code>');

    if($this->form_validation->run() == TRUE) {
        $shname= ($this->input->post('shname'));
        $shname_eng = $this->input->post('shname_eng');
        $shcode= ($this->input->post('shcode'));
        $sgid= ($this->input->post('sgid'));
        $scid = $this->input->post('scid');
        $whid = $this->input->post('whid');
        $snid = $this->input->post('snid');

        $shop = array(
            'sh_name' => $shname,
            'sh_name_eng' => $shname_eng,
            'sh_code' => $shcode,
            'sh_group_id' => $sgid,
            'sh_category_id' => $scid,
            'sh_warehouse_id' => $whid,
            'sh_channel_id' => $snid,
        );

        $shop_id = $this->tp_shop_model->addShop($shop);

        if ($shop_id)
            $this->session->set_flashdata('showresult', 'success');
        else
            $this->session->set_flashdata('showresult', 'fail');
        redirect(current_url());
    }

    $sql = "wh_enable = 1";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $sql = "";
    $data['group_array'] = $this->tp_shop_model->getShopGroup($sql);

    $sql = "";
    $data['category_array'] = $this->tp_shop_model->getShopCategory($sql);

    $sql = "sn_enable = 1";
    $data['channel_array'] = $this->tp_shop_model->getShopChannel($sql);

    $data['title'] = "Nerd - New Shop";
    $this->load->view('TP/shop/add_new_shop_view',$data);
}

function edit_shop()
{
    $id = $this->uri->segment(3);
    $where = "sh_id = '".$id."'";
    $data['sh_array'] = $this->tp_shop_model->getShop($where);

    $sql = "wh_enable = 1";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $sql = "";
    $data['group_array'] = $this->tp_shop_model->getShopGroup($sql);

    $sql = "";
    $data['category_array'] = $this->tp_shop_model->getShopCategory($sql);

    $sql = "sn_enable = 1";
    $data['channel_array'] = $this->tp_shop_model->getShopChannel($sql);

    $data['title'] = "Nerd - Edit Shop";
    $this->load->view('TP/shop/edit_shop_view',$data);
}

function edit_shop_save()
{
    $this->form_validation->set_rules('shname', 'shname', 'trim|xss_clean|required');
    $this->form_validation->set_rules('shcode', 'shcode', 'trim|xss_clean|required');
    $this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
    $this->form_validation->set_error_delimiters('<code>', '</code>');
    $id = $this->input->post('shid');

    if($this->form_validation->run() == TRUE) {
        $shname= ($this->input->post('shname'));
        $shname_eng = $this->input->post('shname_eng');
        $shcode= ($this->input->post('shcode'));
        $sgid= ($this->input->post('sgid'));
        $scid = $this->input->post('scid');
        $whid = $this->input->post('whid');
        $snid = $this->input->post('snid');

        $shop = array(
            'id' => $id,
            'sh_name' => $shname,
            'sh_name_eng' => $shname_eng,
            'sh_code' => $shcode,
            'sh_group_id' => $sgid,
            'sh_category_id' => $scid,
            'sh_warehouse_id' => $whid,
            'sh_channel_id' => $snid,
        );

        $shop_id = $this->tp_shop_model->editShop($shop);

        if ($shop_id)
            $this->session->set_flashdata('showresult', 'success');
        else
            $this->session->set_flashdata('showresult', 'fail');
        redirect('shop/edit_shop/'.$id, 'refresh');
    }

    $where = "sh_id = '".$id."'";
    $data['sh_array'] = $this->tp_shop_model->getShop($where);

    $sql = "wh_enable = 1";
    $data['wh_array'] = $this->tp_warehouse_model->getWarehouse($sql);

    $sql = "";
    $data['group_array'] = $this->tp_shop_model->getShopGroup($sql);

    $sql = "";
    $data['category_array'] = $this->tp_shop_model->getShopCategory($sql);

    $data['title'] = "Nerd - Edit Shop";
    $this->load->view('TP/shop/edit_shop_view',$data);
}

function disable_shop()
{
    $sh_id = $this->uri->segment(3);

    $shop = array("id" => $sh_id, "sh_enable" => 0);
    $result = $this->tp_shop_model->editShop($shop);

    redirect('shop/manage', 'refresh');
}

function bar_manage()
{
  $sql = "";
  $data['shop_array'] = $this->tp_shop_model->getBarcode_GP($sql);

  $data['title'] = "Nerd - Sale Barcode";
  $this->load->view('TP/shop/bar_manage',$data);
}

function form_new_bar()
{
  $this->load->model('tp_item_model','',TRUE);

  $sql = "";
  $data['brand_array'] = $this->tp_item_model->getBrand($sql);

  $data['group_array'] = $this->tp_shop_model->getShopGroup($sql);

  $data['title'] = "Nerd - New Sale Barcode";
  $this->load->view('TP/shop/form_new_bar',$data);
}

function save_new_bar()
{
  $sbnumber= ($this->input->post('sbnumber'));
  $sbname = $this->input->post('sbname');
  $sgid= ($this->input->post('sgid'));
  $brid= ($this->input->post('brid'));
  $dc = $this->input->post('dc');
  $gp = $this->input->post('gp');

  $this->load->model('tp_item_model','',TRUE);

  $bar = array(
      'sb_number' => $sbnumber,
      'sb_brand_name' => $sbname,
      'sb_shop_group_id' => $sgid,
      'sb_item_brand_id' => $brid,
      'sb_discount_percent' => $dc,
      'sb_gp' => $gp,
  );

  $shop_id = $this->tp_shop_model->add_sale_barcode($bar);

  if ($shop_id)
    $this->session->set_flashdata('showresult', 'success');
  else
    $this->session->set_flashdata('showresult', 'fail');



  $sql = "";
  $data['brand_array'] = $this->tp_item_model->getBrand($sql);

  $data['group_array'] = $this->tp_shop_model->getShopGroup($sql);

  redirect('shop/form_new_bar', 'refresh');
}

function disable_bar()
{
  $sb_id = $this->uri->segment(3);

  $shop = array("id" => $sb_id, "sb_enable" => 0);
  $result = $this->tp_shop_model->edit_sale_barcode($shop);

  redirect('shop/bar_manage', 'refresh');
}

function form_edit_bar()
{
    $id = $this->uri->segment(3);
    $where = "sb_id = '".$id."'";
    $data['bar_array'] = $this->tp_shop_model->getBarcode_GP($where);

    $this->load->model('tp_item_model','',TRUE);

    $sql = "";
    $data['brand_array'] = $this->tp_item_model->getBrand($sql);

    $data['group_array'] = $this->tp_shop_model->getShopGroup($sql);

    $data['title'] = "Nerd - Edit Sale Barcode";
    $this->load->view('TP/shop/form_edit_bar',$data);
}

function save_edit_bar()
{
  $sbid = ($this->input->post('sbid'));
  $sbnumber= ($this->input->post('sbnumber'));
  $sbname = $this->input->post('sbname');
  $sgid= ($this->input->post('sgid'));
  $brid= ($this->input->post('brid'));
  $dc = $this->input->post('dc');
  $gp = $this->input->post('gp');

  $this->load->model('tp_item_model','',TRUE);

  $bar = array(
      'id' => $sbid,
      'sb_number' => $sbnumber,
      'sb_brand_name' => $sbname,
      'sb_shop_group_id' => $sgid,
      'sb_item_brand_id' => $brid,
      'sb_discount_percent' => $dc,
      'sb_gp' => $gp,
  );

  $shop_id = $this->tp_shop_model->edit_sale_barcode($bar);

  if ($shop_id)
    $this->session->set_flashdata('showresult', 'success');
  else
    $this->session->set_flashdata('showresult', 'fail');

  $where = "sb_id = '".$sbid."'";
  $data['bar_array'] = $this->tp_shop_model->getBarcode_GP($where);

  $this->load->model('tp_item_model','',TRUE);

  $sql = "";
  $data['brand_array'] = $this->tp_item_model->getBrand($sql);

  $data['group_array'] = $this->tp_shop_model->getShopGroup($sql);

  $data['title'] = "Nerd - Edit Sale Barcode";
  $this->load->view('TP/shop/form_edit_bar',$data);
}

}
?>
