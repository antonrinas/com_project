# Com.project

### Features

- add comments using pusher;
- saving comments in DB;
- Doctrine 2 is used;
- Vue.js and webpack are used; 
- emoji icons auto-replacement;
- based on my framework;
- all classes are covered by tests;
- event manager with pluggable observers (observers are registered automatically if it are exist in observer's DB table);

### Installation

- setup local server;
- clone repository https://github.com/antonrinas/com_project.git;
- all configs are placed in `config` folder (use `db_doctrine.php` for db settings);
- DB dump is in `db` folder;

### Make changes in build.js

- `$ npm install`
- all components are placed in `resources` folder
- `$ npm run-build`
- or
- `$ npm run-build-production`

### Run tests

- `$ .\vendor\bin\phpunit`
