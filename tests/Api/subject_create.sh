#!/usr/bin/bash
# study_id as param
source vars.sh
# -H "Content-Type: application/json"
curl -H "Accept: application/json" \
	 -H "Content-Type: application/json" \
	 -H "Authorization: Bearer $TOKEN_VALUE" \
	 -d '{"study_id": "1", "site_id": "0", "code": "SUB1", "initials": "ABC"}' \
    $URL_HOST/api/user/subject/create
