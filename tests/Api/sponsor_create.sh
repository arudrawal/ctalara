#!/usr/bin/bash
source vars.sh
# -H "Content-Type: application/json"
curl -X POST -H "Accept: application/json" \
	 -H "Content-Type: application/json" \
	 -H "Authorization: Bearer $TOKEN_VALUE" \
	 -d '{"name": "AAAAAA", "code": "ACODE-ACODE", "address": "123 AAA Drive"}' \
    $URL_HOST/api/sponsor/create