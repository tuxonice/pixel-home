#!/bin/sh

# Usage: ./deploy.sh [tag or commit hash]

set -e

MAIN_PATH=$(pwd)

if [ -z "$1" ]
then
    release_name=$(date +"%Y%m%d_%H%M%S")
else
    release_name=$1
fi

mkdir "releases/$release_name"

cd "releases/$release_name" || exit

git clone https://github.com/tuxonice/pixel-home.git .

if [[ $# -eq 0 ]] ; then
    git checkout $release_name
fi

composer install --no-dev
npm install
npm run prod

rm .dockerignore .editorconfig .env.example .gitattributes .gitignore .styleci.yml docker-compose.yml phpunit.xml renovate.json server.php README.md
rm -rf tests .github .git storage tools docker

ln -s $MAIN_PATH/shared/.env .env
ln -s $MAIN_PATH/shared/storage storage

cd $MAIN_PATH

rm current
ln -s "releases/$release_name/public/" current
