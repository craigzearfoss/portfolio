## Create an AWS Security Groups

- [ ] Navigate to the EC2 dashboard.
- [ ] Click on "Security Groups" under "Network & Security" in the left menu.
- [ ] CLick the orange "Create security group" button in the top right of the page.
  - **Basic details**
    - **Security group name**
      - Enter a name for the security group. You cannot edit the name after creation.
    - **Description**
      - Enter a description if you want to.
    - **VPC**
      - Select the VPC that you created.
  - **Inbound rules**
    - Add rules for "HTTP", "HTTPS", and "SSH".
      - For each of them select "Anywhere-IPv4" for **Source**.
  - **Outbound rules**
    - Select "All traffic". This is the default for outbound traffic.
  - Click on the orange "Create" button in the bottom right.
  - In the inbound rules table at the bottom of the page, enter names for each of the rules.
