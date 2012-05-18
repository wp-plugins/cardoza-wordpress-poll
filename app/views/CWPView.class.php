<?php
/*
 * Filename: CWPView.class.php
 * This is the class file which will have all the markup for the user interface.
 */

require 'CWPViewCreatePoll.class.php';
require 'CWPViewPollOptions.class.php';
require 'CWPViewWidget.class.php';
require 'CWPViewManagePolls.class.php';
require 'CWPViewEditPoll.class.php';
require 'CWPViewStats.class.php';

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
            'Polls', 
            'manage_options', 
            'cwp_poll', array(&$this, 'poll_page'), 
            CWP_PGN_DIR . 'public/css/images/Vinoj.jpg');
    }

    /* The actual admin interface starts form here */
    public function poll_page() {
        ?>
        <div class="wrap">
            <h2><?php _e("Cardoza Wordpress Poll", "cwppoll_tans_domain"); ?></h2><br />
            <h3>* Mandatory fields.</h3>
            <ul id="tabs">
                <li><a id="menu-tab1" href="javascript:showTab(1);">Manage Polls</a></li>
                <li><a id="menu-tab2" href="javascript:showTab(2);">Add New Poll</a></li>
                <li><a id="menu-tab3" href="javascript:showTab(3);">Poll Options</a></li>
                <li><a id="menu-tab4" href="javascript:showTab(4);">Widget Options *</a></li>
                <li><a id="menu-tab5" href="javascript:showTab(5);">Poll Statistics</a></li>
            </ul>
            <div id="cwp-content">
                
        <?php 
            /* Creating instances and calling the views classes here 
             * to display the interface
             */
            $this->view_manage_poll->init();
            $view_create_poll = new CWPViewCreatePoll();
            $view_poll_options = new CWPViewPollOptions();
            $view_widget_options = new CWPViewWidget();
            $view_stats = new CWPViewStats();
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
