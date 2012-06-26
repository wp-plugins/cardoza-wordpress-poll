<?php
class CWPViewUserLogs{
    function __construct() {?>
            <div id="tab6" class="tab-content">
                <h4>This feature will show the list of users voted for a particular poll.</h4>
                <h4>The results will be shown only when the logged in users has voted for the poll. (The answers will be visible only for the votes after 26.06.2012)</h4>
                <h3>Poll User Logs</h3>
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
                                <td align="center"><input name="polluserlogs" type="button" onclick="javascript:userlogs(<?php echo $poll->id;?>)" value="View User Logs"/></td>
                            </tr>
                        <?php
                        $total_votes = $total_votes +  $poll->total_votes;
                        }
                        ?>
                    </form>
                </table>
            </div>
                <br />
                <div id="poll-logs"></div>
            </div>
        </div>
<?php }
}
?>
