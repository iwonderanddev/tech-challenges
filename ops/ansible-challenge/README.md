# ANSIBLE TEST

## PURPOSE

The purpose of this test is to deploy a Wordpress site. This software has been chosen since its install is simple. The application must work after the process (no install steps to do manually).

## TIME TO COMPLETE

This test is designed to be done in 2 to 3 hours but you will have a few days to complete it.

## HOW TO SUBMIT THIS TEST PROPOSAL

Fork this repository in your own Github account and provide us with the URL.

## DESCRIPTION

The application will go on a virtual machine and the database on another virtual machine.

![](ansible-challenge.png)

Everything must be automated. Ideally, in just one script you will:

* Create the VMs
* Provision them (webserver, database...) - with Ansible
* Deploy Wordpress - with Ansible
* Install Wordpress - with Ansible

Software:
* VirtualBox for the VMs (or any other Virtualization software you are comfortable with)
* Distribution: Debian/Ubuntu (alternatively you can use Redhat-based distrib)
* Webserver: apache or nginx
* Database: MySQL

Notes:

* COMMENT your code ! It must be easy for a reviewer to understand what you did.
* Even if this project is small, use all the software best practices. Consider this project as a base which may grow.
* If, for any reason, you do not comply with some of the constraints, this will not be eliminatory. We will assess your adaptation skills. Explain why you cannot or won’t do some things.
* You are welcome to use any existing module that already exists. Do not reinvent the wheel.
