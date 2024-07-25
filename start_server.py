import os
import subprocess
import sys

def run_command(command):
    process = subprocess.Popen(command, shell=True)
    return process

def main():
    # Get the current working directory (the root of the project)
    root_dir = os.getcwd()
    print(f"Root directory: {root_dir}")

    # Define relative paths to the model and laravel directories
    model_dir = os.path.join(root_dir, "ThesisPredictiveModel")
    laravel_dir = os.path.join(root_dir, "Thesis")
    venv_dir = os.path.join(model_dir, "venv")

    # Ensure directories exist
    if not os.path.exists(model_dir):
        sys.exit("Error: ThesisPredictiveModel directory not found.")
    if not os.path.exists(laravel_dir):
        sys.exit("Error: Thesis directory not found.")

    # Activate virtual environment
    activate_script = os.path.join(venv_dir, "Scripts", "activate") if os.name == "nt" else os.path.join(venv_dir, "bin", "activate")
    activate_command = f"source {activate_script}" if os.name != "nt" else activate_script

    # Change directory to Laravel project and start npm and Laravel servers
    os.chdir(laravel_dir)
    print("Starting npm server...")
    npm_process = run_command("npm run dev")
    
    print("Starting Laravel server...")
    
    laravel_process = run_command("php artisan serve")

    # Change directory back to the Python project and start Flask server
    os.chdir(model_dir)
    print("Starting Flask server...")
    flask_command = f"{activate_command} && python app.py"
    flask_process = run_command(flask_command)

    print("All servers started successfully.")

    # Wait for the processes to complete
    npm_process.wait()
    laravel_process.wait()
    flask_process.wait()

if __name__ == "__main__":
    main()