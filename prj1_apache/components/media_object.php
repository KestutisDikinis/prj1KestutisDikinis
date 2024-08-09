<?php

/*
This file basically takes advantage of the fact that when you include a php file inside another
the parent file (so the initial file) will basically pass down all it's global variables down to the included file.
This might be slightly problematic in larger projects as there will be allot of global variables that you need to
keep track of and as PHP is not a strongly typed language it makes it a bit "iffy"
*/

/* INPUT VARIABLES */
// $img -> String (URL of IMG or base64 encoded string)
// $date -> String (07 - June)
// $description -> String (lorem ipsum)
// $price -> String ($6.40)
// $ID -> Int? (1)
echo(
    '
    
    <div class=" flex list-item shadow-subtle">
            <span class="media-left" style="width: 10%; overflow: hidden;">
            <img style="height: 30vh;" src="'.$img.'" />
            </span>
    
            <span class="flex flex-col-4 flex-direction-column">
                <h3>' . $title . '</h3>
                <p style="height: 12vh;margin-top: 0;" class="mo-description">' . $description . '</p>
                <sub>lorem ipsum</sub>
            </span>

            <span class="flex flex-col-1 flex-align-end flex-direction-column" style="padding: 5px !important; min-width: 18vw;">
                
                <a href="http://localhost/view_event.php?id='.$ID.'#TICKETS" class="link-button list-item-right-button flex perfect-center">Tickets</a>
                <br />
                <a href="http://localhost/view_event.php?id='.$ID.'" class="list-item-right-button flex perfect-center">View</a>
            </span>
    </div>
    '
)

?>