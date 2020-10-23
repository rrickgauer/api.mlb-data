# api.mlb-data

Restful API for historical MLB data.


## Overview

* The root url for the API is **`https://api.mlb-data.ryanrickgauer.com/main.php`**
* All of the data used in the database was obtained [here](https://github.com/WebucatorTraining/lahman-baseball-mysql)
* Demo page coming soon!


## Modules

There are 9 modules (endpoints/resources) available:

Module | Description | Relative Link
--- | --- | ---
Appearances | Details on the positions a player appeared at | `/appearances{/playerID}{?sort,filter,aggregate,perPage}`
Batting | Batting statistics | `/batting{/playerID}{?sort,filter,aggregate,perPage}`
Fielding | Fielding statistics | `/fielding{/playerID}{?sort,filter,aggregate,perPage}`
FieldingOF | Outfield position data | `/fielding-of{/playerID}{?sort,filter,aggregate,perPage}`
FieldingOFSplit | LF/CF/RF splits | `/fielding-of-split{/playerID}{?sort,filter,aggregate,perPage}`
People | Player names, DOB, and biographical info | `/people{/playerID}{?sort,filter,perPage}` 
Pitching | Pitching statistics  | `/pitching{/playerID}{?sort,filter,aggregate,perPage}`
Salaries | Player salary data | `/salaries{/playerID}{?sort,filter,aggregate,perPage}`
Search | Search for a player via text query | `/search?q={query}`

You can read about the result fields returned in each module [here](docs/tables.md).

### playerID

All of the modules, *except Search* allow for you to send in a **playerID**. This will return that module's data for that player only. 

This can be done by doing this: `/module/playerID`

### Sorting

Besides the playerID, you can also specify 1 sort column: `/module?sort=columnName:(asc,desc)`. You can sort by any of the returned fields in ascending or descending order. 

* `/module/columnName:asc` - sort results by `columnName` ascending
* `/module/columnName:desc` - sort results by `columnName` descending

*Note:* Currently, the API only allows for 1 sort option. I plan on adding multiple sorting in the next release.

### Filtering

The API allows for filtering via: `/module?filter=columnName:conditional:qualifier`. 

* `columnName` is the data field found in the results
* `conditional` is one of the accepted filter conditionals:
  * __=__
  * __!=__
  * __>=__
  * __<=__
  * __>__
  * __<__
* `qualifier` is the value that you want the data field to be compared againt

To achieve multiple filters, just seperate them out by commas: `/module?filter=columnName:conditional:qualifier,columnName2:conditional2:qualifier2`

### Per Page

You can specify the number of records to return by setting the `perPage` option. Currently, the default is 100, and the maximum is 1000.

### Aggregates

The default data returned in the modules is seasonal. For instance, if you look at the batting data of Barry Bonds, the data returned is the batting stats season by season. If you want the data fields to be the sum of each field for the player's entire career, you can use the `aggregate` flag. 

To get the aggregate results: `/module{/playerID}?aggregate=true`

## Examples

To see some real examples of how to use the API, checkout the [examples page](docs/examples.md).


