<?php

class ImagesearcherController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Handles what happens when user moves to URL/index/index - or - as this is the default controller, also
     * when user moves to /index or enter your application at base level
     */
    public function index()
    {
	$result='';
	$s=REQUEST::post('btnFile');
	if(!empty($s)){
		$result.=ImagesearcherController::upload();
	}
	$this->View->render('imagesearcher/index', array(
			'uploaded'=>$result));
    }

    public function upload(){
	    include 'upload.php';
	    $bef=Session::get('user_name') . '_';
	    $data='/root/spoderman/data';
	    upload($data . '/faces', 'flFaces', $bef);
	    upload($data . '/guns', 'flGuns', $bef);
	    upload($data . '/streetViews', 'flStreetViews', $bef);
	    upload($data . '/drugs', 'flDrugs', $bef);
	    $result='';
	    $result.="<p>Uploaded!</p>";
	    return $result;
    }




}
