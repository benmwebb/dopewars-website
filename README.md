This repository contains files needed to populate the
[dopewars website](https://dopewars.sourceforge.io/).

Note that SourceForge no longer supports PHP scripts, so the old
PHP metaserver no longer works. See the `cloudflare` subdirectory for
the replacement metaserver hosted at Cloudflare.

The HTML pages are generated from [Jinja2](https://jinja.palletsprojects.com/)
templates (`*.html.j2`, which extend `include/base.html.j2`) by the
`render.py` script. Run `make` to build the site into `WEBTOP` (set in
`Makefile.vars`); this requires Python 3 with the `jinja2` package installed.
For example, `make WEBTOP=/tmp/htdocs` builds a local copy of the site.
