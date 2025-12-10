## Create AWS Security Groups

- [ ] Navigate to the EC2 dashboard.
- [ ] Click on "Security Groups" under "Network & Security" in the left menu.
- [ ] Click the orange "Create security group" button in the top right of the page.

  - You'll need to create **Inbound Rules**. 
  - Make your names meaning full.
  - Below is a list of security groups you might want to create for **Inbound Rules**.

| Security group name             | Description                    | Inbound rule type | Outbound Rule source    |
|:--------------------------------|:-------------------------------|:------------------|:------------------------|                     
| allow-ssh-sg                    | Allows SSH access to developer | SSH               | Anywhere-IPv4 0.0.0.0/0 | 
| allow-public-internet-access-sg | Allows public internet access  | HTTP              | Anywhere-IPv4 0.0.0.0/0 | 
| ...                             | ...                            | HTTPS             | Anywhere-IPv4 0.0.0.0/0 | 

- [ ] Click on the orange "Create" button in the bottom right.
- [ ] In the inbound rules table at the bottom of the page, enter names for each of the rules.
