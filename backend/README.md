# IWD backend challenge

## Setup

To avoid losing time, we have setup a Silex boilerplate to handle HTTP request/response.

> The choice of Silex is arbitrary, we could have used Symfony, Laravel, whatever the frameworks... We are not interested in finding a master of frameworks, but a developer who knows how to code business rules so that they can be maintained over time.

```bash
cd backend
composer install
php -S localhost:8080 -t web web/index.php

#Go to http://localhost:8080, you will see "Status OK"
```

## Guidelines

We want to see your skills to design business code to produce **efficient** and **maintainable** code over time. This exercise might seem simple and some shortcuts can be used to develop these features quickly but we are more interested in how you might structure your code and classes if these features were to be just the **beginning of a larger project** destined to **evolve in time**.

DO
* Do use good design
* Do maintainable design
* Do use unit tests
* Do use dependency management
* Do use consistent code styles
* Do use others dependencies if you want/need it
* Follow PSR-x
* Show the Business in your code

DON'T DO
* Do not loose time with optimization
* Do not use Docker, Vagrant... we must be able to run the api only with the PHP server

## Data

The data folder contains some JSON files. Think of it as a database or any other persistence system.
This is a list of survey answers by a sales man.  
Different surveys are identified by the code (think of it as the id). Answers will be aggregated by survey code.

You have 3 kind of questions:
* qcm: the answer is an array of `true`/`false` (based on the `option` array)
* number: the answer is a `number`
* date: the answer is a `date`

## The Test

### Stage 1

Expose the surveys through an api endpoint for read purpose.

The API result must be:
```JSON
[{
    "name": "Paris",
    "code": "XX1"
},{
    "name": "Chartres",
    "code": "XX2"
},{
    "name": "Melun",
    "code": "XX3"
}]
```

The order of those entries is not important.

### Stage 2

Aggregate the answers by survey code, and expose it through an api endpoint.

The aggregation will be different depending on the question type:
* qcm: how much `Product 1`, how much `Product 2`...
* number: the **average** of all answers
* date: a list of `dates`

The API result is not defined, do what you want, be creative and data centric.
