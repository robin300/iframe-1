<html style="margin:0;padding:0;">
    <head>
        <style type="text/css">
            body { margin:0 !important; background:#fff; color:#333; padding:0; font-family: sans-serif; }
            #headstrip { background:#333; padding:0px; }
            #logo { float:left; height:32px; width:32px; margin:10px; }
            #new { margin:10px; border-radius: 8px; float:right; background: #f90; padding: 8px 10px; font-size: 13px; font-weight: bold; cursor: pointer; }
            #info { float:right; height:32px; width:32px; border-radius:13px; background: #f90; margin:10px; line-height:32px; text-align:center; font-weight:bold; cursor: pointer; }
            p { margin:10px; }
            #historylist { padding:0; }
            #historylist li { padding:5px 10px; list-style-type: none; margin:0 5px 5px 0; cursor:pointer; }
        </style>
        <script type='text/javascript' src='http://clients.digitalmarmalade.co.uk/github/iframe/jquery-1.11.0.min.js'></script>
        <script type='text/javascript'>

            $(function(){

                var startState = '';

                function saveStartState() {                    
                    startState = $('body').html();
                }



                $('body').on('click', '.trg', function(){
                    goFrame($(this).data('href'));
                    return false;
                });

                $('#manualform').submit(function(){
                    if($('#manualitem').val() != '') {
                        var URL = $('#manualitem').val();
                        storeURL(URL);
                        goFrame(URL);
                        return false;
                    }
                });

                $('#new').click(function(){
                    var URL = prompt('Enter URL to put in iFrame', 'http://');
                    if(URL != null) {
                        storeURL(URL);
                        goFrame(URL);
                    }
                    return false;
                });

                function goFrame(URL) {
                    $('body').html('<iframe src="' + URL + '" width="100%" height="100%" frameborder="0" border="0" cellspacing="0"/>');
                }

                function storeURL(URL) {
                    console.log(URL);
                    var aURLs = JSON.parse(localStorage.getItem('github/iframe/history')) || [];
                    var id = (new Date()).getTime();
                    var data = {
                        id: id,
                        URL: URL
                    };
                    aURLs.push(data);
                    localStorage.setItem('github/iframe/history', JSON.stringify(aURLs));
                }

                function readURLs() {
                    var oHistory = JSON.parse(localStorage.getItem('github/iframe/history')) || [],
                        aHistory = [],
                        HTML = '',
                        i,
                        arrayOfTimestamps = [],
                        objectOfURLs = {};
                    
                    for (i = 0; i < oHistory.length; i = i + 1) {
                        arrayOfTimestamps.push(oHistory[i].id);
                        objectOfURLs[oHistory[i].id] = oHistory[i].URL;
                    }   

                    arrayOfTimestamps.sort(function (a, b) {return b - a; });

                    for (i = 0; i < oHistory.length; i = i + 1) {
                        HTML += '<li class="trg" data-href="' + objectOfURLs[arrayOfTimestamps[i]] + '">' + objectOfURLs[arrayOfTimestamps[i]] + '</li>';
                    }                        
                    $('#historylist').html(HTML);

                }

                readURLs();

            });

    onDeviceReady = function () {
        alert('remote onDeviceReady');
		document.addEventListener("backbutton", onBackKeyDown, false);
	};

	onBackKeyDown = function () {
		alert('remote onBackKeyDown');
		//navigator.app.exitApp();
	};

    function onLoad() {
        'use strict';
        alert('remote onLoad');
        document.addEventListener("deviceready", onDeviceReady, false);
    }

        </script>

    </head>
    <body onload="onLoad();" style="margin:0;">

        <div id="headstrip">
            <div id="logo"><img src="DM-LOGO-32.png"/></div>
            <div id="info">i</div>
            <div id="new">NEW</div>
            <div style="clear:both;height:0;"></div>
        </div>
        
        <ul id="historylist"></ul>

    </body>
</html>