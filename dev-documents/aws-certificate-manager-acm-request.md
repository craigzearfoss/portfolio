## Request an SSL Certificate with AWS Certificate Manager (ACM)
- [ ] Navigate to the AWS Certificate Manager (ACM)
- **Certificate type**
    - Select "Request a public certificate".
    - Click on the orange "Next" button in the bottom right.
  - **Domain names**
    - Enter the domain name and add subdomains.
  - **Allow export**
    - Select "Disable export".
  - **Validation method**
    - Select "DNS validation - recommended".
  - **Key algorithm**
    - Select "RSA 2048".
  - It will say "Pending validation". They'll need to be verified for approval. To prove ownership:
    - Navigate to the Route 53 dashboard and select "Hosted zones" from the left menu.
    - Click on the domain you are applying the SSL certificate to.
    - Click the orange "Create record" on the  right side of the page.
    - In another browser window open the AWS Certificate Manager (ACM) dashboard and click on "List certificates" from the left menu.
      - Click on the domain.
      - For each of the CNAMEs listed copy the CNAME name and CNAME value into the **Quick create record** page you have open in the other browser window.
        - You can click on the "Add another record" button so you can submit them all with one click.
        - Make sure you select "C" for all the record types.
        - When you add a CNAME don't include the .youdomain.com part because that is automatically appended to the record.
        - When you are done entering all the CNAMEs click the orange "Create records" button in the bottom right.
        - Now you'll have to wait for them to be approved before continuing.

## Create a Hosted Zone for the Domain and Add CNAME records

## Apply an SSL Certificate to an EC2 Instance




### References
[https://repost.aws/knowledge-center/acm-certificate-pending-validation](https://repost.aws/knowledge-center/acm-certificate-pending-validation)
