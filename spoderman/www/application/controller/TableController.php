<?php
include 'PHPExcel.php';
include 'download.php';
/**
 * This controller shows an area that's only visible for logged in users (because of Auth::checkAuthentication(); in line 16)
 */
class TableController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // this entire controller should only be visible/usable by logged in users, so we put authentication-check here
        Auth::checkAuthentication();
    }

    /**
     * This method controls what happens when you move to /dashboard/index in your app.
     */
    public function index()
    {
	    $table='';
        $s = REQUEST::get('fileName');
        if(!empty($s)) {
            $filePath = "/tmp/" . $s;
            $file = fopen($filePath, "rb");
            download($filePath, $s);
            exit;
        }
	    $s = REQUEST::post('btnFNLN');
	    if(!empty($s)){
		    $table.=TableController::getFNLNHtml();
	    }
	    $s = REQUEST::post('btnF');
	    if(!empty($s)){
		    $table.=TableController::getFacebookHtml();
	    }
	    $s = REQUEST::post('btnL');
	    if(!empty($s)){
		    $table.=TableController::getLocationHtml();
	    }
	    $s = REQUEST::get('crid');
	    if(!empty($s)){
		    $table.=TableController::getCRIdHtml();
	    }
	    $s = REQUEST::get('midcid');
	    if(!empty($s)){
		    $table.=TableController::getMIDCIdHtml();
	    }
        $s = REQUEST::get('picmidcid');
        if(!empty($s)){
            $table.=TableController::getMIDCIdPicHtml();
        }
        $s = REQUEST::get('picmcid');
        if(!empty($s)){
            $table.=TableController::getMCIdPicHtml();
        }
	    $s = REQUEST::get('mcid');
	    if(!empty($s)){
		    $table.=TableController::getMCIdHtml();
	    }
	    $s = REQUEST::get('ocid');
	    if(!empty($s)){
		    $table.=TableController::getOCIdHtml();
	    }
	    $s = REQUEST::post('btnTW');
	    if(!empty($s)){
		    $table.=TableController::getTwitterHtml();
	    }
        $s = REQUEST::get('fbTimelineMessageId');
        if(!empty($s)){
            $table.=TableController::getFbTimelineMessagePicHtml();
        }
        $s = REQUEST::post('data');
        if(!empty($s)) {
            set_time_limit(0);
            ignore_user_abort(1);
            $data = TableController::getTimelineExcel($s);
            $this->View->renderJSON($data);
        } else {
            $this->View->render('table/index', array(
                'table' => $table)); 
        }
    }

    /**
     * This method runs your search in multiple tables and exports a xls.
     */
    /*
    public function getTimelineCsv() 
    {
        $s = REQUEST::post('txtFTM');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = 'localhost';
        // mysql username
        $username = 'root';
        // mysql password
        $password = '1503vzw35';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_root_info_xnet", $username, $password); 
            //headers and formatting for xls - because its html excel will think its corrupted but it still works.
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;Filename=Timelines.xls");
            echo "<html>";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
            echo "<body>";
            echo "<table border=1>";
            // This is for the first line in the excel file, this needs to be edited depending on the table.
            echo "<tr><th>Id</th><th>Posting Profile</th><th>Friend</th><th>Poster</th><th>PosterLink</th><th>Action</th><th>Message</th><th>PostTime_FB</th><th>PostTime</th><th>Privacy</th><th>Likes</th><th>Likers</th><th>Post Link</th><th>Comments</th><th>First Seen</th><th>Last Seen</th></tr>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table_array = [
                'fb01_timeline',
                'fb02_timeline',
                'fb03_timeline',
                'fb04_timeline',
                'fb05_timeline',
                'fb06_timeline',
                'fb07_timeline',
                'fb08_timeline',
                'fb09_timeline',
                'fb10_timeline'
		];
            //iterates through tables, if using different structured tables we need to set up a conditional block for selecting the right query to run or we need to take pictures out of db altogether.
            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                // If searching multiple columns don't use for loop instead build union query to avoid duplicate rows.
		$column="message";
                //Sql query to search, just don't forget to concate the strings together using .= or . 
                $sql_query = "SELECT id,postingProfile,friend,poster,posterLink,action,message,postTime_fb,postTime,privacy,likes,likers,postLink,comments,firstSeen,lastSeen,tag FROM " . $table;
                $sql_query .= " WHERE ";
                $sql_query .= $column;
                $sql_query .= " LIKE '%";
                $sql_query .= $s;
                $sql_query .= "%';";
                $STM2 = $dbh->prepare($sql_query);
                //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
                // bind paramenters, Named paramenters alaways start with colon(:)
                //$STM2->bindParam(':EntryBy', $EntryBy);
                // For Executing prepared statement we will use below function
                $STM2->execute();
                // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
                $STMrecords = $STM2->fetchAll();
                // We use foreach loop here to echo records.
                foreach($STMrecords as $r)
                    {
                        echo "<tr>";
                        echo "<td>" .$r[0] ."</td>";
                        echo "<td>" .$r[1] ."</td>";
                        echo "<td>" .$r[2] ."</td>";
                        echo "<td>" .$r[3] ."</td>";
                        echo "<td>" .$r[4] ."</td>";
                        echo "<td>" .$r[5] ."</td>";
                        echo "<td>" .$r[6] ."</td>";
                        echo "<td>" .$r[7] ."</td>";
                        echo "<td>" .$r[8] ."</td>";
                        echo "<td>" .$r[9] ."</td>";
                        echo "<td>" .$r[10] ."</td>";
                        echo "<td>" .$r[11] ."</td>";
                        echo "<td>" .$r[12] ."</td>";
                        echo "<td>" .$r[13] ."</td>";
                        echo "<td>" .$r[14] ."</td>";
                        echo "<td>" .$r[15] ."</td>";
                        echo "</tr>";  
                    }
            }

            echo "</table>";
            echo "</body>";
            echo "</html>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            echo $e->getMessage();    
        }
    }
     */

    /**
     * This method runs comments search and exports a xls.
     */
    /*
    public function getTimelineCommentsCsv() 
    {
        $s = REQUEST::post('txtFTC');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = 'localhost';
        // mysql username
        $username = 'root';
        // mysql password
        $password = '1503vzw35';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_root_info_xnet", $username, $password); 
            //headers and formatting for xls - because its html excel will think its corrupted but it still works.
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;Filename=Timeline-Comments.xls");
            echo "<html>";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
            echo "<body>";
            echo "<table border=1>";
            // This is for the first line in the excel file, this needs to be edited depending on the table.
            echo "<tr><th>Id</th><th>Posting Profile</th><th>Timeline Id</th><th>Name</th><th>Link</th><th>Message</th><th>PostTime_FB</th><th>PostTime</th><th>First Seen</th><th>Last Seen</th><th>Tag</th></tr>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table_array = [
                'fb01_comments',
                'fb02_comments',
                'fb03_comments',
                'fb04_comments',
                'fb05_comments',
                'fb06_comments',
                'fb07_comments',
                'fb08_comments',
                'fb09_comments',
                'fb10_comments'
            ];
            //iterates through tables, if using different structured tables we need to set up a conditional block for selecting the right query to run or we need to take pictures out of db altogether.
            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                // If searching multiple columns don't use for loop instead build union query to avoid duplicate rows.
		$column="message";
                //Sql query to search, just don't forget to concontinate the strings together using .= or . 
                $sql_query = "SELECT id,postingProfile,timelineID,name,link,message,postTime_fb,postTime,firstSeen,lastSeen,tag FROM " . $table;
                $sql_query .= " WHERE ";
                $sql_query .= $column;
                $sql_query .= " LIKE '%";
                $sql_query .= $s;
                $sql_query .= "%';";
                $STM2 = $dbh->prepare($sql_query);
                //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
                // bind paramenters, Named paramenters alaways start with colon(:)
                //$STM2->bindParam(':EntryBy', $EntryBy);
                // For Executing prepared statement we will use below function
                $STM2->execute();
                // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
                $STMrecords = $STM2->fetchAll();
                // We use foreach loop here to echo records.
                foreach($STMrecords as $r)
                    {
                        echo "<tr>";
                        echo "<td>" .$r[0] ."</td>";
                        echo "<td>" .$r[1] ."</td>";
                        echo "<td>" .$r[2] ."</td>";
                        echo "<td>" .$r[3] ."</td>";
                        echo "<td>" .$r[4] ."</td>";
                        echo "<td>" .$r[5] ."</td>";
                        echo "<td>" .$r[6] ."</td>";
                        echo "<td>" .$r[7] ."</td>";
                        echo "<td>" .$r[8] ."</td>";
                        echo "<td>" .$r[9] ."</td>";
                        echo "<td>" .$r[10] ."</td>";
                        echo "</tr>";
                    }
            }

            echo "</table>";
            echo "</body>";
            echo "</html>";
            // Closing MySQL database connection
            $dbh = null;
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            echo $e->getMessage();
        }
    }
     */

    public function getFNLNHtml()
    {
	$result='';
	$sFN=REQUEST::post('txtFN');
	$sLN=REQUEST::post('txtLN');
	$sOr=REQUEST::post('ckFNLNOr');
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=molly_pizza", $username, $password); 
            $result.= "<table id=\"name\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>id</th><th>date_modified</th><th>name_first</th><th>name_middle</th><th>name_last</th><th>race</th><th>gender</th><th>hair_color</th><th>eye_color</th><th>height</th><th>weight</th><th>date_birth</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>id</th><th>date_modified</th><th>name_first</th><th>name_middle</th><th>name_last</th><th>race</th><th>gender</th><th>hair_color</th><th>eye_color</th><th>height</th><th>weight</th><th>date_birth</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "people";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_modified,name_first,name_middle,name_last,race,gender,hair_color,eye_color,height,weight,date_birth FROM " . $table;
            $sql_query .= " WHERE ";
	    if(!empty($sFN)){
	    	$column="`name_first`";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sFN;
	    	$sql_query .= "%'";
	    }
	    if(!empty($sFN) and !empty($sLN)){
		if($sOr=='on'){
			$sql_query .= ' OR ';
		}
		else{
			$sql_query .= ' AND ';
		}
	    }
	    if(!empty($sLN)){
	    	$column="`name_last`";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sLN;
	    	$sql_query .= "%'";
	    }

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "<td>" .$r[8] ."</td>";
                    $result.= "<td>" .$r[9] ."</td>";
                    $result.= "<td>" .$r[10] ."</td>";
                    $result.= "<td>" .$r[11] ."</td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
	
	    /*
	    $sFN=REQUEST::post('txtFN');
	    $sLN=REQUEST::post('txtLN');
	    $sOr=REQUEST::post('ckFNLNOr');
	    $result.="<h2>";
	    $result.="CRISNET Results";
	    $result.="</h2>";
        $result.= "<form id=\"download_cr\" method=\"get\" hidden=\"true\">";
        $result.= "<input id=\"download_cr_fName\" name=\"fileName\" type=\"hidden\">";
        $result.= "<input type=\"submit\" value=\"Excel Ready\">";
        $result.= "</form>";
        $result.= "<br><br>";
	    $result.=TableController::getCRHtml($sFN, $sLN, $sOr);
	    $result.="<br>";
	    $result.="<br>";
	    $result.="<h2>";
	    $result.="Michigan Department of Corrections Results";
	    $result.="</h2>";
        $result.= "<form id=\"download_midc\" method=\"get\" hidden=\"true\">";
        $result.= "<input id=\"download_midc_fName\" name=\"fileName\" type=\"hidden\">";
        $result.= "<input type=\"submit\" value=\"Excel Ready\">";
        $result.= "</form>";
        $result.= "<br><br>";
	    $result.=TableController::getMIDCHtml($sFN, $sLN, $sOr);
	    $result.="<br>";
	    $result.="<br>";
	    $result.="<h2>";
	    $result.="Macomb County Results";
	    $result.="</h2>";
        $result.= "<form id=\"download_mc\" method=\"get\" hidden=\"true\">";
        $result.= "<input id=\"download_mc_fName\" name=\"fileName\" type=\"hidden\">";
        $result.= "<input type=\"submit\" value=\"Excel Ready\">";
        $result.= "</form>";
        $result.= "<br><br>";
	    $result.=TableController::getMCHtml($sFN, $sLN, $sOr);
	    $result.="<br>";
	    $result.="<br>";
	    $result.="<h2>";
	    $result.="Oakland County Results";
	    $result.="</h2>";
        $result.= "<form id=\"download_oc\" method=\"get\" hidden=\"true\">";
        $result.= "<input id=\"download_oc_fName\" name=\"fileName\" type=\"hidden\">";
        $result.= "<input type=\"submit\" value=\"Excel Ready\">";
        $result.= "</form>";
        $result.= "<br><br>";
	    $result.=TableController::getOCHtml($sFN, $sLN, $sOr);
        $result.="<br>";
        $result.="<br>";
        $result.="<h2>";
        $result.="Wayne County Results";
        $result.="</h2>";
        $result.= "<form id=\"download_wc\" method=\"get\" hidden=\"true\">";
        $result.= "<input id=\"download_wc_fName\" name=\"fileName\" type=\"hidden\">";
        $result.= "<input type=\"submit\" value=\"Excel Ready\">";
        $result.= "</form>";
        $result.= "<br><br>";
        $result.=TableController::getWCHtml($sFN, $sLN, $sOr);
	    return $result;
	*/
    }

    public function getFacebookHtml()
    {
	$result='';
	$s=REQUEST::post('txtF');
	$result.="<h2>";
	$result.="Timeline Results";
	$result.="</h2>";
    $result.= "<form id=\"download_message\" method=\"get\" hidden=\"true\">";
    $result.= "<input id=\"download_message_fName\" name=\"fileName\" type=\"hidden\">";
    $result.= "<input type=\"submit\" value=\"Excel Ready\">";
    $result.= "</form>";
    $result.= "<br><br>";
	$result.=TableController::getTimelineHtml($s);
	$result.="<br>";
	$result.="<br>";
	$result.="<h2>";
	$result.="Timeline Comments Results";
	$result.="</h2>";
    $result.= "<form id=\"download_comment\" method=\"get\" hidden=\"true\">";
    $result.= "<input id=\"download_comment_fName\" name=\"fileName\" type=\"hidden\">";
    $result.= "<input type=\"submit\" value=\"Excel Ready\">";
    $result.= "</form>";
    $result.= "<br><br>";
	$result.=TableController::getTimelineCommentsHtml($s);
	return $result;
    }

    public function getTwitterHtml()
    {
	    $result='';
	    $s=REQUEST::post('txtTW');
        $result.="<h2>";
        $result.="Tweets Results";
        $result.="</h2>";
        $result.= "<form id=\"download_twitter\" method=\"get\" hidden=\"true\">";
        $result.= "<input id=\"download_twitter_fName\" name=\"fileName\" type=\"hidden\">";
        $result.= "<input type=\"submit\" value=\"Excel Ready\">";
        $result.= "</form>";
        $result.= "<br><br>";
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_root_info_xnet", $username, $password); 
            $result.= "<table id=\"twitter\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	        $result.="<thead>";
            	$result.= "<tr>";
	        $result.= "<th>id</th><th>First Seen</th><th>Last Seen</th><th>Message</th><th>Tweet Handle</th><th>Is Retweet?</th><th>timestamp</th><th>Twitter Time Stamp</th><th>Retweet Amount</th><th>Favorite Amount</th>";
	        $result.="</tr>";
	        $result.="</thead>";
	        $result.="<tfoot>";
            	$result.= "<tr>";
	        $result.= "<th>id</th><th>First Seen</th><th>Last Seen</th><th>Message</th><th>Tweet Handle</th><th>Is Retweet?</th><th>timestamp</th><th>Twitter Time Stamp</th><th>Retweet Amount</th><th>Favorite Amount</th>";
	        $result.="</tr>";
	        $result.="</tfoot>";
	        $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "tw14_tweets";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,firstSeen,lastSeen,message,tweetHandle,isRetweet,timestamp,twTimeStampTweet,retweetAmount,favoriteAmount";
	        $sql_query .= " FROM ";
            	$sql_query .= $table;
            	$sql_query .= " WHERE ";
	    	$column="`message`";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $s;
	    	$sql_query .= "%'";
            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
		    for($i=0;$i<10;$i++){
                    	$result.= "<td>" .$r[$i] ."</td>";
		    }
                    $result.= "</tr>";
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
            //echo $e->getMessage();
        }
	    return $result;
    }
    public function getCRHtml($sFN, $sLN, $sOr)
    {
	$result='';
        //$sFN = REQUEST::post('txtCRFN');
        //$sLN = REQUEST::post('txtCRLN');
        //$sOr = REQUEST::post('ckCROr');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"cr\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	        $result.="<thead>";
            $result.= "<tr><th>id</th><th>Date Created</th>";
	        $result.= "<th>CRNO</th><th>CASEID</th><th>CRID</th><th>Location</th><th>B Location</th><th>Jurisdiction</th><th>Sector id</th><th>Month</th><th>Day</th><th>Year</th><th>Arrested on Char</th><th>Offense Code</th><th>Offense Category</th><th>First Name</th><th>Last Name</th><th>Race</th><th>Sex</th><th>Age</th><th>Date of Birth</th><th>Height</th><th>Weight</th><th>Address</th><th>Driver License Number</th><th>Social Security Number</th><th>Entity Id</th><th>Entity Type</th><th>XCoord</th><th>YCoord</th><th>X000CT</th><th>Custom Area</th><th>Narrative Id</th><th>Description</th><th>Occured On Char</th><th>Sequence Number</th><th>Offense CID</th><th>Arrested On</th><th>Occured On</th><th>Date of Birth Date</th><th>Phone</th><th>Business Phone</th><th>Load Date</th><th>More Info</th>";
	        $result.="</tr>";
	        $result.="</thead>";
	        $result.="<tfoot>";
            $result.= "<tr><th>id</th><th>Date Created</th>";
            $result.= "<th>CRNO</th><th>CASEID</th><th>CRID</th><th>Location</th><th>B Location</th><th>Jurisdiction</th><th>Sector id</th><th>Month</th><th>Day</th><th>Year</th><th>Arrested on Char</th><th>Offense Code</th><th>Offense Category</th><th>First Name</th><th>Last Name</th><th>Race</th><th>Sex</th><th>Age</th><th>Date of Birth</th><th>Height</th><th>Weight</th><th>Address</th><th>Driver License Number</th><th>Social Security Number</th><th>Entity Id</th><th>Entity Type</th><th>XCoord</th><th>YCoord</th><th>X000CT</th><th>Custom Area</th><th>Narrative Id</th><th>Description</th><th>Occured On Char</th><th>Sequence Number</th><th>Offense CID</th><th>Arrested On</th><th>Occured On</th><th>Date of Birth Date</th><th>Phone</th><th>Business Phone</th><th>Load Date</th><th>More Info</th>";
	        $result.="</tr>";
	        $result.="</tfoot>";
	        $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "dogmeat_update_dcc";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_created,`CRNO`,`CASEID`,`CRID`,`LOCATION`,`BLOCATION`,`JURISDICTI`,`SECTORID`,`MONTH`,`DAY`,`YEAR`,`ARRESTEDON_CHAR`,`OFFENSECOD`,`OFFENSECAT`,`FIRSTNAME`,`LASTNAME`,`RACE`,`SEX`,`AGE`,`DATEOFBIRT`,`HEIGHT`,`WEIGHT`,`ADDRESS`,`DLN`,`SSN`,`ENTITYID`,`ENTITYTYPE`,`XCOORD`,`YCOORD`,`X000CT`,`CUSTOMAREA`,`NARRATIVEID`,`DESCRIPTIO`,`OCCURREDON_CHAR`,`SEQUENCENO`,`OFFENSECID`,`ARRESTEDON`,`OCCURREDON`,`DOB_DT`,`PHONE`,`BUSINESSPHONE`,`LoadDate`";
	        $sql_query .= " FROM ";
            $sql_query .= $table;
            $sql_query .= " WHERE ";
	    if(!empty($sFN)){
	    	$column="`FIRSTNAME`";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sFN;
	    	$sql_query .= "%'";
	    }
	    if(!empty($sFN) and !empty($sLN)){
		if($sOr=='on'){
			$sql_query .= ' OR ';
		}
		else{
			$sql_query .= ' AND ';
		}
	    }
	    if(!empty($sLN)){
	    	$column="`LASTNAME`";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sLN;
	    	$sql_query .= "%'";
	    }
            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
		    for($i=0;$i<=42;$i++){
                    	$result.= "<td>" .$r[$i] ."</td>";
		    }
		    $result.= "<td><a onclick=\"window.open('" . Config::get('URL') . "table/index?crid=" . $r[32] . "','_blank');\" style=\"cursor:pointer\">Click for more info</a></td>";
                    $result.= "</tr>";
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
            //echo $e->getMessage();
        }
	    return $result;
    }

    /**
     * This method runs your search in multiple tables and returns a table
     */
    public function getTimelineHtml($s)
    {
	$result='';
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_root_info_xnet", $username, $password); 
            $result.= "<table id=\"message\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	        $result.="<thead>";
            $result.= "<tr><th>Posting Profile</th><th>Friend</th><th>Poster</th><th>PosterLink</th><th>Action</th><th>Message</th><th>PostTime_FB</th><th>PostTime</th><th>Privacy</th><th>Likes</th><th>Likers</th><th>Post Link</th><th>Comments</th><th>First Seen</th><th>Last Seen</th><th>Tag</th><th>Picture</th></tr>";
	        $result.="</thead>";
	        $result.="<tfoot>";
            $result.= "<tr><th>Posting Profile</th><th>Friend</th><th>Poster</th><th>PosterLink</th><th>Action</th><th>Message</th><th>PostTime_FB</th><th>PostTime</th><th>Privacy</th><th>Likes</th><th>Likers</th><th>Post Link</th><th>Comments</th><th>First Seen</th><th>Last Seen</th><th>Tag</th><th>Picture</th></tr>";
	        $result.="</tfoot>";
	        $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table_array = [
                'fb01_timeline',
                'fb02_timeline',
                'fb03_timeline',
                'fb04_timeline',
                'fb05_timeline',
                'fb06_timeline',
                'fb07_timeline',
                'fb08_timeline',
                'fb09_timeline',
                'fb10_timeline'
		];
            //iterates through tables, if using different structured tables we need to set up a conditional block for selecting the right query to run or we need to take pictures out of db altogether.
            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                // If searching multiple columns don't use for loop instead build union query to avoid duplicate rows.
		        $column="message";
                //Sql query to search, just don't forget to concate the strings together using .= or . 
                $sql_query = "SELECT id,postingProfile,friend,poster,posterLink,action,message,postTime_fb,postTime,privacy,likes,likers,postLink,comments,firstSeen,lastSeen,tag, (CASE WHEN picture IS NULL THEN FALSE ELSE TRUE END) AS pic, picture  FROM " . $table;
                $sql_query .= " WHERE LOWER(";
                $sql_query .= $column;
                $sql_query .= ") LIKE LOWER('%";
                $sql_query .= $s;
                $sql_query .= "%')";
                $sql_query .= " OR LOWER(poster) LIKE LOWER('%";
                $sql_query .= $s;
                $sql_query .= "%');";
                $STM2 = $dbh->prepare($sql_query);
                //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
                // bind paramenters, Named paramenters alaways start with colon(:)
                //$STM2->bindParam(':EntryBy', $EntryBy);
                // For Executing prepared statement we will use below function
                $STM2->execute();
                // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
                $STMrecords = $STM2->fetchAll();
                // We use foreach loop here to echo records.
                foreach($STMrecords as $r)
                    {
                        $result.= "<tr>";
                        //$result.= "<td>" .$r[0] ."</td>";
                        $result.= "<td>" .$r[1] ."</td>";
                        $result.= "<td>" .$r[2] ."</td>";
                        $result.= "<td>" .$r[3] ."</td>";
                        $result.= "<td>" .$r[4] ."</td>";
                        $result.= "<td>" .$r[5] ."</td>";
                        $result.= "<td>" .$r[6] ."</td>";
                        $result.= "<td>" .$r[7] ."</td>";
                        $result.= "<td>" .$r[8] ."</td>";
                        $result.= "<td>" .$r[9] ."</td>";
                        $result.= "<td>" .$r[10] ."</td>";
                        $result.= "<td>" .$r[11] ."</td>";
                        $result.= "<td>" .$r[12] ."</td>";
                        $result.= "<td>" .$r[13] ."</td>";
                        $result.= "<td>" .$r[14] ."</td>";
                        $result.= "<td>" .$r[15] ."</td>";
                        $result.= "<td>" .$r[16] ."</td>";
                        if($r[17]) {
                            $result.= "<td style=\"cursor:pointer\"><img onclick=\"window.open('" . Config::get('URL') . "table/index?fbTimelineMessageId=" . $r[0] . "&fbTable=" . $table ."','_blank');\" src=\"data:image/jpeg;base64," .base64_encode($r[18])."\" height=\"42\" width=\"42\" \/></td>";
                        } else {
                            $result.= "<td>No Picture</td>";
                        }
                        
                        $result.= "</tr>";  
                    }
            }

            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	    return $result;
    }

    public function getTimelineExcel($data) {
        //Create phpexcel obj and vars
        set_time_limit(0);
        ignore_user_abort(1);
        $objPHPExcel = new PHPExcel();
        $alphas = range('A', 'Z');
        $rows = $data['rows'];
        $table = $data['table'];
        $columnNames = $data['columns'];
        //set properties
        $objPHPExcel->getProperties()->setCreator("SkyNet");
        $objPHPExcel->getProperties()->setLastModifiedBy("SkyNet");
        $objPHPExcel->getProperties()->setTitle(" Excel");
        $objPHPExcel->getProperties()->setSubject("GangIQ Timeline Excel");
        $objPHPExcel->getProperties()->setDescription("GangIQ Timeline Excel Description");
        // get Data
        try {
            $objPHPExcel-> setActiveSheetIndex(0);
            for ($i=0; $i < sizeof($columnNames); $i++) { 
                $cellSpot = "";
                if($i>25 and $i<52) {
                    $ii = $i - 26;
                    $cellSpot = $alphas[$ii] . $alphas[$ii] . (string)(1);
                } else {
                    $cellSpot = $alphas[$i] . (string)(1);
                }
                $objPHPExcel->getActiveSheet()->SetCellValue($cellSpot, $columnNames[$i]);
            }
            for ($j=0;$j<sizeof($rows);$j++) {
                $row = $rows[$j];
                for($i = 0; $i < sizeof($row); $i++) {
                    $cellData = $row[$i];
                    $cellSpot = "";
                    if($i>25 and $i<52) {
                        $ii = $i - 26;
                        $cellSpot = ($alphas[$ii] . $alphas[$ii] . (string)($j+2));
                    } else {
                        $cellSpot = ($alphas[$i] . (string)($j+2));
                    }
                    if(substr($cellData, 1,3) === "img") {
                        $pStartStr = strrpos($cellData, 'base64,')+7;
                        $pEndStr = strrpos($cellData, 'height') - 6;
                        $pLength = $pEndStr - $pStartStr;
                        $pStr = substr($cellData, $pStartStr,$pLength);
                        $decodedImg = base64_decode($pStr);
                        $img = imagecreatefromstring($decodedImg);
                        $objPHPExcel->getActiveSheet()->getRowDimension((string)($j+2))->setRowHeight(50);
                        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
                        $objDrawing->setName('Image');
                        $objDrawing->setDescription('FB Timeline Image');
                        $objDrawing->setImageResource($img);
                        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
                        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
                        $objDrawing->setCoordinates($cellSpot);
                        $objDrawing->setHeight(50);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                    } else {
                        $objPHPExcel->getActiveSheet()->SetCellValue($cellSpot, $cellData);
                    }
                }
            }
            $objPHPExcel->getActiveSheet()->setTitle("Exported Data");
            $userId = Session::get('user_name');
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $utime = (string)time();
            $filename = "/tmp/". $userId . $utime . ".xlsx";
            $objWriter->save($filename);
            return array(
                "BtnName" => $table,
                "FileName" => ($userId . $utime . ".xlsx")
                );
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
             echo $e;
        }
    }

    /**
     * This method runs your search in multiple tables and returns a table
     */
    public function getLocationHtml()
    {
	$result='';
        $sLat = REQUEST::post('txtLat');
        $sLon = REQUEST::post('txtLon');
        $sRad = REQUEST::post('txtRad');
        $result.="<h2>";
        $result.="CRISNET Results";
        $result.="</h2>";
        $result.= "<form id=\"download_cr\" method=\"get\" hidden=\"true\">";
        $result.= "<input id=\"download_cr_fName\" name=\"fileName\" type=\"hidden\">";
        $result.= "<input type=\"submit\" value=\"Excel Ready\">";
        $result.= "</form>";
        $result.= "<br><br>";
	$dLat=($sRad/69.172);
	$dLon=($sRad/(cos($sLon)*69.172));

	$lLat=$sLat-$dLat;
	$hLat=$sLat+$dLat;
	$lLon=$sLon-$dLon;
	$hLon=$sLon+$dLon;

        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"cr\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	        $result.="<thead>";
            $result.= "<tr><th>id</th><th>Date Created</th>";
	        $result.= "<th>CRNO</th><th>CASEID</th><th>CRID</th><th>Location</th><th>B Location</th><th>Jurisdiction</th><th>Sector id</th><th>Month</th><th>Day</th><th>Year</th><th>Arrested on Char</th><th>Offense Code</th><th>Offense Category</th><th>First Name</th><th>Last Name</th><th>Race</th><th>Sex</th><th>Age</th><th>Date of Birth</th><th>Height</th><th>Weight</th><th>Address</th><th>Driver License Number</th><th>Social Security Number</th><th>Entity Id</th><th>Entity Type</th><th>XCoord</th><th>YCoord</th><th>X000CT</th><th>Custom Area</th><th>Narrative Id</th><th>Description</th><th>Occured On Char</th><th>Sequence Number</th><th>Offense CID</th><th>Arrested On</th><th>Occured On</th><th>Date of Birth Date</th><th>Phone</th><th>Business Phone</th><th>Load Date</th>";
	        $result.="</tr>";
	        $result.="</thead>";
	        $result.="<tfoot>";
            $result.= "<tr><th>id</th><th>Date Created</th>";
            $result.= "<th>CRNO</th><th>CASEID</th><th>CRID</th><th>Location</th><th>B Location</th><th>Jurisdiction</th><th>Sector id</th><th>Month</th><th>Day</th><th>Year</th><th>Arrested on Char</th><th>Offense Code</th><th>Offense Category</th><th>First Name</th><th>Last Name</th><th>Race</th><th>Sex</th><th>Age</th><th>Date of Birth</th><th>Height</th><th>Weight</th><th>Address</th><th>Driver License Number</th><th>Social Security Number</th><th>Entity Id</th><th>Entity Type</th><th>XCoord</th><th>YCoord</th><th>X000CT</th><th>Custom Area</th><th>Narrative Id</th><th>Description</th><th>Occured On Char</th><th>Sequence Number</th><th>Offense CID</th><th>Arrested On</th><th>Occured On</th><th>Date of Birth Date</th><th>Phone</th><th>Business Phone</th><th>Load Date</th>";
	        $result.="</tr>";
	        $result.="</tfoot>";
	        $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "dogmeat_update_dcc";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_created,`CRNO`,`CASEID`,`CRID`,`LOCATION`,`BLOCATION`,`JURISDICTI`,`SECTORID`,`MONTH`,`DAY`,`YEAR`,`ARRESTEDON_CHAR`,`OFFENSECOD`,`OFFENSECAT`,`FIRSTNAME`,`LASTNAME`,`RACE`,`SEX`,`AGE`,`DATEOFBIRT`,`HEIGHT`,`WEIGHT`,`ADDRESS`,`DLN`,`SSN`,`ENTITYID`,`ENTITYTYPE`,`XCOORD`,`YCOORD`,`X000CT`,`CUSTOMAREA`,`NARRATIVEID`,`DESCRIPTIO`,`OCCURREDON_CHAR`,`SEQUENCENO`,`OFFENSECID`,`ARRESTEDON`,`OCCURREDON`,`DOB_DT`,`PHONE`,`BUSINESSPHONE`,`LoadDate`";
	    $sql_query .= " FROM ";
            $sql_query .= $table;
            $sql_query .= " WHERE ";

	    $sql_query .= "(";
	    $column="`YCOORD`";
            $sql_query .= $column;
	    $sql_query .= " BETWEEN ";
            $sql_query .= $lLat;
	    $sql_query .= " AND ";
	    $sql_query .= $hLat;
	    $sql_query .= ")";

	    $sql_query .= " AND ";

	    $sql_query .= "(";
	    $column="`XCOORD`";
            $sql_query .= $column;
	    $sql_query .=" BETWEEN ";
            $sql_query .= $lLon;
	    $sql_query .= " AND ";
	    $sql_query .= $hLon;
	    $sql_query .= ")";

	    $sql_query .= ';';

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
		    for($i=0;$i<=42;$i++){
                    	$result.= "<td>" .$r[$i] ."</td>";
		    }
                    $result.= "</tr>";
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
            //echo $e->getMessage();
        }
	    return $result;

    }

    public function getFbTimelineMessagePicHtml() {
        $result='';
        $id=REQUEST::get('fbTimelineMessageId');
        $table = REQUEST::get('fbTable');
        $result.=TableController::getFbTimelineMessagePic($id, $table);
        return $result;
    }

    public function getFbTimelineMessagePic($id, $table) {
        $result = '';
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_root_info_xnet", $username, $password);
            $sql_query = "SELECT picture FROM " . $table . " WHERE id=" . $id;
            $STM2 = $dbh->prepare($sql_query);
            $STM2->execute();
            $num = $STM2->rowCount();
                if( $num ){
                    $row = $STM2->fetch(PDO::FETCH_ASSOC);
                    //header("Content-type: ".$row['type']);
                    return '<img src="data:image/jpeg;base64,' .base64_encode($row['picture']).'"/>';
                }else{
                    return null;
                }
        } 
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
        return $result;
    }

    /**
     * This method runs comments search and returns a table
     */
    public function getTimelineCommentsHtml($s)
    {
	$result='';
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_root_info_xnet", $username, $password); 
            //headers and formatting for xls - because its html excel will think its corrupted but it still works.
            $result.= "<table id=\"comment\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the excel file, this needs to be edited depending on the table.
	    $result.="<thead>";
            $result.= "<tr><th>Id</th><th>Posting Profile</th><th>Timeline Id</th><th>Name</th><th>Link</th><th>Message</th><th>PostTime_FB</th><th>PostTime</th><th>First Seen</th><th>Last Seen</th><th>Tag</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>Id</th><th>Posting Profile</th><th>Timeline Id</th><th>Name</th><th>Link</th><th>Message</th><th>PostTime_FB</th><th>PostTime</th><th>First Seen</th><th>Last Seen</th><th>Tag</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table_array = [
                'fb01_comments',
                'fb02_comments',
                'fb03_comments',
                'fb04_comments',
                'fb05_comments',
                'fb06_comments',
                'fb07_comments',
                'fb08_comments',
                'fb09_comments',
                'fb10_comments'
            ];
            //iterates through tables, if using different structured tables we need to set up a conditional block for selecting the right query to run or we need to take pictures out of db altogether.
            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                // If searching multiple columns don't use for loop instead build union query to avoid duplicate rows.
		$column="message";
                //Sql query to search, just don't forget to concontinate the strings together using .= or . 
                $sql_query = "SELECT id,postingProfile,timelineID,name,link,message,postTime_fb,postTime,firstSeen,lastSeen,tag FROM " . $table;
                $sql_query .= " WHERE LOWER(";
                $sql_query .= $column;
                $sql_query .= ") LIKE LOWER('%";
                $sql_query .= $s;
                $sql_query .= "%')";
                $sql_query .= " OR  LOWER(name) LIKE LOWER('%";
                $sql_query .= $s;
                $sql_query .= "%');";
                $STM2 = $dbh->prepare($sql_query);
                //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
                // bind paramenters, Named paramenters alaways start with colon(:)
                //$STM2->bindParam(':EntryBy', $EntryBy);
                // For Executing prepared statement we will use below function
                $STM2->execute();
                // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
                $STMrecords = $STM2->fetchAll();
                // We use foreach loop here to echo records.
                foreach($STMrecords as $r)
                    {
                        $result.= "<tr>";
                        $result.= "<td>" .$r[0] ."</td>";
                        $result.= "<td>" .$r[1] ."</td>";
                        $result.= "<td>" .$r[2] ."</td>";
                        $result.= "<td>" .$r[3] ."</td>";
                        $result.= "<td>" .$r[4] ."</td>";
                        $result.= "<td>" .$r[5] ."</td>";
                        $result.= "<td>" .$r[6] ."</td>";
                        $result.= "<td>" .$r[7] ."</td>";
                        $result.= "<td>" .$r[8] ."</td>";
                        $result.= "<td>" .$r[9] ."</td>";
                        $result.= "<td>" .$r[10] ."</td>";
                        $result.= "</tr>";
                    }
            }

            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection
            $dbh = null;
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();
	}
	return $result;
    }

    /*
    public function getMIDCCsv()
    {
        $sFN = REQUEST::post('txtMFN');
        $sLN = REQUEST::post('txtMLN');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = 'localhost';
        // mysql username
        $username = 'root';
        // mysql password
        $password = '1503vzw35';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
	    header("Content-type: application/vnd.ms-excel");
	    header("Content-Disposition: attachment;Filename=Timelines.xls");
	    echo "<html>";
	    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
	    echo "<body>";
	    echo "<table border=1>";

            echo "<tr><th>MDM Id</th><th>Date Recorded</th><th>MDOC Number</th><th>SID Number</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Race</th><th>Sex</th><th>Hair</th><th>Eyes</th><th>Height</th><th>Weight</th><th>Date of Birth</th><th>Image Date</th><th>Image URL</th><th>Image URL Local</th><th>Current Status</th><th>Assigned Location</th><th>Security Level</th><th>Date Intake</th><th>Date Discharged</th><th>Profile URL</th></tr>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "sawbones_main";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_created,mdoc_number,sid_number,full_name,last_name,first_name,middle_name,race,sex,hair,eyes,height,weight,date_of_birth,image_date,image_url,image_url_local,current_status,assigned_location,security_level,date_intake,date_discharge,profile_url FROM " . $table;
            $sql_query .= " WHERE ";
	    if(!empty($sFN)){
	    	$column="first_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sFN;
	    	$sql_query .= "%';";
	    }
	    if(!empty($sFN) and !empty($sLN)){
		$sql_query .= ' OR ';
	    }
	    if(!empty($sLN)){
	    	$column="last_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sLN;
	    	$sql_query .= "%';";
	    }

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    echo "<tr>";
                    echo "<td>" .$r[0] ."</td>";
                    echo "<td>" .$r[1] ."</td>";
                    echo "<td>" .$r[2] ."</td>";
                    echo "<td>" .$r[3] ."</td>";
                    echo "<td>" .$r[4] ."</td>";
                    echo "<td>" .$r[5] ."</td>";
                    echo "<td>" .$r[6] ."</td>";
                    echo "<td>" .$r[7] ."</td>";
                    echo "<td>" .$r[8] ."</td>";
                    echo "<td>" .$r[9] ."</td>";
                    echo "<td>" .$r[10] ."</td>";
                    echo "<td>" .$r[11] ."</td>";
                    echo "<td>" .$r[12] ."</td>";
                    echo "<td>" .$r[13] ."</td>";
                    echo "<td>" .$r[14] ."</td>";
                    echo "<td>" .$r[15] ."</td>";
                    echo "<td>" .$r[16] ."</td>";
                    echo "<td>" .$r[17] ."</td>";
                    echo "<td>" .$r[18] ."</td>";
                    echo "<td>" .$r[19] ."</td>";
                    echo "<td>" .$r[20] ."</td>";
                    echo "<td>" .$r[21] ."</td>";
                    echo "<td>" .$r[22] ."</td>";
                    echo "<td>" .$r[23] ."</td>";
                    echo "</tr>";  
                  }
	    echo "</table>";
	    echo "</body>";
	    echo "</html>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            echo $e->getMessage();    
        }
    }
     */

    public function getMIDCHtml($sFN, $sLN, $sOr)
    {
	$result='';
        //$sFN = REQUEST::post('txtMFN');
        //$sLN = REQUEST::post('txtMLN');
        //$sOr = REQUEST::post('ckMOr');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"midc\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>MDM Id</th><th>Date Created</th><th>MDOC Number</th><th>SID Number</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Race</th><th>Sex</th><th>Hair</th><th>Eyes</th><th>Height</th><th>Weight</th><th>Date of Birth</th><th>Image Date</th><th>Image URL</th><th>Current Status</th><th>Assigned Location</th><th>Security Level</th><th>Date Intake</th><th>Date Discharged</th><th>Profile URL</th><th>Picture</th><th>More info</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>MDM Id</th><th>Date Created</th><th>MDOC Number</th><th>SID Number</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Race</th><th>Sex</th><th>Hair</th><th>Eyes</th><th>Height</th><th>Weight</th><th>Date of Birth</th><th>Image Date</th><th>Image URL</th><th>Current Status</th><th>Assigned Location</th><th>Security Level</th><th>Date Intake</th><th>Date Discharged</th><th>Profile URL</th><th>Picture</th><th>More info</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "sawbones_main";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_created,mdoc_number,sid_number,full_name,last_name,first_name,middle_name,race,sex,hair,eyes,height,weight,date_of_birth,image_date,image_url,current_status,assigned_location,security_level,date_intake,date_discharge,profile_url, (CASE WHEN picture IS NULL THEN FALSE ELSE TRUE END) AS pic, picture FROM ";
            $sql_query .= $table;
            $sql_query .= " WHERE ";
	    if(!empty($sFN)){
	    	$column="first_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sFN;
	    	$sql_query .= "%'";
	    }
	    if(!empty($sFN) and !empty($sLN)){
		if($sOr=='on'){
			$sql_query .= ' OR ';
		}
		else{
			$sql_query .= ' AND ';
		}
	    }
	    if(!empty($sLN)){
	    	$column="last_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sLN;
	    	$sql_query .= "%'";
	    }
            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "<td>" .$r[8] ."</td>";
                    $result.= "<td>" .$r[9] ."</td>";
                    $result.= "<td>" .$r[10] ."</td>";
                    $result.= "<td>" .$r[11] ."</td>";
                    $result.= "<td>" .$r[12] ."</td>";
                    $result.= "<td>" .$r[13] ."</td>";
                    $result.= "<td>" .$r[14] ."</td>";
                    $result.= "<td>" .$r[15] ."</td>";
                    $result.= "<td>" .$r[16] ."</td>";
                    $result.= "<td>" .$r[17] ."</td>";
                    $result.= "<td>" .$r[18] ."</td>";
                    $result.= "<td>" .$r[19] ."</td>";
                    $result.= "<td>" .$r[20] ."</td>";
                    $result.= "<td>" .$r[21] ."</td>";
                    $result.= "<td>" .$r[22] ."</td>";
                    if($r[23]) {
                        $result.= "<td style=\"cursor:pointer\"><img onclick=\"window.open('" . Config::get('URL') . "table/index?picmidcid=" . $r[0] ."','_blank');\" src=\"data:image/jpeg;base64," .base64_encode($r[24])."\" height=\"42\" width=\"42\" \/></td>";
                    } else {
                        $result.= "<td>No Picture</td>";
                    }
                    $result.= "<td><a onclick=\"window.open('" . Config::get('URL') . "table/index?midcid=" . $r[0] . "','_blank');\" style=\"cursor:pointer\">Click for more info</a></td>";
                    $result.= "</tr>";
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
            //echo $e->getMessage();
        }
	    return $result;
    }

    public function getMIDCIdPicHtml() {
        $result='';
        $id=REQUEST::get('picmidcid');
        $result.=TableController::getMIDCdPic($id);
	$result.=TableController::getMIDCInfo($id);
        return $result;
    }

    public function getMIDCdPic($id) {
        $result = '';
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password);
            $table = "sawbones_main";
            $sql_query = "SELECT picture FROM " . $table . " WHERE id=" . $id;
            $STM2 = $dbh->prepare($sql_query);
            $STM2->execute();
            $num = $STM2->rowCount();
                if( $num ){
                    $row = $STM2->fetch(PDO::FETCH_ASSOC);
                    //header("Content-type: ".$row['type']);
                    //return '<img src="data:image/jpeg;base64,' .base64_encode($row['picture']).'"/>';
                    $result.= '<img src="data:image/jpeg;base64,' .base64_encode($row['picture']).'"/>';
		    $result.='<br>';
                }else{
                    return null;
                }
        } 
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
        return $result;
    }

    public function getMIDCInfo($id){
        $result = '';
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password);
            $table = "sawbones_main";
            $sql_query = "SELECT sid_number,full_name,date_of_birth,current_status,date_intake,date_discharge FROM " . $table . " WHERE id=" . $id;
            $STM2 = $dbh->prepare($sql_query);
            $STM2->execute();
            $STMrecords = $STM2->fetchAll();
	    $result.='SID Number:' . $STMrecords[0][0];
	    $result.='<br>';
	    $result.='Full Name:' . $STMrecords[0][1];
	    $result.='<br>';
	    $result.='Date Of Birth:' . $STMrecords[0][2];
	    $result.='<br>';
	    $result.='Current Status:' . $STMrecords[0][3];
	    $result.='<br>';
	    $result.='Intake Date:' . $STMrecords[0][4];
	    $result.='<br>';
	    $result.='Discharge Date:' . $STMrecords[0][5];
	    $result.='<br>';
        }
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
        return $result;
    }

    public function getCRIdHtml()
    {
	$result='';
	$id=REQUEST::get('crid');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"crnotes\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>id</th><th>date_created</th><th>NODESID</th><th>NOTES</th><th>LoadDate</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>id</th><th>date_created</th><th>NODESID</th><th>NOTES</th><th>LoadDate</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "dogmeat_update_notes";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,`date_created`,NOTESID,NOTES,LoadDate FROM " . $table;
            $sql_query .= " WHERE ";
	    $column="NOTESID";
            $sql_query .= $column;
            $sql_query .= '=';
            $sql_query .= $id;

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
    }

    public function getMIDCIdHtml()
    {
	    $id=REQUEST::get('midcid');
	    $result='';
	    $result.="<h2>";
	    $result.="Offenses Results";
	    $result.="</h2>";
	    $result.=TableController::getMIDCSentencesHtml($id);
	    $result.="<br>";
	    $result.="<br>";
	    $result.="<h2>";
	    $result.="Marks Results";
	    $result.="</h2>";
	    $result.=TableController::getMIDCMarksHtml($id);
	    $result.="<br>";
	    $result.="<br>";
	    $result.="<h2>";
	    $result.="Aliases Results";
	    $result.="</h2>";
	    $result.=TableController::getMIDCAliasesHtml($id);
	    return $result;
    }

    public function getMIDCSentencesHtml($id)
    {
	$result='';
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"midcsentences\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>Date Recorded</th><th>Type</th><th>Offense</th><th>MCL Number</th><th>Court File Number</th><th>County</th><th>Conviction Type</th><th>Min Sentence</th><th>Max Sentence</th><th>Date of Offense</th><th>Discharge Date</th><th>Discharge Reason</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>Date Recorded</th><th>Type</th><th>Offense</th><th>MCL Number</th><th>Court File Number</th><th>County</th><th>Conviction Type</th><th>Min Sentence</th><th>Max Sentence</th><th>Date of Offense</th><th>Discharge Date</th><th>Discharge Reason</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "sawbones_sentences";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT date_created,type,offense,mcl_number,court_file_number,county,conviction_type,min_sentence,max_sentence,date_of_offense,discharge_date,discharge_reason FROM " . $table;
            $sql_query .= " WHERE ";
	    $column="sawbones_main_id";
            $sql_query .= $column;
            $sql_query .= '=';
            $sql_query .= $id;

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "<td>" .$r[8] ."</td>";
                    $result.= "<td>" .$r[9] ."</td>";
                    $result.= "<td>" .$r[10] ."</td>";
                    $result.= "<td>" .$r[11] ."</td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
    }

    public function getMIDCMarksHtml($id)
    {
	$result='';
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"midcmarks\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>Mark</th><th>Date Created</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>Mark</th><th>Date Created</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "sawbones_marks";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT mark,date_created FROM " . $table;
            $sql_query .= " WHERE ";
	    $column="sawbones_main_id";
            $sql_query .= $column;
            $sql_query .= '=';
            $sql_query .= $id;

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
    }

    public function getMIDCAliasesHtml($id)
    {
	$result='';
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"midcaliases\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>Alias</th><th>Date Recorded</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>Alias</th><th>Date Recorded</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "sawbones_aliases";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT alias,date_created FROM " . $table;
            $sql_query .= " WHERE ";
	    $column="sawbones_main_id";
            $sql_query .= $column;
            $sql_query .= '=';
            $sql_query .= $id;

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
    }

    /*
    public function getMCCsv()
    {
        $sFN = REQUEST::post('txtMCFN');
        $sLN = REQUEST::post('txtMCLN');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = 'localhost';
        // mysql username
        $username = 'root';
        // mysql password
        $password = '1503vzw35';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
	    header("Content-type: application/vnd.ms-excel");
	    header("Content-Disposition: attachment;Filename=Timelines.xls");
	    echo "<html>";
	    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
	    echo "<body>";
	    echo "<table border=1>";

            echo "<tr><th>CMJ Id</th><th>Date Recorded</th><th>Inmate Number</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Sex</th><th>Date of Birth</th><th>Date Intake</th><th>Image URL</th><th>Image URL Local</th><th>Profile URL</th></tr>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "blinddiodejefferson_main";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT cmj_id,date_recorded,inmate_number,full_name,last_name,first_name,middle_name,sex,date_of_birth,date_intake,image_url,image_url_local,profile_url FROM " . $table;
            $sql_query .= " WHERE ";
	    if(!empty($sFN)){
	    	$column="first_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sFN;
	    	$sql_query .= "%';";
	    }
	    if(!empty($sFN) and !empty($sLN)){
		$sql_query .= ' OR ';
	    }
	    if(!empty($sLN)){
	    	$column="last_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sLN;
	    	$sql_query .= "%';";
	    }

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    echo "<tr>";
                    echo "<td>" .$r[0] ."</td>";
                    echo "<td>" .$r[1] ."</td>";
                    echo "<td>" .$r[2] ."</td>";
                    echo "<td>" .$r[3] ."</td>";
                    echo "<td>" .$r[4] ."</td>";
                    echo "<td>" .$r[5] ."</td>";
                    echo "<td>" .$r[6] ."</td>";
                    echo "<td>" .$r[7] ."</td>";
                    echo "<td>" .$r[8] ."</td>";
                    echo "<td>" .$r[9] ."</td>";
                    echo "<td>" .$r[10] ."</td>";
                    echo "<td>" .$r[11] ."</td>";
                    echo "<td>" .$r[12] ."</td>";
                    echo "</tr>";  
                  }
	    echo "</table>";
	    echo "</body>";
	    echo "</html>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            echo $e->getMessage();    
        }
    }
     */

    public function getMCHtml($sFN, $sLN, $sOr)
    {
	$result='';
        //$sFN = REQUEST::post('txtMCFN');
        //$sLN = REQUEST::post('txtMCLN');
        //$sOr = REQUEST::post('ckMCOr');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"mc\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>CMJ Id</th><th>Date Recorded</th><th>Inmate Number</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Sex</th><th>Date of Birth</th><th>Date Intake</th><th>Image URL</th><th>Image URL Local</th><th>Profile URL</th><th>Picture</th><th>More info</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>CMJ Id</th><th>Date Recorded</th><th>Inmate Number</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Sex</th><th>Date of Birth</th><th>Date Intake</th><th>Image URL</th><th>Image URL Local</th><th>Profile URL</th><th>Picture</th><th>More info</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "blinddiodejefferson_main";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT cmj_id,date_recorded,inmate_number,full_name,last_name,first_name,middle_name,sex,date_of_birth,date_intake,image_url,image_url_local,profile_url, (CASE WHEN picture IS NULL THEN FALSE ELSE TRUE END) AS pic, picture FROM " . $table;
            $sql_query .= " WHERE ";
	    if(!empty($sFN)){
	    	$column="first_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sFN;
	    	$sql_query .= "%'";
	    }
	    if(!empty($sFN) and !empty($sLN)){
		if($sOr=='on'){
			$sql_query .= ' OR ';
		    }
		    else{
			$sql_query .= ' AND ';
		    }
	    }
	    if(!empty($sLN)){
	    	$column="last_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sLN;
	    	$sql_query .= "%'";
	    }

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
		    //$result.= "<tr onclick=\"window.open('" . Config::get('URL') . "table/index?mcid=" . $r[0] . "','_blank');\" style=\"cursor:pointer\" >";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "<td>" .$r[8] ."</td>";
                    $result.= "<td>" .$r[9] ."</td>";
                    $result.= "<td>" .$r[10] ."</td>";
                    $result.= "<td>" .$r[11] ."</td>";
                    $result.= "<td>" .$r[12] ."</td>";
                    if($r[13]) {
                        $result.= "<td style=\"cursor:pointer\"><img onclick=\"window.open('" . Config::get('URL') . "table/index?picmcid=" . $r[0] ."','_blank');\" src=\"data:image/jpeg;base64," .base64_encode($r[14])."\" height=\"42\" width=\"42\" \/></td>";
                    } else {
                        $result.= "<td>No Picture</td>";
                    }
		            $result.= "<td><a onclick=\"window.open('" . Config::get('URL') . "table/index?mcid=" . $r[0] . "','_blank');\" style=\"cursor:pointer\">Click for more info</a></td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
    }

    public function getMCIdPicHtml() {
        $result='';
        $id=REQUEST::get('picmcid');
        $result.=TableController::getMCIdPic($id);
	$result.=TableController::getMCIdInfo($id);
        return $result;
    }

    public function getMCIdPic($id) {
        $result = '';
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password);
            $table = "blinddiodejefferson_main";
            $sql_query = "SELECT picture FROM " . $table . " WHERE id=" . $id;
            $STM2 = $dbh->prepare($sql_query);
            $STM2->execute();
            $num = $STM2->rowCount();
                if( $num ){
                    $row = $STM2->fetch(PDO::FETCH_ASSOC);
                    //header("Content-type: ".$row['type']);
                    //return '<img src="data:image/jpeg;base64,' .base64_encode($row['picture']).'"/>';
                    $result.= '<img src="data:image/jpeg;base64,' .base64_encode($row['picture']).'"/>';
		    $result.='<br>';
                }else{
                    return null;
                }
        } 
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
        return $result;
    }

    public function getMCInfo($id){
        $result = '';
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password);
            $table = "blinddiodejefferson_main";
            $sql_query = "SELECT cmj_number,full_name,date_of_birth,date_intake FROM " . $table . " WHERE id=" . $id;
            $STM2 = $dbh->prepare($sql_query);
            $STM2->execute();
            $STMrecords = $STM2->fetchAll();
	    $result.='CMJ Number:' . $STMrecords[0][0];
	    $result.='<br>';
	    $result.='Full Name:' . $STMrecords[0][1];
	    $result.='<br>';
	    $result.='Date Of Birth:' . $STMrecords[0][2];
	    $result.='<br>';
	    $result.='Intake Date:' . $STMrecords[0][4];
	    $result.='<br>';
        }
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
        return $result;
    }

    public function getMCIdHtml()
    {
	    $result='';
	    $id=REQUEST::get('mcid');
	    $result.="<h2>";
	    $result.="Sentences Results";
	    $result.="</h2>";
	    $result.=TableController::getMCSentencesHtml($id);
	    $result.="<br>";
	    $result.="<br>";
	    $result.="<h2>";
	    $result.="Aliases Results";
	    $result.="</h2>";
	    $result.=TableController::getMCAliasesHtml($id);
	    return $result;
    }

    public function getMCSentencesHtml($id)
    {
	$result='';
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"mcsentences\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>CMJA ID</th><th>CMJ ID</th><th>Date Recorded</th><th>Type</th><th>Offense</th><th>Court File Number</th><th>Court Name</th><th>Arresting Agency</th><th>Date Intake</th><th>Discharge Date</th><th>Bail</th><th>Bail Ten Percent</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>CMJA ID</th><th>CMJ ID</th><th>Date Recorded</th><th>Type</th><th>Offense</th><th>Court File Number</th><th>Court Name</th><th>Arresting Agency</th><th>Date Intake</th><th>Discharge Date</th><th>Bail</th><th>Bail Ten Percent</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "blinddiodejefferson_sentences";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT cmjs_id,cmj_id,date_recorded,type,offense,court_file_number,court_name,arresting_agency,date_intake,discharge_date,bail,bail_10_percent FROM " . $table;
            $sql_query .= " WHERE ";
	    $column="cmj_id";
            $sql_query .= $column;
            $sql_query .= '=';
            $sql_query .= $id;

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "<td>" .$r[8] ."</td>";
                    $result.= "<td>" .$r[9] ."</td>";
                    $result.= "<td>" .$r[10] ."</td>";
                    $result.= "<td>" .$r[11] ."</td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
    }

    public function getMCAliasesHtml($id)
    {
	$result='';
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"mcaliases\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>CMJA ID</th><th>CMJ ID</th><th>Date Recorded</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Suffix</th><th>Date of Birth</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>CMJA ID</th><th>CMJ ID</th><th>Date Recorded</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Suffix</th><th>Date of Birth</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "blinddiodejefferson_aliases";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT cmja_id,cmj_id,date_recorded,first_name,middle_name,last_name,suffix,date_of_birth  FROM " . $table;
            $sql_query .= " WHERE ";
	    $column="cmj_id";
            $sql_query .= $column;
            $sql_query .= '=';
            $sql_query .= $id;

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
    }

    public function getOCHtml($sFN, $sLN, $sOr)
    {
	$result='';

        //$sFN = REQUEST::post('txtOCFN');
        //$sLN = REQUEST::post('txtOCLN');
        //$sOr = REQUEST::post('ckOCOr');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"oc\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>ID</th><th>Date Created</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Inmate ID</th><th>Date Booked</th><th>Date of Birth</th><th>Sex</th><th>Jail Location</th><th>Bond</th><th>Date Lastseen</th><th>More info</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>ID</th><th>Date Created</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Inmate ID</th><th>Date Booked</th><th>Date of Birth</th><th>Sex</th><th>Jail Location</th><th>Bond</th><th>Date Lastseen</th><th>More info</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "ironbelly_booked";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_created,name_full,name_last,name_first,name_middle,inmate_id,date_booked,date_ob,sex,jail_loc,bond,date_lastseen FROM ";
            $sql_query .= $table;
            $sql_query .= " WHERE ";
	    if(!empty($sFN)){
	    	$column="name_first";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sFN;
	    	$sql_query .= "%'";
	    }
	    if(!empty($sFN) and !empty($sLN)){
		if($sOr=='on'){
			$sql_query .= ' OR ';
		}
		else{
			$sql_query .= ' AND ';
		}
	    }
	    if(!empty($sLN)){
	    	$column="name_last";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sLN;
	    	$sql_query .= "%'";
	    }
            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "<td>" .$r[8] ."</td>";
                    $result.= "<td>" .$r[9] ."</td>";
                    $result.= "<td>" .$r[10] ."</td>";
                    $result.= "<td>" .$r[11] ."</td>";
                    $result.= "<td>" .$r[12] ."</td>";
                    $result.= "<td><a onclick=\"window.open('" . Config::get('URL') . "table/index?ocid=" . $r[0] . "','_blank');\" style=\"cursor:pointer\">Click for more info</a></td>";
                    $result.= "</tr>";
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
            //echo $e->getMessage();
        }
	    return $result;
    }

    public function getWCHtml($sFN, $sLN, $sOr)
    {
        //change table
    $result='';

        //$sFN = REQUEST::post('txtOCFN');
        //$sLN = REQUEST::post('txtOCLN');
        //$sOr = REQUEST::post('ckOCOr');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"wc\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
        $result.="<thead>";
            $result.= "<tr><th>ID</th><th>Date Created</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Inmate ID</th><th>Date Booked</th><th>Date of Birth</th><th>Sex</th><th>Jail Location</th><th>Bond</th><th>Date Lastseen</th><th>More info</th></tr>";
        $result.="</thead>";
        $result.="<tfoot>";
            $result.= "<tr><th>ID</th><th>Date Created</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Inmate ID</th><th>Date Booked</th><th>Date of Birth</th><th>Sex</th><th>Jail Location</th><th>Bond</th><th>Date Lastseen</th><th>More info</th></tr>";
        $result.="</tfoot>";
        $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "ironbelly_booked";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_created,name_full,name_last,name_first,name_middle,inmate_id,date_booked,date_ob,sex,jail_loc,bond,date_lastseen FROM ";
            $sql_query .= $table;
            $sql_query .= " WHERE ";
        if(!empty($sFN)){
            $column="name_first";
                $sql_query .= $column;
                $sql_query .= " LIKE '%";
                $sql_query .= $sFN;
            $sql_query .= "%'";
        }
        if(!empty($sFN) and !empty($sLN)){
        if($sOr=='on'){
            $sql_query .= ' OR ';
        }
        else{
            $sql_query .= ' AND ';
        }
        }
        if(!empty($sLN)){
            $column="name_last";
                $sql_query .= $column;
                $sql_query .= " LIKE '%";
                $sql_query .= $sLN;
            $sql_query .= "%'";
        }
            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            //$STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
        foreach($STMrecords as $r)
                {
            $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "<td>" .$r[8] ."</td>";
                    $result.= "<td>" .$r[9] ."</td>";
                    $result.= "<td>" .$r[10] ."</td>";
                    $result.= "<td>" .$r[11] ."</td>";
                    $result.= "<td>" .$r[12] ."</td>";
                    $result.= "<td><a onclick=\"window.open('" . Config::get('URL') . "table/index?ocid=" . $r[0] . "','_blank');\" style=\"cursor:pointer\">Click for more info</a></td>";
                    $result.= "</tr>";
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
            //echo $e->getMessage();
        }
        return $result;
    }

    /*
    public function getOCsv()
    {
	//not done because we do not need it
        $sFN = REQUEST::post('txtMFN');
        $sLN = REQUEST::post('txtMLN');
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = 'localhost';
        // mysql username
        $username = 'root';
        // mysql password
        $password = '1503vzw35';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
	    header("Content-type: application/vnd.ms-excel");
	    header("Content-Disposition: attachment;Filename=Timelines.xls");
	    echo "<html>";
	    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
	    echo "<body>";
	    echo "<table border=1>";

            echo "<tr><th>MDM Id</th><th>Date Recorded</th><th>MDOC Number</th><th>SID Number</th><th>Full Name</th><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Race</th><th>Sex</th><th>Hair</th><th>Eyes</th><th>Height</th><th>Weight</th><th>Date of Birth</th><th>Image Date</th><th>Image URL</th><th>Image URL Local</th><th>Current Status</th><th>Assigned Location</th><th>Security Level</th><th>Date Intake</th><th>Date Discharged</th><th>Profile URL</th></tr>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "sawbones_main";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_created,mdoc_number,sid_number,full_name,last_name,first_name,middle_name,race,sex,hair,eyes,height,weight,date_of_birth,image_date,image_url,image_url_local,current_status,assigned_location,security_level,date_intake,date_discharge,profile_url FROM " . $table;
            $sql_query .= " WHERE ";
	    if(!empty($sFN)){
	    	$column="first_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sFN;
	    	$sql_query .= "%';";
	    }
	    if(!empty($sFN) and !empty($sLN)){
		$sql_query .= ' OR ';
	    }
	    if(!empty($sLN)){
	    	$column="last_name";
            	$sql_query .= $column;
            	$sql_query .= " LIKE '%";
            	$sql_query .= $sLN;
	    	$sql_query .= "%';";
	    }

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    echo "<tr>";
                    echo "<td>" .$r[0] ."</td>";
                    echo "<td>" .$r[1] ."</td>";
                    echo "<td>" .$r[2] ."</td>";
                    echo "<td>" .$r[3] ."</td>";
                    echo "<td>" .$r[4] ."</td>";
                    echo "<td>" .$r[5] ."</td>";
                    echo "<td>" .$r[6] ."</td>";
                    echo "<td>" .$r[7] ."</td>";
                    echo "<td>" .$r[8] ."</td>";
                    echo "<td>" .$r[9] ."</td>";
                    echo "<td>" .$r[10] ."</td>";
                    echo "<td>" .$r[11] ."</td>";
                    echo "<td>" .$r[12] ."</td>";
                    echo "<td>" .$r[13] ."</td>";
                    echo "<td>" .$r[14] ."</td>";
                    echo "<td>" .$r[15] ."</td>";
                    echo "<td>" .$r[16] ."</td>";
                    echo "<td>" .$r[17] ."</td>";
                    echo "<td>" .$r[18] ."</td>";
                    echo "<td>" .$r[19] ."</td>";
                    echo "<td>" .$r[20] ."</td>";
                    echo "<td>" .$r[21] ."</td>";
                    echo "<td>" .$r[22] ."</td>";
                    echo "<td>" .$r[23] ."</td>";
                    echo "</tr>";  
                  }
	    echo "</table>";
	    echo "</body>";
	    echo "</html>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            echo $e->getMessage();    
        }
    }
     */

    public function getOCIdHtml()
    {
	    $result='';
	    $id=REQUEST::get('ocid');
	    $result.="<h2>";
	    $result.="Released Results";
	    $result.="</h2>";
	    $result.=TableController::getOCReleasedHtml($id);
	    return $result;
    }

    public function getOCReleasedHtml($id)
    {
	$result='';
        
        // Time limit to 0 for exporting big records.
        set_time_limit(0); 
        // mysql hostname
        $hostname = '10.10.3.21';
        // mysql username
        $username = 'root';
        // mysql password
        $password = 'mysq1024!)@$ME$E';
        // Database Connection using PDO with try catch method. 
        try { 
            $dbh = new PDO("mysql:host=$hostname;dbname=xnet_node_xnet", $username, $password); 
            $result.= "<table id=\"ocreleased\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
            // This is for the first line in the table, this needs to be edited depending on the db table.
	    $result.="<thead>";
            $result.= "<tr><th>id</th><th>date_created</th><th>name_full</th><th>name_last</th><th>name_first</th><th>name_middle</th><th>inmate_id</th><th>date_booked</th><th>date_ob</th><th>sex</th><th>date_released</th><th>date_lastseen</th></tr>";
	    $result.="</thead>";
	    $result.="<tfoot>";
            $result.= "<tr><th>id</th><th>date_created</th><th>name_full</th><th>name_last</th><th>name_first</th><th>name_middle</th><th>inmate_id</th><th>date_booked</th><th>date_ob</th><th>sex</th><th>date_released</th><th>date_lastseen</th></tr>";
	    $result.="</tfoot>";
	    $result.="<tbody>";
            // We will assign variable here for entry By. you can use your variables here.
            //$EntryBy = $_GET[val];
            // Get data using PDO prepare Query.
            $table = "ironbelly_released";
            //Sql query to search, just don't forget to concate the strings together using .= or . 
            $sql_query = "SELECT id,date_created,name_full,name_last,name_first,name_middle,inmate_id,date_booked,date_ob,sex,date_released,date_lastseen FROM " . $table;
            $sql_query .= " WHERE ";
	    $column="inmate_id";
            $sql_query .= $column;
            $sql_query .= '=';
            $sql_query .= $id;

            $STM2 = $dbh->prepare($sql_query);
            //$STM2 = $dbh->prepare("SELECT `id`, `postingProfile`, `friend`, `poster`, `posterLink`, `action`, `message`, `postTime_fb`, `postTime`, `privacy`, `likes`, `likers`, `postLink`, `comments`, `firstSeen`, `lastSeen` FROM  WHERE EntryBy = :EntryBy ORDER BY SrNo");
            // bind paramenters, Named paramenters alaways start with colon(:)
            //$STM2->bindParam(':EntryBy', $EntryBy);
            // For Executing prepared statement we will use below function
            $STM2->execute();
            // We will fetch records like this and use foreach loop to show multiple Results later in bottom of the page.
            $STMrecords = $STM2->fetchAll();
            // We use foreach loop here to echo records.
		foreach($STMrecords as $r)
                {
		    $result.= "<tr>";
                    $result.= "<td>" .$r[0] ."</td>";
                    $result.= "<td>" .$r[1] ."</td>";
                    $result.= "<td>" .$r[2] ."</td>";
                    $result.= "<td>" .$r[3] ."</td>";
                    $result.= "<td>" .$r[4] ."</td>";
                    $result.= "<td>" .$r[5] ."</td>";
                    $result.= "<td>" .$r[6] ."</td>";
                    $result.= "<td>" .$r[7] ."</td>";
                    $result.= "<td>" .$r[8] ."</td>";
                    $result.= "<td>" .$r[9] ."</td>";
                    $result.= "<td>" .$r[10] ."</td>";
                    $result.= "<td>" .$r[11] ."</td>";
                    $result.= "</tr>";  
                  }
            $result.= "</tbody>";
            $result.= "</table>";
            // Closing MySQL database connection   
            $dbh = null;    
        }
        // In case of error PDO exception will show error message.
        catch(PDOException $e) {    
            $result.= $e->getMessage();    
        }
	return $result;
    }


}
