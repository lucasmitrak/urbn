<?php

class MessagesController extends Controller
{
    private $messd = array();
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
        $table = MessagesController::buildMessageTable();
        MessagesController::buildUserMessages();
        $this->View->render('messages/index',array(
            'table' => $table, 'messaged' => $this->messd));
        //$this->View->render('messages/index');
    }

    public function buildMessageTable() {
        $result = '';
        $result .= "<table id=\"message\" border=\"1\" class=\"display responsive nowrap\" width=\"100%\" cellspacing=\"0\">";
        $result .="<thead>";
        $result .= "<tr><th></th><th>To</th><th>From</th><th>Date Created</th></tr>";
        $result .="</thead>";
        $result .="<tfoot>";
        $result .= "<tr><th></th><th>To</th><th>From</th><th>Date Created</th></tr>";
        $result .="</tfoot>";
        return $result;
    }

    public function buildUserMessages() {
        $messages = Session::getUserMessages();

        foreach ($messages as $r) {
            $nrow = array(
                    "to" => $r[0],
                    "from" => $r[1],
                    "date_created" => $r[2],
                    "message" => $r[3]
                );
            array_push($this->messd, $nrow);
        }

        if(Session::get('user_account_type') == 7) {
            MessagesController::getAdminMessages();
        }
    }

    public function getAdminMessages() {
        $messages = Session::getAdminMessages();

        foreach ($messages as $r) {
            $nrow = array(
                    "to" => $r[0],
                    "from" => $r[1],
                    "date_created" => $r[2],
                    "message" => $r[3]
                );
            array_push($this->messd, $nrow);
        }
    }
}
