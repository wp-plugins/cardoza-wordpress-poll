<?php
/*
Plugin Name: Wordpress Poll
Plugin URI: http://fingerfish.com/cardoza-wordpress-poll
Description: Wordpress Poll is completely ajax powered polling system. This poll plugin supports both single and multiple selection of answers.
Version: 1.5
Author: Vinoj Cardoza
Author URI: http://fingerfish.com/about-me/
License: GPL2
*/
define('CWP_PGN_DIR', plugin_dir_url(__FILE__));

require_once 'app/CWPController.class.php';

/* To include the stylesheets */
wp_enqueue_style('cwpcss', CWP_PGN_DIR.'public/css/CWPPoll.css');

/* To include the javascripts */
wp_enqueue_script('cwp-main', CWP_PGN_DIR.'public/js/CWPPoll.js', array('jquery'));

add_action('wp_head','cwppoll_ajaxurl');
add_action('plugins_loaded', 'trigger_init');

register_activation_hook  ( __FILE__, 'CWP_Install' );

function cwppoll_ajaxurl() {
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
    register_sidebar_widget(__('Wordpress Poll'), 'widget_cardoza_wp_poll');
}

/*Calling all the required files*/
require_once 'cardozawppollFrontEndFunctions.php';
require_once 'cardozawppolldb.php';

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
    
    if(!empty($option_value['no_of_polls'])) $no_of_polls_in_Widget = $option_value['no_of_polls'];
    else $no_of_polls_in_Widget = 1;
    
    echo $after_title;
    
    $polls = $cwp->retrievePoll();
    $count = 1;
    foreach($polls as $poll){
        $poll_end_date = $poll->end_date;
        $expiry_date = explode('/', $poll_end_date);
        $exp_time = mktime(0,0,0,$expiry_date[1], $expiry_date[0], $expiry_date[2]);
        if($count <= $no_of_polls_in_Widget){?>
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
                
                if($option_value['poll_access']=='loggedin'){
                        
                    if(is_user_logged_in()){
                        global $current_user;
                        get_currentuserinfo();
                        $loggedinuserid = $current_user->ID;
                        $status = $cwp->getPollLogged($poll->id, $loggedinuserid);
                        if(empty($status)) showPollForm($vars);
                        else displayPollResults($vars);
                    }
                    else{?>

                        <div id="show-results<?php $poll->id;?>">
                            <?php displayPollResults($vars);?>
                        </div>
                    <?php
                    }
                }
                else{
                    $lock_by = $option_value['poll_lock'];
                    if(empty($lock_by)) $lock_by = 'cookies';
                    if($lock_by == 'cookies'){
                        if(isset($_COOKIE['cwppoll'.$poll->id])){?>
                            <div id="show-results<?php $poll->id;?>">
                                <?php displayPollResults($vars);?>
                            </div>
                        <?php
                        }
                        else showPollForm($vars);
                    }
                    elseif($lock_by == 'ipaddress'){    
                        $status = $cwp->getPollIPLogged($poll->id);
                        if(!empty($status)){?>
                            <div id="show-results<?php $poll->id;?>">
                                <?php displayPollResults($vars);?>
                            </div>
                        <?php
                        }
                        else showPollForm($vars);
                    }
                }
                ?>
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
    if(isset($_GET['poll_archive_page_no'])) {
        $polls = $cwp->retrieveArchivePoll($option_value['no_of_polls_to_display_archive'], $_GET['poll_archive_page_no']);
        $next_polls = $cwp->retrieveArchivePoll($option_value['no_of_polls_to_display_archive'], $_GET['poll_archive_page_no']+1);
        $page_no = $_GET['poll_archive_page_no'];
    }
    else{
        $polls = $cwp->retrieveArchivePoll($option_value['no_of_polls_to_display_archive']);
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
    
    if(empty($polls)) _e("<br>Sorry! No polls found in the archive for this page");
    foreach($polls as $poll){
        
        $stimestamp = $cwp->getStrToTime($poll->start_date);
        $etimestamp = $cwp->getStrToTime($poll->end_date);
        $current_time = time();
        ?>
            <br/>
            <strong>Poll id : </strong>#<?php print $poll->id." - ".date('F jS, Y', $stimestamp);?>&nbsp;to&nbsp;<?php print date('F jS, Y', $etimestamp);?>&nbsp;&nbsp;(<?php
                if($etimestamp > $current_time) echo "Open";
                else echo "Closed";
            ?>)
            <div id="widget-poll">
                
                <div id="widget-poll-question"><?php print $poll->question;?></div>
                <?php
                $poll_answers = $cwp->getPollAnswers($poll->id);         
                $vars['poll_answers'] = $poll_answers;
                $vars['total_votes'] = $poll->total_votes;
                $vars['option_value'] = $option_value;
                $vars['poll_id'] = $poll->id;
                $vars['poll'] = $poll;
                displayPollResults($vars);
                ?>
            </div>
    <?php 
        
    }
}

add_shortcode("cardoza_wp_poll", "cwp_poll_id_display");

function cwp_poll_id_display($atts){
    ob_start();
    $cwp = new CWPController();
    $option_value = $cwp->cwpp_options();
    
    $vars = array();
    $vars['option_value'] = $option_value;
                
    $polls = $cwp->getPollList();
    
    foreach($polls as $poll){
        
        $stimestamp = $cwp->getStrToTime($poll->start_date);
        $etimestamp = $cwp->getStrToTime($poll->end_date);
        
        $current_time = time();
        
        if($poll->id == trim($atts['id'])){?>
            <div id="widget-poll">
                <div id="widget-poll-question"><?php print $poll->question;?></div>
                
                <form id="pollsc<?php print $poll->id;?>">
                
                <?php
                
                $poll_answers = $cwp->getPollAnswers($poll->id);
                
                $vars['poll_answers'] = $poll_answers;
                $vars['total_votes'] = $poll->total_votes;
                $vars['poll'] = $poll;
                $vars['exp_time'] = $etimestamp;
                
                if($current_time>$stimestamp && $current_time < $etimestamp){
                    
                    if($option_value['poll_access']=='loggedin'){

                        if(is_user_logged_in()){
                                global $current_user;
                                get_currentuserinfo();
                                $loggedinuserid = $current_user->ID;
                                $status = $cwp->getPollLogged($poll->id, $loggedinuserid);
                                if(empty($status)) showPollFormSC($vars);
                                else displayPollResults($vars);							
                        }

                        else{?>

                            <div id="show-results<?php $poll->id;?>">
                                <?php displayPollResults($vars);?>
                            </div>
                        <?php
                        }
                    }

                    else{
                        $lock_by = $option_value['poll_lock'];
                        if(empty($lock_by)) $lock_by = 'cookies';
                        if($lock_by == 'cookies'){
                            if(isset($_COOKIE['cwppoll'.$poll->id])){?>
                                <div id="show-results<?php $poll->id;?>">
                                    <?php displayPollResults($vars);?>
                                </div>
                        <?php
                            }
                            else showPollFormSC($vars);
                        }
                        elseif($lock_by == 'ipaddress'){
                            $status = $cwp->getPollIPLogged($poll->id);
                            if(empty($status)) showPollFormSC($vars);
                            else {?>
                                <div id="show-results<?php $poll->id;?>">
                                    <?php displayPollResults($vars);?>
                                </div>
                        <?php
                            }
                        }
                    }
                    ?>
                </form>
            </div>
            
        <?php 
                }
        }
        $count++;
    }    
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}
add_action('plugins_loaded', 'cwp_db_update');
?>