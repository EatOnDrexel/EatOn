
pro_consumed = 0
fat_consumed = 0
carbs_consumed = 0

def take_calories_input():
    print("What is your daily caloric limit?")
    user_input = int(input())
    return user_input


def take_input(macro):
    print("How many grams of " + macro + " have you consumed today?")
    user_input = int(input())
    return user_input


def collect_macro_input():
    global pro_consumed
    global fat_consumed
    global carbs_consumed

    pro_consumed = take_input("protein")
    fat_consumed = take_input("fat")
    carbs_consumed = take_input("carbs")


def calculate_calories():
    # Calculating how many calories of each macro have been eaten that day

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

