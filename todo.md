
# To do

- When scraping, arrange/inherit suites based on classes and not file structure

- No info on file paths or line numbers is stored. Locating failing tests could be difficult.
- Maybe it's best to create classes for a test result and/or a report.
- Suite event handlers, supported by `run()` and `runTest()`
	- `init()`
	- `beforeTest()`
	- `afterTest()`
	- `cleanup()`
	- Injections work
- `injection()`
	- consistent with `child`
- `eject()`
- Refactoring
	- Arranging suites seems pointless, since report is or could be created on class inheritance

## Report dashboard

- Separate page (static HTML)
- Runs tests via AJAX
- Passes spec path with POST
- Auto refresh
- knockout.js
- User settings visible in UI (spec path, poll duration)

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
