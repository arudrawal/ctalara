#!/usr/bin/bash
source vars.sh
# -H "Content-Type: application/json"
curl -H "Accept: application/json" \
	 -H "Content-Type: application/json" \
	 -H "Authorization: Bearer $TOKEN_VALUE" \
    $URL_HOST/api/protocol/visit/index/1