# IPv6-in-IPv4 Tunnel 

Author: sskaje ([http://sskaje.me/](http://sskaje.me/))

You can set up your own tunnelbroker.net!


More to read: ([http://sskaje.me/2016/01/be-your-own-tunnelbroker-net-iproute2/](http://sskaje.me/2016/01/be-your-own-tunnelbroker-net-iproute2/))

## Commands
### Add
Create a new tunnel, tunnel_id=1, remote ip 211.100.11.11

```
./bin/6to4 add 1 211.100.11.11
```

### Update
Change remote ip to 211.100.11.12 for tunnel_id=1 

```
./bin/6to4 update 1 211.100.11.12
```

### Delete
Delete tunnel tunnel_id=1

```
./bin/6to4 del 1
```


## Config

Config file locates at **etc/config.ini**

*Case: You have 2400:1234:1234:1200::/56 routed to your VPS, eth0 is your internet network device.*

### IPV6_NETWORK
IPv6 network , must be ending with '::'

*Case: 2400:1234:1234:1200::*

### IPV6_CIDR

IPV6 CIDR, must be a multiple of 8, accepted CIDR: 8,16,24,32,40,48,56,64,72,80,88,96.

If your IPV6_CIDR is smaller than /64, assigned blocks are /64; if smaller than /48, /48 is used.

If IPV6_CIDR is greater than /64, assigned blocks are /(IPV6_CIDR + 16 [ + 8 ]), e.g.: 64->80, 72->96, 80->96

*Case: 56*


### INTERFACE
Bind tunnel to device INTERFACE

*Case: eth0*

### LINK_MTU
MTU, default to 1480



## Settings for http API

### Add following to /etc/sudoers

```
php-user ALL=(ALL) NOPASSWD: /path/to/v6/bin/6to4
```

### Add following to nginx vhost 

```
rewrite ^/v6/(.+)$ /v6/cgi/$1 break;
location ~ ^/v6 {
    auth_basic "Username: tunnel id; Password: Secret.";
    auth_basic_user_file $document_root/v6/etc/htpasswd;

    fastcgi_split_path_info ^(.+\.php)(/.+)$;

    fastcgi_pass unix:/var/run/php5-fpm.sock;
    fastcgi_index index.php;
    include fastcgi.conf;
}

```

### Add user for tunnel id 0
```
htpasswd etc/htpasswd 0
```

## Client Settings

### Clients configuration on Debian
```
auto ss-ipv6
iface ss-ipv6 inet6 v4tunnel
        address 'Client IPv6 Address'
        netmask 80
        gateway 'Server IPv6 Address'
        endpoint 'Server IPv4 Address'
        local 0.0.0.0
        ttl 255

```
### Update EndPoint IP


```
curl --silent --user 'TUNNEL_ID:PASSWORD' http://your.v6.api.domain/v6/update.php
```
You can also add this to your **crontab** or somewhere like **/etc/network/if-up.d/**


## EOF


