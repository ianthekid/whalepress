#!/bin/bash

echo "cloning repo"
cd wordpress/wp-content/themes
git clone $THEME_REPO $THEME_NAME

if [ ! -z $BUILD_CMD ]
then
  echo "running theme build command"
  cd $THEME_NAME
  $BUILD_CMD
fi

echo "set theme"
cd $WPCLI_DIR
wp theme activate $THEME_NAME $WPCLI_PARAMS

# Remove default themes
wp theme delete twentyseventeen $WPCLI_PARAMS
wp theme delete twentynineteen $WPCLI_PARAMS
wp theme delete twentytwenty $WPCLI_PARAMS