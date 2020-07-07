#!/bin/bash

# DB_HOST var
#export $(cat .db | sed 's/#.*//g' | xargs)

# Download core. 
wp core download --force $WPCLI_PARAMS

# Create WP config file (if one doesnt already exist).
wp config create \
    --dbhost="$DB_HOST:3306" \
    --dbname=$DB_NAME \
    --dbuser=$DB_USER \
    --dbpass=$DB_PASS \
    --force \
    $WPCLI_PARAMS

# Increase memory limit to match php.ini
wp config set WP_MEMORY_LIMIT '512M' --type=constant $WPCLI_PARAMS

# Set domain
wp config set WP_HOME $SITEURL --type=constant $WPCLI_PARAMS
wp config set WP_SITEURL $SITEURL --type=constant $WPCLI_PARAMS

# Turn on debugging.
wp config set WP_DEBUG true --raw --type=constant $WPCLI_PARAMS
wp config set WP_DEBUG_LOG true --raw --type=constant $WPCLI_PARAMS

# Perform WP installation process.
wp core install \
    --url=$DOMAIN \
    --title="$WP_TITLE" \
    --admin_user=$WP_USER \
    --admin_email=$WP_EMAIL \
    --admin_password=$WP_PASS \
    $WPCLI_PARAMS


# Set permalink structure
wp rewrite structure '/blog/%postname%/' $WPCLI_PARAMS

# Remove all posts, comments, and terms.
#wp site empty --yes $WPCLI_PARAMS


# Remove widgets.
#wp widget delete recent-posts-2 $WPCLI_PARAMS
#wp widget delete recent-comments-2 $WPCLI_PARAMS
#wp widget delete archives-2 $WPCLI_PARAMS
#wp widget delete search-2 $WPCLI_PARAMS
#wp widget delete categories-2 $WPCLI_PARAMS
#wp widget delete meta-2 $WPCLI_PARAMS