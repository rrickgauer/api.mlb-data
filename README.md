# mlb-api

Restful API for MLB data

**https://mlb.ryanrickgauer.com/api.mlb-data.php**

## Resources

* https://github.com/WebucatorTraining/lahman-baseball-mysql
* http://www.seanlahman.com/files/database/readme2017.txt


## Overview

Currently, there are 2 modules offered in the API:

1. **people**
2. **search**


The **people** module, is where you obtain all the available information related to a person. Specifically, you can find a player's batting stats, pitching stats, annual salary, seasonal appearances, and more.

The **search** module does exactly what it sounds like: *search* for a person. In order to retrieve any player data, you need to know the player's individual `playerID`. That is what the **search** module is for. You can search for a player by name, and it will return a list of `playerID`.


### People :smile:

Submodule | Syntax
--- | ---
All people :family_man_man_boy_boy: | **`/people{?page}`**
Biographical :man_health_worker:    | **`/people/{playerID}`**
Salary info :heavy_dollar_sign:     | **`/people/{playerID}/salaries{?total}    `**
Batting data :bat:                  | **`/people/{playerID}/batting{?total}`**
Pitching data :punch:               | **`/people/{playerID}/pitching{?total}`**
Appearances :clipboard:             | **`/people/{playerID}/appearances{?total}`**
Schools :school:                    | **`/people/{playerID}/schools`**


### Search :mag:

* To search the database by first and last name: **`/search?q=`**

## Complete Database Descriptions

You can read about the full list of tables [here](docs/tables.md)


