import functions

# EatOn Demo Alpha
# Author: James Hemmen
# Drexel University
# Python 3.6


# Taking initial user inputs
functions.take_calories_input()
functions.collect_macro_input()

# Calculate how many calories have been consumed and how many grams are left for the day of each macro
functions.calculate_remaining_calories()
functions.calculate_remaining_grams()
functions.calculate_limits()

# Generate API call
request = functions.generate_API_call()

print(request)

data = request.json()

print(request.text)
