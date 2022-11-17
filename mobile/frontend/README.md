# IWD mobile frontend challenge

## The challenge

The app is supposed to display a list of surveys and the aggregated answers to
those.

### Stage 1

Display a simple list of all the surveys.

### Stage 2

For each survey, display the aggregated answers of each question.

Here's how to aggregate answers by question type:
- **Numeric**: the average of the answers
- **Date**: a list of all dates that have been answered
- **Multiple choice question**: the number of times each option was selected in the answers

You can display the data the way you want (directly in the list, in a dedicated screen...), 
as long as the UI is intuitive for the user.

## Guidelines

We want to see your skills to design business code to produce **efficient** and **maintainable** code over time.

DO:

- Follow React best practices (hooks, functional components...)
- Architecture your code (split code and logic)
- Using packages from the NPM registry is allowed
- [Optional] Use Typescript
- [Optional] Write some unit tests on what you think is critical

DON'T DO:

- Do not lose time on build process, focus on the app itself
- Do not use Docker, Vagrant... we must be able to run the app only with `yarn android` and `yarn ios`
- Do not lose time with amazing styling, animations, navigation... be basic

## Domain

A survey is composed of a name and a unique ID. For a given survey, questions
and answers are available. Questions are not mandatory, so the amount of answers
per question may vary.

There are 3 types of questions:

- Numeric
- Date
- Multiple choice question (MCQ)

For each type of question, the answer has a different format:

- **Numeric**: a number
- **Date**: a date in format ISO 8601
- **Multiple choice question**: a list of the selection state of each choice

## Setup

### Create a new project

To avoid losing time, you will use a simple create-react-native-app bootstrap.

First, be sure to have `npx` and `yarn` installed.

Then, create the app:

```bash
# If you know typescript
npx create-react-native-app app -t with-typescript

# If you don't know typescript
npx create-react-native-app app
```

*☝️ when asked, choose `Default new app`.*

Once done, remove the git repository:

```shell
cd app/
rm -rf .git
```

Finally, start the app:

```
yarn start
```

You can open the app in an emulator (if you have Xcode / Android Studio installed) or on a real device via the `Expo Go` app (available on both App Store and Play Store).

### API mock

You will get the data via a REST API implementing these endpoints:
- `GET /api/surveys`
- `GET /api/survey/1`
- `GET /api/survey/2`
- `GET /api/survey/3`

We provide a way to mock HTTP requests on those endpoints within the app.

In your newly created project:

1. Install the package `miragejs`
   ```shell
   yarn add --dev miragejs
   ```
2. Copy the file `apiMock.js`
3. Import it in the project root file:
   ```js
   import 'apiMock';
   ```

You should now be able to make HTTP requests on the endpoints listed above.

Good luck!
