# mlb-api

Restful API for MLB data

**https://mlb.ryanrickgauer.com/api.mlb-data.php**

## Resources

* https://github.com/WebucatorTraining/lahman-baseball-mysql
* http://www.seanlahman.com/files/database/readme2017.txt


## Documentation

You can read about the full list of tables [here](docs/tables.md)


### Modules

As of now, there is one module: **people**.

#### People

Submodule | Result
:--- | :---
`/people{?page}` | All people in the database
`/people/{playerID}` | biographical
`/people/{playerID}/salaries` | salary info
`/people/{playerID}/batting` | batting stats
`/people/{playerID}/pitching` | pitching stats
`/people/{playerID}/appearances` | appearances
`/people/{playerID}/schools` | schools attended


#### Search

Submodule | Result
:--- | :---
`/search?q=` | Search the database


## Examples


**To get the biographical data on Kris Bryant: [/people/bryankr01](https://mlb.ryanrickgauer.com/api.mlb-data.php/people/bryankr01)**



<details><summary>Click to view results</summary>


```json
{
    "playerID": "bryankr01",
    "birthCountry": "USA",
    "birthState": "NV",
    "birthCity": "Las Vegas",
    "deathState": null,
    "deathCity": null,
    "nameFirst": "Kris",
    "nameLast": "Bryant",
    "nameGiven": "Kristopher Lee",
    "weight": "230",
    "height": "77",
    "bats": "R",
    "throws": "R",
    "retroID": "bryak001",
    "bbrefID": "bryankr01",
    "birthDate": "1992-01-04",
    "debutDate": "2015-04-17",
    "finalGameDate": "2019-09-22",
    "deathDate": null
}
```


</details>


---


**To get salary data of Javier Baez: [/people/baezja01/salaries](https://mlb.ryanrickgauer.com/api.mlb-data.php/people/baezja01/salaries)**


<details><summary>Click to view results</summary>



```json
{
  "year": "2016",
  "salary": "512000"
}
```


</details>


---


**To get the batting data for Sammy Sosa: [/people/sosasa01/batting](https://mlb.ryanrickgauer.com/api.mlb-data.php/people/sosasa01/batting)**


<details><summary>Click to view results</summary>


```json

[
    {
        "ID": "67267",
        "playerID": "sosasa01",
        "yearID": "1989",
        "stint": "1",
        "teamID": "TEX",
        "team_ID": "2046",
        "lgID": "AL",
        "G": "25",
        "G_batting": null,
        "AB": "84",
        "R": "8",
        "H": "20",
        "2B": "3",
        "3B": "0",
        "HR": "1",
        "RBI": "3",
        "SB": "0",
        "CS": "2",
        "BB": "0",
        "SO": "20",
        "IBB": "0",
        "HBP": "0",
        "SH": "4",
        "SF": "0",
        "GIDP": "3"
    },
    {
        "ID": "67268",
        "playerID": "sosasa01",
        "yearID": "1989",
        "stint": "2",
        "teamID": "CHA",
        "team_ID": "2026",
        "lgID": "AL",
        "G": "33",
        "G_batting": null,
        "AB": "99",
        "R": "19",
        "H": "27",
        "2B": "5",
        "3B": "0",
        "HR": "3",
        "RBI": "10",
        "SB": "7",
        "CS": "3",
        "BB": "11",
        "SO": "27",
        "IBB": "2",
        "HBP": "2",
        "SH": "1",
        "SF": "2",
        "GIDP": "3"
    },
    {
        "ID": "68385",
        "playerID": "sosasa01",
        "yearID": "1990",
        "stint": "1",
        "teamID": "CHA",
        "team_ID": "2052",
        "lgID": "AL",
        "G": "153",
        "G_batting": null,
        "AB": "532",
        "R": "72",
        "H": "124",
        "2B": "26",
        "3B": "10",
        "HR": "15",
        "RBI": "70",
        "SB": "32",
        "CS": "16",
        "BB": "33",
        "SO": "150",
        "IBB": "4",
        "HBP": "6",
        "SH": "2",
        "SF": "6",
        "GIDP": "10"
    },
    {
        "ID": "69475",
        "playerID": "sosasa01",
        "yearID": "1991",
        "stint": "1",
        "teamID": "CHA",
        "team_ID": "2078",
        "lgID": "AL",
        "G": "116",
        "G_batting": null,
        "AB": "316",
        "R": "39",
        "H": "64",
        "2B": "10",
        "3B": "1",
        "HR": "10",
        "RBI": "33",
        "SB": "13",
        "CS": "6",
        "BB": "14",
        "SO": "98",
        "IBB": "2",
        "HBP": "2",
        "SH": "5",
        "SF": "1",
        "GIDP": "5"
    },
    {
        "ID": "70538",
        "playerID": "sosasa01",
        "yearID": "1992",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2105",
        "lgID": "NL",
        "G": "67",
        "G_batting": null,
        "AB": "262",
        "R": "41",
        "H": "68",
        "2B": "7",
        "3B": "2",
        "HR": "8",
        "RBI": "25",
        "SB": "15",
        "CS": "7",
        "BB": "19",
        "SO": "63",
        "IBB": "1",
        "HBP": "4",
        "SH": "4",
        "SF": "2",
        "GIDP": "4"
    },
    {
        "ID": "71696",
        "playerID": "sosasa01",
        "yearID": "1993",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2131",
        "lgID": "NL",
        "G": "159",
        "G_batting": null,
        "AB": "598",
        "R": "92",
        "H": "156",
        "2B": "25",
        "3B": "5",
        "HR": "33",
        "RBI": "93",
        "SB": "36",
        "CS": "11",
        "BB": "38",
        "SO": "135",
        "IBB": "6",
        "HBP": "4",
        "SH": "0",
        "SF": "1",
        "GIDP": "14"
    },
    {
        "ID": "72747",
        "playerID": "sosasa01",
        "yearID": "1994",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2159",
        "lgID": "NL",
        "G": "105",
        "G_batting": null,
        "AB": "426",
        "R": "59",
        "H": "128",
        "2B": "17",
        "3B": "6",
        "HR": "25",
        "RBI": "70",
        "SB": "22",
        "CS": "13",
        "BB": "25",
        "SO": "92",
        "IBB": "1",
        "HBP": "2",
        "SH": "1",
        "SF": "4",
        "GIDP": "7"
    },
    {
        "ID": "73961",
        "playerID": "sosasa01",
        "yearID": "1995",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2187",
        "lgID": "NL",
        "G": "144",
        "G_batting": null,
        "AB": "564",
        "R": "89",
        "H": "151",
        "2B": "17",
        "3B": "3",
        "HR": "36",
        "RBI": "119",
        "SB": "34",
        "CS": "7",
        "BB": "58",
        "SO": "134",
        "IBB": "11",
        "HBP": "5",
        "SH": "0",
        "SF": "2",
        "GIDP": "8"
    },
    {
        "ID": "75213",
        "playerID": "sosasa01",
        "yearID": "1996",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2215",
        "lgID": "NL",
        "G": "124",
        "G_batting": null,
        "AB": "498",
        "R": "84",
        "H": "136",
        "2B": "21",
        "3B": "2",
        "HR": "40",
        "RBI": "100",
        "SB": "18",
        "CS": "5",
        "BB": "34",
        "SO": "134",
        "IBB": "6",
        "HBP": "5",
        "SH": "0",
        "SF": "4",
        "GIDP": "14"
    },
    {
        "ID": "76457",
        "playerID": "sosasa01",
        "yearID": "1997",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2243",
        "lgID": "NL",
        "G": "162",
        "G_batting": null,
        "AB": "642",
        "R": "90",
        "H": "161",
        "2B": "31",
        "3B": "4",
        "HR": "36",
        "RBI": "119",
        "SB": "22",
        "CS": "12",
        "BB": "45",
        "SO": "174",
        "IBB": "9",
        "HBP": "2",
        "SH": "0",
        "SF": "5",
        "GIDP": "16"
    },
    {
        "ID": "77753",
        "playerID": "sosasa01",
        "yearID": "1998",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2272",
        "lgID": "NL",
        "G": "159",
        "G_batting": null,
        "AB": "643",
        "R": "134",
        "H": "198",
        "2B": "20",
        "3B": "0",
        "HR": "66",
        "RBI": "158",
        "SB": "18",
        "CS": "9",
        "BB": "73",
        "SO": "171",
        "IBB": "14",
        "HBP": "1",
        "SH": "0",
        "SF": "5",
        "GIDP": "20"
    },
    {
        "ID": "79070",
        "playerID": "sosasa01",
        "yearID": "1999",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2302",
        "lgID": "NL",
        "G": "162",
        "G_batting": null,
        "AB": "625",
        "R": "114",
        "H": "180",
        "2B": "24",
        "3B": "2",
        "HR": "63",
        "RBI": "141",
        "SB": "7",
        "CS": "8",
        "BB": "78",
        "SO": "171",
        "IBB": "8",
        "HBP": "3",
        "SH": "0",
        "SF": "6",
        "GIDP": "17"
    },
    {
        "ID": "80419",
        "playerID": "sosasa01",
        "yearID": "2000",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2332",
        "lgID": "NL",
        "G": "156",
        "G_batting": null,
        "AB": "604",
        "R": "106",
        "H": "193",
        "2B": "38",
        "3B": "1",
        "HR": "50",
        "RBI": "138",
        "SB": "7",
        "CS": "4",
        "BB": "91",
        "SO": "168",
        "IBB": "19",
        "HBP": "2",
        "SH": "0",
        "SF": "8",
        "GIDP": "12"
    },
    {
        "ID": "81787",
        "playerID": "sosasa01",
        "yearID": "2001",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2362",
        "lgID": "NL",
        "G": "160",
        "G_batting": null,
        "AB": "577",
        "R": "146",
        "H": "189",
        "2B": "34",
        "3B": "5",
        "HR": "64",
        "RBI": "160",
        "SB": "0",
        "CS": "2",
        "BB": "116",
        "SO": "153",
        "IBB": "37",
        "HBP": "6",
        "SH": "0",
        "SF": "12",
        "GIDP": "6"
    },
    {
        "ID": "83113",
        "playerID": "sosasa01",
        "yearID": "2002",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2392",
        "lgID": "NL",
        "G": "150",
        "G_batting": null,
        "AB": "556",
        "R": "122",
        "H": "160",
        "2B": "19",
        "3B": "2",
        "HR": "49",
        "RBI": "108",
        "SB": "2",
        "CS": "0",
        "BB": "103",
        "SO": "144",
        "IBB": "15",
        "HBP": "3",
        "SH": "0",
        "SF": "4",
        "GIDP": "14"
    },
    {
        "ID": "84441",
        "playerID": "sosasa01",
        "yearID": "2003",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2422",
        "lgID": "NL",
        "G": "137",
        "G_batting": null,
        "AB": "517",
        "R": "99",
        "H": "144",
        "2B": "22",
        "3B": "0",
        "HR": "40",
        "RBI": "103",
        "SB": "0",
        "CS": "1",
        "BB": "62",
        "SO": "143",
        "IBB": "9",
        "HBP": "5",
        "SH": "0",
        "SF": "5",
        "GIDP": "14"
    },
    {
        "ID": "85806",
        "playerID": "sosasa01",
        "yearID": "2004",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2452",
        "lgID": "NL",
        "G": "126",
        "G_batting": null,
        "AB": "478",
        "R": "69",
        "H": "121",
        "2B": "21",
        "3B": "0",
        "HR": "35",
        "RBI": "80",
        "SB": "0",
        "CS": "0",
        "BB": "56",
        "SO": "133",
        "IBB": "4",
        "HBP": "2",
        "SH": "0",
        "SF": "3",
        "GIDP": "9"
    },
    {
        "ID": "87125",
        "playerID": "sosasa01",
        "yearID": "2005",
        "stint": "1",
        "teamID": "BAL",
        "team_ID": "2478",
        "lgID": "AL",
        "G": "102",
        "G_batting": null,
        "AB": "380",
        "R": "39",
        "H": "84",
        "2B": "15",
        "3B": "1",
        "HR": "14",
        "RBI": "45",
        "SB": "1",
        "CS": "1",
        "BB": "39",
        "SO": "84",
        "IBB": "3",
        "HBP": "2",
        "SH": "0",
        "SF": "3",
        "GIDP": "15"
    },
    {
        "ID": "89888",
        "playerID": "sosasa01",
        "yearID": "2007",
        "stint": "1",
        "teamID": "TEX",
        "team_ID": "2563",
        "lgID": "AL",
        "G": "114",
        "G_batting": null,
        "AB": "412",
        "R": "53",
        "H": "104",
        "2B": "24",
        "3B": "1",
        "HR": "21",
        "RBI": "92",
        "SB": "0",
        "CS": "0",
        "BB": "34",
        "SO": "112",
        "IBB": "3",
        "HBP": "3",
        "SH": "0",
        "SF": "5",
        "GIDP": "11"
    }
]

```



</details>



---


**To get the pitching for Kyle Hendricks: [/people/hendrky01/pitching](https://mlb.ryanrickgauer.com/api.mlb-data.php/people/hendrky01/pitching)**



<details><summary>Click to view results</summary>


```json
[
    {
        "ID": "42883",
        "playerID": "hendrky01",
        "yearID": "2014",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2751",
        "lgID": "NL",
        "W": "7",
        "L": "2",
        "G": "13",
        "GS": "13",
        "CG": "0",
        "SHO": "0",
        "SV": "0",
        "IPouts": "241",
        "H": "72",
        "ER": "22",
        "HR": "4",
        "BB": "15",
        "SO": "47",
        "BAOpp": "0.242",
        "ERA": "2.46",
        "IBB": "2",
        "WP": "0",
        "HBP": "4",
        "BK": "0",
        "BFP": "321",
        "GF": "0",
        "R": "24",
        "SH": "4",
        "SF": "1",
        "GIDP": "11"
    },
    {
        "ID": "43661",
        "playerID": "hendrky01",
        "yearID": "2015",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2781",
        "lgID": "NL",
        "W": "8",
        "L": "7",
        "G": "32",
        "GS": "32",
        "CG": "1",
        "SHO": "1",
        "SV": "0",
        "IPouts": "540",
        "H": "166",
        "ER": "79",
        "HR": "17",
        "BB": "43",
        "SO": "167",
        "BAOpp": "0.244",
        "ERA": "3.95",
        "IBB": "1",
        "WP": "3",
        "HBP": "8",
        "BK": "1",
        "BFP": "739",
        "GF": "0",
        "R": "82",
        "SH": "6",
        "SF": "0",
        "GIDP": "15"
    },
    {
        "ID": "44465",
        "playerID": "hendrky01",
        "yearID": "2016",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2811",
        "lgID": "NL",
        "W": "16",
        "L": "8",
        "G": "31",
        "GS": "30",
        "CG": "2",
        "SHO": "1",
        "SV": "0",
        "IPouts": "570",
        "H": "142",
        "ER": "45",
        "HR": "15",
        "BB": "44",
        "SO": "170",
        "BAOpp": "0.207",
        "ERA": "2.13",
        "IBB": "3",
        "WP": "5",
        "HBP": "8",
        "BK": "0",
        "BFP": "745",
        "GF": "0",
        "R": "53",
        "SH": "4",
        "SF": "3",
        "GIDP": "12"
    },
    {
        "ID": "45302",
        "playerID": "hendrky01",
        "yearID": "2017",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2841",
        "lgID": "NL",
        "W": "7",
        "L": "5",
        "G": "24",
        "GS": "24",
        "CG": "0",
        "SHO": "0",
        "SV": "0",
        "IPouts": "419",
        "H": "126",
        "ER": "47",
        "HR": "17",
        "BB": "40",
        "SO": "123",
        "BAOpp": "0.242",
        "ERA": "3.03",
        "IBB": "1",
        "WP": "0",
        "HBP": "2",
        "BK": "0",
        "BFP": "570",
        "GF": "0",
        "R": "49",
        "SH": "6",
        "SF": "1",
        "GIDP": "11"
    },
    {
        "ID": "46173",
        "playerID": "hendrky01",
        "yearID": "2018",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2871",
        "lgID": "NL",
        "W": "14",
        "L": "11",
        "G": "33",
        "GS": "33",
        "CG": "0",
        "SHO": "0",
        "SV": "0",
        "IPouts": "597",
        "H": "184",
        "ER": "76",
        "HR": "22",
        "BB": "44",
        "SO": "161",
        "BAOpp": "0.247",
        "ERA": "3.44",
        "IBB": "4",
        "WP": "0",
        "HBP": "9",
        "BK": "0",
        "BFP": "812",
        "GF": "0",
        "R": "82",
        "SH": "7",
        "SF": "7",
        "GIDP": "18"
    },
    {
        "ID": "47070",
        "playerID": "hendrky01",
        "yearID": "2019",
        "stint": "1",
        "teamID": "CHN",
        "team_ID": "2901",
        "lgID": "NL",
        "W": "11",
        "L": "10",
        "G": "30",
        "GS": "30",
        "CG": "1",
        "SHO": "1",
        "SV": "0",
        "IPouts": "531",
        "H": "168",
        "ER": "68",
        "HR": "19",
        "BB": "32",
        "SO": "150",
        "BAOpp": "0.249",
        "ERA": "3.46",
        "IBB": "1",
        "WP": "1",
        "HBP": "9",
        "BK": "0",
        "BFP": "730",
        "GF": "0",
        "R": "78",
        "SH": "8",
        "SF": "5",
        "GIDP": "6"
    }
]
```



</details>


---

**To get Nolan Arenado appearances: [/people/arenano01/appearances](https://mlb.ryanrickgauer.com/api.mlb-data.php/people/arenano01/appearances)**


<details><summary>Click to view results</summary>


```json
[
    {
        "playerid": "arenano01",
        "namefirst": "Nolan",
        "namelast": "Arenado",
        "namegiven": "Nolan James",
        "weight": 215,
        "height": 74,
        "bats": "R",
        "throws": "R",
        "debut_date": "2013-04-28",
        "finalgame_date": "2019-09-27",
        "birth_date": "1991-04-16",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "CA",
        "birthcity": "Newport Beach"
    },
    {
        "playerid": "fontano01",
        "namefirst": "Nolan",
        "namelast": "Fontana",
        "namegiven": "Nolan David",
        "weight": 195,
        "height": 71,
        "bats": "L",
        "throws": "R",
        "debut_date": "2017-05-22",
        "finalgame_date": "2018-06-15",
        "birth_date": "1991-06-06",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "FL",
        "birthcity": "Winter Garden"
    },
    {
        "playerid": "nolanga01",
        "namefirst": "Gary",
        "namelast": "Nolan",
        "namegiven": "Gary Lynn",
        "weight": 197,
        "height": 74,
        "bats": "R",
        "throws": "R",
        "debut_date": "1967-04-15",
        "finalgame_date": "1977-09-18",
        "birth_date": "1948-05-27",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "CA",
        "birthcity": "Herlong"
    },
    {
        "playerid": "nolanjo01",
        "namefirst": "Joe",
        "namelast": "Nolan",
        "namegiven": "Joseph William",
        "weight": 175,
        "height": 71,
        "bats": "L",
        "throws": "R",
        "debut_date": "1972-09-21",
        "finalgame_date": "1985-06-25",
        "birth_date": "1951-05-12",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "MO",
        "birthcity": "St. Louis"
    },
    {
        "playerid": "nolanth01",
        "namefirst": "The Only",
        "namelast": "Nolan",
        "namegiven": "Edward Sylvester",
        "weight": 171,
        "height": 68,
        "bats": "L",
        "throws": "R",
        "debut_date": "1878-05-01",
        "finalgame_date": "1885-10-09",
        "birth_date": "1855-11-07",
        "death_date": "1913-05-18",
        "birthcountry": "CAN",
        "birthstate": "ON",
        "birthcity": "Trenton"
    },
    {
        "playerid": "reimono01",
        "namefirst": "Nolan",
        "namelast": "Reimold",
        "namegiven": "Nolan G.",
        "weight": 205,
        "height": 76,
        "bats": "R",
        "throws": "R",
        "debut_date": "2009-05-14",
        "finalgame_date": "2016-10-01",
        "birth_date": "1983-10-12",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "PA",
        "birthcity": "Greenville"
    },
    {
        "playerid": "ryanno01",
        "namefirst": "Nolan",
        "namelast": "Ryan",
        "namegiven": "Lynn Nolan",
        "weight": 170,
        "height": 74,
        "bats": "R",
        "throws": "R",
        "debut_date": "1966-09-11",
        "finalgame_date": "1993-09-22",
        "birth_date": "1947-01-31",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "TX",
        "birthcity": "Refugio"
    }
]
```


</details>



---

**To search for a player named *Jeter*: [/search?q=jeter](https://mlb.ryanrickgauer.com/api.mlb-data.php/search?q=jeter)**


<details><summary>Click to view results</summary>


```json
[
    {
        "playerid": "jeterde01",
        "namefirst": "Derek",
        "namelast": "Jeter",
        "namegiven": "Derek Sanderson",
        "weight": 195,
        "height": 75,
        "bats": "R",
        "throws": "R",
        "debut_date": "1995-05-29",
        "finalgame_date": "2014-09-28",
        "birth_date": "1974-06-26",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "NJ",
        "birthcity": "Pequannock"
    },
    {
        "playerid": "jeterjo01",
        "namefirst": "Johnny",
        "namelast": "Jeter",
        "namegiven": "John",
        "weight": 180,
        "height": 73,
        "bats": "R",
        "throws": "R",
        "debut_date": "1969-06-14",
        "finalgame_date": "1974-09-14",
        "birth_date": "1944-10-24",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "LA",
        "birthcity": "Shreveport"
    },
    {
        "playerid": "jetersh01",
        "namefirst": "Shawn",
        "namelast": "Jeter",
        "namegiven": "Shawn Darrell",
        "weight": 185,
        "height": 74,
        "bats": "L",
        "throws": "R",
        "debut_date": "1992-06-13",
        "finalgame_date": "1992-10-04",
        "birth_date": "1966-06-28",
        "death_date": null,
        "birthcountry": "USA",
        "birthstate": "LA",
        "birthcity": "Shreveport"
    }
]
```


</details>