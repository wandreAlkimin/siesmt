#!/bin/bash
set -e

php artisan migrate --seed

exec apache2-foreground
