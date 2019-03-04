import config
import requests
import sys

Protein_Remaining_Grams = sys.argv[1]
Fat_Remaining_Grams = sys.argv[2]
Carb_Remaining_Grams = sys.argv[3]
Calories_Remaining = sys.argv[4]

URL = "https://api.edamam.com/search"
PARAMS = (
	('q', take_search_term()),
	('app_id', config.app_id),
	('app_key', config.api_key),
	('from', '0'),
	('to', str(config.number_of_results)),
	('calories', str(int(Calories_Remaining * .5)) + "-" + str(Calories_Remaining)),
	('nutrients[PROCNT]', str(int(Protein_Remaining_Grams * .9)) + "-" + str(int(Protein_Remaining_Grams))),
	('nutrients[FAT]', str(int(Fat_Remaining_Grams * .9)) + "-" + str(int(Fat_Remaining_Grams))),
	('nutrients[CHOCDF]', str(int(Carb_Remaining_Grams * .9)) + "-" + str(int(Carb_Remaining_Grams))),
)

r = requests.get(url=URL, params=PARAMS)
return r
