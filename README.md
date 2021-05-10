# need following step for project setup

"laravel/lumen-framework": "^7.0"

-> Before using Lumen, make sure you have Composer and PHP >= 7.3 installed on your machine.
-> Download the zip file from git and extract that zip file inside xampp/htocs
-> After that need to update composer.
-> You should rename the .env.example file to .env
-> Inside .env file do the following changes
     APP_KEY=base64:8Mz8LdcOZ6OaJvon5KhmuBahVjmlrici1IDKmKNXm3M=
     APP_URL=http://localhost/test


     DB_CONNECTION=mysql
	 DB_HOST=localhost
     DB_PORT=3306
     DB_DATABASE=testing
     DB_USERNAME=Your Database Username
     DB_PASSWORD="Your Database Password"
     
     JWT_SECRET=YTCzV4Roj2vfSjtcJ7JfVEIi1IM4KF9sRSIy50QPGZaclN3kxcrrE4ut0NLHp8qa
  -> Import the given test.sql file in MySql    