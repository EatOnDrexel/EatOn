import config
import requests

# Declaring Variables for use later
pro_consumed = 0
fat_consumed = 0
carbs_consumed = 0

Calories_Limit = 0
Calories_Remaining = 0

Protein_Desired = 0
Fat_Desired = 0
Carbs_Desired = 0

Protein_Limit = 0
Fat_Limit = 0
Carbs_Limit = 0

r = None


# Takes user input for how many calories they can have in a day
def take_calories_input():

    global Calories_Limit
    print("What is your daily caloric limit?")
    user_input = int(input())

    Calories_Limit = user_input
    return user_input



# Takes user input as integer to store as value of a given macro
def take_input(macro):
    print("How many grams of " + macro + " have you consumed today?")
    user_input = int(input())
    return user_input


# Takes input of macros consumed in the day. Runs function take_input for each macro
def collect_macro_input():
    global pro_consumed
    global fat_consumed
    global carbs_consumed

    pro_consumed = take_input("protein")
    fat_consumed = take_input("fat")
    carbs_consumed = take_input("carbs")


# Calculating how many calories of each macro have been eaten that day
def calculate_calories():

    global pro_consumed
    global fat_consumed
    global carbs_consumed

    pro_consumed_cals = pro_consumed * 4
    fat_consumed_cals = fat_consumed * 9
    carbs_consumed_cals = carbs_consumed * 4
    return [pro_consumed_cals, fat_consumed_cals, carbs_consumed_cals]


def take_percentages(macro):
    print("What percentage of your diet should be made up of " + macro + "?")
    user_input = int(input())
    percent = user_input / 100.0
    return percent


# Generating call request
def generate_API_call():
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
        ('nutrients[CHOCDF]', str(int(Carbs_Remaining_Grams * .9)) + "-" + str(int(Carbs_Remaining_Grams))),
    )

    r = requests.get(url=URL, params=PARAMS)
    return r


# Calculate how many grams the user should have of each macro
def calculate_limits():

    global Calories_Limit
    global Protein_Limit
    global Fat_Limit
    global Carbs_Limit

    Protein_Limit = (Calories_Limit * take_percentages("protein")) / 4
    Fat_Limit = (Calories_Limit * take_percentages("fat")) / 9
    Carbs_Limit = (Calories_Limit * take_percentages("carbs")) / 4


# Calculate how many grams the user has left of each macro
def calculate_remaining_grams():

    global Protein_Remaining_Grams
    global Fat_Remaining_Grams
    global Carbs_Remaining_Grams

    Protein_Remaining_Grams = Protein_Limit - pro_consumed
    Fat_Remaining_Grams = Fat_Limit - fat_consumed
    Carbs_Remaining_Grams = Carbs_Limit - carbs_consumed


def calculate_remaining_calories():

    global Calories_Consumed
    global Calories_Remaining

    Calories_Consumed = sum(calculate_calories())
    Calories_Remaining = take_calories_input() - Calories_Consumed
    print(Calories_Limit)


# Asks user for search query
def take_search_term():
    print("What type of food are you looking for?")
    user_input = input()
    return user_input
