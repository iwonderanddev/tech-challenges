# Proposal

Write here you proposal of the [asked architecture](README.md).
## Bare metal platform VS Cloud platform
I privilege cloud platform to bare metal ones, for the uniq reason that hardware is managed by the cloud provider and it represents  a non negligeable cost, in addition to hardware evolution, upgrade and failures.
With cloud provider, i'm sure to use last generation of the hardware.

In my proposal, i'm basing my solution on **AWS cloud** and all my design will use the resources that **AWS** provides us.

## Elements to take in consideration
### Plan of Activity Continuity
- scalability to overtake the eventual load that the app will face.
- Reduce SPOFS or eliminate them
### Plan Activity Recovery
 - Backups
 - Disatser recovery: 
 -- For Data, RDS proposes snapshoting which guarantee the availability of my data for an eventual restore.
 -- For infrastructure and apps, all this stuff will be managed and veriosionned, provisioning and deployemnt will be fully automated.
 ### Platform provisioning and deployements pipelines
 - Need to be provision my platform  as a code (PaaC), this reduce the time to build and update of the infrastructure
 
 ## How i see this architecture
 We are here in a multitier application
 - Static HTML front with a CDN for assets
 - A PHP Backend
 - and a Mysql database and a Caching server.
 
 Each part of our application represents a SPOF.
 
 ### Front-end
 As our front is a static HTML, so a CDN is the best solution for us to diserve assets, because this will improve the user experience as the contents will be downloaded (viewed) quickly by them (visitors).
 AWS propose a service called CloudFront, which manages the cache and versions of the assets efficiently.
 For our Font-end app, we will use an **E**lastic **L**oad **B**alance (**ELB**) in front of my web servers to deliver to content. The ELB will be available on all Availability zones of that regions. On each region, we will put one **E**lactic **C**loud **C**ompute (**EC2**) instance. 
 I'll also define an autoscaling group on that region (all availability zones), to face any future load. 
 
 ### Back-end
 There are many solutions to design a solution for our backend, one of them is to use 
 1. an **E**lastic **L**oad **B**alance (**ELB**) in front of my backend servers. This ELB will be available in one region and all availability zones.
 This will guarantee that my ELB still always available (The only worst case is when a region is down ??? **SPOF**)
 We can improve this by using another ELB in an other region and creating a **route53** DNS entry (**CNAME**) that points to my Backend ELBs.
 2. Attached to each ELB, three **E**lactic **C**loud **C**ompute (**EC2**) instances, each one in an availibilty zone. As AWS has, mostely, three availability zones on each Region. This guarantee the availability of the service on that region.
 3. Implement the scalibilty of the Backend:
    - On each region, i'll create lauch configuration and an autoscaling group that will absorb the overload that my app will eventually face.
    - Conditions of upscaling or downlscaling will be defined according to the banchmark that will be done on backend (how many requests it can handle per minutes without crashing the resources. TO BE DEFINED)
    - Once the values will be known, we will create cloud watch events on our ELBs that will scale our backend service.
    - for the downlscale, we will use CloudWatch Events to do that, if we observe number of request above a threshould, we will downscale our capicity.
    
 ### Database
 For the database service, I will use the service **R**elational **D**atabase **S**ervice (**RDS**), It's managed by AWS with the ability to taylor some parameters on mysql (or Whatever database) Server (**Parameter groups**). 
 The cons, there is no ssh access to the server, only sql access. We can't realy see system logs and other perfs related to the system. Sometime AWS schedules maintenance on the servers which, often, makes the resources unvailable for few minutes, so should have an architecture that is taking account about this. 
 
 This service manages efficiently automatic backups as snapshots which are easly restored as RDS instances. in addition the these snapshots, we will save them on S3 buckets.
 
 For the database resource, i'll use mysql Aurora RDS cluster. This will garantee that my data will be always available for my users (visitors). storage scalability, high availablility (multiple availibility zones).
 
 I think that we convered all SPOFs that our app can have.
 
 ## Tooling
 ### Code
 I will host my code on github. I'll have 2 or three repositories for my app: Front, Backend The schema of database or scripts to create my database, this last also can be managed in backend repository (here i think espacially for rails apps).
 To manage my platform as a code, i need also to have another reporsitory for my platform.
 ### Tools
 - For my platform, i'll use terraform. It really a powerfull and rich tool to manage cloud infrastruture or other resources as a code. It is open source and the community is active and many providers are managed now by terraform. There is some limitations about fonctionnality on some providers. In case of terraform AWS provider, in existing platform, if we need to start to automatize it, we can't import some resources.
 
 Why wouldn't use CloudFormation, For the simple resaon, if i need someday to manage a part of my app on another cloud provider or just host it in my office, Terraform will be more felxible to my new case than cloudformation which only works with AWS resources.
 - For my code, as i'm mentionned the use of Github, we (the team) will use git.
 - Moniroting, Metrologie: In addition to cloudwatch, i'll put in place an ELK stack in order to collect app logs to extract metrics and plot them as graphs. Also Kibana is able to create diagrams, this will usefull to understand the behaviour of our app.
 - Deployment pipeline: CI/CD pipelines will be set. The CI pipeline, will be ensured by Travis CI for each **P**ull. Travis CI is already integrated to GitHub. **R**equest (**PR**). No PR mergeable if no at least two reviewers validated the code. The CD pipeline, can managed by jenkins, which will fire an instance on which we will have ansible or any orchestration tool to deploy code on our servers (Front-end and/or Backend). _Don't have skill to develop these section, Need to learn and improve them._
 - For Dev team, a process will be imposed even we are in agility. Each change should be reviewed by at least two collaborators,  the code coverage of the code should be around 95%, the **P**roduct **O**wener has the decision to deploy in production or not by validating the features.
 - The deployement will be done with Ansible, it's powerfull and agentless. This project has grown quickly and no need to install any additionnal software to use it (it's based on python). 
 Ansible uses yml to describe the task that will be performed. It's easy to learn.
 
 
 ## Disater Recovery
 In the worst case, we will loose all our infrastructure no front-end, no back-end and no database.
 The infra will be (re)created  with terraform (we can create our DB from a snapshot with terraform)
 With ansible we will deploy our code on each tier of our app (front-end and backend)
 
 ## Improvements
 ### Add a caching server 
 We can use the service Elasticache of AWS. We can integrate it easily with our architecture, the service is managed by AWS, so this will save us a time to work on other features.  The cons i can see, is the unavailibity of the server in case of an overhead.
 
## Architecture Design in the main Region
 
 <p align="center"><img src="IWD_test.png" /></p>
 
 
 
 
 
