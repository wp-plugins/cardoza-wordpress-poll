<?php
/*
 * Filename: CWPController.class.php
 * This is the class file which will have all the control for this plugin.
 */
require_once 'CWPModel.class.php';
require_once 'views/CWPView.class.php';


class CWPController {
    
    public $cwpv; //instance variable for views
    public $cwpm; //instance variable for model
    
    function __construct(){
        
        $this->cwpv = new CWPView();
        $this->cwpm = new CWPModel();

        add_action('wp_ajax_save_poll', array(&$this, 'saveNewPoll'));
        add_action('wp_ajax_nopriv_save_poll', array(&$this, 'saveNewPoll'));
        add_action('wp_ajax_refresh_poll_list', array(&$this, 'refreshPollList'));
        add_action('wp_ajax_nopriv_refresh_poll_list', array(&$this, 'refreshPollList'));
        add_action('wp_ajax_editpoll', array(&$this, 'editPoll'));
        add_action('wp_ajax_nopriv_editpoll_list', array(&$this, 'editPoll'));
        add_action('wp_ajax_deletepoll', array(&$this, 'deletePoll'));
        add_action('wp_ajax_nopriv_deletepoll', array(&$this, 'deletePoll'));
        add_action('wp_ajax_save_widget', array(&$this, 'saveWidgetOptions'));
        add_action('wp_ajax_nopriv_save_widget', array(&$this, 'saveWidgetOptions'));
        add_action('wp_ajax_editpoll', array(&$this, 'editPoll'));
        add_action('wp_ajax_nopriv_editpoll', array(&$this, 'editPoll'));
        add_action('wp_ajax_update_answer', array(&$this, 'updateAnswer'));
        add_action('wp_ajax_nopriv_update_answer', array(&$this, 'updateAnswer'));
        add_action('wp_ajax_delete_answer', array(&$this, 'deleteAnswer'));
        add_action('wp_ajax_nopriv_delete_answer', array(&$this, 'deleteAnswer'));
        add_action('wp_ajax_add_answer', array(&$this, 'addAnswer'));
        add_action('wp_ajax_nopriv_add_answer', array(&$this, 'addAnswer'));
        add_action('wp_ajax_save_changes', array(&$this, 'editPollSave'));
        add_action('wp_ajax_nopriv_save_changes', array(&$this, 'editPollSave'));
        add_action('wp_ajax_save_poll_options', array(&$this, 'savePollOptions'));
        add_action('wp_ajax_nopriv_poll_options', array(&$this, 'savePollOptions'));
        add_action('wp_ajax_submit_vote', array(&$this, 'saveVote'));
        add_action('wp_ajax_nopriv_submit_vote', array(&$this, 'saveVote'));
        add_action('wp_ajax_cancel_vote', array(&$this, 'cancelVote'));
        add_action('wp_ajax_nopriv_cancel_vote', array(&$this, 'cancelVote'));
        
    }
    
    public function init(){
        
        $this->cwpv->cwp_admin_menu_init(); 
    }
      
    public function saveNewPoll(){
        
        $answers = array();
        $vars['name'] = stripslashes($_POST['poll_name']);
        $vars['question'] = stripslashes($_POST['poll_question']);
        $vars['answer_type'] = $_POST['poll_answer_type'];
        $vars['no_of_answers'] = $_POST['no_of_answers'];
        $vars['s_date'] = $_POST['s_date'];
        $vars['e_date'] = $_POST['e_date'];
        
        for($i=1;$i<=50;$i++) {
            if(!empty($_POST['answer'.$i])) array_push($answers, $_POST['answer'.$i]);
        }
        $this->cwpm->addNewPollDB($vars, $answers);
        die();
    }
    
    public function getPollList(){
        
        $vars = $this->cwpm->getPollsFromDB();
        return $vars;
    }
    
    public function refreshPollList(){
        
        $result = $this->cwpv->refreshPollsTable();
        die();
    }
    
    public function deletePoll(){
        $poll = $this->cwpm->getPollByIDFromDB($_POST['pollid']);
        if(sizeof($poll[0])<1) return false;
        else $result = $this->cwpm->deletePollFromDB($_POST['pollid']);
        $this->refreshPollList();
    }
    
    public function cwpp_options(){
        
        $cwpp_options = $this->cwpm->getCWPPOptions();
	return $cwpp_options;
    }
    
    public function saveWidgetOptions(){
        
        $vars['no_of_polls'] = $_POST['no_of_polls'];
        $vars['poll_archive'] = $_POST['poll-archive'];
        $vars['height'] = $_POST['widget_height'];
        $vars['width'] = $_POST['widget_width'];
        $vars['title'] = $_POST['widget_title'];
        $this->cwpm->saveWidgetOptionsToDB($vars);
        die();
    }
    
    public function retrievePoll(){
        
        $open_polls = array();
        $polls = $this->cwpm->getNPollsFromDB();
        $current_time = time();
        foreach($polls as $poll){
            
            //To calculate the time stamp for start date
            $sdate = explode('/', $poll->start_date);
            $smonth = $sdate[0];
            $sday = $sdate[1];
            $syear = $sdate[2];
            $stimestamp = mktime(0, 0, 0, $smonth, $sday, $syear); //poll start date timestamp
            
            //To calculate the time stamp for end date
            $edate = explode('/', $poll->end_date);
            $emonth = $edate[0];
            $eday = $edate[1];
            $eyear = $edate[2];   
            $etimestamp = mktime(0, 0, 0, $emonth, $eday, $eyear); //poll end date timestamp
            
            if($current_time>$stimestamp && $current_time < $etimestamp){
                array_push($open_polls, $poll);
            }
        }
        return $open_polls;
        die();
    }
    
    public function retrieveArchivePoll($no_of_polls, $page_no = null){
        
        $open_polls = array();
        $polls = $this->cwpm->getPollsArchiveFromDB($no_of_polls, $page_no);
        return $polls;
        die();
    }
    
    public function editPoll(){
        $poll = $this->cwpm->getPollByIDFromDB($_POST['pollid']);
        if(sizeof($poll[0])<1) return false;
        else $this->cwpv->viewEditPoll();
        die();
    }
    
    public function getPollByID(){
        $poll = $this->cwpm->getPollByIDFromDB($_POST['pollid']);
        return $poll;
    }
    
    public function updateAnswer(){
        $this->cwpm->updatePollAnswerByID($_POST['answer'], $_POST['answer_id']);
        $poll = $this->cwpm->getPollByIDFromDB($_POST['pollid']);
        if(sizeof($poll[0])<1) return false;
        else $this->cwpv->viewEditPoll();
        die();
    }
    
    public function deleteAnswer(){
        $this->cwpm->deletePollAnswerByID($_POST['answer_id']);
        $poll = $this->cwpm->getPollByIDFromDB($_POST['pollid']);
        if(sizeof($poll[0])<1) return false;
        else $this->cwpv->viewEditPoll();
        die();
    }
    
    public function addAnswer(){
        $this->cwpm->addPollAnswerIntoDB($_POST['pollid'],$_POST['answer']);
        $poll = $this->cwpm->getPollByIDFromDB($_POST['pollid']);
        if(sizeof($poll[0])<1) return false;
        else $this->cwpv->viewEditPoll();
        die();
    }
    
    public function editPollSave(){
        $vars = array();
        $vars['name'] = stripslashes($_POST['poll_name']);
        $vars['question'] = stripslashes($_POST['poll_question']);
        $vars['answer_type'] = $_POST['poll_answer_type'];
        $vars['no_of_answers'] = $_POST['no_of_answers'];
        $vars['s_date'] = $_POST['s_date'];
        $vars['e_date'] = $_POST['e_date'];
       
        $this->cwpm->saveChangesPollDB($vars, $_POST['pollid']);
        die();
    }
    
    public function savePollOptions(){
        
        $vars['archive_url'] = $_POST['archive_url'];
        $vars['no_of_polls_to_display_archive'] = $_POST['no_of_polls_to_display_archive'];
        $vars['poll_access'] = $_POST['poll_access'];
        $vars['poll_bar_color'] = $_POST['poll_bar_color'];
        $vars['poll_bar_height'] = $_POST['poll_bar_height'];
        $vars['poll_bg_color'] = $_POST['poll_bg_color'];
        $vars['polls_to_display_archive'] = $_POST['polls_to_display_archive'];
        $this->cwpm->savePollOptionsToDB($vars);
        die();
    }
    
    public function getPollAnswers($pollid){
        
        $answers = $this->cwpm->getPollAnswersFromDB($pollid);
        return $answers;
    }
    
    public function saveVote(){
        $pollid = $_POST['poll_id'];
        $expire = $_POST['expiry'];
        $status = 0;
        $option_value = $this->cwpp_options();
        $answerid = array();
        if($_POST['answertype'] == 'one'){
            if(isset($_POST[$pollid])){
                $answerid[] = $_POST[$pollid];
                $status = 1;
            }
            
        }
        if($_POST['answertype'] == 'multiple'){
            for($i=1; $i<=200; $i++){
                if(isset($_POST['option'.$i])){
                    $answerid[] = $_POST['option'.$i];
                    $status = 1;
                }
            }
        }
        
        if($status == 1){
            setcookie('cwppoll'.$pollid, "true", $expire, COOKIEPATH, COOKIE_DOMAIN,false,true);
            $this->cwpm->updatePollVote($pollid, $answerid);
            $answers = $this->cwpm->getPollAnswersFromDB($pollid);
            $polls = $this->cwpm->getPollByIDFromDB($pollid);
            
            $poll = $polls[0];
            print "<b>Total Votes: </b>".$poll[0]->total_votes."<br/>";
            foreach($answers as $answer){
                print $answer->answer." - ".$answer->votes." votes";
                $total = $poll[0]->total_votes;
                $votes = $answer->votes;
                $width = ($votes/$total)*100;
                ?>
                <br/>
                <div style="
                height:<?php if(!empty($option_value['bar_height'])) echo $option_value['bar_height'];
                else echo "10";?>px;
                width:<?php echo $width?>%;background-color:#<?php if(!empty($option_value['bar_color'])) echo $option_value['bar_color'];
                else echo "ECF1EF";?>"></div>
                <?php
            }    
        }
        
        die();
    }
    public function cancelVote(){
        
        $pollid = $_POST['poll_id'];
        setcookie('cwppoll'.$pollid, "true", time()-3600, COOKIEPATH, COOKIE_DOMAIN,false,true);
        $answerid = array();
        if($_POST['answertype'] == 'one'){
            $answerid[] = $_POST[$pollid];
        }
        if($_POST['answertype'] == 'multiple'){
            for($i=1; $i<=200; $i++){
                $answerid[] = $_POST['option'.$i];
            }
        }
        if(sizeof($answerid>0)){
            
            $this->cwpm->updatePollVote($pollid, $answerid);
        }
        
        die();
    }
}

?>
