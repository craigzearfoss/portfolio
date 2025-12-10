## Install AWS CLI on EC2 Ubuntu Instance
```
sudo apt install -y unzip curl

url "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"

unzip awscliv2.zip

sudo ./aws/install

aws --version
```

Disable the firewall. (This flushes the IP table rules for all ports.)
    sudo iptables -F

Restart the SSL service
    sudo systemctl restart sshd

To verify that port 22 is in a listening state,
    sudo netstat -tnlp | grep :22


    if [[ $( cat /etc/hosts.[a,d]* | grep -vE '^#' | awk 'NF' | wc -l) -ne 0 ]];\
then sudo sed -i 'li sshd2 sshd : ALL: allow' /etc/hosts.allow; fiep -vE '^#' | awkk 'NF' | wc =-1) -ne 0 ]];\
cat '/etc/hosts.[a,d]*' : No such file or directoryhosts.allow; fi
