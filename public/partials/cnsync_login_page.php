<?php

/**
 * Provide a public  area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://techexeitsolutions.com/
 * @since      1.0.0
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/public/partials
 */ ?>
<style>
    * {
        box-sizing: border-box
    }

    /* Add padding to containers */
    .cnsync>.container {
        padding: 16px;
        border: 2px black solid;
        background-color: gray;
    }

    /* Full-width input fields */
    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus,
    input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity: 1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }

    .error {
        color: red;
    }
</style>

<body>
    <div class="cnsync container">
        <?php
        
        cnsync_show_error_messages(); ?>
        <p>Please fill in this form to create an account.</p>
        <p id="data"></p>
        <hr>
        <form method="post" id="myform" name="login_account">
            <label for="email"><b>Username</b></label>
            <input type="text" placeholder="Enter Email" name="username" id="username" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" id="password" required>

            <hr>
            <input type="hidden" value="login_account" name="action">
            <button type="submit" name="login_account" id="login_account">Login</button>
        </form>
    </div>
</body> 