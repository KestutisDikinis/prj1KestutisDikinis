
<article class="card">
    <div
            <?php
            if(isset($barcode)){
                echo 'class="thumb barcode"';
            }else{
                echo 'class="thumb"';
            }
            ?>
            style="background-image: url('<?php echo $bg_img; ?>');" ></div> <!-- bg image here -->
    <div class="infos">
        <h2 class="title">
            <?php
            if (strlen(trim($title)) > 13){
                $truncatedTitle = substr($title, 0, 10) . '...';
                echo trim($truncatedTitle);
            }else{
                echo trim($title);
            }

            ?>
            <span>
                <?php if(isset($icon)){
                    echo '<img class="icon" src="'.$icon.'" />';
                }else{
                    echo '<img class="icon" src="./img/event_icon.svg" />';
                }
                ?>

            </span>
        </h2>
        <h3 class="date"><?php echo $date?></h3>
        <h3 class="uploader">
            <?php
            $organizer = null;
            if(isset($ID)){
                $organizer = get_event_organizer($ID);
                echo "<a class='secondary-text' href='/organizer_profile.php?id=".$organizer["account_id"]."'>" .$organizer["username"]. "</a>";
            }

            ?>
        </h3>
        <p class="txt">
            <?php
            if (strlen(trim($description)) > 153){
                $truncatedDesc = substr($description, 0, 153) . '...';
                echo trim($truncatedDesc);
            }else{
                echo trim($description);
            }
            ?>
        </p>
        <h3 class="details">
            <?php echo "<a class='secondary-text' href='http://localhost/view_event.php?id=".$ID."'>event details</a>"?>

        </h3>
    </div>
</article>