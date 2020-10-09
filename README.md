# mlb-api

Restful API for MLB data

## Resources

https://github.com/WebucatorTraining/lahman-baseball-mysql


## Tables




<details><summary>allstarfull</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>gameNum</td><td>smallint(6)</td></tr>
<tr><td>gameID</td><td>varchar(12)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>GP</td><td>smallint(6)</td></tr>
<tr><td>startingPos</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>appearances</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>G_all</td><td>smallint(6)</td></tr>
<tr><td>GS</td><td>smallint(6)</td></tr>
<tr><td>G_batting</td><td>smallint(6)</td></tr>
<tr><td>G_defense</td><td>smallint(6)</td></tr>
<tr><td>G_p</td><td>smallint(6)</td></tr>
<tr><td>G_c</td><td>smallint(6)</td></tr>
<tr><td>G_1b</td><td>smallint(6)</td></tr>
<tr><td>G_2b</td><td>smallint(6)</td></tr>
<tr><td>G_3b</td><td>smallint(6)</td></tr>
<tr><td>G_ss</td><td>smallint(6)</td></tr>
<tr><td>G_lf</td><td>smallint(6)</td></tr>
<tr><td>G_cf</td><td>smallint(6)</td></tr>
<tr><td>G_rf</td><td>smallint(6)</td></tr>
<tr><td>G_of</td><td>smallint(6)</td></tr>
<tr><td>G_dh</td><td>smallint(6)</td></tr>
<tr><td>G_ph</td><td>smallint(6)</td></tr>
<tr><td>G_pr</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>awardsmanagers</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(10)</td></tr>
<tr><td>awardID</td><td>varchar(75)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>tie</td><td>varchar(1)</td></tr>
<tr><td>notes</td><td>varchar(100)</td></tr>

</tbody></table>



</details>



<details><summary>awardsplayers</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>awardID</td><td>varchar(255)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>tie</td><td>varchar(1)</td></tr>
<tr><td>notes</td><td>varchar(100)</td></tr>

</tbody></table>



</details>



<details><summary>awardssharemanagers</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>awardID</td><td>varchar(25)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>playerID</td><td>varchar(10)</td></tr>
<tr><td>pointsWon</td><td>smallint(6)</td></tr>
<tr><td>pointsMax</td><td>smallint(6)</td></tr>
<tr><td>votesFirst</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>awardsshareplayers</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>awardID</td><td>varchar(25)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>pointsWon</td><td>double</td></tr>
<tr><td>pointsMax</td><td>smallint(6)</td></tr>
<tr><td>votesFirst</td><td>double</td></tr>

</tbody></table>



</details>



<details><summary>batting</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>stint</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>G_batting</td><td>smallint(6)</td></tr>
<tr><td>AB</td><td>smallint(6)</td></tr>
<tr><td>R</td><td>smallint(6)</td></tr>
<tr><td>H</td><td>smallint(6)</td></tr>
<tr><td>2B</td><td>smallint(6)</td></tr>
<tr><td>3B</td><td>smallint(6)</td></tr>
<tr><td>HR</td><td>smallint(6)</td></tr>
<tr><td>RBI</td><td>smallint(6)</td></tr>
<tr><td>SB</td><td>smallint(6)</td></tr>
<tr><td>CS</td><td>smallint(6)</td></tr>
<tr><td>BB</td><td>smallint(6)</td></tr>
<tr><td>SO</td><td>smallint(6)</td></tr>
<tr><td>IBB</td><td>smallint(6)</td></tr>
<tr><td>HBP</td><td>smallint(6)</td></tr>
<tr><td>SH</td><td>smallint(6)</td></tr>
<tr><td>SF</td><td>smallint(6)</td></tr>
<tr><td>GIDP</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>battingpost</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>round</td><td>varchar(10)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>AB</td><td>smallint(6)</td></tr>
<tr><td>R</td><td>smallint(6)</td></tr>
<tr><td>H</td><td>smallint(6)</td></tr>
<tr><td>2B</td><td>smallint(6)</td></tr>
<tr><td>3B</td><td>smallint(6)</td></tr>
<tr><td>HR</td><td>smallint(6)</td></tr>
<tr><td>RBI</td><td>smallint(6)</td></tr>
<tr><td>SB</td><td>smallint(6)</td></tr>
<tr><td>CS</td><td>smallint(6)</td></tr>
<tr><td>BB</td><td>smallint(6)</td></tr>
<tr><td>SO</td><td>smallint(6)</td></tr>
<tr><td>IBB</td><td>smallint(6)</td></tr>
<tr><td>HBP</td><td>smallint(6)</td></tr>
<tr><td>SH</td><td>smallint(6)</td></tr>
<tr><td>SF</td><td>smallint(6)</td></tr>
<tr><td>GIDP</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>collegeplaying</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>schoolID</td><td>varchar(15)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>divisions</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>divID</td><td>char(2)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>division</td><td>varchar(50)</td></tr>
<tr><td>active</td><td>char(1)</td></tr>

</tbody></table>



</details>



<details><summary>fielding</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>stint</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>POS</td><td>varchar(2)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>GS</td><td>smallint(6)</td></tr>
<tr><td>InnOuts</td><td>smallint(6)</td></tr>
<tr><td>PO</td><td>smallint(6)</td></tr>
<tr><td>A</td><td>smallint(6)</td></tr>
<tr><td>E</td><td>smallint(6)</td></tr>
<tr><td>DP</td><td>smallint(6)</td></tr>
<tr><td>PB</td><td>smallint(6)</td></tr>
<tr><td>WP</td><td>smallint(6)</td></tr>
<tr><td>SB</td><td>smallint(6)</td></tr>
<tr><td>CS</td><td>smallint(6)</td></tr>
<tr><td>ZR</td><td>double</td></tr>

</tbody></table>



</details>



<details><summary>fieldingof</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>stint</td><td>smallint(6)</td></tr>
<tr><td>Glf</td><td>smallint(6)</td></tr>
<tr><td>Gcf</td><td>smallint(6)</td></tr>
<tr><td>Grf</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>fieldingofsplit</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>stint</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>POS</td><td>varchar(2)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>GS</td><td>smallint(6)</td></tr>
<tr><td>InnOuts</td><td>smallint(6)</td></tr>
<tr><td>PO</td><td>smallint(6)</td></tr>
<tr><td>A</td><td>smallint(6)</td></tr>
<tr><td>E</td><td>smallint(6)</td></tr>
<tr><td>DP</td><td>smallint(6)</td></tr>
<tr><td>PB</td><td>smallint(6)</td></tr>
<tr><td>WP</td><td>smallint(6)</td></tr>
<tr><td>SB</td><td>smallint(6)</td></tr>
<tr><td>CS</td><td>smallint(6)</td></tr>
<tr><td>ZR</td><td>double</td></tr>

</tbody></table>



</details>



<details><summary>fieldingpost</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>round</td><td>varchar(10)</td></tr>
<tr><td>POS</td><td>varchar(2)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>GS</td><td>smallint(6)</td></tr>
<tr><td>InnOuts</td><td>smallint(6)</td></tr>
<tr><td>PO</td><td>smallint(6)</td></tr>
<tr><td>A</td><td>smallint(6)</td></tr>
<tr><td>E</td><td>smallint(6)</td></tr>
<tr><td>DP</td><td>smallint(6)</td></tr>
<tr><td>TP</td><td>smallint(6)</td></tr>
<tr><td>PB</td><td>smallint(6)</td></tr>
<tr><td>SB</td><td>smallint(6)</td></tr>
<tr><td>CS</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>halloffame</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(10)</td></tr>
<tr><td>yearid</td><td>smallint(6)</td></tr>
<tr><td>votedBy</td><td>varchar(64)</td></tr>
<tr><td>ballots</td><td>smallint(6)</td></tr>
<tr><td>needed</td><td>smallint(6)</td></tr>
<tr><td>votes</td><td>smallint(6)</td></tr>
<tr><td>inducted</td><td>varchar(1)</td></tr>
<tr><td>category</td><td>varchar(20)</td></tr>
<tr><td>needed_note</td><td>varchar(25)</td></tr>

</tbody></table>



</details>



<details><summary>homegames</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>yearkey</td><td>int(11)</td></tr>
<tr><td>leaguekey</td><td>char(2)</td></tr>
<tr><td>teamkey</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>parkkey</td><td>varchar(255)</td></tr>
<tr><td>park_ID</td><td>int(11)</td></tr>
<tr><td>spanfirst</td><td>varchar(255)</td></tr>
<tr><td>spanlast</td><td>varchar(255)</td></tr>
<tr><td>games</td><td>int(11)</td></tr>
<tr><td>openings</td><td>int(11)</td></tr>
<tr><td>attendance</td><td>int(11)</td></tr>
<tr><td>spanfirst_date</td><td>date</td></tr>
<tr><td>spanlast_date</td><td>date</td></tr>

</tbody></table>



</details>



<details><summary>leagues</summary><br>

<table><tbody>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>league</td><td>varchar(50)</td></tr>
<tr><td>active</td><td>char(1)</td></tr>

</tbody></table>



</details>



<details><summary>managers</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(10)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>inseason</td><td>smallint(6)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>W</td><td>smallint(6)</td></tr>
<tr><td>L</td><td>smallint(6)</td></tr>
<tr><td>teamRank</td><td>smallint(6)</td></tr>
<tr><td>plyrMgr</td><td>varchar(1)</td></tr>

</tbody></table>



</details>



<details><summary>managershalf</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(10)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>inseason</td><td>smallint(6)</td></tr>
<tr><td>half</td><td>smallint(6)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>W</td><td>smallint(6)</td></tr>
<tr><td>L</td><td>smallint(6)</td></tr>
<tr><td>teamRank</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>parks</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>parkalias</td><td>varchar(255)</td></tr>
<tr><td>parkkey</td><td>varchar(255)</td></tr>
<tr><td>parkname</td><td>varchar(255)</td></tr>
<tr><td>city</td><td>varchar(255)</td></tr>
<tr><td>state</td><td>varchar(255)</td></tr>
<tr><td>country</td><td>varchar(255)</td></tr>

</tbody></table>



</details>



<details><summary>people</summary><br>

<table><tbody>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>birthYear</td><td>int(11)</td></tr>
<tr><td>birthMonth</td><td>int(11)</td></tr>
<tr><td>birthDay</td><td>int(11)</td></tr>
<tr><td>birthCountry</td><td>varchar(255)</td></tr>
<tr><td>birthState</td><td>varchar(255)</td></tr>
<tr><td>birthCity</td><td>varchar(255)</td></tr>
<tr><td>deathYear</td><td>int(11)</td></tr>
<tr><td>deathMonth</td><td>int(11)</td></tr>
<tr><td>deathDay</td><td>int(11)</td></tr>
<tr><td>deathCountry</td><td>varchar(255)</td></tr>
<tr><td>deathState</td><td>varchar(255)</td></tr>
<tr><td>deathCity</td><td>varchar(255)</td></tr>
<tr><td>nameFirst</td><td>varchar(255)</td></tr>
<tr><td>nameLast</td><td>varchar(255)</td></tr>
<tr><td>nameGiven</td><td>varchar(255)</td></tr>
<tr><td>weight</td><td>int(11)</td></tr>
<tr><td>height</td><td>int(11)</td></tr>
<tr><td>bats</td><td>varchar(255)</td></tr>
<tr><td>throws</td><td>varchar(255)</td></tr>
<tr><td>debut</td><td>varchar(255)</td></tr>
<tr><td>finalGame</td><td>varchar(255)</td></tr>
<tr><td>retroID</td><td>varchar(255)</td></tr>
<tr><td>bbrefID</td><td>varchar(255)</td></tr>
<tr><td>birth_date</td><td>date</td></tr>
<tr><td>debut_date</td><td>date</td></tr>
<tr><td>finalgame_date</td><td>date</td></tr>
<tr><td>death_date</td><td>date</td></tr>

</tbody></table>



</details>



<details><summary>pitching</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>stint</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>W</td><td>smallint(6)</td></tr>
<tr><td>L</td><td>smallint(6)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>GS</td><td>smallint(6)</td></tr>
<tr><td>CG</td><td>smallint(6)</td></tr>
<tr><td>SHO</td><td>smallint(6)</td></tr>
<tr><td>SV</td><td>smallint(6)</td></tr>
<tr><td>IPouts</td><td>int(11)</td></tr>
<tr><td>H</td><td>smallint(6)</td></tr>
<tr><td>ER</td><td>smallint(6)</td></tr>
<tr><td>HR</td><td>smallint(6)</td></tr>
<tr><td>BB</td><td>smallint(6)</td></tr>
<tr><td>SO</td><td>smallint(6)</td></tr>
<tr><td>BAOpp</td><td>double</td></tr>
<tr><td>ERA</td><td>double</td></tr>
<tr><td>IBB</td><td>smallint(6)</td></tr>
<tr><td>WP</td><td>smallint(6)</td></tr>
<tr><td>HBP</td><td>smallint(6)</td></tr>
<tr><td>BK</td><td>smallint(6)</td></tr>
<tr><td>BFP</td><td>smallint(6)</td></tr>
<tr><td>GF</td><td>smallint(6)</td></tr>
<tr><td>R</td><td>smallint(6)</td></tr>
<tr><td>SH</td><td>smallint(6)</td></tr>
<tr><td>SF</td><td>smallint(6)</td></tr>
<tr><td>GIDP</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>pitchingpost</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>round</td><td>varchar(10)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>W</td><td>smallint(6)</td></tr>
<tr><td>L</td><td>smallint(6)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>GS</td><td>smallint(6)</td></tr>
<tr><td>CG</td><td>smallint(6)</td></tr>
<tr><td>SHO</td><td>smallint(6)</td></tr>
<tr><td>SV</td><td>smallint(6)</td></tr>
<tr><td>IPouts</td><td>int(11)</td></tr>
<tr><td>H</td><td>smallint(6)</td></tr>
<tr><td>ER</td><td>smallint(6)</td></tr>
<tr><td>HR</td><td>smallint(6)</td></tr>
<tr><td>BB</td><td>smallint(6)</td></tr>
<tr><td>SO</td><td>smallint(6)</td></tr>
<tr><td>BAOpp</td><td>double</td></tr>
<tr><td>ERA</td><td>double</td></tr>
<tr><td>IBB</td><td>smallint(6)</td></tr>
<tr><td>WP</td><td>smallint(6)</td></tr>
<tr><td>HBP</td><td>smallint(6)</td></tr>
<tr><td>BK</td><td>smallint(6)</td></tr>
<tr><td>BFP</td><td>smallint(6)</td></tr>
<tr><td>GF</td><td>smallint(6)</td></tr>
<tr><td>R</td><td>smallint(6)</td></tr>
<tr><td>SH</td><td>smallint(6)</td></tr>
<tr><td>SF</td><td>smallint(6)</td></tr>
<tr><td>GIDP</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>salaries</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>playerID</td><td>varchar(9)</td></tr>
<tr><td>salary</td><td>double</td></tr>

</tbody></table>



</details>



<details><summary>schools</summary><br>

<table><tbody>
<tr><td>schoolID</td><td>varchar(15)</td></tr>
<tr><td>name_full</td><td>varchar(255)</td></tr>
<tr><td>city</td><td>varchar(55)</td></tr>
<tr><td>state</td><td>varchar(55)</td></tr>
<tr><td>country</td><td>varchar(55)</td></tr>

</tbody></table>



</details>



<details><summary>seriespost</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>round</td><td>varchar(5)</td></tr>
<tr><td>teamIDwinner</td><td>varchar(3)</td></tr>
<tr><td>lgIDwinner</td><td>varchar(2)</td></tr>
<tr><td>team_IDwinner</td><td>int(11)</td></tr>
<tr><td>teamIDloser</td><td>varchar(3)</td></tr>
<tr><td>team_IDloser</td><td>int(11)</td></tr>
<tr><td>lgIDloser</td><td>varchar(2)</td></tr>
<tr><td>wins</td><td>smallint(6)</td></tr>
<tr><td>losses</td><td>smallint(6)</td></tr>
<tr><td>ties</td><td>smallint(6)</td></tr>

</tbody></table>



</details>



<details><summary>teams</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>franchID</td><td>varchar(3)</td></tr>
<tr><td>divID</td><td>char(1)</td></tr>
<tr><td>div_ID</td><td>int(11)</td></tr>
<tr><td>teamRank</td><td>smallint(6)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>Ghome</td><td>smallint(6)</td></tr>
<tr><td>W</td><td>smallint(6)</td></tr>
<tr><td>L</td><td>smallint(6)</td></tr>
<tr><td>DivWin</td><td>varchar(1)</td></tr>
<tr><td>WCWin</td><td>varchar(1)</td></tr>
<tr><td>LgWin</td><td>varchar(1)</td></tr>
<tr><td>WSWin</td><td>varchar(1)</td></tr>
<tr><td>R</td><td>smallint(6)</td></tr>
<tr><td>AB</td><td>smallint(6)</td></tr>
<tr><td>H</td><td>smallint(6)</td></tr>
<tr><td>2B</td><td>smallint(6)</td></tr>
<tr><td>3B</td><td>smallint(6)</td></tr>
<tr><td>HR</td><td>smallint(6)</td></tr>
<tr><td>BB</td><td>smallint(6)</td></tr>
<tr><td>SO</td><td>smallint(6)</td></tr>
<tr><td>SB</td><td>smallint(6)</td></tr>
<tr><td>CS</td><td>smallint(6)</td></tr>
<tr><td>HBP</td><td>smallint(6)</td></tr>
<tr><td>SF</td><td>smallint(6)</td></tr>
<tr><td>RA</td><td>smallint(6)</td></tr>
<tr><td>ER</td><td>smallint(6)</td></tr>
<tr><td>ERA</td><td>double</td></tr>
<tr><td>CG</td><td>smallint(6)</td></tr>
<tr><td>SHO</td><td>smallint(6)</td></tr>
<tr><td>SV</td><td>smallint(6)</td></tr>
<tr><td>IPouts</td><td>int(11)</td></tr>
<tr><td>HA</td><td>smallint(6)</td></tr>
<tr><td>HRA</td><td>smallint(6)</td></tr>
<tr><td>BBA</td><td>smallint(6)</td></tr>
<tr><td>SOA</td><td>smallint(6)</td></tr>
<tr><td>E</td><td>int(11)</td></tr>
<tr><td>DP</td><td>int(11)</td></tr>
<tr><td>FP</td><td>double</td></tr>
<tr><td>name</td><td>varchar(50)</td></tr>
<tr><td>park</td><td>varchar(255)</td></tr>
<tr><td>attendance</td><td>int(11)</td></tr>
<tr><td>BPF</td><td>int(11)</td></tr>
<tr><td>PPF</td><td>int(11)</td></tr>
<tr><td>teamIDBR</td><td>varchar(3)</td></tr>
<tr><td>teamIDlahman45</td><td>varchar(3)</td></tr>
<tr><td>teamIDretro</td><td>varchar(3)</td></tr>

</tbody></table>



</details>



<details><summary>teamsfranchises</summary><br>

<table><tbody>
<tr><td>franchID</td><td>varchar(3)</td></tr>
<tr><td>franchName</td><td>varchar(50)</td></tr>
<tr><td>active</td><td>char(1)</td></tr>
<tr><td>NAassoc</td><td>varchar(3)</td></tr>

</tbody></table>



</details>



<details><summary>teamshalf</summary><br>

<table><tbody>
<tr><td>ID</td><td>int(11)</td></tr>
<tr><td>yearID</td><td>smallint(6)</td></tr>
<tr><td>lgID</td><td>char(2)</td></tr>
<tr><td>teamID</td><td>char(3)</td></tr>
<tr><td>team_ID</td><td>int(11)</td></tr>
<tr><td>Half</td><td>varchar(1)</td></tr>
<tr><td>divID</td><td>char(1)</td></tr>
<tr><td>div_ID</td><td>int(11)</td></tr>
<tr><td>DivWin</td><td>varchar(1)</td></tr>
<tr><td>teamRank</td><td>smallint(6)</td></tr>
<tr><td>G</td><td>smallint(6)</td></tr>
<tr><td>W</td><td>smallint(6)</td></tr>
<tr><td>L</td><td>smallint(6)</td></tr>

</tbody></table>



</details>
