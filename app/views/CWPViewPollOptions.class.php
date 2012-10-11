<?php

/*
 * Filename : CWPViewPollOptions.class.php
 * This class will create the user interface for the poll options tab.
 */
class CWPViewPollOptions extends CWPView {

    function __construct() {
        
        $controller = new CWPController();
        $opts = $controller->cwpp_options();
        ?>
        <div id="tab4" class="tab-content">
            <h3><?php _e('Poll options','cardozapolldomain');?></h3>
            <div id="box">
                <form id="poll-options">
                <div id="label"><?php _e('Who is allowed to vote?','cardozapolldomain');?> </div>
                <select name="poll_access" id="poll-access" class="slct"
                        onblur="javascript:setBorderDefault('poll-access');" 
                        onchange="javascript:showanswers(this.value)"
                        onfocus="javascript:setBorder('poll-access');">
                    <option value="all"
                    <?php
                        if(!empty($opts['poll_access']) && $opts['poll_access']=='all') echo " selected";
                    ?>        
                    ><?php _e('Anyone can poll','cardozapolldomain');?></option>
                    <option value="loggedin"
                    <?php
                        if(!empty($opts['poll_access']) && $opts['poll_access']=='loggedin') echo " selected";
                    ?>
                    ><?php _e('Only logged in users can poll','cardozapolldomain');?> </option>
                </select>
                <div id="clear"></div>
                
                <div id="label"><?php _e('Lock Poll by','cardozapolldomain');?> </div>
                <select name="poll_lock" id="poll-lock" class="slct">
                    <option value="cookies"
                    <?php
                        print $opts['poll_lock'];
                        if(!empty($opts['poll_lock']) && $opts['poll_lock']=='cookies') echo " selected";
                    ?>        
                    ><?php _e('Cookies','cardozapolldomain');?></option>
                    <option value="ipaddress"
                    <?php
                        if(!empty($opts['poll_lock']) && $opts['poll_lock']=='ipaddress') echo " selected";
                    ?>
                    ><?php _e('IP Address','cardozapolldomain');?></option>
                </select>
                <div id="clear"></div>
            </div>
            <h3><?php _e('Poll style options','cardozapolldomain');?></h3>
            <div id="box">
                <div id="label"><?php _e('Background colour','cardozapolldomain');?>: #</div>
                <input id="poll-bg-color" 
                       style="width:100px;"
                       onkeyup="javascript:getColor('bg-cp', this.value)"
                       onblur="javascript:setBorderDefault('poll-bg-color');" 
                       onfocus="javascript:setBorder('poll-bg-color');"
                       name="poll_bg_color" type="text" value="<?php if(!empty($opts['poll_bg_color'])) echo $opts['poll_bg_color'];?>" class="txt" />
                <div class="color-preview" id="bg-cp"></div>
                <div id="clear"></div>
                <div id="label"><?php _e('Colour','cardozapolldomain');?>: #</div>
                <input id="poll-bar-color" 
                       style="width:100px;"
                       onkeyup="javascript:getColor('bg-bc', this.value)"
                       onblur="javascript:setBorderDefault('poll-bar-color');" 
                       onfocus="javascript:setBorder('poll-bar-color');"
                       name="poll_bar_color" type="text" value="<?php if(!empty($opts['bar_color'])) echo $opts['bar_color'];?>" class="txt" />
                <div class="color-preview" id="bg-bc"></div>
                <div id="clear"></div>
                <div id="label"><?php _e('Height','cardozapolldomain');?> : </div>
                <input id="poll-bar-height" 
                       style="width:40px;"
                       onkeyup="javascript:pollSetHeight(this.value)"
                       onblur="javascript:setBorderDefault('poll-bar-height');" 
                       onfocus="javascript:setBorder('poll-bar-height');"
                       name="poll_bar_height" type="text" value="<?php if(!empty($opts['bar_height'])) echo $opts['bar_height'];?>" class="txt" />
                
                <div id="clear"></div>
                <div id="label"><?php _e('Preview of the poll bar','cardozapolldomain');?> : </div>
                <div class="color-preview" id="poll-preview"></div>
                <div id="clear"></div>
            </div>
            
            <h3><?php _e('Poll archive options','cardozapolldomain');?></h3>
            <div id="box">
                <div id="label"><?php _e('Polls to display in the older polls page','cardozapolldomain');?>: </div>
                <select style="width:250px;" name="polls_to_display_archive" id="poll-access" class="slct"
                        onblur="javascript:setBorderDefault('poll-access');" 
                        onchange="javascript:showanswers(this.value)"
                        onfocus="javascript:setBorder('poll-access');">
                    <option value="open" <?php if(!empty($opts['polls_to_display_archive']) && $opts['polls_to_display_archive']=='open') echo " selected";?>><?php _e('Opened Polls Only','cardozapolldomain');?></option>
                    <option value="closed" <?php if(!empty($opts['polls_to_display_archive']) && $opts['polls_to_display_archive']=='closed') echo " selected";?>><?php _e('Closed Polls Only','cardozapolldomain');?></option>
                    <option value="open-closed" <?php if(!empty($opts['polls_to_display_archive']) && $opts['polls_to_display_archive']=='open-closed') echo " selected";?>><?php _e('Opened and Closed Polls','cardozapolldomain');?></option>
                </select>
                <div id="clear"></div>
                <div id="label"><?php _e('No of polls to display per page in the older polls','cardozapolldomain');?>: </div>
                <select name="no_of_polls_to_display_archive" id="poll-access" class="slct"
                        onblur="javascript:setBorderDefault('poll-access');" 
                        onchange="javascript:showanswers(this.value)"
                        onfocus="javascript:setBorder('poll-access');">
                    <?php
                        for($i=1; $i<=10; $i++){
                            echo "<option value=".$i;
                            if(!empty($opts['no_of_polls_to_display_archive']) && $opts['no_of_polls_to_display_archive']==$i) echo " selected";
                            echo ">".$i."</option>";
                        }
                    ?>
                </select>
                <div id="clear"></div>
                
                <div id="label"><?php _e('Poll archive URL','cardozapolldomain');?>: </div>
                <input id="archive-url" 
                       style="width:350px;"
                       onblur="javascript:setBorderDefault('archive-url');" 
                       onfocus="javascript:setBorder('archive-url');"
                       name="archive_url" type="text" value="<?php if(!empty($opts['archive_url'])) echo $opts['archive_url'];?>" class="txt" />
                <div id="clear"></div>
            </div>
            <center>
            <input type="hidden" name="action" value="save_poll_options" />
            <input id="save-poll-options"
                   onclick="javascript:savePollOptions()"
                   onblur="javascript:setBorderDefault('save-poll-options');" 
                   onfocus="javascript:setBorder('save-poll-options');"
                   type="button" value="<?php _e('Save','cardozapolldomain');?>"/></center>
            </form>
        </div>
<?php
    }

}
?>
