<?php

$stylefull =
'
<table width="95%" class="wpasc_rounded wpasc_shadow" bgcolor="#F5F5F5" cellspacing="10">
<tr>
<td valign="top">
<h2>%APPNAME%</h2>
<br />
by <a href="%DEVELOPERURL%" target="_blank">%DEVELOPERNAME%</a><br>
<br />
<b>%PRICE% %CURRENCY%</b><br />
<br />
%ITUNESLINK%<br />
<br />
%UNIVERSALAPP%<br />
</td>
<td>
<div align="right">%APPICON<175>%</div>
</td>
<tr>
<td colspan=2>
<p>
Customer ratings: %RATING% (%RATINGCOUNT% ratings)<br>
Category: %CATEGORIES%<br>
Languages: %LANGUAGES%<br>
Rated: %CONTENTRATING%
</p>
<p>
Updated: %RELEASEDATE%<br>
Version: %VERSION%<br>
Size: %FILESIZE%<br>
Requirements: %SUPPORTED%
</p>
</td>
</tr>
<tr>
<td colspan=2>
<h3>Description %APPNAME%</h3>
<p>%DESCRIPTION%</p>
<br />
<h3>What\'s new in Version %VERSION%</h3>
<p>%RELEASENOTES%</p>
</td>
</tr>
</table>
<br />
%SCREENSHOTS%
';
					
$styleinfobox = 
'
<table width="95%" class="wpasc_rounded wpasc_shadow" bgcolor="#F5F5F5" cellspacing="10">
<tr>
<td valign="top">
<h2>%APPNAME%</h2>
<br />
by <a href="%DEVELOPERURL%" target="_blank">%DEVELOPERNAME%</a><br>
<br />
<b>%PRICE% %CURRENCY%</b><br />
<br />
%ITUNESLINK%<br />
<br />
%UNIVERSALAPP%<br />
</td>
<td>
<div align="right">%APPICON<175>%</div>
</td>
<tr>
<td colspan=2>
<p>
Customer ratings: %RATING% (%RATINGCOUNT% ratings)<br>
Category: %CATEGORIES%<br>
Languages: %LANGUAGES%<br>
Rated: %CONTENTRATING%
</p>
<p>
Updated: %RELEASEDATE%<br>
Version: %VERSION%<br>
Size: %FILESIZE%<br>
Requirements: %SUPPORTED%
</p>
</td>
</tr>
<tr>
<td colspan=2>
<blockquote>%DESCRIPTION<250>%...</blockquote>
<br />
</td>
</tr>
</table>
<br />
%SCREENSHOTS%
';

$stylesmallbox = 
'
<table class="wpasc_rounded wpasc_shadow" bgcolor="#F5F5F5" cellspacing="10">
<tr>
<td>
%APPICON<90>%
<p><center>%RATING%</center></p>
</td>
<td>
<h2>%APPNAME%</h2>
<p>by <a href="%DEVELOPERURL%" target="_blank">%DEVELOPERNAME%</a></p>
%ITUNESLINK%<br />
%UNIVERSALAPP%<br />
<b>%PRICE% %CURRENCY%</b><br>
</td>
</table>
';

$liststyle1 =
'
<table width="95%" bgcolor="lightgrey" class="wpasc_rounded wpasc_shadow" cellspacing="10">
<tr>
<td colspan=2><h3>%POSITION%. <a href="%ITUNESLINK%"  target="_blank">%APPNAME%</a></h3></td>
</tr>
<tr><td colspan=2>
<table cellspacing="10">
<tr>
<td width="90" style="vertical-align: middle"><a href="%ITUNESLINK%"  target="_blank">%APPICON<100>%</a><br /><br /><center>[appstore id="%APPID%" style="%RATING%"]</center></td>
<td>
%DESCRIPTION<250>% <a href="%ITUNESLINK%" target="_blank">more</a><br />
in %CATEGORY%<br />
by %DEVELOPERNAME%<br />
</td>
</tr>
</table>
</td></tr>
</tr>
<tr>
<td>%PRICE%</td>
<td><div align="right">%RELEASEDATE%</div></td>
</tr>
</table>
<br />
';

$widgetstyle1 =
'
<div style="margin-right:10px;">
<table width="100%" style="vertical-align: top; border:1px solid grey;" cellspacing="10" class="wpasc_rounded wpasc_shadow">
<tr style="vertical-align: top">
<td style="vertical-align: top">%APPICON<50>%</td>
<td style="vertical-align: top">
%DEVELOPERNAME%<br />
<a href="%ITUNESLINK%" target="_blank">%APPNAME%</a><br />
%PRICE%
</td>
</tr>
</table>
<br />
</div>
';

$widgetstyle2 =
'
<table style="vertical-align: top" cellspacing="10">
<tr style="vertical-align: top">
<td style="vertical-align: top">%POSITION%. <a href="%ITUNESLINK%" target="_blank">%APPNAME%</a></td>
</tr>
<tr style="vertical-align: top">
<td style="vertical-align: top">
<table style="vertical-align: top" cellspacing=5>
<tr>
<td style="vertical-align: top">%APPICON<50>%</td>
<td style="vertical-align: top">
in: %CATEGORY%<br />
from: %RELEASEDATE%<br />
for: %PRICE%
</td>
</tr>
</table>
</td>
</tr>
</table>
<br />
';

$widgetstyle3 =
'
<table style="vertical-align: top" cellspacing="10">
<tr style="vertical-align: top">
<td style="vertical-align: top">%POSITION%. <a href="%ITUNESLINK%" target="_blank">%APPNAME%</a></td>
</tr>
<tr style="vertical-align: top">
<td style="vertical-align: top">
<table style="vertical-align: top" cellspacing=5>
<tr>
<td style="vertical-align: top">%APPICON<50>%</td>
<td style="vertical-align: top">
in: %CATEGORY%<br />
%PRICE%<br />
[appstore id="%APPID%" style="%RATING%"]
</td>
</tr>
</table>
</td>
</tr>
</table>
<br />
';

?>