<?php
/* Functions for PHP-generated dopewars pages */

  if (isset($mirror) && $mirror=='UK') {
    $DOCROOT='http://bellatrix.pcl.ox.ac.uk/~ben/dopewars/';
  } else unset($DOCROOT);

  include "local.php";

  if (isset($mirror)) { $mirrorID="&amp;mirror=$mirror"; }

  $mainpage=$DOCROOT;

  function StartHTML($title,$sitepage='') {
    global $DOCROOT,$mainpage,$mirrorID;
    $sitelinks = array (
      'Main Index' => $mainpage,
      'News' => $DOCROOT.'news.html',
      'Documentation' => $DOCROOT.'docs/',
      'FAQ' => $DOCROOT.'faq.html',
      'Download' => $DOCROOT.'download.html',
      'Screenshots' => $DOCROOT.'screenshots/',
      'Active servers' => 'http://dopewars.sourceforge.net/metaserver.php?getlist=2'.$mirrorID,
      'SourceForge project page' => 'http://sourceforge.net/projects/dopewars/'
    );
    print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n\n";
    print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"\n";
    print " \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n\n";
    print "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\">\n\n";
    print "<head>\n";
    print "  <link rel=\"stylesheet\" type=\"text/css\" ".
          "href=\"".$DOCROOT."dopewars.css\" />\n";
    print "  <link rel=\"made\" type=\"text/html\" ".
          "href=\"mailto:benwebb@users.sf.net\" />\n";
    print "  <title>$title</title>\n";
    print "</head>\n\n";

    print "<body>\n";
    print "<p class=\"sitelinks\">\n";

    $first=TRUE;
    foreach ($sitelinks as $name => $url) {
      if ($first) $first=FALSE; else print " *\n";
      if ($name==$sitepage || !$url) print "  $name";
      else print "  <a href=\"$url\">$name</a>";
    }

    print "\n</p>\n\n";

    print "<h1>$title</h1>\n\n";
  }

  function WriteNavLinks() {
    global $DOCROOT,$mainpage,$mirrorID;
    $validlinks = array(
      'Active servers' => 'http://dopewars.sourceforge.net/metaserver.php?getlist=2',$mirrorID,
      'Screenshots' => $DOCROOT.'screenshots/'
    );

    $links = func_get_args();

    print "\n<p class=\"navlinks\">\n";
    print '  <a href="'.$mainpage.'">Main Index</a>';

    for ($i=0;$i<sizeof($links);$i++) {
      $name = $links[$i];
      if ($i==sizeof($links)-1) $url = '';
      else $url=$validlinks[$name];
      if (!isset($url)) {
        die("Invalid navigation link $name!");
      }
      print " :\n  ";
      if ($url) print "  <a href=\"$url\">$name</a>";
      else print "  $name";
    }
    print "\n</p>\n\n";
  }

  function EndHTML($sourcefile='') {
    global $DOCROOT;

    if (!$sourcefile and isset($_SERVER['PATH_TRANSLATED'])) {
      $sourcefile = $_SERVER['PATH_TRANSLATED'];
    }
    if (!$sourcefile) $sourcefile = $_SERVER["argv"][0];
    if (!$sourcefile) {
      die("Cannot figure out which file we're processing...");
    }

    $fileinfo = stat($sourcefile);
    if (!$fileinfo) {
      die("Cannot stat PHP source file \"$sourcefile\"");
    }

    /* $fileinfo[9] is stat.m_time (last modification time) */
    $modtime = date("D M j G:i:s T Y",$fileinfo[9]);
  
    print "<address>\n";
    print "  <a href=\"http://jigsaw.w3.org/css-validator/check/referer\">\n";
    print "    <img class=\"w3clink\" src=\"".$DOCROOT."valid-css.png\"".
          " alt=\"Valid CSS\" />\n  </a>\n";
    print "  <a href=\"http://validator.w3.org/check/referer\">\n";
    print "    <img class=\"w3clink\" src=\"".$DOCROOT."valid-xhtml11.png\"".
          " alt=\"Valid XHTML 1.1\" />\n  </a>\n";
    print "  <a href=\"http://sourceforge.net/projects/dopewars\">\n";
    print "    <img class=\"w3clink\" src=\"http://sflogo.sourceforge.net/" .
          "sflogo.php?group_id=11128&amp;type=12\"\n" .
          "     width=\"120\" height=\"30\"\n" .
          "      alt=\"Fast, secure and Free Open Source software " .
          "downloads\" />";
    print "  </a>\n";

    print "  Written by <a href=\"mailto:benwebb@users.sf.net\">".
          "Ben Webb</a><br />\n";
    print " This page last updated: $modtime\n";
    print "</address>\n\n</body>\n\n</html>\n";
  }

  function ListMirrors() {
?>
<table class="mirrors" border="0" cellpadding="10">
 <caption>
 <a id="mirrors">
   Please use the mirror site that is closer to you:
 </a>
 </caption>

 <tr>
  <td><a href="http://dopewars.sourceforge.net/">
  United States (dopewars.sourceforge.net)
  </a></td>

  <td><a href="http://bellatrix.pcl.ox.ac.uk/~ben/dopewars/">
  England, UK (bellatrix.pcl.ox.ac.uk)</a></td>
 </tr>
</table>
<?php
    
  }

?>
