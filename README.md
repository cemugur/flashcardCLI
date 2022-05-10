
# Command Line (CLI) Flashcard App

<p align="center">
<a href="https://php.net" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/1200px-PHP-logo.svg.png"  height="50"></a>
<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  height="50"></a>
<a href="https://mysql.com" target="_blank"><img src="https://i0.wp.com/www.elearningworld.org/wp-content/uploads/2019/04/MySQL.svg.png?fit=600%2C400&ssl=1" height="50"></a>
</p>


Interactive CLI program for Flashcard practice. 
Flashcards are small note cards used for testing and improving memory through practiced information retrieval. We will create our flashcards by using command line and then practice with them.

## Development environment
    
    Windows 10
    WSL
    Visual Studio Code
    Bash
    Docker

## Technologies

    PHP 8
    Laravel 9
    Mysql 
    Artisan
    Docker
    Laravel sail
    PhpUnit
    
## Methodology

    Simple approach to SOLID design principle

    Clean Code

    Service + Repository pattern

    Interfaces for repositories
    
    Traits: for common methods (validations, frequently used functions etc.) 

## How to run the project.

- Clone github repo 

    ```git clone https://github.com/cemugur/flashcardCLI```

- Enter the flashcard directory

    ```cd flashcardCLI```


- Run docker command to upload all dependencies

    ```docker run --rm --interactive --tty -v $(pwd):/app composer install```

- Run sail up

    ```./vendor/bin/sail up```

After this step, you should need to open a new terminal or you should send the process background by using CTRL + Z

- Modify .env file (set database, username, password)
- Migrate and seed database tables.

    ```./vendor/bin/sail artisan migrate:fresh --seed```

- Run command

    ``` ./vendor/bin/sail artisan flashcard:interactive```

- Enter test account email:  ```test@studocu.com ```
    
    If it needs, we can add password confirmation to login.

- Enter a menu ID (1-6)
    
    - ```1``` : You can create a flashcard
            
            Enter a question and its answer
            Validation rule: required and max 255 chars 


    - ```2``` : List all flashcard with their answers

    - ```3``` : Practice, try to guess answer of the questions (case insensitive)
            
            Select a question, enter its id then write your answer
            Validation rule: 
            Should select a not correctly answered question's id. 
            Answers should be not empty max chars 255

    - ```4``` : Display the practice stats

    - ```5``` : Erase all practice progress 

            Update all practice status to "Not answered" and delete all answers were given by a user

    - ```6``` : Exit from the app

- Test 

    ```./vendor/bin/sail test```

    You will run 13 tests with 104 assertions
    
<br>
<br>
<br>
<hr>

** if you already added "alias sail=’./vendor/bin/sail’" to your .bashrc, you can  use commands like 'sail ...' instead of './vendor/bin/sail ...'