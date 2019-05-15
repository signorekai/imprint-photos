css:
	nodemon -w scss/ -x "sass scss/main.scss static/css/main.css -s compressed" -e ".scss"