<?php


class CWPModel {
    
    public function addNewPollDB($vars, $answers){
        global $wpdb;
        $table = $wpdb->prefix.'cwp_poll'; 
        $insert_poll = $wpdb->insert($table, array(
            'name' => $vars['name'],
            'question' => $vars['question'],
            'answer_type' => $vars['answer_type'] ,
            'no_of_answers' => $vars['no_of_answers'],
            'start_date' => $vars['s_date'],
            'end_date' => $vars['e_date']
        ));
        
        $poll_id = $wpdb->get_results("SELECT max(id) as 'maxid' FROM ".$wpdb->prefix."cwp_poll");
        $pollid = $poll_id[0]->maxid;
        
        $table = $wpdb->prefix.'cwp_poll_answers'; 
        foreach($answers as $answer){
            $insert_poll_answer = $wpdb->insert($table, array(
                'pollid' => $pollid,
                'answer' => $answer
            )); 
        }
    }
    
    public function getPollsFromDB(){
        
        global $wpdb;
        $all_polls = $wpdb->get_results("SELECT 
                    id, name, question, answer_type, start_date, end_date, total_votes
                    FROM ".$wpdb->prefix."cwp_poll ORDER BY id DESC");
        return $all_polls;
    }
    
    public function deletePollFromDB($pollid){
        
        global $wpdb;
        $wpdb->query("delete from ".$wpdb->prefix."cwp_poll where id=".$pollid);
        $wpdb->query("delete from ".$wpdb->prefix."cwp_poll_answers where pollid=".$pollid);
    }
    
    public function getCWPPOptions(){
        
        return array(
            'title' => stripslashes(get_option('cwpp_title')),
            'no_of_polls' => stripslashes(get_option('cwpp_no_of_polls')),
            'width' => stripslashes(get_option('cwpp_width')),
            'height' => stripslashes(get_option('cwpp_height')),
            'archive' => stripslashes(get_option('cwpp_archive')),
            'archive_url' => stripslashes(get_option('cwpp_archive_url')),
            'poll_access' => stripslashes(get_option('cwpp_poll_access')),
            'polls_to_display_archive' => stripslashes(get_option('cwpp_polls_to_display_archive')),
            'bar_color' => stripslashes(get_option('cwpp_poll_bar_color')),
            'bar_height' => stripslashes(get_option('cwpp_bar_height')),
            'poll_bg_color' => stripslashes(get_option('cwpp_poll_bg_color')),
            'no_of_polls_to_display_archive' => stripslashes(get_option('cwpp_no_of_polls_to_display_archive')),
	); 
    }
    
    public function saveWidgetOptionsToDB($vars){
        update_option('cwpp_title', $vars['title']);
        update_option('cwpp_no_of_polls', $vars['no_of_polls']);
        update_option('cwpp_archive', $vars['poll_archive']);
        update_option('cwpp_height', $vars['height']);
        update_option('cwpp_width', $vars['width']);
        
    }
    
    public function getNPollsFromDB(){
        global $wpdb;
        $all_polls = array();
        
        $all_polls = $wpdb->get_results("SELECT 
                    id, name, question, answer_type, start_date, end_date, total_votes 
                    FROM ".$wpdb->prefix."cwp_poll ORDER BY id DESC");
        return $all_polls;
    }
    
    public function getPollsArchiveFromDB($no_of_polls, $page_no=null){
        global $wpdb;
        $all_polls = array();
        $page_no = $page_no-1;
        
        if($page_no<1) $to = 0;
        else $to = $page_no*$no_of_polls;
        
        $all_polls = $wpdb->get_results("SELECT 
                    id, name, question, answer_type, start_date, end_date, total_votes 
                    FROM ".$wpdb->prefix."cwp_poll ORDER BY id DESC LIMIT ".$to.",".$no_of_polls);
        
        return $all_polls;
    }
    
    public function getPollByIDFromDB($poll_id){
        global $wpdb;
        $poll_answers = array();
        $poll = array();
        $vars = array();
        $poll = $wpdb->get_results("SELECT 
                    id, name, question, answer_type, no_of_answers, start_date, end_date, total_votes 
                    FROM ".$wpdb->prefix."cwp_poll WHERE id=".$poll_id);
        array_push($vars, $poll);
        $poll_answers = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."cwp_poll_answers WHERE pollid=".$poll_id);
        array_push($vars, $poll_answers);
        return $vars;
    }
    
    public function updatePollAnswerByID($answer, $answerid){
        global $wpdb;
        $result = $wpdb->query("UPDATE ".$wpdb->prefix."cwp_poll_answers SET
                    answer='".$answer."'
                    WHERE id=".$answerid);
    }
    
    public function deletePollAnswerByID($answerid){
        global $wpdb;
        $result = $wpdb->query("DELETE FROM ".$wpdb->prefix."cwp_poll_answers WHERE id=".$answerid);
        //POll answer delete to be included
    }
    
    public function addPollAnswerIntoDB($pollid, $answer){
        global $wpdb;
        
        $table = $wpdb->prefix.'cwp_poll_answers'; 
        $insert_poll_answer = $wpdb->insert($table, array(
                'pollid' => $pollid,
                'answer' => $answer
            )); 
    }
    
    public function saveChangesPollDB($vars, $pollid){
        
        global $wpdb;
        $result = $wpdb->query("UPDATE ".$wpdb->prefix."cwp_poll SET
            name = '".$vars['name']."',
            question = '".$vars['question']."',
            answer_type = '".$vars['answer_type']."',
            no_of_answers = '".$vars['no_of_answers']."',
            start_date = '".$vars['s_date']."',
            end_date = '".$vars['e_date']."' WHERE id = ".$pollid);
    }
    
    public function savePollOptionsToDB($vars){
                
        
        update_option('cwpp_archive_url', $vars['archive_url']);
        update_option('cwpp_no_of_polls_to_display_archive', $vars['no_of_polls_to_display_archive']);
        update_option('cwpp_poll_access', $vars['poll_access']);
        update_option('cwpp_poll_bar_color', $vars['poll_bar_color']);
        update_option('cwpp_bar_height', $vars['poll_bar_height']);
        update_option('cwpp_poll_bg_color', $vars['poll_bg_color']);
        update_option('cwpp_polls_to_display_archive', $vars['polls_to_display_archive']);
    }
    
    public function getPollAnswersFromDB($pollid){
        global $wpdb;    
        $poll_answers = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."cwp_poll_answers WHERE pollid=".$pollid);
        return $poll_answers;
    }
    
    public function updatePollVote($pollid, $answerid){
        
        global $wpdb;
        $result = $wpdb->query("UPDATE ".$wpdb->prefix."cwp_poll SET
            total_votes = total_votes+1 WHERE id = ".$pollid);
        foreach($answerid as $ansid){
            $result = $wpdb->query("UPDATE ".$wpdb->prefix."cwp_poll_answers SET
            votes = votes+1 WHERE id = ".$ansid);
        }
    }
}
?>
