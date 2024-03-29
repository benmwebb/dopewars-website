<?php
  include "include/dopefunc.php";
  StartHTML("dopewars-1.6.2","Main Index");
?>

<h2>Make a fortune dealing drugs on the streets of New York...</h2>

<h3><a href="news.html">NEWS</a>: Version 1.6.2 is now available! This release
improves Unicode support in the text-mode client, and adds support for
networking on the Haiku operating system.
Get it from the <a href="download.html">download page</a>.
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

<p class="advisory"><b>ADVISORY:</b> dopewars is not recommended for children
below 16 without parental supervision. We also do not condone real-life drug
dealing.</p>

<p>dopewars runs on Unix (e.g. Linux, Solaris, Mac OS) systems and Win32
(Windows 7 or later).</p>

<p>A framework for writing AI clients for dopewars with
<a href="https://www.perl.com/">Perl</a> (and a simple example client)
is available courtesy of Dave Madison
<a href="http://MarginalHacks.com/Hacks/dAIve/">here</a>. A version of
dopewars which implements an improved AI, using a behaviour-based
architecture, <a href="http://www.cs.nott.ac.uk/~esg/dopewars.html">is also
available</a>.</p>

<h3>Support</h3>

<p>If you have a question about dopewars, first check the
<a href="faq.html">FAQ</a> to see if it's already answered there.
Otherwise,
<a href="https://github.com/benmwebb/dopewars/issues">open an issue</a>.</p>

<p>If you discover a bug in the version you have, check the download page
for a later version (or try the
<a href="https://github.com/benmwebb/dopewars">development code at GitHub</a>); chances are that the bug has already been reported and it's been fixed.
If not,
<a href="https://github.com/benmwebb/dopewars/issues">open an issue</a>.</p>

<?php WriteNavLinks(); ?>

<?php EndHTML(""); ?>
