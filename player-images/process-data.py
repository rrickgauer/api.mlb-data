import json

def getData(fileName):
  with open(fileName) as configFile:
      configData = json.loads(configFile.read())
      return configData


def getInsertStmt(playerID, source):
  # print(playerID)

  stmt = 'INSERT INTO images (playerID, source) VALUES ("'
  stmt += playerID + '", "'
  stmt += source + '");'
  return stmt


FILE_NAME = 'player-images.json'


data = getData(FILE_NAME)

print(len(data))


outputFile = open('insert-images.sql', 'w')

for row in data:
  playerID = row["playerID"]
  source = row["imgUrl"]
  stmt = getInsertStmt(playerID, source)
  outputFile.write(stmt + "\n")

outputFile.close()
