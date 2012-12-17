<?php

/*
 * Filename : CWPViewWidget.class.php
 * This will display the options of widget for poll
 */
class CWPViewWidget{
    
    function __construct() {
        $controller = new CWPController();
        $opts = $controller->cwpp_options();
        
        ?>
        <div id="tab5" class="tab-content">
            <h3><?php _e('Widget options','cardozapolldomain');?></h3>
            <div id="box">
                <form id="widget-options">
                <div id="label"><?php _e('Title','cardozapolldomain');?>: </div>
                <input id="widget-title" style="width: 300px;"
                       onblur="javascript:setBorderDefault('widget-title');" 
                       onfocus="javascript:setBorder('widget-title');"
                       name="widget_title" type="text" value="<?php if(!empty($opts['title'])) print $opts['title'];?>" class="txt" />
                <div id="clear"></div>
                <div id="label"><?php _e('Display Older Polls Link','cardozapolldomain');?>: * </div>
                <select class="slct" name="poll-archive" style="width:75px;">
                    <option value="yes"
                    <?php
                        if(!empty($opts['archive']) && $opts['archive']=='yes') echo " selected";
                    ?>
                    ><?php _e('Yes','cardozapolldomain');?></option>
                    <option value="no"
                    <?php
                        if(!empty($opts['archive']) && $opts['archive']=='no') echo " selected";
                    ?>
                    ><?php _e('No','cardozapolldomain');?></option>
                </select>
                <div id="clear"></div>
                <div id="label"><?php _e('Select the latest number of polls to be displayed','cardozapolldomain');?>: * </div>
                <select class="slct" name="no_of_polls" style="width:75px;">
                    <?php
                        for($i=1; $i<=10; $i++){
                            echo "<option value=".$i;
                            if(!empty($opts['no_of_polls']) && $opts['no_of_polls']==$i) echo " selected";
                            echo ">".$i."</option>";
                        }
                    ?>
                </select>
                <div id="clear"></div>
                <div id="label"><?php _e('Width','cardozapolldomain');?>: </div>
                <input id="widget-width" style="width: 50px;"
                       onblur="javascript:setBorderDefault('widget-width');" 
                       onfocus="javascript:setBorder('widget-width');"
                       name="widget_width" type="text" value="<?php if(!empty($opts['width'])) print $opts['width'];?>" class="txt" />px
                <div id="clear"></div>
                
                <div id="label"><?php _e('Height','cardozapolldomain');?>: </div>
                <input id="widget-height" style="width: 50px;"
                       onblur="javascript:setBorderDefault('widget-height');" 
                       onfocus="javascript:setBorder('widget-height');"
                       name="widget_height" type="text" value="<?php if(!empty($opts['height'])) print $opts['height'];?>" class="txt" />px
                <div id="clear"></div>
                <center>
                <input type="hidden" name="action" value="save_widget" />
                <input id="widget-opt" 
                       onclick="javascript:saveWidgetOptions()"
                       onblur="javascript:setBorderDefault('widget-opt');" 
                       onfocus="javascript:setBorder('widget-opt');"
                       type="button" value="<?php _e('Save','cardozapolldomain');?>"/></center>
                </form>
            </div>
        </div>
<?php
        
    }

}
?>
