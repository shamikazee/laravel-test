
## About The Project

This is a recruitment test in a web development company "DEVINWEB" for a backend developer post (PHP/LARAVEL)

## Installation

- First of all you need to install Laravel you can follow the **[Documentation](https://laravel.com/docs/6.x#installation)**

- After installing laravel you need to get a copy of the project on your computer using the following command:
    ```
    git clone https://github.com/shamikazee/laravel-test.git/ projectName
    ```
    
- After getting inside the project folder using `cd projectName` you will install the composer and npm cependencies using :

    ```
    composer install
    npm install
    ```
    
 - Create a copy of your .env file and generate an app encryption key using :
 
    ```
    cp .env.example .env
    php artisan key:generate
    ```
     - Create a database and configure it in the .env and confih/database.php .


 ## Usage
 
 Now everything is ready lets get started in the RULES.
 
 - Using migration to create the schema :
 
    ```
    php artisan migrate
    ```
    
  - Creating 15 categories using seeder:
  
    ```
    php artisan db:seed
    ```
    
  - The CRUD endpoints follows `docs responses` structure :

    
 All the other rules are done.
 
 To the next section :
 
   - The categories responses are multi-language in Category and Course Controllers you will find a variable `public $local='en';` you can change from `'en'` to `'fr'` to get the responses in french.
   
   - Observers : in the `App\Providers\AppServiceProvider` exactly the `boot` function there is few commented lines try to uncomment them, it's an observer for indexing categories so when the indexing endpoint is called a `dd('indexed')` is shown.
   
   - Morph map is done.
   
   - We can test on `GET:'/categories'` to check the Json structure , you can the change the testing structure in `Tests\Feature\CategoryTest.php` . to test it use:
   
  ```
  vendor/bin/phpunit --filter testing_category_indexed_format
  ```
   
   Thank you.
