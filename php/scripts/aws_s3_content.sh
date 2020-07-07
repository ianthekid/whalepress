#!/bin/bash

# load .env variables
BASE_DIR=/shared/scripts
wpDIR=wordpress
set -o allexport; source $BASE_DIR/.env; set +o allexport

AWS_ACCESS_KEY_ID=$AWS_KEY AWS_SECRET_ACCESS_KEY=$AWS_SECRET \
aws s3 sync s3://$S3BUCKET/wp-content $wpDIR/wp-content

echo "Content downloaded to $wpDIR/wp-content/"