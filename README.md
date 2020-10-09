# mlb-api

Restful API for MLB data

## Resources

https://github.com/WebucatorTraining/lahman-baseball-mysql





<details><summary>allstarfull</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
yearID                         | smallint(6)                                       
gameNum                        | smallint(6)                                       
gameID                         | varchar(12)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
GP                             | smallint(6)                                       
startingPos                    | smallint(6)                                       



</details>



<details><summary>appearances</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
yearID                         | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
playerID                       | varchar(9)                                        
G_all                          | smallint(6)                                       
GS                             | smallint(6)                                       
G_batting                      | smallint(6)                                       
G_defense                      | smallint(6)                                       
G_p                            | smallint(6)                                       
G_c                            | smallint(6)                                       
G_1b                           | smallint(6)                                       
G_2b                           | smallint(6)                                       
G_3b                           | smallint(6)                                       
G_ss                           | smallint(6)                                       
G_lf                           | smallint(6)                                       
G_cf                           | smallint(6)                                       
G_rf                           | smallint(6)                                       
G_of                           | smallint(6)                                       
G_dh                           | smallint(6)                                       
G_ph                           | smallint(6)                                       
G_pr                           | smallint(6)                                       



</details>



<details><summary>awardsmanagers</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(10)                                       
awardID                        | varchar(75)                                       
yearID                         | smallint(6)                                       
lgID                           | char(2)                                           
tie                            | varchar(1)                                        
notes                          | varchar(100)                                      



</details>



<details><summary>awardsplayers</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
awardID                        | varchar(255)                                      
yearID                         | smallint(6)                                       
lgID                           | char(2)                                           
tie                            | varchar(1)                                        
notes                          | varchar(100)                                      



</details>



<details><summary>awardssharemanagers</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
awardID                        | varchar(25)                                       
yearID                         | smallint(6)                                       
lgID                           | char(2)                                           
playerID                       | varchar(10)                                       
pointsWon                      | smallint(6)                                       
pointsMax                      | smallint(6)                                       
votesFirst                     | smallint(6)                                       



</details>



<details><summary>awardsshareplayers</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
awardID                        | varchar(25)                                       
yearID                         | smallint(6)                                       
lgID                           | char(2)                                           
playerID                       | varchar(9)                                        
pointsWon                      | double                                            
pointsMax                      | smallint(6)                                       
votesFirst                     | double                                            



</details>



<details><summary>batting</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
yearID                         | smallint(6)                                       
stint                          | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
G                              | smallint(6)                                       
G_batting                      | smallint(6)                                       
AB                             | smallint(6)                                       
R                              | smallint(6)                                       
H                              | smallint(6)                                       
2B                             | smallint(6)                                       
3B                             | smallint(6)                                       
HR                             | smallint(6)                                       
RBI                            | smallint(6)                                       
SB                             | smallint(6)                                       
CS                             | smallint(6)                                       
BB                             | smallint(6)                                       
SO                             | smallint(6)                                       
IBB                            | smallint(6)                                       
HBP                            | smallint(6)                                       
SH                             | smallint(6)                                       
SF                             | smallint(6)                                       
GIDP                           | smallint(6)                                       



</details>



<details><summary>battingpost</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
yearID                         | smallint(6)                                       
round                          | varchar(10)                                       
playerID                       | varchar(9)                                        
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
G                              | smallint(6)                                       
AB                             | smallint(6)                                       
R                              | smallint(6)                                       
H                              | smallint(6)                                       
2B                             | smallint(6)                                       
3B                             | smallint(6)                                       
HR                             | smallint(6)                                       
RBI                            | smallint(6)                                       
SB                             | smallint(6)                                       
CS                             | smallint(6)                                       
BB                             | smallint(6)                                       
SO                             | smallint(6)                                       
IBB                            | smallint(6)                                       
HBP                            | smallint(6)                                       
SH                             | smallint(6)                                       
SF                             | smallint(6)                                       
GIDP                           | smallint(6)                                       



</details>



<details><summary>collegeplaying</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
schoolID                       | varchar(15)                                       
yearID                         | smallint(6)                                       



</details>



<details><summary>divisions</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
divID                          | char(2)                                           
lgID                           | char(2)                                           
division                       | varchar(50)                                       
active                         | char(1)                                           



</details>



<details><summary>fielding</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
yearID                         | smallint(6)                                       
stint                          | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
POS                            | varchar(2)                                        
G                              | smallint(6)                                       
GS                             | smallint(6)                                       
InnOuts                        | smallint(6)                                       
PO                             | smallint(6)                                       
A                              | smallint(6)                                       
E                              | smallint(6)                                       
DP                             | smallint(6)                                       
PB                             | smallint(6)                                       
WP                             | smallint(6)                                       
SB                             | smallint(6)                                       
CS                             | smallint(6)                                       
ZR                             | double                                            



</details>



<details><summary>fieldingof</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
yearID                         | smallint(6)                                       
stint                          | smallint(6)                                       
Glf                            | smallint(6)                                       
Gcf                            | smallint(6)                                       
Grf                            | smallint(6)                                       



</details>



<details><summary>fieldingofsplit</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
yearID                         | smallint(6)                                       
stint                          | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
POS                            | varchar(2)                                        
G                              | smallint(6)                                       
GS                             | smallint(6)                                       
InnOuts                        | smallint(6)                                       
PO                             | smallint(6)                                       
A                              | smallint(6)                                       
E                              | smallint(6)                                       
DP                             | smallint(6)                                       
PB                             | smallint(6)                                       
WP                             | smallint(6)                                       
SB                             | smallint(6)                                       
CS                             | smallint(6)                                       
ZR                             | double                                            



</details>



<details><summary>fieldingpost</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
yearID                         | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
round                          | varchar(10)                                       
POS                            | varchar(2)                                        
G                              | smallint(6)                                       
GS                             | smallint(6)                                       
InnOuts                        | smallint(6)                                       
PO                             | smallint(6)                                       
A                              | smallint(6)                                       
E                              | smallint(6)                                       
DP                             | smallint(6)                                       
TP                             | smallint(6)                                       
PB                             | smallint(6)                                       
SB                             | smallint(6)                                       
CS                             | smallint(6)                                       



</details>



<details><summary>halloffame</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(10)                                       
yearid                         | smallint(6)                                       
votedBy                        | varchar(64)                                       
ballots                        | smallint(6)                                       
needed                         | smallint(6)                                       
votes                          | smallint(6)                                       
inducted                       | varchar(1)                                        
category                       | varchar(20)                                       
needed_note                    | varchar(25)                                       



</details>



<details><summary>homegames</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
yearkey                        | int(11)                                           
leaguekey                      | char(2)                                           
teamkey                        | char(3)                                           
team_ID                        | int(11)                                           
parkkey                        | varchar(255)                                      
park_ID                        | int(11)                                           
spanfirst                      | varchar(255)                                      
spanlast                       | varchar(255)                                      
games                          | int(11)                                           
openings                       | int(11)                                           
attendance                     | int(11)                                           
spanfirst_date                 | date                                              
spanlast_date                  | date                                              



</details>



<details><summary>leagues</summary>


<br>
Field | Type
:--- | :---
lgID                           | char(2)                                           
league                         | varchar(50)                                       
active                         | char(1)                                           



</details>



<details><summary>managers</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(10)                                       
yearID                         | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
inseason                       | smallint(6)                                       
G                              | smallint(6)                                       
W                              | smallint(6)                                       
L                              | smallint(6)                                       
teamRank                       | smallint(6)                                       
plyrMgr                        | varchar(1)                                        



</details>



<details><summary>managershalf</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(10)                                       
yearID                         | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
inseason                       | smallint(6)                                       
half                           | smallint(6)                                       
G                              | smallint(6)                                       
W                              | smallint(6)                                       
L                              | smallint(6)                                       
teamRank                       | smallint(6)                                       



</details>



<details><summary>parks</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
parkalias                      | varchar(255)                                      
parkkey                        | varchar(255)                                      
parkname                       | varchar(255)                                      
city                           | varchar(255)                                      
state                          | varchar(255)                                      
country                        | varchar(255)                                      



</details>



<details><summary>people</summary>


<br>
Field | Type
:--- | :---
playerID                       | varchar(9)                                        
birthYear                      | int(11)                                           
birthMonth                     | int(11)                                           
birthDay                       | int(11)                                           
birthCountry                   | varchar(255)                                      
birthState                     | varchar(255)                                      
birthCity                      | varchar(255)                                      
deathYear                      | int(11)                                           
deathMonth                     | int(11)                                           
deathDay                       | int(11)                                           
deathCountry                   | varchar(255)                                      
deathState                     | varchar(255)                                      
deathCity                      | varchar(255)                                      
nameFirst                      | varchar(255)                                      
nameLast                       | varchar(255)                                      
nameGiven                      | varchar(255)                                      
weight                         | int(11)                                           
height                         | int(11)                                           
bats                           | varchar(255)                                      
throws                         | varchar(255)                                      
debut                          | varchar(255)                                      
finalGame                      | varchar(255)                                      
retroID                        | varchar(255)                                      
bbrefID                        | varchar(255)                                      
birth_date                     | date                                              
debut_date                     | date                                              
finalgame_date                 | date                                              
death_date                     | date                                              



</details>



<details><summary>pitching</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
yearID                         | smallint(6)                                       
stint                          | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
W                              | smallint(6)                                       
L                              | smallint(6)                                       
G                              | smallint(6)                                       
GS                             | smallint(6)                                       
CG                             | smallint(6)                                       
SHO                            | smallint(6)                                       
SV                             | smallint(6)                                       
IPouts                         | int(11)                                           
H                              | smallint(6)                                       
ER                             | smallint(6)                                       
HR                             | smallint(6)                                       
BB                             | smallint(6)                                       
SO                             | smallint(6)                                       
BAOpp                          | double                                            
ERA                            | double                                            
IBB                            | smallint(6)                                       
WP                             | smallint(6)                                       
HBP                            | smallint(6)                                       
BK                             | smallint(6)                                       
BFP                            | smallint(6)                                       
GF                             | smallint(6)                                       
R                              | smallint(6)                                       
SH                             | smallint(6)                                       
SF                             | smallint(6)                                       
GIDP                           | smallint(6)                                       



</details>



<details><summary>pitchingpost</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
playerID                       | varchar(9)                                        
yearID                         | smallint(6)                                       
round                          | varchar(10)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
W                              | smallint(6)                                       
L                              | smallint(6)                                       
G                              | smallint(6)                                       
GS                             | smallint(6)                                       
CG                             | smallint(6)                                       
SHO                            | smallint(6)                                       
SV                             | smallint(6)                                       
IPouts                         | int(11)                                           
H                              | smallint(6)                                       
ER                             | smallint(6)                                       
HR                             | smallint(6)                                       
BB                             | smallint(6)                                       
SO                             | smallint(6)                                       
BAOpp                          | double                                            
ERA                            | double                                            
IBB                            | smallint(6)                                       
WP                             | smallint(6)                                       
HBP                            | smallint(6)                                       
BK                             | smallint(6)                                       
BFP                            | smallint(6)                                       
GF                             | smallint(6)                                       
R                              | smallint(6)                                       
SH                             | smallint(6)                                       
SF                             | smallint(6)                                       
GIDP                           | smallint(6)                                       



</details>



<details><summary>salaries</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
yearID                         | smallint(6)                                       
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
lgID                           | char(2)                                           
playerID                       | varchar(9)                                        
salary                         | double                                            



</details>



<details><summary>schools</summary>


<br>
Field | Type
:--- | :---
schoolID                       | varchar(15)                                       
name_full                      | varchar(255)                                      
city                           | varchar(55)                                       
state                          | varchar(55)                                       
country                        | varchar(55)                                       



</details>



<details><summary>seriespost</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
yearID                         | smallint(6)                                       
round                          | varchar(5)                                        
teamIDwinner                   | varchar(3)                                        
lgIDwinner                     | varchar(2)                                        
team_IDwinner                  | int(11)                                           
teamIDloser                    | varchar(3)                                        
team_IDloser                   | int(11)                                           
lgIDloser                      | varchar(2)                                        
wins                           | smallint(6)                                       
losses                         | smallint(6)                                       
ties                           | smallint(6)                                       



</details>



<details><summary>teams</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
yearID                         | smallint(6)                                       
lgID                           | char(2)                                           
teamID                         | char(3)                                           
franchID                       | varchar(3)                                        
divID                          | char(1)                                           
div_ID                         | int(11)                                           
teamRank                       | smallint(6)                                       
G                              | smallint(6)                                       
Ghome                          | smallint(6)                                       
W                              | smallint(6)                                       
L                              | smallint(6)                                       
DivWin                         | varchar(1)                                        
WCWin                          | varchar(1)                                        
LgWin                          | varchar(1)                                        
WSWin                          | varchar(1)                                        
R                              | smallint(6)                                       
AB                             | smallint(6)                                       
H                              | smallint(6)                                       
2B                             | smallint(6)                                       
3B                             | smallint(6)                                       
HR                             | smallint(6)                                       
BB                             | smallint(6)                                       
SO                             | smallint(6)                                       
SB                             | smallint(6)                                       
CS                             | smallint(6)                                       
HBP                            | smallint(6)                                       
SF                             | smallint(6)                                       
RA                             | smallint(6)                                       
ER                             | smallint(6)                                       
ERA                            | double                                            
CG                             | smallint(6)                                       
SHO                            | smallint(6)                                       
SV                             | smallint(6)                                       
IPouts                         | int(11)                                           
HA                             | smallint(6)                                       
HRA                            | smallint(6)                                       
BBA                            | smallint(6)                                       
SOA                            | smallint(6)                                       
E                              | int(11)                                           
DP                             | int(11)                                           
FP                             | double                                            
name                           | varchar(50)                                       
park                           | varchar(255)                                      
attendance                     | int(11)                                           
BPF                            | int(11)                                           
PPF                            | int(11)                                           
teamIDBR                       | varchar(3)                                        
teamIDlahman45                 | varchar(3)                                        
teamIDretro                    | varchar(3)                                        



</details>



<details><summary>teamsfranchises</summary>


<br>
Field | Type
:--- | :---
franchID                       | varchar(3)                                        
franchName                     | varchar(50)                                       
active                         | char(1)                                           
NAassoc                        | varchar(3)                                        



</details>



<details><summary>teamshalf</summary>


<br>
Field | Type
:--- | :---
ID                             | int(11)                                           
yearID                         | smallint(6)                                       
lgID                           | char(2)                                           
teamID                         | char(3)                                           
team_ID                        | int(11)                                           
Half                           | varchar(1)                                        
divID                          | char(1)                                           
div_ID                         | int(11)                                           
DivWin                         | varchar(1)                                        
teamRank                       | smallint(6)                                       
G                              | smallint(6)                                       
W                              | smallint(6)                                       
L                              | smallint(6)                                       



</details>
