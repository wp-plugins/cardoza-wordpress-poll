<?php
/*
 * Filename: CWPViewCreatePoll.class.php
 * This is the class file which will have all the markup for the 
 * user interface to create a new poll.
 */

class CWPViewCreatePoll extends CWPView{

    function __construct() {?>

        <div id="tab2" class="tab-content">
            <form id="create-poll" name="create_poll">
                <h3>Poll Friendly Name</h3>
                <div id="box">
                    <div id="label">Friendly name* :</div>
                    <input id="poll-name" name="poll_name" style="width:350px;"
                           onblur="javascript:setBorderDefault('poll-name');" 
                           onfocus="javascript:setBorder('poll-name');" type="text" value=""/>
                    <div id="clear"></div>
                </div>
                <h3>Poll Question</h3>
                <div id="box">
                    <div id="label">Question* :</div>
                    <input id="poll-question" name="poll_question" style="width:350px;"
                           onblur="javascript:setBorderDefault('poll-question');" 
                           onfocus="javascript:setBorder('poll-question');" type="text" value=""/>
                    <div id="clear"></div>
                </div>
                <h3>Poll Answers</h3>
                <div id="box">
                    <div class="answers">
                        <div id="answer1"><div id="label">Answer 1* :</div>
                            <input id="ans1" name="answer1" type="text" value="" style="width:350px;" />
                            <div id="clear"></div>
                        </div>
                        <div id="answer2"><div id="label">Answer 2* :</div>
                            <input id="ans2" name="answer2" type="text" value="" style="width:350px;" />
                            <div id="clear"></div>
                        </div>
                    </div>
                    <center>
                        <input id="add-answer" 
                               onblur="javascript:setBorderDefault('add-answer');" 
                               onfocus="javascript:setBorder('add-answer');" 
                               onclick="javascript:appendAnswers()"
                               type="button" value="Add answer"/>
                        <input id="remove-answer" 
                               onblur="javascript:setBorderDefault('remove-answer');" 
                               onfocus="javascript:setBorder('remove-answer');" 
                               onclick="javascript:removeAnswers()"
                               type="button" value="Remove Answer"/>
                    </center>
                </div>
                <h3>Poll Answer type</h3>
                <div id="box">
                    <div id="label">Allow users to select* :</div>
                    <select name="poll_answer_type" id="poll-answer-type"
                            onblur="javascript:setBorderDefault('poll-answer-type');" 
                            onchange="javascript:showanswers(this.value)"
                            onfocus="javascript:setBorder('poll-answer-type');">
                        <option value="one">Only one answer</option>
                        <option value="multiple">More than one answer</option>
                    </select>
                    <div id="clear"></div>
                    <div id="nanswers" style="display:none">
                        <div id="label">No of answers to allow* :</div>
                        <input id="no-of-answers" style="width:40px" name="no_of_answers" type="text" value="" />
                    </div>
                    <div id="clear"></div>
                </div>
                <h3>Poll Start/End Date</h3>
                <div id="box">
                    <div id="label">Start Date* :</div>
                    <input id="start_date" type="text" name="s_date" style="width:100px;"/> <b>Format: </b> mm/dd/yyyy
                    <div id="clear"></div>
                    <div id="label">End Date* :</div>
                    <input id="end_date" type="text" name="e_date" style="width:100px;"/> <b>Format: </b> mm/dd/yyyy
                    <div id="clear"></div>
                </div><center>
                    <input type="hidden" name="action" value="save_poll" />
                    <input id="add-answer" 
                           onclick="javascript:validateAddNewPollForm()"
                           onblur="javascript:setBorderDefault('add-answer');" 
                           onfocus="javascript:setBorder('add-answer');"
                           type="button" value="Add New Poll"/></center>
            </form>
        </div> 
        <?php
    }

}
?>