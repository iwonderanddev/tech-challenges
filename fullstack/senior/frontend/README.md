# IWD senior *fullstack* challenge frontend part

## Setup

To avoid losing time, you will use a simple create-react-app bootstrap.

```bash
cd fullstack/senior/frontend
yarn global add create-react-app
cd ..
create-react-app frontend
cd frontend
yarn start
#This will open your browser to http://localhost:3000
```

## Guidelines

We want to see your skills to design business code to produce **efficient** and
**maintainable** code over time.

DO
* Do use good design
* Follow reactjs best pratices
* Do maintainable design
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

> For the backend data endpoints, use `http://localhost:8080` in your frontend code

A customer wants us to create an application to display the aggregated answers
for the `XX2` survey only. So the app will use the API built in the backend part
to request the aggregated data for that survey (so for now, the code can be
hardcoded even if a ability to display others surveys is on the roadmap).

> Reminder: for now there are only 2 types of question, but new ones are
> expected to be added in the system very soon.

You can display the data the way you want, be creative (data visualization).
