## Allocate AWS Elastic IP Address
- [ ] Navigate to the Amazon EC2 console.
- [ ] In the left menu, under "Network & Security," choose "Elastic IPs".
- [ ] Click on the orange "Allocate Elastic IP address" button in the bottom right.
  - **Allocate Elastic IP address**
      - **Public IPv4 address pool**
          - Select Amazon's pool of IPv4 addresses.
      - **Network border group**
          - Select the desired network border group.
  - Click on the "Allocate" button in the bottom right.

## Associate the Elastic IP Address with an EC2 Instance
- [ ] In the EC2 console, select the Elastic IP address from the list.
- [ ] Choose "Actions", then "Associate Elastic IP address".
  - **Associate Elastic IP address**
    - **Resource type**
      - Select "Instance".
    - **Instance**
      - Select the EC2 instance.
    - **Private IP address**
      - Choose the private IP address of the instance's primary network interface.
        - This is optional if the instance is currently associated with another Elastic IP, you can choose "Allow the Elastic IP address to be reassociated.
    - Click on the orange "Associate" button in the bottom right.
    
