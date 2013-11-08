SamVersioning
=============

This Module provides Features to keep versions of your DB-Entries. Using different Terminology, whenever you insert or
update a Row from your DB-Tables, a copy of this very Row is saved into a separate Table. That is, if you configure this
Module to to so ;)

[![Build Status](https://travis-ci.org/manuakasam/SamVersioning.png?branch=master)](https://travis-ci.org/manuakasam/SamVersioning)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/manuakasam/SamVersioning/badges/quality-score.png?s=9a587ec84774561be74f546e2e122d13ec5b7538)](https://scrutinizer-ci.com/g/manuakasam/SamVersioning/)

Modules Workflow
================

The Workflow of this Module is very simple. Whenever an Event is triggered that you specify in this Modules config, the
Entity will be serialized and copied into a dedicated db-table.

```
Example\Entity\Row1 - saved to DB
  -> serialize Row1
    -> insert to versioning table (ID: 1)
Example\Entity\Row1 - editted by someone
  -> serialize Row1
    -> insert to versioning table (ID: 2 - no update!)
```

Requirements
============

This Module is designed to work out of the Box with Doctrine 2 (```DoctrineORMModule```) and Zend Framework 2. While the
ultimate goal will be to implement the same Features for ```Zend\Db```, too, currently this is not supported.

Installation
============

The easiest way to install this module is through the use of Composer:

```
composer.phar require manuakasam/sam-versioning dev-master
```

After that you should update your Database, this can either be done via doctrine

```
doctrine orm:validate-schema               // Everything OK? Next:
doctrine orm:schema-tool:update --dump-sql // Only updating what you're expecting? Next:
doctrine orm:schema-tool:update --force    // And we're good to go
```
or by using the ```/data/schema.sql```-file.

All that's left is to add this Module to the loaded Modules within your ```application.config.php``` in the usual way.

```
return array(
    'modules' => array(
        'Application',
        'DoctrineModule',
        'DoctrineORMModule',
        'SamVersioning'         // Load order isn't realy important tho
    ),
```

Configuration
=============

The configuration is just as simple as the installation. Copy ```/SamVersioning/config/sam-versioning.globa.php.dist```
to your ```/config/autoload``` directory, remove the ```.dist``` extension and modify it's contents to your needs. The
```versionify``` array expects you to attack key=>value pairs of ClassName => EventName. That way SamVersioning will be
able to listen to those Events. An example could be:

```
return array(
    'sam_versioning' => array(
        'versionify' => array(
            'My\Namespaced\Service'    => 'eventname.additem.post',
            'My\Namespaced\Service'    => 'eventname.edititem.post',
            'Other\Namespaced\Service' => 'objecteditted',
        )
    )
);
```

Events? What Events?
====================

In the best scenario you already have your services set up in a way that they provide events that you can easily hook
into. Often times however this is not the case, but changing your Services to provide events is nothing more than two
lines of code. See the following example:

```
namespace MyNS\Services;
class SomeService {
    public function saveEntity($entity) {
        $this->dbMapper->save($entity);
    }
}
```

Like this, SamVersioning can do nothing to keep track of the Version of ```$entity```, so let's modify the code to allow
us to keep track of it. Be sure to attach the Entity to your event as parameter with the name ```object```

```
namespace MyNS\Services;
class SomeService {
    public function saveEntity($entity) {
        $this->dbMapper->save($entity);

        $eventManager = new EventManager('MyNS\Services\SomeService');
                                                          // notice this array and the object key
        $eventManager->trigger('save-entity.post', $this, array('object' => $entity));
    }
}
```

And that's it, a configuration for this Service to be folllowed would be this:


```
return array(
    'sam_versioning' => array(
        'versionify' => array(
            'MyNS\Services\SomeService' => 'save-entity.post'
        )
    )
);
```

Todo
====

- Learn how to Unit Test
- Implement Unit Tests
- Provide ViewHelpers to gain easy access to earlier versions
- Provide a RollBack-Feature for earlier versions
- Provide the same features for Zend\Db, too
- Let me know about your Ideas!