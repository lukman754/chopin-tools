import numpy as np

# Definisikan kriteria (gabungan cost dan benefit)
criteria = np.array([
    # k1    k2   k3  k4  k5
    [0.75, 2000, 18, 50, 500],    # Baris 
    [0.50, 1500, 20, 40, 450], 
    [0.90, 2050, 35, 35, 800]
])

types = np.array(['cost', 'benefit', 'cost', 'benefit', 'cost'])
weights = np.array([5, 3, 4, 4, 2])

print("\nWeights: ", end="")
print(*weights, sep=", ")
# Jumlahkan seluruh weights
total_weight = np.sum(weights)
print("Total Weight:", total_weight)

# Bagi setiap nilai weight dengan hasil penjumlahan itu
normalized_weights = weights / total_weight

# Ubah tanda weight menjadi negatif jika jenis kriteria adalah 'cost'
normalized_weights[types == 'cost'] = -normalized_weights[types == 'cost']

# Bulatkan hasil ke dua angka di belakang koma
normalized_weights = np.round(normalized_weights, 2)

# Cetak proses perhitungan bobot
for i, (weight, normalized_weight, t) in enumerate(zip(weights, normalized_weights, types), start=1):
    sign = "-" if t == 'cost' else ""
    print(f"W{i} = {weight}/{total_weight} = {normalized_weight:.2f} ({t})")

# Cetak hasil tanpa kurung siku
print("\nNormalized Weights: ", end="")
print(*normalized_weights, sep=", ")

# Hitung hasil untuk setiap baris
results = []
for i, row in enumerate(criteria):
    calculation_steps = []
    result = 1
    for value, weight in zip(row, normalized_weights):
        calc = value ** weight
        calculation_steps.append(f"({value}^{weight})")
        result *= calc
    calculation_str = " * ".join(calculation_steps)
    print(f"S{i+1} = {calculation_str} = {result:.4f}")
    results.append(result)

print("\nHasil")
for i, result in enumerate(results):
    print(f"S{i+1} = {result:.4f}")

# Hitung total hasil
total_result = sum(results)

# Hitung perankingan
print("\nPerankingan")
rankings = []
for i, result in enumerate(results):
    ranking = result / total_result
    rankings.append(ranking)
    print(f"S{i+1} = {result:.4f} / ({' + '.join([f'{r:.4f}' for r in results])}) = {ranking:.4f}")

# Cetak ranking dalam bentuk yang lebih mudah dibaca
print("\nRanking dalam bentuk yang lebih mudah dibaca")
for i, ranking in enumerate(rankings, start=1):
    print(f"S{i} {ranking:.4f}")
