// dopewars metaserver as a Cloudflare Worker with a D1 (SQLite) database.
// Port of metaserver.php: same request parameters, same text output format.
//
//   GET /?output=text&getlist=2       list active servers (text, as the game client expects)
//   GET /                             list active servers (HTML)
//   GET /?server=<hostname>           high scores for a server (HTML)
//   GET|POST /?port=...&up=...        register, update or remove a server
//
// The Worker answers on every path, so /metaserver.php works too.

const NUMHISCORES = 18;
const DOCROOT = "https://dopewars.sourceforge.io/";
const STALE = "datetime('now', '-4 hours')"; // servers silent this long are removed

class FatalError extends Error {}

export default {
  async fetch(request, env) {
    const p = await getParams(request);
    const textOutput = p.get("output") === "text";
    const out = [];
    const ctx = {
      request, db: env.DB, p, textOutput, out,
      para(msg) { out.push(textOutput ? `${msg}\n\n` : `<p>${esc(msg)}</p>\n\n`); },
    };

    let servername = "";
    try {
      if (truthy(p.get("port"))) {
        await registerServer(ctx);
      } else if (truthy(p.get("server"))) {
        servername = p.get("server");
        await serverInfo(ctx, servername);
      } else {
        await showServers(ctx);
      }
      if (!textOutput) out.push(htmlFooter(servername));
    } catch (e) {
      // Like the PHP FatalError(): print the message and stop (no footer)
      if (e instanceof FatalError) {
        ctx.para(`FATAL ERROR: ${e.message}`);
      } else {
        console.error(e);
        ctx.para("FATAL ERROR: internal error");
      }
    }

    return new Response(out.join(""), {
      headers: {
        "Content-Type": textOutput ? "text/plain; charset=utf-8" : "text/html; charset=utf-8",
        "Cache-Control": "no-store, no-cache, must-revalidate, max-age=0",
        "Pragma": "no-cache",
      },
    });
  },
};

// ---------------------------------------------------------------- listing

async function showServers(ctx) {
  const { db, p, out } = ctx;
  const getlist = truthy(p.get("getlist")) ? Number(p.get("getlist")) : 2;

  // Remove servers that haven't reported in for 4 hours, and their scores
  await db.batch([
    db.prepare(`DELETE FROM highscores WHERE ServerID IN
                  (SELECT ID FROM servers WHERE LastUpdate < ${STALE})`),
    db.prepare(`DELETE FROM servers WHERE LastUpdate < ${STALE}`),
  ]);

  const { results } = await db.prepare(
    `SELECT servers.*, COUNT(highscores.Score) AS NumScores
       FROM servers LEFT JOIN highscores ON highscores.ServerID = servers.ID
      GROUP BY servers.ID ORDER BY UpSince`
  ).all();

  if (ctx.textOutput) {
    out.push("MetaServer:\n");
    for (const r of results) {
      out.push(`${r.HostName}\n${r.Port}\n${str(r.Version)}\n`);
      if (getlist >= 2) out.push(`${str(r.Players)}\n`);
      out.push(`${str(r.MaxPlayers)}\n`);
      out.push(`${formatTimestamp(r.LastUpdate)}\n${str(r.Comment)}\n`);
      if (getlist >= 2) out.push(`${formatTimestamp(r.UpSince)}\n`);
    }
    return;
  }

  out.push(htmlHeader("Active dopewars servers"));
  out.push(INTRO_HTML);
  out.push(`<table border="1">\n\n<tr><th>Server name</th><th>Port</th><th>Version</th>
<th>Players</th><th>Max. Players</th><th>Last update</th>
<th>Up since</th><th>Comment</th></tr>\n\n`);
  for (const r of results) {
    const name = r.NumScores > 0
      ? `<a href="?server=${encodeURIComponent(r.HostName)}">${esc(r.HostName)}</a>`
      : esc(r.HostName);
    out.push(`<tr><td>${name}</td>
<td>${esc(r.Port)}</td>
<td>${esc(r.Version)}</td>
<td>${esc(r.Players)}</td>
<td>${esc(r.MaxPlayers)}</td>
<td>${formatTimestamp(r.LastUpdate)}</td>
<td>${formatTimestamp(r.UpSince)}</td>
<td>${esc(r.Comment)}</td>
</tr>\n\n`);
  }
  out.push("</table>\n\n");
}

// ---------------------------------------------------------------- high scores

async function serverInfo(ctx, server) {
  const { db, out } = ctx;
  if (!ctx.textOutput) out.push(htmlHeader(`dopewars server ${server}`));

  const { results } = await db.prepare(
    `SELECT Score, Date, Name, Status
       FROM servers JOIN highscores ON highscores.ServerID = servers.ID
      WHERE HostName = ? ORDER BY highscores.ID`
  ).bind(server).all();

  out.push("<h3>Scores for multiplayer mode</h3>\n\n");
  if (results.length === 0) {
    out.push("<p>No data available for this server - it has, most likely, gone down.</p>\n\n");
    return;
  }
  out.push(`<table border="1"><tr><th>Score</th><th>Date</th>\n<th>Name</th><th>Status</th></tr>\n\n`);
  for (const r of results) {
    out.push(`<tr>\n<td>${esc(r.Score)}</td>\n<td>${esc(r.Date)}</td>\n` +
             `<td>${esc(r.Name)}</td>\n<td>${esc(r.Status)}</td>\n</tr>\n`);
  }
  out.push("</table>\n");
}

// ---------------------------------------------------------------- registration

async function registerServer(ctx) {
  const { db, p, out } = ctx;
  if (!ctx.textOutput) out.push(htmlHeader("dopewars server registration"));

  const { hostName, remoteIP, proxyIP } = await getServerLocation(ctx);

  // Validate server details
  const port = parseInt(p.get("port"), 10);
  if (!(port > 0 && port < 65536)) throw new FatalError("Invalid server port supplied");
  const players = parseInt(p.get("players"), 10) || 0;
  const maxplay = parseInt(p.get("maxplay"), 10) || 0;
  const version = p.get("version");
  const comment = p.get("comment");
  const password = p.get("password");

  const nm = p.arr("nm"), dt = p.arr("dt") ?? [], st = p.arr("st") ?? [], sc = p.arr("sc") ?? [];
  const scores = [];
  for (let i = 0; i < NUMHISCORES; i++) {
    if (!nm || !truthy(nm[i])) continue;
    const d = dt[i] ?? "";
    if (d.length !== 10) throw new FatalError(`Invalid high score date ${d}`);
    // DD?MM?YYYY -> YYYY-MM-DD
    const day = parseInt(d.slice(0, 2), 10) || 0;
    const month = parseInt(d.slice(3, 5), 10) || 0;
    const year = parseInt(d.slice(6, 10), 10) || 0;
    scores.push({
      id: i,
      name: nm[i],
      date: `${pad(year, 4)}-${pad(month, 2)}-${pad(day, 2)}`,
      status: st[i] === "dead" || st[i] === "alive" ? st[i] : null,
      score: sc[i] ?? "",
    });
  }

  // Dynamic DNS: password given without a hostname
  const validDyn = !truthy(p.get("hostname")) && truthy(password) &&
    !!(await db.prepare("SELECT 1 FROM dynamicdns WHERE Password = ?").bind(password).first());

  let existing;
  if (validDyn) {
    ctx.para("Dynamic DNS password accepted");
    existing = await db.prepare(
      `SELECT ID, Credential, ProxyIP FROM servers
         JOIN dynamicdns ON dynamicdns.ServerID = servers.ID
        WHERE dynamicdns.Password = ?`
    ).bind(password).first();
  } else {
    existing = await db.prepare(
      "SELECT ID, Credential, ProxyIP FROM servers WHERE HostName = ? AND Port = ?"
    ).bind(hostName, port).first();
  }

  if (existing) checkValidProxy(existing.ProxyIP ?? "", proxyIP, hostName);

  ctx.para(`You are apparently at ${hostName}:${port} (${remoteIP})`);
  const up = truthy(p.get("up"));
  ctx.para(`Server is: ${up ? "up" : "down"}`);

  if (!up) {
    if (existing) {
      const stmts = [
        db.prepare("DELETE FROM servers WHERE ID = ?").bind(existing.ID),
        db.prepare("DELETE FROM highscores WHERE ServerID = ?").bind(existing.ID),
      ];
      if (validDyn) {
        stmts.push(db.prepare("UPDATE dynamicdns SET ServerID = NULL WHERE Password = ?").bind(password));
      }
      await db.batch(stmts);
    }
    return;
  }

  const fields = [hostName, port, version, players, maxplay, remoteIP, proxyIP, comment];
  let serverID;
  if (!existing) {
    const row = await db.prepare(
      `INSERT INTO servers (UpSince, LastUpdate, Credential,
                            HostName, Port, Version, Players, MaxPlayers, IP, ProxyIP, Comment)
       VALUES (datetime('now'), datetime('now'), 'dummy', ?, ?, ?, ?, ?, ?, ?, ?)
       RETURNING ID`
    ).bind(...fields).first();
    serverID = row.ID;
  } else {
    serverID = existing.ID;
  }

  const stmts = [];
  if (existing) {
    stmts.push(db.prepare(
      `UPDATE servers SET LastUpdate = datetime('now'),
              HostName = ?, Port = ?, Version = ?, Players = ?, MaxPlayers = ?,
              IP = ?, ProxyIP = ?, Comment = ?
        WHERE ID = ?`
    ).bind(...fields, serverID));
  } else if (validDyn) {
    stmts.push(db.prepare("UPDATE dynamicdns SET ServerID = ? WHERE Password = ?").bind(serverID, password));
  }

  // A new score list replaces the old one
  if (nm && nm.length > 0) {
    stmts.push(db.prepare("DELETE FROM highscores WHERE ServerID = ?").bind(serverID));
    for (const s of scores) {
      stmts.push(db.prepare(
        "INSERT INTO highscores (Name, Date, Status, Score, ServerID, ID) VALUES (?, ?, ?, ?, ?, ?)"
      ).bind(s.name, s.date, s.status, s.score, serverID, s.id));
    }
  }
  if (stmts.length) await db.batch(stmts);
}

// The PHP version only ever rejected a host that last connected directly
// and now connects through a proxy; other proxy changes were allowed.
function checkValidProxy(oldProxyIP, proxyIP, hostName) {
  if (proxyIP === oldProxyIP) return;
  if (!oldProxyIP) {
    throw new FatalError(`Cannot update ${hostName} - you are connecting via proxy ${proxyIP}, ` +
                         `and this host last connected directly`);
  }
}

// ---------------------------------------------------------------- client location

async function getServerLocation(ctx) {
  const { request, db } = ctx;

  // CF-Connecting-IP is the address that connected to Cloudflare.
  const connecting = request.headers.get("CF-Connecting-IP") ?? "";
  let remoteIP = connecting;
  let proxyIP = "";

  // If the client came through an HTTP proxy, that proxy's X-Forwarded-For
  // names the original host. (Unverifiable, exactly as in the PHP version.)
  const xff = (request.headers.get("X-Forwarded-For") ?? "")
    .split(",").map((s) => s.trim()).filter(Boolean);
  while (xff.length && xff[xff.length - 1] === connecting) xff.pop(); // drop Cloudflare's own entry
  if (xff.length && xff[0] !== "unknown") {
    proxyIP = connecting;
    remoteIP = xff[0];
  }

  const override = await checkHostOverride(ctx, remoteIP);
  if (override) return { hostName: override, remoteIP, proxyIP };

  let hostName = "";
  const row = await db.prepare("SELECT HostName FROM localdns WHERE IP = ?").bind(remoteIP).first();
  if (row) hostName = row.HostName;
  if (!hostName) hostName = (await reverseDNS(remoteIP)) || remoteIP;

  if (await db.prepare("SELECT 1 FROM hostoverride WHERE HostName = ?").bind(hostName).first()) {
    throw new FatalError(`Host ${hostName} is password-protected - not updating server details`);
  }
  return { hostName, remoteIP, proxyIP };
}

async function checkHostOverride(ctx, remoteIP) {
  const { db, p } = ctx;
  const hostname = p.get("hostname");
  const password = p.get("password");

  if (truthy(password) && truthy(hostname)) {
    const ok = await db.prepare("SELECT 1 FROM hostoverride WHERE Password = ? AND HostName = ?")
      .bind(password, hostname).first();
    if (!ok) throw new FatalError("Password and hostname do not match!");
    ctx.para("Hostname override password accepted");
    return hostname;
  }

  if (truthy(hostname)) {
    const ips = await resolveDNS(hostname, remoteIP.includes(":") ? "AAAA" : "A");
    if (ips.length === 0) throw new FatalError(`LocalName ${hostname}: unknown host!`);
    if (ips.some((ip) => normalizeIP(ip) === normalizeIP(remoteIP))) {
      ctx.para(`DNS mapping ${remoteIP} -> ${hostname} accepted`);
      return hostname;
    }
    throw new FatalError(`Password required for LocalName ${hostname} (${ips[0]}) override`);
  }
  return null;
}

// ---------------------------------------------------------------- DNS over HTTPS
// Workers have no gethostbyname()/gethostbyaddr(), so ask Cloudflare's resolver.

const DNS_TYPES = { A: 1, AAAA: 28, PTR: 12 };

async function dohQuery(name, type) {
  try {
    const res = await fetch(
      `https://cloudflare-dns.com/dns-query?name=${encodeURIComponent(name)}&type=${type}`,
      { headers: { Accept: "application/dns-json" } }
    );
    if (!res.ok) return [];
    const json = await res.json();
    return (json.Answer ?? []).filter((a) => a.type === DNS_TYPES[type]).map((a) => a.data);
  } catch {
    return [];
  }
}

function resolveDNS(hostname, type) {
  return dohQuery(hostname, type);
}

async function reverseDNS(ip) {
  let name;
  if (ip.includes(":")) {
    name = expandIPv6(ip).split("").reverse().join(".") + ".ip6.arpa";
  } else if (/^\d+\.\d+\.\d+\.\d+$/.test(ip)) {
    name = ip.split(".").reverse().join(".") + ".in-addr.arpa";
  } else {
    return "";
  }
  const names = await dohQuery(name, "PTR");
  return names.length ? names[0].replace(/\.$/, "") : "";
}

// "2001:db8::1" -> 32 hex digits, for comparing and reverse lookups
function expandIPv6(ip) {
  const parts = ip.toLowerCase().split("::");
  const head = parts[0] ? parts[0].split(":") : [];
  const tail = parts.length > 1 && parts[1] ? parts[1].split(":") : [];
  const missing = 8 - head.length - tail.length;
  return [...head, ...Array(Math.max(missing, 0)).fill("0"), ...tail]
    .map((g) => g.padStart(4, "0")).join("");
}

function normalizeIP(ip) {
  return ip.includes(":") ? expandIPv6(ip) : ip;
}

// ---------------------------------------------------------------- request parsing

// Merge query string and form body like PHP's $_REQUEST, including
// array parameters such as nm[0]=...&nm[1]=... or nm[]=...
async function getParams(request) {
  const params = new URLSearchParams(new URL(request.url).search);
  if (request.method === "POST") {
    const type = request.headers.get("Content-Type") ?? "";
    if (type.includes("application/x-www-form-urlencoded")) {
      for (const [k, v] of new URLSearchParams(await request.text())) params.append(k, v);
    } else if (type.includes("multipart/form-data")) {
      for (const [k, v] of await request.formData()) if (typeof v === "string") params.append(k, v);
    }
  }

  const scalars = {};
  const arrays = {};
  for (const [key, value] of params) {
    const m = key.match(/^([^[]+)\[(\d*)\]$/);
    if (m) {
      const arr = (arrays[m[1]] ??= []);
      if (m[2] === "") arr.push(value);
      else arr[Number(m[2])] = value;
    } else {
      scalars[key] = value; // later (POST) values win, as in PHP
    }
  }
  return {
    get: (k) => scalars[k] ?? "",
    arr: (k) => arrays[k] ?? null,
  };
}

// ---------------------------------------------------------------- helpers

// PHP truthiness for request strings: "" and "0" are false
function truthy(v) {
  return v !== undefined && v !== null && v !== "" && v !== "0";
}

function str(v) {
  return v === null || v === undefined ? "" : String(v);
}

function pad(n, width) {
  return String(n).padStart(width, "0");
}

function esc(v) {
  return str(v).replace(/[&<>"']/g, (c) =>
    ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;" })[c]);
}

// "YYYY-MM-DD HH:MM:SS" -> "HH:MM on DD/MM/YYYY"
function formatTimestamp(ts) {
  if (!ts) return "";
  return `${ts.slice(11, 13)}:${ts.slice(14, 16)} on ${ts.slice(8, 10)}/${ts.slice(5, 7)}/${ts.slice(0, 4)}`;
}

function htmlHeader(title) {
  return `<?xml version="1.0" encoding="UTF-8"?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="${DOCROOT}dopewars.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />
  <link rel="made" type="text/html" href="mailto:benwebb@users.sf.net" />
  <title>${esc(title)}</title>
</head>

<body>
<p class="sitelinks">
  <a href="${DOCROOT}">Main Index</a> *
  <a href="${DOCROOT}news.html">News</a> *
  <a href="${DOCROOT}docs/index.html">Documentation</a> *
  <a href="${DOCROOT}faq.html">FAQ</a> *
  <a href="${DOCROOT}download.html">Download</a> *
  <a href="${DOCROOT}screenshots/index.html">Screenshots</a> *
  Active servers *
  <a href="https://sourceforge.net/projects/dopewars/">SourceForge project page</a> *
  <a href="https://github.com/benmwebb/dopewars">GitHub</a>
</p>

<h1>${esc(title)}</h1>

`;
}

function htmlFooter(servername) {
  const trail = servername
    ? ` :\n  <a href="?getlist=2">Active servers</a> :\n  ${esc(servername)}`
    : " :\n  Active servers";
  return `\n<p class="navlinks">\n  <a href="${DOCROOT}">Main Index</a>${trail}\n</p>` + OUTRO_HTML;
}

const INTRO_HTML = `<p>dopewars incorporates limited multiplayer capabilities, with a server
mode (the -s switch). The list below is maintained automatically, providing
that you're running a server of version 1.5.1 or above. In some cases (usually
if you're connecting via a proxy) the metaserver may report your domain
name incorrectly, or refuse connection entirely; see the
<a href="${DOCROOT}docs/metaserver.html">metaserver</a>
page for tips on fixing this problem. Additional problems can usually be solved
by <a href="mailto:benwebb@users.sf.net">emailing</a> the metaserver
maintainer.</p>

<p>To prevent your server announcing itself to the outside world, add the
line "MetaServer.Active=0" (without the quotes) to your dopewars configuration
file (<tt>/etc/dopewars</tt> or <tt>~/.dopewars</tt> on Linux/Mac/Unix,
<tt>C:\\Users\\user\\AppData\\Local\\dopewars\\dopewars-config.txt</tt> on Windows)
or run the server with the <b>-S</b> command line option rather than
<b>-s</b>.</p>

<p>Please note that all servers are checked for service; those that are
unreachable or refuse connection will be removed from this list.</p>

<p>If a given server is reporting its high scores to the metaserver, the
server name will be hyperlinked (only versions 1.5.1 and above do this -
older versions only work with the "old" metaserver). Follow the link to
see the current high scores.</p>

`;

const OUTRO_HTML = `

<address>
  <a href="https://jigsaw.w3.org/css-validator/validator?uri=https://dopewars.sourceforge.io/metaserver.php">
    <img class="w3clink" src="${DOCROOT}valid-css.png" alt="Valid CSS" />
  </a>
  <a href="https://validator.w3.org/check?uri=https://dopewars.sourceforge.io/metaserver.php">
    <img class="w3clink" src="${DOCROOT}valid-xhtml11.png" alt="Valid XHTML 1.1" />
  </a>
  <a href="https://sourceforge.net/projects/dopewars">
    <img class="w3clink" src="https://sflogo.sourceforge.net/sflogo.php?group_id=11128&amp;type=12"
     width="120" height="30"
      alt="Fast, secure and Free Open Source software downloads" />  </a>
  <span class="editlink">
    <a class="editlink" href="https://github.com/benmwebb/dopewars-website/blob/main/cloudflare/src/index.js"><i class="fab fa-github"></i> Edit on GitHub</a>
  </span>
  Written by <a href="mailto:benwebb@users.sf.net">Ben Webb</a><br />
</address>

</body>

</html>
`;
