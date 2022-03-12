<?php
include_once('css-base.php');
?>

@import url('/css/fonts.css');

.container {
    width: 100%;
    text-align: left;
    margin: auto;
    background : <?php echo $backgroundContent; ?>;
}

body, font {
    font: <?php echo $bodyFontSize; ?>px 'Source Sans Pro', sans-serif;
    color: #ffffff;
    -webkit-text-size-adjust: none;
    -moz-text-size-adjust: none;
    -ms-text-size-adjust: none;
    text-size-adjust: none;
}

.center {
    text-align: center;
}

.middle {
    vertical-align: middle;
}

.header {
    background : <?php echo $backgroundBanners; ?>;
    text-decoration : none;
    color : <?php echo $textBanners; ?>;
    font-family : 'Source Sans Pro', sans-serif;
    text-align : left;
    padding : 5px 0px 5px 0px;
}

.header h1 {
    margin-top:-10px;
    font-size: <?php echo $headerFontSize; ?>px;
}

.nav {
    float: left;
    margin : 0;
    padding : 3px;
    width : 230px;
    background : <?php echo $backgroundNavPanel; ?>;
    font-weight : normal;
    min-height : 100%;
}

.content {
    margin : 0 0 0 240px;
    padding : 1px 5px 5px 5px;
    color : <?php echo $textSections; ?>;
    background : <?php echo $backgroundContent; ?>;
    text-align: center;
}

.contentwide {
    padding: 3px;
    color: <?php echo $textContent; ?>;
    background: <?php echo $backgroundContent; ?>;
    text-align: center;
    margin-top: 5px;
}

.contentwide h2 {
    color: #<?php echo $textContent; ?>;
    font: 1em 'Source Sans Pro', sans-serif;
    text-align: center;
    font-weight: bold;
    padding: 0px;
    margin: 0px;
}

.footer {
    background : <?php echo $backgroundBanners; ?>;
    text-decoration : none;
    color : <?php echo $textBanners; ?>;
    font-family : 'Source Sans Pro', sans-serif;
    font-size : 9px;
    text-align : center;
    padding : 10px 0 10px 0;
    clear : both;
}

tt, code, kbd, pre {
        font-family: 'Inconsolata', monospace !important;
}

#tail {
    font-family: 'Inconsolata', monospace;
    height: 800px;
    width: 100%;
    overflow-y: scroll;
    overflow-x: scroll;
    color: #00ff00;
    background: #000000;
    font-size: 17px;
}

table {
    vertical-align: middle;
    text-align: center;
    empty-cells: show;
    padding: 0px;
    border-collapse:collapse;
    border-spacing: 4px;
    border: .5px solid <?php echo $tableBorderColor; ?>;
    text-decoration: none;
    background: #000000;
    font-family: 'Source Sans Pro', sans-serif;
    width: 100%;
    white-space: nowrap;
}

table th {
    font-family:  'Source Sans Pro', sans-serif;
    border: .5px solid <?php echo $tableBorderColor; ?>;
    font-weight: 600;
    text-decoration: none;
    color : <?php echo $textBanners; ?>;
    background: <?php echo $backgroundBanners; ?>;
    padding: 2px;
}

table tr:nth-child(even) {
    background: <?php echo $tableRowEvenBg; ?>;
}

table tr:nth-child(odd) {
    background: <?php echo $tableRowOddBg; ?>;
}

table td {
    color: <?php echo $textContent; ?>;
    font-family: 'Inconsolata', monospace;
    font-weight: 500;
    text-decoration: none;
    border: .5px solid <?php echo $tableBorderColor; ?>;
    padding: 2px;
    font-size: <?php echo "$mainFontSize"; ?>px;
}

.divTable{
    font-family:  'Source Sans Pro', sans-serif;
    display: table;
    border-collapse: collapse;
    width: 100%;
}

.divTableRow {
    display: table-row;
    width: auto;
    clear: both;
}

.divTableHead, .divTableHeadCell {
    color : <?php echo $textBanners; ?>;
    background: <?php echo $backgroundBanners; ?>;
    border: .5px solid <?php echo $tableBorderColor; ?>;
    font-weight: 600;
    text-decoration: none;
    padding: 2px;
    caption-side: top;
    display: table-caption; 
    text-align: center;
    vertical-align: middle;
}

.divTableCellSans {
    font-size: <?php echo "$contentFontSize"; ?>px;
    color: <?php echo $textContent; ?>;
}

.divTableCell {
    font-family: 'Inconsolata', monospace;
    font-weight: 500;
    font-size: <?php echo "$mainFontSize"; ?>px;
    border: .5px solid <?php echo $tableBorderColor; ?>;
    color: <?php echo $textContent; ?>;
}

.divTableCell, .divTableHeadCell {
    display: table-cell;
}

.divTableBody {
    display: table-row-group;
}

.divTableBody .divTableRow {
    background: <?php echo $tableRowEvenBg; ?>;
}

.divTableCell.hwinfo {
    padding: 4px;
}

body {
    background: <?php echo $backgroundPage; ?>;
    color: <?php echo $textContent; ?>;
}

a {
    text-decoration:none;
    
}

a:link, a:visited {
    text-decoration: none;
    color: <?php echo $textLinks; ?>
}

a.tooltip, a.tooltip:link, a.tooltip:visited, a.tooltip:active  {
    text-decoration: none;
    position: relative;
    color: <?php echo $textTableHeaderColor; ?>;
}

a.tooltip:hover {
    text-decoration: none;
    color: #FFFFFF;
    background: transparent;
}

a.tooltip span {
    text-decoration: none;
    display: none;
}

a.tooltip:hover span {
    text-decoration: none;
    display: block;
    position: absolute;
    top: 20px;
    left: 0;
    z-index: 100;
    color: #000000;
    border:1px solid #000000;
    background: #f7f7f7;
    font: 12px 'Source Sans Pro', sans-serif; 
    text-align: left;
    white-space: nowrap;
}

th:last-child a.tooltip:hover span {
    left: auto;
    right: 0;
}

a.tooltip span b {
    text-decoration: none;
    display: block;
    color: #000000;
    margin: 0;
    padding: 0;
    font-size: 12px;
    font-weight: bold;
    border: 0px;
    border-bottom: 1px solid black;
    background: #d0d0d0;
}

a.tooltip2, a.tooltip2:link, a.tooltip2:visited, a.tooltip2:active  {
    text-decoration: none;
    position: relative;
    font-weight: bold;
    color: #000000;
}

a.tooltip2:hover {
    text-decoration: none;
    color: #000000;
    background: transparent;
}

a.tooltip2 span {
    text-decoration: none;
    display: none;
}

a.tooltip2:hover span {
    text-decoration: none;
    display: block;
    position: absolute;
    top: 20px;
    left: 0;
    width: 202px;
    z-index: 100;
    color: #000000;
    border:1px solid #000000;
    background: #f7f7f7;
    font: 12px 'Source Sans Pro', sans-serif; 
    text-align: left;
    white-space: normal;
}

a.tooltip2 span b {
    text-decoration: none;
    display: block;
    color: #000000;
    margin: 0;
    padding: 0;
    font-size: 12px;
    font-weight: bold;
    border: 0px;
    border-bottom: 1px solid black;
    background: #d0d0d0;
}

ul {
    padding: 5px;
    margin: 10px 0;
    list-style: none;
    float: left;
}

ul li {
    float: left;
    display: inline; /*For ignore double margin in IE6*/
    margin: 0 10px;
}

ul li a {
    text-decoration: none;
    float:left;
    color: #999;
    cursor: pointer;
    font: 600 14px/22px 'Source Sans Pro', sans-serif;
}

ul li a span {
    margin: 0 10px 0 -10px;
    padding: 1px 8px 5px 18px;
    position: relative; /*To fix IE6 problem (not displaying)*/
    float:left;
}

ul.mmenu li a.current, ul.mmenu li a:hover {
    background: url(/images/buttonbg.png) no-repeat top right;
    color: #0d5f83;
}

ul.mmenu li a.current span, ul.mmenu li a:hover span {
    background: url(/images/buttonbg.png) no-repeat top left;
}

h1 {
    text-align: center;
    font-weight: 600;
}

/* CSS Toggle Code here */
.toggle {
    position: absolute;
    margin-left: -9999px;
    z-index: 0;
}

.toggle + label {
    display: block;
    position: relative;
    cursor: pointer;
    outline: none;
}

input.toggle-round-flat + label {
    padding: 1px;
    margin: 3px;
    border: 1px solid transparent;
    width: 33px;
    height: 18px;
    background-color: #dddddd;
    border-radius: 10px;
    transition: background 0.4s;
}

input.toggle-round-flat + label:before,
input.toggle-round-flat + label:after {
    display: block;
    position: absolute;
    content: "";
}

input.toggle-round-flat + label:before {
    top: 1px;
    left: 1px;
    bottom: 1px;
    right: 1px;
    background-color: #999;
    background: <?php echo $backgroundContent; ?>;
    border-radius: 10px;
    transition: background 0.4s;
}

input.toggle-round-flat + label:after {
    top: 2px;
    left: 2px;
    bottom: 2px;
    width: 16px;
    background-color:  #999;
    border-radius: 12px;
    transition: margin 0.4s, background 0.4s;
}

input.toggle-round-flat:checked + label {
    background-color: #ddd;
}

input.toggle-round-flat:checked + label:after {
    margin-left: 14px;
    background-color: <?php echo $backgroundBanners; ?>;
}

input.toggle-round-flat:focus + label {
    box-shadow: 0 0 2px <?php echo $backgroundBanners; ?>;
    padding: 1px;
    border: 1px solid <?php echo $backgroundBanners; ?>;
    z-index: 5;
}

.mode_flex .row {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  width: 100%;
}

.mode_flex .column {
  display: flex;
  flex-direction: column;
  flex-basis: 100%;
  flex: 1;
}

.mode_flex button {
    background: <?php echo $backgroundNavbar ?>;
    color: <?php echo $textNavbar ?>;
    flex-basis: 25%;
    flex-shrink: 0;
    text-align: center;
    justify-content: center;
    flex-grow: 1;
    font-family: 'Source Sans Pro', sans-serif;
    border: 1px solid <?php echo $tableBorderColor; ?>;
    padding: 2px;
}

.mode_flex button > span  {
    align-items: center; 
    flex-wrap: wrap;
    display: flex; 
    justify-content: center;
    margin: 3px;
    text-align: center;
}

textarea, input[type='text'] {
        font-size: <?php echo $bodyFontSize; ?>px;
        font-family: 'Inconsolata', monospace;
        border: 1px solid black;
        padding: 5px;
        margin 3px;
}

input[type=button], input[type=submit], input[type=reset], input[type=radio], button {
    font-size: <?php echo $bodyFontSize; ?>px;
    font-family: 'Source Sans Pro', sans-serif;
    border: 1px solid <?php echo $tableBorderColor; ?>;
    padding: 5px;
    text-decoration: none;
    margin: 3px;
    cursor: pointer;
    background: <?php echo $backgroundNavbar ?>;
    color: <?php echo $textNavbar ?>;
}

input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover, button:hover {
    color: <?php echo $textNavbarHover; ?>;
    background-color: <?php echo $backgroundNavbarHover; ?>;
}

input[type=button]:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

button:disabled {
    cursor: not-allowed;
    color: <?php echo $textModeCellDisabledColor; ?>;
    background: <?php echo $backgroundModeCellDisabledColor; ?>;
}

input:disabled + label {
    color: #000;
    opacity: 0.6;
    cursor: not-allowed;
}

select {
    background-color: #f1f1f1;
    font-family: 'Inconsolata', monospace;
    font-size: <?php echo $bodyFontSize; ?>px;
    border: 1px solid black;
    color: black;
    padding: 5px;
    text-decoration: none;
    margin: 3px;
}

.select2-selection__rendered {
  font-family: 'Inconsolata', monospace;
  font-size: <?php echo $bodyFontSize; ?>px;
}

.select2-results__options{
  font-size:<?php echo $bodyFontSize; ?>px !important;
  font-family: 'Inconsolata', monospace;
}

.navbar {
    overflow: hidden;
    background-color: <?php echo $backgroundNavbar; ?>;
}

.navbar a {
    float: right;
    font-family : 'Source Sans Pro', sans-serif;
    font-size: <?php echo $bodyFontSize; ?>px;
    color: <?php echo $textNavbar; ?>;
    text-align: center;
    padding: 5px 8px;
    text-decoration: none;
}

.dropdown .dropbutton {
    font-size: <?php echo $bodyFontSize; ?>px;
    border: none;
    outline: none;
    color: <?php echo $textNavbar; ?>;
    padding: 5px 8px;
    background-color: <?php echo $backgroundNavbar; ?>;
    font-family: inherit;
    margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbutton {
    color: <?php echo $textNavbarHover; ?>;
    background-color: <?php echo $backgroundNavbarHover; ?>;
}

.lnavbar {
    overflow: hidden;
    background-color: <?php echo $backgroundNavbar; ?>;
}

/* Expert menus */
.mainnav {
    display: inline-block;
    list-style: none;
    padding: 0;
    margin: 0 auto;
    width: 100%;
    background: <?php echo $backgroundNavbar; ?>;
    overflow: hidden;
}

.dropdown {
    position: absolute;
    top: 123px;
    width: 170px;
    opacity: 0;
    visibility: hidden;
}

.mainnav ul {
    padding: 0;
    list-style: none;
}

.mainnav li {
    display: block;
    float: left;
    font-size: 0;
    margin: 0;
    background: <?php echo $backgroundNavbar; ?>;
}

.mainnav li a {
    list-style: none;
    padding: 0;
    display: inline-block;
    padding: 1px 10px;
    font-family : 'Source Sans Pro', sans-serif;
    font-size: <?php echo $bodyFontSize; ?>px;
    color: <?php echo $textNavbar; ?>;
    text-align: center;
    text-decoration: none;
}

.mainnav .has-subs a:after {
    content: "\f0d7";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-left: 1em;
}

.mainnav .has-subs .dropdown .subs a:after {
    content: "";
}

.mainnav li:hover {
    background: <?php echo $backgroundNavbarHover; ?>;
}

.mainnav li:hover a {
    color: <?php echo $textNavbarHover; ?>;
    background-color: <?php echo $backgroundNavbarHover; ?>;
}

/* First Level */
.subs {
    position: relative;
    width: 170px;
}

.has-subs:hover .dropdown,
.has-subs .has-subs:hover .dropdown {
    opacity: 1;
    visibility: visible;
}

.mainnav ul li,
.mainav ul li ul li  a {
    color: <?php echo $textDropdown; ?>;
    background-color: <?php echo $backgroundDropdown; ?>;
}

.mainnav li:hover ul a,
.mainnav li:hover ul li ul li a {
    color: <?php echo $textDropdown; ?>;
    background-color: <?php echo $backgroundDropdown; ?>;
}

.mainnav li ul li:hover,
.mainnav li ul li ul li:hover {
    background-color: <?php echo $backgroundDropdownHover; ?>;
}

.mainnav li ul li:hover a,
.mainnav li ul li ul li:hover a {
    color: <?php echo $textDropdownHover; ?>;
    background-color: <?php echo $backgroundDropdownHover; ?>;
}

.mainnav .has-subs .dropdown .has-subs a:after {
    content: "\f0da";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    position: absolute;
    top: 1px;
    right: 9px;
}

/* Second Level */
.has-subs .has-subs .dropdown .subs {
    position: relative;
    top: -133px;
    width: 170px;
    border-style: none none none solid;
    border-width: 1px;
    border-color: <?php echo $backgroundDropdownHover; ?>;
}

.has-subs .has-subs .dropdown .subs a:after {
    content:"";
}

.has-subs .has-subs .dropdown {
    position: absolute;
    width: 170px;
    left: 170px;
    opacity: 0;
    visibility: hidden;
}

.menuconfig .menuadmin .menudashboard .menulive .menuupdate .menuupgrade .menupower .menulogs .menubackup .menuexpert .menureset .menusysinfo {
    position: relative;
}

.menuconfig:before {
    content: "\f1de";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menuadmin:before {
    content: "\f2bd";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menuupdate:before {
    content: "\f021";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menuupgrade:before {
    content: "\f1b8";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menupower:before {
    content: "\f011";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menulogs:before {
    content: "\f06e";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menudashboard:before {
    content: "\f0e4";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menulive:before {
    content: "\f21e";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}
.menubackup:before {
    content: "\f187";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menuexpert:before {
    content: "\f0a3";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menureset:before {
    content: "\f1cd";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.menusysinfo:before {
    content: "\f05a";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    padding-right: 0.2em;
}

.disabled-service-cell {
    color: <?php echo $textModeCellDisabledColor; ?>;
    background: <?php echo $backgroundModeCellDisabledColor; ?>;
}

.active-service-cell {
    color: <?php echo $textServiceCellActiveColor; ?>;
    background: <?php echo $backgroundServiceCellActiveColor; ?>;
}

.inactive-service-cell {
    color: <?php echo $textServiceCellInactiveColor; ?>;
    background: <?php echo $backgroundServiceCellInactiveColor; ?>;
}

.disabled-mode-cell {
    color: <?php echo $textModeCellDisabledColor; ?>;
    padding:2px;
    text-align: center;
    border:0;
    background: <?php echo $backgroundModeCellDisabledColor; ?>;
}

.active-mode-cell {
    color: <?php echo $textModeCellActiveColor; ?>;
    border:0;
    text-align: center;
    padding:2px;
    background: <?php echo $backgroundModeCellActiveColor; ?>;
}

.inactive-mode-cell {
    color: <?php echo $textModeCellInactiveColor; ?>;
    border:0;
    text-align: center;
    padding:2px;
    background: <?php echo $backgroundModeCellInactiveColor; ?>;
}

.paused-mode-cell {
    color: <?php echo $textModeCellActiveColor; ?>;
    border:0;
    text-align: center;
    padding:2px;
    background: <?php echo $backgroundModeCellPausedColor; ?>;
}

.paused-mode-span {
    background: <?php echo $backgroundModeCellPausedColor; ?>;
}

.error-state-cell {
    color: <?php echo $textModeCellInactiveColor; ?>;
    text-align: center;
    border:0;
    background: <?php echo $backgroundModeCellInactiveColor; ?>;
}

.table-container {
    position: relative;
}

/* Tame Firefox Buttons */
@-moz-document url-prefix() {
    select,
    input {
        margin : 0;
        padding : 0;
        border-width : 1px;
        font : 14px 'Inconsolata', monospace;
    }
    input[type="button"], button, input[type="submit"] {
        padding : 0px 3px 0px 3px;
        border-radius : 3px 3px 3px 3px;
        -moz-border-radius : 3px 3px 3px 3px;
    }
}

hr {
  display: block;
  height: 1px;
  border: 0;
  border-top: 1px solid <?php echo $tableBorderColor; ?>;
  margin: 1em 0;
  padding: 0; 
}

.status-grid {
  display: grid;
  grid-template-columns: auto auto auto auto auto auto;
  grid-template-rows: auto auto auto auto auto;
  margin:0;
  padding:0;
}


.status-grid .grid-item {
  padding: 1px;
  border: .5px solid <?php echo $tableBorderColor; ?>;
  text-align: center;
}

