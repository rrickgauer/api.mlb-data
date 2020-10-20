<?php

class Constants {
  const Batting = [
    "ID"        => "ID",
    "playerID"  => "playerID",
    "yearID"    => "yearID",
    "stint"     => "stint",
    "teamID"    => "teamID",
    "team_ID"   => "team_ID",
    "lgID"      => "lgID",
    "G"         => "G",
    "G_batting" => "G_batting",
    "AB"        => "AB",
    "R"         => "R",
    "H"         => "H",
    "2B"        => "2B",
    "3B"        => "3B",
    "HR"        => "HR",
    "RBI"       => "RBI",
    "SB"        => "SB",
    "CS"        => "CS",
    "BB"        => "BB",
    "SO"        => "SO",
    "IBB"       => "IBB",
    "HBP"       => "HBP",
    "SH"        => "SH",
    "SF"        => "SF",
    "GIDP"      => "GIDP",
  ];

  const Pitching = [
    "ID"       => "ID",
    "playerID" => "playerID",
    "yearID"   => "yearID",
    "stint"    => "stint",
    "teamID"   => "teamID",
    "team_ID"  => "team_ID",
    "lgID"     => "lgID",
    "W"        => "W",
    "L"        => "L",
    "G"        => "G",
    "GS"       => "GS",
    "CG"       => "CG",
    "SHO"      => "SHO",
    "SV"       => "SV",
    "IPouts"   => "IPouts",
    "H"        => "H",
    "ER"       => "ER",
    "HR"       => "HR",
    "BB"       => "BB",
    "SO"       => "SO",
    "BAOpp"    => "BAOpp",
    "ERA"      => "ERA",
    "IBB"      => "IBB",
    "WP"       => "WP",
    "HBP"      => "HBP",
    "BK"       => "BK",
    "BFP"      => "BFP",
    "GF"       => "GF",
    "R"        => "R",
    "SH"       => "SH",
    "SF"       => "SF",
    "GIDP"     => "GIDP",
  ];

  const Appearances = [
    "ID"        => "ID",
    "yearID"    => "yearID",
    "teamID"    => "teamID",
    "team_ID"   => "team_ID",
    "lgID"      => "lgID",
    "playerID"  => "playerID",
    "G_all"     => "G_all",
    "GS"        => "GS",
    "G_batting" => "G_batting",
    "G_defense" => "G_defense",
    "G_p"       => "G_p",
    "G_c"       => "G_c",
    "G_1b"      => "G_1b",
    "G_2b"      => "G_2b",
    "G_3b"      => "G_3b",
    "G_ss"      => "G_ss",
    "G_lf"      => "G_lf",
    "G_cf"      => "G_cf",
    "G_rf"      => "G_rf",
    "G_of"      => "G_of",
    "G_dh"      => "G_dh",
    "G_ph"      => "G_ph",
    "G_pr"      => "G_pr",
  ];

  const Fielding = [
    "ID"       => "ID",
    "playerID" => "playerID",
    "yearID"   => "yearID",
    "stint"    => "stint",
    "teamID"   => "teamID",
    "team_ID"  => "team_ID",
    "lgID"     => "lgID",
    "POS"      => "POS",
    "G"        => "G",
    "GS"       => "GS",
    "InnOuts"  => "InnOuts",
    "PO"       => "PO",
    "A"        => "A",
    "E"        => "E",
    "DP"       => "DP",
    "PB"       => "PB",
    "WP"       => "WP",
    "SB"       => "SB",
    "CS"       => "CS",
    "ZR"       => "ZR",
  ];

  const People = [
    "playerID"      => "playerID",
    "birthCountry"  => "birthCountry",
    "birthState"    => "birthState",
    "birthCity"     => "birthCity",
    "deathState"    => "deathState",
    "deathCity"     => "deathCity",
    "nameFirst"     => "nameFirst",
    "nameLast"      => "nameLast",
    "nameGiven"     => "nameGiven",
    "weight"        => "weight",
    "height"        => "height",
    "bats"          => "bats",
    "throws"        => "throws",
    "retroID"       => "retroID",
    "bbrefID"       => "bbrefID",
    "birthDate"     => "birthDate",
    "debutDate"     => "debutDate",
    "finalGameDate" => "finalGameDate",
    "deathDate"     => "deathDate",
  ];

  const FieldingOF = [
    "ID"       => "ID",
    "playerID" => "playerID",
    "yearID"   => "yearID",
    "stint"    => "stint",
    "Glf"      => "Glf",
    "Gcf"      => "Gcf",
    "Grf"      => "Grf",
  ];


  const FieldingOFSplit = [
    "ID"       => "ID",
    "playerID" => "playerID",
    "yearID"   => "yearID",
    "stint"    => "stint",
    "teamID"   => "teamID",
    "team_ID"  => "team_ID",
    "lgID"     => "lgID",
    "POS"      => "POS",
    "G"        => "G",
    "GS"       => "GS",
    "InnOuts"  => "InnOuts",
    "PO"       => "PO",
    "A"        => "A",
    "E"        => "E",
    "DP"       => "DP",
    "PB"       => "PB",
    "WP"       => "WP",
    "SB"       => "SB",
    "CS"       => "CS",
    "ZR"       => "ZR",
  ];

  const Salaries = [
    "year"   => "year",
    "salary" => "salary",
  ];


  const Resources = [
    "Batting"         => "batting",
    "Pitching"        => "pitching",
    "Appearances"     => "appearances",
    "Fielding"        => "fielding",
    "People"          => "people",
    "FieldingOF"      => "fielding-of",
    "FieldingOFSplit" => "fielding-of-split",
    "Salaries"        => "salaries",
  ];

  const Defaults = [
    "PerPage" => 100,
    "Page"    => 1,
  ];

  const Limits = [
    "PerPage" => 1000,
  ];


  const FilterConditionals = [
    "E"  => "=",    // equal to
    "NE" => "!=",   // not equal to
    "GE" => ">=",   // greater than or equal to
    "LE" => "<=",   // less than or equal to
    "G"  => ">",    // greater than
    "L"  => "<",    // less than
  ];
}





















































?>