#!/bin/bash

# load .env variables
BASE_DIR=/shared/scripts
export $(cat $BASE_DIR/.env | sed 's/#.*//g' | xargs)

echo "cd to /shared/html/wp-content/themes/$THEME_NAME"
cd /shared/html/wp-content/themes/$THEME_NAME

echo "running 'git pull' from $THEME_REPO"
echo "========================="
git pull $THEME_REPO
echo "========================="

echo "chown ownership www-data"
chown -R www-data:www-data .

if [ ! -z $BUILD_CMD ]
then
  echo "running theme build command"
  $BUILD_CMD
fi
