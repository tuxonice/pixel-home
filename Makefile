# Include this makefile in your Makefile
# And add help text after each target name starting with '\#\#'
# A category can be added with @category
HELP_FUN = \
	%help; \
	while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([a-zA-Z\-]+)\s*:.*\#\#(?:@([a-zA-Z\-]+))?\s(.*)$$/ }; \
	print "usage: make [target]\n\n"; \
	for (sort keys %help) { \
	print "${WHITE}$$_:${RESET}\n"; \
	for (@{$$help{$$_}}) { \
	$$sep = " " x (32 - length $$_->[0]); \
	print "  ${YELLOW}$$_->[0]${RESET}$$sep${GREEN}$$_->[1]${RESET}\n"; \
	}; \
	print "\n"; }

help: ##@help show this help
	@perl -e '$(HELP_FUN)' $(MAKEFILE_LIST)
.PHONY: help

start: ##@setup start the application server
	vendor/bin/sail up -d
.PHONY: start

stop: ##@setup stop the application servers
	vendor/bin/sail stop
.PHONY: stop

composer-install: ##@setup install dependencies
	vendor/bin/sail composer install
.PHONY: composer-install

pint: ##@setup run code style fixer
	vendor/bin/sail shell -c 'vendor/bin/pint'
.PHONY: pint

pint-test: ##@setup run code style checker
	vendor/bin/sail shell -c 'vendor/bin/pint --test'
.PHONY: pint-test

tests: ##@setup run tests
	vendor/bin/sail artisan test
.PHONY: tests
