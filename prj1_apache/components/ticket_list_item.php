<?php
// not sure if this is best practise in php as there's allot of projects that move away from the "component" design

/*
This file basically takes advantage of the fact that when you include a php file inside another
the parent file (so the initial file) will basically pass down all it's global variables down to the included file.
This might be slightly problematic in larger projects as there will be allot of global variables that you need to 
keep track of and as PHP is not a strongly typed language it makes it a bit "iffy"
*/
echo (
    '
    <div class="list-item shadow-subtle">
            <h4 class="media-left flex perfect-center">'.$date.'</h4>
            <h4 class="media-middle flex perfect-center">'.$description.'</h4>
            <span class="media-right flex perfect-center" style="padding: 0px !important;">
                <p class="accent-text">'.$availability.'</p>
                <form action="../Purchase.php" style="width: 100%;height: 100%;">
                    <input hidden name="ticket_id" value="'.$T_ID.'">
                    <button type="submit" class="list-item-right-label">Buy <b>($'.$price.')</b></button> 
                </form>

            </span>
    </div>
    '
)


?>