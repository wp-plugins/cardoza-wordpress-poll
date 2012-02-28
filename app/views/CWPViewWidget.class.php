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
        <div id="tab4" class="tab-content">
            <h3>Widget options</h3>
            <div id="box">
                <form id="widget-options">
                <div id="label">Title of the widget: </div>
                <input id="widget-title" style="width: 300px;"
                       onblur="javascript:setBorderDefault('widget-title');" 
                       onfocus="javascript:setBorder('widget-title');"
                       name="widget_title" type="text" value="<?php if(!empty($opts['title'])) print $opts['title'];?>" class="txt" />
                <div id="clear"></div>
                <div id="label">Display Older Polls Link: </div>
                <select class="slct" name="poll-archive" style="width:75px;">
                    <option value="yes"
                    <?php
                        if(!empty($opts['archive']) && $opts['archive']=='yes') echo " selected";
                    ?>
                    >Yes</option>
                    <option value="no"
                    <?php
                        if(!empty($opts['archive']) && $opts['archive']=='no') echo " selected";
                    ?>
                    >No</option>
                </select>
                <div id="clear"></div>
                <div id="label">Select the latest number of polls to be displayed: </div>
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
                <div id="label">Widget width: </div>
                <input id="widget-width" style="width: 50px;"
                       onblur="javascript:setBorderDefault('widget-width');" 
                       onfocus="javascript:setBorder('widget-width');"
                       name="widget_width" type="text" value="<?php if(!empty($opts['width'])) print $opts['width'];?>" class="txt" />
                <div id="clear"></div>
                <center>
                <div id="label">Widget height: </div>
                <input id="widget-height" style="width: 50px;"
                       onblur="javascript:setBorderDefault('widget-height');" 
                       onfocus="javascript:setBorder('widget-height');"
                       name="widget_height" type="text" value="<?php if(!empty($opts['height'])) print $opts['height'];?>" class="txt" /> 
                <div id="clear"></div>
                <input type="hidden" name="action" value="save_widget" />
                <input id="widget-opt" 
                       onclick="javascript:saveWidgetOptions()"
                       onblur="javascript:setBorderDefault('widget-opt');" 
                       onfocus="javascript:setBorder('widget-opt');"
                       type="button" value="Save Widget Options"/></center>
                </form>
            </div>
        </div>
<?php
        
    }

}
?>
