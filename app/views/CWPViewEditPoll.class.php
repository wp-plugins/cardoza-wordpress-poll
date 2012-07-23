<?php

/*
 * 
 */
class CWPViewEditPoll {

    function init() {
        $controller = new CWPController();
        $poll_data = $controller->getPollByID();
        $poll = $poll_data[0];
        
        $poll_answers = $poll_data[1];
        
        ?>
            <div id="all-polls">
            <input id="refresh-list" class="inpt"
                    onclick="javascript:refreshPollList()"
                    onblur="javascript:setBorderDefault('refresh-list');" 
                    onfocus="javascript:setBorder('refresh-list');" type="button" value="<?php _e("Refresh Poll List", "cardozapolldomain");?>"/>
                <input id="edit-poll" class="inpt"
                    onblur="javascript:setBorderDefault('edit-poll');" 
                    onfocus="javascript:setBorder('edit-poll');" type="button" value="<?php _e("Edit a Poll", "cardozapolldomain");?>" onclick="javascript:editPoll()" />
                <input id="delete-poll" class="inpt"
                    onblur="javascript:setBorderDefault('delete-poll');" 
                    onfocus="javascript:setBorder('delete-poll');" type="button" value="<?php _e("Delete a Poll", "cardozapolldomain");?>" onclick="javascript:deletePoll()" />
                <br />
            <form id="edit-poll-form" name="create_poll">
                <h3><?php _e("Poll Friendly Name", "cardozapolldomain");?></h3>
                <div id="box">
                    <div id="label"><?php _e("Friendly name", "cardozapolldomain");?>* :</div>
                    <input id="poll-name" name="poll_name" style="width:350px;"
                            type="text" value="<?php echo $poll[0]->name; ?>" />
                    <div id="clear"></div>
                </div>
                <h3><?php _e("Poll Question", "cardozapolldomain");?></h3>
                <div id="box">
                    <div id="label"><?php _e("Name", "cardozapolldomain");?>Question* :</div>
                    <input id="poll-question" name="poll_question" style="width:350px;"
                           onblur="javascript:setBorderDefault('poll-question');" 
                           onfocus="javascript:setBorder('poll-question');" type="text" value="<?php print $poll[0]->question; ?>" />
                    <div id="clear"></div>
                </div>
                <h3><?php _e("Poll Answers", "cardozapolldomain");?></h3>
                <div id="box">
                    <div class="answers">
                        <?php 
                        
                        foreach($poll_answers as $answers){?>
                            <div style="padding-left: 10px;">
                                &nbsp;&nbsp;&nbsp;<?php echo $answers->answer;?>
                                &nbsp;&nbsp;<a href="javascript:editAnswer(<?php echo $answers->id.','.$poll[0]->id;?>)"><?php _e("Edit", "cardozapolldomain");?></a>
                                &nbsp;&nbsp;<a href="javascript:deleteAnswer(<?php echo $answers->id.','.$poll[0]->id;?>)"><?php _e("Delete", "cardozapolldomain");?></a>
                                
                            </div><br/>
                        <?php }?>
                            <input onclick="javascript:addAnswer(<?php echo $poll[0]->id;?>)" type="button" value="<?php _e("Add more answers", "cardozapolldomain");?>"/>
                    </div>
                </div>
                <h3><?php _e("Poll Answer type", "cardozapolldomain");?></h3>
                <div id="box">
                    <div id="label"><?php _e("Allow users to select", "cardozapolldomain");?>* :</div>
                    <select name="poll_answer_type" id="poll-answer-type"
                            onblur="javascript:setBorderDefault('poll-answer-type');" 
                            onfocus="javascript:setBorder('poll-answer-type');">
                        <option value="one" <?php if($poll[0]->answer_type == "one") echo "selected";?>><?php _e("Only one answer", "cardozapolldomain");?></option>
                        <option value="multiple" <?php if($poll[0]->answer_type == "multiple") echo "selected";?>><?php _e("More than one answer", "cardozapolldomain");?></option>
                    </select>
                    <div id="clear"></div>
                    <div id="nanswers">
                        <div id="label"><?php _e("No of answers to allow", "cardozapolldomain");?>* :</div>
                        <input id="no-of-answers" style="width:40px" name="no_of_answers" type="text" value="<?php print $poll[0]->no_of_answers; ?>" />
                    </div>
                    <div id="clear"></div>
                </div>
                <h3><?php _e("Poll Start/End Date", "cardozapolldomain");?></h3>
                <div id="box">
                    <div id="label"><?php _e("Start date", "cardozapolldomain");?>* :</div>
                    <input id="edit_start_date" type="text" name="s_date" value="<?php print $poll[0]->start_date; ?>" style="margin-right:10px;width:100px;"/> <b>Format:</b> mm/dd/yyyy
                    <div id="clear"></div>
                    <div id="label"><?php _e("End date", "cardozapolldomain");?>* :</div>
                    <input id="edit_end_date" type="text" name="e_date" value="<?php print $poll[0]->end_date; ?>" style="margin-right:10px;width:100px;"/> <b>Format:</b> mm/dd/yyyy
                    <div id="clear"></div>
                </div><center>
                    <input type="hidden" name="action" value="save_changes" />
                    <input type="hidden" name="pollid" value="<?php print $poll[0]->id; ?>" />

                    <input id="save-changes" 
                           onclick="javascript:save_changes()"
                           onblur="javascript:setBorderDefault('save-changes');" 
                           onfocus="javascript:setBorder('save-changes');"
                           type="button" value="<?php _e("Save", "cardozapolldomain");?>"/></center>
            </form>
            </div>
        <?php
        
    }
}
?>
