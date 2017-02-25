<?php

/*
Plugin Name: System Info
Author: Harshal Lele



*/

    

    //include the file that gets the system info
    include_once ('sysinfo.php');

    //add action for wp_dashboard_setup hook that adds scripts,styles and a dashboard widget
    add_action('wp_dashboard_setup','hlele_add_dashboard_widget');
    //add action for POST request with 'action' property equal to 'sendSysInfo'
    add_action( 'wp_ajax_sendSysInfo', 'sendSysInfo' );

    function hlele_add_dashboard_widget(){
        
        wp_enqueue_style('hlele_stylesheet',plugins_url('/css/styles.css',__FILE__));
        
        wp_enqueue_script('hlele_main_script',plugins_url('/js/hlele_main.js',__FILE__) , array('jquery'));
        
        wp_enqueue_script('hlele_progressbar_script',plugins_url('/js/progressbar.min.js',__FILE__));
        

        wp_add_dashboard_widget('hlele_sysinfo_dashboard','System Information','hlele_setSysInfo');
    }

    //set the system info in the widget
    function hlele_setSysInfo(){
        
        $infoObj = json_decode(getSystemInfo());
        //$infoObj = getSystemInfo();
        //echo $infoObj;

        echo 
        '
            <div class="header">'
                //OS name,hostname, and uptime
                . '<div class="header-main">' . ($infoObj->hostname) . '</div>' . '<small class="os-text">' . ($infoObj->os) . '</small>' . '<div class="uptime-text" id="uptime-text">Uptime:'. ($infoObj->uptime) .'</div>'
                . '<hr>' 
                //CPU model 
                . '<div class="cpu-header">CPU</div><small class="cpu-model">' . ($infoObj->cpu_model) . '</small>'
                //progressbar of CPU percentage
                . '<div id="hlele-bar-cpu"></div>'
                //Memory(used/total)
                . '<div class="mem-header">Memory</div><small class="mem-val" id="mem-val">' . ($infoObj->mem_used) . 'GB/' . ($infoObj->mem_total) . 'GB' . '</small>'
                //progressbar for memory usage
                . '<div id="hlele-bar-mem"></div>'
                //HDD(used/total)
                . '<div class="hdd-header">Storage</div><small class="hdd-val" id="hdd-val">' . ($infoObj->hdd_used) . 'GB/' . ($infoObj->hdd_total) . 'GB' . '</small>'
                //progressbar for HDD
                . '<div id="hlele-bar-hdd"></div>'
                //Network upload and download
                . '<div class="net-header">Network</div>'
                . '<div class="net-rx">Download: <span class="net-rx-val" id="net-rx-val">' . ($infoObj->network_rx) . 'GB</span></div>'
                . '<div class="net-tx">Upload:   <span class="net-tx-val" id="net-tx-val">' . ($infoObj->network_tx) . 'GB</span></div>'
            .'</div>'
            
        ;
        
        
    }

    //respond to the POST request by sending system info
    function sendSysInfo(){
        $info = json_decode(getSystemInfo());
        echo json_encode($info);
        wp_die();
    }
    





?>