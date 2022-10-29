FROM node:18-alpine

# required with manipilating with some php composer packages
#RUN apt-get -y update
#RUN apt-get -y install git

# required for JS files if exists
#RUN apt-get -y update
#RUN apt-get -y install npm
RUN apk update && apk add bash

ADD start.sh /
RUN chmod +x /start.sh
ENTRYPOINT ["/start.sh"]

#EXPOSE 8888