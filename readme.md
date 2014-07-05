
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



# To do

- Only load class files if they have classes that extend Unitest
- Unitest objects could use an optional ID and/or file path that can be used in reports
- Maybe it's best to create classes for test result and report



# Instructions



## Using Unitest

Unitest is a one-class framework. First load the class file:

	include_once 'Unitest.php';

Then, instantiate a new suite by creating a Unitest object:

	$mainSuite = new Unitest();

Any Unitest object can contain both test methods and child suites.



## Writing tests

You write tests as methods (prefixed with `test`) to any class that extends the `Unitest` class. Example:

	class TestMath extends Unitest {

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

Unitest will look for all PHP files that contain Unitest-based classes, load them and create new Unitest objects under `$mainSuite`. To run all tests of your suite, call:

	$report = $mainSuite->run();

You can run only part of your tests as well:

	$ownTestReport = $mainSuite->run($mainSuite->ownTests());
	$childrensTestReport = $mainSuite->run($mainSuite->children());
	$arbitraryTestReport = $mainSuite->run('nameOfTestMethod');



# API

## Construct

Parent case and script variables can be passed.

	$case = new Unitest($parent = null)

## Getters

#### children ()

Child suites

#### parameters ()

Script variables available for test methods

#### ownTests ()

All test methods of this suite

#### parent ()

Parent suite

#### prefix ()

Test method prefix



## Public setters

#### setChild ()

Add a suite as a child of this suite

#### setParameter ($name, $value)

Add a parameter that can be passed to functions

#### setParent ($parentCase, $parentKnows = false)

Parent



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
