<?php

class CWPViewStats {
    function __construct($vars = null) {
        ?>
        <div id="tab5" class="tab-content">
            <h3>Poll Statistics</h3>
            <?php
            $controller = new CWPController();
            $vars = $controller->getPollStats();
            $votes = $vars['votes'];
            $label = $vars['label'];
            if(!empty($votes)){
                $max_value = 0;
                
                foreach($votes as $vote){
                    if($vote>$max_value) $max_value = $vote; 
                }

                if($max_value<10) $max_value = 10;

                if(($max_value%10) != 0) $max_y_axis_value = ($max_value+10-($max_value%10));
                else $max_y_axis_value = $max_value;
            ?>
            <div id="box">
            <input type="button" onclick="javascript:getPollStatsjs(7)" value="Last 7 days statistics"/>
            <input type="button" onclick="javascript:getPollStatsjs(15)" value="Last 15 days statistics"/>
            <input type="button" onclick="javascript:getPollStatsjs(30)" value="Last 30 days statistics"/>
            </div>
            <div id="clear"></div>
            <div id="box">                
            <div id="cwp-graph">
                <div id="cwp-xaxis">
                    <?php print $label;?>
                </div>
                <div id="cwp-yaxis">
                    <?php 
                    for($i=0; $i<10; $i++){?>
                        <div class="cwp-yaxis-label">
                            <?php print $max_y_axis_value-(($max_y_axis_value/10)*$i);?>-
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div id="cwp-graph-content">
                    <?php
                        $bar_width = 545/sizeof($votes);
                        if($bar_width>5) $bar_width = $bar_width-1;
                        $bar_width = $bar_width;
                        $bar_height = (493/$max_y_axis_value);
                    ?>
                    <?php foreach($votes as $key=>$vote){?>
                    <div id="cwp-graph-bar" 
                         style="width:<?php echo $bar_width;?>px;
                                height:<?php echo $bar_height*$vote;?>px;
                                margin-top:<?php echo 500-($bar_height*$vote);?>px;
                                margin-left:<?php if($bar_width<5) echo '0';else echo '1';?>px" 
                         title ="Date:<?php echo date('d/m/y',$key)." - ".$vote;?> Votes">
                    </div>
                    <?php }?>
                </div>
                
            </div>
            </div>
            <?php }
            else{
                print "No data available to analyze. If you have installed or updated the plugin recently, poll statistics will not be available until someone votes.";
            }
?>
       </div>
        <?php
    }

}
?>
