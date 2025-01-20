import numpy as np

# Definisikan kriteria (gabungan cost dan benefit)
criteria = np.array([
    #k1  k2  k3  k4  
    [80, 169, 78, 85],    # Baris 
    [75, 162, 78, 78], 
    [85, 163, 78, 73],
    [84, 159, 78, 80], 
    [76, 152, 78, 77],
    [81, 157, 78, 79], 
    [82, 160, 80, 76],
    [79, 158, 80, 75]

])
types = np.array(['benefit', 'cost', 'benefit', 'cost'])
weights = np.array([0.25, 0.35, 0.15, 0.25])


# Definisikan fungsi untuk normalisasi
def normalize(criteria, types):
    normalized_criteria = np.zeros_like(criteria, dtype=float)
    for i in range(criteria.shape[1]):
        if types[i] == 'cost':
            normalized_criteria[:, i] = np.min(criteria[:, i]) / criteria[:, i]
        else:
            normalized_criteria[:, i] = criteria[:, i] / np.max(criteria[:, i])
    return normalized_criteria

# Normalisasi kriteria
normalized_criteria = normalize(criteria, types)

# Hitung nilai v
def calculate_v(normalized_criteria, weights):
    vs = np.dot(normalized_criteria, weights)
    return vs
    
vs = calculate_v(normalized_criteria, weights)

# Tentukan jumlah kolom (termasuk kolom c1, c2, ..., c6)
num_columns = criteria.shape[1]
column = [f"c{i+1}" for i in range(num_columns)]
c_list = (' '.join([f"{col:>12}" for col in column]))


# Tampilkan hasil
print("Kriteria :")
print(c_list)
for i, row in enumerate(criteria):
    print(' '.join([f"{item:>12}" for item in row]))

print("\nNormalisasi :")
print(c_list)
for i, row in enumerate(normalized_criteria):
    print(' '.join([f"{item:12.4f}" for item in row]))

print("\nVektor :")
for i, v in enumerate(vs):
    print(f"v{i+1} = {v:.3f}")
