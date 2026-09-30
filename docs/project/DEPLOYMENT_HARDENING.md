# CodeSommet — Deployment Hardening Notes

Server-side rules that complement the application-level controls. These are
**defence in depth**: uploads are already re-encoded (stripping any appended
executable content) and stored under server-generated names, but the web
server must also refuse to execute anything in the upload/storage tree.

## Upload directory — never execute PHP

Uploads land in `storage/app/public/media/` and are served through the
`public/storage` symlink. Ensure the web server cannot execute PHP there.

### Nginx

```nginx
# Serve the app.
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

# PHP only for the front controller.
location ~ ^/index\.php {
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}

# Never execute scripts under the public storage tree.
location ^~ /storage/ {
    location ~* \.(php|phtml|phar|cgi|pl|py|sh)$ { deny all; return 403; }
    add_header X-Content-Type-Options nosniff always;
}

# Block dotfiles and sensitive files.
location ~ /\.(env|git|htaccess) { deny all; }
```

### Apache (`public/storage/.htaccess`)

```apache
# Disable any handler-based execution in the storage tree.
<FilesMatch "\.(php|phtml|phar|cgi|pl|py|sh)$">
    Require all denied
</FilesMatch>
php_flag engine off
Options -ExecCGI -Indexes
Header set X-Content-Type-Options "nosniff"
```

> Note: because `public/storage` is a symlink to `storage/app/public`, confirm
> `Options +FollowSymLinks` is present for that path (Laravel's default
> `public/.htaccess` already sets it) and that the storage `.htaccess` above is
> applied to the symlink target.

## SQLite database — outside the document root

`config/database.php` resolves the DB to `database/database.sqlite`
(via `database_path()`), which is **outside `public/`** and not web-reachable.
Verify the deploy does not copy `database/*.sqlite` into `public/`, and that
backups (`database/database.before-security-fixes.sqlite`) are excluded from the
deployable artifact (they are already gitignored via `database/.gitignore`).

## Directory listing

Ensure `Options -Indexes` (Apache) / no `autoindex` (Nginx) globally so no
directory can be browsed.

## HTTPS / proxies

Set `TRUSTED_PROXIES` when behind a load balancer; the app forces HTTPS URLs in
production (`AppServiceProvider`) and the `SecurityHeaders` middleware emits HSTS
only over HTTPS in production.

## Verification checklist (run once after deploy)

- `curl -I https://host/storage/media/<known>.png` → 200 image, `X-Content-Type-Options: nosniff`.
- Upload a PNG/PHP polyglot, then request it → served as an image, PHP NOT executed.
- `curl https://host/.env` → 403/404.
- `curl https://host/storage/` → no directory listing.
- Security headers present on `/`.
