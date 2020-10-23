# Examples


:baseball: **Top 5 career HR leaders:** [/batting?aggregate=true&sort=HR:desc&perPage=5](https://api.mlb-data.ryanrickgauer.com/main.php/batting?aggregate=true&sort=HR:desc&perPage=5)

<details><summary>Click to view results</summary>

```json
[
    {
        "playerID": "bondsba01",
        "nameFirst": "Barry",
        "nameLast": "Bonds",
        "years": 22,
        "G": 2986,
        "G_batting": null,
        "AB": 9847,
        "R": 2227,
        "H": 2935,
        "2B": 601,
        "3B": 77,
        "HR": 762,
        "RBI": 1996,
        "SB": 514,
        "CS": 141,
        "BB": 2558,
        "SO": 1539,
        "IBB": 688,
        "HBP": 106,
        "SH": 4,
        "SF": 91,
        "GIDP": 165
    },
    {
        "playerID": "aaronha01",
        "nameFirst": "Hank",
        "nameLast": "Aaron",
        "years": 23,
        "G": 3298,
        "G_batting": null,
        "AB": 12364,
        "R": 2174,
        "H": 3771,
        "2B": 624,
        "3B": 98,
        "HR": 755,
        "RBI": 2297,
        "SB": 240,
        "CS": 73,
        "BB": 1402,
        "SO": 1383,
        "IBB": 293,
        "HBP": 32,
        "SH": 21,
        "SF": 121,
        "GIDP": 328
    },
    {
        "playerID": "ruthba01",
        "nameFirst": "Babe",
        "nameLast": "Ruth",
        "years": 22,
        "G": 2503,
        "G_batting": null,
        "AB": 8398,
        "R": 2174,
        "H": 2873,
        "2B": 506,
        "3B": 136,
        "HR": 714,
        "RBI": 2217,
        "SB": 123,
        "CS": 117,
        "BB": 2062,
        "SO": 1330,
        "IBB": null,
        "HBP": 43,
        "SH": 113,
        "SF": null,
        "GIDP": 2
    },
    {
        "playerID": "rodrial01",
        "nameFirst": "Alex",
        "nameLast": "Rodriguez",
        "years": 22,
        "G": 2784,
        "G_batting": null,
        "AB": 10566,
        "R": 2021,
        "H": 3115,
        "2B": 548,
        "3B": 31,
        "HR": 696,
        "RBI": 2086,
        "SB": 329,
        "CS": 76,
        "BB": 1338,
        "SO": 2287,
        "IBB": 97,
        "HBP": 176,
        "SH": 16,
        "SF": 111,
        "GIDP": 261
    },
    {
        "playerID": "mayswi01",
        "nameFirst": "Willie",
        "nameLast": "Mays",
        "years": 22,
        "G": 2992,
        "G_batting": null,
        "AB": 10881,
        "R": 2062,
        "H": 3283,
        "2B": 523,
        "3B": 140,
        "HR": 660,
        "RBI": 1903,
        "SB": 338,
        "CS": 103,
        "BB": 1464,
        "SO": 1526,
        "IBB": 192,
        "HBP": 44,
        "SH": 13,
        "SF": 91,
        "GIDP": 251
    }
]
```

</details>


---

:baseball: **Ryne Sandberg's fielding stats in 1983:** [/fielding/sandbry01?filter=yearID:=:1983](https://api.mlb-data.ryanrickgauer.com/main.php/fielding/sandbry01?filter=yearID:=:1983)


<details><summary>Click to view results</summary>

```json
[
    {
        "playerID": "sandbry01",
        "nameFirst": "Ryne",
        "nameLast": "Sandberg",
        "yearID": 1983,
        "stint": 1,
        "teamID": "CHN",
        "team_ID": 1871,
        "teamName": "Chicago Cubs",
        "lgID": "NL",
        "POS": "2B",
        "G": 157,
        "GS": 153,
        "InnOuts": 4045,
        "PO": 330,
        "A": 571,
        "E": 13,
        "DP": 126,
        "PB": null,
        "WP": null,
        "SB": null,
        "CS": null,
        "ZR": null
    },
    {
        "playerID": "sandbry01",
        "nameFirst": "Ryne",
        "nameLast": "Sandberg",
        "yearID": 1983,
        "stint": 1,
        "teamID": "CHN",
        "team_ID": 1871,
        "teamName": "Chicago Cubs",
        "lgID": "NL",
        "POS": "SS",
        "G": 1,
        "GS": 0,
        "InnOuts": 3,
        "PO": 0,
        "A": 1,
        "E": 0,
        "DP": 0,
        "PB": null,
        "WP": null,
        "SB": null,
        "CS": null,
        "ZR": null
    }
]
```


</details>


---

:baseball: **Top 3 hitters in 1985:** [/batting?sort=H:desc&perPage=3&filter=yearID:=:1985](https://api.mlb-data.ryanrickgauer.com/main.php/batting?sort=H:desc&perPage=3&filter=yearID:=:1985)


<details><summary>Click to view results</summary>

```json
[
    {
        "playerID": "boggswa01",
        "nameFirst": "Wade",
        "nameLast": "Boggs",
        "yearID": 1985,
        "stint": 1,
        "teamID": "BOS",
        "team_ID": 1920,
        "lgID": "AL",
        "G": 161,
        "G_batting": null,
        "AB": 653,
        "R": 107,
        "H": 240,
        "2B": 42,
        "3B": 3,
        "HR": 8,
        "RBI": 78,
        "SB": 2,
        "CS": 1,
        "BB": 96,
        "SO": 61,
        "IBB": 5,
        "HBP": 4,
        "SH": 3,
        "SF": 2,
        "GIDP": 20
    },
    {
        "playerID": "mcgeewi01",
        "nameFirst": "Willie",
        "nameLast": "McGee",
        "yearID": 1985,
        "stint": 1,
        "teamID": "SLN",
        "team_ID": 1941,
        "lgID": "NL",
        "G": 152,
        "G_batting": null,
        "AB": 612,
        "R": 114,
        "H": 216,
        "2B": 26,
        "3B": 18,
        "HR": 10,
        "RBI": 82,
        "SB": 56,
        "CS": 16,
        "BB": 34,
        "SO": 86,
        "IBB": 2,
        "HBP": 0,
        "SH": 1,
        "SF": 5,
        "GIDP": 3
    },
    {
        "playerID": "mattido01",
        "nameFirst": "Don",
        "nameLast": "Mattingly",
        "yearID": 1985,
        "stint": 1,
        "teamID": "NYA",
        "team_ID": 1933,
        "lgID": "AL",
        "G": 159,
        "G_batting": null,
        "AB": 652,
        "R": 107,
        "H": 211,
        "2B": 48,
        "3B": 3,
        "HR": 35,
        "RBI": 145,
        "SB": 2,
        "CS": 2,
        "BB": 56,
        "SO": 41,
        "IBB": 13,
        "HBP": 2,
        "SH": 2,
        "SF": 15,
        "GIDP": 15
    }
]
```

</details>


---

:baseball: **The year Jon Lester had the most strikeouts:** [/pitching/lestejo01?sort=SO:desc&perPage=1](https://api.mlb-data.ryanrickgauer.com/main.php)


<details><summary>Click to view results</summary>


```json
[
    {
        "playerID": "lestejo01",
        "nameFirst": "Jon",
        "nameLast": "Lester",
        "year": 2009,
        "stint": 1,
        "team_ID": 2599,
        "teamName": "Boston Red Sox",
        "lgID": "AL",
        "W": 15,
        "L": 8,
        "G": 32,
        "GS": 32,
        "CG": 2,
        "SHO": 0,
        "SV": 0,
        "IPouts": 610,
        "H": 186,
        "ER": 77,
        "HR": 20,
        "BB": 64,
        "SO": 225,
        "BAOpp": 0.242,
        "ERA": 3.41,
        "IBB": 0,
        "WP": 6,
        "HBP": 3,
        "BK": 0,
        "BFP": 843,
        "GF": 0,
        "R": 80,
        "SH": 2,
        "SF": 6,
        "GIDP": 14
    }
]
```


</details>


