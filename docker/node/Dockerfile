FROM ppiper/node-browsers:v22-16-buster

ENV CHROME_BIN=/usr/bin/google-chrome
#ENV CHROME_BIN=/usr/bin/chromium

USER root
ADD start.sh /
RUN chmod 755 /start.sh
# return back to old user (this is different from image to image, verify when change docker image)
USER node
ENTRYPOINT ["/start.sh"]