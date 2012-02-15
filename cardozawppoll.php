<?php

/*
Plugin Name: Cardoza Wordpress Poll
Plugin URI: http://fingerfish.com/cardoza-wordpress-poll
Description: Cardoza Wordpress Poll is completely ajax powered polling system. This poll plugin supports both single and multiple selection of answers.
Version: 0.2
Author: Vinoj Cardoza
Author URI: http://fingerfish.com/about-me/
License: GPL2
*/
define('CWP_PGN_DIR', plugin_dir_url(__FILE__));

require_once 'app/CWPController.class.php';

wp_enqueue_style('cwpcss', CWP_PGN_DIR.'public/css/CWPPoll.css');
wp_enqueue_script('cwp-main', CWP_PGN_DIR.'public/js/CWPPoll.js', array('jquery'));

add_action('wp_head','pluginname_ajaxurl');
add_action('plugins_loaded', 'trigger_init');

register_activation_hook  ( __FILE__, 'CWP_Install' );

function pluginname_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}

function trigger_init(){
     
    if(is_admin){
        $cwp = new CWPController();
        $cwp->init();
    }
    register_sidebar_widget(__('Cardoza Wordpress Poll'), 'widget_cardoza_wp_poll');
}

require_once 'cardozawppollFrontEndFunctions.php';

function widget_cardoza_wp_poll($args){
    
    $cwp = new CWPController();
    
    $option_value = $cwp->cwpp_options();
    
    $vars = array();
    $vars['option_value'] = $option_value;
    
    extract($args);
    echo $before_widget;
    echo $before_title;
    
    if(empty($option_value['title'])) $option_value['title'] = "Poll";
    echo $option_value['title'];
    
    echo $after_title;
    
    $polls = $cwp->retrievePoll();
    $count = 1;
    foreach($polls as $poll){
        $poll_end_date = $poll->end_date;
        $expiry_date = explode('/', $poll_end_date);
        $exp_time = mktime(0,0,0,$expiry_date[1], $expiry_date[0], $expiry_date[2]);
        if($count <= $option_value['no_of_polls']){?>
            <div id="widget-poll" <?php if(!empty($option_value['poll_bg_color'])) echo 'style="background-color:#'.$option_value['poll_bg_color'].';"';?>>
                <div id="widget-poll-question"><?php print $poll->question;?></div>
                
                <form id="poll<?php print $poll->id;?>">
                
                <?php
                
                $poll_answers = $cwp->getPollAnswers($poll->id);
                
                $vars['poll_answers'] = $poll_answers;
                $vars['total_votes'] = $poll->total_votes;
                $vars['poll_id'] = $poll->id;
                $vars['poll'] = $poll;
                $vars['exp_time'] = $exp_time;
                
                if(isset($_COOKIE['cwppoll'.$poll->id])){?>
                    <div id="show-results<?php $poll->id;?>">
                        <?php displayPollResults($vars);?>
                    </div>
                <?php
                }
                else{
                    if($option_value['poll_access']=='loggedin'){
                        
                        if(is_user_logged_in()) showPollForm($vars);
                        
                        else{?>
                    
                            <div id="show-results<?php $poll->id;?>">
                                <?php displayPollResults($vars);?>
                            </div>
                        <?php
                        }
                    }
                    
                    else showPollForm($vars);
                    }?>
                    
                </form>
            </div>
            
        <?php 
        }
        $count++;
    }
    previousPollsLink($vars);
    echo $after_widget;
}

add_shortcode("cardoza_wp_poll_archive", "cwp_poll_archive");

//function to display the poll archive shortcode
function cwp_poll_archive($atts){
    $cwp = new CWPController();
    $option_value = $cwp->cwpp_options();
    if(isset($_GET['poll_archive_page_no'])) $polls = $cwp->retrieveArchivePoll($option_value['no_of_polls_to_display_archive'], $_GET['poll_archive_page_no']);
    else $polls = $cwp->retrieveArchivePoll($option_value['no_of_polls_to_display_archive']);
    
    if(isset($_GET['poll_archive_page_no'])) $next_polls = $cwp->retrieveArchivePoll($option_value['no_of_polls_to_display_archive'], $_GET['poll_archive_page_no']+1);
    
    if(isset($_GET['poll_archive_page_no'])) {
        $page_no = $_GET['poll_archive_page_no'];
    }
    else {
        $page_no = 1;
    }
     
    if($page_no != 1) $previous_page = $page_no -1;
    else $previous_page = $page_no = 1;
    
    $next_page = $page_no+1;
    $count = 1;
    $archive_url = $option_value['archive_url'];
    $url = explode('?', $archive_url);
    if(sizeof($url)>1){
        if($_GET['poll_archive_page_no']!=1) {?>
            <a style="margin-right:10px;" id="previous-page" href="<?php echo $option_value['archive_url'].'&poll_archive_page_no='.$previous_page;?>">Previous Page</a>
        <?php
        }
        if(sizeof($next_polls)>0){
        ?>
            <a id="next-page" href="<?php echo $option_value['archive_url'].'&poll_archive_page_no='.$next_page;?>">Next Page</a>
        <?php
        }   
    }
    else{
        if($_GET['poll_archive_page_no']!=1) {?>
        <a id="previous-page" href="<?php echo $option_value['archive_url'].'?poll_archive_page_no='.$previous_page;?>">Previous Page</a>
        <?php
        }
        if(sizeof($next_polls)>0){
        ?>
            <a id="next-page" href="<?php echo $option_value['archive_url'].'?poll_archive_page_no='.$next_page;?>">Next Page</a>
    <?php
        }
    }
    ?>
    <?php
    
    if(empty($polls)) echo "<br>Sorry! No polls found in the archive for this page";
    foreach($polls as $poll){
        $poll_end_date = $poll->end_date;
        ?>
            <div id="widget-poll">
                <div id="widget-poll-question"><?php print $poll->question;?></div>
                <?php
                $poll_answers = $cwp->getPollAnswers($poll->id);         
                $vars['poll_answers'] = $poll_answers;
                $vars['total_votes'] = $poll->total_votes;
                $vars['option_value'] = $option_value;
                $vars['poll_id'] = $poll->id;
                displayPollResults($vars);
                ?>
            </div>
    <?php 
        
    }
}

global $CWP_db_version;
$CWP_db_version = "1.0";

function CWP_install(){
    global $wpdb;
    global $CWP_db_version;
    
    $poll_table = $wpdb->prefix."cwp_poll";
    $poll_answer_table = $wpdb->prefix."cwp_poll_answers";
    
    $create_poll_table = "CREATE TABLE ".$poll_table." (
		id int(10) not null auto_increment,
		name tinytext not null,
                question tinytext not null,
                answer_type tinytext not null,
                no_of_answers tinytext null,
                start_date tinytext not null,
                end_date tinytext not null,
                total_votes int(10) not null,
		UNIQUE KEY id (id));";
    
    $create_poll_answer_table = "CREATE TABLE ".$poll_answer_table." (
		id int(10) not null auto_increment,
		pollid int(10) not null,
                answer tinytext not null,
                votes int(10) not null,
		UNIQUE KEY id (id));";
        
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($create_poll_table);
    dbDelta($create_poll_answer_table);
    
    add_option("CWP_db_Version", $CWP_db_version);
}
?>