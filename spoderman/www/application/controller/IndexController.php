<?php

/**
 * This controller shows an area that's only visible for logged in users (because of Auth::checkAuthentication(); in line 16)
 */
class IndexController extends Controller
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
        $commentcount=IndexController::getCommentRowCount();
        $timelinecount=IndexController::getTimelineRowCount();
        $midccount=IndexController::getMidcRowCount();
	   $twittercount=IndexController::getTwitterRowCount();
	   $macombjailcount=IndexController::getMacombJailRowCount();
	   $oaklandjailcount=IndexController::getOaklandJailRowCount();
	   $waynejailcount=IndexController::getWayneJailRowCount();
	   $crisnetcount=IndexController::getCrisnetRowCount();
        $this->View->render('index/index', array(
            'commentcount' => $commentcount,
            'timelinecount' => $timelinecount,
	    'midccount' => $midccount,
	    'twittercount' => $twittercount,
	    'macombjailcount' => $macombjailcount,
	    'oaklandjailcount' => $oaklandjailcount,
	    //'waynejailcount' => $waynejailcount,
	    'waynejailcount' => number_format(3017),
	    'crisnetcount' => $crisnetcount
        ));
    }

    /**
    * This method gets Comment rowcounts
    */
    public function getCommentRowCount() 
    {
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

            $sumrows = 0;

            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                $sql_query = "SELECT COUNT(id) FROM ";
                $sql_query .= $table;
                $STM2 = $dbh->prepare($sql_query);
                $STM2->execute();
                $res = $STM2->fetchAll();
                foreach ($res as $r) {
                    $sumrows += (int)$r[0];
                }
            }

            return number_format($sumrows);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
    * This method gets rowcounts
    */
    public function getTimelineRowCount() 
    {
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

            $sumrows = 0;

            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                $sql_query = "SELECT COUNT(id) FROM ";
                $sql_query .= $table;
                $STM2 = $dbh->prepare($sql_query);
                $STM2->execute();
                $res = $STM2->fetchAll();
                foreach ($res as $r) {
                    $sumrows += (int)$r[0];
                }
            }

            return number_format($sumrows);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
    * This method gets rowcounts
    */
    public function getMidcRowCount() 
    {
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
            
            $table_array = [
                'sawbones_aliases',
                'sawbones_main',
                'sawbones_marks',
                'sawbones_sentences'
            ]; 

            $sumrows = 0;

            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                $sql_query = "SELECT COUNT(id) FROM ";
                $sql_query .= $table;
                $STM2 = $dbh->prepare($sql_query);
                $STM2->execute();
                $res = $STM2->fetchAll();
                foreach ($res as $r) {
                    $sumrows += (int)$r[0];
                }
            }

            return number_format($sumrows);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
    * This method gets rowcounts
    */
    public function getTwitterRowCount() 
    {
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
            
            $table_array = [
                'tw14_catfish',
                'tw14_catfish_bak',
                'tw14_cat_followers',
                'tw14_comments',
                'tw14_favoriters',
                'tw14_followers',
                'tw14_followings',
                'tw14_member_of_list',
                'tw14_retweeters',
                'tw14_subscribed_to_list',
                'tw14_tweets',
                'tw14_tweet_favorites',
            ]; 

            $sumrows = 0;

            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                $sql_query = "SELECT COUNT(id) FROM ";
                $sql_query .= $table;
                $STM2 = $dbh->prepare($sql_query);
                $STM2->execute();
                $res = $STM2->fetchAll();
                foreach ($res as $r) {
                    $sumrows += (int)$r[0];
                }
            }

            return number_format($sumrows);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
    * This method gets rowcounts
    */
    public function getMacombJailRowCount() 
    {
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
            
            $table_array = [
                'blinddiodejefferson_aliases',
                'blinddiodejefferson_main',
                'blinddiodejefferson_sentences'
            ]; 

            $sumrows = 0;

            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                $sql_query = "SELECT COUNT(date_recorded) FROM ";
                $sql_query .= $table;
                $STM2 = $dbh->prepare($sql_query);
                $STM2->execute();
                $res = $STM2->fetchAll();
                foreach ($res as $r) {
                    $sumrows += (int)$r[0];
                }
            }

            return number_format($sumrows);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
    * This method gets rowcounts
    */
    public function getOaklandJailRowCount() 
    {
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
            
            $table_array = [
                'ironbelly_booked',
                'ironbelly_main',
                'ironbelly_released',
                'ironbelly_sentences'
            ]; 

            $sumrows = 0;

            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                $sql_query = "SELECT COUNT(id) FROM ";
                $sql_query .= $table;
                $STM2 = $dbh->prepare($sql_query);
                $STM2->execute();
                $res = $STM2->fetchAll();
                foreach ($res as $r) {
                    $sumrows += (int)$r[0];
                }
            }

            return number_format($sumrows);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
    * This method gets rowcounts
    */
    public function getWayneJailRowCount() 
    {
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
            
            $table_array = [
                'midc_oakland_main'
            ]; 

            $sumrows = 0;

            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                $sql_query = "SELECT COUNT(id) FROM ";
                $sql_query .= $table;
                $STM2 = $dbh->prepare($sql_query);
                $STM2->execute();
                $res = $STM2->fetchAll();
                foreach ($res as $r) {
                    $sumrows += (int)$r[0];
                }
            }

            return number_format($sumrows);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
    * This method gets rowcounts
    */
    public function getCrisnetRowCount() 
    {
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
            
            $table_array = [
                'dogmeat_update_dcc',
                'dogmeat_update_notes'
            ]; 

            $sumrows = 0;

            for($i = 0; $i < count($table_array); ++$i) {
                $table = $table_array[$i];
                $sql_query = "SELECT COUNT(id) FROM ";
                $sql_query .= $table;
                $STM2 = $dbh->prepare($sql_query);
                $STM2->execute();
                $res = $STM2->fetchAll();
                foreach ($res as $r) {
                    $sumrows += (int)$r[0];
                }
            }

            return number_format($sumrows);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * This method runs comments search and exports a xls.
     */
    public function getTimelineCommentsCsv() 
    {
        $search = REQUEST::post('searchtc_text');
        
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
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;Filename=Timeline-Comments.xls");
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
                $column = 'message';
                //Sql query to search, just don't forget to concontinate the strings together using .= or . 
                $sql_query = "SELECT id,postingProfile,timelineID,name,link,message,postTime_fb,postTime,firstSeen,lastSeen,tag FROM " . $table;
                $sql_query .= " WHERE ";
                $sql_query .= $column;
                $sql_query .= " LIKE '%";
                $sql_query .= $search;
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

    /**
     * This method runs your search in multiple tables and exports a xls.
     */
    public function getTimelineCsv() 
    {
        $search = REQUEST::post('searchtm_text');
        
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
                $column = 'message';
                //Sql query to search, just don't forget to concate the strings together using .= or . 
                $sql_query = "SELECT id,postingProfile,friend,poster,posterLink,action,message,postTime_fb,postTime,privacy,likes,likers,postLink,comments,firstSeen,lastSeen,tag FROM " . $table;
                $sql_query .= " WHERE ";
                $sql_query .= $column;
                $sql_query .= " LIKE '%";
                $sql_query .= $search;
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
}
