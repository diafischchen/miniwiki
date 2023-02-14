# Miniwiki

An Open Source Wiki Solution for your Webserver

#### Features: 
- write Wiki Entries with Markdown Syntax
- no Database needed
- PWA Support
- mobile responsive, modern Design
- Download Wiki Files


## Docker Setup

1. Download this Repository as a ZIP File
2. Extract this Zip File somewhere on your Computer
3. Go into the miniwiki folder and open a command prompt in this folder
4. run this command to build the image
```sh
docker build . -t miniwiki:1.1.3
```
5. rename the file main.example.php to main.php
6. rename the file auth.example.php to auth.php
    - this file contains the login information. make sure this file is not accessable to the public
    - change the login information according to the comments in this file
7. run this command to run the image in a container. change "/local/path/to/miniwiki" to the actual local path of this repository
```sh
docker run -d --name miniwiki -p 2187:80 -v /local/path/to/miniwiki:/src miniwiki:1.1.3
```
8. open http://localhost:2187/ in your browser to access Miniwiki