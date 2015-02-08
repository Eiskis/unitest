
# Unitest

Unitest is a one-class miniature unit testing framework for PHP. It's a great way to get started with unit testing - and do as much as makes sense for your project. For the major leagues, you should probably use [PHPUnit](http://phpunit.de/).

- [GitHub repo](https://github.com/Eiskis/unitest)
- [Download](https://raw.githubusercontent.com/Eiskis/unitest/master/Unitest.php)

## Quick start

```php
// Init
include_once 'Unitest.php';
$suite = new Unitest();

// Your code that needs testing
include_once 'YourClass.php';

// Test classes that extend Unitest (will be loaded into $suite)
$suite->scrape('my-tests/');

// Run tests and get a results array
$results = $suite->run();
```


## Repo contents

- `dashboard/`
	- A full-fledged UI and radiator for running and auto-updating tests and visualizing results.
- `demo/`
	- Simple JSON dump of a report produced by Unitest.
- `html`
	- A simple example of printing results in custom HTML.
- `Unitest.php`
	- Unitest release, in one file.



# Instructions

Unitest is very simple to use. It's easy to get started with, but also extendable.

## Using Unitest

Unitest is a one-class framework. First load the class file:

```php
	include_once 'Unitest.php';
```

Then, instantiate a new suite by creating a Unitest object:

```php
$mainSuite = new Unitest();
```

Any Unitest object can contain both test methods and child suites.



## Writing tests

You write tests as methods (prefixed with `test`) to any class that extends the `Unitest` class. Each test suite you write should have its own class. For example:

```php
class TestSomeMath extends Unitest {

	function testPlus () {
		return $this->should(0 + 1);
	}

	function testOnePlusOne () {
		return $this->should(1 + 1 === 2);
	}

	function testMinus () {
		return $this->shouldBeEqual(0, 1-1, 2-2, 3-3);
	}

}
```



## Running tests

Since your tests come in classes, to run them you need to load the classes and instantiate them and run each one. Unitest can take care of all of this:

```php
$mainSuite->scrape('path/to/your/test/files/');
```

Unitest will:

- look for PHP files
- see if they contain definitions of classes that extend Unitest
- load any file with valid classes
- instantiate objects under `$mainSuite`

Now `$mainSuite` contains all suites you scraped for.

To run all tests of your suite, call:

	$report = $mainSuite->run();

You can run only part of your tests as well:

```php
$mainSuite->run($mainSuite->ownTests());
$mainSuite->run($mainSuite->children());
$mainSuite->run('nameOfTestMethod');
$anySuite->run();
$anySuite->run('anyTestMehod');
```



## Extend `Unitest`

(Write about extended classes.)



## Injections

(Write about injections.)



# API

## Construct

Parent case and script variables can be passed.

```php
$case = new Unitest($parent = null)
```

## Properties

#### child ($suite [, $suite2, ...])

Add one or more new child suites.

#### children ()

List child suites, or add new ones.

#### inject ($name, $value)

Add a new injected variable.

#### injections ([$name, $value])

List injected variables available for test methods, or add new ones.

#### parent ([$suite])

Get parent suite, or `null` if such does not exists. Sets a parent suite if such is provided.

#### prefix ()

Get test method prefix.

#### tests ()

List all test methods of this suite.



## Running tests

#### run ()

Run tests, some or all

#### runTest ($method)

Run an individual test method

#### scrape ()

Find tests in locations



## Assessing a test result

Protected methods (only available in extended classes).

#### assess ($value)

#### fails ($value)

#### passes ($value)

#### skips ($value)



## Assertions

#### should ($value [, $value2, ...])

Trueyness. Passes unless provided a falsey value.

#### shouldNot ($value [, $value2, ...])

Falseyness. Passes unless provided fails.

#### shouldBeEqual ($value [, $value2, ...])

Equality. Passes if passed zero or only one value.

#### shouldNotBeEqual ($value [, $value2, ...])

Non-equality. Fails if passed zero or only one value.

#### shouldBeOfClass ($className, $value [, $value2, ...])

Should be of a specific class. Fails if passed non-objects or no objects.

#### shouldExtendClass ($className)

Should be of any class that extends a specific class. Fails if passed non-objects or no objects.
