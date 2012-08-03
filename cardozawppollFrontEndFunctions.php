<?php

function displayPollResults( $vars){
    $poll_answers = $vars['poll_answers'];
    $total = $vars['total_votes'];
    $option_value = $vars['option_value'];
    $poll = $vars['poll'];
    $answer_type = $poll->answer_type;
    $total_votes = 0;  
    $poll_id = $vars['poll']->id;
    if(!empty($option_value['bar_height'])) 
        $bar_height = $option_value['bar_height'];
    else $bar_height = "10";
    if(!empty($option_value['bar_color'])) 
        $bar_color = $option_value['bar_color'];
    else 
        $bar_color = "CCC";
    ?>
    <div id="show-results<?php echo $poll_id;?>" class="show-results<?php echo $poll_id;?>">
    <?php
        if($answer_type == "multiple") print "<div class='total-voters'><b>".__("Total voters", "cardozapolldomain").": </b>".$total."</div>";

        foreach($poll_answers as $answer){
            $total_votes = $total_votes + $answer->votes;
        }
        print "<div class='total-votes'><b>".__("Total votes", "cardozapolldomain").": </b>".$total_votes."</div>";
        $answer_count = 0;
        $total_answer_count = sizeof($poll_answers);
        $total_width = 0;
        foreach($poll_answers as $answer){
            $answer_count++;
            $votes = $answer->votes;
            if($total_votes!=0) $width = ($votes/$total_votes)*100;
            else $width = 0;
            if($answer_count == $total_answer_count) $width = 100 - $total_width;
            else $total_width = $total_width + round($width);
            print "<div class='result-answer'>".$answer->answer." (".$answer->votes.__(" votes", "cardozapolldomain").", ".round($width)."%)</div>";
            print '<div style="height:'.$bar_height.'px;width:'.$width.'%;background-color:#'.$bar_color.'"></div>';
        } 
    ?>
    </div>
	<?php
}

function showPollForm($vars){
    
    $poll_answers = $vars['poll_answers'];
    $total = $vars['total_votes'];
    $option_value = $vars['option_value'];
    $poll = $vars['poll'];
    $option = 1;
    $exp_time = $vars['exp_time'];
    
    ?>
    <div id="show-form<?php echo $poll->id;?>" class="show-form<?php echo $poll->id;?>">
        <?php
        foreach($poll_answers as $answer){
            if($poll->answer_type == "one"){?>
                <input type="radio" name="<?php print $poll->id;?>" value="<?php print $answer->id;?>"><?php print $answer->answer;?><br/>
            <?php
            }
            if($poll->answer_type == "multiple"){?>
                <input type="checkbox" name="option<?php print $option;?>" value="<?php print $answer->id;?>"><?php print $answer->answer;?><br/>
            <?php
            }
            $option++;
        }?>
        <input type="hidden" value="<?php print $poll->id;?>" name="poll_id" />
        <input type="hidden" value="<?php print $exp_time;?>" name="expiry" />
        <input type="hidden" value="<?php print $poll->answer_type;?>" name="answertype"/>
        <input type="hidden" value="submit_vote" name="action"/>
        <center><input id="poll-wh-style" type="button" value="<?php print __('Vote', 'cardozapolldomain');?>" onclick="javascript:vote_poll(<?php print $poll->id;?>)" /></center>                
    </div>
    <?php
}

function showPollFormSC($vars){
    
    $poll_answers = $vars['poll_answers'];
    $total = $vars['total_votes'];
    $option_value = $vars['option_value'];
    $poll = $vars['poll'];
    $option = 1;
    $exp_time = $vars['exp_time'];
    
    ?>
    <div id="show-form<?php echo $poll->id;?>" class="show-form<?php echo $poll->id;?>">
        <?php
        foreach($poll_answers as $answer){
            if($poll->answer_type == "one"){?>
                <input type="radio" name="<?php print $poll->id;?>" value="<?php print $answer->id;?>"><?php print $answer->answer;?><br/>
            <?php
            }
            if($poll->answer_type == "multiple"){?>
                <input type="checkbox" name="option<?php print $option;?>" value="<?php print $answer->id;?>"><?php print $answer->answer;?><br/>
            <?php
            }
            $option++;
        }?>
        <input type="hidden" value="<?php print $poll->id;?>" name="poll_id" />
        <input type="hidden" value="<?php print $exp_time;?>" name="expiry" />
        <input type="hidden" value="<?php print $poll->answer_type;?>" name="answertype"/>
        <input type="hidden" value="submit_vote" name="action"/>
        <center><input style="width:60px;height:25px;" type="button" value="<?php print __('Vote', 'cardozapolldomain');?>" onclick="javascript:vote_poll_sc(<?php print $poll->id;?>)" /></center>                
    </div>
    <?php
}

function previousPollsLink($vars){
    
    $option_value = $vars['option_value'];
    
    if($option_value['archive']=='yes'){
        ?>
        <div style="margin-top:10px;margin-bottom:10px;width:100%; border-bottom: 1px #000 dotted"></div>
        <?php
        $archive_url = $option_value['archive_url'];
        $url = explode('?', $archive_url);
        if(sizeof($url)>1) echo '<a href="'.$option_value['archive_url'].'&poll_archive_page_no=1">'.__('See all polls & results', 'cardozapolldomain').'</a>';
        else echo '<a href="'.$option_value['archive_url'].'?poll_archive_page_no=1">'.__('See all polls & results', 'cardozapolldomain').'</a>';
    }
}
?>
