# EatOn Demo Alpha
# Author: James Hemmen
# Drexel University
# Python 2.7

# Taking initial user inputs
Calories_Limit = int(input("What is your daily caloric limit?"))

Protein_Consumed = int(input("How many grams of protein have you consumed today? "))
Fat_Consumed = int(input("How many grams of fat have you consumed today? "))
Carbs_Consumed = int(input("How many grams of carbohydrates have you consumed today? "))


# Calculating how many calories of each macro have been eaten that day
Protein_Consumed_Calories = Protein_Consumed * 4
Fat_Consumed_Calories = Fat_Consumed * 9
Carbs_Consumed_Calories = Carbs_Consumed * 4

# Calculate how many calories have been consumed and how many are left for the day
Calories_Consumed = Protein_Consumed_Calories + Fat_Consumed_Calories + Carbs_Consumed_Calories
Calories_Remaining = Calories_Limit - Calories_Consumed

print(Protein_Consumed_Calories)
print(Fat_Consumed_Calories)
print(Carbs_Consumed_Calories)


print("What percentage of your diet should be made up of protein?")
Protein_Desired = (int(input()) / 100)

print("What percentage of your diet should be made up of fat")
Fat_Desired = (int(input()) / 100)

print("What percentage of your diet should be made up of carbs?")
Carbs_Desired = (int(input()) / 100)


# Calculate how many calories the user has consumed so far that day
Total_Calories_So_Far = Protein_Consumed_Calories + Fat_Consumed_Calories + Carbs_Consumed_Calories

# Calculate the percentage of calories from each macro
if Total_Calories_So_Far != 0:
    Percent_From_Protein = Protein_Consumed_Calories / Total_Calories_So_Far
    Percent_From_Fat = Fat_Consumed_Calories / Total_Calories_So_Far
    Percent_From_Carbs = Carbs_Consumed_Calories / Total_Calories_So_Far

else:
    Percent_From_Protein = 0
    Percent_From_Fat = 0
    Percent_From_Carbs = 0

Diet_Current = [Percent_From_Protein, Percent_From_Fat, Percent_From_Carbs]

# Calculate how many grams the user should have of each macro
Protein_Limit = (Calories_Limit * Protein_Desired) / 4
Fat_Limit = (Calories_Limit * Fat_Desired) / 9
Carbs_Limit = (Calories_Limit * Carbs_Desired) / 4

Protein_Remaining_Grams = Protein_Limit - Protein_Consumed
Fat_Remaining_Grams = Fat_Limit - Fat_Consumed
Carbs_Remaining_Grams = Carbs_Limit - Carbs_Consumed

print(Protein_Remaining_Grams)
print(Fat_Remaining_Grams)
print(Carbs_Remaining_Grams)
















