# IWD ops challenge

## The application

You are working as a sysadmin in a new company. This company is about to release a new blog, via a blogging application developped internally.

This application is multi-tier:

* A front-end built in static HTML
* A backend built in PHP
* A MySQL storage

![diagram](diagram.png)

There is no fancy requirements.

## Objectives

You have to make a proposal of an architecture which host this application by editing the file [proposal](proposal.md) in this very repository.

The application should be available on the Internet, the objective here is to reduce [SPOFs](https://en.wikipedia.org/wiki/Single_point_of_failure) and secure the application. The number of users is currently small but the application should be able to scale if need be. There is no need to automate this at the moment. You are the person who should know if the hardware should evolve, so you need tools for this.

Your solution must also deal with backups and Disaster Recovery Plan.

There is no good or wrong answers. Deal with the technology you already know.

Name softwares / tools / providers and how you plan to integrate them in your architecture. We expect you to explain your choices, the pros, the cons, and what are the limitations of the technology you chose.

If changes has to be made directly in the code of the application, note your advises for the fictional dev team.

Do not hesitate to illustrate your proposal with graphs.
