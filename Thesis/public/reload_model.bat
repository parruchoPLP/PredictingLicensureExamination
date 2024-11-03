@echo off
cd ThesisPredictiveModel

if exist venv\Scripts\activate (
    call venv\Scripts\activate
    python prcode.py
    python sub1.py
    python sub2.py
    python sub3.py
    python sub4.py
    exit /b 0
) else (
    py prcode.py
    python sub1.py
    python sub2.py
    python sub3.py
    python sub4.py
    exit /b 0
)