<?php
/*
 * Filename: CWPView.class.php
 * This is the class file which will have all the markup for the user interface.
 */

require 'CWPViewCreatePoll.class.php';
require 'CWPViewCreateImagePoll.class.php';
require 'CWPViewPollOptions.class.php';
require 'CWPViewWidget.class.php';
require 'CWPViewManagePolls.class.php';
require 'CWPViewEditPoll.class.php';
require 'CWPViewStats.class.php';
require 'CWPViewUserLogs.class.php';

class CWPView {
    
    public $view_manage_poll;
    public $view_edit_poll;
    /* To initialize the admin menu in the wordpress cms backend */
    
    public function __construct(){
        $this->view_manage_poll = new CWPViewManagePolls();
        $this->view_edit_poll = new CWPViewEditPoll();
    }

    public function cwp_admin_menu_init() {

        add_action('admin_menu', array(&$this, 'cwp_admin_menu'));
    }

    /* Creates 'Cardoza Poll' menu in the wordpress cms backend */

    public function cwp_admin_menu() {

        add_menu_page(
            __('Poll'), 
            __('Poll'), 
            'manage_options', 
            'cwp_poll', array(&$this, 'poll_page'), 
            CWP_PGN_DIR . 'public/css/images/poll.png');
    }

    /* The actual admin interface starts form here */
    public function poll_page() {
        ?>
        <div class="wrap">
            <h2><?php _e("Wordpress Poll", "cardozapolldomain"); ?></h2><br />
            <h3>* <?php _e("Mandatory fields", "cardozapolldomain"); ?>.</h3>
            <ul id="tabs">
                <li>
                    <a id="menu-tab1" href="javascript:showTab(1);">
                        <?php _e('Manage Polls', 'cardozapolldomain');?>
                    </a>
                </li>
                <li>
                    <a id="menu-tab2" href="javascript:showTab(2);">
                        <?php _e('Add New Poll', 'cardozapolldomain');?>
                    </a>
                </li>
                <li>
                    <a id="menu-tab3" href="javascript:showTab(3);">
                        <?php _e('Add New Image Poll', 'cardozapolldomain');?>
                    </a>
                </li>
                <li>
                    <a id="menu-tab4" href="javascript:showTab(4);">
                        <?php _e('Poll Options', 'cardozapolldomain');?>
                    </a>
                </li>
                <li>
                    <a id="menu-tab5" href="javascript:showTab(5);">
                        <?php _e('Widget Options', 'cardozapolldomain');?> *
                    </a>
                </li>
                <li>
                    <a id="menu-tab6" href="javascript:showTab(6);">
                        <?php _e('Poll Statistics', 'cardozapolldomain');?>
                    </a>
                </li>
                <li>
                    <a id="menu-tab7" href="javascript:showTab(7);">
                        <?php _e('User Logs', 'cardozapolldomain');?>
                    </a>
                </li>
            </ul>
            <div id="cwp-content">
                
        <?php 
            /* Creating instances and calling the views classes here 
             * to display the interface
             */
            $this->view_manage_poll->init();
            $view_create_poll = new CWPViewCreatePoll();
            $view_create_image_poll = new CWPViewCreateImagePoll();
            $view_poll_options = new CWPViewPollOptions();
            $view_widget_options = new CWPViewWidget();
            $view_stats = new CWPViewStats();
            $user_logs = new CWPViewUserLogs();
        ?>
            </div>
        </div>
    <?php }
    
    public function refreshPollsTable(){
        $this->view_manage_poll->init();
    }
    
    public function viewEditPoll(){
        $this->view_edit_poll->init();
    }
    
    public function viewAnswers(){
        $this->view_edit_poll->updatedAnswers();
    }
    
    
}
?>
