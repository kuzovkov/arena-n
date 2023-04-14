<?php
echo exec('../app/console doctrine:generate:entities CinemaCinemaBundle');
echo exec('../app/console doctrine:schema:update --force');