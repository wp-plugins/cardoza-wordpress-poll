<?php
/*
 * Filename: CWPViewCreatePoll.class.php
 * This is the class file which will have all the markup for the 
 * user interface to create a new poll.
 */

class CWPViewCreatePoll{

    public function __construct() {?>
    
        <div id="tab2" class="tab-content" style="z-index:10000;">
            <form id="create-poll" name="create_poll">
                <h3><?php _e('Poll Friendly Name','cardozapolldomain');?></h3>                
                <div id="box">
                    <div id="label"><?php _e('Friendly name','cardozapolldomain');?>* :</div>
                    <input id="poll-name" name="poll_name" style="width:350px;"
                           onblur="javascript:setBorderDefault('poll-name');" 
                           onfocus="javascript:setBorder('poll-name');" type="text" value="" />
                    <div id="clear"></div>
                </div>
                <h3><?php _e('Poll Question','cardozapolldomain');?></h3>
                <div id="box">
                    <div id="label"><?php _e('Question','cardozapolldomain');?>* :</div>
                    <input id="poll-question" name="poll_question" style="width:350px;"
                           onblur="javascript:setBorderDefault('poll-question');" 
                           onfocus="javascript:setBorder('poll-question');" type="text" value="" />
                    <div id="clear"></div>
                </div>
                <h3><?php _e('Poll Answers','cardozapolldomain');?></h3>
                <div id="box">
                    <div class="answers">
                        <div id="answer1"><div id="label"><?php _e('Answer','cardozapolldomain');?> 1* :</div>
                            <input id="ans1" name="answer1" type="text" value="" style="width:350px;" />
                            <div id="clear"></div>
                        </div>
                        <div id="answer2"><div id="label"><?php _e('Answer','cardozapolldomain');?> 2* :</div>
                            <input id="ans2" name="answer2" type="text" value="" style="width:350px;" />
                            <div id="clear"></div>
                        </div>
                    </div>
                    <center>
                        <input id="add-answer" 
                               onblur="javascript:setBorderDefault('add-answer');" 
                               onfocus="javascript:setBorder('add-answer');" 
                               onclick="javascript:appendAnswers()"
                               type="button" value="<?php _e('Add answer','cardozapolldomain');?>"/>
                        <input id="remove-answer" 
                               onblur="javascript:setBorderDefault('remove-answer');" 
                               onfocus="javascript:setBorder('remove-answer');" 
                               onclick="javascript:removeAnswers()"
                               type="button" value="<?php _e('Remove Answer','cardozapolldomain');?>"/>
                    </center>
                </div>
                <h3><?php _e('Poll Answer type','cardozapolldomain');?></h3>
                <div id="box">
                    <div id="label"><?php _e('Allow users to select','cardozapolldomain');?>* :</div>
                    <select name="poll_answer_type" id="poll-answer-type"
                            onblur="javascript:setBorderDefault('poll-answer-type');" 
                            onchange="javascript:showanswers(this.value)"
                            onfocus="javascript:setBorder('poll-answer-type');">
                        <option value="one"> <?php _e('Only one answer','cardozapolldomain');?></option>
                        <option value="multiple"><?php _e('More than one answer','cardozapolldomain');?></option>
                    </select>
                    <div id="clear"></div>
                    <div id="nanswers" style="display:none">
                        <div id="label"><?php _e('No of answers to allow','cardozapolldomain');?>* :</div>
                        <input id="no-of-answers" style="width:40px" name="no_of_answers" type="text" value="" />
                    </div>
                    <div id="clear"></div>
                </div>
                <h3><?php _e('Poll Start/End Date','cardozapolldomain');?></h3>
                <div id="box">
                    <div id="label"><?php _e('Start date','cardozapolldomain');?>* :</div>
                    <input id="start_date" type="text" name="s_date" style="width:100px;"/> <b><?php _e('Format','cardozapolldomain');?>: </b> mm/dd/yyyy
                    <div id="clear"></div>
                    <div id="label"><?php _e('End date','cardozapolldomain');?>* :</div>
                    <input id="end_date" type="text" name="e_date" style="width:100px;"/> <b><?php _e('Format','cardozapolldomain');?>: </b> mm/dd/yyyy
                    <div id="clear"></div>
                </div>
                <center>
                    <input type="hidden" name="action" value="save_poll" />
                    <input id="add-answer" 
                           onclick="javascript:validateAddNewPollForm()"
                           onblur="javascript:setBorderDefault('add-answer');" 
                           onfocus="javascript:setBorder('add-answer');"
                           type="button" value="<?php _e('Add New Poll','cardozapolldomain');?>" />
                </center>
            </form>
        </div> 
        <?php
    }

}
?>