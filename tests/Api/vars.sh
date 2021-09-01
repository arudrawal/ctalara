#!/usr/bin/bash
export URL_HOST='http://127.0.0.1:8000';
export USER='ajay@hotmail.com';
export PASSWORD='password';
export LOGIN_DATA='{"email":"'"$USER"'","password":"'"$PASSWORD"'"}';
export TOKEN_FILE='../../storage/logs/api_token_curl.txt';
#  cut -f 2 -d:| cut -f 1 -d,
if test -f "$TOKEN_FILE"; then \
	tokenTextQuoted=`cat $TOKEN_FILE | cut -f 2 -d:|cut -f1 -d,`;\
	export TOKEN_VALUE=`echo $tokenTextQuoted | awk -F '"' '{print $2}'`;\
fi
echo 'Token Value: '$TOKEN_VALUE;