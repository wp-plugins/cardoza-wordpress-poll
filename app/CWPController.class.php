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
        add_action('wp_ajax_view_poll_result', array(&$this, 'viewPollResult'));
        add_action('wp_ajax_nopriv_view_poll_result', array(&$this, 'viewPollResult'));
        add_action('wp_ajax_view_poll_stats', array(&$this, 'getPollStats'));
        add_action('wp_ajax_nopriv_view_poll_stats', array(&$this, 'getPollStats'));
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
                                   
            $stimestamp = $this->getStrToTime($poll->start_date);
            $etimestamp = $this->getStrToTime($poll->end_date);
            
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
            $answer_type = $poll[0]->answer_type;
            
            $total = $poll[0]->total_votes;
            if($answer_type == "multiple") print "<b>Total Voters: </b>".$total."<br/>";
    
            foreach($answers as $answer){
                $total_votes = $total_votes + $answer->votes;
            }
            print "<b>Total Votes: </b>".$total_votes."<br/>";
            foreach($answers as $answer){
                
                $total = $poll[0]->total_votes;
                $votes = $answer->votes;
                if($total!=0) $width = ($votes/$total)*100;
                else $width = 0;
        
                print $answer->answer." (".$answer->votes." votes, ".intval($width)."%)";
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
       
    public function viewPollResult(){
        
        $pollid = $_POST['poll_id'];
        $polls = $this->cwpm->getPollByIDFromDB($pollid);
        $answers = $this->cwpm->getPollAnswersFromDB($pollid);
        $option_value = $this->cwpp_options();
        $poll = $polls[0];
        print "<b>".$poll[0]->question."</b><br/>";
        print "<b>Total Votes: </b>".$poll[0]->total_votes."<br/>";
        foreach($answers as $answer){
                
                $total = $poll[0]->total_votes;
                $votes = $answer->votes;
                if($total!=0) $width = ($votes/$total)*100;
                else $width = 0;
                print "<div style='width:100%;float:left;'>".$answer->answer." (".$answer->votes." votes, ".intval($width)."%)</div>";
                ?>
                <hr style="float:left;height:10px;width:<?php echo $width;?>%;background-color:#4a7194;">
                <?php
            }?>
                <div id="clear">
        <?php
        die();
    }
    
    public function getStrToTime($date){
        
        $date = explode('/', $date);
        $month = $date[0];
        $day = $date[1];
        $year = $date[2];   
        $timestamp = mktime(0, 0, 0, $month, $day, $year); 
        return $timestamp;
    }
    
    public function getPollStats($vars = null){
        $poll_stats = $this->cwpm->pollStats();
        $current_time = time();
        $votes = array();
        $today = mktime(0,0,0,date('m'),date('d'),date('Y'));
        if(isset($_POST['arguments'])) $vars['arguments'] = $_POST['arguments'];
        if(empty($vars)){
            if(!empty($poll_stats)){
                for($i=0;$i<7;$i++){
                    $vars['label'] = 'Last 7 days Statistics';
                    $from = $today - ((24*60*60)*$i);
                    if($i!=0) $to = $today - ((24*60*60)*($i-1));
                    else $to = time();
                    foreach($poll_stats as $stats){
                        if($stats->polledtime>$from && $stats->polledtime<$to){
                            if(array_key_exists($from, $votes)){
                                if(is_array($votes[$from])) $votes[$from] = $votes[$from]+1;
                                else $votes[$from] = $votes[$from]+1;           
                            }
                            else $votes[$from] = 1;
                        }
                    }
                }  
            }
            $vars['votes'] = $votes;
            return $vars;
        }
        else{
            if(!empty($poll_stats)){
                $days = $vars['arguments'];
                for($i=0;$i<$days;$i++){
                    $vars['label'] = 'Last '.$days.' days Statistics';
                    $from = $today - ((24*60*60)*$i);
                    if($i!=0) $to = $today - ((24*60*60)*($i-1));
                    else $to = time();
                    foreach($poll_stats as $stats){
                        if($stats->polledtime>$from && $stats->polledtime<$to){
                            if(array_key_exists($from, $votes)){
                                if(is_array($votes[$from])) $votes[$from] = $votes[$from]+1;
                                else $votes[$from] = $votes[$from]+1;           
                            }
                            else $votes[$from] = 1;
                        }
                    }
                }
                $label = $vars['label'];
                if(!empty($votes)){
                    $max_value = 0;

                    foreach($votes as $vote){
                        if($vote>$max_value) $max_value = $vote; 
                    }

                    if($max_value<10) $max_value = 10;

                    if(($max_value%10) != 0) $max_y_axis_value = ($max_value+10-($max_value%10));
                    else $max_y_axis_value = $max_value;
                    ?>
                    <div id="cwp-xaxis">
                        <?php print $label;?>
                    </div>
                    <div id="cwp-yaxis">
                        <?php 
                        for($i=0; $i<10; $i++){?>
                            <div class="cwp-yaxis-label">
                                <?php print $max_y_axis_value-(($max_y_axis_value/10)*$i);?>-
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div id="cwp-graph-content">
                        <?php
                            $bar_width = 545/sizeof($votes);
                            if($bar_width>5) $bar_width = $bar_width-1;
                            $bar_width = $bar_width;
                            $bar_height = (493/$max_y_axis_value);
                        ?>
                        <?php foreach($votes as $key=>$vote){?>
                                <div id="cwp-graph-bar" 
                                     style="width:<?php echo $bar_width;?>px;
                                            height:<?php echo $bar_height*$vote;?>px;
                                            margin-top:<?php echo 500-($bar_height*$vote);?>px;
                                            margin-left:<?php if($bar_width<5) echo '0';else echo '1';?>px" 
                                     title ="Date:<?php echo date('d/m/y',$key)." - ".$vote;?> Votes">
                                </div>
                        <?php }?>
                    </div>
                <?php
                }
            }
        }
        
        die();
    }
	
	public function getPollLogged($pollid, $userid){
		$status = $this->cwpm->getPollLoggedDetail($pollid, $userid);
		return $status;		
	}
}

?>
