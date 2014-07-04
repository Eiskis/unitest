
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



## API

### Construct

Parent case and script variables can be passed.

	$case = new Unitest($parent = null)

### Properties

#### children

Child cases.

	$case->children()

#### parent

Parent case.

	$case->parent()

#### parameters

Script variables that will be passed to test methods that ask for them.

	$case->parameters()

### Dynamic getters

#### ownTests

All test methods.

	$case->ownTests()



### Managing cases

#### scrape

Find PHP files with classes under <code>$directory</code>. Multiple paths can be passed.

	$case->scrape($directory)

#### addChild

Add a valid child test case as a child.

	$case->addChild($case)



### Running tests

#### runTest

Run an individual test method.

	$case->runTest($method)

#### runOwnTests

Run all own tests.

	$case->runOwnTests()

#### runChildrensOwnTests

Run tests of all children.

	$case->runChildrensOwnTests()



### Assertions

#### assert

Truey.

	$case->assert()

#### assertEquals

Equality.

	$case->assertEquals()
