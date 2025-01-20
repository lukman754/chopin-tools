from itertools import permutations

def solve_cryptarithm(words, result):
    unique_chars = set(''.join(words) + result)
    assert len(unique_chars) <= 10, "Terlalu banyak karakter unik"

    for perm in permutations('0123456789', len(unique_chars)):
        char_to_digit = dict(zip(unique_chars, perm))
        if char_to_digit[result[0]] == '0':
            continue
        word_sum = sum(int(''.join(char_to_digit[char] for char in word)) for word in words)
        result_value = int(''.join(char_to_digit[char] for char in result))
        if word_sum == result_value:
            return char_to_digit
    return None

# Contoh penggunaan
words = ['I', 'DID']
result = 'ALL'
solution = solve_cryptarithm(words, result)

if solution:
    print("Solusi ditemukan:")
    for char, digit in solution.items():
        print(f"{char} = {digit}")
else:
    print("Tidak ada solusi yang ditemukan")
