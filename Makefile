watch-css:
	nodemon -w scss/ -x "sass scss/main.scss static/css/main.css -s compressed" -e ".scss"

css:
	sass scss/main.scss static/css/main.css -s compressed

production:
	git push && git checkout master && git merge develop && git push && make update-tag && git checkout develop

update-tag:
	git tag -d latest && git push --delete origin "latest" && git tag -a "latest" -m "latest production" && git push --tags
