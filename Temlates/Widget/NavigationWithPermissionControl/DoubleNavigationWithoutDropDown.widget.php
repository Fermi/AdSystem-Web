<div id="navigation" class="nav">
    <div id="top_navigation">
        <?php
            
            $echo_top_count = 0;
            echo "<ul id='top_nav' class='nav_top'>";
            foreach($navInfo as $top){
                if ($top['permission'] === 1) {
                    if ($echo_top_count === 0){
                        echo "<li id=".$echo_top_count." class='top default'>".$top['name']."</li>";
                        $echo_top_count ++;
                    } else {
                        echo "<li id=".$echo_top_count." class='top'>".$top['name']."</li>";
                        $echo_top_count ++;
                    }
                }
            }
            echo "</ul>";
        ?>
    </div>
    <div id="sub_navigation">
        <?php

            $echo_sub_count = 0;
            foreach($navInfo as $top){
                if ($top['permission'] === 1){
                    echo "<ul id='sub_nav' class='nav_sub'>";
                    foreach($top['sub'] as $sub){
                        if ($sub['permission'] === 1) {
                            echo "<li id=".$echo_sub_count." class='sub'>".$sub['name']."</li>";
                        }
                    }
                    echo "</ul>";
                }
            }
        ?>
    </div>

</div>
