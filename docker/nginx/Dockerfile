FROM nginx:1.21.4

COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY nginx-selfsigned.crt /usr/nginx/
COPY nginx-selfsigned.key /usr/nginx/

EXPOSE 9443:443
ENTRYPOINT nginx -g 'daemon off;'
