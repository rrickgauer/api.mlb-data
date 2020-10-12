# mlb-api

Restful API for MLB data

## Resources

* https://github.com/WebucatorTraining/lahman-baseball-mysql
* [Database field descriptions](https://github.com/chadwickbureau/baseballdatabank/blob/master/core/readme2014.txt)


http://www.seanlahman.com/files/database/readme2017.txt


## Tables




<details><summary>allstarfull</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>gameNum</b></td><td>smallint(6)</td></tr>
<tr><td><b>gameID</b></td><td>varchar(12)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>GP</b></td><td>smallint(6)</td></tr>
<tr><td><b>startingPos</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>appearances</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>G_all</b></td><td>smallint(6)</td></tr>
<tr><td><b>GS</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_batting</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_defense</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_p</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_c</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_1b</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_2b</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_3b</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_ss</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_lf</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_cf</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_rf</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_of</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_dh</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_ph</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_pr</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>awardsmanagers</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(10)</td></tr>
<tr><td><b>awardID</b></td><td>varchar(75)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>tie</b></td><td>varchar(1)</td></tr>
<tr><td><b>notes</b></td><td>varchar(100)</td></tr>

</tbody></table>



</details>



<details><summary>awardsplayers</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>awardID</b></td><td>varchar(255)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>tie</b></td><td>varchar(1)</td></tr>
<tr><td><b>notes</b></td><td>varchar(100)</td></tr>

</tbody></table>



</details>



<details><summary>awardssharemanagers</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>awardID</b></td><td>varchar(25)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(10)</td></tr>
<tr><td><b>pointsWon</b></td><td>smallint(6)</td></tr>
<tr><td><b>pointsMax</b></td><td>smallint(6)</td></tr>
<tr><td><b>votesFirst</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>awardsshareplayers</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>awardID</b></td><td>varchar(25)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>pointsWon</b></td><td>double</td></tr>
<tr><td><b>pointsMax</b></td><td>smallint(6)</td></tr>
<tr><td><b>votesFirst</b></td><td>double</td></tr>

</tbody></table>



</details>



<details><summary>batting</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>stint</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>G_batting</b></td><td>smallint(6)</td></tr>
<tr><td><b>AB</b></td><td>smallint(6)</td></tr>
<tr><td><b>R</b></td><td>smallint(6)</td></tr>
<tr><td><b>H</b></td><td>smallint(6)</td></tr>
<tr><td><b>2B</b></td><td>smallint(6)</td></tr>
<tr><td><b>3B</b></td><td>smallint(6)</td></tr>
<tr><td><b>HR</b></td><td>smallint(6)</td></tr>
<tr><td><b>RBI</b></td><td>smallint(6)</td></tr>
<tr><td><b>SB</b></td><td>smallint(6)</td></tr>
<tr><td><b>CS</b></td><td>smallint(6)</td></tr>
<tr><td><b>BB</b></td><td>smallint(6)</td></tr>
<tr><td><b>SO</b></td><td>smallint(6)</td></tr>
<tr><td><b>IBB</b></td><td>smallint(6)</td></tr>
<tr><td><b>HBP</b></td><td>smallint(6)</td></tr>
<tr><td><b>SH</b></td><td>smallint(6)</td></tr>
<tr><td><b>SF</b></td><td>smallint(6)</td></tr>
<tr><td><b>GIDP</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>battingpost</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>round</b></td><td>varchar(10)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>AB</b></td><td>smallint(6)</td></tr>
<tr><td><b>R</b></td><td>smallint(6)</td></tr>
<tr><td><b>H</b></td><td>smallint(6)</td></tr>
<tr><td><b>2B</b></td><td>smallint(6)</td></tr>
<tr><td><b>3B</b></td><td>smallint(6)</td></tr>
<tr><td><b>HR</b></td><td>smallint(6)</td></tr>
<tr><td><b>RBI</b></td><td>smallint(6)</td></tr>
<tr><td><b>SB</b></td><td>smallint(6)</td></tr>
<tr><td><b>CS</b></td><td>smallint(6)</td></tr>
<tr><td><b>BB</b></td><td>smallint(6)</td></tr>
<tr><td><b>SO</b></td><td>smallint(6)</td></tr>
<tr><td><b>IBB</b></td><td>smallint(6)</td></tr>
<tr><td><b>HBP</b></td><td>smallint(6)</td></tr>
<tr><td><b>SH</b></td><td>smallint(6)</td></tr>
<tr><td><b>SF</b></td><td>smallint(6)</td></tr>
<tr><td><b>GIDP</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>collegeplaying</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>schoolID</b></td><td>varchar(15)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>divisions</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>divID</b></td><td>char(2)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>division</b></td><td>varchar(50)</td></tr>
<tr><td><b>active</b></td><td>char(1)</td></tr>

</tbody></table>



</details>



<details><summary>fielding</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>stint</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>POS</b></td><td>varchar(2)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>GS</b></td><td>smallint(6)</td></tr>
<tr><td><b>InnOuts</b></td><td>smallint(6)</td></tr>
<tr><td><b>PO</b></td><td>smallint(6)</td></tr>
<tr><td><b>A</b></td><td>smallint(6)</td></tr>
<tr><td><b>E</b></td><td>smallint(6)</td></tr>
<tr><td><b>DP</b></td><td>smallint(6)</td></tr>
<tr><td><b>PB</b></td><td>smallint(6)</td></tr>
<tr><td><b>WP</b></td><td>smallint(6)</td></tr>
<tr><td><b>SB</b></td><td>smallint(6)</td></tr>
<tr><td><b>CS</b></td><td>smallint(6)</td></tr>
<tr><td><b>ZR</b></td><td>double</td></tr>

</tbody></table>



</details>



<details><summary>fieldingof</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>stint</b></td><td>smallint(6)</td></tr>
<tr><td><b>Glf</b></td><td>smallint(6)</td></tr>
<tr><td><b>Gcf</b></td><td>smallint(6)</td></tr>
<tr><td><b>Grf</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>fieldingofsplit</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>stint</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>POS</b></td><td>varchar(2)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>GS</b></td><td>smallint(6)</td></tr>
<tr><td><b>InnOuts</b></td><td>smallint(6)</td></tr>
<tr><td><b>PO</b></td><td>smallint(6)</td></tr>
<tr><td><b>A</b></td><td>smallint(6)</td></tr>
<tr><td><b>E</b></td><td>smallint(6)</td></tr>
<tr><td><b>DP</b></td><td>smallint(6)</td></tr>
<tr><td><b>PB</b></td><td>smallint(6)</td></tr>
<tr><td><b>WP</b></td><td>smallint(6)</td></tr>
<tr><td><b>SB</b></td><td>smallint(6)</td></tr>
<tr><td><b>CS</b></td><td>smallint(6)</td></tr>
<tr><td><b>ZR</b></td><td>double</td></tr>

</tbody></table>



</details>



<details><summary>fieldingpost</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>round</b></td><td>varchar(10)</td></tr>
<tr><td><b>POS</b></td><td>varchar(2)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>GS</b></td><td>smallint(6)</td></tr>
<tr><td><b>InnOuts</b></td><td>smallint(6)</td></tr>
<tr><td><b>PO</b></td><td>smallint(6)</td></tr>
<tr><td><b>A</b></td><td>smallint(6)</td></tr>
<tr><td><b>E</b></td><td>smallint(6)</td></tr>
<tr><td><b>DP</b></td><td>smallint(6)</td></tr>
<tr><td><b>TP</b></td><td>smallint(6)</td></tr>
<tr><td><b>PB</b></td><td>smallint(6)</td></tr>
<tr><td><b>SB</b></td><td>smallint(6)</td></tr>
<tr><td><b>CS</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>halloffame</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(10)</td></tr>
<tr><td><b>yearid</b></td><td>smallint(6)</td></tr>
<tr><td><b>votedBy</b></td><td>varchar(64)</td></tr>
<tr><td><b>ballots</b></td><td>smallint(6)</td></tr>
<tr><td><b>needed</b></td><td>smallint(6)</td></tr>
<tr><td><b>votes</b></td><td>smallint(6)</td></tr>
<tr><td><b>inducted</b></td><td>varchar(1)</td></tr>
<tr><td><b>category</b></td><td>varchar(20)</td></tr>
<tr><td><b>needed_note</b></td><td>varchar(25)</td></tr>

</tbody></table>



</details>



<details><summary>homegames</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>yearkey</b></td><td>int(11)</td></tr>
<tr><td><b>leaguekey</b></td><td>char(2)</td></tr>
<tr><td><b>teamkey</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>parkkey</b></td><td>varchar(255)</td></tr>
<tr><td><b>park_ID</b></td><td>int(11)</td></tr>
<tr><td><b>spanfirst</b></td><td>varchar(255)</td></tr>
<tr><td><b>spanlast</b></td><td>varchar(255)</td></tr>
<tr><td><b>games</b></td><td>int(11)</td></tr>
<tr><td><b>openings</b></td><td>int(11)</td></tr>
<tr><td><b>attendance</b></td><td>int(11)</td></tr>
<tr><td><b>spanfirst_date</b></td><td>date</td></tr>
<tr><td><b>spanlast_date</b></td><td>date</td></tr>

</tbody></table>



</details>



<details><summary>leagues</summary><br>

<table><tbody>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>league</b></td><td>varchar(50)</td></tr>
<tr><td><b>active</b></td><td>char(1)</td></tr>

</tbody></table>



</details>



<details><summary>managers</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(10)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>inseason</b></td><td>smallint(6)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>W</b></td><td>smallint(6)</td></tr>
<tr><td><b>L</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamRank</b></td><td>smallint(6)</td></tr>
<tr><td><b>plyrMgr</b></td><td>varchar(1)</td></tr>

</tbody></table>



</details>



<details><summary>managershalf</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(10)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>inseason</b></td><td>smallint(6)</td></tr>
<tr><td><b>half</b></td><td>smallint(6)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>W</b></td><td>smallint(6)</td></tr>
<tr><td><b>L</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamRank</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>parks</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>parkalias</b></td><td>varchar(255)</td></tr>
<tr><td><b>parkkey</b></td><td>varchar(255)</td></tr>
<tr><td><b>parkname</b></td><td>varchar(255)</td></tr>
<tr><td><b>city</b></td><td>varchar(255)</td></tr>
<tr><td><b>state</b></td><td>varchar(255)</td></tr>
<tr><td><b>country</b></td><td>varchar(255)</td></tr>

</tbody></table>



</details>



<details><summary>people</summary><br>

<table><tbody>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>birthYear</b></td><td>int(11)</td></tr>
<tr><td><b>birthMonth</b></td><td>int(11)</td></tr>
<tr><td><b>birthDay</b></td><td>int(11)</td></tr>
<tr><td><b>birthCountry</b></td><td>varchar(255)</td></tr>
<tr><td><b>birthState</b></td><td>varchar(255)</td></tr>
<tr><td><b>birthCity</b></td><td>varchar(255)</td></tr>
<tr><td><b>deathYear</b></td><td>int(11)</td></tr>
<tr><td><b>deathMonth</b></td><td>int(11)</td></tr>
<tr><td><b>deathDay</b></td><td>int(11)</td></tr>
<tr><td><b>deathCountry</b></td><td>varchar(255)</td></tr>
<tr><td><b>deathState</b></td><td>varchar(255)</td></tr>
<tr><td><b>deathCity</b></td><td>varchar(255)</td></tr>
<tr><td><b>nameFirst</b></td><td>varchar(255)</td></tr>
<tr><td><b>nameLast</b></td><td>varchar(255)</td></tr>
<tr><td><b>nameGiven</b></td><td>varchar(255)</td></tr>
<tr><td><b>weight</b></td><td>int(11)</td></tr>
<tr><td><b>height</b></td><td>int(11)</td></tr>
<tr><td><b>bats</b></td><td>varchar(255)</td></tr>
<tr><td><b>throws</b></td><td>varchar(255)</td></tr>
<tr><td><b>debut</b></td><td>varchar(255)</td></tr>
<tr><td><b>finalGame</b></td><td>varchar(255)</td></tr>
<tr><td><b>retroID</b></td><td>varchar(255)</td></tr>
<tr><td><b>bbrefID</b></td><td>varchar(255)</td></tr>
<tr><td><b>birth_date</b></td><td>date</td></tr>
<tr><td><b>debut_date</b></td><td>date</td></tr>
<tr><td><b>finalgame_date</b></td><td>date</td></tr>
<tr><td><b>death_date</b></td><td>date</td></tr>

</tbody></table>



</details>



<details><summary>pitching</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>stint</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>W</b></td><td>smallint(6)</td></tr>
<tr><td><b>L</b></td><td>smallint(6)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>GS</b></td><td>smallint(6)</td></tr>
<tr><td><b>CG</b></td><td>smallint(6)</td></tr>
<tr><td><b>SHO</b></td><td>smallint(6)</td></tr>
<tr><td><b>SV</b></td><td>smallint(6)</td></tr>
<tr><td><b>IPouts</b></td><td>int(11)</td></tr>
<tr><td><b>H</b></td><td>smallint(6)</td></tr>
<tr><td><b>ER</b></td><td>smallint(6)</td></tr>
<tr><td><b>HR</b></td><td>smallint(6)</td></tr>
<tr><td><b>BB</b></td><td>smallint(6)</td></tr>
<tr><td><b>SO</b></td><td>smallint(6)</td></tr>
<tr><td><b>BAOpp</b></td><td>double</td></tr>
<tr><td><b>ERA</b></td><td>double</td></tr>
<tr><td><b>IBB</b></td><td>smallint(6)</td></tr>
<tr><td><b>WP</b></td><td>smallint(6)</td></tr>
<tr><td><b>HBP</b></td><td>smallint(6)</td></tr>
<tr><td><b>BK</b></td><td>smallint(6)</td></tr>
<tr><td><b>BFP</b></td><td>smallint(6)</td></tr>
<tr><td><b>GF</b></td><td>smallint(6)</td></tr>
<tr><td><b>R</b></td><td>smallint(6)</td></tr>
<tr><td><b>SH</b></td><td>smallint(6)</td></tr>
<tr><td><b>SF</b></td><td>smallint(6)</td></tr>
<tr><td><b>GIDP</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>pitchingpost</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>round</b></td><td>varchar(10)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>W</b></td><td>smallint(6)</td></tr>
<tr><td><b>L</b></td><td>smallint(6)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>GS</b></td><td>smallint(6)</td></tr>
<tr><td><b>CG</b></td><td>smallint(6)</td></tr>
<tr><td><b>SHO</b></td><td>smallint(6)</td></tr>
<tr><td><b>SV</b></td><td>smallint(6)</td></tr>
<tr><td><b>IPouts</b></td><td>int(11)</td></tr>
<tr><td><b>H</b></td><td>smallint(6)</td></tr>
<tr><td><b>ER</b></td><td>smallint(6)</td></tr>
<tr><td><b>HR</b></td><td>smallint(6)</td></tr>
<tr><td><b>BB</b></td><td>smallint(6)</td></tr>
<tr><td><b>SO</b></td><td>smallint(6)</td></tr>
<tr><td><b>BAOpp</b></td><td>double</td></tr>
<tr><td><b>ERA</b></td><td>double</td></tr>
<tr><td><b>IBB</b></td><td>smallint(6)</td></tr>
<tr><td><b>WP</b></td><td>smallint(6)</td></tr>
<tr><td><b>HBP</b></td><td>smallint(6)</td></tr>
<tr><td><b>BK</b></td><td>smallint(6)</td></tr>
<tr><td><b>BFP</b></td><td>smallint(6)</td></tr>
<tr><td><b>GF</b></td><td>smallint(6)</td></tr>
<tr><td><b>R</b></td><td>smallint(6)</td></tr>
<tr><td><b>SH</b></td><td>smallint(6)</td></tr>
<tr><td><b>SF</b></td><td>smallint(6)</td></tr>
<tr><td><b>GIDP</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>salaries</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>playerID</b></td><td>varchar(9)</td></tr>
<tr><td><b>salary</b></td><td>double</td></tr>

</tbody></table>



</details>



<details><summary>schools</summary><br>

<table><tbody>
<tr><td><b>schoolID</b></td><td>varchar(15)</td></tr>
<tr><td><b>name_full</b></td><td>varchar(255)</td></tr>
<tr><td><b>city</b></td><td>varchar(55)</td></tr>
<tr><td><b>state</b></td><td>varchar(55)</td></tr>
<tr><td><b>country</b></td><td>varchar(55)</td></tr>

</tbody></table>



</details>



<details><summary>seriespost</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>round</b></td><td>varchar(5)</td></tr>
<tr><td><b>teamIDwinner</b></td><td>varchar(3)</td></tr>
<tr><td><b>lgIDwinner</b></td><td>varchar(2)</td></tr>
<tr><td><b>team_IDwinner</b></td><td>int(11)</td></tr>
<tr><td><b>teamIDloser</b></td><td>varchar(3)</td></tr>
<tr><td><b>team_IDloser</b></td><td>int(11)</td></tr>
<tr><td><b>lgIDloser</b></td><td>varchar(2)</td></tr>
<tr><td><b>wins</b></td><td>smallint(6)</td></tr>
<tr><td><b>losses</b></td><td>smallint(6)</td></tr>
<tr><td><b>ties</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>teams</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>franchID</b></td><td>varchar(3)</td></tr>
<tr><td><b>divID</b></td><td>char(1)</td></tr>
<tr><td><b>div_ID</b></td><td>int(11)</td></tr>
<tr><td><b>teamRank</b></td><td>smallint(6)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>Ghome</b></td><td>smallint(6)</td></tr>
<tr><td><b>W</b></td><td>smallint(6)</td></tr>
<tr><td><b>L</b></td><td>smallint(6)</td></tr>
<tr><td><b>DivWin</b></td><td>varchar(1)</td></tr>
<tr><td><b>WCWin</b></td><td>varchar(1)</td></tr>
<tr><td><b>LgWin</b></td><td>varchar(1)</td></tr>
<tr><td><b>WSWin</b></td><td>varchar(1)</td></tr>
<tr><td><b>R</b></td><td>smallint(6)</td></tr>
<tr><td><b>AB</b></td><td>smallint(6)</td></tr>
<tr><td><b>H</b></td><td>smallint(6)</td></tr>
<tr><td><b>2B</b></td><td>smallint(6)</td></tr>
<tr><td><b>3B</b></td><td>smallint(6)</td></tr>
<tr><td><b>HR</b></td><td>smallint(6)</td></tr>
<tr><td><b>BB</b></td><td>smallint(6)</td></tr>
<tr><td><b>SO</b></td><td>smallint(6)</td></tr>
<tr><td><b>SB</b></td><td>smallint(6)</td></tr>
<tr><td><b>CS</b></td><td>smallint(6)</td></tr>
<tr><td><b>HBP</b></td><td>smallint(6)</td></tr>
<tr><td><b>SF</b></td><td>smallint(6)</td></tr>
<tr><td><b>RA</b></td><td>smallint(6)</td></tr>
<tr><td><b>ER</b></td><td>smallint(6)</td></tr>
<tr><td><b>ERA</b></td><td>double</td></tr>
<tr><td><b>CG</b></td><td>smallint(6)</td></tr>
<tr><td><b>SHO</b></td><td>smallint(6)</td></tr>
<tr><td><b>SV</b></td><td>smallint(6)</td></tr>
<tr><td><b>IPouts</b></td><td>int(11)</td></tr>
<tr><td><b>HA</b></td><td>smallint(6)</td></tr>
<tr><td><b>HRA</b></td><td>smallint(6)</td></tr>
<tr><td><b>BBA</b></td><td>smallint(6)</td></tr>
<tr><td><b>SOA</b></td><td>smallint(6)</td></tr>
<tr><td><b>E</b></td><td>int(11)</td></tr>
<tr><td><b>DP</b></td><td>int(11)</td></tr>
<tr><td><b>FP</b></td><td>double</td></tr>
<tr><td><b>name</b></td><td>varchar(50)</td></tr>
<tr><td><b>park</b></td><td>varchar(255)</td></tr>
<tr><td><b>attendance</b></td><td>int(11)</td></tr>
<tr><td><b>BPF</b></td><td>int(11)</td></tr>
<tr><td><b>PPF</b></td><td>int(11)</td></tr>
<tr><td><b>teamIDBR</b></td><td>varchar(3)</td></tr>
<tr><td><b>teamIDlahman45</b></td><td>varchar(3)</td></tr>
<tr><td><b>teamIDretro</b></td><td>varchar(3)</td></tr>

</tbody></table>



</details>



<details><summary>teamsfranchises</summary><br>

<table><tbody>
<tr><td><b>franchID</b></td><td>varchar(3)</td></tr>
<tr><td><b>franchName</b></td><td>varchar(50)</td></tr>
<tr><td><b>active</b></td><td>char(1)</td></tr>
<tr><td><b>NAassoc</b></td><td>varchar(3)</td></tr>

</tbody></table>



</details>



<details><summary>teamshalf</summary><br>

<table><tbody>
<tr><td><b>ID</b></td><td>int(11)</td></tr>
<tr><td><b>yearID</b></td><td>smallint(6)</td></tr>
<tr><td><b>lgID</b></td><td>char(2)</td></tr>
<tr><td><b>teamID</b></td><td>char(3)</td></tr>
<tr><td><b>team_ID</b></td><td>int(11)</td></tr>
<tr><td><b>Half</b></td><td>varchar(1)</td></tr>
<tr><td><b>divID</b></td><td>char(1)</td></tr>
<tr><td><b>div_ID</b></td><td>int(11)</td></tr>
<tr><td><b>DivWin</b></td><td>varchar(1)</td></tr>
<tr><td><b>teamRank</b></td><td>smallint(6)</td></tr>
<tr><td><b>G</b></td><td>smallint(6)</td></tr>
<tr><td><b>W</b></td><td>smallint(6)</td></tr>
<tr><td><b>L</b></td><td>smallint(6)</td></tr>

</tbody></table>



</details>
