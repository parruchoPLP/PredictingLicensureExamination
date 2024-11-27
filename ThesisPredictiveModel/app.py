from io import StringIO
from flask import Flask, request, jsonify, send_file, make_response
import pandas as pd
import joblib
from sklearn.preprocessing import LabelEncoder, StandardScaler
import os

app = Flask(__name__)

# Load the pre-trained model
model_file_path = 'random_forest_licensure_model.pkl'
model1_file_path = 'category_1_model.pkl'
model2_file_path = 'category_2_model.pkl'
model3_file_path = 'category_3_model.pkl'
model4_file_path = 'category_4_model.pkl'

# Load the pre-fitted scaler
scaler = joblib.load("standard_scaler.pkl")

try:
    model = joblib.load(model_file_path)
except Exception as e:
    print(f"An error occurred while loading the model: {e}")
    model = None

try:
    model1 = joblib.load(model1_file_path)
except Exception as e:
    print(f"An error occurred while loading the model: {e}")
    model1 = None

try:
    model2 = joblib.load(model2_file_path)
except Exception as e:
    print(f"An error occurred while loading the model: {e}")
    model2 = None

try:
    model3 = joblib.load(model3_file_path)
except Exception as e:
    print(f"An error occurred while loading the model: {e}")
    model3 = None

try:
    model4 = joblib.load(model4_file_path)
except Exception as e:
    print(f"An error occurred while loading the model: {e}")
    model4 = None

# Load label encoders
label_encoder_gender = LabelEncoder()

# Load the dataset (for label encoder fitting)
file_path = 'TrainingData.csv'
df = pd.read_csv(file_path)

# Fit label encoders
label_encoder_gender.fit(df['PERFORMANCE'])

# Endpoint for batch prediction
@app.route('/batchpredict', methods=['POST'])
def batch_predict():
    if model is None:
        return jsonify({'error': 'Model not loaded!'}), 500
    if model1 is None:
        return jsonify({'error': 'Model for Category 1 not loaded!'}), 500
    if model2 is None:
        return jsonify({'error': 'Model for Category 2 not loaded!'}), 500
    if model3 is None:
        return jsonify({'error': 'Model for Category 3 not loaded!'}), 500
    if model4 is None:
        return jsonify({'error': 'Model for Category 4 not loaded!'}), 500

    try:
         # Check if a file is in the request
        if 'file' not in request.files:
            return jsonify({'error': 'File is required'}), 400

        # Read the file from the request
        file = request.files['file']
        df_input = pd.read_csv(file)

        # Check if all required fields are present in the input data
        required_fields = [
            'ECE 111', 'ECE 112', 'ECE 114', 'ECE 121', 'ECE 122', 'ECE 131', 
            'ECE 132', 'ECE 133', 'ECE 141', 'ECE 143', 'ECE 142', 'ECE 146', 
            'ECE 152', 'ECE 153', 'ECE 156', 'ECE 151', 'ECE 154', 'ECE 158', 
            'ECE 155', 'ECE 162', 'ECE 160', 'ECE 163', 'ECE 164', 'ECE 166', 
            'ECE 167', 'ECE 168', 'ECE 202'
        ]

        if not all(field in df_input.columns for field in required_fields):
            return jsonify({'error': 'Missing required fields'}), 400

        # Standardize the numerical features
        columns_to_standardize = [
            'ECE 111', 'ECE 112', 'ECE 114', 'ECE 121', 'ECE 122', 'ECE 131', 
            'ECE 132', 'ECE 133', 'ECE 141', 'ECE 143', 'ECE 142', 'ECE 146', 
            'ECE 152', 'ECE 153', 'ECE 156', 'ECE 151', 'ECE 154', 'ECE 158', 
            'ECE 155', 'ECE 162', 'ECE 160', 'ECE 163', 'ECE 164', 'ECE 166', 
            'ECE 167', 'ECE 168', 'ECE 202'
        ]

        df_input[columns_to_standardize] = scaler.transform(df_input[columns_to_standardize])

        # Make predictions for new data
        predictions = model.predict(df_input[required_fields])
        predictions1 = model1.predict(df_input[required_fields])
        predictions2 = model2.predict(df_input[required_fields])
        predictions3 = model3.predict(df_input[required_fields])
        predictions4 = model4.predict(df_input[required_fields])

        # Mapping numeric labels to categories (assuming binary classification: 0 - Fail, 1 - Pass)
        df_input['SUB1'] = ['High' if pred == 1 else 'Low' for pred in predictions1]
        df_input['SUB2'] = ['High' if pred == 1 else 'Low' for pred in predictions2]
        df_input['SUB3'] = ['High' if pred == 1 else 'Low' for pred in predictions3]
        df_input['SUB4'] = ['High' if pred == 1 else 'Low' for pred in predictions4]
        df_input['PERFORMANCE'] = ['High' if pred == 1 else 'Low' for pred in predictions]
        df_input[columns_to_standardize] = scaler.inverse_transform(df_input[columns_to_standardize])
        df_input.rename(columns={'PERFORMANCE':'EXPECTED PERFORMANCE'}, inplace=True)
        # Convert DataFrame to CSV in-memory
        output = StringIO()
        df_input.to_csv(output, index=False)
        output.seek(0)

        # Send as a downloadable file
        response = make_response(output.getvalue())
        response.headers['Content-Disposition'] = 'attachment; filename=predictions.csv'
        response.headers['Content-Type'] = 'text/csv'

        return response
    except Exception as e:
        app.logger.error("Prediction error: %s", e)
        return jsonify({'error': f'Prediction error: {e}'}), 400
    
# Endpoint to check for missing files
@app.route('/check-missing-files', methods=['POST'])
def check_missing_files():
    current_files = request.json.get('current_files', [])
    training_data_dir = 'TrainingData'
    existing_files = os.listdir(training_data_dir)
    
    # Determine missing files
    missing_files = [file for file in existing_files if file not in current_files]
    
    return jsonify({'missing_files': missing_files})

# Endpoint to download a specific file
@app.route('/download/<filename>', methods=['GET'])
def download_file(filename):
    training_data_dir = 'TrainingData'
    file_path = os.path.join(training_data_dir, filename)
    
    if os.path.exists(file_path):
        return send_file(file_path, as_attachment=True)
    else:
        return jsonify({'error': 'File not found'}), 404
    
# New endpoint to delete a file
@app.route('/delete-file', methods=['POST'])
def delete_file():
    # Path to your TrainingData directory
    TrainingDataPath = 'TrainingData'
    data = request.get_json()
    file_name = data.get('file_name')

    # Verify file_name is provided
    if not file_name:
        return jsonify({'status': 'error', 'message': 'No file name provided.'}), 400

    # Construct the full path to the file
    file_path = os.path.join(TrainingDataPath, file_name)

    # Check if the file exists
    if os.path.exists(file_path):
        try:
            # Delete the file
            os.remove(file_path)
            return jsonify({'status': 'success', 'message': 'File deleted successfully.'}), 200
        except Exception as e:
            return jsonify({'status': 'error', 'message': f'Error deleting file: {str(e)}'}), 500
    else:
        return jsonify({'status': 'error', 'message': 'File not found.'}), 404
    
@app.route('/upload-file', methods=['POST'])
def upload_file():
    # Path to your TrainingData directory
    TrainingDataPath = 'TrainingData'

    # Check if file part is in the request
    if 'file' not in request.files:
        return jsonify({'status': 'error', 'message': 'No file part in the request'}), 400

    file = request.files['file']

    # Check if a file was uploaded
    if file.filename == '':
        return jsonify({'status': 'error', 'message': 'No selected file'}), 400

    # Ensure the TrainingData directory exists
    os.makedirs(TrainingDataPath, exist_ok=True)

    # Save the file to the TrainingData directory
    file_path = os.path.join(TrainingDataPath, file.filename)
    file.save(file_path)

    return jsonify({'status': 'success', 'message': 'File uploaded successfully'}), 200

# Endpoint for individual prediction
@app.route('/individualpredict', methods=['POST'])
def individual_predict():
    if model is None:
        return jsonify({'error': 'Model not loaded!'}), 500
    if model1 is None:
        return jsonify({'error': 'Model for Category 1 not loaded!'}), 500
    if model2 is None:
        return jsonify({'error': 'Model for Category 2 not loaded!'}), 500
    if model3 is None:
        return jsonify({'error': 'Model for Category 3 not loaded!'}), 500
    if model4 is None:
        return jsonify({'error': 'Model for Category 4 not loaded!'}), 500

    try:
        # Ensure JSON input is provided
        if not request.is_json:
            return jsonify({'error': 'JSON input is required'}), 400

        # Parse JSON input
        input_data = request.get_json()
        df_input = pd.DataFrame([input_data])

        # Required fields
        required_fields = [
            'ECE 111', 'ECE 112', 'ECE 114', 'ECE 121', 'ECE 122', 'ECE 131', 
            'ECE 132', 'ECE 133', 'ECE 141', 'ECE 143', 'ECE 142', 'ECE 146', 
            'ECE 152', 'ECE 153', 'ECE 156', 'ECE 151', 'ECE 154', 'ECE 158', 
            'ECE 155', 'ECE 162', 'ECE 160', 'ECE 163', 'ECE 164', 'ECE 166', 
            'ECE 167', 'ECE 168', 'ECE 202'
        ]

        # Check if all required fields are present
        if not all(field in df_input.columns for field in required_fields):
            return jsonify({'error': 'Missing required fields'}), 400

        # Standardize the numerical features
        columns_to_standardize = required_fields
        df_input[columns_to_standardize] = scaler.transform(df_input[columns_to_standardize])

        # Make predictions for new data
        predictions = model.predict(df_input[required_fields])
        predictions1 = model1.predict(df_input[required_fields])
        predictions2 = model2.predict(df_input[required_fields])
        predictions3 = model3.predict(df_input[required_fields])
        predictions4 = model4.predict(df_input[required_fields])

        # Mapping numeric labels to categories (assuming binary classification: 0 - Fail, 1 - Pass)
        result = {
            'SUB1': 'High' if predictions1[0] == 1 else 'Low',
            'SUB2': 'High' if predictions2[0] == 1 else 'Low',
            'SUB3': 'High' if predictions3[0] == 1 else 'Low',
            'SUB4': 'High' if predictions4[0] == 1 else 'Low',
            'PERFORMANCE': 'High' if predictions[0] == 1 else 'Low'
        }

        return jsonify(result)

    except Exception as e:
        app.logger.error("Prediction error: %s", e)
        return jsonify({'error': f'Prediction error: {e}'}), 400
    
# Reload model endpoint
@app.route('/reload-model', methods=['POST'])
def reload_model():
    global model
    try:
        # Reload the model by running the code in prcode.py
        exec(open("prcode.py").read())
        exec(open("sub1.py").read())
        exec(open("sub2.py").read())
        exec(open("sub3.py").read())
        exec(open("sub4.py").read())
        return jsonify({'status': 'success', 'message': 'Model reloaded successfully'}), 200
    except Exception as e:
        return jsonify({'status': 'error', 'message': f'Failed to reload model: {str(e)}'}), 500

# Route for the root URL
@app.route('/')
def index():
    return 'Welcome to the Licensure Exam Prediction API!'

if __name__ == '__main__':
    app.run(debug=True)
