<?php
  include "include/dopefunc.php";
  StartHTML("dopewars-1.5.8","Main Index");
?>

<h2>Make a fortune dealing drugs on the streets of New York...</h2>

<?php  ListMirrors(); ?>

<h3><a href="news.html">NEWS</a>: Version 1.5.8 is now available! This release
adds Windows XP, GNOME2, and Unicode support, adds a default set of sound
effects, and fixes some minor bugs. Get it from the
<a href="download.html">download page</a>.
</h3>

<p>dopewars is a free Unix/Win32 rewrite of a game originally based on "Drug
Wars" by John E. Dell. The idea of dopewars is to deal in drugs on the streets
of New York, amassing a huge fortune and paying off the loan shark, while
avoiding the ever-annoying police. The Unix/Win32 rewrite, as well as
featuring a so-called "antique" mode which closely follows the original,
introduces new features such as the ability to take part in multi-player games.
dopewars aims to be highly configurable, and what you can't change in the
configuration files you can change by poking around in the source, which is
freely available under the terms of the
<a href="LICENCE">GNU General Public License</a>.</p>

<p>dopewars runs on Unix (e.g. Linux, Solaris, Mac OS X) systems and Win32
(Windows 95, 98, NT, 2000, ME, XP).</p>

<p>A framework for writing AI clients for dopewars with
<a href="http://www.perl.com/">Perl</a> (and a simple example client)
is available courtesy of Dave Madison
<a href="http://MarginalHacks.com/Hacks/dAIve/">here</a>. A version of
dopewars which implements an improved AI, using a behaviour-based
architecture, <a href="http://www.cs.nott.ac.uk/~esg/dopewars.html">is also
available</a>.</p>

<p>A version of dopewars written in <a href="http://www.python.org/">Python</a>
is in development by <a href="mailto:mwm@mired.org">Mike Meyer</a>. The aim
of this version is to enable dopewars to be run easily on other platforms
(such as MacOS and Windows) and to greatly simplify the development
of computerised dopewars players. The code is freely available
<a href="http://www.mired.org/home/mwm/wars/">here</a>. The author would
really appreciate assistance from keen Python programmers in getting the code
to run cleanly on both Linux and Windows systems!</p>

<p>dopewars is also an IRC bot! To play a game, connect with any IRC client
to the IRC server at <b>irc.irc-hispano.org</b>. Then start a game by
entering the command<br />
<b>/msg WaRZ jugar</b> or <b>/msg BRoK jugar</b><br />
...and then accept the DCC-CHAT. <b>WaRZ</b> is a space-trading themed version,
while <b>BRoK</b> is a share-dealing version.</p>

<h3>Support</h3>

<p>If you have a question about dopewars, first check the
<a href="faq.html">FAQ</a> to see if it's already answered there. Also,
consider checking the
<a href="http://sourceforge.net/projects/dopewars/">SourceForge</a> pages for
the <a href="http://sourceforge.net/forum/forum.php?forum_id=34874">Open
Discussion forum</a>, the
<a href="http://sourceforge.net/forum/forum.php?forum_id=34875">Help forum</a>
or the
<a href="http://lists.sourceforge.net/mailman/listinfo/dopewars-devel">dopewars
mailing list</a>.
You can also email enquiries to me directly at
<a href="mailto:ben@bellatrix.pcl.ox.ac.uk">ben@bellatrix.pcl.ox.ac.uk</a>.</p>

<p>If you discover a bug in the version you have, check the download page
for a later version (or try the development code in CVS); chances are that the
bug has already been reported and it's been fixed...</p>

<?php WriteNavLinks(); ?>

<p>Links to Ben Webb's pages:-</p>
<ul>
<li><a href="http://bellatrix.pcl.ox.ac.uk/~ben/">Main Index</a>;
<a href="http://bellatrix.pcl.ox.ac.uk/~ben/directory.html">
Site Directory</a>
  <ul>
  <li><a href="http://bellatrix.pcl.ox.ac.uk/~ben/programs.html">
  Program download page</a>
  </li>
  </ul>
</li>
</ul>

<?php EndHTML(); ?>
