@echo off
cd ThesisPredictiveModel

if exist venv\Scripts\activate (
    call venv\Scripts\activate
    python prcode.py
    exit /b 0
) else (
    py prcode.py
    exit /b 0
)