import json

def getData(fileName):
  with open(fileName) as configFile:
    configData = json.loads(configFile.read())
    return configData


def getInsertStmt(teamID, source):
  stmt = 'INSERT IGNORE INTO imagesteams (teamID, source) VALUES '
  stmt += '("' + teamID + '", '
  stmt += '"' + source + '");'
  return stmt


INPUT_FILE = 'teamID-img-links.json'
OUTPUT_FILE = 'insert-imagesteams.sql'


inputData = getData(INPUT_FILE)

stmts = []


for row in inputData:
  stmts.append(getInsertStmt(row['teamID'], row['imgLink']))



outputFile = open(OUTPUT_FILE, 'w')

for stmt in stmts:
  outputFile.write(stmt + "\n")

outputFile.close






