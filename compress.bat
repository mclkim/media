@echo off
SET ZipPath="C:\Program Files\7-Zip\7zG.exe"
SET SourcePath="D:\phpdev\workspace\media"
SET BackupPath="D:\backup\media"
SET BackupFile="media-%date%.zip"
%ZipPath% a -tzip %BackupPath%\%BackupFile% %SourcePath%\*.php %SourcePath%\*.html %SourcePath%\*.js %SourcePath%\*.css %SourcePath%\*.xml -r
