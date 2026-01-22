https://www.google.com/search?q=installing+webmin+on+aws+ubuntu+server&sca_esv=bf060a61777141fd&rlz=1C1RXQR_enUS1006US1006&cs=1&biw=1230&bih=794&aic=0&sxsrf=ANbL-n4uz27itS3H_dxd8SQfQx8RcaAbOw%3A1768693791330&ei=HyBsaaXxE9mGwbkPysjrkQM&oq=installing+webmin+on+aws+ubutn&gs_lp=Egxnd3Mtd2l6LXNlcnAiHmluc3RhbGxpbmcgd2VibWluIG9uIGF3cyB1YnV0bioCCAMyBxAhGKABGAoyBxAhGKABGAoyBxAhGKABGAoyBxAhGKABGAoyBxAhGKABGAoyBRAhGJ8FMgUQIRifBTIFECEYnwUyBRAhGJ8FSOVfUABYu0dwAXgBkAEAmAFyoAGuE6oBBDMwLjG4AQPIAQD4AQGYAiCgAqAUwgIEECMYJ8ICChAjGIAEGCcYigXCAgcQIxjwBRgnwgIKEAAYgAQYQxiKBcICCxAAGIAEGJECGIoFwgIFEAAYgATCAgoQABiABBgUGIcCwgIGEAAYFhgewgIIEAAYFhgKGB7CAgUQIRigAcICBRAhGKsCmAMAkgcEMzAuMqAH3u8BsgcEMjkuMrgHnRTCBwYwLjI5LjPIB0mACAA&sclient=gws-wiz-serp

sudo apt update && sudo apt upgrade -y
sudo curl -o webmin-setup-repo.sh https://raw.githubusercontent.com/webmin/webmin/master/webmin-setup-repo.sh
sudo sh webmin-setup-repo.sh
sudo apt install webmin --install-recommends -y


Prerequisites
An AWS EC2 instance running Ubuntu Server (e.g., Ubuntu 22.04 or 24.04).
The instance's public IP address.
SSH access to the instance (using a .pem key pair).
Step 1: Connect to your AWS instance and update packages
Connect to your Ubuntu instance via SSH using a terminal.
bash
ssh -i your-key.pem ubuntu@your-server-ip
Once logged in, update your system's package lists and installed packages:
bash
sudo apt update && sudo apt upgrade -y
Step 2: Add the Webmin repository
The simplest method to add the Webmin repository is using their automated script:
Download the setup script:
bash
curl -o webmin-setup-repo.sh https://raw.githubusercontent.com/webmin/webmin/master/webmin-setup-repo.sh
Run the script to automatically configure the repository and GPG keys:
bash
sudo sh webmin-setup-repo.sh
This script handles adding the repository line to /etc/apt/sources.list and importing the GPG key to verify package authenticity.
Step 3: Install Webmin
After the repository is set up, you can install Webmin using apt:
bash
sudo apt install webmin --install-recommends -y
The installation is complete when you see the message "Webmin install complete." in the output.
Step 4: Configure the AWS Security Group
By default, AWS security groups block incoming traffic to most ports. Webmin runs on TCP port 10000 by default, so you must open this port in your AWS Management Console:
Navigate to the EC2 Dashboard in the AWS Console.
Select your instance.
In the Security tab, click on the associated Security Group ID.
Under the Inbound rules tab, click Edit inbound rules.
Add a new rule:
Type: Custom TCP
Port range: 10000
Source: Custom or Anywhere (0.0.0.0/0) (for testing purposes, restrict to your IP for better security)
Click Save rules.
Step 5: Access Webmin
You can now access the Webmin interface from your web browser. Note that Webmin uses HTTPS by default and a self-signed certificate, so you will see a security warning which you can safely bypass for the first login.
Navigate to: https://<your-server-ip>:10000
Log in with your Ubuntu system username and password (e.g., ubuntu user or root if you set a password for it). 
