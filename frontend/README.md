# IWD frontend challenge

## Setup

To avoid losing time, you will use a simple create-react-app bootstrap.

```bash
yarn global add create-react-app
cd ..
create-react-app frontend
cd frontend
yarn start
#This will open your browser to http://localhost:3000
```

## Guidelines

We want to see your skills to design business code to produce **efficient** and **maintenable** code over time.

DO
* Do use good design
* Follow reactjs best pratices
* Do maintenable design
* Do use unit tests
* Do use dependency management
* Do use consistent code styles
* Do use others dependencies if you want/need

> Some candidates had some issues with momentjs and create-react-app, avoid it

DON'T DO
* Do not loose time with build process, just use create-react-app `yarn start`
* Do not use Docker, Vagrant... we must be able to run the api only with `yarn start`
* Do not loose time with amazing CSS, be basic

## The Test

> For the backend data endpoints, use  `http://localhost:8080` in your frontend code

### Stage 1

Show a list of the surveys coming from the endpoint you have done in backend test (stage 1)

Result will be a simple list:

| Name  	|  Code	     |
|---        |---	     |
| Paris  	| XX1        |
| Chartres  | XX2        |
| Melun  	| XX3        |

### Stage 2

The user can now click on a survey item. It will show the aggregate data of this survey. The data is coming from the endpoint you have done in backend test (stage 2).

You can display the data the way you want, be creative (data visualization).

### Stage 3 (bonus)

> This is not mandatory, add this feature if you feel like it.

Add a search input on the survey list to filter surveys by names and/or code.
