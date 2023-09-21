@echo off
setlocal enabledelayedexpansion

set SOURCE_DIR=%~dp0
set DESTINATION_DIR=%~dp0

for /f "tokens=1,2 delims=:::::" %%a in (publish.txt) do (
    set "SOURCE_PATH=!SOURCE_DIR!\%%a"
    set "DESTINATION_PATH=!DESTINATION_DIR!\%%b"

    robocopy "!SOURCE_PATH!" "!DESTINATION_PATH!"
)

echo Files and folders copied successfully.
pause
