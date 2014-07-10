
# To do

- xUnit-compliance
- Maybe use helpers as static methods
- `->clone()`
- Clean up injections that are created in test methods
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

	- shouldBeFile($file)
	- shouldBeDirectory($file)

	- shouldBeIncluded($file)

	- shouldBeAvailableClass

	- shouldHaveMethod($property, $objOrClass)
	- shouldHaveProperty($property, $objOrClass)

## Report dashboard

- Fix layout
- Auto refresh
- User settings in UI
	- Poll duration
	- Filters
	- View type
- Total test numbers in footer
