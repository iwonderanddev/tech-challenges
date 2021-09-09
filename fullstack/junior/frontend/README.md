# IWD junior _fullstack_ challenge frontend part

## Setup

To avoid losing time, you will use a simple create-react-app bootstrap.

```bash
cd fullstack/senior
npx create-react-app frontend
# or use TypeScript if you prefer
# npx create-react-app frontend --template typescript
cd frontend
yarn start
#This will open your browser to http://localhost:3000
```

## Guidelines

We want to see your skills to design business code to produce **efficient** and **maintenable** code over time.

DO

- Do use good design
- Follow reactjs best pratices: use hooks, functionnal components...
- Do maintenable design
- Do use unit tests
- Do use dependency management
- Do use consistent code styles
- Do use others dependencies if you want/need

> Some candidates had some issues with momentjs and create-react-app, avoid it

DON'T DO

- Do not loose time with build process, just use create-react-app `yarn start`
- Do not use Docker, Vagrant... we must be able to run the app only with `yarn start`
- Do not loose time with amazing CSS, be basic

## The Test

> For the backend data endpoints, use `http://localhost:8080` in your frontend code

Show a list of the surveys coming from the endpoint you have done in backend test

Result will be a simple list:

| Name     | Code |
| -------- | ---- |
| Paris    | XX1  |
| Chartres | XX2  |
| Melun    | XX3  |
