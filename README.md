# 42 WikiMedia OAuth connection extension

This extension provides OAuth connection using 42 School's intra as a extension to
(WSOAuth)[https://www.mediawiki.org/wiki/Extension:WSOAuth]

This automates the recommended code checkers for PHP and JavaScript code in Wikimedia projects
(see https://www.mediawiki.org/wiki/Continuous_integration/Entry_points).
To take advantage of this automation.

1. install nodejs, npm, and PHP composer
2. change to the extension's directory
3. `npm install`
4. `composer install`

Once set up, running `npm test` and `composer test` will run automated code checks.
