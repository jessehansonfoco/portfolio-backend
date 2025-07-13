#!/bin/bash
bin/console doctrine:schema:drop --force
bin/console doctrine:schema:create
bin/console webapp:create:user --email jesse@jessehanson.com --password passw0rd --first Jesse --last Hanson
bin/console webapp:demo:insert
