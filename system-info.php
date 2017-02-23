<?php

/*
Plugin Name: System Info
Author: Harshal Lele



*/
    //include the file that gets the system info and get system info
    include_once ("sysinfo.php");





    add_action("wp_dashboard_setup","hlele_add_dashboard_widget");
    hlele_enqueue_bootstrap();


    
    function hlele_enqueue_bootstrap(){
         // JS
        wp_register_script('hlele_bootstrap', plugins_url('js/bootstrap.min.js',__FILE__));
        wp_enqueue_script('hlele_bootstrap');

        // CSS
        wp_register_style('hlele_bootstrap', plugins_url('css/bootstrap-paper.min.css',__FILE__));
        wp_enqueue_style('hlele_bootstrap');

    }
    
    
    
    function hlele_add_dashboard_widget(){
        wp_add_dashboard_widget("hlele_sysinfo_dashboard","System Information","setSysInfo");
    }

    function setSysInfo(){
        $infoObj = getSystemInfo();
        echo "<a class='btn btn-default'>Test</a>";

    }

       



?>