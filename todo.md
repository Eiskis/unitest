
# To do

- Clear duplication in method/property assertions
- method tests fail on object
- xUnit-compliance
- Maybe use helpers as static methods
- Maybe prefix all internal private methods with underscores? The `Unitest` class is designed to be extended.
- `->clone()`
- Test coverage
	- Event hook methods
		- Test that they're run at the right time
		- Test that test-specific methods fail all tests
	- Injections
		- Make sure injections are passed as clones (when self-injecting in suite `init()`)
		- Test all types, and with a dummy class object
		- Test inherited injections
- shoulds
	- types
		- object
		- array
		- indexed array (queue)
		- assoc array (hash)
		- integer
		- float
		- string
		- boolean
	- `shouldBeIncluded($file)`
	- `shouldHaveMethod($subjectClassOrObject, $method)`
		- `shouldHaveStaticMethod($subjectClassOrObject, $method)`
	- `shouldHaveProperty($subjectClassOrObject, $property)`
		- `shouldHaveStaticProperty($subjectClassOrObject, $property)`



## Testing protected/private methods and properties

- [http://php.net/manual/en/reflectionmethod.setaccessible.php]()
- [http://php.net/manual/en/reflectionproperty.setaccessible.php]()

> If you're using PHP5 (>= 5.3.2) with PHPUnit, you can test your private and protected methods by using reflection to set them to be public prior to running your tests:

	protected static function getMethod($name) {
	  $class = new ReflectionClass('MyClass');
	  $method = $class->getMethod($name);
	  $method->setAccessible(true);
	  return $method;
	}

	public function testFoo() {
	  $foo = self::getMethod('foo');
	  $obj = new MyClass();
	  $foo->invokeArgs($obj, array(...));
	  ...
	}

## Report dashboard

- Fix layout
- Auto refresh
- User settings in UI
	- Poll duration
	- Filters
	- View type
- Total test numbers in footer
