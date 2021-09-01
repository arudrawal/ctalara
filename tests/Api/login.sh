#!/usr/bin/bash
source vars.sh
# -H "Content-Type: application/json"
curl -o $TOKEN_FILE \
    -H "Accept: application/json" \
	-H "Content-Type: application/json" \
    -d $LOGIN_DATA \
    $URL_HOST/api/login