# Absolute Cache Bust
With Absolute Cache Bust for Magento 2 you can ensure your customers are viewing the latest version of your images, CSS and JavaScript files.
This extension can be used with or without a CDN, and will also bust local versions of assets in your customers web browser cache.
Find more information at https://abscom.co/cachebust.

# Version Compatibility

- For Magento 2.2.x and later please use version 3.x.x of this extension.
- For earlier Magento versions, please use version 2.x.x of this extension.

# Installation
The best way to add the extension is via composer.

```
composer require absolute/magento2-cache-bust
```

Once the extension has been added, update Magento 2 in the normal fashion.

```
php bin/magento setup:upgrade
```

# Web Server Configuration
Some web server configuration is required in order for requests to `yoursite.com/static/version12345/some/asset.js` to resolve correctly.
The intention is for the web server to ignore the segment `/version12345/` and process the request as if it were not there.

Add the following to the appropriate location in your web server configuration.

## Nginx
For the static cache busting, Magento already has the following in the recommended nginx configuration:

```
location /static/ {
    ...

    location ~ ^/static/version {
        rewrite ^/static/(version\d*/)?(.*)$ /static/$2 last;
    }
    
    ...
```

For the media cache busting, add the following to your nginx configuration:

```
location /media/ {
   ...
   
   location ~ ^/media/version {
       rewrite ^/media/(version\d*/)?(.*)$ /media/$2 last;
   }
   
   ...
}
```

## Apache
For the static cache busting, Magento already has the following configuration in `pub/static/.htaccess`:
 
```
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Remove signature of the static files that is used to overcome the browser cache
    RewriteRule ^version.+?/(.+)$ $1 [L]

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-l

    RewriteRule .* ../static.php?resource=$0 [L]
</IfModule>
```

For the media cache busting, update `pub/media/.htaccess` with the following:

```
<IfModule mod_rewrite.c>

############################################
## enable rewrites

    Options +FollowSymLinks
    RewriteEngine on

############################################
## Absolute Cache Bust
    RewriteRule ^version.+?/(.+)$ $1 [L]

############################################
## never rewrite for existing files
    RewriteCond %{REQUEST_FILENAME} !-f

############################################
## rewrite everything else to index.php

    RewriteRule .* ../get.php [L]
    
</IfModule>
```

# Usage
Once installed and configured, there are various ways to bust your Magento 2 websites cached assets.

## Admin Panel Buttons
In the Magento Admin Panel go to `System > Cache Management` and you will see a new section at the bottom called `Cache Busting`.
Clicking these buttons will update the dynamic element `/version12345/` with a new value and then flush the appropriate Magento caches, so on their next visit your customers will download the assets afresh.

## Command Line Interface (CLI)
In the Magento CLI tool you will see some new commands available, which can be used to automatically bust your cache during a deployment for example.

```
./bin/magento absolute:cache-bust:all
./bin/magento absolute:cache-bust:static
./bin/magento absolute:cache-bust:media
```

# Help / Support
Need help or custom development? Find us at https://absolutecommerce.co.uk.
For terms and conditions and license information, please visit https://abscom.co/terms.
