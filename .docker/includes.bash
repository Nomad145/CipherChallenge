# Aliases for common commands

alias dcomposer="docker-compose exec php composer --working-dir=/app/"
alias dphpunit="docker-compose exec php php -d memory_limit=-1 /app/vendor/bin/phpunit -c /app/"
alias dconsole="docker-compose exec php php -d memory_limit=-1 /app/bin/console"
alias test="docker-compose exec php php -d memory_limit=-1 /app/.ideas/test_2.php"
alias scratch="docker-compose exec php php /app/.ideas/scratch.php"

alias pcomposer="docker-compose exec php composer --working-dir=/package/"
alias pphpunit="docker-compose exec php php -d memory_limit=-1 /package/vendor/bin/phpunit -c /package/"
