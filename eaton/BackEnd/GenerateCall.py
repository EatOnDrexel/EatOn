import config
import requests
import sys
import json


# Percentage of each macro required by user
Protein_Desired = int(sys.argv[1])/100
Fat_Desired = int(sys.argv[2])/100
Carb_Desired = int(sys.argv[3])/100

# Daily caloric limit of user
Calories_Limit = int(sys.argv[4])

# How many grams of each macro have been consumed that day
Protein_Consumed_Grams = int(sys.argv[5])
Fat_Consumed_Grams = int(sys.argv[6])
Carb_Consumed_Grams = int(sys.argv[7])

# User's search term
Search_Term = sys.argv[8]


# Calculating how many calories of each macro have been eaten that day
Pro_Consumed_Cals = Protein_Consumed_Grams * 4
Fat_Consumed_Cals = Fat_Consumed_Grams * 9
Carbs_Consumed_Cals = Carb_Consumed_Grams * 4

# Calculate how many grams the user should have of each macro
Protein_Limit = (Calories_Limit * Protein_Desired) / 4
Fat_Limit = (Calories_Limit * Fat_Desired) / 9
Carbs_Limit = (Calories_Limit * Carb_Desired) / 4

# Calculate how many grams the user has left of each macro
if Protein_Consumed_Grams > Protein_Limit:
	Protein_Remaining_Grams = 0
else:
	Protein_Remaining_Grams = Protein_Limit - Protein_Consumed_Grams

if Fat_Consumed_Grams > Fat_Limit:
	Fat_Remaining_Grams = 0
else:
	Fat_Remaining_Grams = Fat_Limit - Fat_Consumed_Grams

if Carb_Consumed_Grams > Carbs_Limit:
	Carb_Remaining_Grams = 0
else:
	Carb_Remaining_Grams = Carbs_Limit - Carb_Consumed_Grams


# Calculate how many calories have been consumed and how many are left for the day
Calories_Consumed = (Pro_Consumed_Cals + Fat_Consumed_Cals + Carbs_Consumed_Cals)
Calories_Remaining = Calories_Limit - Calories_Consumed


# Generating call request
URL = "https://api.edamam.com/search"
PARAMS = (
    ('q', Search_Term),
    ('app_id', config.app_id),
    ('app_key', config.api_key),
    ('from', '0'),
    ('to', str(config.number_of_results)),
    ('calories', str(int(Calories_Remaining * .75)) + "-" + str(Calories_Remaining)),
    ('nutrients[PROCNT]', str(int(Protein_Remaining_Grams * .75)) + "-" + str(int(Protein_Remaining_Grams))),
    ('nutrients[FAT]', str(int(Fat_Remaining_Grams * .75)) + "-" + str(int(Fat_Remaining_Grams))),
    ('nutrients[CHOCDF]', str(int(Carb_Remaining_Grams * .75)) + "-" + str(int(Carb_Remaining_Grams))),
)

r = requests.get(url=URL, params=PARAMS)

print (json.dumps(r.json()))


