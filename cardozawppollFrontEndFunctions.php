<?php

function displayPollResults($vars){
    
    $poll_answers = $vars['poll_answers'];
    $total = $vars['total_votes'];
    $option_value = $vars['option_value'];
    $poll_id = $vars['poll_id'];
    $poll = $vars['poll'];
    $answer_type = $poll->answer_type;
    $total_votes = 0;  
    
    if($answer_type == "multiple") print "<b>Total Voters: </b>".$total."<br/>";
    
    foreach($poll_answers as $answer){
        $total_votes = $total_votes + $answer->votes;
    }
    print "<b>Total Votes: </b>".$total_votes."<br/>";
    
    foreach($poll_answers as $answer){
                      
        $votes = $answer->votes;
        
        if($total_votes!=0) $width = ($votes/$total_votes)*100;
        else $width = 0;
        
        print $answer->answer." (".$answer->votes." votes, ".intval($width)."%)";
        
        ?>
        
        <br/>
        
        <div style="height:<?php if(!empty($option_value['bar_height'])) echo $option_value['bar_height'];else echo "10";?>px;
        width:<?php echo $width?>%;background-color:#<?php if(!empty($option_value['bar_color'])) echo $option_value['bar_color'];else echo "CCC";?>"></div>
        
    <?php
    }
    
}

function showPollForm($vars){
    
    $poll_answers = $vars['poll_answers'];
    $total = $vars['total_votes'];
    $option_value = $vars['option_value'];
    $poll = $vars['poll'];
    $option = 1;
    $exp_time = $vars['exp_time'];
    
    ?>
    <div id="show-form<?php echo $poll->id;?>" >
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
        <center><input id="poll-wh-style" type="button" value="Vote" onclick="javascript:vote_poll(<?php print $poll->id;?>)" /></center>                
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
    <div id="show-form<?php echo $poll->id;?>" >
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
        <center><input style="width:60px;height:25px;" type="button" value="Vote" onclick="javascript:vote_poll_sc(<?php print $poll->id;?>)" /></center>                
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
        if(sizeof($url)>1) echo '<a href="'.$option_value['archive_url'].'&poll_archive_page_no=1">See all polls &amp; results</a>';
        else echo '<a href="'.$option_value['archive_url'].'?poll_archive_page_no=1">See all polls &amp; results</a>';
    }
}
?>
