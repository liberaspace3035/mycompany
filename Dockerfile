FROM caddy:2-alpine

# Static site config + assets
COPY Caddyfile /etc/caddy/Caddyfile
COPY index.html /srv/index.html
COPY assets /srv/assets
COPY apps /srv/apps

# Railway injects $PORT; Caddyfile reads it. EXPOSE is informational.
EXPOSE 80

CMD ["caddy", "run", "--config", "/etc/caddy/Caddyfile", "--adapter", "caddyfile"]
