<!DOCTYPE html>
<html>
<head>
	<title>Test Player</title>

	<script src="js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/jwplayer/jwplayer.js"></script>
	<script type="text/javascript">jwplayer.key="+w2dT5h4jJ27TMTalFPJE/IWsZ2cIzBT0BxnHA==";</script>
</head>
<body>
<div class="v-player"><div id="v-player">Loading the player...</div>
 
<script type="text/javascript"> 
 //JWplayer
    jwplayer("v-player").setup({
        file: "http://arena-n.ru/upload/trailers/kinopoisk.ru-Hercules-213462.mp4",
        width: 600,
        height: 320,
		autostart: true
    });
</script>


</body>
</html>
