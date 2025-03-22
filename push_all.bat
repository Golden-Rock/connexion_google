@echo off
echo Début du script...
echo Pushing to origin...
git push origin main
if %errorlevel% neq 0 (
    echo Erreur lors du push vers origin.
    pause
    exit /b
)
echo Pushing to origin2...
git push golden_rock main
if %errorlevel% neq 0 (
    echo Erreur lors du push vers origin2.
    pause
    exit /b
)
echo Push réussi vers les deux remotes !
pause