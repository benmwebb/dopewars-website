<?php
  include "include/dopefunc.php";
  StartHTML("News","News");
?>

<dl>
<dt><b>21st October 2002</b></dt>
<dd>dopewars-1.5.8 released. The Windows and GTK+2.0 builds now have fairly
complete Unicode support. A default set of sounds is now provided, and
Windows XP is better supported.<p /></dd>

<dt><b>25th June 2002</b></dt>
<dd>dopewars-1.5.7 released. There is now sound support (ESD and/or SDL
on Unix systems, WinMM on Win32) although you have to provide your own WAVs
(musicians take note - if you can provide suitable copyright-free sounds,
then they can be included in future releases). Some minor bugs have been
fixed, and overall security has been tightened up.<p /></dd>

<dt><b>29th April 2002</b></dt>
<dd>dopewars-1.5.6 released. This corrects some problems with the GTK+2.0
client in non-UTF8 locales, fixes a server memory corruption bug, and adds
extra sanity checks to the server to foil cheating clients.<p /></dd>

<dt><b>13th April 2002</b></dt>
<dd>dopewars-1.5.5 released. The code should now compile with GTK+2.0,
and several minor glitches have been fixed.<p /></dd>

<dt><b>3rd March 2002</b></dt>
<dd>dopewars-1.5.4 released. This fixes bugs observed on the PPC platform,
and adds a configuration file editor to the graphical client.<p /></dd>

<dt><b>4th February 2002</b></dt>
<dd>dopewars-1.5.3 released. This fixes several bugs and annoyances in the
Windows version, and supports running the Windows server as an "NT Service".
The Unix server is now also more daemon-like.<p /></dd>

<dt><b>16th October 2001</b></dt>
<dd>dopewars-1.5.2 released. This features a new networking subsystem, with
HTTP/1.0 and SOCKS4&amp;5 support, and now has a familiar install/uninstall
program for Windows systems.<p /></dd>

<dt><b>19th June 2001</b></dt>
<dd>dopewars-1.5.1 released. This fixes a few minor bugs, and supports the
"new" metaserver on SourceForge.<p /></dd>

<dt><b>13th May 2001</b></dt>
<dd>dopewars-1.5.0 released. This improves on 1.4.8 by adding a graphical
client, and features many security and usability fixes.<p /></dd>

<dt><b>29th April 2001</b></dt>
<dd>Second beta release of 1.5.0, fixing several bugs that were reported
with the first beta.<p /></dd>

<dt><b>9th April 2001</b></dt>
<dd>Beta release of the new dopewars version, 1.5.0, which features a graphical
client, internationalisation, and rewrites of many parts of the code.<p /></dd>

<dt><b>10th September 2000</b></dt>
<dd>The dopewars project, previously hosted solely at 
<a href="http://bellatrix.pcl.ox.ac.uk/~ben/dopewars/">
http://bellatrix.pcl.ox.ac.uk/~ben/dopewars/</a> now has an additional home at
<a href="http://sourceforge.net/projects/dopewars/">SourceForge</a>! This is
to allow developers easier access to development codes (by CVS) and to take
advantage of SourceForge's mailing lists and forums. Translators are
particularly needed for translation of the
<a href="download.html#develop">development version</a> of the dopewars code
into other languages!<p /></dd>

<dt><b>2nd August 2000</b></dt>
<dd>The German translation now has its home
<a href="http://www.ideenpark.de/dopewars/">here</a>. This site also mirrors the
original English version of the program.<p /></dd>

<dt><b>28th July 2000</b></dt>
<dd>A <a href="http://www.rLUG.de/files/dopewars-german/">German translation</a>
of dopewars is now available.<p /></dd>

<dt><b>9th July 2000</b></dt>
<dd>dopewars 1.4.8 released. This features a complete revamp of the metaserver
interface - new servers now report game data, such as current number of players
and high scores, to the metaserver. Several bugs, mainly in the Win32
networking code, have been fixed.<p /></dd>

<dt><b>2nd July 2000</b></dt>
<dd>A mirror in the US is now available for dopewars downloads. Follow the US
links (as opposed to the UK links) on the
<a href="download.html">download page</a> to download from this site.<p /></dd>

<dt><b>14th January 2000</b></dt>
<dd>dopewars 1.4.7 released. This now uses autoconf to build on a variety
of "odd" Unices, and also "out of the box" under Cygwin (Win32). Servers for
which the IP is incorrectly resolved by the metaserver can now set a
preferred hostname with the "MetaServer.LocalName" variable.<p /></dd>

<dt><b>31st Decemeber 1999</b></dt>
<dd>The Polish version of dopewars has moved <a href="http://dresswars.mtl.pl/">
here</a>.<p /></dd>

<dt><b>12th November 1999</b></dt>
<dd>dopewars 1.4.6 released. This fixes a few minor bugs with 1.4.5, and is
now also available on the popular Windows platform. A Win32 binary can be
downloaded from the <a href="download.html">download page</a>.<p /></dd>

<dt><b>8th November 1999</b></dt>
<dd>A translation of the dopewars pages and dopewars client software into
Polish is now available at <a href="http://naboo.mtl.pl/~dopewars/">
http://naboo.mtl.pl/~dopewars/</a>.<p /></dd>

<dt><b>21st October 1999</b></dt>
<dd>dopewars 1.4.5 released. Client players can now be instructed to connect
to the metaserver, to present a "nice" list of available servers for the user
to select from; more configuration options; metaserver almost works with
web proxies now.<p /></dd>

<dt><b>11th October 1999</b></dt>
<dd>Snapshots of the latest in-development version of dopewars are now
made available on a semi-regular basis at the main <a href="download.html">
download page</a>. <a href="docs/index.html">HTML documentation</a> is also
now available.<p /></dd>

<dt><b>16th September 1999</b></dt>
<dd>dopewars 1.4.4 released. This handles connection to the new metaserver
automatically, so that the list of dopewars servers can be easily kept up
to date. Other minor changes fix small bugs from earlier versions.<p /></dd>

<dt><b>15th September 1999</b></dt>
<dd>Servers can now be registered by completing <a href="serverform.html">
this form</a>. The upcoming version 1.4.4 of dopewars will be able to
handle the connection to the web and the completion of registration details
automatically.<p /></dd>

<dt><b>23rd June 1999</b></dt>
<dd>dopewars 1.4.3 released. This adds many new features (while hopefully not 
adding any new bugs) such as much better fight handling, and the ability to 
customise dopewars servers and clients.<p /></dd>

<dt><b>16th May 1999</b></dt>
<dd>dopewars 1.4.2 released. This version fixes numerous minor bugs and makes 
many small improvements - most noticeable is the support for AI players in 
multiplayer games (dopewars -c).<p /></dd>

<dt><b>28th April 1999</b></dt>
<dd>Interim release of dopewars 1.4.1b, which fixes a segfault problem
with the server.<p /></dd>

<dt><b>28th April 1999</b></dt>
<dd>Interim release of dopewars 1.4.1a, which corrects a few minor bugs in
"antique" mode.<p /></dd>

<dt><b>27th April 1999</b></dt>
<dd>dopewars 1.4.1 released. This fixes a bug with the loan shark, which
was discovered by several people quick off the mark; dunno how that slipped 
past my team of beta testers here at Oxford - they're obviously too busy 
doing "real" work!<p /></dd>

<dt><b>27th April 1999</b></dt>
<dd>First GPL release of dopewars (1.4.0)</dd>

</dl>

<p>For more details, read the dopewars <a href="CHANGELOG">CHANGELOG</a>.</p>

<?php
  WriteNavLinks("News");
  EndHTML();
?>
