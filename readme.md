
# Unitest

Unitest is a one-class miniature unit testing framework for PHP. It's a great way to get started with unit testing - and do as much as makes sense for your project. For the major leagues, you should probably use [PHPUnit](http://phpunit.de/).

## Resources

- [Bitbucket repo](https://bitbucket.org/Eiskis/unitest/)
- [Download](https://bitbucket.org/Eiskis/unitest/src/master/Unitest.php)

## Kickstart

	// Init
	include_once 'Unitest.php';
	$suite = new Unitest();

	// Your code that needs testing
	include_once 'YourClass.php';

	// Test classes that extend Unitest (will be loaded into $suite)
	$suite->scrape('my-tests/');

	// Run tests and get a results array
	$results = $suite->run();



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
