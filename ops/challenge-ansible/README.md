# This is my version of the ops ansible challenge

## To create and run the virtual machines, you have to run in a shell in ops/challenge-ansible directory
    ./init.sh

### I had issues on virtualbox to make unattended installation directly frombash with vboxmanage, so I decided to use vagrant to make it possible

```
.
├── ansible
│   ├── ansible.cfg
│   ├── deploy.yml
│   ├── group_vars
│   │   ├── mysql.yml
│   │   └── wordpress.yml
│   ├── host_vars
│   │   └── hosts.yml
│   ├── playbook
│   │   ├── mysql
│   │   │   ├── install.yml
│   │   │   └── scripts
│   │   │       └── newDb.sql
│   │   └── wordpress
│   │       └── install.yml
│   └── templates
│       └── wordpress
│           └── wordpress.conf
├── init.sh
├── README.md
├── ubuntu-db-server
│   ├── ubuntu-bionic-18.04-cloudimg-console.log
│   └── Vagrantfile
├── ubuntu.iso
└── ubuntu-web-server
    ├── ubuntu-bionic-18.04-cloudimg-console.log
    └── Vagrantfile

```


