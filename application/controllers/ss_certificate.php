<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ss_certificate extends CI_Controller {
    private $upload_path_result = "./uploads/certificate/result";
    private $upload_path_proportion = "./uploads/certificate/proportion";
    private $upload_path_clarity = "./uploads/certificate/clarity";
    
function __construct()
{
     parent::__construct();
     $this->load->model('ss_list_model','',TRUE);
     $this->load->model('ss_certificate_model','',TRUE);
     $this->load->library('form_validation');
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
}

function index()
{
    
}
 
function add_newcert()
{
    $this->load->helper(array('form'));
	
    //////////   ------ get list
	$query = $this->ss_list_model->get_list_clarity();
	if($query){
		$data['clarity_array'] =  $query;
	}else{
		$data['clarity_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_color();
	if($query){
		$data['color_array'] =  $query;
	}else{
		$data['color_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_culet();
	if($query){
		$data['culet_array'] =  $query;
	}else{
		$data['culet_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_cuttingstyle();
	if($query){
		$data['cuttingstyle_array'] =  $query;
	}else{
		$data['cuttingstyle_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_fluorescence();
	if($query){
		$data['fluorescence_array'] =  $query;
	}else{
		$data['fluorescence_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdlefinish();
	if($query){
		$data['girdlefinish_array'] =  $query;
	}else{
		$data['girdlefinish_array'] = array();
	}
    /*
    $query = $this->ss_list_model->get_list_girdleinscription();
	if($query){
		$data['girdleinscription_array'] =  $query;
	}else{
		$data['girdleinscription_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdlethickness();
	if($query){
		$data['girdlethickness_array'] =  $query;
	}else{
		$data['girdlethickness_array'] = array();
	}
    */
    $query = $this->ss_list_model->get_list_naturaldiamond();
	if($query){
		$data['naturaldiamond_array'] =  $query;
	}else{
		$data['naturaldiamond_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_polish();
	if($query){
		$data['polish_array'] =  $query;
	}else{
		$data['polish_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_proportion();
	if($query){
		$data['proportion_array'] =  $query;
	}else{
		$data['proportion_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_shape();
	if($query){
		$data['shape_array'] =  $query;
	}else{
		$data['shape_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_symmetry();
	if($query){
		$data['symmetry_array'] =  $query;
	}else{
		$data['symmetry_array'] = array();
	}
    
    /////   ------  end get list
    
	$data['title'] = "NGG| Nerd - Add New Certificate";
	$this->load->view('SS/certificate/add_newcert_view',$data);
}
    
function save()
{
    $natural= ($this->input->post('natural'));
    $shape= ($this->input->post('shape'));
    $cuttingstyle= ($this->input->post('cuttingstyle'));
    $measurement= ($this->input->post('measurement'));
    $carat= ($this->input->post('carat'));
    $color= ($this->input->post('color'));
    $clarity= ($this->input->post('clarity'));
    $girdleinscription= ($this->input->post('girdleinscription'));
    $fluorescence= ($this->input->post('fluorescence'));
    $proportion= ($this->input->post('proportion'));
    $symmetry= ($this->input->post('symmetry'));
    $polish= ($this->input->post('polish'));
    $totaldepth= ($this->input->post('totaldepth'));
    $totalsize= ($this->input->post('totalsize'));
    $crownheight= ($this->input->post('crownheight'));
    $crownangle= ($this->input->post('crownangle'));
    $starlength= ($this->input->post('starlength'));
    $paviliondepth= ($this->input->post('paviliondepth'));
    $pavilionangle= ($this->input->post('pavilionangle'));
    $lowerhalflength= ($this->input->post('lowerhalflength'));
    $girdlethickness= ($this->input->post('girdlethickness'));
    $girdlefinish= ($this->input->post('girdlefinish'));
    $culet= ($this->input->post('culet'));
    
    $comment = ($this->input->post('comment'));
    
    $currentdate = date("Y-m-d");
    $date_array = explode('-',date("y-m-d"));
    
    $number = $this->ss_certificate_model->get_maxnumber_certificate($currentdate);
    $number++;
    $number = $date_array[0].$date_array[1].$date_array[2].str_pad($number, 4, '0', STR_PAD_LEFT);
    
    $currentdate = date("Y-m-d H:i:s");

    $certificate = array(
        'cer_number' => $number,
        'cer_naturaldiamond_id' => $natural,
        'cer_shape_id' => $shape,
        'cer_cuttingstyle_id' => $cuttingstyle,
        'cer_measurement' => $measurement,
        'cer_carat' => $carat,
        'cer_color_id' => $color,
        'cer_clarity_id' => $clarity,
        'cer_proportion_id' => $proportion,
        'cer_symmetry_id' => $symmetry,
        'cer_polish_id' => $polish,
        'cer_totaldepth' => $totaldepth,
        'cer_tablesize' => $totalsize,
        'cer_crownheight' => $crownheight,
        'cer_crownangle' => $crownangle,
        'cer_starlength' => $starlength,
        'cer_paviliondepth' => $paviliondepth,
        'cer_pavilionangle' => $pavilionangle,
        'cer_lowerhalflength' => $lowerhalflength,
        'cer_girdlethickness' => $girdlethickness,
        'cer_girdlefinish_id' => $girdlefinish,
        'cer_culet_id' => $culet,
        'cer_girdleinscription' => $girdleinscription,
        'cer_fluorescence_id' => $fluorescence,
        'cer_softwareresult' => 1,
        'cer_comment' => $comment,
        'cer_dateadd' => $currentdate,
        'cer_dateadd_by' => $this->session->userdata('sessid'),
        'cer_status' => 1
    );

    $cer_id = $this->ss_certificate_model->add_certificate($certificate);

    $currentdate = date("Y-m-d H:i:s");

    $temp = array('cer_certificate_id' => $cer_id);

    $certificate = array_merge($certificate, $temp);

    $result_log = $this->ss_certificate_model->add_log_certificate($certificate);
    
    if ($cer_id) {
        $this->session->set_flashdata('showresult', 'true');
        
        redirect('ss_certificate/add_newcert_ok/'.$cer_id, 'refresh');
        
    }else{
        $this->session->set_flashdata('showresult', 'fail');
        redirect(current_url());
    }

    
}
    
function edit()
{
    $cer_id = ($this->input->post('cer_id'));
    $number = ($this->input->post('number'));
    $natural= ($this->input->post('natural'));
    $shape= ($this->input->post('shape'));
    $cuttingstyle= ($this->input->post('cuttingstyle'));
    $measurement= ($this->input->post('measurement'));
    $carat= ($this->input->post('carat'));
    $color= ($this->input->post('color'));
    $clarity= ($this->input->post('clarity'));
    $girdleinscription= ($this->input->post('girdleinscription'));
    $fluorescence= ($this->input->post('fluorescence'));
    $proportion= ($this->input->post('proportion'));
    $symmetry= ($this->input->post('symmetry'));
    $polish= ($this->input->post('polish'));
    $totaldepth= ($this->input->post('totaldepth'));
    $totalsize= ($this->input->post('totalsize'));
    $crownheight= ($this->input->post('crownheight'));
    $crownangle= ($this->input->post('crownangle'));
    $starlength= ($this->input->post('starlength'));
    $paviliondepth= ($this->input->post('paviliondepth'));
    $pavilionangle= ($this->input->post('pavilionangle'));
    $lowerhalflength= ($this->input->post('lowerhalflength'));
    $girdlethickness= ($this->input->post('girdlethickness'));
    $girdlefinish= ($this->input->post('girdlefinish'));
    $culet= ($this->input->post('culet'));
    
    $comment = ($this->input->post('comment'));
    
    $currentdate = date("Y-m-d H:i:s");

    $certificate = array(
        'id' => $cer_id,
        'cer_naturaldiamond_id' => $natural,
        'cer_shape_id' => $shape,
        'cer_cuttingstyle_id' => $cuttingstyle,
        'cer_measurement' => $measurement,
        'cer_carat' => $carat,
        'cer_color_id' => $color,
        'cer_clarity_id' => $clarity,
        'cer_proportion_id' => $proportion,
        'cer_symmetry_id' => $symmetry,
        'cer_polish_id' => $polish,
        'cer_totaldepth' => $totaldepth,
        'cer_tablesize' => $totalsize,
        'cer_crownheight' => $crownheight,
        'cer_crownangle' => $crownangle,
        'cer_starlength' => $starlength,
        'cer_paviliondepth' => $paviliondepth,
        'cer_pavilionangle' => $pavilionangle,
        'cer_lowerhalflength' => $lowerhalflength,
        'cer_girdlethickness' => $girdlethickness,
        'cer_girdlefinish_id' => $girdlefinish,
        'cer_culet_id' => $culet,
        'cer_girdleinscription' => $girdleinscription,
        'cer_fluorescence_id' => $fluorescence,
        'cer_softwareresult' => 1,
        'cer_comment' => $comment,
        'cer_dateadd' => $currentdate,
        'cer_dateadd_by' => $this->session->userdata('sessid')
    );

    $cer_result = $this->ss_certificate_model->edit_certificate($certificate);

    $currentdate = date("Y-m-d H:i:s");

    unset($certificate['id']);
    $temp = array('cer_certificate_id' => $cer_id, 'cer_status' => 2, 'cer_number' => $number);

    $certificate = array_merge($certificate, $temp);

    $result_log = $this->ss_certificate_model->add_log_certificate($certificate);
    
    if ($cer_result) 
        $this->session->set_flashdata('showresult', 'success');
    else
        $this->session->set_flashdata('showresult', 'fail');
        
    redirect('ss_certificate/edit_certificate/'.$cer_id, 'refresh');

    
}
    
function add_newcert_ok()
{
    $cer_id = $this->uri->segment(3);
    $data["showresult"] = $this->session->flashdata('showresult');
    $where = "cer_id = '".$cer_id."'";
    $data["cer_array"] = $this->ss_certificate_model->get_certificate($where);
    
    $query = $this->ss_list_model->get_list_symbol();
	if($query){
		$data['symbol_array'] = $query;
	}else{
		$data['symbol_array'] = array();
	}

    $data["cer_id"] = $cer_id;
    $data['title'] = "NGG| Nerd - Add New Certificate";
    $this->load->view('SS/certificate/add_newcert_result',$data);
}
    
public function upload_picture_result()
{
    $cer_id = $this->uri->segment(3);
    
    if ( ! empty($_FILES)) 
    {
        $config["upload_path"]   = $this->upload_path_result."/".$cer_id;
        $config["allowed_types"] = "gif|jpg|png";
        $this->load->library('upload', $config);

        $dir_exist = true; // flag for checking the directory exist or not
        if (!is_dir($this->upload_path_result."/".$cer_id))
        {
            mkdir($this->upload_path_result."/".$cer_id, 0777, true);
            $dir_exist = false; // dir not exist
        }

        if ( ! $this->upload->do_upload("file")) {
            if(!$dir_exist)
                rmdir($this->upload_path_result."/".$cer_id);
            echo "failed to upload file(s)";
        }else{
            $upload_data = $this->upload->data(); 
            $file_name =   $upload_data['file_name'];
            $picture = array("pre_certificate_id" => $cer_id, "pre_value" => $file_name);
            $this->ss_certificate_model->add_upload_picture_result($picture);
        }
    }
}

public function remove_picture_result()
{
    $cer_id = $this->uri->segment(3);
    $file = $this->input->post("file");
    if ($file && file_exists($this->upload_path_result."/".$cer_id . "/" . $file)) {
        unlink($this->upload_path_result."/".$cer_id . "/" . $file);
        $picture = array("pre_certificate_id" => $cer_id, "pre_value" => $file);
        $this->ss_certificate_model->delete_upload_picture_result($picture);
    }
}

public function list_picture_result()
{
    $cer_id = $this->uri->segment(3);
    $this->load->helper("file");
    $files = get_filenames($this->upload_path_result."/".$cer_id );
    // we need name and size for dropzone mockfile
    foreach ($files as &$file) {
        $file = array(
            'name' => $file,
            'size' => filesize($this->upload_path_result."/".$cer_id . "/" . $file),
            'path' => substr($this->upload_path_result, 1)."/".$cer_id . "/" . $file
        );
    }

    header("Content-type: text/json");
    header("Content-type: application/json");
    echo json_encode($files);
}
   
public function upload_picture_proportion()
{
    $cer_id = $this->uri->segment(3);
    
    if ( ! empty($_FILES)) 
    {
        $config["upload_path"]   = $this->upload_path_proportion."/".$cer_id;
        $config["allowed_types"] = "gif|jpg|png";
        $this->load->library('upload', $config);

        $dir_exist = true; // flag for checking the directory exist or not
        if (!is_dir($this->upload_path_proportion."/".$cer_id))
        {
            mkdir($this->upload_path_proportion."/".$cer_id, 0777, true);
            $dir_exist = false; // dir not exist
        }

        if ( ! $this->upload->do_upload("file")) {
            if(!$dir_exist)
                rmdir($this->upload_path_proportion."/".$cer_id);
            echo "failed to upload file(s)";
        }else{
            $upload_data = $this->upload->data(); 
            $file_name =   $upload_data['file_name'];
            $picture = array("ppr_certificate_id" => $cer_id, "ppr_value" => $file_name);
            $this->ss_certificate_model->add_upload_picture_proportion($picture);
        }
    }
}

public function remove_picture_proportion()
{
    $cer_id = $this->uri->segment(3);
    $file = $this->input->post("file");
    if ($file && file_exists($this->upload_path_proportion."/".$cer_id . "/" . $file)) {
        unlink($this->upload_path_proportion."/".$cer_id . "/" . $file);
        $picture = array("ppr_certificate_id" => $cer_id, "ppr_value" => $file);
        $this->ss_certificate_model->delete_upload_picture_proportion($picture);
    }
}

public function list_picture_proportion()
{
    $cer_id = $this->uri->segment(3);
    $this->load->helper("file");
    $files = get_filenames($this->upload_path_proportion."/".$cer_id );
    // we need name and size for dropzone mockfile
    foreach ($files as &$file) {
        $file = array(
            'name' => $file,
            'size' => filesize($this->upload_path_proportion."/".$cer_id . "/" . $file),
            'path' => substr($this->upload_path_proportion, 1)."/".$cer_id . "/" . $file
        );
    }

    header("Content-type: text/json");
    header("Content-type: application/json");
    echo json_encode($files);
}
    
public function upload_picture_clarity()
{
    $cer_id = $this->uri->segment(3);
    
    if ( ! empty($_FILES)) 
    {
        $config["upload_path"]   = $this->upload_path_clarity."/".$cer_id;
        $config["allowed_types"] = "gif|jpg|png";
        $this->load->library('upload', $config);

        $dir_exist = true; // flag for checking the directory exist or not
        if (!is_dir($this->upload_path_clarity."/".$cer_id))
        {
            mkdir($this->upload_path_clarity."/".$cer_id, 0777, true);
            $dir_exist = false; // dir not exist
        }

        if ( ! $this->upload->do_upload("file")) {
            if(!$dir_exist)
                rmdir($this->upload_path_clarity."/".$cer_id);
            echo "failed to upload file(s)";
        }else{
            $upload_data = $this->upload->data(); 
            $file_name =   $upload_data['file_name'];
            $picture = array("pcl_certificate_id" => $cer_id, "pcl_value" => $file_name);
            $this->ss_certificate_model->add_upload_picture_clarity($picture);
        }
    }
}

public function remove_picture_clarity()
{
    $cer_id = $this->uri->segment(3);
    $file = $this->input->post("file");
    if ($file && file_exists($this->upload_path_clarity."/".$cer_id . "/" . $file)) {
        unlink($this->upload_path_clarity."/".$cer_id . "/" . $file);
        $picture = array("pcl_certificate_id" => $cer_id, "pcl_value" => $file);
        $this->ss_certificate_model->delete_upload_picture_clarity($picture);
    }
}

public function list_picture_clarity()
{
    $cer_id = $this->uri->segment(3);
    $this->load->helper("file");
    $files = get_filenames($this->upload_path_clarity."/".$cer_id );
    // we need name and size for dropzone mockfile
    foreach ($files as &$file) {
        $file = array(
            'name' => $file,
            'size' => filesize($this->upload_path_clarity."/".$cer_id . "/" . $file),
            'path' => substr($this->upload_path_clarity, 1)."/".$cer_id . "/" . $file
        );
    }

    header("Content-type: text/json");
    header("Content-type: application/json");
    echo json_encode($files);
}
    
function view_certificate_pdf_full()
{
    $cer_id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('','A4-L','0', 'ffdin');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/styleCertificate.css');

    $where = "cer_id = '".$cer_id."'";
    $data["cer_array"] = $this->ss_certificate_model->get_certificate($where);
    
    $where = "pre_certificate_id = '".$cer_id."'";
    $data["result_array"] = $this->ss_certificate_model->get_picture_result($where);
    
    $where = "ppr_certificate_id = '".$cer_id."'";
    $data["proportion_array"] = $this->ss_certificate_model->get_picture_proportion($where);
    
    $where = "pcl_certificate_id = '".$cer_id."'";
    $data["clarity_array"] = $this->ss_certificate_model->get_picture_clarity($where);
    
    $query = $this->ss_list_model->get_list_symbol();
	if($query){
		$data['symbol_array'] = $query;
	}else{
		$data['symbol_array'] = array();
	}

    $data["cer_id"] = $cer_id;
    $data["path_result"] = $this->upload_path_result;
    $data["path_proportion"] = $this->upload_path_proportion;
    $data["path_clarity"] = $this->upload_path_clarity;
    //echo $html;
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("SS/certificate/view_certificate_pdf", $data, TRUE));
    $mpdf->Output();
}
    
function view_certificate_pdf_small()
{
    $cer_id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('','A5-L','0', 'ffdin');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/styleCertificate_small.css');

    $where = "cer_id = '".$cer_id."'";
    $data["cer_array"] = $this->ss_certificate_model->get_certificate($where);
    
    $where = "pre_certificate_id = '".$cer_id."'";
    $data["result_array"] = $this->ss_certificate_model->get_picture_result($where);
    
    $where = "ppr_certificate_id = '".$cer_id."'";
    $data["proportion_array"] = $this->ss_certificate_model->get_picture_proportion($where);
    
    $where = "pcl_certificate_id = '".$cer_id."'";
    $data["clarity_array"] = $this->ss_certificate_model->get_picture_clarity($where);

    $data["cer_id"] = $cer_id;
    $data["path_result"] = $this->upload_path_result;
    $data["path_proportion"] = $this->upload_path_proportion;
    $data["path_clarity"] = $this->upload_path_clarity;
    //echo $html;
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("SS/certificate/view_certificate_small", $data, TRUE));
    $mpdf->Output();
}
    
function view_certificate_pdf_form()
{
    $cer_id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('','A4','0', 'ffdin');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/styleCertificate_form.css');

    $where = "cer_id = '".$cer_id."'";
    $data["cer_array"] = $this->ss_certificate_model->get_certificate($where);
    
    $where = "pre_certificate_id = '".$cer_id."'";
    $data["result_array"] = $this->ss_certificate_model->get_picture_result($where);
    
    $where = "ppr_certificate_id = '".$cer_id."'";
    $data["proportion_array"] = $this->ss_certificate_model->get_picture_proportion($where);
    
    $where = "pcl_certificate_id = '".$cer_id."'";
    $data["clarity_array"] = $this->ss_certificate_model->get_picture_clarity($where);
    
    $query = $this->ss_list_model->get_list_symbol();
	if($query){
		$data['symbol_array'] = $query;
	}else{
		$data['symbol_array'] = array();
	}

    $data["cer_id"] = $cer_id;
    $data["path_result"] = $this->upload_path_result;
    $data["path_proportion"] = $this->upload_path_proportion;
    $data["path_clarity"] = $this->upload_path_clarity;
    //echo $html;
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("SS/certificate/view_certificate_form", $data, TRUE));
    $mpdf->Output();
}

    
function view_all_certificate()
{
    $data['title'] = "NGG| Nerd - All Certificate";
    $this->load->view('SS/certificate/view_all_certificate',$data);
}

function ajaxAllCertificate()
{
    $this->load->library('Datatables');
    $this->datatables
    ->select("cer_number, lsh_value as shape, cer_measurement, cer_carat, lpt_value as proportion, lco_value as color, lcl_value as clarity, cer_id")
    ->from('ss_certificate')
    ->join("ss_list_clarity", "lcl_id = cer_clarity_id", "left")
    ->join("ss_list_color", "lco_id = cer_color_id", "left")
    ->join("ss_list_culet", "lct_id = cer_culet_id", "left")
    ->join("ss_list_cuttingstyle", "lcs_id = cer_cuttingstyle_id", "left")
    ->join("ss_list_fluorescence", "lfu_id = cer_fluorescence_id", "left")
    ->join("ss_list_girdlefinish", "lgf_id = cer_girdlefinish_id", "left")
    //->join("ss_list_girdleinscription", "lgs_id = cer_girdleinscription_id", "left")
    //->join("ss_list_girdlethickness", "lgt_id = cer_girdlethickness_id", "left")
    ->join("ss_list_naturaldiamond", "lnd_id = cer_naturaldiamond_id", "left")
    ->join("ss_list_polish", "lpo_id = cer_polish_id", "left")
    ->join("ss_list_proportion", "lpt_id = cer_proportion_id", "left")
    ->join("ss_list_shape", "lsh_id = cer_shape_id", "left")
    ->join("ss_list_symmetry", "lsm_id = cer_symmetry_id", "left")
    ->where('cer_enable',1)
    ->edit_column("cer_id",'<div class="tooltip-demo">
<a href="'.site_url("ss_certificate/view_certificate/$1").'" target="blank" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
<a href="'.site_url("ss_certificate/edit_certificate/$1").'" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="'.site_url("ss_certificate/add_newcert_ok/$1").'" class="btn bg-purple btn-xs" data-title="Picture" data-toggle="tooltip" data-target="#picture" data-placement="top" rel="tooltip" title="แก้ไขรูปภาพ"><i class="fa fa-image"></i></a>
<a href="'.site_url("ss_certificate/delete_certificate/$1").'" class="btn btn-danger btn-xs" data-title="ยกเลิก" data-toggle="tooltip" data-target="#remove" data-placement="top" rel="tooltip" title="ยกเลิก"><i class="fa fa-remove"></i></a>
</div>',"cer_id");
    echo $this->datatables->generate(); 
}
    
function view_certificate()
{
    $cer_id = $this->uri->segment(3);
    $where = "cer_id = '".$cer_id."'";
    $data["cer_array"] = $this->ss_certificate_model->get_certificate($where);
    
    $where = "pre_certificate_id = '".$cer_id."'";
    $data["result_array"] = $this->ss_certificate_model->get_picture_result($where);
    
    $where = "ppr_certificate_id = '".$cer_id."'";
    $data["proportion_array"] = $this->ss_certificate_model->get_picture_proportion($where);
    
    $where = "pcl_certificate_id = '".$cer_id."'";
    $data["clarity_array"] = $this->ss_certificate_model->get_picture_clarity($where);

    $data["cer_id"] = $cer_id;
    $data["path_result"] = $this->upload_path_result;
    $data["path_proportion"] = $this->upload_path_proportion;
    $data["path_clarity"] = $this->upload_path_clarity;
    $data['title'] = "NGG| Nerd - View Certificate";
    $this->load->view('SS/certificate/view_certificate',$data);
}
    
function edit_certificate()
{
    $cer_id = $this->uri->segment(3);
    $where = "cer_id = '".$cer_id."'";
    $data["cer_array"] = $this->ss_certificate_model->get_certificate($where);

    $this->load->helper(array('form'));
	
    //////////   ------ get list
	$query = $this->ss_list_model->get_list_clarity();
	if($query){
		$data['clarity_array'] =  $query;
	}else{
		$data['clarity_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_color();
	if($query){
		$data['color_array'] =  $query;
	}else{
		$data['color_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_culet();
	if($query){
		$data['culet_array'] =  $query;
	}else{
		$data['culet_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_cuttingstyle();
	if($query){
		$data['cuttingstyle_array'] =  $query;
	}else{
		$data['cuttingstyle_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_fluorescence();
	if($query){
		$data['fluorescence_array'] =  $query;
	}else{
		$data['fluorescence_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdlefinish();
	if($query){
		$data['girdlefinish_array'] =  $query;
	}else{
		$data['girdlefinish_array'] = array();
	}
    /*
    $query = $this->ss_list_model->get_list_girdleinscription();
	if($query){
		$data['girdleinscription_array'] =  $query;
	}else{
		$data['girdleinscription_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdlethickness();
	if($query){
		$data['girdlethickness_array'] =  $query;
	}else{
		$data['girdlethickness_array'] = array();
	}
    */
    $query = $this->ss_list_model->get_list_naturaldiamond();
	if($query){
		$data['naturaldiamond_array'] =  $query;
	}else{
		$data['naturaldiamond_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_polish();
	if($query){
		$data['polish_array'] =  $query;
	}else{
		$data['polish_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_proportion();
	if($query){
		$data['proportion_array'] =  $query;
	}else{
		$data['proportion_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_shape();
	if($query){
		$data['shape_array'] =  $query;
	}else{
		$data['shape_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_symmetry();
	if($query){
		$data['symmetry_array'] =  $query;
	}else{
		$data['symmetry_array'] = array();
	}
    
    /////   ------  end get list
    
    $data["cer_id"] = $cer_id;
    $data['title'] = "NGG| Nerd - View Certificate";
    $this->load->view('SS/certificate/edit_certificate',$data);
}
    
function delete_certificate()
{
    $cer_id = $this->uri->segment(3);
    $data["showresult"] = $this->session->flashdata('showresult');
    $where = "cer_id = '".$cer_id."'";
    $data["cer_array"] = $this->ss_certificate_model->get_certificate($where);
    
    $where = "pre_certificate_id = '".$cer_id."'";
    $data["result_array"] = $this->ss_certificate_model->get_picture_result($where);
    
    $where = "ppr_certificate_id = '".$cer_id."'";
    $data["proportion_array"] = $this->ss_certificate_model->get_picture_proportion($where);
    
    $where = "pcl_certificate_id = '".$cer_id."'";
    $data["clarity_array"] = $this->ss_certificate_model->get_picture_clarity($where);

    $data["cer_id"] = $cer_id;
    $data["path_result"] = $this->upload_path_result;
    $data["path_proportion"] = $this->upload_path_proportion;
    $data["path_clarity"] = $this->upload_path_clarity;
    $data['title'] = "NGG| Nerd - View Certificate";
    $this->load->view('SS/certificate/delete_certificate',$data);
}
    
function delete_certificate_confirm()
{
    $currentdate = date("Y-m-d H:i:s");
        
    $cer_id = $this->input->post("cer_id");
    $certificate = array("id" => $cer_id, "cer_enable" => 0, "cer_dateadd" => $currentdate,"cer_dateadd_by" => $this->session->userdata('sessid'));
    $query = $this->ss_certificate_model->edit_certificate($certificate);
    
    
    if ($query) {
        $result = "OK";
    }else{
        $result = "ERROR";
    }
    
    echo json_encode($result);
    exit();
}
    
function save_symbol()
{
    $symbol_input = $this->input->post("symbol_array");
    $cer_id = $this->input->post("cer_id");
    $symbol = "";
    for($i=0; $i<count($symbol_input); $i++) {
        $symbol .= "#".$symbol_input[$i];
    }
    

    $certificate = array(
        'id' => $cer_id,
        'cer_symbol' => $symbol
    );

    $cer_result = $this->ss_certificate_model->edit_certificate($certificate);

    echo json_encode("OK");
}
    
function search_certificate()
{
    //////////   ------ get list
	$query = $this->ss_list_model->get_list_clarity();
	if($query){
		$data['clarity_array'] =  $query;
	}else{
		$data['clarity_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_color();
	if($query){
		$data['color_array'] =  $query;
	}else{
		$data['color_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_culet();
	if($query){
		$data['culet_array'] =  $query;
	}else{
		$data['culet_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_cuttingstyle();
	if($query){
		$data['cuttingstyle_array'] =  $query;
	}else{
		$data['cuttingstyle_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_fluorescence();
	if($query){
		$data['fluorescence_array'] =  $query;
	}else{
		$data['fluorescence_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdlefinish();
	if($query){
		$data['girdlefinish_array'] =  $query;
	}else{
		$data['girdlefinish_array'] = array();
	}

    $query = $this->ss_list_model->get_list_naturaldiamond();
	if($query){
		$data['naturaldiamond_array'] =  $query;
	}else{
		$data['naturaldiamond_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_polish();
	if($query){
		$data['polish_array'] =  $query;
	}else{
		$data['polish_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_proportion();
	if($query){
		$data['proportion_array'] =  $query;
	}else{
		$data['proportion_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_shape();
	if($query){
		$data['shape_array'] =  $query;
	}else{
		$data['shape_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_symmetry();
	if($query){
		$data['symmetry_array'] =  $query;
	}else{
		$data['symmetry_array'] = array();
	}
    
    $data['number'] = "NULL";
    $data['shape'] = 0;
    $data['cuttingstyle'] = 0;
    $data['carat1'] = 0.11;
    $data['carat2'] = 23.99;
    $data['color'] = 0;
    $data['clarity'] = 0;
    $data['fluorescence'] = 0;
    $data['proportion'] = 0;
    $data['symmetry'] = 0;
    $data['polish'] = 0;
    
    $data['title'] = "NGG| Nerd - Advanced Search";
    $this->load->view('SS/certificate/form_search_certificate',$data);
}
    
function result_search_certificate()
{
    $number = ($this->input->post('cer_number'));
    if ($number == "") $number="NULL";
    $data['number'] = $number;
    $data['shape'] = ($this->input->post('shape'));
    $data['cuttingstyle'] = ($this->input->post('cuttingstyle'));
    $carat1 = ($this->input->post('carat1'));
    if ($carat1 == "") $carat1 = 0.11;
    $data['carat1'] = $carat1;
    $carat2 = ($this->input->post('carat2'));
    if ($carat2 == "") $carat2 = 23.99;
    $data['carat2'] = $carat2;
    $data['color'] = ($this->input->post('color'));
    $data['clarity'] = ($this->input->post('clarity'));
    $data['fluorescence'] = ($this->input->post('fluorescence'));
    $data['proportion'] = ($this->input->post('proportion'));
    $data['symmetry'] = ($this->input->post('symmetry'));
    $data['polish'] = ($this->input->post('polish'));
    
    
    //////////   ------ get list
	$query = $this->ss_list_model->get_list_clarity();
	if($query){
		$data['clarity_array'] =  $query;
	}else{
		$data['clarity_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_color();
	if($query){
		$data['color_array'] =  $query;
	}else{
		$data['color_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_culet();
	if($query){
		$data['culet_array'] =  $query;
	}else{
		$data['culet_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_cuttingstyle();
	if($query){
		$data['cuttingstyle_array'] =  $query;
	}else{
		$data['cuttingstyle_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_fluorescence();
	if($query){
		$data['fluorescence_array'] =  $query;
	}else{
		$data['fluorescence_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_girdlefinish();
	if($query){
		$data['girdlefinish_array'] =  $query;
	}else{
		$data['girdlefinish_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_naturaldiamond();
	if($query){
		$data['naturaldiamond_array'] =  $query;
	}else{
		$data['naturaldiamond_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_polish();
	if($query){
		$data['polish_array'] =  $query;
	}else{
		$data['polish_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_proportion();
	if($query){
		$data['proportion_array'] =  $query;
	}else{
		$data['proportion_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_shape();
	if($query){
		$data['shape_array'] =  $query;
	}else{
		$data['shape_array'] = array();
	}
    
    $query = $this->ss_list_model->get_list_symmetry();
	if($query){
		$data['symmetry_array'] =  $query;
	}else{
		$data['symmetry_array'] = array();
	}
    
    $data['title'] = "NGG| Nerd - Advanced Search";
    $this->load->view('SS/certificate/result_search_certificate',$data);
    
    $where = "cer_enable = 1";
    
    if ($number != "") $where .= " and cer_number like '%".$number."%'";
    if ($shape != 0) $where .= " and cer_shape_id = '".$shape."'";
    if ($cuttingstyle != 0) $where .= " and cer_cuttingstyle_id = '".$cuttingstyle."'";
    if ($color != 0) $where .= " and cer_color_id = '".$color."'";
    if ($clarity != 0) $where .= " and cer_clarity_id = '".$clarity."'";
    if ($fluorescence != 0) $where .= " and cer_fluorescence_id = '".$fluorescence."'";
    if ($proportion != 0) $where .= " and cer_proportion_id = '".$proportion."'";
    if ($symmetry != 0) $where .= " and cer_symmetry_id = '".$symmetry."'";
    if ($polish != 0) $where .= " and cer_polish_id = '".$polish."'";
    if ($carat1 != "") $where .= " and cer_carat >= ".$carat1;
    if ($carat2 != "") $where .= " and cer_carat <= ".$carat2;
}
    
function ajaxView_search_certificate()
{
    
}

}
?>