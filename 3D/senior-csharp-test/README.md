# IWD C# developer challenge

## Setup

Unity3D 2018.3.12 ( https://download.unity3d.com/download_unity/8afd630d1f5b/Windows64EditorInstaller/UnitySetup64-2018.3.12f1.exe ) and a C# editor such as Visual Studio

## Guidelines

We would like to test your ability to understand existing code, as well as your capacity of either implementing unit tests or learning how to do it. 
Our tests are implemented using Zenject and NUnit, you have all the necessary includes and assembly definitions provided. 

## Content

We have provided a small module that implements saving files to a cache, and retrieving them. 
The main class is FileCacheStorage, and this is the one we want to test. 
We have provided the FileCacheStorageTest file to get you started, so all you need to do is write your test functions inside. 
At the top of the file there are also some keywords to get you started.

We aim at unit testing rather than integration or end-to-end tests.
The naming convention we usually follow for unit tests is `MyFunction_DoThis_When_SomethingHappens`, allowing to clarify the intent of the test.

The tests should run in Unity's Test Runner ( open Window->General->Test Runner, and switch to the "Play mode" tests  via the toggle at the top )
