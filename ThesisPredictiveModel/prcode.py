import os
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
from sklearn.preprocessing import LabelEncoder, StandardScaler
from sklearn.model_selection import train_test_split, cross_val_score
from imblearn.over_sampling import SMOTE
from collections import Counter
import joblib
import glob
import numpy as np

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
    'CALCULUS I', 'CALCULUS II', 'DIFFERENTIAL EQUATIONS', 
    'CHEMISTRY FOR ENGINEERS', 'PHYSICS FOR ENGINEERS', 
    'COMPUTER AIDED DRAFTING', 'ENGINEERING ECONOMICS', 
    'ENGINEERING MANAGEMENT', 'PHYSICS II', 'MATERIAL SCIENCE AND ENGINEERING',
    'COMPUTER PROGRAMMING', 'ENVIRONMENTAL SCIENCE AND ENGINEERING',
    'ADVANCED ENGINEERING MATHEMATICS', 'ELECTROMAGNETICS',
    'ECE LAWS, CONTRACTS, ETHICS, STANDARDS AND SAFETY',
    'ELECTRONICS 1: ELECTRONIC DEVICES AND CIRCUITS', 
    'ELECTRONICS 2: ELECTRONIC CIRCUIT ANALYSIS AND DESIGN', 
    'SIGNALS, SPECTRA AND SIGNAL PROCESSING', 
    'COMMUNICATIONS 1: PRINCIPLES OF COMMUNICATION SYSTEMS', 
    'COMMUNICATIONS 4: TRANSMISSION MEDIA AND ANTENNA SYSTEM AND DESIGN',
    'DIGITAL ELECTRONICS 1: LOGIC CIRCUITS AND SWITCHING THEORY', 
    'DIGITAL ELECTRONICS 2: MICROPROCESSOR, MICROCONTROLLER SYSTEM AND DESIGN',
    'FEEDBACK AND CONTROL SYSTEMS', 'DESIGN 1/CAPSTONE PROJECT 1', 
    'ECE ELECTIVE: INDUSTRIAL ELECTRONICS', 'DESIGN 2/ CAPSTONE PROJECT 2', 'SEMINARS/COLLOQUIUM'
]
selected_columns = grade_columns + ['PERFORMANCE']
combined_df = combined_df[selected_columns]

# Drop rows with missing values in the selected columns
combined_df.dropna(subset=selected_columns, inplace=True)

# Display the head of the DataFrame
print("Head of the DataFrame:")
print(combined_df.head())

# Display the head of the DataFrame
print("Head of the DataFrame:")
print(combined_df.head())

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
y = combined_df['PERFORMANCE']

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
model_file_path = "random_forest_licensure_model.pkl"
full_model_path = os.path.join(os.getcwd(), model_file_path)

try:
    joblib.dump(model, full_model_path)
    print("Model saved successfully as 'random_forest_licensure_model.pkl'")
except Exception as e:
    print(f"An error occurred while saving the model: {e}")

# Get feature importances
feature_importances = model.feature_importances_

# Create a DataFrame for feature importances
importance_df = pd.DataFrame({
    'Feature': grade_columns,
    'Importance': feature_importances
})

# Sort the DataFrame by importance
importance_df = importance_df.sort_values(by='Importance', ascending=False)

# Print the top predictors
print("\nTop predictors based on feature importance:")
print(importance_df)

# Print the most important predictor
top_predictor = importance_df.iloc[0]
print(f"\nThe top predictor is '{top_predictor['Feature']}' with an importance score of {top_predictor['Importance']:.4f}")