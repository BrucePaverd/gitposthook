#!/bin/bash

. /etc/bashrc

whoami

# Checkout the branch
cd /home/rcn2/committest
git checkout prod
git pull
git checkout $1

# Create tag
git tag -a $1 -m "Tag for $1"

# Delete branch
git checkout prod
git push origin :$1
git branch -D $1

# Push tag
git push origin $1


echo "Done with git tag" $1
