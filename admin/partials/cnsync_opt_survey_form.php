<style>
    .wrap{
        max-width: 1000px;
        margin: 0 auto;
    }

    h1.cn_title {
        /*background: url(../images/shortcoder.png) no-repeat left;*/
        background-size: 32px 32px;
        padding-bottom: 9px;
    }
    h1.cn_title .title-count {
        font-size: 10px;
        padding: 2px 8px;
        opacity: 0.7;
    }
    .head_wrap {
        padding: 15px 0;
        position: relative;
    }

    #content{
        background: #fff;
        padding: 20px;
        border: 1px solid #dfdfdf;
        border-radius: 3px;
        box-shadow: 0 0 4px -3px;
    }

    .page_title {
        border-bottom: 1px solid #dfdfdf;
        margin: -20px -20px 20px -20px;
        padding: 1em;
        background: #fafafa;
        position: relative;
    }

    .cn_list {
        margin: -20px 0;
        position: relative;
    }
    .cn_list li {
        margin: 0;
        position: relative;
    }
    .cn_list li a {
        text-decoration: none;
    }
    .cn_list li .cn_link {
        display: block;
        margin: 0 -20px;
        padding: 20px;
        border-bottom: 1px solid #dfdfdf;
        font-size: 18px;
    }
    .cn_list li:last-child .cn_link{
        border-bottom: 0;
    }
    .cn_link:hover{
        background: #fffeea;
    }
    /*    .cn_link:hover:after {
            font-family: dashicons;
            content: "\f464";
            font-size: 15px;
            position: absolute;
            margin-left: 10px;
        }*/
    .cn_controls {
        position: absolute;
        top: 7px;
        right: 0;
    }
    .cn_list .cn_controls a {
        padding: 10px;
        border-radius: 50%;
        margin: 0 0 0 15px;
        border: 1px solid transparent;
        display: inline-block;
    }
    .cn_list .cn_controls a:hover{
        /*border: 1px solid #dfdfdf;*/
    }

    .cn_list .cn_delete:hover{
        border-color: red;
        color: red;
    }

    .cn_list:empty:before {
        content: attr( data-empty );
        position: absolute;
        left: 0;
        right: 0;
        text-align: center;
        font-style: italic;
        top: 25px;
    }
    .cn_list:empty {
        height: 70px;
    }
    .spin{
        animation: spin infinite 1s;
    }
    .cn_copy_box {
        position: absolute;
        top: -2px;
        font-size: 20px;
        width: 92%;
        padding: 16px;
        left: -22px;
        display: none;
        cursor: copy;
        background: #e6fffe !important;
        box-shadow: none !important;
        text-align: center;
    }
    .cn_list .disabled_text{
        font-size: 10px;
        background: #ffdfdd;
        border-radius: 10px;
        padding: 2px 10px;
        margin: 0 0 0 10px;
        color: #F44336;
    }

    .cn_tags_list {
        display: inline-block;
        vertical-align: middle;
        position: relative;
    }
    .cn_tags_list li {
        float: left;
        background: transparent;
        padding: 0.5em;
        border-radius: 3px;
        margin-left: 0.75em;
        color: #717171;
        /*box-shadow: 0 1px 2px -1px;*/
        cursor: pointer;
    }
    .cn_tags_list li:hover {
        box-shadow: 0 1px 2px -1px;
        background: #fff;
    }
    .cn_tags_list:before {
        content: "\f323";
        font-family: Dashicons;
        position: absolute;
        left: -15px;
        top: 10px;
        color: #9c9c9c;
    }


    .cn_tags_filt_btn{
        padding: 0 !important;
    }
    .cn_tags_filt_btn .cn_tags_filt_icon{
        padding: 0 10px;
    }
    .cn_tags_filt_btn.active .cn_tags_filt_icon{
        padding: 0 5px;
    }
    .cn_tags_filt_btn:active, .cn_tags_filt_btn.active{
        transform: none !important;
    }
    .cn_tags_filt_btn.active .cn_tags_filter_wrap{
        display: inline-block;
    }
    .cn_tags_filter_wrap{
        width: 260px;
        display: none;
    }
    .cn_tags_filter_wrap .selectize-input{
        height: 26px;
        padding: 2px !important;
        border-radius: 0 3px 3px 0;
        border: none;
        border-left: 1px solid #dfdfdf;
    }
    .cn_tags_filter_wrap .selectize-control{
        margin: 0;
        text-align: left;
    }
    .cn_tags_filter_wrap .item{
        background: #e1f6ff !important;
        color: #2196F3 !important;
        font-size: 10px;
    }
    .cn_tags_filter_wrap .item:hover{
        opacity: 0.5;
    }
    .cn_tags_filter_wrap .item.active{
        color: red !important;
        background: #ffe1e1 !important;
    }

    .cn_menu{
        position: absolute;
        top: 10px;
        right: 20px;
    }
    .cn_menu > *{
        margin-left: 10px !important;
    }

    #content .button .dashicons{
        margin: 0.3em 0 0 0;
        font-size: 15px;
    }

    .cn_section{
        margin: 0 0 20px 0;
    }
    .cn_section label{
        display: block;
        margin: 0 0 10px 0;
    }
    .cn_section label select{
        font-size: 12px;
        margin-top: 10px;
    }

    .cn_settings {
        display: flex;
        flex-wrap: wrap;
    }
    .cn_settings .cn_section {
        flex: 1;
        margin-bottom: 0;
    }

    #cn_name{
        padding: 10px;
    }
    .cn_name_wrap {
        position: relative;
    }

    .cn_name_wrap > .copy_shortcode {
        position: absolute;
        top: 1px;
        right: 1px;
        bottom: 1px;
        padding: 10px;
        border-left: 1px solid #d0d0d0;
        background: rgba(255, 255, 255, 0.5);
    }

    .page_footer{
        margin: 30px -20px -20px -20px;
        background: #f7f7f7;
        padding: 20px;
        border-top: 1px solid #dfdfdf;
        border-radius: 0 0 5px 5px;
    }
    .page_footer .cn_delete_ep{
        float: right;
    }
    .page_footer .cn_delete_ep:hover{
        color: red;
    }

    .wrap .notice{
        margin-bottom: 0;
    }

    .params_wrap{
        /*box-shadow: 0 3px 5px rgba(0,0,0,.2);*/
        border: 1px solid #dfdfdf;
        margin: 0;
        position: absolute;
        display: none;
        background: #fff;
        z-index: 9999;
    }
    .params_wrap li{
        position: relative;
        background: #fff;
        margin: 0;
        padding: 7px 10px;
        width: 200px;
        border-bottom: 1px solid #dfdfdf;
        cursor: pointer;
    }
    .params_wrap li:hover{
        background: lightyellow;
    }
    .params_wrap > li:after{
        position: absolute;
        font-family: dashicons;
        content: "\f139";
        right: 5px;
        top: 7px;
    }
    .params_wrap li:last-child{
        border: 0;
    }
    .params_wrap li ul{
        background: #fff;
        position: absolute;
        display: none;
        top: 0;
        left: 100%;
        box-shadow: 0 3px 5px rgba(0,0,0,.2);
        border: 1px solid #dfdfdf;
        z-index: 9999;
        max-height: 300px;
        overflow: auto;
    }
    .params_wrap li:hover ul{
        display: block;
    }

    .params_wrap .cp_form{
        cursor: auto;
        width: 300px;
    }
    .cp_form h4{
        margin: 0 0 15px 0;
    }
    .cp_info{
        margin: 5px 0;
    }
    .cp_info.red{
        color: red;
    }

    .top_sharebar{
        position: absolute;
        right: 0;
        top: 24px;
    }
    .top_sharebar > * {
        vertical-align: middle;
        margin-left: 10px;
        float: right;
    }
    .share_text {
        font-size: 10px;
        text-align: right;
        line-height: 1.5;
        margin-right: 5px;
        color: #838383;
    }
    .share_btn{
        background: #333;
        color: #fff;
        text-decoration: none;
        padding: 2px 10px;
        border-radius: 2em;
        font-size: 12px;
        line-height: 2em;
    }
    .share_btn:hover{
        opacity: 0.5;
        color: #fff;
    }
    .share_btn:active, .share_btn:focus{
        color: #fff;
    }
    .share_btn .dashicons {
        font-size: 14px;
        margin: 5px 2px 0 0;
        height: 14px;
    }
    .share_btn.twitter{
        background-color: #2196F3;
    }
    .share_btn.googleplus{
        background-color: #dd4b39;
    }
    .share_btn.rate_btn .dashicons{
        color: #FF9800;
    }

    .coffee_box{
        padding: 15px 15px 25px 15px;
        border: 1px solid #4CAF50;
        padding-left: 18%;
        background: url(../images/coffee.svg) no-repeat;
        border-radius: 3px;
        background-position: 30px center;
        margin: 30px 0 15px 0;
        background-size: 84px;
    }
    .coffee_box .coffee_amt {
        width: 120px;
        padding: 5px;
        height: auto;
        font-size: 1.5em;
    }
    .coffee_amt_wrap{
        float: right;
        margin: 0 30px;
    }
    .credits_box{
        font-size: 12px;
        font-style: italic;
        color: #757575;
    }
    .credits_box img {
        vertical-align: middle;
        margin-right: 5px;
    }

    #import_form{
        display: none;
    }
    .search_btn .search_box{
        display: none;
    }
    .search_btn.active .search_box{
        display: inline;
    }
    .search_box{
        height: 26px;
        border: 0;
        margin: 0 -10px 0 10px;
        border-left: 1px solid #ccc;
        border-radius: 0 3px 3px 0;
    }
    .search_btn .dashicons-search{
        position: relative;
    }
    .search_btn.filtered .dashicons-search{
        color: #f44336;
    }
    .search_empty_msg{
        margin: 40px 0 20px 0;
    }

    .cn_note{
        background: #fffbdc;
        padding: 10px;
        color: #965400;
        border-radius: 5px;
        position: relative;
        padding-left: 50px;
        box-shadow: 0 2px 1px -2px;
        display: none;
    }
    .cn_note:before {
        content: "\f348";
        font-family: dashicons;
        position: absolute;
        left: 15px;
        font-size: 25px;
        opacity: 0.8;
        top: 12px;
    }
    .cn_note_btn {
        margin: 0 0 0 5px;
        font-size: 15px;
        height: 15px;
        vertical-align: middle;
    }

    .cn_editor_list {
        position: relative;
        display: inline-block;
    }
    .cn_editor_list select{
        padding: 0 30px !important;
    }
    .cn_editor_list:before {
        font-family: Dashicons;
        position: absolute;
        left: 10px;
        top: 6px;
    }
    .cn_editor_icon_text:before{
        content: "\f215";
    }
    .cn_editor_icon_visual:before{
        content: "\f177";
    }
    .cn_editor_icon_code:before{
        content: "\f475";
    }
    .cn_editor_list:after{
        font-family: Dashicons;
        content: "\f140";
        position: absolute;
        right: 25px;
        top: 15px;
        font-size: 15px;
        padding: 0;
        width: 0;
        height: 0;
        line-height: 0;
    }

    .cn_cm_menu .cn_editor_list{
        margin-left: 5px;
    }

    .rate_link{
        float: right;
    }
    .rate_link .dashicons{
        color: #e7711b;
        text-decoration: none;
        font-size: 13px;
    }
    .rate_link:hover .dashicons{
        text-decoration: underline;
    }
    .rate_link .dashicons {
        font-size: 12px;
        margin: 5px 0 0 0;
    }

    .help_link{
        margin-left: 10px;
        text-decoration: none;
    }
    .help_link .dashicons{
        font-size: 32px;
        width: 32px;
        height: 32px;
        color: #607D8B;
    }
    .help_link:hover .dashicons{
        color: #000;
    }

    .fright{
        float: right;
    }

    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }

    .clearfix:after{
        clear: both;
        content: ".";
        display: block;
        height: 0;
        visibility: hidden;
        font-size: 0;
    }

    .CodeMirror{
        border: 1px solid #ccc;
        margin-top: 15px;
    }

    @media screen and (max-width: 950px) {
        .cn_settings {
            display: block;
        }
        .cn_settings .cn_section {
            margin-bottom: 20px;
        }
    }

    [tooltip]{
        margin: 20px 60px;
        position:relative;
        display:inline-block;
    }
    [tooltip]::before {
        content: "";
        position: absolute;
        top:-6px;
        left:50%;
        transform: translateX(-50%);
        border-width: 4px 6px 0 6px;
        border-style: solid;
        border-color: rgba(0,0,0,0.7) transparent transparent transparent;
        z-index: 99;
        opacity:0;
    }
    [tooltip]::after {
        content: attr(tooltip);
        position: absolute;
        left:50%;
        top:-6px;
        transform: translateX(-50%) translateY(-100%);
        background: rgba(0,0,0,0.7);
        text-align: center;
        color: #fff;
        padding: 2px 8px !important;
        font-size: 12px;
        min-width: 80px;
        border-radius: 5px;
        pointer-events: none;
        padding: 4px 4px;
        z-index:99;
        opacity:0;
    }
    [tooltip]:hover::after,[tooltip]:hover::before {
        opacity:1
    }
</style>
<div class="wrap">
    <div class="head_wrap">
        <h1 class="cn_title dashicons-before dashicons-cloud">CloudNet360 Survey Forms</h1>
    </div>
    <div id="content">
        <h3 class="page_title">Shortcoder 
            <div class="cn_menu">
                <a href="<?php echo admin_url(); ?>admin.php?page=survey" class="button cn_back_btn">
                    <span class="dashicons dashicons-arrow-left-alt2"></span>Back to Form list</a>
            </div>
        </h3>
        <form method="post" id="cn_edit_form">
            <div class="cn_section">
                <label for="cn_name">Name</label>
                <div class="cn_name_wrap">
                    <input type="text" id="cn_name" name="cn_name" value="<?php echo ($data['formname'] != '') ? $data['formname'] : ''; ?>" class="widefat" required="required" placeholder="Enter a name for the form, case sensitive" pattern="[a-zA-z0-9 \-]+">
                    <?php if (isset($_GET['id']) != '') { ?>
                        <div class="copy_shortcode">
                            Your shortcode is - 
                            <strong>
                                <?php echo '[cn_opt_survey_form id =' . $_GET['id'] . ']'; ?>
                            </strong>
                        </div>
                    <?php } else { ?>
                        <div class="copy_shortcode">Allowed characters A to Z, a to z, 0 to 9, hyphens, underscores and space</div>
                    <?php } ?>
                </div>

            </div>
            <div class="cn_section">
                <label for="cn_content">Add action survey code below<span class="dashicons dashicons-info cn_note_btn" title="Put form data in below box."></span>
                </label>

                <div id="wp-cn_content-wrap" class="wp-core-ui wp-editor-wrap html-active">
                    <?php
                    $content = '';
                    if ($data['formdata'] != '') {
                        $content = stripslashes($data['formdata']);
                    }
                    $editor_id = 'form_content';
                    wp_editor($content, $editor_id);
                    ?>
                </div>
            </div>
            <div class="cn_settings">
                <div class="cn_section"><h4>Settings</h4><label>
                        <input type="checkbox" name="cn_disable" value="1" <?php echo ($data['status'] == '1') ? "checked" : ""; ?> > Temporarily disable this form shortcode</label>
                </div>
                <div class="cn_section"><h4>Visibility</h4>
                    <label>Show this form shortcode</label>
                    <select name="cn_devices">
                        <option value="all" <?php echo ($data['visible'] == 'all') ? 'selected="selected"' : ''; ?>>On both desktop and mobile devices</option>
                        <option value="mobile_only" <?php echo ($data['visible'] == 'mobile_only') ? 'selected="selected"' : ''; ?>>On mobile devices alone</option>
                        <option value="desktop_only" <?php echo ($data['visible'] == 'desktop_only') ? 'selected="selected"' : ''; ?>>On desktops alone</option>
                    </select>
                </div>
            </div>
            <footer class="page_footer">
                <input class="button button-primary cn_save" type="submit" name="cn_survey_save" value="Save settings">
                <?php wp_nonce_field('cn_survey_save_action', 'cn_create_survey_form'); ?>
            </footer>
        </form>
    </div>
</div>