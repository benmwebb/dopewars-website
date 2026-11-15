#!/usr/bin/env python3
"""Generate a static dopewars HTML page from a Jinja2 template.

Usage: render.py [--var NAME=VALUE ...] WEBTOP TEMPLATE OUTFILE
"""

import argparse
import os
import sys

import jinja2

TOPDIR = os.path.dirname(os.path.abspath(__file__))

# Stuff that varies from mirror to mirror
SITE = {
    # Root directory of the web site
    'docroot': '/',
    # Root directory for downloads
    'dnlroot':
        'https://sourceforge.net/projects/dopewars/files/dopewars/1.7.0/',
}


def raise_error(msg):
    raise jinja2.TemplateError(msg)


def main():
    parser = argparse.ArgumentParser(
        description="Generate a dopewars HTML page from a Jinja2 template")
    parser.add_argument('--var', action='append', default=[],
                        metavar='NAME=VALUE',
                        help="Pass an extra variable to the template")
    parser.add_argument('webtop', help="Top-level web output directory")
    parser.add_argument('template', help="Input Jinja2 template")
    parser.add_argument('outfile', help="Output HTML file")
    args = parser.parse_args()

    env = jinja2.Environment(loader=jinja2.FileSystemLoader(TOPDIR),
                             undefined=jinja2.StrictUndefined,
                             keep_trailing_newline=True)
    env.globals.update(SITE)
    env.globals['raise'] = raise_error

    # Template path relative to the top of the repository, used for the
    # "Edit on GitHub" link
    source = os.path.relpath(os.path.abspath(args.template), TOPDIR)
    # Page path relative to the top of the web site, used for the
    # validator links (index.html pages are referenced by directory)
    outfile = os.path.relpath(os.path.abspath(args.outfile),
                              os.path.abspath(args.webtop))
    if os.path.basename(outfile) == 'index.html':
        outfile = outfile[:-len('index.html')]

    context = {'source': source.replace(os.sep, '/'),
               'outfile': outfile.replace(os.sep, '/')}
    for var in args.var:
        name, _, value = var.partition('=')
        context[name] = value

    html = env.get_template(context['source']).render(context)
    if '</html>' not in html:
        sys.exit("Error occurred during production of %s" % args.outfile)

    os.makedirs(os.path.dirname(os.path.abspath(args.outfile)), exist_ok=True)
    tmpfile = args.outfile + '.tmp'
    with open(tmpfile, 'w', encoding='utf-8') as fh:
        fh.write(html)
    os.replace(tmpfile, args.outfile)


if __name__ == '__main__':
    main()
