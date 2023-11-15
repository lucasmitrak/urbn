<?php

class SchedualerController extends Controller
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
        $scheduled = SchedualerController::getSchedule();
        $schedule = SchedualerController::formatSchedule($scheduled);
        $this->View->render('schedualer/index', array('schedule' => $schedule));
    }

    public function getSchedule()
    {
        $database = DatabaseFactory::getFactory()->getXnetNodeRootConnection();
        //TODO: Set up to get node id from node_list table
        //TODO: Set up future tasks via frequency column, repeat
        $sql = "SELECT `node_list_id`,
                       `script`,
                       `repeat`,
                       `repeat_frequency`,
                       CASE WHEN `date_last_run` > 0 THEN `date_last_run`
                            ELSE `date_start` END AS `date_start`, 
                       CASE WHEN `date_last_success` > 0 THEN `date_last_success` 
                            WHEN `date_last_error` > 0 THEN `date_last_error`
                            WHEN `date_last_run` > 0 THEN DATE_ADD(`date_last_run`, INTERVAL 8 HOUR)
                            ELSE DATE_ADD(`date_start`, INTERVAL 8 HOUR) END AS `date_end` 
                FROM node_schedule" ;

        $query = $database->prepare($sql);
        $query->execute();

        $result = array();

        while($row = $query->fetch()) {
            $result[] = $row;
        }

        return $result;
    }

    public function formatSchedule($schedule)
    {
        $nschedule = array();
        $c = 1;

        foreach ($schedule as $r) {
            $etitle = "Event " . $c;
            $rid = chr(96+intval($r[0])) . SchedualerController::getScriptNum($r[1]);
            //$rid = chr(96+intval($r[0]));
            $sdate = preg_replace("/[\s_]/", "T", $r[4]);
            $edate = preg_replace("/[\s_]/", "T", $r[5]);
            $nrow = array(
                'id' => strval($c),
                'resourceId' => $rid,
                'start' => $sdate,
                'end' => $edate,
                'title' => $r[1]
                );
            array_push($nschedule, $nrow);
            $c++;
            if($r[2] > 0) {
                //TODO: Set up Repeat event function.

                for ($i=0; $i < $r[3]; $i++) { 
                    //TOOD: Set up frequency event function
                    //(# of days / $r[3]) * $i
                }
            }
        }

        return $nschedule; 
    }
    /* Foot Notes for formatSchedule
    *   repeat - $r[2]
    *   0: None
    *   1: daily
    *   2: weekly
    *   3: monthly
    *   4: weekdays
    *   5: weekends
    */

    public function getScriptNum($script)
    {
        if(strcmp($script,"blinddiodejefferson") == 0) {
            return 1;
        } else if (strcmp($script,"deputysteel") == 0) {
            return 2;
        } else if (strcmp($script,"dogmeat") == 0) {
            return 3;
        } else if (strcmp($script,"ironbelly") == 0) {
            return 4;
        } else if (strcmp($script,"machinegunwashington") == 0) {
            return 5;
        } else if (strcmp($script,"sawbones") == 0) {
            return 6;
        } 
    }
}

//macomb = blinddiodejefferson
//facebook = deputysteel
//crisnet = dogmeat
//oakland = ironbelly
//wayne = machinegunwashington
//midc = sawbones
