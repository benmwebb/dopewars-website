<?php

  include "include/dopefunc.php";

/* This is the main functionality of the dopewars metaserver. */
  function MainFunc($dbhand) {
    global $textoutput;
    if (!$dbhand) {
      FatalError("Could not connect to dopewars database server");
    }
    if (!@mysql_select_db("d11128_metaserver",$dbhand)) {
      FatalError("Could not locate the main dopewars database!");
    }
    if ($_REQUEST['output'] == 'text') {
      header("Content-type: text/plain");
      $textoutput=TRUE;
    } else $textoutput=FALSE;
    $servername='';
    if ($_REQUEST['port']) {
      RegisterServer($dbhand);
    } else if ($_REQUEST['server']) {
      ServerInfo($dbhand, $_REQUEST['server']);
      $servername = $_REQUEST['server'];
    } else {
      ShowServers($dbhand);
    }
    PrintHTMLFooter($servername);
  }

/* Maximum number of high scores */
  $NUMHISCORES = 18;

  function ShowServers($dbhand) {
    global $DOCROOT,$mirrorID;
    PrintHTMLHeader("Active dopewars servers",TRUE);

    if (!$_REQUEST['getlist']) {
      $getlist = 2;
    } else {
      $getlist = $_REQUEST['getlist'];
    }

/* First, wipe any servers that haven't reported in for 4 hours
   (14400 seconds) and any associated tables */
    $result = dope_query("SELECT ID FROM servers WHERE UNIX_TIMESTAMP(LastUpdate)+14400 < UNIX_TIMESTAMP(NOW())");
    while ($row=mysql_fetch_array($result)) {
      dope_query("DELETE FROM highscores WHERE ServerID='".$row['ID']."'");
    }
    $result = dope_query("DELETE FROM servers WHERE UNIX_TIMESTAMP(LastUpdate)+14400 < UNIX_TIMESTAMP(NOW())");

    $result = dope_query("SELECT servers.*,COUNT(Score) AS NumScores FROM servers LEFT JOIN highscores ON ServerID=servers.ID GROUP BY servers.ID ORDER BY UpSince");
    if ($_REQUEST['output'] == 'text') {
      print "MetaServer:\n";
      while ($row=mysql_fetch_array($result)) {
        print $row['HostName']."\n".$row['Port']."\n".$row['Version']."\n";
        if ($getlist>=2) {
          print $row['Players']."\n";
        }
        print $row['MaxPlayers']."\n";
        print FormatTimestamp($row['LastUpdate'])."\n".$row['Comment']."\n";
        if ($getlist>=2) {
          print FormatTimestamp($row['UpSince'])."\n";
        }
      }
    } else {
?>
<p>dopewars incorporates limited multiplayer capabilities, with a server
mode (the -s switch). The list below is maintained automatically, providing
that you're running a server of version 1.5.1 or above. In some cases (usually
if you're connecting via a proxy) the metaserver may report your domain
name incorrectly, or refuse connection entirely; see the
<?php print "<a href=\"".$DOCROOT."docs/metaserver.html\">metaserver</a>\n"; ?>
page for tips on fixing this problem. Additional problems can usually be solved
by <a href="mailto:benwebb@users.sf.net">emailing</a> the metaserver
maintainer.</p>

<p>To prevent your server announcing itself to the outside world, add the
line "MetaServer.Active=0" (without the quotes) to your dopewars configuration
file (/etc/dopewars or ~/.dopewars) or run the server with the <b>-S</b>
command line option rather than <b>-s</b>.</p>

<p>Please note that all servers are checked for service; those that are
unreachable or refuse connection will be removed from this list.</p>

<p>If a given server is reporting its high scores to the metaserver, the
server name will be hyperlinked (only versions 1.5.1 and above do this - older
versions only work with the "old" metaserver). Follow the link to see the 
current high scores.</p>

<?php
/*    print "<p>refer: ".$_SERVER['HTTP_REFERER']."</p>\n";*/
      print "<table border=\"1\">\n\n";
      print "<tr><th>Server name</th><th>Port</th><th>Version</th>\n".
            "<th>Players</th><th>Max. Players</th><th>Last update</th>\n".
            "<th>Up since</th><th>Comment</th></tr>\n\n";
      while ($row=mysql_fetch_array($result)) {
        print "<tr>";
        print "<td>";
        HTMLQuote($row['Version']);
        HTMLQuote($row['Comment']);
        if ($row['NumScores']>0) {
          print "<a href=\"metaserver.php?server=".$row['HostName'].
                $mirrorID."\">";
        }
        print $row['HostName'];
        if ($row['NumScores']>0) print "</a>";
        print "</td>\n";
        print "<td>".$row['Port']."</td>\n";
        print "<td>".$row['Version']."</td>\n";
        print "<td>".$row['Players']."</td>\n";
        print "<td>".$row['MaxPlayers']."</td>\n";
        print "<td>".FormatTimestamp($row['LastUpdate'])."</td>\n";
        print "<td>".FormatTimestamp($row['UpSince'])."</td>\n";
        print "<td>".$row['Comment']."</td>\n";
        print "</tr>\n\n";
      }
      print "</table>\n\n";
    }
  }

/* Quote all HTML stuff in $str, and modify it in place. */
  function HTMLQuote(&$str) {
    $str = htmlspecialchars($str,ENT_QUOTES);
  }

  function FormatTimestamp($timestamp) {
    $year=substr($timestamp,0,4);
    $month=substr($timestamp,5,2);
    $day=substr($timestamp,8,2);
    $hour=substr($timestamp,11,2);
    $minute=substr($timestamp,14,2);
    return "$hour:$minute on $day/$month/$year";
  }

  function dope_query($query) {
    $result = mysql_query($query);
    if (!$result) {
      FatalError("performing query: ".mysql_error());
    } else return $result;
  }

  function ValidateServerDetails(&$nm, &$dt, &$sc, &$version, &$comment,
                                 &$hostname, &$password) {
    global $NUMHISCORES;

    $players = $_REQUEST['players'];
    $maxplay = $_REQUEST['maxplay'];

    $port=(int)$_REQUEST['port'];
    $players=(int)$players;
    $maxplay=(int)$maxplay;
    if (!$_REQUEST['port']) { FatalError("Invalid server port supplied"); }

/* Convert dates into SQL-friendly format */
    for ($i=0;$i<$NUMHISCORES;$i++) if ($nm[$i]) {
      if (!$dt[$i] || strlen($dt[$i])!=10) {
        FatalError("Invalid high score date ".$dt[$i]);
      }
      $day=(int)substr($dt[$i],0,2);
      $month=(int)substr($dt[$i],3,2);
      $year=(int)substr($dt[$i],6,4);
      $dt[$i] = sprintf("%04d-%02d-%02d",$year,$month,$day);
      MyAddSlashes($nm[$i]);
      MyAddSlashes($sc[$i]);
    }

/* Quote text strings (if necessary) for SQL */
    MyAddSlashes($version);
    MyAddSlashes($comment);
    MyAddSlashes($hostname);
    MyAddSlashes($password);
  }

/* Escape quote characters etc. if magic quotes are _not_ being used */
  function MyAddSlashes(&$str) {
    if (!get_magic_quotes_gpc()) $str=addslashes($str);
  }

  function FatalError($msg) {
    PrintParagraph("FATAL ERROR: $msg"); exit();
  }

  function PrintParagraph($msg) {
    global $textoutput;
    if ($textoutput) print "$msg\n\n";
    else print "<p>$msg</p>\n\n";
  }

  function CheckHostOverride(&$realhostname, $remoteIP) {
    $hostname = $_REQUEST['hostname'];
    $password = $_REQUEST['password'];
    if ($password && $hostname) {
      $result = dope_query("SELECT * FROM hostoverride WHERE Password='$password' AND HostName='$hostname'");
      if (!(mysql_affected_rows())) {
        FatalError("Password and hostname do not match!");
      }
      $realhostname = $hostname;
      PrintParagraph("Hostname override password accepted");
      return TRUE;
    } else if ($hostname) {
      $IP = gethostbyname($hostname);
      if ($IP == $hostname) {
        FatalError("LocalName $hostname: unknown host!");
      } else if ($IP == $remoteIP) {
        $realhostname = $hostname;
        PrintParagraph("DNS mapping $IP -> $hostname accepted");
        return TRUE;
      } else {
        FatalError("Password required for LocalName $hostname ($IP) override");
      }
    }
    return FALSE;
  }

  function CheckHostNotOverridden($hostname) {
    $result = dope_query("SELECT * FROM hostoverride WHERE HostName='$hostname'");
    if (mysql_affected_rows()) {
      FatalError("Host $hostname is password-protected - not updating server details");
    }
  }

  function GetServerLocation(&$realhostname,&$remoteIP,&$proxyIP) {

    $remoteIP = $_SERVER['REMOTE_ADDR'];
    $proxyIP = '';

    if ($_SERVER['HTTP_X_FORWARDED_FOR'] != ''
        && $_SERVER['HTTP_X_FORWARDED_FOR'] != 'unknown') {
      $fwdIPs = $_SERVER['HTTP_X_FORWARDED_FOR'];
      $proxyIP = $_SERVER['REMOTE_ADDR'];
/* Check for multiple forwards, and take the first IP if necessary */
      $splitIPs = explode(", ",$fwdIPs);
      if ($splitIPs==$fwdIPs || $split) $remoteIP=$fwdIPs;
      else $remoteIP=$splitIPs[0];
    }

    if (CheckHostOverride($realhostname, $remoteIP)) return;

    $result = dope_query("SELECT HostName FROM localdns WHERE IP='$remoteIP'");
    $row=mysql_fetch_array($result);
    if ($row) $realhostname = $row['HostName'];

    if (!$realhostname) $realhostname=@gethostbyaddr($remoteIP);

    CheckHostNotOverridden($realhostname);
  }

  function CheckServerConnect($HostName,$Port) {
/*  $fp = fsockopen($HostName,$Port,$errno,$errstr,60);
    if (!$fp) {
      FatalError("Could not connect to server at $HostName:$Port ($errstr). NOT registering server - please check that the hostname and port are correct and that your firewall is not blocking connections, and try again later.");
    }*/
  }

  function CreateCredential() {
    return "dummy";
  }

  function CheckCredential($ProperCred) {
/*  if ($_REQUEST['credential'] != $ProperCred) {
      FatalError("Credential mismatch: server details not updated");
    }*/
  }

  function ValidDynamicDNS() {
    $hostname = $_REQUEST['hostname'];
    $password = $_REQUEST['password'];
    if ($hostname || !$password) return FALSE;
    $result = dope_query("SELECT * FROM dynamicdns WHERE Password='$password'");
    return (mysql_affected_rows()!=0);
  }

  function CheckValidProxy($oldproxyIP,$proxyIP,$HostName) {
    if ($proxyIP == $oldproxyIP) return;
    if (!$oldproxyIP) {
      FatalError("Cannot update $HostName - you are connecting via proxy $proxyIP, and this host last connected directly");
    } else if (!proxyIP) {
      FatalError("Cannot update $HostName - you are connecting directly, and this host last connected via a proxy");
    } else {
/*    FatalError("Cannot update $HostName - you are connecting via a different proxy to the one it last connected via."); */

/* We'll let this go for now - the paranoid will just have to use the password
   authentication scheme instead */
      return;
    }
  }

  function RegisterServer($dbhand) {
    global $NUMHISCORES;

    $nm = $_REQUEST['nm'];
    $dt = $_REQUEST['dt'];
    $st = $_REQUEST['st'];
    $sc = $_REQUEST['sc'];
    $version = $_REQUEST['version'];
    $comment = $_REQUEST['comment'];
    $players = $_REQUEST['players'];
    $maxplay = $_REQUEST['maxplay'];
    $up = $_REQUEST['up'];
    $hostname = $_REQUEST['hostname'];
    $password = $_REQUEST['password'];

    PrintHTMLHeader("dopewars server registration");

    GetServerLocation($HostName,$remoteIP,$proxyIP);
    ValidateServerDetails($nm, $dt, $sc, $version, $comment, $hostname,
                          $password);

    $validdyn=ValidDynamicDNS();
    $port = $_REQUEST['port'];

    if ($validdyn) {
      PrintParagraph("Dynamic DNS password accepted");
      $result = dope_query("SELECT ID,Credential,ProxyIP FROM servers,dynamicdns WHERE ServerID=ID AND Password='$password'");
    } else {
      $result = dope_query("SELECT ID,Credential,ProxyIP FROM servers WHERE HostName='$HostName' AND Port='$port'");
    }
    $createnew=(mysql_affected_rows()==0);

    if (!$createnew) {
      $row=mysql_fetch_array($result);
      $serverID=$row['ID'];
      $credential=$row['Credential'];
      $oldproxyIP=$row['ProxyIP'];
      CheckValidProxy($oldproxyIP,$proxyIP,$HostName);
    }

    PrintParagraph("You are apparently at $HostName:$port ($remoteIP)");
    PrintParagraph("Server is: ".($up ? 'up' : 'down'));

    if ($up==0) {
      if (!$createnew) {
        CheckCredential($credential);
        dope_query("DELETE FROM servers WHERE ID='$serverID'");
        dope_query("DELETE FROM highscores WHERE ServerID='$serverID'");
        if ($validdyn) dope_query("UPDATE dynamicdns SET ServerID=NULL WHERE Password='$password'");
      }
      return;
    }

    if ($createnew) {
      CheckServerConnect($HostName,$port);
      $credential=CreateCredential();
/*    PrintParagraph("Credential: $credential");*/
      $query="INSERT INTO servers SET UpSince=NOW(), Credential='$credential', ";
    } else {
      CheckCredential($credential);
      $query="UPDATE servers SET ";
    }

    $query .= "HostName='$HostName', ";
    $query .= "Port='$port', ";
    $query .= "LastUpdate=NOW(), ";
    $query .= "Version='$version', ";
    $query .= "Players='$players', ";
    $query .= "MaxPlayers='$maxplay', ";
    $query .= "IP='$remoteIP', ";
    $query .= "ProxyIP='$proxyIP', ";
    $query .= "Comment='$comment' ";

    if (!$createnew) $query .= "WHERE ID='$serverID'";

    $result = dope_query($query);
    if ($createnew) {
      $serverID=mysql_insert_id();
      if ($validdyn) dope_query("UPDATE dynamicdns SET ServerID='$serverID' WHERE Password='$password'");
    }

    if (sizeof($nm)>0) {
      $result = dope_query("DELETE FROM highscores WHERE ServerID='$serverID'");
    }

    for ($i=0;$i<$NUMHISCORES;$i++) if ($nm[$i]) {
      $result = dope_query("INSERT INTO highscores SET Name='$nm[$i]', Date='$dt[$i]', Status='$st[$i]', Score='$sc[$i]', ServerID='$serverID', ID='$i'");
    }
  }

  function ServerInfo($dbhand,$server) {
    PrintHTMLHeader("dopewars server $server");
    $result = dope_query("SELECT Score, Date, Name, Status FROM servers,highscores WHERE serverID=servers.ID AND HostName='$server' ORDER BY highscores.ID");

?>

<h3>Scores for multiplayer mode</h3>

<?php
    if (!(mysql_affected_rows())) {
      print "<p>No data available for this server - it has, most likely, gone down.</p>\n\n";
      return;
    }

    print "<table border=\"1\"><tr><th>Score</th><th>Date</th>\n";
    print "<th>Name</th><th>Status</th></tr>\n\n";
    while (($row=mysql_fetch_array($result))) {
      HTMLQuote($row['Score']);
      HTMLQuote($row['Name']);
      print "<tr>\n";
      print "<td>".$row['Score']."</td>\n";
      print "<td>".$row['Date']."</td>\n";
      print "<td>".$row['Name']."</td>\n";
      print "<td>".$row['Status']."</td>\n";
      print "</tr>\n";
    }
    print "</table>\n";
  }

  function PrintHTMLHeader($title,$ismain=FALSE) {
    global $textoutput;
    if ($textoutput) return;

    StartHTML($title,$ismain ? "Active servers" : "");
  }

  function PrintHTMLFooter($servername) {
    global $textoutput;
    if ($textoutput) return;

    if ($servername) WriteNavLinks("Active servers",$servername);
    else WriteNavLinks("Active servers");

    EndHTML("metaserver.php");
  }

?>
<?php
/* Get database connection info from persistent storage */
  $f = fopen("/home/project-web/dopewars/persistent/web/sql-data", 'r');
  $data = fgets($f);
  fclose($f);
  $split = explode("\t", trim($data));
  $my_server = $split[0];
  $my_username = $split[1];
  $my_password = $split[2];

/* Open the database, and pass the handle to MainFunc */
  $dbhand = @mysql_connect($my_server, $my_username, $my_password);
  MainFunc($dbhand);

/* Make sure that we don't leave any DB connections floating around */
  mysql_close($dbhand);
  unset($dbhand);
?>
