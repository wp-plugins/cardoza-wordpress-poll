<?php
/*
 * Filename: CWPViewCreatePoll.class.php
 * This is the class file which will have all the markup for the 
 * user interface to create a new poll.
 */
class CWPViewCreateImagePoll{

    public function __construct() {
        print '<div id="tab3" class="tab-content" style="z-index:10000;">';
       	?>
        <form id="image-create-poll" name="create_poll">
                <h3><?php _e('Poll Friendly Name', 'cardozapolldomain');?></h3>                
                <div id="box">
                    <div id="label"><?php _e('Friendly name', 'cardozapolldomain');?>* :</div>
                    <input id="image-poll-name" name="poll_name" style="width:350px;"
                           onblur="javascript:setBorderDefault('poll-name');" 
                           onfocus="javascript:setBorder('poll-name');" type="text" value="" />
                    <div id="clear"></div>
                </div>
                <h3>Poll Question</h3>
                <div id="box">
                    <div id="label"><?php _e('Question', 'cardozapolldomain');?>* :</div>
                    <input id="image-poll-question" name="poll_question" style="width:350px;"
                           onblur="javascript:setBorderDefault('poll-question');" 
                           onfocus="javascript:setBorder('poll-question');" type="text" value="" />
                    <div id="clear"></div>
                </div>
                <h3><?php _e('Poll Answers', 'cardozapolldomain');?></h3>
                <div id="box">
                    <div class="answers">
                        <div id="answer1"><div id="label"><?php _e('Answer', 'cardozapolldomain');?> 1* :</div>
                            <input id="image-ans1" name="answer1" type="text" value="" style="width:350px;" />
                            <div id="clear"></div>
                        </div>
                        <div id="answer2"><div id="label"><?php _e('Answer', 'cardozapolldomain');?> 2* :</div>
                            <input id="image-ans2" name="answer2" type="text" value="" style="width:350px;" />
                            <div id="clear"></div>
                        </div>
                    </div>
                    <center>
                        <input id="add-answer" 
                               onblur="javascript:setBorderDefault('add-answer');" 
                               onfocus="javascript:setBorder('add-answer');" 
                               onclick="javascript:appendAnswers()"
                               type="button" value="<?php _e('Add answer', 'cardozapolldomain');?>"/>
                        <input id="remove-answer" 
                               onblur="javascript:setBorderDefault('remove-answer');" 
                               onfocus="javascript:setBorder('remove-answer');" 
                               onclick="javascript:removeAnswers()"
                               type="button" value="<?php _e('Remove Answer', 'cardozapolldomain');?>"/>
                    </center>
                </div>
                <h3><?php _e('Poll Answer type', 'cardozapolldomain');?></h3>
                <div id="box">
                    <div id="label"><?php _e('Allow users to select', 'cardozapolldomain');?>* :</div>
                    <select name="poll_answer_type" id="image-poll-answer-type"
                            onblur="javascript:setBorderDefault('poll-answer-type');" 
                            onchange="javascript:showanswers(this.value)"
                            onfocus="javascript:setBorder('poll-answer-type');">
                        <option value="one">Only one answer</option>
                        <option value="multiple">More than one answer</option>
                    </select>
                    <div id="clear"></div>
                    <div id="nanswers">
                        <div id="label"><?php _e('No of answers to allow', 'cardozapolldomain');?>* :</div>
                        <input id="image-no-of-answers" style="width:40px" name="no_of_answers" type="text" value="" />
                    </div>
                    <div id="clear"></div>
                </div>
                <h3><?php _e('Poll Start/End Date', 'cardozapolldomain');?></h3>
                <div id="box">
                    <div id="label"><?php _e('Start date', 'cardozapolldomain');?>* :</div>
                    <input id="image_start_date" type="text" name="s_date" style="width:100px;"/> <b><?php _e('Format', 'cardozapolldomain');?>: </b> mm/dd/yyyy
                    <div id="clear"></div>
                    <div id="label"><?php _e('End date', 'cardozapolldomain');?>* :</div>
                    <input id="image_end_date" type="text" name="e_date" style="width:100px;"/> <b><?php _e('Format', 'cardozapolldomain');?>: </b> mm/dd/yyyy
                    <div id="clear"></div>
                </div>
                <center>
                    <input type="hidden" name="action" value="save_poll" />
                    <input type="hidden" name="poll_type" value="image_poll" />
                    <input id="add-answer" 
                           onclick="javascript:validateAddNewImagePollForm()"
                           onblur="javascript:setBorderDefault('add-answer');" 
                           onfocus="javascript:setBorder('add-answer');"
                           type="button" value="<?php _e('Add New Poll', 'cardozapolldomain');?>" />
                </center>
            </form>
        <?php
        print '</div>';
    }
}
?>