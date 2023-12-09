# inputfile = "day4_input.txt"
# with open(inputfile, 'r') as file:
# 	data = file.readlines()

data = [
	"Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53",
	"Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19",
	"Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1",
	"Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83",
	"Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36",
	"Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11",
]
class Card:
    def __init__(self, input_line):
    	card, numbers = input_line.split(':')
    	winners, mynumbers = numbers.split('|')
    	winners, mynumbers = winners.split(' '), mynumbers.split(' ')
    	# remove spaces/empty entries and convert to int
    	winners = sorted([int(x) for x in winners if x != ''])
    	mynumbers = sorted([int(x) for x in mynumbers if x != ''])

    	matches = list(set(winners) & set(mynumbers))
    	
    	self.card_number = int(card.split(' ')[1])
    	self.matches = sorted(matches)
    	self.number_of_matches = len(matches)


    def find_winning_copies(self):
    	# The Card has number_of_matches matching numbers, 
    	# so you win one copy each of the next number_of_matches cards: 
    	# cards self.card_number+1, self.card_number+2, self.card_number+3, self.card_number+4
    	# cards 2, 3, 4, and 5.
    	self.winning_card_numbers = [self.card_number + (number+1) for number in range(self.number_of_matches)]
    	print(self.winning_card_numbers)
    	for m in self.matches:
    		print(f"These cards win copies: {m},")

    def __str__(self):
    	return f"Card {self.card_number} has matches {', '.join(map(str, self.matches))}"

total = 0


for index, line in enumerate(data):

	card = Card(line)
	number_of_elements = card.number_of_matches
	print(card, "\n")
	card.find_winning_copies()
	



