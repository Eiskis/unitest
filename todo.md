
# To do

- Test durations
- xUnit-compliance
- `eject()`
- Suite events, supported by `run()` and `runTest()`
	- `init()`
	- `beforeTest()`
	- `afterTest()`
	- `cleanup()`
	- Injections work
- Test injections with self-injecting suite (use `init()`)
	- make sure injections are passed as clones
	- test all types, and with a dummy class object
- `->clone()`
- Private constants
	- Prefix
	- Root class name
	- Status names
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

- Better layout (top bar)
- Auto refresh
- Activity indicator
- User settings in UI
	- Poll duration
	- Filters
	- View type
- Total test numbers in footer

## Report format

Remove `stats` and `digest`. Report should always look like this:

	{
		"stats": {
			"total": 12,
			"failed": 1,
			"skipped": 1,
			"passed": 10
		},
		"suites": [
			{
				"class": "UnitestPlus",
				"parents": [
					"UnitestOperators",
					"UnitestMath",
					"Unitest"
				],
				"stats": {
					"total": 12,
					"failed": 1,
					"skipped": 1,
					"passed": 10
				},
				"tests": [
					{
						"method": "testOnePlusOneIsTwo"
						"injections": []
						"status": "passed"
						"message": true
					},
					{
						"method": "testOnePlusOneIsThree"
						"injections": []
						"status": "failed"
						"message": false
					}
				]
			}
		]
	}
