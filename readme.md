# Q/A app made with Laravel and the Artisan Console

![](https://github.com/edermariano/artisan-qa/workflows/StuDocu%20Tests/badge.svg?branch=master)
[Builds](https://github.com/edermariano/artisan-qa/actions)

### Requirements:
 - Docker
 - docker-compose
 - Make
 
### Instuctions to run:
 - download de repository _(git clone...)_
 - create your `.env` file based on `.env.example`
 - `make up` to up the containers
 - `make run-tests` to run the automated tests
 - `make studocu` to run the command
 - `make reset-progress` to erase the progress
 - `make clean` to stop and remove docker containers and studocu image

<details>
<summary>Changelog</summary>

### Changelog
> - Dependecies Updates
> - Laravel 6
> - PHPUnit 8
> - pcov (test code coverage)
> - Make
> - Docker + docker-compose
> - Postgres + sqlite (for tests) 
> - GitHub Actions each push the CI will run the pipeline:tests 
> - > source, dependecies installation, tests 
> 
</details>

<details>
<summary>Requirements</summary>
The purpose of the exercise is to see how comfortable you are with a Laravel based interactive console app. We have done a bit of work for you. If you fork this project, run `composer install`, and then run `php artisan qanda:interactive`, the command will be started. In this command, create an event loop and implement the following features:

- The initial interaction should allow you to choose between adding questions and answers and viewing previously entered answers.

### Creating Questions
- Upon choosing the option to add a question, the user will be prompted to give a question and the answer to that question.
- Upon giving a question and answer, this must be stored in the database. Use migrations to create the DB tables.

### Practising Questions
- Upon choosing to view the questions, the user will be prompted to choose from the previously given questions which one he wants to practice.
- Upon choosing to practice a question, the user must fill in the right answer for the question, which will be checked against the previously given answer.
- Upon answering a question, the user is returned to the list of all questions, and sees his progress for each question.
- Upon completing all questions, an overview of the users final progress is given.

### Extra
- Every step must have an option to go back one step.
- Use the DB, and use laravel best practices to approach it.
- Allow the user to exit the interactive console with an option at every point.

### I really want this job
- Make a new console command to be run with `php artisan qanda:reset` that removes all previous progresses.
- Write (a) unit test(s).
</details>
