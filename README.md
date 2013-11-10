Remote method invocation on Application Servers.
================================================

EASC (Enterprise Application Server Connectivity)
-------------------------------------------------
This is a binary protocol which is used for client/server communication.
The serialization format used is similar to that of PHP. The wire-format
is designed for speed - the protocol overhead is commonly between one
and three milliseconds.

ESDL (Enterprise Service Description Language)
----------------------------------------------
Built on-top of the EASC protocol, this optional part provides functionality
to remotely discover deployed functionality and to introspect its workings
reflectively. This way, a programmer implementing a client for a business
object needs only know the server's and the beans' name and can generate
stub classes from that.

Server implementations
----------------------
The following application servers support EASC:

* JBoss (TM) Application Server - via MBean
* Peking - Application server written in the XP Framework

The EASC protocol is also used for communication with the Lucene
Daemon to perform searches using the Apache Lucene search engine.

Client implementations
----------------------
There following client implementations of the EASC protocol exist:

* XP Framework - remote package (this here)
* Perl - EASC::Remote
* Microsoft (TM) .NET Framework - Net.XpFramework.EASC

Example
-------
To use a bean deployed on an application server we use code along the
lines of the following:

```php
$facade= Remote::forName('xp://middleware.example.com:6448')
  ->lookup('corporate/customer/Facade/1.0')
  ->create()
;
$customer= $facade->getByCustomerNumber(new Long(1861822));
```

See also
--------
http://news.planet-xp.net/category/11/EASC/
