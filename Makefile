twig:
	php bin/console lint:twig templates
	vendor/bin/twigcs templates

phpmd:
	vendor/bin/phpmd src/ text .phpmd.xml

insights:
	vendor/bin/phpinsights --no-interaction

phpcpd:
	vendor/bin/phpcpd src/