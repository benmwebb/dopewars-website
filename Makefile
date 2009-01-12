WEB=${WEBTOP}
FILES=${WEB}/index.html ${WEB}/download.html ${WEB}/faq.html ${WEB}/news.html \
      ${WEB}/dopewars.css ${WEB}/metaserver.php
TOPDIR=.
SUBDIRS=screenshots

include ${TOPDIR}/Makefile.include

${WEB}/dopewars.css: dopewars.css
	cp $< $@

${WEB}/metaserver.php: metaserver.php
	cp $< $@
