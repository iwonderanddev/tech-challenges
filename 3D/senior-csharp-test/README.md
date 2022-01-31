# IWD C# developer challenge

## Setup

Unity3D 2020.3 LTS ( https://download.unity3d.com/download_unity/9b9180224418/UnityDownloadAssistant-2020.3.25f1.exe ) and a C# editor such as Visual Studio

## Guidelines

We would like to test your ability to understand existing code, as well as your capacity of either implementing unit tests or learning how to do it. \
Our tests are implemented using Moq and NUnit, you have all the necessary includes and assembly definitions provided. 

## Content

We have provided a small module that allow to add/remove/retrieve files from a cache. \
The main class is FileCacheStorage, and is the class we want you to unit test. \
We have provided the FileCacheStorageTest file to get you started, so all you need to do is write your test functions inside. \
The naming convention we usually follow for unit tests is `MyFunction_DoesThis_When_SomethingHappens`, allowing to clarify the intent of the test. \
The tests should run in Unity's Test Runner.
