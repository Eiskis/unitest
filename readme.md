
# Unitest

Unitest is a one-class miniature unit testing framework for PHP. It's a great way to get started with unit testing - and do as much as makes sense for your project. For the major leagues, you should probably use [PHPUnit](http://phpunit.de/).

- [Bitbucket repo](https://bitbucket.org/Eiskis/unitest/)
- [Download](https://bitbucket.org/Eiskis/unitest/src/master/Unitest.php)

## Quick start

	// Init
	include_once 'Unitest.php';
	$suite = new Unitest();

	// Your code that needs testing
	include_once 'YourClass.php';

	// Test classes that extend Unitest (will be loaded into $suite)
	$suite->scrape('my-tests/');

	// Run tests and get a results array
	$results = $suite->run();



# Instructions



## Using Unitest

Unitest is a one-class framework. First load the class file:

	include_once 'Unitest.php';

Then, instantiate a new suite by creating a Unitest object:

	$mainSuite = new Unitest();

Any Unitest object can contain both test methods and child suites.



## Writing tests

You write tests as methods (prefixed with `test`) to any class that extends the `Unitest` class. Each test suite you write should have its own class. For example:

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



## Running tests

Since your tests come in classes, to run them you need to load the classes and instantiate them and run each one. Unitest can take care of all of this:

	$mainSuite->scrape('path/to/your/test/files/');

Unitest will:

- look for PHP files
- see if they contain definitions of classes that extend Unitest
- load any file with valid classes
- instantiate objects under `$mainSuite`

Now `$mainSuite` contains all suites you scraped for.

To run all tests of your suite, call:

	$report = $mainSuite->run();

You can run only part of your tests as well:

	$mainSuite->run($mainSuite->ownTests());
	$mainSuite->run($mainSuite->children());
	$mainSuite->run('nameOfTestMethod');
	$anySuite->run();
	$anySuite->run('anyTestMehod');



# API

## Construct

Parent case and script variables can be passed.

	$case = new Unitest($parent = null)

## Getters

#### children ()

Child suites

#### injections ()

Injected variables available for test methods

#### ownTests ()

All test methods of this suite

#### parent ()

Parent suite

#### prefix ()

Test method prefix



## Running tests

#### run ()

Run tests, some or all

#### runTest ($method)

Run an individual test method

#### scrape ()

Find tests in locations



## Assessing a test result

#### assess ($value)

#### failed ($value)

#### passed ($value)

#### skipped ($value)



## Reports

#### asNumbers ($report)

#### byStatus ($report, $key = '')



## Assertions

#### should ()

Truey

#### shouldBeEqual ()

Equality

#### shouldBeOfClass ($className)

Should be of a specific class. Fails if passed non-objects or no objects.

#### shouldExtendClass ($className)

Should be of any class that extends a specific class. Fails if passed non-objects or no objects.
