The class is created for demonstrating purpose and ethical hacking.

### Use it for your own responsibility.

### How to protect yourself against brute force attack at application level?

- using strong password and well designed password policy
- using authentication delay between failed attempt
- lock out IP address with multiple failed logins
- allow login from certain IP address
- answer secret question after three or more failed login
- using two factor authentication methods

### Password policy example

- set minimum password length
- set password age
- enforce password history, don't reuse old passwords
- set password complexity requirements
- admin should be reset password every x days
- set password audit
- email notifications, remind users when it's time to change the password before it expires


### Web Server level protection

#### NGINX configuration

- Limiting the rate of requests, see: limit_req_zone

- Limiting the number of connections, see: limit_conn_zone

- Closing slow connections, see: client_body_timeout, client_header_timeout

- Using black or whitelisting of ip addresses

- Blocking some suspicous requests using User-Agent, Referer headers

- Limiting the connections to the backend, see: max_conns parameters

#### Apache configuration

- see: Mod_Security
- see: Mod_Evasive

#### Consider moving to cloud environment and using providers base protections or other third party solution