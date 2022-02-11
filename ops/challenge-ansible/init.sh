#!/bin/bash   
    origin=$(pwd)
    export ANSIBLE_CONFIG=$PWD/ansible/ansible.cfg

    # VM Creation and installation
    cd ./ubuntu-web-server/ && vagrant up && cd $origin
    cd ./ubuntu-db-server/ && vagrant up && cd $origin

    #By safety, to avoid MITM error
    ssh-keygen -f ~/.ssh/known_hosts -R "192.168.10.10"
    ssh-keygen -f ~/.ssh/known_hosts -R "192.168.10.20"
    
    #We get the ssh key
    cp ./ubuntu-web-server/.vagrant/machines/default/virtualbox/private_key ./ansible/host_vars/.ssh/id_rsa_app
    cp ./ubuntu-db-server/.vagrant/machines/default/virtualbox/private_key ./ansible/host_vars/.ssh/id_rsa_db
    
    # Ansible deployment
    cd ansible && ansible-playbook deploy.yml -i ./host_vars/hosts.yml --diff -v

