FROM nginx

MAINTAINER Michael Phillips <michael.phillips@manpow.com>

COPY bin/entrypoint.sh /usr/local/bin
RUN chmod +x /usr/local/bin/entrypoint.sh
COPY conf/vhost.conf /etc/nginx/nginx.conf
ENV ENVIRONMENT dev

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
