import requests
from bs4 import BeautifulSoup
import mysql.connector
import json



def getData(fileName):
  with open(fileName) as configFile:
      configData = json.loads(configFile.read())
      return configData


def generateTeamUrl(bbrefID):
  return BBREF_BASE_URL + bbrefID + '/'


def getImgLink(teamID, bbrefID):
  print(teamID, bbrefID)
  url = generateTeamUrl(bbrefID)
  response = requests.get(url)
  soup = BeautifulSoup(response.text, 'html.parser')
  element = soup.find(id='meta')
  img = element.find(class_='teamlogo').get('src')
  return img


def getImgDict(teamID, imgLink):
  return {
    "teamID": teamID,
    "imgLink": imgLink,
  }


def writeDictToFile(data, fileName):
  jsonString = json.dumps(data, indent=4)
  with open(fileName, "w") as newConfigFile:
    newConfigFile.write(jsonString)


INPUT_FILE_NAME = 'teamID-bbrefID-data.json'
OUTPUT_FILE_NAME = 'teamID-img-links.json'
BBREF_BASE_URL = 'https://www.baseball-reference.com/teams/'


inputData = getData(INPUT_FILE_NAME)


imgDicts = []

for row in inputData:
  link = getImgLink(row['teamID'], row['bbrefID'])
  imgDicts.append(getImgDict(row['teamID'], link))


writeDictToFile(imgDicts, OUTPUT_FILE_NAME)





