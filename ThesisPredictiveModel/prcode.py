import os
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
from sklearn.preprocessing import LabelEncoder, StandardScaler
from sklearn.model_selection import train_test_split
import joblib

# Load the dataset from the CSV file
file_path = 'dummy_data.csv'
df = pd.read_csv(file_path)

# Drop the 'id' column
df.drop(columns=['id'], inplace=True)

# Select relevant columns including the target column 'Licensure Outcome'
grade_columns = [
    'algebra', 'trigo', 'advalgebra', 'anageo', 'diffcal', 'stats', 'intcal',
    'advmat', 'numeric', 'vector', 'elxdevice', 'elxcirc', 'signals', 'princo',
    'lcst', 'digicom', 'trans', 'micro', 'broadcast', 'control', 'circ1',
    'elemag', 'circ2'
]
selected_columns = ['age', 'gender'] + grade_columns + ['passed']
df = df[selected_columns]

# Drop rows with missing values in the selected columns
df.dropna(subset=selected_columns, inplace=True)

# Display the head of the DataFrame
print("Head of the DataFrame:")
print(df.head())

# Convert categorical variables to numerical using label encoding
label_encoder_gender = LabelEncoder()

df['gender'] = label_encoder_gender.fit_transform(df['gender'])

# Display the head of the DataFrame
print("Head of the DataFrame:")
print(df.head())

columns_to_standardize = grade_columns + ['age']

# Initialize the scaler
scaler = StandardScaler()

# Standardize the grades and age
df[columns_to_standardize] = scaler.fit_transform(df[columns_to_standardize])

# Display the head of the DataFrame
print("Head of the DataFrame:")
print(df.head())

# Split the data into features (X) and target variable (y)
X = df[['age', 'gender'] + grade_columns]
y = df['passed']

# Split the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Create a RandomForestClassifier model
model = RandomForestClassifier(n_estimators=50, max_features='sqrt', max_depth=5, random_state=42)

'''
# Define the parameter grid
param_grid = {
    'max_depth': [5, 10, 15, 20, None],
    'n_estimators': [50, 100, 200]
}

# Initialize a RandomForestClassifier
rf = RandomForestClassifier(random_state=42)

# Perform grid search with cross-validation
grid_search = GridSearchCV(estimator=rf, param_grid=param_grid, cv=5, n_jobs=-1, scoring='accuracy')
grid_search.fit(X_train, y_train)

# Get the best parameters
best_params = grid_search.best_params_
print(f"Best parameters found: {best_params}")

# Train the final model with the best parameters
final_model = RandomForestClassifier(**best_params, random_state=42)
final_model.fit(X_train, y_train)
'''
# Train the model
model.fit(X_train, y_train)

# Print message indicating that the model is trained
print('Model trained successfully!')

# Evaluate the model on the test set
y_pred = model.predict(X_test)

# Display accuracy and classification report
accuracy = accuracy_score(y_test, y_pred)
print(f'Accuracy: {accuracy:.2f}')
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

'''
# Get feature importances
feature_importances = model.feature_importances_

# Get feature names
feature_names = ['age', 'gender'] + grade_columns

# Create a DataFrame for feature importances
importance_df = pd.DataFrame({
    'Feature': feature_names,
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
'''