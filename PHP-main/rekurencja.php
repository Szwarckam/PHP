<?php
function rabbitsEden($month){
    if($month == 1){
        return 1;
    }elseif ($month == 0){
        return 0;
    }
        return rabbitsEden($month -1) + rabbitsEden($month -2);   
}
echo rabbitsEden(12);