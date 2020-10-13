# mlb-api

Restful API for MLB data

`api.mlb-data.php/`

## Resources

* https://github.com/WebucatorTraining/lahman-baseball-mysql
* http://www.seanlahman.com/files/database/readme2017.txt


## Documentation

You can read about the full list of tables [here](docs/tables.md)


The base URL is `api.mlb-data.php`. As of now, there is one module: **people**.

### People

Submodule | Result
:--- | :---
`/people/` | All people in the database
`/people/{playerID}` | biographical
`/people/{playerID}/salaries` | salary info
`/people/{playerID}/batting` | batting stats
`/people/{playerID}/pitching` | pitching stats
`/people/{playerID}/appearances` | appearances
`/people/{playerID}/schools` | schools attended

