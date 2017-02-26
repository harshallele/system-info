
//shorthand because $ doesn't seem to work
var jq = jQuery;

var systemInfo = null;
//progress bar elements
var bar_cpu,bar_mem,bar_hdd;

/* 

*/


jq(window).load(function(){
    //set the system info once, repeat every 15 secs
    getAndSetSystemInfo();

    setInterval(getAndSetSystemInfo,15000);


    //iniitalise progress bars
    bar_cpu = new ProgressBar.Line('#hlele-bar-cpu', {
        strokeWidth: 1.5,
        easing: 'easeOut',
        duration: 500,
        color: '#B71C1C',
        trailColor: '#FFCDD2',
        trailWidth: 1,
        svgStyle: {width: '100%', height: '50%'},
    });

    bar_mem = new ProgressBar.Line('#hlele-bar-mem', {
        strokeWidth: 1.5,
        easing: 'easeOut',
        duration: 500,
        color: '#B71C1C',
        trailColor: '#FFCDD2',
        trailWidth: 1,
        svgStyle: {width: '100%', height: '50%'},

    });

    bar_hdd = new ProgressBar.Line('#hlele-bar-hdd', {
        strokeWidth: 1.5,
        easing: 'easeOut',
        duration: 500,
        color: '#B71C1C',
        trailColor: '#FFCDD2',
        trailWidth: 1,
        svgStyle: {width: '100%', height: '50%'},

    });

});

var getAndSetSystemInfo = function(){

    //Send POST request to get the latest system info. The 'action' property is used by the server to identify what plugin this request is for 
    var data = {
        'action': 'sendSysInfo'
    };
    jq.post(ajaxurl,data,function(data){
        systemInfo = JSON.parse(data);
        setInfo();
        setBars();

    });


};

//set values of uptime,memory,hdd and network
var setInfo = function(){
    jq('#uptime-text').text('Uptime:'+systemInfo.uptime);
    jq('#mem-val').text(systemInfo.mem_used+"GB/"+systemInfo.mem_total+"GB");
    jq('#hdd-val').text(systemInfo.hdd_used+"GB/"+systemInfo.hdd_total+"GB");
    jq('#net-rx-val').text(systemInfo.network_rx+"GB");
    jq('#net-tx-val').text(systemInfo.network_tx+"GB");

};

//set progress bars
var setBars = function(){

    bar_cpu.animate((systemInfo.cpu/100));
    bar_mem.animate((systemInfo.mem_percent/100));
    bar_hdd.animate((systemInfo.hdd_percent/100));
};