HTML    = index.html linux-gtk-multi.html linux-curses-multi.html \
          linux-curses-ptbr.html win32-single.html winxp-multi.html
MAKE    = make
INCDIR  = ~ben/public_html/dopewars/include
PHPROOT = ~ben/dopewars/web-template
INCLUDE = ${INCDIR}/dopefunc.php
PHPDIR  = ${PHPROOT}/screenshots

.PHONY: subdirs ${SUBDIRS}

all : ${HTML}

index.html : ${PHPDIR}/index.php ${INCLUDE}
	php $< | awk 'BEGIN { body=0} ($$0=="" || $$0=="\r") && !body { body=1; next } body { print }' > phpout
	@grep -q "</html>" phpout && mv phpout $@ || (echo "Error occurred during production of $@: check phpout for errors"; exit 1)

%.html : ${PHPDIR}/index.php ${INCLUDE}
	pic="$@" php $< | awk 'BEGIN { body=0} ($$0=="" || $$0=="\r") && !body { body=1; next } body { print }' > phpout
	@grep -q "</html>" phpout && mv phpout $@ || (echo "Error occurred during production of $@: check phpout for errors"; exit 1)
