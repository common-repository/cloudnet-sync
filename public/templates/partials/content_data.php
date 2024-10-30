<div class="cn360-section">
    <div class="product-dis" style="padding: 15px !important;">
        <?php
        $post_id = get_the_ID();
        $post = get_post($post_id);

        $content = apply_filters('the_content', $post->post_content);
        echo $content;

        ?>

        <!----- tabs-box ---->
    </div>
    <?php
    $file = get_field('file');
    if ($file) : ?>
        <?php
        if ($file['type'] == 'image') :
            $icon =  $file['sizes']['thumbnail'];
        ?>
            <div class="cn360-btn">
                <img src="<?php echo $icon; ?>">
            </div>
        <?php endif;
        if ($file['type'] == 'application') :
            $icon =  wp_get_attachment_url($file['ID']);
        ?>
            <div class="cn360-btn">
                <div style="text-align:center">
                    <iframe src="https://docs.google.com/viewer?url=<?php echo $icon; ?>&embedded=true" frameborder="0" height="500px" width="80%"></iframe>
                </div>
            </div>
        <?php endif;
        if ($file['type'] == 'video') : 
            $icon =  wp_get_attachment_url($file['ID']);?>
            <div class="cn360-btn">
                <div style="text-align:center">
                    <video width="800" controls>
                        <source src="<?php echo $icon?>" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
            </div>
        <?php endif; 
        if ($file['type'] == 'audio') : 
            $icon =  wp_get_attachment_url($file['ID']);?>
            <div class="cn360-btn">
                <div style="text-align:center">
                    <audio width="800" controls>
                        <source src="<?php echo $icon?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <!----->
</div>