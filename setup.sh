#!/bin/bash

# Global params stored in .env
set -o allexport; source .env; set +o allexport
export WPCLI_DIR=$(pwd)
export WPCLI_PARAMS='--path=wordpress/ --allow-root'

# Check if existing install
if wp core is-installed $WPCLI_PARAMS
then
  echo "============================================"
  echo "WordPress is already installed, exiting."
  echo "To start over, delete ./wordpress and run ./setup.sh"
  echo "============================================"
  exit
fi

######################################
# WordPress Install Process
######################################

# Database on AWS RDS (mariaDB)
if [ -z $DB_HOST ]
then
  echo "Creating AWS RDS database in Region: $AWS_REGION"
  ./setup/database.sh
  #re-import .env vars for DB_HOST
  set -o allexport; source .env; set +o allexport
fi

# WordPress Core + wp-config.php settings
echo "Install WordPress core and define wp-config.php parameters"
./setup/wordpress.sh
cp .env ./wordpress

# Headless Theme and wpgraphql plugins
echo "Set themes/plugins"
./setup/theme.sh
./setup/plugins.sh

# Done
echo "============================================"
echo "Wordpress setup complete."
echo "Run: $(tput setaf 3)docker-compose build$(tput sgr 0)"
echo "============================================"
