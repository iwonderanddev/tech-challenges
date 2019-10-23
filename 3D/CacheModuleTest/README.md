# IWD C# developer challenge

## Setup

Unity3D 2018 and a C# editor.

## Guidelines

We would like to test your ability to understand existing code, as well as your capacity of either implementing unit tests or learning how to do it. 
Our tests are implemented using Zenject and NUnit, you have all the necessary includes and assembly definitions provided. 

## Content

We have provided a small module that implements saving files to a cache, and retrieving them. 
The main class is FileCacheStorage, and this is the one we want to test. 
We have provided the FileCacheStorageTest file and The test functions already exist inside, so what we would like you to do is to implement them.

What we aim at is unit testing rather than integration or end-to-end tests. So logically basic understanding of what the module does should suffise. 

At the top of the file there are some keywords to get you started. 
FYI to run the tests in Unity, you need to go to Window->General->Test Runner, and switch to the "Play mode" tests (toggle at the top)

## Bonus 

If you find that a functionality of the module is not unit-tested, you can add the missing test(s).