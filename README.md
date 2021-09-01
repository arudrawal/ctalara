
## About CTA

Clinical trial assistant: corporation sponsors a nueropsychiatric medicine study. 
 Geo sites are selected for study and subjects (patients) are enrolled on site basis.
 Each subject is given treatment and monitored for results. Application keeping
 track of visits and using scales (forms) with questionnaire to determine the impact
 of medicine. Various modules of application are:
 
- Study configuration and Administartion
- Allow doctors/invetigators to collect data (audio/forms)
- Maintain detailed audit logs
- Allow reviewers to comment and accept/reject data
- Record reviewer/investigator conversation logs and comments
- Post Study: data access and reporting
- Export study data to standard formats

## Application setup and run
- clone the code to local host and change directory to cloned repo root
- cp .env.example .env
- php artisan key:generate
- php artisan serve
- login with user: ajay@hotmail.com, password: password

## Basic navigation
- After login select sponsor -> lead to select study
- select study -> will lead to select site
- select site -> will lead to select subject(patient)
- select subject -> will lead to select visit
- select visit -> will lead to select scale (form)
- select form -> will lead to actual form to fill in.


## Commands to prepare test database
- php artisan migrate:reset
- php artisan migrate
- php artisan db:seed

## Most used commands (quick ref)
- php artisan make:model Study
- php artisan make:test Feature/ApiLoginTest
- php artisan test --filter ApiLoginTest


## Complete cache clear/reload
- php artisan cache:clear
- php artisan route:cache
- php artisan config:cach
- composer dump-autoload -o

