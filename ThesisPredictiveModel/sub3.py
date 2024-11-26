import os
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report, confusion_matrix
from sklearn.preprocessing import LabelEncoder, StandardScaler
from sklearn.model_selection import train_test_split, cross_val_score
from imblearn.over_sampling import SMOTE
from collections import Counter
import joblib
import glob
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns

# Define the directory containing the files
directory_path = os.path.join(os.path.dirname(__file__), 'TrainingData')

# Find all CSV, XLSX, and XLS files in the directory
file_patterns = ['*.csv', '*.xlsx', '*.xls']
files = []
for pattern in file_patterns:
    files.extend(glob.glob(os.path.join(directory_path, pattern)))

# List to hold individual DataFrames
dfs = []

# Iterate through the list of files and read them into DataFrames
for file in files:
    if file.endswith('.csv'):
        df = pd.read_csv(file)
    else:  # Handles both .xlsx and .xls
        df = pd.read_excel(file)
    dfs.append(df)

# Concatenate all DataFrames
combined_df = pd.concat(dfs, ignore_index=True)

# Drop the 'id' column if it exists
if 'id' in combined_df.columns:
    combined_df.drop(columns=['id'], inplace=True)

# Display the combined DataFrame
print(combined_df)

# Select relevant columns including the target column 'Licensure Outcome'
grade_columns = [
    'ECE 111', 'ECE 112', 'ECE 114', 'ECE 121', 'ECE 122', 'ECE 131', 
    'ECE 132', 'ECE 133', 'ECE 141', 'ECE 143', 'ECE 142', 'ECE 146', 
    'ECE 152', 'ECE 153', 'ECE 156', 'ECE 151', 'ECE 154', 'ECE 158', 
    'ECE 155', 'ECE 162', 'ECE 160', 'ECE 163', 'ECE 164', 'ECE 166', 
    'ECE 167', 'ECE 168', 'ECE 202'
]
selected_columns = grade_columns + ['SUB3']
combined_df = combined_df[selected_columns]

# Drop rows with missing values in the selected columns
combined_df.dropna(subset=selected_columns, inplace=True)

# Display the head of the DataFrame
print("Head of the DataFrame:")
print(combined_df.head())

# Display the head of the DataFrame
print("Head of the DataFrame:")
print(combined_df.head())

performance = combined_df['SUB3']
combined_df = pd.concat([combined_df, combined_df], ignore_index=True)

# Calculate the average per course
average_per_course = combined_df[grade_columns].mean()

columns_to_standardize = grade_columns

# Initialize the scaler
scaler = StandardScaler()

# Standardize the grades and age
combined_df[columns_to_standardize] = scaler.fit_transform(combined_df[columns_to_standardize])

# Display the head of the DataFrame
print("Head of the DataFrame:")
print(combined_df.head())

# Split the data into features (X) and target variable (y)
X = combined_df[grade_columns]
y = combined_df['SUB3']

# Apply SMOTE to oversample the minority classes
smote = SMOTE(sampling_strategy='auto' ,random_state=100)
X_resampled, y_resampled = smote.fit_resample(X, y)

# Display resampled class distribution
print("Resampled class distribution:", Counter(y_resampled))

# Split the resampled data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X_resampled, y_resampled, test_size=0.2, random_state=42)

# Create a RandomForestClassifier model
model = RandomForestClassifier(n_estimators=100, max_features='sqrt', max_depth=10, random_state=42)

# Perform 5-fold cross-validation
cv_scores = cross_val_score(model, X_train, y_train, cv=5, scoring='accuracy')

# Print cross-validation scores
print(f"Cross-validation scores: {cv_scores}")
print(f"Mean cross-validation score: {np.mean(cv_scores):.2f}")

# Train the model on the entire training set
model.fit(X_train, y_train)

# Print message indicating that the model is trained
print('Model trained successfully!')

# Evaluate the model on the test set
y_pred = model.predict(X_test)

# Display accuracy and classification report
accuracy = accuracy_score(y_test, y_pred)
print(f'Accuracy on test set: {accuracy:.2f}')
print('Classification Report:')
print(classification_report(y_test, y_pred))

# Save the trained model
model_file_path = "category_3_model.pkl"
full_model_path = os.path.join(os.getcwd(), model_file_path)

try:
    joblib.dump(model, full_model_path)
    print("Model saved successfully as 'category_3_model.pkl'")
except Exception as e:
    print(f"An error occurred while saving the model: {e}")


'''
# Generate the confusion matrix
cm = confusion_matrix(y_test, y_pred)

# Display the confusion matrix
plt.figure(figsize=(8, 6))
sns.heatmap(cm, annot=True, fmt='g', cmap='Blues', cbar=False)
plt.title('Confusion Matrix')
plt.xlabel('Predicted')
plt.ylabel('Actual')
plt.show()
'''