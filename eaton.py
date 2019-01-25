import functions

# EatOn Demo Alpha
# Author: James Hemmen
# Drexel University
# Python 2.7


app_id = "lorem"
app_key = "ipsum"
number_of_results = 10
search_term = "chicken"

# Taking initial user inputs
Calories_Limit = functions.take_calories_input()
functions.collect_macro_input()


# Calculate how many calories have been consumed and how many are left for the day
Calories_Consumed = sum(functions.calculate_calories())
Calories_Remaining = Calories_Limit - Calories_Consumed

print("How Many Grams of Each Macro Consumed")
print(functions.pro_consumed)
print(functions.fat_consumed)
print(functions.carbs_consumed)


Protein_Desired = functions.take_percentages("protein")
Fat_Desired = functions.take_percentages("fat")
Carbs_Desired = functions.take_percentages("carbs")

print("Desired Grams of Each Macro")
print(Protein_Desired)
print(Fat_Desired)
print(Carbs_Desired)


# Calculate how many grams the user should have of each macro
Protein_Limit = (Calories_Limit * Protein_Desired) / 4
Fat_Limit = (Calories_Limit * Fat_Desired) / 9
Carbs_Limit = (Calories_Limit * Carbs_Desired) / 4

print("Daily Limit for Each Macro in Grams")
print(Protein_Limit)
print(Fat_Limit)
print(Carbs_Limit)

Protein_Remaining_Grams = Protein_Limit - functions.pro_consumed
Fat_Remaining_Grams = Fat_Limit - functions.fat_consumed
Carbs_Remaining_Grams = Carbs_Limit - functions.carbs_consumed

# Generating call request
# THIS IS UNFINISHED
API_Call = "https://api.edamam.com/search?" + search_term + "&app_id=" + app_id + "&app_key=" + app_key + "&from=0&to=" + str(number_of_results - 1) + "&"

print(API_Call)













