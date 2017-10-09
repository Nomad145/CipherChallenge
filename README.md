# Cipher Challenge
This repository provides a solution for the Cipher Challenge as both a command and a web interface.

## Getting Started
Little configuration is needed to run the application.

### Install Dependencies
```
composer install
```
The application also depends on a source text file to build a Frequency Distribution that can be found in `includes/plain.txt`.

### Console Command
To execute the application from the command line:
```
php -d memory_limit=-1 bin/console decipher path/to/encrypted.txt
```

### Web Interface
To run the application from a web interface, point a web server to `web/index.php`.

