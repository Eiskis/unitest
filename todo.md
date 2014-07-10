
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
		- Test that injecting works in event hooks
		- Make sure injections are passed as clones (when self-injecting in suite `init()`)
		- Test all types, and with a dummy class object
		- Make sure all injection methods work
		- Make sure eject works
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
	- shouldBeIncluded
	- shouldBeAvailableClass
	- shouldBeAvailableClassMethod
	- shouldHave($obj, $property)

## Report dashboard

- Fix layout
- Auto refresh
- User settings in UI
	- Poll duration
	- Filters
	- View type
- Total test numbers in footer
