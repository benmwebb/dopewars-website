<?php
  include "include/dopefunc.php";

  $images=array(
    'Linux graphical (GTK+) client (version 1.5.0)' => array(
      'Multi-player mode' => 'linux-gtk-multi'
    ),
    'Linux console-mode (ncurses) client (version 1.5.0)' => array(
      'Single-player mode (Brazilian Portuguese translation)' =>
        'linux-curses-ptbr',
      'Multi-player mode' => 'linux-curses-multi'
    ),
    'Windows client (version 1.5.2)' => array(
      'Single-player mode, under Win98' => 'win32-single',
      'Multi-player mode, under WinXP' => 'winxp-multi',
    )
  );

  if (isset($_ENV['pic'])) {
    $pic = $_ENV['pic'];
    $match='';
    if (substr($pic,-5)=='.html') $pic=substr($pic,0,-5);
    foreach($images as $category => $picarray) {
      foreach ($picarray as $name => $prefix) {
        if ($pic==$prefix) { $match=$name; break 2; }
      }
    }
    if ($match) {
      StartHTML("Screenshots - $category");
      print "<h2>$match</h2>\n\n";
      print "<p><img src=\"$pic.png\" alt=\"$match\" /></p>\n\n";
      WriteNavLinks("Screenshots",$category);
      EndHTML();
    } else {
      print "<p>Error - invalid picture $pic</p>\n\n";
    }
  } else {
    StartHTML("Screenshots","Screenshots");

    print "<p>Click on the images for full-size pictures.</p>";

    print "<ul>\n";
    foreach($images as $category => $picarray) {
      print "<li>$category\n";
      print "<ul>\n";
      foreach ($picarray as $name => $prefix) {
        print "<li>$name<br />\n";
        print "<a href=\"$prefix.html\">\n";
        print "  <img src=\"$prefix-small.png\" alt=\"$name\" />\n";
        print "</a></li>\n\n";
      }
      print "</ul></li>\n";
    }
    print "</ul>\n\n";

    WriteNavLinks("Screenshots");
    EndHTML();
  }
?>
