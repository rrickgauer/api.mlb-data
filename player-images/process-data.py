import json

def getData(fileName):
  with open(fileName) as configFile:
      configData = json.loads(configFile.read())
      return configData


FILE_NAME = 'player-images.json'


data = getData(FILE_NAME)

print(len(data))