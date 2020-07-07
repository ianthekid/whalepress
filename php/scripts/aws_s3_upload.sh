#!/bin/bash

# load .env variables
BASE_DIR=/shared/scripts
wpDIR=/shared/html
set -o allexport; source $BASE_DIR/.env; set +o allexport

AWS_ACCESS_KEY_ID=$AWS_KEY AWS_SECRET_ACCESS_KEY=$AWS_SECRET \
aws s3 sync --delete \
$wpDIR/wp-content s3://$S3BUCKET/wp-content \
--exclude "themes/$THEME_NAME/.git/*" \
--exclude "themes/$THEME_NAME/node_modules/*" \
--exclude "themes/$THEME_NAME/vendor/*"

AWS_ACCESS_KEY_ID=$AWS_KEY AWS_SECRET_ACCESS_KEY=$AWS_SECRET \
aws s3 cp \
$wpDIR/wp-config.php s3://$S3BUCKET/wp-config.php

echo "done"