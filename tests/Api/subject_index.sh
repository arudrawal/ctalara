#!/usr/bin/bash
# study_id as param
source vars.sh
# -H "Content-Type: application/json"
curl -H "Accept: application/json" \
	 -H "Content-Type: application/json" \
	 -H "Authorization: Bearer $TOKEN_VALUE" \
    $URL_HOST/api/user/subject/index/1
