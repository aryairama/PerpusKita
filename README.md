## PerpusKIta v.1.0
Perpuskita is a website-based UAS Semester 1 result application that functions as a manager of borrowing and returning books, for now the features are:
### v.1.0
- crud users
- crud book
- crud category
- crud borrow a book
- crud Book returns
- excel recap loan and book repayment
### v.1.1 (coming soon)
- book borrowing fines
- library absences
- and others
### Demo
- demo : https://perpuskita.arya-profile.tk
- email  :  adminpkk@perpus.com
- password  : adminpkk
- apologize if the website load speed is slow, due to using free hosting.
## Install PerpusKita
### Clone GItlab repo
> git clone https://gitlab.com/arya_iw/perpuskita.git

### Cd into your project
> cd perpuskita

### Install Composer Dependencies
> composer install
### Install NPM Dependencies
>npm install

### Create a copy of your .env file
> cp .env.example .env

### Generate an app encryption key
>php artisan key:generate

### Create an empty database for our application
>Create an empty database for your project using the database tools you prefer (My favorite is [SequelPro](https://www.sequelpro.com/) for mac). In our example we created a database called “test”. Just create an empty database here, the exact steps will depend on your system setup

### In the .env file, add database information to allow Laravel to connect to the database
>We will want to allow Laravel to connect to the database that you just created in the previous step. To do this, we must add the connection credentials in the .env file and Laravel will handle the connection from there.

>In the .env file fill in the `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` options to match the credentials of the database you just created. This will allow us to run migrations and seed the database in the next step.

### Migrate the database
>php artisan migrate
>
### Seed the database
>php artisan db:seed
