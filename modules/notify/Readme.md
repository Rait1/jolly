# Notify 2.0

Many Applications and Modules need to deliver messages to the user, and there is no uniformity on how that is done. This is
where Notify comes in.

Notify is a simple Kohana 3 module designed to capture messages from different methods and modules to be displayed later with a unified look and feel.

# Composer

The module can be installed using [Composer](http://getcomposer.org/). An example `composer.json` file might look like this.

```javascript
{
	"require": {
		"anroots/notify":"2.*"
	}
}

```
To download and install the module (you need to have [Composer](http://getcomposer.org/) installed first):
```bash
$ composer install
```

```bash
Loading composer repositories with package information
Updating dependencies
  - Installing anroots/notify (2.0)
    Downloading: 100%

Writing lock file
Generating autoload files
```

# Requirements

* Kohana 3.3 (for PSR-0 compliance, rename class files to lowercase to use with Kohana 3.2 or enable the legacy autoloader in
`bootstrap.php`)
* PHP 5.4

# Authors

The module was originally developed by Ricardo de Luna (https://github.com/kaltar/Notify).
This is a fork of that work with some added / changed functionality.