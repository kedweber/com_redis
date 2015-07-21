# Redis Component for the Content Construction Kit \(CCK\) \(com_redis\)

## Description

[Redis](http://redis.io), or *Remote Dictionary Service*, is an Open Source advanced key-value cache and store. It is a data structure server \(as the keys can contain strings, hases lists, sets, sorted sets, bitmaps and huperloglogs \), networked, in-memory, and stores keys with optional durability. The development of Redis has been sponsored by [Pivotal Software](http://pivotal.io) since May 2013, while previously sponsored by [VMware](http://www.vmware.com).


This Redis Component for the, Content Construction Kit \(CCK\), produced by [Moyo Web Architects](http://moyoweb.nl),  is a Joomla / Nooku component that uses redis to handle otherwise resource intensive complex data objects. Most of [Moyo Web Architects'](http://moyoweb.nl) work has been sponsored by the [CTA](http://cta.int), which is a joint institution operating under the framework of the Cotonou Agreement between the ACP Group of States \(Africa, the Caribbean and the Pacific\) and the EU Member States \(European Union\). CTA is funded by the European Union.

## Requirements

* Joomla 3.X . Untested in Joomla 2.5.
* Koowa 0.9 or 1.0 (as yet, Koowa 2 is not supported)
* PHP 5.3.10 or better
* Composer
* [Redis](http://redis.io/download) Installed
    current stable version [3.0](http://download.redis.io/releases/redis-3.0.3.tar.gz)

## Installation

The Antirez repository for [Redis](https://github.com/antirez/redis) is another option and is avaiable [here](https://github.com/antirez/redis).

As yet, copy or symlink manually after checking out.

## Installation \(after improvement\)

### Composer

Installation is done through composer. In your `composer.json` file, you should add the following lines to the repositories
section:

from the local repository;

```json
{
    "name": "moyo/com_redis",
    "type": "vcs",
    "url": "https://github.com/kedweber/com_redis.git"
}
```

and from the official repository;

```json
{
    "name": "moyo/com_redis",
    "type": "vcs",
    "url": "https://github.com/moyoweb/com_redis.git"
}
```

The require section should contain the following line:

```json
    "moyo/com_redis": "1.0.*",
```

Afterwards, one just needs to run the command `composer update` from the root of your Joomla project. This will 
effectively create a `composer.lock` file which will contain the collected dependencies and the hash codes for 
each latest release \(depending on the require section's format\) for each particular repo. Should installations 
problems occur due to a bad ordering of the dependencies, one may need to go into the lock file and manualy change 
the order of the components. Running `composer update` again will again cause a reordering of the lock file, beware of 
this factor when running an update. Thereafter, you can run the command `composer install`. 

If you have not setup an alias to use the command composer, then you will need to replace the word composer in the previous commands with the 
commands with `php composer.phar` followed by the desired action \(eg. update or install\).

### jsymlinker

Another option is to run the [jsymlink script](https://github.com/derjoachim/moyo-git-tools) in the root folder, available via the original Moyo developer, Joachim van de Haterd's repository, under 
the [Moyo Git Tools](https://github.com/derjoachim/moyo-git-tools).

#### License jsymlinker

The joomlatools/installer plugin is free and open-source software licensed under the [GPLv3 license](https://github.com/derjoachim/joomla-composer/blob/develop/gplv3-license).


