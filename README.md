# api.mlb-data

Restful API for historical MLB data.


## Overview

* The root url for the API is **`https://api.mlb-data.ryanrickgauer.com/main.php`**
* All of the data used in the database was obtained [here](https://github.com/WebucatorTraining/lahman-baseball-mysql)
* Demo page coming soon!


## Modules

There are 14 modules (endpoints/resources) available:

1. **Appearances** &mdash;      `/appearances{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **Batting** &mdash;          `/batting{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **BattingPost** &mdash;      `/batting-post{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **Colleges** &mdash;         `/colleges{/playerID}{?sort,filter,page,perPage}`
1. **Fielding** &mdash;         `/fielding{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **FieldingOF** &mdash;       `/fielding-of{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **FieldingOFSplit** &mdash;  `/fielding-of-split{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **FieldingPost** &mdash;     `/fielding-post{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **Images** &mdash;           `/images{/playerID}{?sort,filter,page,perPage}`
1. **People** &mdash;           `/people{/playerID}{?sort,filter,page,perPage}`
1. **Pitching** &mdash;         `/pitching{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **PitchingPost** &mdash;     `/pitching-post{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **Salaries** &mdash;         `/salaries{/playerID}{?sort,filter,aggregate,page,perPage}`
1. **Search** &mdash;           `/search?q={query,page,perPage}`

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

### Page

If the requested dataset returned is greater than the amount specified in `perPage`, then the remaining results will be available on the next page. 

All results return 2 items:
1. `pagination`
1. `results`

The pagination items are the links for you to access all the rows in your requested dataset. 

### Aggregates

The default data returned in the modules is seasonal. For instance, if you look at the batting data of Barry Bonds, the data returned is the batting stats season by season. If you want the data fields to be the sum of each field for the player's entire career, you can use the `aggregate` flag. 

To get the aggregate results: `/module{/playerID}?aggregate=true`

## Examples

To see some real examples of how to use the API, checkout the [examples page](docs/examples.md).