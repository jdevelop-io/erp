# Enterprise Resource Planning (ERP)

[![Test](https://github.com/jdevelop-io/erp/actions/workflows/test.yml/badge.svg)](https://github.com/jdevelop-io/erp/actions/workflows/test.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![wakatime](https://wakatime.com/badge/user/b5dd94a4-c0ea-4c12-9cb2-41f984e74fdc/project/a19cc586-7b1d-4e83-91b9-ad726913b6a3.svg)](https://wakatime.com/badge/user/b5dd94a4-c0ea-4c12-9cb2-41f984e74fdc/project/a19cc586-7b1d-4e83-91b9-ad726913b6a3)

# Getting Started

## PHPStorm and XDebug configuration

1. Build the docker image
   ```bash
   docker build -f .docker/php/Dockerfile -t jdevelop/php .
   ```

2. Set Up Docker in PhpStorm:
   Go to Settings > Build, Execution, Deployment > Docker.  
   Add a new Docker configuration.  
   Choose the Docker daemon option (typically the default).  
   PhpStorm should now be able to see your Docker containers.  
   ![PHPStorm Docker Configuration](doc/asset/image/phpstorm/settings/docker.png)

3. Set Up a Server:
   Go to Settings > Languages & Frameworks > PHP > Servers.  
   Click + to add a new server.  
   Name: docker  
   Host: localhost  
   Port: 8000 or your chosen port.  
   Check the box that says "Use path mappings".  
   Map the project root (/var/www/html) to the container's /var/www/html.  
   ![PHPStorm Server Configuration](doc/asset/image/phpstorm/settings/servers.png)

4. PHP Interpreter:
   Go to Settings > Languages & Frameworks > PHP.  
   Under "CLI Interpreter", click ... to add a new interpreter.  
   Choose Docker and select your php service.  
   PhpStorm will automatically detect the PHP version inside the container.  
   ![PHPStorm PHP Interpreter Configuration](doc/asset/image/phpstorm/settings/php-remote-cli_1.png)  
   ![PHPStorm PHP Interpreter Configuration](doc/asset/image/phpstorm/settings/php-remote-cli_2.png)

5. Configure PHPUnit:
   Go to Settings > Languages & Frameworks > PHP > Test Frameworks.  
   Add a new PHPUnit configuration.  
   Select "By remote interpreter".  
   Choose the Docker interpreter you set up earlier.  
   Use the path to PHPUnit inside the container, for example, /var/www/html/vendor/bin/phpunit.  
   ![PHPStorm PHPUnit Configuration](doc/asset/image/phpstorm/settings/phpunit.png)
