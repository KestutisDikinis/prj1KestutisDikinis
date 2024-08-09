
    <div class="card-media">
        <!-- media container -->
        <div class="card-media-object-container">
            <div class="card-media-object">
                <img src="<?php echo $img; ?>" />
            </div>
            <ul class="card-media-object-social-list">
                <li>
                    <img src="../img/event_icon.svg" class="card-media-object-social-list-icon">
                </li>
            </ul>
        </div>
        <!-- body container -->
        <div class="card-media-body">
            <div class="card-media-body-top">
                <span class="subtle"><?php echo $date . " | " . $title;?></span>

            </div>
            <span class="card-media-body-heading"><?php echo $description;?></span>
            <div class="card-media-body-supporting-bottom">
                <span class="card-media-body-supporting-bottom-text subtle"><?php echo $location;?></span>
                <span class="card-media-body-supporting-bottom-text subtle u-float-right"><?php echo $price_range; ?></span>
            </div>
            <div class="card-media-body-supporting-bottom card-media-body-supporting-bottom-reveal">
                <span class="card-media-body-supporting-bottom-text subtle"><?php echo $category; ?></span>
                <a href="http://localhost/view_event.php?id=<?php echo $ID;?>#TICKETS" class="card-media-body-supporting-bottom-text card-media-link u-float-right">VIEW TICKETS</a>
                <?php if($_SESSION['role']==1){
                    echo '<a href="http://localhost/events_edit_admin.php?id='. $ID .'" class="card-media-body-supporting-bottom-text card-media-link u-float-right" style="margin-right: 20px">Edit Event</a>';
                } ?>
            </div>
        </div>
    </div>

