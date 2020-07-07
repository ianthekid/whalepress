#!/bin/bash

## CREATE DATABASE 
AWS_ACCESS_KEY_ID=$AWS_KEY AWS_SECRET_ACCESS_KEY=$AWS_SECRET \
AWS_DEFAULT_REGION=$AWS_REGION \
aws rds create-db-instance \
  --db-name $DB_NAME \
  --db-instance-identifier $DB_INSTANCE \
  --db-instance-class "db.t2.micro" \
  --master-username $DB_USER \
  --master-user-password $DB_PASS \
  --allocated-storage 20 \
  --publicly-accessible \
  --no-enable-iam-database-authentication \
  --engine mariadb

## WAIT FOR DB INSTANCE
AWS_ACCESS_KEY_ID=$AWS_KEY AWS_SECRET_ACCESS_KEY=$AWS_SECRET \
AWS_DEFAULT_REGION=$AWS_REGION \
aws rds wait db-instance-available \
  --db-instance-identifier $DB_INSTANCE \

## GET DETAILS AND ENDPOINT
DB_HOST=($(AWS_ACCESS_KEY_ID=$AWS_KEY AWS_SECRET_ACCESS_KEY=$AWS_SECRET \
AWS_DEFAULT_REGION=$AWS_REGION \
aws rds describe-db-instances \
  --db-instance-identifier $DB_INSTANCE | jq -r '.DBInstances[].Endpoint.Address'))

## Update DB_HOST value
sed -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/" .env
