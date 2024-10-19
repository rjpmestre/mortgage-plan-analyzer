# Mortgage Plan Analyzer

This Laravel project, developed as part of [SUSE Hack Week 23 and 24](https://hackweek.opensuse.org/24/projects/mortgage-plan-analyzer), is a collaborative effort aimed at simplifying the analysis of housing loan proposals, with a focus on common configurations in Portugal.

## Overview

The Mortgage Plan Analyzer focuses on analyzing proposals that typically have two phases: an initial fixed-rate phase followed by a variable phase composed of a contracted spread and variable Euribor. This project aims to streamline and clarify the financial decision-making process for common housing loans in Portuguese territory.

## Links
- **[GitHub Repository](https://github.com/rjpmestre/Mortgage-Plan-Analyzer)**
- **[SUSE Hack Week 24 Project](https://hackweek.opensuse.org/24/projects/mortgage-plan-analyzer)**
- **[Euribor API](https://rapidapi.com/lrdavocado-O3qmwiGJQwR/api/euribor/)**
- **[Price table (CAS)](https://pt.wikipedia.org/wiki/Tabela_Price)**
- **[Banco de Portugal](https://clientebancario.bportugal.pt/credito-habitacao)**
- **[App Logo](https://app.logo.com/)**

## Contacts
- **GitHub:** [rjpmestre](https://github.com/rjpmestre)
- **Email:** [ricardo.mestre@suse.com](mailto:ricardo.mestre@suse.com)

## How to Contribute

If you are interested in contributing to the Mortgage Plan Analyzer project, feel free to fork the repository and submit pull requests. Your contributions are welcome!

## Version

Current version: v1.1.0

## Installation
### Need:
- php
- git
- docker
- composer

### Execute
```sh
# clone the project
git clone https://github.com/rjpmestre/mortgage-plan-analyzer.git mpa
cd mpa

# basic setup
composer update
cp .env.example .env
# generate your app key
php artisan key:generate
# optional adjust .env file: APP_URL and/or RAPID_API_KEY_EURIBOR [https://rapidapi.com/lrdavocado-O3qmwiGJQwR/api/euribor/]

# build and start docker container
sudo docker-compose build mpa-app
chmod -R 777 storage
sudo ./vendor/bin/sail up -d
```
