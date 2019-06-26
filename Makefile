css:
	nodemon -w scss/ -x "sass scss/main.scss static/css/main.css -s compressed" -e ".scss"

push:
	git checkout master && git merge develop && make update-tag

update-tag:
	git tag -d latest && git push --delete origin "latest" && git tag -a "latest" -m "latest production" && git push --tags
