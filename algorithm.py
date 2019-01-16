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
Calories_From_Protein = Protein_Consumed * 4
Calories_From_Fat = Fat_Consumed * 4
Calories_From_Carbs = Carbs_Consumed * 9

# Calculate how many calories have been consumed and how many are left for the day
Calories_Consumed = Calories_From_Protein + Calories_From_Fat + Calories_From_Carbs
Calories_Remaining = Calories_Limit - Calories_Consumed

print(Calories_From_Protein)
print(Calories_From_Fat)
print(Calories_From_Carbs)

# Diets stored in arrays with percentage breakdown of protein, fat, & carbs

Diet_Keto = [30, 60, 10]
Diet2 = [0, 0, 0]
Diet3 = [0, 0, 0]
Diet4 = [0, 0, 0]

Diet_Custom = [0, 0, 0]

# print("Please Choose the Diet You Are Following.")
# print("The numbers shown represent the percentage breakdown of protein, fat, and carbs.")
# print("\n")
# print("Keto: " + Diet_Keto)

