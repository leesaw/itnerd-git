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
     if (!($this->session->userdata('sessusername'))) redirect('catalog', 'refresh');
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
    
	$data['title'] = "NGG| Nerd - Add New Certification";
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
        'cer_girdlethickness_id' => $girdlethickness,
        'cer_girdlefinish_id' => $girdlefinish,
        'cer_culet_id' => $culet,
        'cer_girdleinscription_id' => $girdleinscription,
        'cer_fluorescence_id' => $fluorescence,
        'cer_softwareresult' => 1,
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
    
function add_newcert_ok()
{
    $cer_id = $this->uri->segment(3);
    $data["showresult"] = $this->session->flashdata('showresult');
    $where = "cer_id = '".$cer_id."'";
    $data["cer_array"] = $this->ss_certificate_model->get_certificate($where);

    $data["cer_id"] = $cer_id;
    $data['title'] = "NGG| Nerd - Add New Certification";
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
    
function view_certificate_pdf()
{
    $cer_id = $this->uri->segment(3);

    $this->load->library('mpdf/mpdf');                
    $mpdf= new mPDF('','A4-L','0', 'helvetica');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/styleCertificate.css');

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
    $mpdf->WriteHTML($this->load->view("SS/certificate/view_certificate_pdf", $data, TRUE));
    $mpdf->Output();
}

}
?>