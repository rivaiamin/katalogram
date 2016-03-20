#Katalogram - Client-side

##Developer Getting Strated
- Install Node.js https://nodejs.org/en/
- Download or clone the repository `git clone https://rivaiamin@bitbucket.org/katalogram/katalogram-client.git`
- Install NPM `npm install`
- Install Bower `bower install`
- Running gulp script `gulp`

##Running Application Locally
- Add virtual host for katalogram-client/dist http://katalogram.dev
- Add virtual host for katalogram-client/files http://files.katalogram.dev

##Developer Notes
- Edit source code in folder `src`
- for now, temporary using static json
- Add dependencies using `npm install dependency-name --save`
- Build source code using gulp command
-- `gulp imagemin` for optimize image
-- `gulp fontmin` for convert font
-- `gulp uglify` for compile javascript
-- `gulp cssmin` for compile css
-- `gulp htmlmin` for compile html
-- `gulp watch` for watch/synchronize modification
-- `gulp` for all