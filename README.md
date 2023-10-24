# Digivate-test

## How to use this project

### Requirement
- composer
- npm 

### Installation
- clone this project
- install WordPress and plugins runing 
```shell script
composer install
```
- copy data base from this repo (SQL file)
- install the database 
- create and setup a wp-config.php file with you'r database credentials
- login in the admin with this credentials :

username : digivate-admin
password : ND*BuYBFDAp6YejDbAjVLIS2

### Alternative installation
if the first method does not work or you prefere another one :

Download the duplicator package and installer.php at the root of the project and use it https://duplicator.com/how-to-migrate-wordpress-site/
Install the package 

## description of the project
- Custom starter theme based on Ignition Press with webpack and SASS include in it.
- Custom template "posts-custom-template.php" who's calling parts files called "hero-banner" and "custom-posts-archive.php"
- This template is used by the "news" page.
- the pagination start when there more than 3 posts, this setting can be adjuted in the back office in settings -> Reading -> "Blog pages show at most"
- the main modified files in this project are : 
```shell script
wordpress/wp-content/themes/Digivate-test/posts-custom-template.php
wordpress/wp-content/themes/Digivate-test/src/parts/global/site-top.php
wordpress/wp-content/themes/Digivate-test/src/parts/hero-banner.php
wordpress/wp-content/themes/Digivate-test/src/parts/custom-posts-archive.php
wordpress/wp-content/themes/Digivate-test/src/parts/global/site-footer.php
wordpress/wp-content/themes/Digivate-test/src/parts/post/_post.scss
wordpress/wp-content/themes/Digivate-test/src/sass/global/_menus.scss
wordpress/wp-content/themes/Digivate-test/src/sass/global/_page.scss
wordpress/wp-content/themes/Digivate-test/src/sass/_variables.scss
wordpress/wp-content/themes/Digivate-test/src/sass/core/_panel-left-layout.scss
wordpress/wp-content/themes/Digivate-test/src/sass/global/_menus.scss
wordpress/wp-content/themes/Digivate-test/src/sass/global/_panels.scss
wordpress/wp-content/themes/Digivate-test/theme.config.json
```

## Duration of tasks
I recorded the time I took for each task whith https://app.clockify.me/

- Setup github project : 3 min
- Set up local v host : 2 min
- Set up wordpress files and theme : 30 min
- Create the post archive template : 3 min
- Setup and style the menu : 25 min
- Create post hero banner : 30 min
- Create blog post archive : 20 min
- fix responsive design : 60 min

TOTAL : 2 hours and 53 minutes
