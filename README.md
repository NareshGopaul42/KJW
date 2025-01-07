# King's Jewellery World Inventory Management

## About

King's Jewellery World Inventory Management is a web application designed to manage the inventory of materials and products for King's Jewellery World. This application is built using the Laravel framework and provides features such as material receipts management, inventory tracking, and more.

## Features

- Material Receipts Management
- Inventory Tracking
- User Authentication
- Responsive Design

## Requirements

- PHP ^8.2
- Composer
- Node.js & npm

## Installation

1. Unzip the file submission:

    ALL libraries should already be in the project folder
    This may be unconventional but I just zipped everything to make it easier for 
    you and my setup instructions much shorter.
  

2. Install PHP dependencies:
    ```sh
    composer install
    ```

3. Install JavaScript dependencies:
    ```sh
    npm install
    ```

5. Generate an application key:
    ```sh
    php artisan key:generate
    ```


6. Set up SSL Certificate** (required for database connection):
   ```powershell
   php setup-ssl.php
   ```

The SSL key is to connect to the remote database

6. Database:
   I used a website(SUPABASE.COM) to host my database and share the credentials to the team for everyone to work with a single db

    Below are the credentails to sign in

    Remote Database login

    User email: nareshgopaul682@gmail.com
    Password: Ethere@l@8824

    https://supabase.com/dashboard/sign-in 

    Table views: https://supabase.com/dashboard/project/hqnpzwiyxehxtridriit/editor/29625?schema=public
    

7. Build the front-end assets:
    ```sh
    npm run build
    ```

## Usage

To start the development server, run:

php artisan serve 

and then

npm run dev

Then type this url in your browser:
```
http://localhost:8000/

```


Enjoy exploring what existing components our project has, cheers!
- Naresh Gopaul
USI#1040391