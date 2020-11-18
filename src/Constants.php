<?php
/**
 * This class holds the constants used throughout the API.
 * 
 * RootUrl
 * Modules
 * Defaults
 * Limits
 * Batting
 * Pitching
 * Appearances
 * Fielding
 * People
 * FieldingOF
 * FieldingOFSPlit
 * Salaries
 * Search
 * Images
 * BattingPost
 * PitchingPost
 * FieldingPost
 * Colleges
 * BattingAggregate
 * PitchingAggregate
 * AppearancesAggregate
 * FieldingAggregate
 * FieldingOFAggregate
 * FieldingOFSplitAggregate
 * SalariesAggregate
 * BattingPostAggregate
 * PitchingPostAggregate
 * FieldingPostAggregate
 * FilterConditionals
 * ExternalUrls
 * InternalUrls
 * DefaultPageDisplay
 */
 
class Constants {

  const RootUrl = 'https://api.mlb-data.ryanrickgauer.com/main.php';

  const Modules = [
    "Batting"         => "batting",
    "Pitching"        => "pitching",
    "Appearances"     => "appearances",
    "Fielding"        => "fielding",
    "Images"          => "images",
    "People"          => "people",
    "FieldingOF"      => "fielding-of",
    "FieldingOFSplit" => "fielding-of-split",
    "Salaries"        => "salaries",
    "Search"          => "search",
    "BattingPost"     => "batting-post",
    "PitchingPost"    => "pitching-post",
    "FieldingPost"    => "fielding-post",
    "Colleges"        => "colleges",
    "Teams"           => "teams",
  ];

  const Defaults = [
    "perPage"  => 100,
    "page"     => 1,
    "offset"   => 0,
    "playerID" => null,
    "sort"     => null,
    "filters"  => null,
  ];

  const Limits = [
    "perPage" => 1000,
  ];

  const Batting = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "teamName"  => "teamName",
    "stint"     => "stint",
    "lgID"      => "lgID",
    "G"         => "G",
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
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "stint"     => "stint",
    "teamName"  => "teamName",
    "lgID"      => "lgID",
    "W"         => "W",
    "L"         => "L",
    "G"         => "G",
    "GS"        => "GS",
    "CG"        => "CG",
    "SHO"       => "SHO",
    "SV"        => "SV",
    "IPouts"    => "IPouts",
    "H"         => "H",
    "ER"        => "ER",
    "HR"        => "HR",
    "BB"        => "BB",
    "SO"        => "SO",
    "BAOpp"     => "BAOpp",
    "ERA"       => "ERA",
    "IBB"       => "IBB",
    "WP"        => "WP",
    "HBP"       => "HBP",
    "BK"        => "BK",
    "BFP"       => "BFP",
    "GF"        => "GF",
    "R"         => "R",
    "SH"        => "SH",
    "SF"        => "SF",
    "GIDP"      => "GIDP",
  ];

  const Appearances = [
    "year"      => "year",
    "teamName"  => "teamName",
    "lgID"      => "lgID",
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
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
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "stint"     => "stint",
    "teamName"  => "teamName",
    "lgID"      => "lgID",
    "POS"       => "POS",
    "G"         => "G",
    "GS"        => "GS",
    "InnOuts"   => "InnOuts",
    "PO"        => "PO",
    "A"         => "A",
    "E"         => "E",
    "DP"        => "DP",
    "PB"        => "PB",
    "WP"        => "WP",
    "SB"        => "SB",
    "CS"        => "CS",
    "ZR"        => "ZR",
  ];

  const People = [
    "playerID"      => "playerID",
    "nameFirst"     => "nameFirst",
    "nameLast"      => "nameLast",
    "nameGiven"     => "nameGiven",
    "birthCountry"  => "birthCountry",
    "birthState"    => "birthState",
    "birthCity"     => "birthCity",
    "deathCountry"  => "deathCountry",
    "deathState"    => "deathState",
    "deathCity"     => "deathCity",
    "weight"        => "weight",
    "height"        => "height",
    "bats"          => "bats",
    "throws"        => "throws",
    "retroID"       => "retroID",
    "bbrefLink"     => "bbrefLink",
    "birthDate"     => "birthDate",
    "debuteDate"    => "debuteDate",
    "finalGameDate" => "finalGameDate",
    "deathDate"     => "deathDate",
    "team"          => "team",
    "image"         => "image",
    "hallOfFame"    => "hallOfFame",
  ];

  const FieldingOF = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "stint"     => "stint",
    "Glf"       => "Glf",
    "Gcf"       => "Gcf",
    "Grf"       => "Grf",
  ];


  const FieldingOFSplit = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "stint"     => "stint",
    "teamName"  => "teamName",
    "lgID"      => "lgID",
    "POS"       => "POS",
    "G"         => "G",
    "GS"        => "GS",
    "InnOuts"   => "InnOuts",
    "PO"        => "PO",
    "A"         => "A",
    "E"         => "E",
    "DP"        => "DP",
    "PB"        => "PB",
    "WP"        => "WP",
    "SB"        => "SB",
    "CS"        => "CS",
    "ZR"        => "ZR",
  ];

  const Salaries = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "teamName"  => "teamName",
    "lgID"      => "lgID",
    "salary"    => "salary",
  ];

  const Search = [
    "playerID"      => "playerID",
    "nameFirst"     => "nameFirst",
    "nameLast"      => "nameLast",
    "birthDate"     => "birthDate",
    "debutDate"     => "debutDate",
    "finalGameDate" => "finalGameDate",
    "deathDate"     => "deathDate",
    "score"         => "score",
  ];

  const Images = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "source"    => "source",
  ];


  const BattingPost = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "teamName"  => "teamName",
    "round"     => "round",
    "lgID"      => "lgID",
    "G"         => "G",
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

  const PitchingPost = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "round"     => "round",
    "teamName"  => "teamName",
    "lgID"      => "lgID",
    "W"         => "W",
    "L"         => "L",
    "G"         => "G",
    "GS"        => "GS",
    "CG"        => "CG",
    "SHO"       => "SHO",
    "SV"        => "SV",
    "IPouts"    => "IPouts",
    "H"         => "H",
    "ER"        => "ER",
    "HR"        => "HR",
    "BB"        => "BB",
    "SO"        => "SO",
    "BAOpp"     => "BAOpp",
    "ERA"       => "ERA",
    "IBB"       => "IBB",
    "WP"        => "WP",
    "HBP"       => "HBP",
    "BK"        => "BK",
    "BFP"       => "BFP",
    "GF"        => "GF",
    "R"         => "R",
    "SH"        => "SH",
    "SF"        => "SF",
    "GIDP"      => "GIDP",
  ];

  const FieldingPost = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "year"      => "year",
    "round"     => "round",
    "teamName"  => "teamName",
    "lgID"      => "lgID",
    "POS"       => "POS",
    "G"         => "G",
    "GS"        => "GS",
    "InnOuts"   => "InnOuts",
    "PO"        => "PO",
    "A"         => "A",
    "E"         => "E",
    "DP"        => "DP",
    "PB"        => "PB",
    "SB"        => "SB",
    "CS"        => "CS",
  ];

  const Colleges = [
    "playerID"      => "playerID",
    "nameFirst"     => "nameFirst",
    "nameLast"      => "nameLast",
    "year"          => "year",
    "schoolName"    => "schoolName",
    "schoolCity"    => "schoolCity",
    "schoolState"   => "schoolState",
    "schoolCountry" => "schoolCountry",
  ];

  const BattingAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "G"         => "G",
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


  const PitchingAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "W"         => "W",
    "L"         => "L",
    "G"         => "G",
    "GS"        => "GS",
    "CG"        => "CG",
    "SHO"       => "SHO",
    "SV"        => "SV",
    "IPouts"    => "IPouts",
    "H"         => "H",
    "ER"        => "ER",
    "HR"        => "HR",
    "BB"        => "BB",
    "SO"        => "SO",
    "BAOpp"     => "BAOpp",
    "ERA"       => "ERA",
    "IBB"       => "IBB",
    "WP"        => "WP",
    "HBP"       => "HBP",
    "BK"        => "BK",
    "BFP"       => "BFP",
    "GF"        => "GF",
    "R"         => "R",
    "SH"        => "SH",
    "SF"        => "SF",
    "GIDP"      => "GIDP",
  ];


  const AppearancesAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
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


  const FieldingAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "G"         => "G",
    "GS"        => "GS",
    "InnOuts"   => "InnOuts",
    "PO"        => "PO",
    "A"         => "A",
    "E"         => "E",
    "DP"        => "DP",
    "PB"        => "PB",
    "WP"        => "WP",
    "SB"        => "SB",
    "CS"        => "CS",
    "ZR"        => "ZR",
  ];


  const FieldingOFAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "Glf"       => "Glf",
    "Gcf"       => "Gcf",
    "Grf"       => "Grf",
  ];


  const FieldingOFSplitAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "G"         => "G",
    "GS"        => "GS",
    "InnOuts"   => "InnOuts",
    "PO"        => "PO",
    "A"         => "A",
    "E"         => "E",
    "DP"        => "DP",
    "PB"        => "PB",
    "WP"        => "WP",
    "SB"        => "SB",
    "CS"        => "CS",
    "ZR"        => "ZR",
  ];


  const SalariesAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "salary"    => "salary",
  ];


  const BattingPostAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "G"         => "G",
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


  const PitchingPostAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "W"         => "W",
    "L"         => "L",
    "G"         => "G",
    "GS"        => "GS",
    "CG"        => "CG",
    "SHO"       => "SHO",
    "SV"        => "SV",
    "IPouts"    => "IPouts",
    "H"         => "H",
    "ER"        => "ER",
    "HR"        => "HR",
    "BB"        => "BB",
    "SO"        => "SO",
    "BAOpp"     => "BAOpp",
    "ERA"       => "ERA",
    "IBB"       => "IBB",
    "WP"        => "WP",
    "HBP"       => "HBP",
    "BK"        => "BK",
    "BFP"       => "BFP",
    "GF"        => "GF",
    "R"         => "R",
    "SH"        => "SH",
    "SF"        => "SF",
    "GIDP"      => "GIDP",
  ];


  const FieldingPostAggregate = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "years"     => "years",
    "G"         => "G",
    "GS"        => "GS",
    "InnOuts"   => "InnOuts",
    "PO"        => "PO",
    "A"         => "A",
    "E"         => "E",
    "DP"        => "DP",
    "PB"        => "PB",
    "SB"        => "SB",
    "CS"        => "CS",
  ];

  const Teams = [
    "teamID"         => "teamID",
    "teamName"       => "teamName",
    "year"           => "year",
    "lgID"           => "lgID",
    "franchID"       => "franchID",
    "divID"          => "divID",
    "div_ID"         => "div_ID",
    "teamRank"       => "teamRank",
    "G"              => "G",
    "Ghome"          => "Ghome",
    "W"              => "W",
    "L"              => "L",
    "DivWin"         => "DivWin",
    "WCWin"          => "WCWin",
    "LgWin"          => "LgWin",
    "WSWin"          => "WSWin",
    "R"              => "R",
    "AB"             => "AB",
    "H"              => "H",
    "2B"             => "2B",
    "3B"             => "3B",
    "HR"             => "HR",
    "BB"             => "BB",
    "SO"             => "SO",
    "SB"             => "SB",
    "CS"             => "CS",
    "HBP"            => "HBP",
    "SF"             => "SF",
    "RA"             => "RA",
    "ER"             => "ER",
    "ERA"            => "ERA",
    "CG"             => "CG",
    "SHO"            => "SHO",
    "SV"             => "SV",
    "IPouts"         => "IPouts",
    "HA"             => "HA",
    "HRA"            => "HRA",
    "BBA"            => "BBA",
    "SOA"            => "SOA",
    "E"              => "E",
    "DP"             => "DP",
    "FP"             => "FP",
    "park"           => "park",
    "attendance"     => "attendance",
    "BPF"            => "BPF",
    "PPF"            => "PPF",
    "teamIDBR"       => "teamIDBR",
    "teamIDlahman45" => "teamIDlahman45",
    "teamIDretro"    => "teamIDretro",
  ];


  const TeamsAggregate = [
    "teamID"     => "teamID",
    "teamName"   => "teamName",
    "years"      => "years",
    "G"          => "G",
    "Ghome"      => "Ghome",
    "W"          => "W",
    "L"          => "L",
    "DivWin"     => "DivWin",
    "WCWin"      => "WCWin",
    "LgWin"      => "LgWin",
    "WSWin"      => "WSWin",
    "R"          => "R",
    "AB"         => "AB",
    "H"          => "H",
    "2B"         => "2B",
    "3B"         => "3B",
    "HR"         => "HR",
    "BB"         => "BB",
    "SO"         => "SO",
    "SB"         => "SB",
    "CS"         => "CS",
    "HBP"        => "HBP",
    "SF"         => "SF",
    "RA"         => "RA",
    "ER"         => "ER",
    "ERA"        => "ERA",
    "CG"         => "CG",
    "SHO"        => "SHO",
    "SV"         => "SV",
    "IPouts"     => "IPouts",
    "HA"         => "HA",
    "HRA"        => "HRA",
    "BBA"        => "BBA",
    "SOA"        => "SOA",
    "E"          => "E",
    "DP"         => "DP",
    "FP"         => "FP",
    "park"       => "park",
    "attendance" => "attendance",
    "BPF"        => "BPF",
    "PPF"        => "PPF",
  ];

  const TeamPlayers = [
    "playerID"  => "playerID",
    "nameFirst" => "nameFirst",
    "nameLast"  => "nameLast",
    "teamID"    => "teamID",
    "teamName"  => "teamName",
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

  const FilterConditionals = [
    "E"  => "=",    // equal to
    "NE" => "!=",   // not equal to
    "GE" => ">=",   // greater than or equal to
    "LE" => "<=",   // less than or equal to
    "G"  => ">",    // greater than
    "L"  => "<",    // less than
  ];

  const ExternalUrls = [
    "bbrefID" => "https://www.baseball-reference.com/players/",  // https://www.baseball-reference.com/players/b/bondsba01.shtml
  ];

  const InternalUrls = [
    "Batting"         => Constants::RootUrl . "/batting",
    "Pitching"        => Constants::RootUrl . "/pitching",
    "Appearances"     => Constants::RootUrl . "/appearances",
    "Fielding"        => Constants::RootUrl . "/fielding",
    "People"          => Constants::RootUrl . "/people",
    "FieldingOF"      => Constants::RootUrl . "/fielding-of",
    "FieldingOFSplit" => Constants::RootUrl . "/fielding-of-split",
    "Salaries"        => Constants::RootUrl . "/salaries",
    "Search"          => Constants::RootUrl . "/search",
    "Images"          => Constants::RootUrl . "/images",
    "BattingPost"     => Constants::RootUrl . "/batting-post",
    "FieldingPost"    => Constants::RootUrl . "/fielding-post",
    "PitchingPost"    => Constants::RootUrl . "/pitching-post",
    "Colleges"        => Constants::RootUrl . "/colleges",
  ];

  const DefaultPageDisplay = [
    "Author"         => "Ryan Rickgauer",
    "Author Website" => "https://www.ryanrickgauer.com/resume/index.html",
    "Api Home Page"  => "https://github.com/rrickgauer/api.mlb-data",

    "Resources" => [
      "Appearances"     => 'https://api.mlb-data.ryanrickgauer.com/main.php/appearances{/playerID}{?sort,filter,aggregate,page,perPage}',
      "Batting"         => 'https://api.mlb-data.ryanrickgauer.com/main.php/batting{/playerID}{?sort,filter,aggregate,page,perPage}',
      "BattingPost"     => 'https://api.mlb-data.ryanrickgauer.com/main.php/batting-post{/playerID}{?sort,filter,aggregate,page,perPage}',
      "Colleges"        => 'https://api.mlb-data.ryanrickgauer.com/main.php/colleges{/playerID}{?sort,filter,page,perPage}',
      "Fielding"        => 'https://api.mlb-data.ryanrickgauer.com/main.php/fielding{/playerID}{?sort,filter,aggregate,page,perPage}',
      "FieldingOF"      => 'https://api.mlb-data.ryanrickgauer.com/main.php/fielding-of{/playerID}{?sort,filter,aggregate,page,perPage}',
      "FieldingOFSplit" => 'https://api.mlb-data.ryanrickgauer.com/main.php/fielding-of-split{/playerID}{?sort,filter,aggregate,page,perPage}',
      "FieldingPost"    => 'https://api.mlb-data.ryanrickgauer.com/main.php/fielding-post{/playerID}{?sort,filter,aggregate,page,perPage}',
      "Images"          => 'https://api.mlb-data.ryanrickgauer.com/main.php/images{/playerID}{?sort,filter,page,perPage}',
      "People"          => 'https://api.mlb-data.ryanrickgauer.com/main.php/people{/playerID}{?sort,filter,page,perPage}',
      "Pitching"        => 'https://api.mlb-data.ryanrickgauer.com/main.php/pitching{/playerID}{?sort,filter,aggregate,page,perPage}',
      "PitchingPost"    => 'https://api.mlb-data.ryanrickgauer.com/main.php/pitching-post{/playerID}{?sort,filter,aggregate,page,perPage}',
      "Salaries"        => 'https://api.mlb-data.ryanrickgauer.com/main.php/salaries{/playerID}{?sort,filter,aggregate,page,perPage}',
      "Search"          => 'https://api.mlb-data.ryanrickgauer.com/main.php/search?q={query,page,perPage}',
    ],

  ];

}


?>