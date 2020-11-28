<?php
include_once('../../css/css-base.php');
?>
@import url('https://fonts.googleapis.com/css2?family=Inconsolata:ital,wght@0,400;0,500;0,600;0,700;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap');

body {
	background-color: <?php echo $backgroundBanners; ?>;
}

.red {
	color:red;
}

.green {
	color:green;
}

.network {
        border:1px solid;
	text-align:left;
        padding-top:5px;
        padding-left:5px;
	background-color: <?php echo $tableRowOddBg; ?>;
}

.tableft {
	display:inline-block;
	text-align:right;
	width:120px;
}

textarea {
        width:699px;
        height:499px;
}

input.button {
        width:80%;
        border:1px solid;
}

input[type=text],input[type=password] {
	border:1px solid;
}

input[type=button],input[type=submit] {
	border:1px solid;
	border-radius:5px;
}

input[type=button]:hover,input[type=submit]:hover {
	color: <?php echo $textNavbarHover; ?>;
	background-color: <?php echo $backgroundNavbarHover; ?>;
}

.infoheader {
	width:100%;
	text-align:center;
	margin-top:10px;
	border-bottom: 1px solid;
	color : <?php echo $textBanners; ?>;
}

.infobox {
	background-color: <?php echo $backgroundBanners; ?>;
	font-weight: bold;
	width:100%;
}

.intinfo {
	background-color: <?php echo $tableRowOddBg; ?>;
	color: <?php echo $textContent; ?>;
	width: 398px;
	text-align: left;
	border-right: 1px solid;
	border-left: 1px solid;
	float: left;
        border-bottom:1px solid;
	font-family: 'Inconsolata', monospace;
}

.wifiinfo {
	background-color: <?php echo $tableRowOddBg; ?>;
	color: <?php echo $textContent; ?>;
	margin: 0 0 0 400px;
	border-right: 1px solid;
	text-align: left;
        border-bottom:1px solid;
	font-family: 'Inconsolata', monospace;
}

.intheader {
	background-color: <?php echo $backgroundBanners; ?>;
	color: <?php echo $textBanners; ?>;
	text-align:center;
	width:100%;
	font-weight: bold;
}

.intfooter {
	background-color: <?php echo $backgroundBanners; ?>;
	color: <?php echo $textBanners; ?>;
	width:100%;
	border-top:1px solid;
	float:left;
	text-align:center;
}

.tail {
	background-color: <?php echo $backgroundBanners; ?>;
	color: <?php echo $backgroundBanners; ?>;
	width:100%;
}
