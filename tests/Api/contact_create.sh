#!/usr/bin/bash
source vars.sh
# -H "Content-Type: application/json"
curl -X POST -H "Accept: application/json" \
	 -H "Content-Type: application/json" \
	 -H "Authorization: Bearer $TOKEN_VALUE" \
	 -d '{"sponsor_id": "1", "name": "Contact1", "phone": "9257897896", "address": "123 AAA Drive", "email": "contact1@mymail.com"}' \
    $URL_HOST/api/sponsor/contact/create
