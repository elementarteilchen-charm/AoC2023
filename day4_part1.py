data = [
	"Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53",
	"Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19",
	"Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1",
	"Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83",
	"Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36",
	"Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11",
]
inputfile = "day4_input.txt"
with open(inputfile, 'r') as file:
	data = file.readlines()

total = 0
for index, line in enumerate(data):
	card, numbers = line.split(':')
	winners, mynumbers = numbers.split('|')
	winners, mynumbers = winners.split(' '), mynumbers.split(' ')
	winners = sorted([int(x) for x in winners if x != ''])
	mynumbers = sorted([int(x) for x in mynumbers if x != ''])
	result = list(set(winners) & set(mynumbers))
	number_of_elements = len(result)
	points = 0
	if number_of_elements > 0:
		points = 2**(number_of_elements-1)
	total = total + points
	print(card, points, sorted(result))

print(total)