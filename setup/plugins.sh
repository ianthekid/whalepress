#!/bin/bash

# mu-plugins
cp -R mu-plugins wordpress/wp-content/

# Setup plugins
cd wordpress/wp-content/plugins
git clone "https://github.com/wp-graphql/wp-graphql.git"
git clone "https://github.com/wp-graphql/wp-graphiql.git"
git clone "https://github.com/wp-graphql/wp-graphql-acf.git"
git clone "https://github.com/wp-graphql/wp-graphql-custom-post-type-ui.git"

cd $WPCLI_DIR
wp plugin install advanced-custom-fields --activate $WPCLI_PARAMS
wp plugin install custom-post-type-ui --activate $WPCLI_PARAMS
#wp plugin install amazon-s3-and-cloudfront --activate $WPCLI_PARAMS
wp plugin activate wp-graphql $WPCLI_PARAMS
wp plugin activate wp-graphiql $WPCLI_PARAMS
wp plugin activate wp-graphql-acf $WPCLI_PARAMS
wp plugin activate wp-graphql-custom-post-type-ui $WPCLI_PARAMS

# Remove default plugins
wp plugin delete hello $WPCLI_PARAMS
wp plugin delete akismet $WPCLI_PARAMS