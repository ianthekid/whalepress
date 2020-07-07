# WhalePress

Headless WordPress in Docker Container hosted on AWS. It uses [WPGraphQL](https://www.wpgraphql.com/) and [ACF](https://www.advancedcustomfields.com/) with a few other plugins so you can use WordPress as a headless CMS.

## Tech Stack

* Docker
* NGINX
* PHP7.4
* WP-CLI
* AWS CLI
* WordPress
* WPGraphQL
* Advanced Custom Fields (ACF)
* Custom Post Type UI

## AWS Hosting

AWS provides free hosting tier for starting, and auto-scaling as needed. You can also add backups using Lifecycle Manager to schedule snapshots

* RDS - MariaDB
* EC2
* S3
* CloudFront

## Setup

You need to start by adding your Amazon AWS account credentials to `.env`. The (Optional) fields are noted, all other fields are required to run `setup.sh`

```shell
$ cp .env.example .env
$ ./setup.sh
$ docker-compose build
$ docker-compose up -d
```

Then load the site you specified as `SITEURL` in `.env`

## Author

* [Ian Ray](https://ianray.com/)
* [LinkedIn](https://www.linkedin.com/in/ianrray/)