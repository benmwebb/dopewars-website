HTML    = index.html download.html faq.html news.html
SUBDIRS = screenshots
MAKE    = make
INCDIR  = ~ben/public_html/dopewars/include
PHPROOT = ~ben/dopewars/web-template
INCLUDE = ${INCDIR}/dopefunc.php
PHPDIR  = ${PHPROOT}
DNLROOT = 

.PHONY: subdirs ${SUBDIRS}

all : ${HTML} subdirs

subdirs: ${SUBDIRS}

${SUBDIRS}:
	${MAKE} -C $@

%.html : ${PHPDIR}/%.php ${INCLUDE}
	dnlroot=${DNLROOT} php $< | awk 'BEGIN { body=0} ($$0=="" || $$0=="\r") && !body { body=1; next } body { print }' > phpout
	@grep -q "</html>" phpout && mv phpout $@ || (echo "Error occurred during production of $@: check phpout for errors"; exit 1)
