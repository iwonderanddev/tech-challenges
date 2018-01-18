# Proposal

Write here you proposal of the [asked architecture](README.md).
## Bare metal platform VS Cloud platform
I privilege cloud platform to bare metal ones, for the uniq reason that hardware is managed by the cloud provider and it represents  a non negligeable cost, in addition to hardware evelution and upgrade.
With cloud provider, i'm sure to use last generation of the hardware.

In my proposal, i'm basing my solution on **AWS cloud** and all my design will use the resources that **AWS** provides us.

## Elements to take in consideration
### Plan of Activity Continuity
- scalability to overtake the eventual load that the app will face.
- Reduce SPOFS or eliminate them
### Plan Activity Recovery
 - Backups
 - Disatser recovery
 ### Platform provisioning and deployements pipelines
 - Need to be provision my platform (PaaC)
 
 ## How i see this architecture
 We are here in a multitier application
 - Static HTML front
 - A PHP Backend
 - and a Mysql database
 
 Each part of our application represents a SPOF, our application will not work if one these three parts is unavailable.
 
 ### Front-end
 As our front is a static HTML, so a CDN is the best solution for us, because this will improve the user experience as the contents will be downloaded (viewed) quickly by our users (visitors).
 And CDN allows as the hace our front available in different geographical regions without needing to purchase any hardward.
 If we should AWS, CloudFront is our solution. It manages the cache and versions of the app efficiently.
 
 ### Back-end
 There are many solutions to design a solution for our back, one of them is to use 
 1. an **E**lastic **L**oad **B**alance (**ELB**) in front of my backend servers. This ELB will be available in one region and all availability zones.
 This will guarantee that my ELB still always available (The only worst case is when a region is down ??? **SPOF**)
 We can improve this by using another ELB in an other region and creating a **route53** DNS entry (**CNAME**) that points to my two ELBs.
 2. Attached to each ELB, three **E**lactic **C**loud **C**ompute (**EC2**) instances, each one in an availibilty zone.As AWS has three availability zone on each Region. this guarantee the availability of the service on that region.
 3. Implement the scalibilty of the Backend:
    - On each region, i'll create lauch configuration and an autoscaling group that will absorb the overload that my app will eventually face.
    - Conditions of upscaling or downlscaling will be defined according to the banchmark that will be done on backend (how many requests it can handle per minutes without crashing the resources. TO BE DEFINED)
    - Once the values will be known, we will create cloud watch events on the our ELBs that will scale our backend service.
    - for the downlscale, we will use CloudWatch Events to do that, if we observe number of request above a threshould, we will downscale our capicity.
    
 ### Database
 For the database service, I will use the service **R**elational **D**atabase **S**ervice (**RDS**), It's managed by AWS with the ability to taylor some parameters on mysql Server (**Parameter groups**). 
 The cons, there is no ssh access to the server, only sql access. we can't realy see system logs and other perfs related to the system. Sometime AWS schedules maintenance on the servers which, sometime, makes the resources unvailable for few minutes, so should have an architecture that is taking account about this.
 
 For the database resource, i'll use mysql Aurora RDS cluster. This will garantee that my data will be always available for my users (visitors). storage scalability, high availablility (multiple availibility zones).
 
 I think that we eliminate all SPOFs.
 
 ##
 Now,  we will talk aboiut tooling (monitoring, platform management and deployment tools)
 
 
 
 
 
 
 
 
