# clear cache and logs
clearcache:
	@echo Clearing cache...
	@sudo rm -rf app/cache/*
	@sudo rm -rf app/logs/*
	@sudo chmod -R 777 app/cache app/logs

# change folder permissions
chmod:
	@sudo chmod -R 777 app/cache app/logs
	@echo Permissions changed.

# rebuild database. drop then craete database, apply migrations, load fixtures
rebuilddb:
	./app/console doctrine:schema:drop --force --full-database
	./app/console doctrine:schema:update --force
	./app/console doctrine:fixtures:load -n

# run all tests
test:
	@phpunit -c app $(FILE)

# run selenium tests (selenium sever required)
testselenium:
	@phpunit -c app/ --testsuite=Selenium

# run unit tests
testunit:
	@phpunit -c app/ --testsuite=Unit

# start selenium server
seleniumserver:
	java -jar bin/selenium-server.jar

# get latest tag
latesttag:
	@git for-each-ref --sort='*authordate' --format='%(tag)' refs/tags | tail -n1

# fix code style
# usage: make fixcs FILE=path/to/directory/or/file
fixcs:
	bin/php-cs-fixer fix $(FILE) --fixers=indentation,linefeed,trailing_spaces,unused_use,php_closing_tag,return,visibility,braces,phpdoc_params,eof_ending,extra_empty_lines,include,psr0,controls_spaces,elseif

# show fixable files without touching them
fixcsshow:
	bin/php-cs-fixer fix $(FILE) --fixers=indentation,linefeed,trailing_spaces,unused_use,php_closing_tag,return,visibility,braces,phpdoc_params,eof_ending,extra_empty_lines,include,psr0,controls_spaces,elseif --dry-run

# dev server tools
deploydev:
	git pull origin develop
	./app/console doctrine:schema:drop --force --full-database
	./app/console doctrine:schema:update --force
	./app/console doctrine:fixtures:load -e dev -n
	./app/console cache:clear -e dev -n
	./app/console cache:warmup -e dev -n
	chmod -R 777 web/uploads
