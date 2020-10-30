import json
import requests
from bs4 import BeautifulSoup
from datetime import datetime

startTime = datetime.now()

print(startTime)

def getDicts(fileName):
  with open(fileName) as configFile:
      configData = json.loads(configFile.read())
      return configData

def getImgDict(playerID, imgUrl):
    imgDict = {
        "playerID": playerID,
        "imgUrl": imgUrl,
    }

    return imgDict

def writeDictToFile(data, fileName):
    jsonString = json.dumps(data, indent=4)
    with open(fileName, "w") as newConfigFile:
        newConfigFile.write(jsonString)


def convertSeconds(seconds): 
    seconds = seconds % (24 * 3600) 
    hour = seconds // 3600
    seconds %= 3600
    minutes = seconds // 60
    seconds %= 60
      
    return "%d:%02d:%02d" % (hour, minutes, seconds) 
      



PLAYER_DICTS = 'player-dicts.json'

dicts = getDicts(PLAYER_DICTS)


# dicts2 = []
# for x in range(10):
#     dicts2.append(dicts[x])

imgsDict = []

count = 0

for player in dicts:

    if count % 100 == 0:
        writeDictToFile(imgsDict, 'player-images.json')
        print(count)


    if player['url'] is None:
         continue

    response = requests.get(player['url'])
    soup = BeautifulSoup(response.text, 'html.parser')
    element = soup.find(id='meta')

    if element is None:
        continue

    for imgLink in element.find_all('img'):
        playerID = player['playerID']
        imgUrl = imgLink.get('src')
        imgsDict.append(getImgDict(playerID, imgUrl))

    count += 1

writeDictToFile(imgsDict, 'player-images.json')

print(len(imgsDict))


timeTaken = datetime.now() - startTime
print(timeTaken)

