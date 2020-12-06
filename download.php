<?php
  include "include/dopefunc.php";
  StartHTML("Download","Download");

  function Download($url,$name='') {
    global $dnlroot;  /* Server where the files are stored - passed in */
    if ($name=='') $name = $url;
    print "   <a href=\"$dnlroot$url\">$name</a>\n";
  }
?>

<p>dopewars should compile on practically any UNIX system which has the
(n)curses library. It can also be compiled on Windows systems; see below.
If you're running Fedora Core 4 on an Intel-based system, you can install
dopewars by getting the relevant RPM(s) and reading the README file. If you
don't have RPM or they don't install properly, grab the tarball instead.</p>

<p>Latest stable version is <b>1.6.0</b>. The RPMs may be a little out of date,
depending on how often I bother to rebuild them... So check the version
numbers!</p>

<p>All RPMs are <a href="http://www.gnupg.org/">GnuPG</a> signed with
<a href="http://dopewars.sourceforge.net/pubkey4.txt">this public key</a>.
GPG-signed SHA256 checksums of all downloadable material
<?php Download("SHA256-1.6.0.txt.asc", "are also available"); ?>.
</p>

<h3>Microsoft Windows</h3>
<p>Windows installer (Windows 7 or later), version 1.6.0: &nbsp;
<?php Download("dopewars-1.6.0-32bit.exe", "32-bit"); ?>; &nbsp;
<?php Download("dopewars-1.6.0-64bit.exe", "64-bit"); ?>
<br />
(just run this program, and it will install dopewars automatically for you;
if you're worried about Internet Explorer's "security" warning, see the
<a href="faq.html#windows">FAQ</a>, or check its
<?php Download("SHA256-1.6.0.txt.asc", "checksum and GPG signature"); ?>).
</p>

<h3>RedHat Enterprise Linux 7 (and similar)</h3>
<p>Binary RPM for 64-bit RedHat Enterprise 7, version 1.6.0: &nbsp;
<?php Download("dopewars-1.6.0-1.el7.x86_64.rpm"); ?>
<br />
SDL_mixer (Simple DirectMedia Layer) sound plugin: &nbsp;
<?php Download("dopewars-sdl-1.6.0-1.el7.x86_64.rpm"); ?>
</p>

<h3>Fedora Linux 33 (and similar)</h3>
<p>Binary RPM for 64-bit Fedora 33, version 1.6.0: &nbsp;
<?php Download("dopewars-1.6.0-1.fc33.x86_64.rpm"); ?>
<br />
SDL_mixer (Simple DirectMedia Layer) sound plugin: &nbsp;
<?php Download("dopewars-sdl-1.6.0-1.fc33.x86_64.rpm"); ?>
</p>

<h3>Source code</h3>
<p>Source RPM, version 1.6.0: &nbsp;
<?php Download("dopewars-1.6.0-1.el7.src.rpm"); ?>
</p>

<p>Source code tarball, version 1.6.0: &nbsp;
<?php Download("dopewars-1.6.0.tar.gz"); ?>
</p>

<h3>Other Linux/Unix</h3>

<p><i>These packages are built by third parties, and so may not be as up to date
as the latest release.</i></p>

<p>
<?php Download("dopewars-1.5.2-slackware.tar.gz","Slackware package"); ?>
</p>

<!-- <p><a href="http://lis.snv.jussieu.fr/~rousse/linux/plf/">Mandrake
package</a></p> -->

<p><a href="https://packages.debian.org/buster/dopewars">Debian
package</a></p>

<p>Homebrew (Mac OS): run <tt>brew install dopewars</tt></p>

<p><a href="http://pdb.finkproject.org/pdb/package.php/dopewars">Mac OS
(Fink) package</a></p>

<!--
<p><a href="http://www.lindows.com/products_details/product_1310.html">Lindows
Click-N-Run package</a></p> -->

<!-- <p><a href="http://www.freebsd.org/cgi/url.cgi?ports/games/dopewars/pkg-descr">
FreeBSD port</a></p> -->

<p><a href="https://pkgsrc.se/games/dopewars">NetBSD package</a></p>

<p><a href="https://openports.se/games/dopewars">OpenBSD package</a></p>

<p>Foresight Linux or Specifix Linux: run <tt>conary update dopewars</tt></p>

<h3>Documentation etc.</h3>

<p>Text documentation: &nbsp;
   <a href="https://github.com/benmwebb/dopewars/blob/master/README">README</a>
</p>

<p>List of changes in this and earlier versions (ChangeLog): &nbsp;
   <a href="https://github.com/benmwebb/dopewars/blob/master/ChangeLog">ChangeLog</a>
</p>

<p>Example configuration file for dopewars: &nbsp;
   <a href="https://github.com/benmwebb/dopewars/blob/master/doc/example-cfg">example-cfg</a>
</p>

<h2><a id="develop">Development versions</a></h2>
<p>dopewars is in continual development, and so, to take advantage of
new features, or to contribute to the code and/or translations, you can get
the latest version of the code using
<a href="https://git-scm.com/">git</a> from
<a href="https://github.com/benmwebb/dopewars">GitHub</a>. Be warned that this
code may not be fully functional - that's why it's still in development!</p>

<p>To obtain the whole code from scratch, use the following command, which will
extract the latest git version into the directory <tt>dopewars</tt> below your
current directory:</p>

<pre class="unixcom">git clone https://github.com/benmwebb/dopewars.git</pre>

<p>If you already have a copy of the code and wish to bring it up to
date, change into the <tt>dopewars</tt> directory and then run the following
command:</p>

<pre class="unixcom">git pull</pre>

<p>If you find issues with the code or configure script, please
<a href="https://github.com/benmwebb/dopewars/issues">open an issue</a>.</p>

<h2>Old versions</h2>
<p>If you desperately want them, all previous GPL versions of dopewars are also
available, mainly at the <a
href="https://sourceforge.net/projects/dopewars/files/dopewars/">SourceForge
files page</a>. Very old versions are also available below. N.B. It is not
recommended to use these versions for anything other than testing - they all
contain bugs, including some severe security problems!</p>

<p>
<a href="oldversions/dopewars-1.4.7.tar.gz">Version 1.4.7.</a>
 Released: 14-01-00<br />
<a href="oldversions/dopewars-1.4.6.tar.gz">Version 1.4.6.</a>
 Released: 12-11-99<br />
<a href="oldversions/dopewars-1.4.5.tar.gz">Version 1.4.5.</a>
 Released: 21-10-99<br />
<a href="oldversions/dopewars-1.4.4.tar.gz">Version 1.4.4.</a>
 Released: 16-9-99<br />
<a href="oldversions/dopewars-1.4.3.tar.gz">Version 1.4.3.</a>
 Released: 23-6-99<br />
<a href="oldversions/dopewars-1.4.2.tar.gz">Version 1.4.2.</a>
 Released: 16-5-99<br />
<a href="oldversions/dopewars-1.4.1b.tar.gz">Version 1.4.1b.</a>
 Released: 28-4-99<br />
<a href="oldversions/dopewars-1.4.1a.tar.gz">Version 1.4.1a.</a>
 Released: 28-4-99<br />
<a href="oldversions/dopewars-1.4.1.tar.gz">Version 1.4.1.</a>
 Released: 27-4-99<br />
<a href="oldversions/dopewars-1.4.0.tar.gz">Version 1.4.0</a>
 Released: 27-4-99<br />
</p>

<?php
  WriteNavLinks("Download");
  EndHTML();
?>
