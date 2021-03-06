#!/bin/bash

. /etc/bashrc

date

# Checkout the branch
cd /home/rcn2/rcn2
git checkout testing
git pull
git checkout $1

# Create tag
git tag -a archive/$1 -m "Tag for $1"

# Push tag
# git push origin archive/$1
git push --tags prod

# Delete branch locally and on server
git checkout testing
git push origin :$1
git branch -D $1


echo "Done with git tag" $1
