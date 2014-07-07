
# To do

- Test durations
- Non-associative array for tests report
- `eject()`
- Suite events, supported by `run()` and `runTest()`
	- `init()`
	- `beforeTest()`
	- `afterTest()`
	- `cleanup()`
	- Injections work

## Report dashboard

- Auto refresh
- Activity indicator
- User settings in UI
	- Poll duration
	- Filters
	- View type
- Better look

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
