WEB=${WEBTOP}/screenshots
FILES=${WEB}/index.html ${WEB}/linux-gtk-multi.html \
      ${WEB}/linux-curses-multi.html ${WEB}/linux-curses-ptbr.html \
      ${WEB}/win32-single.html ${WEB}/winxp-multi.html
TOPDIR=..

include ${TOPDIR}/Makefile.vars

${WEB}/index.html: index.php ${INCLUDE}
	@if [ ! -d ${WEB} ]; then mkdir -p ${WEB}; fi
	php -d include_path="${TOPDIR}" -f $< > phpout
	@grep -q "</html>" phpout && cp phpout $@ && rm phpout || (echo "Error occurred during production of $@: check phpout for errors"; exit 1)

${WEB}/%.html: index.php ${INCLUDE}
	@if [ ! -d ${WEB} ]; then mkdir -p ${WEB}; fi
	pic="$@" php -d include_path="${TOPDIR}" -f $< > phpout
	@grep -q "</html>" phpout && cp phpout $@ && rm phpout || (echo "Error occurred during production of $@: check phpout for errors"; exit 1)
