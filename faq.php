<?php
  include "include/dopefunc.php";
  StartHTML("Frequently-Asked Questions","FAQ");
?>

<ul>
<li><a href="#os">What operating systems is dopewars available for?</a></li>
<li><a href="#depend">What other packages do I need to install
dopewars?</a></li>
<li><a href="#help">I want to help out. What can I do?</a></li>
<li><a href="#windows">I can't download the Windows version!</a></li>
<li><a href="#platform">Is dopewars available for my platform and
operating system?</a></li>
<li><a href="#others">I thought this game was called "Dope Wars 2.0" or
"Dopewars 2000" or "Drug Wars" - what's going on?</a></li>
<li><a href="#days">All of a sudden the game just stops for no reason, and I
have to restart. What's going on?</a></li>
<li><a href="#moredays">31 turns isn't long enough. How do I get a longer
game?</a></li>
<li><a href="#sounds">The game could do with some sounds or extra graphics -
can you add them?</a></li>
<li><a href="#segfault">The game segfaults all the time when I try to page or
talk to other players! I'm using the latest RPM.</a></li>
<li><a href="#glib">Do I <i>really</i> need GLib to build dopewars from
the source code? I just want to use the text-mode client.</a></li>
<li><a href="#winsock">I keep getting a "Cannot Initialize WinSock" error on
Windows 95 - how do I fix it?</a></li>
<li><a href="#bug">I've found a bug! Fix it please.</a></li>
<li><a href="#feature">Can you add <i>&lt;feature&gt;</i> ?.</a></li>
</ul>

<dl>
<dt><a id="os"><b>What operating systems is dopewars available
for?</b></a></dt>
<dd>dopewars was originally developed on a RedHat Linux box, and should be
portable to most flavours of Unix. It will also run under Win32 systems
(Windows 95, Windows 98, Windows NT and Windows 2000). See also
<a href="#platform">this other FAQ.</a><p /></dd>

<dt><a id="depend"><b>What other packages do I need to install
dopewars?</b></a></dt>
<dd>You'll need the <a href="http://www.gtk.org/">GLib</a>
library for starters. (See <a href="#glib">this other FAQ</a>.) To use the
text-mode client on Unix machines, the <b>curses</b> library is
required (although the similar <b>ncurses</b> and <b>cur_colr</b>
libraries should work just fine). To use the graphical
<a href="http://www.gtk.org/">GTK+</a> client on Unix machines, the GTK+
libraries are required. No libraries other than GLib are required on Win32
platforms.<p /></dd>

<dt><a id="help"><b>I want to help out. What can I do?</b></a></dt>
<dd>Even if you're not a programmer, there are lots of things that you can
do, such as designing sounds or graphics for the program, translating it
into non-English languages, or customising the game with local city and drug
names. See the <a href="docs/contribute.html">How to contribute</a> page.
<p /></dd>

<dt><a id="windows"><b>I can't download the Windows
version!</b></a></dt>
<dd>Just click on the link on the <a href="download.html">download page</a>.
Opt to "Run this program from its current location" and click OK. Internet
Explorer will probably, at this point, pop up a security warning. There is
nothing wrong with the program - this just means that I haven't forked out
buckets of cash to buy an Authenticode signature to placate Internet Explorer.
Click the "Yes" button, and then a fairly standard installation program will
run. Once this program has finished, you should be able to run dopewars from
your Start Menu or, if you clicked the relevant option, directly from your
Desktop.<p /></dd>

<dt><a id="platform"><b>Is dopewars available for my platform and
operating system?</b></a></dt>
<dd>
As <a href="#os">stated above</a>, dopewars works on Microsoft Windows
systems and most Unix variants, which includes Linux and Mac OS X. Binaries
are provided for a number of popular operating systems on the
<a href="download.html">download page</a> (some of these binaries are
available directly from this site, while some are built by third parties).
For other operating systems (e.g. most palmtop computers), dopewars probably
won't work, but don't despair - there are many games that are very similar
to dopewars, and so it's likely that you can play one of these on your
system. See the <a href="#others">next FAQ</a> for a list.
<p /></dd>

<dt><a id="others"><b>I thought this game was called
"Dope Wars 2.0" or "Dopewars 2000" or "Drug Wars" - what's
going on?</b></a></dt>
<dd>dopewars is based loosely on "Drug Wars", a game written by John E. Dell
back in the 1980's. It draws more closely on the MS-DOS rewrite, titled
"Dopewars". (In fact, the "antique" mode of dopewars follows the MS-DOS
program particularly closely.) There are many other programs based on
"Drug Wars" available on the net; some of these are listed below.
Please note that these programs are not all free software, and are not
compatible with "dopewars" from this site (for example, you cannot connect
to a dopewars server with Beermat's Windows program - if you want a
Windows or Mac OS X version of "this" dopewars, check out the
download page.)

<ul>
<li><a href="http://www.beermatsoftware.com/dopewars/">Dope Wars for
Windows</a> (Beermat Software). By far the most popular dopewars-like game.
Only available for Windows, only supports single-player games, and is
not free; however, a free trial version is available, and high scores
can be posted on Beermat's website.</li>

<li><a href="http://www.dopewars2000.co.uk/">Dopewars 2000</a>. Also
Windows-only. Freeware.</li>

<li><a href="http://www.umr.edu/~schuette/windealer.html">WinDealer</a>.
An incomplete Windows version.</li>

<li><a href="http://www.makemebig.com/chronic2k/intro.htm">chronic2k</a>.
Another Windows version.</li>

<li><a href="http://www.geocities.com/drugwarz/drugwarz.htm">DrugWarz</a>.
A Windows version written in Visual Basic, and set in St. Louis. Source code
available on request.</li>

<li><a href="http://www.likelysoft.com/dopewars/">DopeWars for MacOS</a>
(Likely Software). Available for MacOS 8, 9, and OS X. Shareware; registration
required.</li>

<li><a href="http://www.abandonkeep.com/games.php?GameID=268">The original
MS-DOS Dopewars</a> (Happy Hacker Foundation).</li>

<li><a href="http://www.angelfire.com/ca/Dopewars/">Drug
Wars</a>. John Dell's original MS-DOS game.</li>

<li><a href="http://aw.localhost.ee/aw/view/573.html">Drug Lord</a>. An old
MS-DOS version.</li>

<li><a href="http://www.geekhideout.com/druglord2.shtml">Drug Lord 2.1</a>.
A free Windows version.</li>

<li><a href="http://pdaguy.com/dopewars/">DopeWars for PalmOS</a>. Matt
Lee's classic PalmOS version. Freeware, with source code.</li>

<li><a href="http://dopewars.scum.dk/">Dopewars for PocketPC</a>.
Freeware, with source code.</li>

<li><a href="http://dopewarsbb.sourceforge.net/">Dopewars for
Blackberry</a>.</li>

<li><a href="http://www.palmanac.co.uk/">Dopewars for Psion</a> (Palmanac
Software). Available for the Psion Series 5 or Series 7.</li>

<li><a href="http://www.dopemart.com/">Dope Mart</a>. An online version of
the game.</li>

<li><a href="http://www.cs.helsinki.fi/u/iizuka/games/dopewars/index.html">
Java Dope Wars</a>. Another online version.</li>

<li><a href="http://www.edrugtrader.com/">eDrugTrader</a>. Online
multi-player version.</li>

<li><a href="http://www.drunkmenworkhere.org/185.php">Online dopewars</a>.
Another online multi-player version, which is closely based on the dopewars
from this site.</li>

<li><a href="http://www.redteam.co.uk/dopewars/">Dope Wars for MIDP</a>
(RedTeam). For playing dopewars on your mobile phone.</li>

<li><a href="http://www.amidev.50megs.com/dopewars.html">DopeWars for the
Amiga</a></li>

<li><a href="http://opop.nols.com/proggie.html">dopewars in Perl</a></li>
</ul>
<p /></dd>

<dt><a id="days"><b>All of a sudden the game just stops for no
reason, and I have to restart. What's going on?</b></a></dt>
<dd>You only get a month (31 days) to make your fortune; after this your time 
is up!<p /></dd>

<dt><a id="moredays"><b>31 turns isn't long enough. How do
I get a longer game?</b></a></dt>
<dd>Edit the <a href="docs/configfile.html">configuration file</a>, and add
a line of the form <tt>NumTurns=x</tt> where <tt>x</tt> is the number of turns.
Alternatively, you can edit this file by selecting "Options" from the "Game"
menu of the Windows or GTK+ dopewars client, of version 1.5.4 or later. If
you are connecting to a public dopewars server, however, the number of turns
is set by whoever runs the server, and you cannot change it.<p /></dd>

<dt><a id="sounds"><b>The game could do with some sounds or
extra graphics - can you add them?</b></a></dt>
<dd>I can't draw, and don't have access to a recording studio. If, however,
you can provide suitable sounds or graphics, I will be only too happy to
incorporate them into the game. (Note that the sounds and graphics need to be
your own work - copying them from a game or other copyrighted source is no
good.)<p /></dd>

<dt><a id="segfault"><b>The game segfaults all the time when
I try to page or talk to other players! I'm using the latest RPM.</b></a></dt>
<dd>You're probably running the binary on a system with different C libraries 
to my Linux box. Try getting the SRPM or tarball and building that to see if 
it fixes your problem.<p /></dd>

<dt><a id="glib"><b>Do I <i>really</i> need GLib to build dopewars from
the source code? I just want to use the text-mode client.</b></a></dt>
<dd>I'm afraid so. It's true that GLib was originally developed as part of
the GTK+ toolkit for the GIMP, but it is <b>not</b> a graphics library;
it's a general purpose utility library. dopewars uses it for string handling,
config file parsing, memory allocation, error handling, logging, list types,
Windows/Unix portability, and Unicode support. So yes, you do need it!
It's not a particularly big library, anyway.
<p /></dd>

<dt><a id="winsock"><b>I keep getting a "Cannot Initialize
WinSock" error on Windows 95 - how do I fix it?</b></a></dt>
<dd>This is a problem with Windows 95, not dopewars. Windows 98 should work
just fine! Alternatively, you can download a Windows Sockets update from 
Microsoft's <a href="http://www.microsoft.com/windows95/downloads/contents/WUAdminTools/S_WUNetworkingTools/W95Sockets2/">Windows Update</a> page.
<p /></dd>

<dt><a id="bug"><b>I've found a bug! Fix it please.</b></a></dt>
<dd>Submit a bug report to the
<a href="http://sourceforge.net/tracker/?atid=111128&amp;group_id=11128&amp;func=browse">
SourceForge bug tracking system</a>. Make sure you leave details of the
dopewars version you're using (e.g. 1.5.2) and your system (e.g. RedHat
Linux 7.2, Windows XP). The more details you can give about how and when
the bug occurred, the more likely that it can be fixed. Also make sure that
you leave a contact address so that you can be contacted for more details if
necessary.
<p /></dd>

<dt><a id="feature"><b>Can you add <i>&lt;feature&gt;</i> ?.</b>
</a></dt>
<dd>dopewars is open source software, so there's nothing to stop you from
getting the source code and adding the feature yourself! Alternatively, submit
a feature request to the 
<a href="http://sourceforge.net/tracker/?atid=361128&amp;group_id=11128&amp;func=browse">
SourceForge feature request system</a>. This way, developers can keep track
of all desired new features.
<p /></dd>

</dl>

<?php
  WriteNavLinks("FAQ");
  EndHTML();
?>
