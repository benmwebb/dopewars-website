WEB=${WEBTOP}/screenshots
FILES=${WEB}/index.html ${WEB}/linux-gtk-multi.html \
      ${WEB}/linux-curses-multi.html ${WEB}/linux-curses-ptbr.html \
      ${WEB}/win32-single.html ${WEB}/winxp-multi.html
TOPDIR=..

include ${TOPDIR}/Makefile.vars

${WEB}/index.html: index.html.j2 ${INCLUDE}
	${RENDER} ${WEBTOP} $< $@

${WEB}/%.html: index.html.j2 ${INCLUDE}
	${RENDER} --var pic=$* ${WEBTOP} $< $@
