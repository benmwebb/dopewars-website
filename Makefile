WEB=${WEBTOP}
FILES=${WEB}/index.html ${WEB}/download.html ${WEB}/faq.html ${WEB}/news.html \
      ${WEB}/dopewars.css
TOPDIR=.
SUBDIRS=screenshots

include ${TOPDIR}/Makefile.include

${WEB}/dopewars.css: dopewars.css
	cp $< $@
