<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
    <title>W0CHP-PiStar-Dash Live Display</title>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/functions.js?version=1.720"></script>
    <style>
        /*  Pr0nHub/W0CHP Color Pallete FTW! \o/ ;^) */
        @import url('/css/fonts.css');
        body {
          background-color: #1B1B1B;
        }
        .live-page-wrapper {
          margin-right: auto;
          margin-left: auto;
          background-color: #1B1B1B;
          font-family: 'Inconsolata', monospace;
        }

        .row {
          display: flex;
          flex-direction: row;
          flex-wrap: wrap;
        }

        .column {
          display: flex;
          flex-direction: column;
          flex: 1 1 auto;
        }

        .orange-column {
          background-color: #E59217;
          padding: 20px;
          flex-grow: 4;
          align-items: baseline;
          align-content: stretch;
        }

        .dark-column {
          background-color: #1B1B1B;
          padding: 20px;
          flex-grow: 3;
          align-items: baseline;
          align-content: stretch;
        }

        .footer-column {
          background-color: #111111;
          padding: 20px;
          flex-grow: 2;
          align-items: baseline;
          align-content: stretch;
        }
</style>
    </head>
    <body>
    <script type="text/javascript">
		$(function() {
    		setInterval(function(){
        		$('#liveDetails').load('/mmdvmhost/live_caller_backend.php');
    		}, 1500);
		});
    </script>
    <div id="liveDetails">
      <?php include '/mmdvmhost/live_caller_backend.php'; ?>
    </div>
    </body>
</html>
