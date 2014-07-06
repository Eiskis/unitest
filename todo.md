
# To do

- When scraping, arrange/inherit suites based on classes and not file structure

- No info on file paths or line numbers is stored. Locating failing tests could be difficult.
- Maybe it's best to create classes for a test result and/or a report.

## Report format:

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
