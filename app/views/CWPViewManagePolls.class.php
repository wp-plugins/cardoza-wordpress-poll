<?php

/*
 * Filename : CWPViewManagePolls
 * This is will create an interface to manage polls
 */

class CWPViewManagePolls{

    function init() {?>

        <div id="all-polls">
            <div id="tab1" class="tab-content">
                <div id="manage-polls">
                <input id="refresh-list" class="inpt"
                    onclick="javascript:refreshPollList()"
                    onblur="javascript:setBorderDefault('refresh-list');" 
                    onfocus="javascript:setBorder('refresh-list');" type="button" value="Refresh Poll List"/>
                <input id="edit-poll" class="inpt"
                    onblur="javascript:setBorderDefault('edit-poll');" 
                    onfocus="javascript:setBorder('edit-poll');" type="button" value="Edit a Poll" onclick="javascript:editPoll()" />
                <input id="delete-poll" class="inpt"
                    onblur="javascript:setBorderDefault('delete-poll');" 
                    onfocus="javascript:setBorder('delete-poll');" type="button" value="Delete a Poll" onclick="javascript:deletePoll()" />
                <br />     
                <div id="all-polls">
                <table width="100%" style="background-color: #4A7194;color:#333;">
                    <thead style="background-color: #4A7194;color:#FFF;height:30px;">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Question</th>
                        <th>Answer type</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Status</th>
                        <th>Total votes</th>
                        <th>View Results</th>
                    </thead>
                    <form id="manage-poll">
                        <?php
                        $controller = new CWPController();
                        $polls = $controller->getPollList();
                        $total_votes = 0;
                        foreach($polls as $poll){?>

                                <tr style="background-color: #ECF1EF;height:40px;">
                                    <td align="center"><?php print $poll->id;?></td>
                                    <td style="padding-left:3px;"><?php print $poll->name;?></td>
                                    <td style="padding-left:3px;"><?php print $poll->question;?></td>
                                    <td style="padding-left:3px;"><?php print $poll->answer_type;?></td>
                                    <td align="center"><?php print $poll->start_date;?></td>
                                    <td align="center"><?php print $poll->end_date;?></td>
                                    <td align="center">
                                    <?php
                                    $timestamp = $controller->getStrToTime($poll->end_date);
                                    $current_time = time();
                                    if($current_time < $timestamp) echo "Open";
                                    else echo "Closed"
                                    ?>
                                    </td>
                                    <td align="center"><?php print $poll->total_votes;?></td>
                                    <td align="center"><input name="view_poll_results" type="button" onclick="javascript:viewPollResults(<?php print $poll->id;?>)" value="View Result"/></td>
                                </tr>
                        <?php
                        $total_votes = $total_votes +  $poll->total_votes;
                        }
                        ?>
                    </form>
                </table>
                    <br/>
                <div id="box">
                <div id="label" style="color:#000;">Total No of Votes :</div>&nbsp;&nbsp;&nbsp;<?php print $total_votes;?>
                <div id="clear"></div>
                </div>
            </div>
            </div>
                </div>
        </div>
<?php }

}
?>
